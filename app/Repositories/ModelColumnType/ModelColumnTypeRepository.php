<?php

namespace App\Repositories\ModelColumnType;

use App\ModelColumnType;

interface ModelColumnTypeRepository {

	public function all();

	public function find($id);

	/**
	 * Create new model column type.
	 *
	 * @param array $data
	 * @return ModelColumnType
	 */
	public function create(array $data);

	/**
	 * Update specified model column type.
	 *
	 * @param $id ModelColumnType Id
	 * @param array $data
	 * @return ModelColumnType
	 */
	public function update($id, array $data);

	/**
	 * Remove model column type from repository.
	 *
	 * @param $id ModelColumnType Id
	 * @return bool
	 */
	public function delete($id);

}