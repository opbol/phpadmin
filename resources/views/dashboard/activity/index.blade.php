@extends('dashboard.layouts.master')

@section('page-title', trans('app.activity_log'))

@section('page-header')
    <h1>
        {{ isset($user) ? $user->present()->nameOrEmail : trans('app.activity_log') }}
        <small>{{ isset($user) ? trans('app.activity_log_sm') : trans('app.activity_log_all_users') }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> @lang('app.home')</a></li>
        @if (isset($user) && isset($adminView))
            <li><a href="{{ route('activity.index') }}">@lang('app.activity_log')</a></li>
            <li class="active">{{ $user->present()->nameOrEmail }}</li>
        @else
            <li class="active">@lang('app.activity_log')</li>
        @endif
    </ol>
@endsection

@section('content')



<div class="box">
    <div class="box-header">
        <h3 class="box-title">
            {{ isset($user) ? trans('app.activity_log_sm') : trans('app.activity_log_all_users') }}
        </h3>
        <div class="box-tools">
            <form method="GET" action="" accept-charset="UTF-8" id="users-form">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="search" class="form-control pull-right" placeholder="@lang('app.search_for_action')" value="{{ Input::get('search') }}">
                    <div class="input-group-btn">
                        <button type="submit" id="search-activities-btn" class="btn btn-default"><i class="fa fa-search"></i></button>
                        @if (Input::has('search') && Input::get('search') != '')
                        <a href="{{ route('activity.index') }}" class="btn btn-danger" type="button">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <thead>
                @if (isset($adminView))
                <th>@lang('app.user')</th>
                @endif
                <th>@lang('app.ip_address')</th>
                <th>@lang('app.message')</th>
                <th>@lang('app.log_time')</th>
                <th class="text-center">@lang('app.more_info')</th>
            </thead>
            <tbody>
                @foreach ($activities as $activity)
                <tr>
                    @if (isset($adminView))
                    <td>
                        @if (isset($user))
                        {{ $activity->user->present()->nameOrEmail }}
                        @else
                        <a href="{{ route('activity.user', $activity->user_id) }}"
                            data-toggle="tooltip" title="@lang('app.view_activity_log')">
                            {{ $activity->user->present()->nameOrEmail }}
                        </a>
                        @endif
                    </td>
                    @endif
                    <td>{{ $activity->ip_address }}</td>
                    <td>{{ $activity->description }}</td>
                    <td>{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                    <td class="text-center">
                        <a tabindex="0" role="button" class="btn btn-primary btn-circle"
                            data-trigger="focus"
                            data-placement="left"
                            data-toggle="popover"
                            title="@lang('app.user_agent')"
                            data-content="{{ $activity->user_agent }}">
                            <i class="fa fa-info"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {!! $activities->render() !!}
    </div>
</div>

@stop