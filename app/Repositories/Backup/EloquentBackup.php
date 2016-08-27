<?php

namespace App\Repositories\Backup;

use App\Events\Backup\Deleted;
use App\Backup;
use App\Support\Authorization\CacheFlusherTrait;
use DB;

class EloquentBackup implements BackupRepository {
	use CacheFlusherTrait;

	/**
	 * {@inheritdoc}
	 */
	public function all() {
		return Backup::all();
	}

	/**
	 * {@inheritdoc}
	 */
	public function find($id) {
		return Backup::find($id);
	}

    /**
     * {@inheritdoc}
     */
    public function findByDisk($disk) {
        return Backup::query()->where('disk', $disk)->get();
    }

	/**
	 * {@inheritdoc}
	 */
	public function create(array $data) {
		$backup = Backup::create($data);

		return $backup;
	}

	/**
	 * {@inheritdoc}
	 */
	public function update($id, array $data) {
        $backup = $this->find($id);

        $backup->update($data);

		return $backup;
	}

	/**
	 * {@inheritdoc}
	 */
	public function delete($id) {
		$backup = $this->find($id);
        event(new Deleted($backup));
        return $backup->delete();
	}
}