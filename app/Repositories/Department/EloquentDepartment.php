<?php

namespace App\Repositories\Department;

use App\Department;
use App\Events\Department\Created;
use App\Events\Department\Deleted;
use App\Events\Department\Updated;
use App\Support\Authorization\CacheFlusherTrait;
use Auth;
use DB;

class EloquentDepartment implements DepartmentRepository {
	use CacheFlusherTrait;

	/**
	 * {@inheritdoc}
	 */
	public function all() {
		return Department::all();
	}
    
    /**
     * {@inheritdoc}
     */
    public function getDepartmentOptions($only = null, $except = null) {
        /** @var \Kalnoy\Nestedset\QueryBuilder $query */
        $query = Department::query()->withDepth();

        if ($except) {
            $query->whereNotDescendantOf($except)->where('id', '<>', $except->id);
        }

        if ($only) {
            $query->whereDescendantOf($only)->orWhere('id', $only->id);
        }

        return traverse_tree_nodes($query->orderBy('sort', 'asc')->withDepth()->get()->toTree(), [ '' => trans('app.department_root') ], true);
    }

	/**
	 * {@inheritdoc}
	 */
	public function find($id) {
		return Department::find($id);
	}

	/**
	 * {@inheritdoc}
	 */
	public function create(array $data) {
		$department = Department::create($data);

		event(new Created($department));

		return $department;
	}

	/**
	 * {@inheritdoc}
	 */
	public function update($id, array $data) {
		$department = $this->find($id);

        $department->update($data);

        Department::fixTree();

		event(new Updated($department));

		return $department;
	}

	/**
	 * {@inheritdoc}
	 */
	public function delete($id) {
		$department = $this->find($id);

        event(new Deleted($department));

        return $department->delete();
    }

	/**
	 * {@inheritdoc}
	 */
	public function makeFilterDepartments($id = null) {
		$user = Auth::user();
        $department = null;
        $departments = [];
        $departmentIds = [];

        $department = $user->department;
        if ($department) {
            $departments = traverse_tree_nodes($department->descendants()->get()->toTree(), [ $department->id => $department->name ]);
            $departmentIds = array_keys($departments);
        }

        if ($id) {
            $dept = $this->find($id);
            if ($dept && ($user->hasRole('Admin') || ! empty($departments[$id])) ) {
                $department = $dept;
                $departmentIds = $department->descendants()->lists('id')->all();
                $departmentIds[] = $department->getKey();
            }
        }

        return [$departments, $departmentIds, $department];
	}
}