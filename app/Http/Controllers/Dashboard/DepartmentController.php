<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\CreateDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;
use App\Repositories\Department\DepartmentRepository;
use App\Department;
use Cache;
use Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class DepartmentController
 * @package App\Http\Controllers
 */
class DepartmentController extends Controller {
	/**
	 * @var DepartmentRepository
	 */
	private $departments;

	/**
	 * DepartmentController constructor.
	 * @param DepartmentRepository $departments
	 */
	public function __construct(DepartmentRepository $departments) {
		$this->middleware('permission:departments.manage');
		$this->departments = $departments;
	}

	/**
	 * Display page with all available departments.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
        $edit = false;

		$departments = $this->departments->getDepartmentOptions();

		return view('dashboard.department.index', compact('edit', 'departments'));
	}

    /**
     * Display form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function form() {
        $id = (int)Request::input('id');
        $selected = (int)Request::input('selected');
        $department = $id > 0 ? Department::find($id) : null;
        $edit = $department ? true : false;
        $departments = $this->departments->getDepartmentOptions(null, $department);
        $data = compact('edit', 'departments');
        if ($edit) {
            $data['department'] = $department;
        } else {
            $data['selected'] = $selected;
        }
        return view('dashboard.department.partials.form', $data);
    }

    /**
     * Store newly created department to database.
     *
     * @param CreateDepartmentRequest $request
     * @return mixed
     */
    public function store(CreateDepartmentRequest $request) {
        $this->departments->create($request->all());

        return redirect()->route('department.index')
            ->withSuccess(trans('app.department_created'));
    }

    /**
     * Update specified department with provided data.
     *
     * @param Department $department
     * @param UpdateDepartmentRequest $request
     * @return mixed
     */
    public function update(Department $department, UpdateDepartmentRequest $request) {
        $this->departments->update($department->id, $request->all());

        return redirect()->route('department.index')
            ->withSuccess(trans('app.department_updated'));
    }

	/**
	 * Remove specified department from system.
	 *
	 * @param Department $department
	 * @return mixed
	 */
	public function delete(Department $department) {
		$this->departments->delete($department->id);

		Cache::flush();

		return redirect()->route('department.index')
			->withSuccess(trans('app.department_deleted'));
	}

    public function nodeMove() {
        $id = (int)Request::input('id');
        $parentId = (int)Request::input('parent_id');
        $sort = (int)Request::input('sort');
        $department = $this->departments->find($id);
        if ($department) {
            $this->departments->update($department->id, [ 'parent_id' => $parentId, 'sort' => $sort ]);
        }
        return Response::json([ 'code' => 0 ]);
    }

    public function jsTree($except = null) {
        /** @var \Kalnoy\Nestedset\QueryBuilder $query */
        $query = Department::select('*', 'name as text');

        if ($except) {
            $query->whereNotDescendantOf($except)->where('id', '<>', $except->id);
        }

        $tree = $query->orderBy('sort', 'asc')->get()->toTree();

        return response()->json($tree);
    }
}