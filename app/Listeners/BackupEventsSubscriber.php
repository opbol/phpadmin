<?php

namespace App\Listeners;

use App\Activity;
use App\Events\Backup\Created;
use App\Events\Backup\Deleted;
use App\Repositories\Backup\BackupRepository;
use App\Services\Logging\UserActivity\Logger;
use Auth;
use Spatie\Backup\Events\CleanupWasSuccessful;
use Storage;
use Spatie\Backup\Events\BackupHasFailed;
use Spatie\Backup\Events\BackupWasSuccessful;

class BackupEventsSubscriber {
	/**
	 * @var UserActivityLogger
	 */
	private $logger;

    private $backups;

	public function __construct(BackupRepository $backups, Logger $logger) {
	    $this->backups = $backups;
		$this->logger = $logger;
	}

	public function onCreate(Created $event) {
		$message = trans(
			$event->getBackup()->createdBy == 0 ? 'log.new_auto_backup' : 'log.new_manual_backup',
			['name' => $event->getBackup()->name]
		);

		$this->logger->log($message);
	}

	public function onDelete(Deleted $event) {
        $backup = $event->getBackup();
        $fs = Storage::disk($backup->disk);

        if ($fs->exists($backup->file) ) {
            $fs->delete($backup->file);
        }

		$message = trans(
			'log.deleted_backup',
			['name' => $backup->name]
		);

		$this->logger->log($message);
	}

	public function onBackupSuccess(BackupWasSuccessful $event) {
        $this->createBackup($event->backupDestination, 'OK');
    }

    public function onBackupFailed(BackupHasFailed $event) {
        $this->createBackup($event->backupDestination, $event->exception->getMessage());
        $this->logger->log($event->exception->getMessage());
    }

    public function onBackupCleanup(CleanupWasSuccessful $event) {
        $backupDestination = $event->backupDestination;
        if (! empty($backupDestination)) {
            $backups = $this->backups->findByDisk($backupDestination->getDiskName());
            $fs = Storage::disk($backupDestination->getDiskName());
            foreach ($backups as $backup) {
                if (! $fs->exists($backup->file)) {
                    $this->backups->delete($backup->id);
                }
            }
        }
    }

    private function createBackup($backupDestination, $message) {
        $newestBackup = empty($backupDestination) ? null : $backupDestination->getNewestBackup();
        if (! empty($backupDestination) && !empty($newestBackup)) {
            $currentUser = Auth::user();
            $this->backups->create([
                'name' => basename($backupDestination->getBackupName()),
                'disk' => $backupDestination->getDiskName(),
                'file' => $newestBackup->path(),
                'message' => $message,
                'create_by' => empty($currentUser->id) ? 0 : $currentUser->id,
                'size' => $newestBackup->size(),
                'md5' => md5(Storage::disk($backupDestination->getDiskName())->get($newestBackup->path())),
            ]);
        }
    }

	/**
	 * Register the listeners for the subscriber.
	 *
	 * @param  \Illuminate\Events\Dispatcher  $events
	 */
	public function subscribe($events) {
		$class = 'App\Listeners\BackupEventsSubscriber';

		$events->listen(Created::class, "{$class}@onCreate");
		$events->listen(Deleted::class, "{$class}@onDelete");
        $events->listen(BackupWasSuccessful::class, "{$class}@onBackupSuccess");
        $events->listen(BackupHasFailed::class, "{$class}@onBackupFailed");
        $events->listen(CleanupWasSuccessful::class, "{$class}@onBackupCleanup");
	}
}
