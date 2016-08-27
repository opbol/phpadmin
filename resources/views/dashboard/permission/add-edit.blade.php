@extends('dashboard.layouts.master')

@section('page-title', trans('app.permissions'))

@section('page-header')
    <h1>
        {{ $edit ? $permission->name : trans('app.create_new_permission') }}
        <small>{{ $edit ? trans('app.edit_permission_details') : trans('app.permission_details_sm') }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> @lang('app.home')</a></li>
        <li><a href="{{ route('dashboard.permission.index') }}">@lang('app.permissions')</a></li>
        <li class="active">{{ $edit ? trans('app.edit') : trans('app.create') }}</li>
      </ol>
@endsection

@section('content')


@include('partials.messages')

@if ($edit)
    {!! Form::open(['route' => ['dashboard.permission.update', $permission->id], 'method' => 'PUT', 'id' => 'permission-form']) !!}
@else
    {!! Form::open(['route' => 'dashboard.permission.store', 'id' => 'permission-form']) !!}
@endif

<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.permission_details')</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="name">@lang('app.permission_name')</label>
                    <input type="text" class="form-control" id="name"
                           @if ($edit && !$permission->removable) readonly @endif
                           name="name" placeholder="@lang('app.permission_name')" value="{{ $edit ? $permission->name : old('name') }}">
                </div>
                <div class="form-group">
                    <label for="display_name">@lang('app.permission_display_name')</label>
                    <input type="text" class="form-control" id="display_name"
                           name="display_name" placeholder="@lang('app.permission_display_name')" value="{{ $edit ? $permission->display_name : old('display_name') }}">
                </div>
                <div class="form-group">
                    <label for="description">@lang('app.description')</label>
                    <textarea name="description" id="description" class="form-control">{{ $edit ? $permission->description : old('description') }}</textarea>
                </div>
                </div>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i>
            {{ $edit ? trans('app.update_permission') : trans('app.create_permission') }}
        </button>
    </div>
</div>

@stop

@section('fter-scripts-end')
    @if ($edit)
        {!! JsValidator::formRequest('App\Http\Requests\Permission\UpdatePermissionRequest', '#permission-form') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\Permission\CreatePermissionRequest', '#permission-form') !!}
    @endif
@stop