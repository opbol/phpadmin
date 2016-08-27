<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('page-title') | {{ settings('app_name') }}</title>

    @yield('before-styles-end')
        {!! Html::style(elixir('css/dashboard.css')) !!}
    @yield('after-styles-end')
</head>
<body class="hold-transition login-page">
    @include('partials/messages')
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ url('assets/img/logo.png') }}" alt="{{ settings('app_name') }}">
        </div>

        <div class="login-box-body">
        @yield('content')
        </div>
    </div>

    @yield('before-scripts-end')
    {!! Html::script(elixir('js/dashboard.js')) !!}
    {!! Html::script('assets/legacy/js/jquery.placeholder.min.js') !!}
    {!! Html::script('vendor/jsvalidation/js/jsvalidation.js') !!}
    @yield('after-scripts-end')
</body>
</html>
