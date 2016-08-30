<?php

namespace App\Repositories\ModelColumnType;

use App\Events\ModelColumnType\Created;
use App\Events\ModelColumnType\Deleted;
use App\Events\ModelColumnType\Updated;
use App\ModelColumnType;
use App\Support\Authorization\CacheFlusherTrait;
use DB;

class EloquentModelColumnType implements ModelColumnTypeRepository {
	use CacheFlusherTrait;

	/**
	 * {@inheritdoc}
	 */
	public function all() {
		return ModelColumnType::all();
	}

	/**
	 * {@inheritdoc}
	 */
	public function find($id) {
		return ModelColumnType::find($id);
	}

	/**
	 * {@inheritdoc}
	 */
	public function create(array $data) {
        $type = ModelColumnType::create($data);

		event(new Created($type));

		return $type;
	}

	/**
	 * {@inheritdoc}
	 */
	public function update($id, array $data) {
        $type = $this->find($id);

        $type->update($data);

		event(new Updated($type));

		return $type;
	}

	/**
	 * {@inheritdoc}
	 */
	public function delete($id) {
		$type = $this->find($id);

		event(new Deleted($type));

		return $type->delete();
	}

}