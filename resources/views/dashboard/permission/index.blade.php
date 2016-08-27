@extends('dashboard.layouts.master')

@section('page-title', trans('app.permissions'))

@section('page-header')
    <h1>
        @lang('app.permissions')
        <small>@lang('app.available_system_permissions')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> @lang('app.home')</a></li>
        <li class="active">@lang('app.permissions')</li>
      </ol>
@endsection

@section('content')

@include('partials.messages')

<div class="box">
    <div class="box-header">
        <h3 class="box-title">@lang('app.available_system_permissions')</h3>
        <div class="box-tools">
            <a href="{{ route('dashboard.permission.create') }}" class="btn btn-sm btn-success">
                <i class="fa fa-plus"></i>
                @lang('app.add_permission')
            </a>
        </div>
    </div>
    {!! Form::open(['route' => 'dashboard.permission.save']) !!}
    <div class="box-body table-responsive no-padding" id="users-table-wrapper">
        <table class="table table-hover">
            <thead>
                <th>@lang('app.permission_name')</th>
                @foreach ($roles as $role)
                <th class="text-center">{{ $role->display_name }}</th>
                @endforeach
                <th class="text-center">@lang('app.action')</th>
            </thead>
            <tbody>
                @if (count($permissions))
                @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->display_name ?: $permission->name }}</td>
                    @foreach ($roles as $role)
                    <td class="text-center">
                        <div class="checkbox">
                            {!! Form::checkbox("roles[{$role->id}][]", $permission->id, $role->hasPermission($permission->name)) !!}
                            <label class="no-content"></label>
                        </div>
                    </td>
                    @endforeach
                    <td class="text-center">
                        <a href="{{ route('dashboard.permission.edit', $permission->id) }}" class="btn btn-primary btn-circle"
                            title="@lang('app.edit_permission')" data-toggle="tooltip" data-placement="top">
                            <i class="glyphicon glyphicon-edit"></i>
                        </a>
                        @if ($permission->removable)
                        <a href="{{ route('dashboard.permission.destroy', $permission->id) }}" class="btn btn-danger btn-circle"
                            title="@lang('app.delete_permission')"
                            data-toggle="tooltip"
                            data-placement="top"
                            data-method="DELETE"
                            data-confirm-title="@lang('app.please_confirm')"
                            data-confirm-text="@lang('app.are_you_sure_delete_permission')"
                            data-confirm-action="@lang('app.yes_delete_it')">
                            <i class="glyphicon glyphicon-trash"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="4"><em>@lang('app.no_records_found')</em></td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix">
        @if (count($permissions))
        <div class="row">
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">@lang('app.save_permissions')</button>
            </div>
        </div>
        @endif
    </div>
    {!! Form::close() !!}
</div>

@section('after-scripts-end')
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_flat',
          radioClass: 'iradio_flat',
          increaseArea: '20%' // optional
        });
      });
    </script>
@stop

@stop
