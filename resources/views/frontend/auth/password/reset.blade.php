@extends('frontend.layouts.auth')

@section('page-title', trans('app.reset_password'))

@section('content')


    <p class="login-box-msg">@lang('app.reset_your_password')</p>
    <form role="form" action="{{ url('password/reset') }}" method="POST" id="reset-password-form" autocomplete="off">

         {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group has-feedback">
            <input type="email" name="email" id="email" class="form-control" placeholder="@lang('app.your_email')">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
            <input type="password" name="password" id="password" class="form-control" placeholder="@lang('app.new_password')">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>


        <div class="form-group has-feedback">
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="@lang('app.confirm_new_password')">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-custom btn-lg btn-block" id="btn-reset-password">
                @lang('app.update_password')
            </button>
        </div>

    </form>
@stop