@extends('dashboard.layouts.master')

@section('page-title', trans('app.roles'))

@section('page-header')
    <h1>
        {{ $edit ? $role->name : trans('app.create_new_role') }}
        <small>{{ $edit ? trans('app.edit_role_details') : trans('app.role_details') }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> @lang('app.home')</a></li>
        <li><a href="{{ route('role.index') }}">@lang('app.roles')</a></li>
        <li class="active">{{ $edit ? trans('app.edit') : trans('app.create') }}</li>
      </ol>
@endsection

@section('content')

@include('partials.messages')

@if ($edit)
    {!! Form::open(['route' => ['role.update', $role->id], 'method' => 'PUT', 'id' => 'role-form']) !!}
@else
    {!! Form::open(['route' => 'role.store', 'id' => 'role-form']) !!}
@endif

<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.role_details_big')</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="name">@lang('app.role_name')</label>
                    <input type="text" class="form-control" id="name"
                           @if ($edit && !$role->removable) readonly @endif
                           name="name" placeholder="@lang('app.role_name')" value="{{ $edit ? $role->name : old('name') }}">
                </div>
                <div class="form-group">
                    <label for="display_name">@lang('app.role_display_name')</label>
                    <input type="text" class="form-control" id="display_name"
                           name="display_name" placeholder="@lang('app.role_display_name')" value="{{ $edit ? $role->display_name : old('display_name') }}">
                </div>
                <div class="form-group">
                    <label for="description">@lang('app.description')</label>
                    <textarea name="description" id="description" class="form-control">{{ $edit ? $role->description : old('description') }}</textarea>
                </div>
                </div>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary btn-block">
            <i class="fa fa-save"></i>
            {{ $edit ? trans('app.update_role') : trans('app.create_role') }}
        </button>
    </div>
</div>

{!! Form::close() !!}

@stop

@section('scripts')
    @if ($edit)
        {!! JsValidator::formRequest('App\Http\Requests\Role\UpdateRoleRequest', '#role-form') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\Role\CreateRoleRequest', '#role-form') !!}
    @endif
@stop