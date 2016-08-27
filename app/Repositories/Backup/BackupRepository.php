<?php

namespace App\Repositories\Backup;

use App\Backup;

interface BackupRepository {
	/**
	 * Get all system backups.
	 *
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function all();

	/**
	 * Find backup by id.
	 *
	 * @param $id Backup Id
	 * @return Backup|null
	 */
	public function find($id);

    /**
     * Find backup by id.
     *
     * @param $disk string
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByDisk($disk);

	/**
	 * Create backup.
	 *
	 * @param array $data
	 * @return Backup
	 */
	public function create(array $data);

	/**
	 * Update specified backup.
	 *
	 * @param $id Backup Id
	 * @param array $data
	 * @return Backup
	 */
	public function update($id, array $data);

	/**
	 * Remove backup from repository.
	 *
	 * @param $id Backup Id
	 * @return bool
	 */
	public function delete($id);
}