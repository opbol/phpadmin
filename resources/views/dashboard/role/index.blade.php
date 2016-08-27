@extends('dashboard.layouts.master')

@section('page-title', trans('app.roles'))

@section('page-header')
    <h1>
        @lang('app.roles')
        <small>@lang('app.available_system_roles')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> @lang('app.home')</a></li>
        <li class="active">@lang('app.roles')</li>
      </ol>
@endsection

@section('content')

    @include('partials.messages')

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">@lang('app.available_system_roles')</h3>
            <div class="box-tools">
                <a href="{{ route('role.create') }}" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i>
                    @lang('app.add_role')
                </a>
            </div>
        </div>
        <div class="box-body table-responsive no-padding" id="users-table-wrapper">
            <table class="table table-hover">
                <thead>
                    <th>@lang('app.role_name')</th>
                    <th>@lang('app.role_display_name')</th>
                    <th>@lang('app.users_with_this_role')</th>
                    <th class="text-center">@lang('app.action')</th>
                </thead>
                <tbody>
                    @if (count($roles))
                    @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->display_name }}</td>
                        <td>{{ $role->users_count }}</td>
                        <td class="text-center">
                            <a href="{{ route('role.edit', $role->id) }}" class="btn btn-primary btn-circle"
                                title="@lang('app.edit_role')" data-toggle="tooltip" data-placement="top">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                            @if ($role->removable)
                            <a href="{{ route('role.delete', $role->id) }}" class="btn btn-danger btn-circle"
                                title="@lang('app.delete_role')"
                                data-toggle="tooltip"
                                data-placement="top"
                                data-method="DELETE"
                                data-confirm-title="@lang('app.please_confirm')"
                                data-confirm-text="@lang('app.are_you_sure_delete_role')"
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
    </div>

@stop
