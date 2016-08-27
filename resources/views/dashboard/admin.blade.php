@extends('dashboard.layouts.master')

@section('page-title', trans('app.dashboard'))

@section('page-header')
    <h1>
        @lang('app.welcome') {{ Auth::user()->present()->realname }}!
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> @lang('app.home')</a></li>
        <li class="active">@lang('app.dashboard')</li>
    </ol>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $stats['new'] }}</h3>
                <p>@lang('app.new_users_this_month')</p>
            </div>
            <div class="icon">
                <i class="fa fa-user-plus"></i>
            </div>
            <a href="{{ route('user.list') }}" class="small-box-footer">
                @lang('app.view_all_users') <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $stats['total'] }}</h3>
                <p>@lang('app.total_users')</p>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a href="{{ route('user.list') }}" class="small-box-footer">
                @lang('app.view_details') <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $stats['banned'] }}</h3>
                <p>@lang('app.banned_users')</p>
            </div>
            <div class="icon">
                <i class="fa fa-user-times"></i>
            </div>
            <a href="{{ route('user.list', ['status' => \App\Support\Enum\UserStatus::BANNED]) }}" class="small-box-footer">
                @lang('app.view_details') <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ $stats['unconfirmed'] }}</h3>
                <p>@lang('app.unconfirmed_users')</p>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            <a href="{{ route('user.list', ['status' => \App\Support\Enum\UserStatus::UNCONFIRMED]) }}" class="small-box-footer">
                @lang('app.view_details') <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('app.registration_history')</h3>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="myChart" style="height:281px"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('app.latest_registrations')</h3>
                <div class="box-tools pull-right">
                    <span class="label label-danger">@lang('app.new_members')</span>
                </div>
            </div>
            <div class="box-body no-padding">
            @if (count($latestRegistrations))
                <ul class="users-list clearfix">
                @foreach ($latestRegistrations as $user)
                    <li>
                        <img src="{{ $user->present()->avatar }}" alt="User Image">
                        <a class="users-list-name" href="{{ route('user.show', $user->id) }}">{{ $user->present()->nameOrEmail }}</a>
                        <span class="users-list-date">{{ $user->created_at->diffForHumans() }}</span>
                    </li>
                @endforeach
                </ul>
            </div>
            @else
                <p class="text-muted">@lang('app.no_records_found')</p>
            @endif
            <div class="box-footer text-center">
                <a href="{{ route('user.list') }}" class="uppercase">@lang('app.view_all_users')</a>
            </div>
        </div>
    </div>
</div>

@stop

@section('after-scripts-end')
    <script>
        var chartItems = {!! json_encode(array_values($usersPerMonth)) !!};
        var chartLabels = {!! json_encode(array_keys($usersPerMonth)) !!};
        var chartTrans = {
            chartLabel: "{{ trans('app.registration_history')  }}",
            itemLabel: "{{ trans('app.new_user_number') }}"
        };
    </script>
    {!! Html::script('assets/js/dashboard-admin.js') !!}
@stop