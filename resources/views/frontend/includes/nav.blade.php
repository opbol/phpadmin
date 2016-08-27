<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#frontend-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{!! route('frontend.index') !!}">
                {{ settings('app_name') }}
            </a>
        </div><!--navbar-header-->

        <div class="collapse navbar-collapse" id="frontend-navbar-collapse">

            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li class="{{ Ekko::isActiveRoute('frontend.index') }}">{!! link_to_route('frontend.index', trans('app.home')) !!}</li>
                <li class="{{ Ekko::isActiveRoute('taxpayer.index') }}">{!! link_to_route('taxpayer.index', trans('tax.taxpayer_query')) !!}</li>
                <li class="{{ Ekko::isActiveRoute('person.create') }}">{!! link_to_route('person.create', trans('tax.add_person')) !!}</li>
                <li class="{{ Ekko::isActiveRoute('person.list') }}">{!! link_to_route('person.list', trans('tax.persons')) !!}</li>
                <li class="{{ Ekko::isActiveRoute('taxer.create') }}">{!! link_to_route('taxer.create', trans('tax.add_taxer')) !!}</li>
                <li class="{{ Ekko::isActiveRoute('taxer.list') }}">{!! link_to_route('taxer.list', trans('tax.taxers')) !!}</li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                @if (false)
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        Language
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        @foreach(Localization::getSupportedLocales() as $key => $locale)
                        <li class="{{ localization()->getCurrentLocale() == $key ? 'active' : '' }}">
                            <a href="{{ localization()->getLocalizedURL($key) }}" rel="alternate" hreflang="{{ $key  }}">
                                <span class="flag-icon flag-icon-{{ $key  }}"></span>
                                {{ $locale->native() }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @endif

                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li>{!! link_to('login', trans('app.login')) !!}</li>
                    <li>{!! link_to('register', trans('app.sign_up')) !!}</li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->present()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>{!! link_to_route('dashboard', trans('app.dashboard')) !!}</li>

                            <li>{!! link_to_route('auth.logout', trans('app.logout')) !!}</li>
                        </ul>
                    </li>
                @endif

            </ul>
        </div><!--navbar-collapse-->
    </div><!--container-->
</nav>