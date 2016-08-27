@extends('frontend.layouts.master')

@section('page-title', trans('app.home'))

@section('page-breadcrumbs')
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('frontend.index') }}">@lang('app.home')</a>
        </li>
        <li class="active">@lang('app.home')</li>
    </ul>

    <div class="nav-search" id="nav-search">
    </div>
@endsection

@section('page-header')
    <h1>
        @lang('app.welcome') <?=Auth::user()->realname ?: Auth::user()->username?>!
    </h1>
@endsection

@section('content')

    <div class="row">

    </div>

@stop

@section('after-scripts-end')

@stop