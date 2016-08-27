<?php

namespace App\Repositories\Permission;

use App\Events\Permission\Created;
use App\Events\Permission\Deleted;
use App\Events\Permission\Updated;
use App\Permission;
use Cache;

class EloquentPermission implements PermissionRepository {
	/**
	 * {@inheritdoc}
	 */
	public function all() {
		return Permission::all();
	}

	/**
	 * {@inheritdoc}
	 */
	public function find($id) {
		return Permission::find($id);
	}

	/**
	 * {@inheritdoc}
	 */
	public function create(array $data) {
		$permission = Permission::create($data);

		event(new Created($permission));

		return $permission;
	}

	/**
	 * {@inheritdoc}
	 */
	public function update($id, array $data) {
		$permission = $this->find($id);

		$permission->update($data);

		Cache::flush();

		event(new Updated($permission));

		return $permission;
	}

	/**
	 * {@inheritdoc}
	 */
	public function delete($id) {
		$permission = $this->find($id);

		event(new Deleted($permission));

		$status = $permission->delete();

		Cache::flush();

		return $status;
	}
}