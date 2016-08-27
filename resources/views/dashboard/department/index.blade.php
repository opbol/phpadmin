@extends('dashboard.layouts.master')

@section('page-title', trans('app.department_tree'))

@section('page-header')
    <h1>
        @lang('app.department_tree')
        <small>@lang('app.available_departments')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> @lang('app.home')</a></li>
        <li class="active">@lang('app.departments')</li>
      </ol>
@endsection

@section('content')

    @include('partials.messages')

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">@lang('app.department_tree')</h3>
            <div class="box-tools">
                <a href="javascript:load_form();" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i>
                    @lang('app.add_department')
                </a>
            </div>
        </div>
        <div class="box-body table-responsive no-padding" id="users-table-wrapper">
            <div class="col-md-6">
                @include('dashboard.department.partials.tree')
            </div>

            <div class="col-md-6" id="department-form-container">
                @include('dashboard.department.partials.form')
            </div>
        </div>
    </div>

@stop

@section('after-scripts-end')
    <script>
        var $tree = $('#tree-container');
        (function() {
            $tree.jstree({
                'core': {
                    'data': {
                        'url': '{{ route('department.jstree') }}',
                        'dataType': 'json' // needed only if you do not supply JSON headers
                    },
                    'check_callback':true
                },
                'types': {
                    'default' : {
                        'icon': 'fa fa-group'
                    }
                },
                'dnd':{
                    'copy':false
                },
                'plugins': ['types', 'dnd']
            }).on('loaded.jstree', function() {
                $tree.jstree('open_all');
            }).on("changed.jstree", function (e, data) {
                var id = data.selected[0];
                if (id > 0) {
                    load_form(id);
                }
            }).on('move_node.jstree', function(e, data) {
                $.post("{{ route('department.node.move') }}", {"_token": "{{ csrf_token() }}", "id": data.node.id, "parent_id": data.parent, "sort": data.position}, function(json) {
                    if (!json || json.code != 0) {
                        alert('error');
                        window.location.reload();
                    }
                });
            });
        })();

        function load_form(id) {
            var selected = $tree.jstree('get_selected');
            $.get('{{ route('department.form') }}' + '?id=' + id + '&selected=' + selected + '&_' + new Date().getTime(), function(html) {
                $('#department-form-container').html(html);
            });
        }
    </script>
@stop
