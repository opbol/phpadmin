<?php

namespace App\Events\Department;

use App\Department;

abstract class DepartmentEvent {
	/**
	 * @var Department
	 */
	protected $department;

	public function __construct(Department $department) {
		$this->department = $department;
	}

	/**
	 * @return Department
	 */
	public function getDepartment() {
		return $this->department;
	}
}