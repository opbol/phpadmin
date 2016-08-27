@extends('dashboard.layouts.master')
@section('page-title', 'Users')
@section('page-header')
<h1>
@lang('app.users')
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> @lang('app.home')</a></li>
    <li class="active">@lang('app.users')</li>
</ol>
@endsection
@section('content')
@include('partials.messages')

<div class="row tab-search">
    <div class="col-md-2 col-xs-2">
        <a href="{{ route('user.create') }}" class="btn btn-success" id="add-user">
            <i class="glyphicon glyphicon-plus"></i>
            @lang('app.add_user')
        </a>
    </div>
    <div class="col-md-3 col-xs-1"></div>
    <form method="GET" action="" accept-charset="UTF-8" id="users-form">
        <div class="col-md-2 col-xs-2">
            {!! Form::select('department', $departments, Input::get('department') ?: $department->id, [ 'id' => 'department', 'class' => 'form-control' ]) !!}
        </div>
        <div class="col-md-2 col-xs-3">
            {!! Form::select('status', $statuses, Input::get('status'), ['id' => 'status', 'class' => 'form-control']) !!}
        </div>
        <div class="col-md-3 col-xs-4">
            <div class="input-group custom-search-form">
                <input type="text" class="form-control" name="search" value="{{ Input::get('search') }}" placeholder="@lang('app.search_for_users')">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" id="search-users-btn">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                    @if (Input::has('search') && Input::get('search') != '')
                        <a href="{{ route('user.list') }}" class="btn btn-danger" type="button" >
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    @endif
                </span>
            </div>
        </div>
    </form>
</div>


<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('app.list_of_registered_users')</h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <div id="users-table-wrapper">
                    <table class="table table-hover table-striped">
                        <tbody>
                            <tr>
                                <th>@lang('app.username')</th>
                                <th>@lang('app.realname')</th>
                                <th>@lang('app.email')</th>
                                <th>@lang('app.department')</th>
                                <th>@lang('app.role')</th>
                                <th>@lang('app.registration_date')</th>
                                <th>@lang('app.status')</th>
                                <th class="text-center">@lang('app.action')</th>
                            </tr>
                            @if (count($users))
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->username ?: trans('app.n_a') }}</td>
                                <td>{{ $user->realname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->department->name }}</td>
                                <td>
                                    @if ($user->roles()->count() > 0)
                                        @foreach ($user->roles as $role)
                                            {!! $role->display_name !!}<br/>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <span class="label label-{{ $user->present()->labelClass }}">{{ trans("app.{$user->status}") }}</span>
                                </td>
                                <td class="text-center">
                                    @if (config('session.driver') == 'database')
                                    <a href="{{ route('user.sessions', $user->id) }}" class="btn btn-info btn-circle"
                                        title="@lang('app.user_sessions')" data-toggle="tooltip" data-placement="top">
                                        <i class="fa fa-list"></i>
                                    </a>
                                    @endif
                                    <a href="{{ route('user.show', $user->id) }}" class="btn btn-success btn-circle"
                                        title="@lang('app.view_user')" data-toggle="tooltip" data-placement="top">
                                        <i class="glyphicon glyphicon-eye-open"></i>
                                    </a>
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-circle edit" title="@lang('app.edit_user')"
                                        data-toggle="tooltip" data-placement="top">
                                        <i class="glyphicon glyphicon-edit"></i>
                                    </a>
                                    <a href="{{ route('user.delete', $user->id) }}" class="btn btn-danger btn-circle" title="@lang('app.delete_user')"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        data-method="DELETE"
                                        data-confirm-title="@lang('app.please_confirm')"
                                        data-confirm-text="@lang('app.are_you_sure_delete_user')"
                                        data-confirm-action="@lang('app.yes_delete_him')">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6"><em>@lang('app.no_records_found')</em></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    {!! $users->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('after-scripts-end')
<script>
$("#status").change(function () {
$("#users-form").submit();
});
</script>
@stop