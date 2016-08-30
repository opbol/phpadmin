<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ Auth::user()->present()->avatar }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->present()->nameOrEmail }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> @lang('app.online')</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="{{ Ekko::isActiveRoute('dashboard') }}">
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard fa-fw"></i> <span>@lang('app.dashboard')</span>
                </a>
            </li>

            @permission('departments.manage')
            <li class="{{ Ekko::isActiveRoute('department.index') }}">
                <a href="{{ route('department.index') }}">
                    <i class="fa fa-sitemap fa-fw"></i> <span>@lang('app.department_tree')</span>
                </a>
            </li>
            @endpermission

            @permission('users.manage')
                <li class="{{ Ekko::isActiveRoute('user.list') }}">
                    <a href="{{ route('user.list') }}">
                        <i class="fa fa-users fa-fw"></i> <span>@lang('app.users')</span>
                    </a>
                </li>
            @endpermission

            @permission(['roles.manage', 'permissions.manage'])
                <li class="{{ Ekko::areActiveRoutes(['role.index', 'dashboard.permission.index']) }} treeview">
                    <a href="#">
                        <i class="fa fa-user fa-fw"></i>
                        <span>@lang('app.roles_and_permissions')</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        @permission('roles.manage')
                            <li class="{{ Ekko::isActiveRoute('role.index') }}">
                                <a href="{{ route('role.index') }}">
                                    <i class="fa fa-circle-o"></i>
                                    @lang('app.roles')
                                </a>
                            </li>
                        @endpermission
                        @permission('permissions.manage')
                            <li class="{{ Ekko::isActiveRoute('dashboard.permission.index') }}">
                                <a href="{{ route('dashboard.permission.index') }}">
                                   <i class="fa fa-circle-o"></i>
                                   @lang('app.permissions')</a>
                            </li>
                        @endpermission
                    </ul>
                </li>
            @endpermission

            <li class="{{ Ekko::areActiveRoutes(['model.column.type.index']) }} treeview">
                <a href="#">
                    <i class="fa fa-user fa-fw"></i>
                    <span>@lang('model.models')</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Ekko::isActiveRoute('model.column.type.index') }}">
                        <a href="{{ route('model.column.type.list') }}">
                            <i class="fa fa-circle-o"></i>
                            @lang('model.column_types')
                        </a>
                    </li>
                </ul>
            </li>

            @permission('backups.manage')
            <li class="{{ Ekko::isActiveRoute('backup.index') }}">
                <a href="{{ route('backup.index') }}">
                    <i class="fa fa-circle-o-notch fa-fw"></i> <span>@lang('app.backups')</span>
                </a>
            </li>
            @endpermission

            @permission('users.activity')
            <li class="{{ Ekko::isActiveRoute('activity.index') }}">
                <a href="{{ route('activity.index') }}">
                    <i class="fa fa-list-alt fa-fw"></i> <span>@lang('app.activity_log')</span>
                </a>
            </li>
            @endpermission

            @role('Admin')
            <li class="{{ Ekko::isActiveMatch('log-viewer') }} treeview">
                <a href="#">
                	<i class="fa fa-file-text-o fa-fw"></i>
                    <span>@lang('app.log_viewer')</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Ekko::isActiveRoute('log-viewer::dashboard') }}">
                        <a href="{!! url('dashboard/log-viewer') !!}">@lang('app.log_viewer_dashboard')</a>
                    </li>
                    <li class="{{ Ekko::isActiveRoute('log-viewer::logs.list') }}">
                        <a href="{!! url('dashboard/log-viewer/logs') !!}">@lang('app.log_viewer_logs')</a>
                    </li>
                </ul>
            </li>
            @endrole

            @permission(['settings.general', 'settings.auth', 'settings.notifications'])
            <li class="{{ Ekko::areActiveRoutes(['settings.general', 'settings.auth', 'settings.notifications']) }} treeview">
                <a href="#">
                    <i class="fa fa-gear fa-fw"></i>
                    <span>@lang('app.settings')</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    @permission('settings.general')
                        <li class="{{ Ekko::isActiveRoute('settings.general') }}">
                            <a href="{{ route('settings.general') }}">
                               <i class="fa fa-circle-o"></i>
                                @lang('app.general')
                            </a>
                        </li>
                    @endpermission
                    @if (false)
                    @permission('settings.auth')
                        <li class="{{ Ekko::isActiveRoute('settings.auth') }}">
                            <a href="{{ route('settings.auth') }}">
                               <i class="fa fa-circle-o"></i>
                                @lang('app.auth_and_registration')
                            </a>
                        </li>
                    @endpermission
                    @permission('settings.notifications')
                        <li class="{{ Ekko::isActiveRoute('settings.notifications') }}">
                            <a href="{{ route('settings.notifications') }}">
                               <i class="fa fa-circle-o"></i>
                                @lang('app.notifications')
                            </a>
                        </li>
                    @endpermission
                    @endif
                </ul>
            </li>
            @endpermission

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>