<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('page-title') | {{ settings('app_name') }}</title>

        <!-- Meta -->
        <meta name="description" content="@yield('meta_description', 'Default Description')">
        <meta name="author" content="@yield('meta_author', 'Xian YiTing Tech.')">
        @yield('meta')

        <!-- Styles -->
        @yield('before-styles-end')
        {!! Html::style(elixir('css/dashboard.css')) !!}
        @yield('after-styles-end')

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        {!! Html::script('assets/js/html5shiv.js') !!}
        {!! Html::script('assets/js/respond.min.js') !!}
        <![endif]-->
    </head>
    <body class="skin-{{ settings('theme_skin') }} sidebar-mini">
    <div class="wrapper">
        @include('dashboard.includes.header')
        @include('dashboard.includes.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('page-header')
            </section>

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        @include('dashboard.includes.footer')
    </div><!-- ./wrapper -->

    <!-- JavaScripts -->
    @yield('before-scripts-end')
    {!! Html::script(elixir('js/dashboard.js')) !!}
    {!! Html::script('vendor/jsvalidation/js/jsvalidation.js') !!}
    @yield('after-scripts-end')
    </body>
</html>