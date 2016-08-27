@extends('dashboard.layouts.master')

@section('page-title', trans('app.backups'))

@section('page-header')
    <h1>
        @lang('app.backups')
        <small>@lang('app.available_backups')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> @lang('app.home')</a></li>
        <li class="active">@lang('app.backups')</li>
    </ol>
@endsection

@section('content')

    @include('partials.messages')

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">@lang('app.available_backups')</h3>
            <div class="box-tools">
                <a href="javascript:void(0);" class="btn btn-sm btn-warning"
                   title="@lang('app.recover_backup')" data-toggle="modal" data-target="#recover-modal">
                    <i class="fa fa-repeat"></i>
                    @lang('app.recover_backup')
                </a>
                <a href="{{ route('backup.manual') }}" class="btn btn-sm btn-success"
                   title="@lang('app.manual_backup')"
                   data-toggle="tooltip"
                   data-placement="top"
                   data-method="POST"
                   data-confirm-title="@lang('app.please_confirm')"
                   data-confirm-text="@lang('app.are_you_sure_manual_backup')"
                   data-confirm-action="@lang('app.yes_manual_it')">
                    <i class="fa fa-plus"></i>
                    @lang('app.backup_manual')
                </a>
            </div>
        </div>
        <div class="box-body table-responsive no-padding" id="users-table-wrapper">
            <table class="table table-hover">
                <thead>
                    <th>@lang('app.backup_name')</th>
                    <th>@lang('app.backup_disk')</th>
                    <th>@lang('app.backup_file')</th>
                    <th>@lang('app.backup_size')</th>
                    <th>@lang('app.backup_md5')</th>
                    <th>@lang('app.backup_created_at')</th>
                    <th class="text-center">@lang('app.action')</th>
                </thead>
                <tbody>
                    @if (count($backups))
                    @foreach ($backups as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->disk }}</td>
                        <td>{{ $item->file }}</td>
                        <td>{{ getHumanReadableSize($item->size) }}</td>
                        <td>{{ $item->md5 }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td class="text-center">
                            <a href="{{ route('backup.download', $item->id) }}" class="btn btn-primary btn-circle"
                               title="@lang('app.download')">
                                <i class="glyphicon glyphicon-download"></i>
                            </a>
                            @if (false)
                            <a href="{{ route('backup.recover', $item->id) }}" class="btn btn-danger btn-circle"
                               title="@lang('app.recover_backup')"
                               data-toggle="tooltip"
                               data-placement="top"
                               data-method="POST"
                               data-confirm-title="@lang('app.please_confirm')"
                               data-confirm-text="@lang('app.are_you_sure_recover_it')"
                               data-confirm-action="@lang('app.yes_recover_it')">
                                <i class="glyphicon glyphicon-repeat"></i>
                            </a>
                            @endif
                            <a href="{{ route('backup.delete', $item->id) }}" class="btn btn-danger btn-circle"
                                title="@lang('app.delete_backup')"
                                data-toggle="tooltip"
                                data-placement="top"
                                data-method="DELETE"
                                data-confirm-title="@lang('app.please_confirm')"
                                data-confirm-text="@lang('app.are_you_sure_delete')"
                                data-confirm-action="@lang('app.yes_delete_it')">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="4"><em>@lang('app.no_records_found')</em></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="recover-modal" tabindex="-1" role="dialog" aria-labelledby="recover-db-model-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="recover-db-model-label">@lang('app.recover_backup')</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'backup.recover.file', 'files' => true, 'id' => 'recover-form']) !!}
                    <div class="form-group">
                        <input id="file-upload" type="file" name="file" />
                        <p class="help-block">
                        <h3>请上传SQL文件</h3>
                        </p>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">@lang('app.close')</button>
                    <button type="button" data-dismiss="modal" id="recover-btn" class="btn btn-primary">@lang('tax.submit')</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="recover-result-modal" tabindex="-1" role="dialog" aria-labelledby="recover-result-model-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="recover-result-model-label">@lang('tax.import')</h4>
                </div>
                <div class="modal-body">
                    <div id="recover-result-container" class="recover-result-container"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">@lang('app.close')</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('after-scripts-end')
    <script>
        jQuery(document).ready(function($) {
            $('#recover-form').fileupload({
                singleFileUploads: true,
                dataType: 'json',
                add: function (e, data) {
                    data.context = $('#recover-btn') .click(function () {
                        $('body').loading({
                            message: "@lang('app.recovering')",
                        });
                        data.submit().complete(function (result, textStatus, jqXHR) {
                            $('body').loading('stop');
                        }).error(function(jqXHR, textStatus, errorThrown) {
                            console.error(errorThrown);
                            alert("@lang('app.recover_failed')");
                        }).success(function (result, textStatus, jqXHR) {
                            $('#recover-result-container').html(result && result.code == 0 ? "@lang('app.recover_success')" : "@lang('app.recover_failed')");
                            $('#recover-result-modal').modal('show');
                        });
                    });
                },
                done: function (e, data) {
                }
            });

            $('#recover-result-modal').on('hidden.bs.modal', function() {
                window.location.reload();
            });
        });
    </script>
@stop