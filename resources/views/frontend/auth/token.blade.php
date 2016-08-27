@extends('frontend.layouts.auth')

@section('page-title', trans('app.two_factor_authentication'))

@section('content')


    <p class="login-box-msg">@lang('app.two_factor_authentication')</p>

    <form role="form" action="<?=route('auth.token.validate')?>" method="POST" autocomplete="off">
        <input type="hidden" value="<?=csrf_token()?>" name="_token">

        <div class="form-group has-feedback">
            <input type="text" name="token" id="token" class="form-control" placeholder="@lang('app.authy_2fa_token')">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-custom btn-lg btn-block" id="btn-reset-password">
                @lang('app.validate')
            </button>
        </div>
    </form>

@stop