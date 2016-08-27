<div id="navbar" class="navbar navbar-default">
    <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>

    <div class="navbar-container" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>
        </button>

        <div class="navbar-header pull-left">
            <a href="{{ route('frontend.index') }}" class="navbar-brand">
                <small>
                    <img src="{{ url('assets/img/logo-no-text.png') }}" width="24" height="24" />
                    {{ settings('app_name') }}
                </small>
            </a>
        </div>

        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue">
                    <a href="{{ route('help') }}" target="_blank">
                        <i class="ace-icon fa fa-question-circle icon-animated-vertical"></i>
                    </a>
                </li>
                <li class="light-blue">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="ace-icon fa fa-cog"></i>
                    </a>

                    <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
                        <li class="dropdown-header">
                            <i class="ace-icon fa fa-cog"></i>
                            @lang('app.ui_settings')
                        </li>

                        <li class="dropdown-content">
                            <ul class="dropdown-menu dropdown-navbar">
                                <li>
                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
                                        <label class="lbl" for="ace-settings-navbar">@lang('app.ui_fixed_navbar')</label>
                                    </div>
                                </li>

                                <li>
                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                                        <label class="lbl" for="ace-settings-sidebar">@lang('app.ui_fixed_sidebar')</label>
                                    </div>
                                </li>

                                <li>
                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                                        <label class="lbl" for="ace-settings-breadcrumbs">@lang('app.ui_fixed_breadcrumbs')</label>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="{{ Auth::user()->present()->avatar }}" />
                        <span class="user-info">
								<small>@lang('app.welcome'),</small>
                                {{ Auth::user()->present()->realname }}
								</span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="{{ route('dashboard') }}">
                                <i class="ace-icon fa fa-cog"></i>
                                @lang('app.my_dashboard')
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('profile') }}">
                                <i class="ace-icon fa fa-user"></i>
                                @lang('app.my_profile')
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="{{ route('auth.logout') }}">
                                <i class="ace-icon fa fa-power-off"></i>
                                @lang('app.logout')
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div><!-- /.navbar-container -->
</div>