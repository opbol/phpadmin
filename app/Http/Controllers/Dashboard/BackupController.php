<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Backup\BackupRepository;
use App\Backup;
use Auth;
use Artisan;
use Cache;
use Event;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Response;
use Storage;
use Symfony\Component\Process\Process;

/**
 * Class BackupController
 * @package App\Http\Controllers
 */
class BackupController extends Controller {
	/**
	 * @var BackupRepository
	 */
	private $backups;

	/**
	 * BackupController constructor.
	 * @param BackupRepository $backups
	 */
	public function __construct(BackupRepository $backups) {
		$this->middleware('permission:backups.manage');
		$this->backups = $backups;
	}

	/**
	 * Display page with all available Backups.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
		$backups = $this->backups->all();

		return view('dashboard.backup.index', compact('backups'));
	}

	/**
	 * Display form for manual backup.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function manual() {
	    $error = null;

        Event::listen('Spatie\Backup\Events\BackupHasFailed', function($event) use (&$error) {
            $error = $event->exception->getMessage();
        });

        Artisan::queue('backup:run');
        // Artisan::queue('backup:mysql', ['--login' => Auth::user()->id, '--gzip' => null]);

        if ($error != null) {
            return redirect()->route('backup.index')
                ->withErrors($error);
        }

        return redirect()->route('backup.index')
            ->withSuccess(trans('app.backup_manual_success'));
	}

	public function recover(Backup $backup) {
	    $fs = Storage::disk($backup->disk);
        if ( ! $fs->exists($backup->file) ) {
            return redirect()->back()
                ->withErrors(trans('app.backup_file_not_found'));
        }

        if ( ! $this->recoverDB($backup->file) ) {
            return redirect()->back()
                ->withErrors(trans('app.recover_failed'));
        }

        return redirect()->back()
            ->withSuccess(trans('app.recover_success'));
	}

	public function recoverFile() {
        $uploadFile = Input::file('file');

        $filename = $uploadFile->getRealPath();

        $code = $this->recoverDB($filename, strtolower($uploadFile->getClientOriginalExtension()) == 'gz') ? 0 : 1;

        if (file_exists($filename)) {
            unlink($filename);
        }

        return Response::json(['code' => $code]);
    }

    public function download(Backup $backup) {
        $fs = Storage::disk($backup->disk);

        if ( ! $fs->exists($backup->file) ) {
            return redirect()->route('backup.index')
                ->withErrors(trans('app.file_not_found'));
        }

        $file = $fs->get($backup->file);

        return Response::make($file, 200)
            ->header('Content-Type', 'application/zip')
            ->header('Content-Disposition', 'attachment; filename="'.basename($backup->file).'"');
    }

	/**
	 * Remove specified backup from system.
	 *
	 * @param Backup $backup
	 * @return mixed
	 */
	public function delete(Backup $backup) {
		try {
			$this->backups->delete($backup->id);

			Cache::flush();

			return redirect()->route('backup.index')
				->withSuccess(trans('app.backup_deleted'));
		} catch (\Exception $e) {
			return redirect()->route('backup.index')
				->withErrors($e->getMessage());
		}
	}

	private function recoverDB($file, $gz = false) {
        $dbHost = Config::get('database.connections.mysql.host');
        $dbUser = Config::get('database.connections.mysql.username');
        $dbPass = Config::get('database.connections.mysql.password');
        $dbName = Config::get('database.connections.mysql.database');

        // Build the command to be run
        $cmd = sprintf('mysql --host=%s --user=%s --password=%s %s',
            escapeshellarg($dbHost),
            escapeshellarg($dbUser),
            escapeshellarg($dbPass),
            escapeshellarg($dbName)
        );

        if ($gz || preg_match('/\.gz$/i', $file)) {
            $cmd = sprintf('gzip -dc %s | ', $file) . $cmd;
        } else {
            $cmd .= sprintf(' < %s', $file);
        }

        $process = new Process($cmd);
        $process->run();

        return $process->isSuccessful();
    }
}