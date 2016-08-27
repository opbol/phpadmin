@extends('frontend.layouts.auth')

@section('page-title', trans('app.login'))

@section('content')
    <p class="login-box-msg">@lang('app.login_welcome')</p>
    <form role="form" action="<?=url('login')?>" method="POST" id="login-form" autocomplete="off">
        <input type="hidden" value="<?=csrf_token()?>" name="_token">

        @if (Input::has('to'))
            <input type="hidden" value="{{ Input::get('to') }}" name="to">
        @endif

        <div class="form-group has-feedback">
            <input type="email" name="username" id="username" class="form-control" placeholder="@lang('app.username_or_phone_or_email')">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
            <input type="password" name="password" id="password" class="form-control" placeholder="@lang('app.password')">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="row">
            <div class="col-xs-8">
                @if (settings('remember_me'))
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="remember" id="remember"> @lang('app.remember_me')
                    </label>
                </div>
                @endif
            </div>
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat" id="btn-login">@lang('app.log_in')</button>
            </div>
        </div>

        @include('frontend.auth.social.buttons')

        @if (settings('forgot_password'))
            <a href="<?=url('password/remind')?>">@lang('app.i_forgot_my_password')</a>
        @endif

        <br>

        @if (settings('reg_enabled'))
        <a href="<?=url("register")?>" class="text-center">@lang('app.dont_have_an_account')</a>
        @endif

    </form>
@stop

@section('after-scripts-end')
    {!! Html::script('assets/js/login.js') !!}
    {!! JsValidator::formRequest('App\Http\Requests\Auth\LoginRequest', '#login-form') !!}
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
@stop