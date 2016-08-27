@extends('frontend.layouts.auth')

@section('content')

        <p class="login-box-msg">@lang('app.hey') {{ $account->getName() }},</p>

        <div class="callout callout-warning">
            <strong>@lang('app.one_more_thing')...</strong>
            @lang('app.twitter_does_not_provide_email')
        </div>

        <form role="form" action="<?=url('auth/twitter/email')?>" method="POST" id="email-form" autocomplete="off">
            <input type="hidden" value="<?=csrf_token()?>" name="_token">

            <div class="form-group has-feedback">
                <input type="email" name="email" id="email" class="form-control" placeholder="@lang('app.your_email')">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-custom btn-lg btn-block">@lang('app.log_me_in')</button>
            </div>
        </form>

@stop

@section('after-scripts-end')
    {!! JsValidator::formRequest('App\Http\Requests\Auth\Social\SaveEmailRequest', '#email-form') !!}
@stop