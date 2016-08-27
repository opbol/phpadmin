<!doctype html>
<html class="no-js" lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title') | {{ settings('app_name') }}</title>

    <!-- Meta -->
    <meta name="description" content="@yield('meta_description', 'Default Description')">
    <meta name="author" content="@yield('meta_author', 'Xian YiTing Tech.')">
@yield('meta')

<!-- Styles -->
@yield('before-styles-end')
{!! Html::style('assets/legacy/css/bootstrap.min.css') !!}
{!! Html::style('assets/legacy/font-awesome/4.2.0/css/font-awesome.min.css') !!}
{!! Html::style('assets/legacy/css/jquery-ui.min.css') !!}
{!! Html::style('assets/legacy/fonts/fonts.googleapis.com.css') !!}
{!! Html::style('assets/legacy/css/ace.min.css') !!}
{!! Html::style('assets/legacy/css/viewer.css') !!}
{!! Html::style('assets/legacy/css/jquery.loading.css') !!}
{!! Html::style('assets/legacy/css/select2.min.css') !!}
{!! Html::style('assets/legacy/css/bootstrap-multiselect.min.css') !!}
{!! Html::style('assets/legacy/css/app.css') !!}
@yield('after-styles-end')

    <!--[if lte IE 9]>
    {!! Html::style('assets/legacy/css/ace-part2.min.css') !!}
    <![endif]-->
    <!--[if lte IE 9]>
    {!! Html::style('assets/legacy/css/ace-ie.min.css') !!}
    <![endif]-->
    {!! Html::script('assets/legacy/js/ace-extra.min.js') !!}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    {!! Html::script('assets/legacy/js/html5shiv.js') !!}
    {!! Html::script('assets/legacy/js/respond.min.js') !!}
    <![endif]-->
</head>
<body class="no-skin">
@include('frontend.includes.legacy.header')
<div class="main-container" id="main-container">
    <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
    </script>
    @include('frontend.includes.legacy.sidebar')
    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs" id="breadcrumbs">
                <script type="text/javascript">
                    try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
                </script>

                @yield('page-breadcrumbs')
            </div>
            <div class="page-content">
                @yield('page-header')
                @include('partials.messages')
                @yield('content')
            </div>
        </div>
    </div>
    @include('frontend.includes.legacy.footer')
</div>
<!-- JavaScripts -->
@yield('before-scripts-end')
<!--[if !IE]> -->
{!! Html::script('assets/legacy/js/jquery.2.1.1.min.js') !!}
<!-- <![endif]-->

<!--[if IE]>
{!! Html::script('assets/legacy/js/jquery.1.11.1.min.js') !!}
<![endif]-->

<!--[if !IE]> -->
<script type="text/javascript">
    window.jQuery || document.write("<script src='assets/legacy/js/jquery.min.js'>"+"<"+"/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='assets/legacy/js/jquery1x.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='assets/legacy/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
{!! Html::script('assets/legacy/js/bootstrap.min.js') !!}

<!-- page specific plugin scripts -->

<!--[if lte IE 9]>
{!! Html::script('assets/legacy/js/excanvas.min.js') !!}
<![endif]-->
{!! Html::script('assets/legacy/js/viewer.js') !!}
{!! Html::script('assets/legacy/js/jquery-ui.min.js') !!}
{!! Html::script('assets/legacy/js/action.handler.js') !!}
<script type="text/javascript">
    $.datepicker.regional["zh-CN"] = { closeText: "关闭", prevText: "&#x3c;上月", nextText: "下月&#x3e;", currentText: "今天", monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"], monthNamesShort: ["一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二"], dayNames: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"], dayNamesShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"], dayNamesMin: ["日", "一", "二", "三", "四", "五", "六"], weekHeader: "周", dateFormat: "yy-mm-dd", firstDay: 1, isRTL: !1, showMonthAfterYear: !0, yearSuffix: "年" };
    $.datepicker.setDefaults($.datepicker.regional["zh-CN"]);
</script>
{!! Html::script('assets/legacy/js/jquery-ui.custom.min.js') !!}
{!! Html::script('assets/legacy/js/jquery.ui.touch-punch.min.js') !!}
{!! Html::script('assets/legacy/js/jquery.placeholder.min.js') !!}
{!! Html::script('assets/legacy/js/jquery.easypiechart.min.js') !!}
{!! Html::script('assets/legacy/js/jquery.sparkline.min.js') !!}
{!! Html::script('assets/legacy/js/jquery.flot.min.js') !!}
{!! Html::script('assets/legacy/js/jquery.flot.pie.min.js') !!}
{!! Html::script('assets/legacy/js/jquery.flot.resize.min.js') !!}
{!! Html::script('assets/legacy/js/bootstrap-multiselect.min.js') !!}

{!! Html::script('assets/legacy/js/jquery.ui.widget.js') !!}
{!! Html::script('assets/legacy/js/jquery.iframe-transport.js') !!}
{!! Html::script('assets/legacy/js/jquery.fileupload.js') !!}

{!! Html::script('assets/legacy/js/jquery.loading.js') !!}
{!! Html::script('assets/legacy/js/select2.min.js') !!}

{!! Html::script('assets/legacy/js/ace-elements.min.js') !!}
{!! Html::script('assets/legacy/js/ace.min.js') !!}

{!! Html::script('assets/legacy/js/app.js') !!}

{!! Html::script('vendor/jsvalidation/js/jsvalidation.js') !!}
@yield('after-scripts-end')
</body>
</html>