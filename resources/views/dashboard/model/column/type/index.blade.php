@extends('dashboard.layouts.master')

@section('page-title', trans('model.model_column_types'))

@section('page-header')
    <h1>
        @lang('model.column_types')
        <small>@lang('model.available_column_types')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> @lang('app.home')</a></li>
        <li class="active">@lang('model.column_types')</li>
      </ol>
@endsection

@section('content')

    @include('partials.messages')

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">@lang('model.available_column_types')</h3>
            <div class="box-tools">
            </div>
        </div>
        <div class="box-body table-responsive no-padding" id="users-table-wrapper">
            <table class="table table-hover">
                <thead>
                    <th>@lang('model.column_type_name')</th>
                    <th>@lang('model.column_type_command')</th>
                    <th>@lang('model.column_type_args')</th>
                    <th>@lang('model.column_type_nullable')</th>
                    <th>@lang('model.column_type_status')</th>
                    <th>@lang('model.column_type_description')</th>
                </thead>
                <tbody>
                    @if (count($types))
                    @foreach ($types as $type)
                    <tr>
                        <td>{{ $type->name }}</td>
                        <td>{{ $type->command }}</td>
                        <td>{{ count($type->args) }}</td>
                        <td>{{ trans('app.' . ($type->nullable ? 'yes' : 'no')) }}</td>
                        <td>{{ trans('app.' . ($type->status > 0 ? 'yes' : 'no')) }}</td>
                        <td>{{ $type->description }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6"><em>@lang('app.no_records_found')</em></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

@stop
