@extends('dashboard.layouts.master')

@section('page-title', trans('app.add_user'))

@section('page-header')
    <h1>
        @lang('app.create_new_user')
        <small>@lang('app.user_details')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> @lang('app.home')</a></li>
        <li><a href="{{ route('user.list') }}">@lang('app.users')</a></li>
        <li class="active">@lang('app.create')</li>
      </ol>
@endsection

@section('content')

@include('partials.messages')

{!! Form::open(['route' => 'user.store', 'files' => true, 'id' => 'user-form']) !!}
    <div class="row">
        <div class="col-md-8">
            @include('dashboard.user.partials.details', ['edit' => false, 'profile' => false])
        </div>
        <div class="col-md-4">
            @include('dashboard.user.partials.auth', ['edit' => false])
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i>
                @lang('app.create_user')
            </button>
        </div>
    </div>
{!! Form::close() !!}

@stop

@section('after-scripts-end')
    {!! Html::script('assets/js/profile.js') !!}
    {!! JsValidator::formRequest('App\Http\Requests\User\CreateUserRequest', '#user-form') !!}
@stop