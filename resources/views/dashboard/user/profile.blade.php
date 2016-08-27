@extends('dashboard.layouts.master')

@section('page-title', trans('app.my_profile'))

@section('page-header')
    <h1>
        {{ $user->present()->nameOrEmail }}
        <small>@lang('app.edit_profile_details')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> @lang('app.home')</a></li>
        <li class="active">@lang('app.my_profile')</li>
     </ol>
@endsection

@section('content')

@include('partials.messages')

<div class="nav-tabs-custom">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#details" aria-controls="details" role="tab" data-toggle="tab">
                <i class="glyphicon glyphicon-th"></i>
                @lang('app.details')
            </a>
        </li>
        @if (false)
        <li role="presentation">
            <a href="#social-networks" aria-controls="social-networks" role="tab" data-toggle="tab">
                <i class="fa fa-youtube"></i>
                @lang('app.social_networks')
            </a>
        </li>
        @endif
        <li role="presentation">
            <a href="#auth" aria-controls="auth" role="tab" data-toggle="tab">
                <i class="fa fa-lock"></i>
                @lang('app.authentication')
            </a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="details">
            <div class="row">
                <div class="col-lg-8 col-md-7">
                    {!! Form::open(['route' => 'profile.update.details', 'method' => 'PUT', 'id' => 'details-form']) !!}
                        @include('dashboard.user.partials.details', ['profile' => true])
                    {!! Form::close() !!}
                </div>
                <div class="col-lg-4 col-md-5">
                    {!! Form::open(['route' => 'profile.update.avatar', 'files' => true, 'id' => 'avatar-form']) !!}
                        @include('dashboard.user.partials.avatar', ['updateUrl' => route('profile.update.avatar-external')])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @if (false)
        <div role="tabpanel" class="tab-pane" id="social-networks">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(['route' => 'profile.update.social-networks', 'method' => 'PUT', 'id' => 'socials-form']) !!}
                        @include('dashboard.user.partials.social-networks')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @endif
        <div role="tabpanel" class="tab-pane" id="auth">
            <div class="row">
                <div class="col-md-8">
                    {!! Form::open(['route' => 'profile.update.login-details', 'method' => 'PUT', 'id' => 'socials-form']) !!}
                        @include('dashboard.user.partials.auth')
                    {!! Form::close() !!}
                </div>
            </div>
            @if (false)
            <div class="row">
                <div class="col-md-8">
                    @if (settings('2fa.enabled'))
                        <?php $route = Authy::isEnabled($user) ? 'disable' : 'enable';?>

                        {!! Form::open(['route' => "profile.two-factor.{$route}", 'id' => 'two-factor-form']) !!}
                            @include('dashboard.user.partials.two-factor')
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@stop

@section('after-scripts-end')
    {!! Html::script('assets/js/btn.js') !!}
    {!! Html::script('assets/js/profile.js') !!}
    {!! JsValidator::formRequest('App\Http\Requests\User\UpdateDetailsRequest', '#details-form') !!}
    {!! JsValidator::formRequest('App\Http\Requests\User\UpdateProfileLoginDetailsRequest', '#login-details-form') !!}

    @if (config('auth.2fa.enabled'))
        {!! JsValidator::formRequest('App\Http\Requests\User\EnableTwoFactorRequest', '#two-factor-form') !!}
    @endif
@stop