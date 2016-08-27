@extends('dashboard.layouts.master')

@section('page-title', trans('app.general_settings'))

@section('page-header')
    <h1>
        @lang('app.general_settings')
        <small>@lang('app.manage_general_system_settings')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> @lang('app.home')</a></li>
        <li><a href="javascript:;">@lang('app.settings')</a></li>
        <li class="active">@lang('app.general')</li>
      </ol>
@endsection

@section('content')

@include('partials.messages')

{!! Form::open(['route' => 'settings.general.update', 'id' => 'general-settings-form']) !!}

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.general_app_settings')</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="name">@lang('app.app_name')</label>
                    <input type="text" class="form-control" id="app_name"
                           name="app_name" value="{{ settings('app_name') }}">
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-refresh"></i>
                    @lang('app.update_settings')
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.skin')</div>
            <div class="panel-body">
                <div class="form-group">
                <label>@lang('app.change_theme_skin')</label>
                <select class="form-control select2" style="width: 100%;" id="theme_skin" name="theme_skin">
                  <option selected="selected">{{ settings('theme_skin') }}</option>
                  <option>black</option>
                  <option>black-light</option>
                  <option>blue</option>
                  <option>blue-light</option>
                  <option>green</option>
                  <option>green-light</option>
                  <option>purple</option>
                  <option>purple-light</option>
                  <option>red</option>
                  <option>red-light</option>
                  <option>yellow</option>
                  <option>yellow-light</option>
                </select>
              </div>

              @include('dashboard.settings.partials.skins')

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-refresh"></i>
                    @lang('app.update_settings')
                </button>
            </div>
        </div>
    </div>
</div>

@stop

@section('after-scripts-end')
    <script>
        $(function () {
        //Initialize Select2
        $(".select2").select2();
    });
</script>

@stop