<?php

namespace App\Repositories\Department;

use App\Department;

interface DepartmentRepository {
	/**
	 * Get all system departments.
	 *
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function all();

	/**
	 * Create $key => $value array for all available departments.
     * @param null $only
     * @param null $except
	 * @return mixed
	 */
    public function getDepartmentOptions($only = null, $except = null);

	/**
	 * Find department by id.
	 *
	 * @param $id Department Id
	 * @return Department|null
	 */
	public function find($id);

	/**
	 * Create department.
	 *
	 * @param array $data
	 * @return Department
	 */
	public function create(array $data);

	/**
	 * Update specified department.
	 *
	 * @param $id Department Id
	 * @param array $data
	 * @return Department
	 */
	public function update($id, array $data);

	/**
	 * Remove department from repository.
	 *
	 * @param $id Department Id
	 * @return bool
	 */
	public function delete($id);

	public function makeFilterDepartments($id = null);
}