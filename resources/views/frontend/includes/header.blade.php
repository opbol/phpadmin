<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ route('frontend.index') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
            <img src="{{ url('assets/img/logo-no-text.png') }}" height="35px" alt="{{ settings('app_name') }}">
        </span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{{ settings('app_name') }}</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">@lang('toggle_navigation')</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ Auth::user()->present()->avatar }}" class="user-image" alt="User Image"/>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ Auth::user()->present()->realname }}</span>
                    </a>

                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ Auth::user()->present()->avatar }}" class="img-circle" alt="User Image" />
                            <p>
                                <small>{{ get_property(Auth::user()->department, 'name') }}<br/>
                                    @if (Auth::user()->roles()->count() > 0)
                                        @foreach (Auth::user()->roles as $role)
                                            {!! $role->display_name !!}
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <a href="{{ route('dashboard') }}" class="btn btn-default btn-block">
                               <i class="fa fa-user"></i>
                               @lang('app.my_dashboard')
                            </a>
                            <a href="{{ route('auth.logout') }}" class="btn btn-default btn-block">
                               <i class="fa fa-sign-out"></i>
                               @lang('app.logout')
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>