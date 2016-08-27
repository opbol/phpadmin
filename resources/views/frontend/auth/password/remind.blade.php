@extends('frontend.layouts.auth')

@section('page-title', trans('app.reset_password'))

@section('content')

    <p class="login-box-msg">@lang('app.forgot_your_password')</p>

    <form role="form" action="<?=url('password/remind')?>" method="POST" id="remind-password-form" autocomplete="off">
        <input type="hidden" value="<?=csrf_token()?>" name="_token">

        <div class="form-group has-feedback">
            <input type="email" name="email" id="email" class="form-control" placeholder="@lang('app.email')">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
            <button type="submit" class="btn btn-primary btn-block btn-flat">@lang('app.reset_password')</button>

        </div>
    </form>

@stop

@section('after-scripts-end')
    {!! JsValidator::formRequest('App\Http\Requests\Auth\PasswordRemindRequest', '#remind-password-form') !!}
@stop