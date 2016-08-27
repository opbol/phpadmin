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
            <li class="{{ Ekko::isActiveRoute('frontend.index') }}">
                <a href="{{ route('frontend.index') }}">
                    <i class="fa fa-home fa-fw"></i> <span>@lang('app.home')</span>
                </a>
            </li>

            @permission('procedures.query')
            <li class="{{ Ekko::isActiveRoute('procedure.list') }}">
                <a href="{{ route('procedure.list') }}">
                    <i class="fa fa-list fa-fw"></i> <span>@lang('tax.procedures_query')</span>
                </a>
            </li>
            @endpermission

            @permission('persons.query')
            <li class="{{ Ekko::isActiveRoute('taxpayer.index') }}">
                <a href="{{ route('taxpayer.index') }}">
                    <i class="fa fa-search fa-fw"></i> <span>@lang('tax.taxpayer_query')</span>
                </a>
            </li>
            @endpermission

            @permission('persons.manage')
                <li class="{{ Ekko::isActiveRoute('person.find') }}">
                    <a href="{{ route('person.find') }}">
                        <i class="fa fa-plus fa-fw"></i> <span>@lang('tax.person_manage')</span>
                    </a>
                </li>
            @endpermission

            @permission('persons.manage')
            <li class="{{ Ekko::isActiveRoute('person.list') }}">
                <a href="{{ route('person.list') }}">
                    <i class="fa fa-users fa-fw"></i> <span>@lang('tax.persons')</span>
                </a>
            </li>
            @endpermission

            @permission('taxers.manage')
            <li class="{{ Ekko::isActiveRoute('taxer.create') }}">
                <a href="{{ route('taxer.create') }}">
                    <i class="fa fa-plus fa-fw"></i> <span>@lang('tax.add_taxer')</span>
                </a>
            </li>
            @endpermission

            @permission('taxers.manage')
            <li class="{{ Ekko::isActiveRoute('taxer.list') }}">
                <a href="{{ route('taxer.list') }}">
                    <i class="fa fa-users fa-fw"></i> <span>@lang('tax.taxers')</span>
                </a>
            </li>
            @endpermission

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>