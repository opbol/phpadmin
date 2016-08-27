@extends('dashboard.layouts.master')

@section('page-title', trans('app.authentication_settings'))

@section('page-header')
    <h1>
        @lang('app.authentication')
        <small>@lang('app.system_auth_registration_settings')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> @lang('app.home')</a></li>
        <li><a href="javascript:;">@lang('app.settings')</a></li>
        <li class="active">@lang('app.authentication')</li>
      </ol>
@endsection

@section('content')

@include('partials.messages')

<div class="nav-tabs-custom">
<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li role="presentation" class="active">
        <a href="#auth" aria-controls="auth" role="tab" data-toggle="tab">
            <i class="fa fa-lock"></i>
            @lang('app.authentication')
        </a>
    </li>
    <li role="presentation">
        <a href="#registration" aria-controls="registration" role="tab" data-toggle="tab">
            <i class="fa fa-user-plus"></i>
            @lang('app.registration')
        </a>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="auth">
        <div class="row">
            <div class="col-md-6">
                @include('dashboard.settings.partials.auth')
            </div>
            <div class="col-md-6">
                @include('dashboard.settings.partials.throttling')
            </div>
        </div>

        @if (false)
        <div class="row">
            <div class="col-md-6">
                @include('dashboard.settings.partials.two-factor')
            </div>
        </div>
        @endif
    </div>
    <div role="tabpanel" class="tab-pane" id="registration">
        <div class="row">
            <div class="col-md-6">
                @include('dashboard.settings.partials.registration')
            </div>
            <div class="col-md-6">
                @include('dashboard.settings.partials.recaptcha')
            </div>
        </div>
    </div>
</div>
</div>

@stop

@section('after-scripts-end')
    <script>
        $(".switch").bootstrapSwitch({ size: 'small' });
    </script>
@stop