<div class="panel panel-default">
    <div class="panel-heading">@lang('app.department_details')</div>
    <div class="panel-body">
        @if ($edit)
            {!! Form::open(['route' => ['department.update', $department->id], 'method' => 'PUT', 'id' => 'department-form']) !!}
        @else
            {!! Form::open(['route' => 'department.store', 'id' => 'department-form']) !!}
        @endif

        <div class="form-group">
            <label for="name">@lang('app.department_name')</label>
            <input type="text" class="form-control" id="name"
                   name="name" placeholder="@lang('app.department_name')" value="{{ $edit ? $department->name : old('name') }}">
        </div>

        <div class="form-group">
            {!! Form::label('parent_id', trans('app.department_parent')) !!}
            {!! Form::select('parent_id', $departments, $edit ? $department->parent_id : (isset($selected) ? $selected : old('parent_id')), [ 'class' => 'form-control' ]) !!}
        </div>

        <div class="form-group">
            <label for="description">@lang('app.description')</label>
            <textarea name="description" id="description" class="form-control">{{ $edit ? $department->description : old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="sort">@lang('app.sort')</label>
            <input type="text" class="form-control" id="sort"
                   name="sort" placeholder="@lang('app.sort')" value="{{ $edit ? $department->sort : old('sort') }}">
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i>
            {{ $edit ? trans('app.update_department') : trans('app.create_department') }}
        </button>

        {!! Form::close() !!}
    </div>
</div>

@section('scripts')
    @if ($edit)
        {!! JsValidator::formRequest('App\Http\Requests\Department\UpdateDepartmentRequest', '#department-form') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\Department\CreateDepartmentRequest', '#department-form') !!}
    @endif
@stop