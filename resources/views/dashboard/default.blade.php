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
        <a href="{{ route('profile') }}" class="panel-link">
            <div class="panel panel-default dashboard-panel">
                <div class="panel-body">
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <p class="lead">@lang('app.update_profile')</p>
                </div>
            </div>
        </a>
    </div>
    @if (config('session.driver') == 'database')
        <div class="col-lg-3 col-xs-6">
            <a href="{{ route('profile.sessions') }}" class="panel-link">
                <div class="panel panel-default dashboard-panel">
                    <div class="panel-body">
                        <div class="icon">
                            <i class="fa fa-list"></i>
                        </div>
                        <p class="lead">@lang('app.my_sessions')</p>
                    </div>
                </div>
            </a>
        </div>
    @endif
    <div class="col-lg-3 col-xs-6">
        <a href="{{ route('profile.activity') }}" class="panel-link">
            <div class="panel panel-default dashboard-panel">
                <div class="panel-body">
                    <div class="icon">
                        <i class="fa fa-list-alt"></i>
                    </div>
                    <p class="lead">@lang('app.activity_log')</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-xs-6">
        <a href="{{ route('auth.logout') }}" class="panel-link">
            <div class="panel panel-default dashboard-panel">
                <div class="panel-body">
                    <div class="icon">
                        <i class="fa fa-sign-out"></i>
                    </div>
                    <p class="lead">@lang('app.logout')</p>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('app.activity') (@lang('app.last_two_weeks'))</h3>
            </div>

            <div class="box-body">
                <div class="chart">
                    <canvas id="myChart" style="height:400px"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('after-scripts-end')
    <script>
        var labels = {!! json_encode(array_keys($activities)) !!};
        var activities = {!! json_encode(array_values($activities)) !!};
    </script>
    {!! Html::script('assets/js/dashboard-default.js') !!}
@stop