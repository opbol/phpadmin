@extends('dashboard.layouts.master')

@section('page-title', $user->present()->nameOrEmail)

@section('page-header')
    <h1>
        {{ $user->present()->nameOrEmail }}
        <small>@lang('app.user_details')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> @lang('app.home')</a></li>
        <li><a href="{{ route('user.list') }}">@lang('app.users')</a></li>
        <li class="active">{{ $user->present()->nameOrEmail }}</li>
      </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4 col-md-5">
        <div class="box box-primary" id="edit-user-panel">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('app.details')</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-default btn-sm" data-toggle="tooltip" title="@lang('app.edit_user')">
                        <i class="fa fa-pencil"></i>
                    </a>
                </div>
            </div>
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="{{ $user->present()->avatar }}" alt="User profile picture">
                <h3 class="profile-username text-center">{{ $user->present()->name }}</h3>
                @if ($socialNetworks)
                <div class="text-center">
                    @if ($socialNetworks->facebook)
                        <a href="{{ $socialNetworks->facebook }}" class="btn btn-social-icon btn-facebook">
                            <i class="fa fa-facebook"></i>
                        </a>
                    @endif

                    @if ($socialNetworks->twitter)
                        <a href="{{ $socialNetworks->twitter }}" class="btn btn-social-icon btn-twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
                    @endif

                    @if ($socialNetworks->google_plus)
                        <a href="{{ $socialNetworks->google_plus }}" class="btn btn-social-icon btn-google">
                            <i class="fa fa-google-plus"></i>
                        </a>
                    @endif

                    @if ($socialNetworks->linked_in)
                        <a href="{{ $socialNetworks->linked_in }}" class="btn btn-social-icon btn-linkedin">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    @endif

                    @if ($socialNetworks->skype)
                        <a href="{{ $socialNetworks->skype }}" class="btn btn btn-social-icon btn-skype">
                            <i class="fa fa-skype"></i>
                        </a>
                    @endif

                    @if ($socialNetworks->dribbble)
                        <a href="{{ $socialNetworks->dribbble }}" class="btn btn-social-icon btn-dribbble">
                            <i class="fa fa-dribbble"></i>
                        </a>
                    @endif
                </div>
                @endif
                <p></p>
                <table class="table table-hover table-details">
                    <thead>
                        <tr>
                            <th colspan="3">@lang('app.contact_informations')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>@lang('app.email')</td>
                            <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                        </tr>
                        @if ($user->phone)
                            <tr>
                                <td>@lang('app.phone')</td>
                                <td><a href="telto:{{ $user->phone }}">{{ $user->phone }}</a></td>
                            </tr>
                        @endif

                        @if ($socialNetworks && $socialNetworks->skype)
                            <tr>
                                <td>Skype</td>
                                <td>{{ $socialNetworks->skype }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th colspan="3">@lang('app.additional_informations')</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>@lang('app.birth')</td>
                        <td>{{ $user->present()->birthday }}</td>
                    </tr>
                    <tr>
                        <td>@lang('app.address')</td>
                        <td>{{ $user->present()->fullAddress }}</td>
                    </tr>
                    <tr>
                        <td>@lang('app.last_logged_in')</td>
                        <td>{{ $user->present()->lastLogin }}</td>
                    </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-md-7">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('app.latest_activity')</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('activity.user', $user->id) }}" class="edit"
                       data-toggle="tooltip" data-placement="top" title="@lang('app.complete_activity_log')">
                        @lang('app.view_all')
                    </a>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>@lang('app.action')</th>
                            <th style="width: 150px">@lang('app.date')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userActivities as $activity)
                            <tr>
                                <td>{{ $activity->description }}</td>
                                <td>{{ $activity->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop