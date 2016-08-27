<?php

namespace App\Events\Backup;

use App\Backup;

abstract class BackupEvent {
	/**
	 * @var Backup
	 */
	protected $backup;

	public function __construct(Backup $backup) {
		$this->backup = $backup;
	}

	/**
	 * @return Backup
	 */
	public function getBackup() {
		return $this->backup;
	}
}