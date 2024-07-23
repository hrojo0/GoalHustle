

@if (Route::currentRouteName() == 'welcome')
<header id="header" class="version-i">
    <div class="container">
        <div class="row">
@else
<header id="header" class="version-ii" style="z-index: 999">
    <div class="stick-holder">
				
        <div class="container">
        
            <div class="row holder">
@endif

            <div class="col-xs-3 col-sm-2">
                <!-- logo of the page -->
                <div class="logo"><a href="{{ route('welcome') }}"><img src="/img/logo.png" alt="dot"></a></div>
                <!-- logo of the page end -->
            </div>
            <div class="col-xs-9 col-sm-10 nav-holder">
                <!-- Nav of the page -->
                <nav id="nav" class="navbar navbar-default">
                    <!-- Navbar header of the page -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <!-- Navbar header of the page end -->
                    <!-- Collapse navbar collapse of the page -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            
                            <li class="{{ request()->routeIs('welcome') ? 'active' : '' }}"><a href="{{ route('welcome') }}">Home</a></li>

                            <li class="{{ request()->routeIs('tournaments.show') ? 'active' : '' }}">
                                <a href="#">Tournaments</a>
                                <!-- drop of the page -->
                                <div class="drop">
                                    <ul>
                                        @foreach ($tournamentsNav as $tournamentNav)
                                            <li>
                                                <a href="{{ route('tournaments.show', $tournamentNav->slug) }}">{{ $tournamentNav->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!-- drop of the page end -->
                            </li>

                            <li class="{{ request()->routeIs('article.news') ? 'active' : '' }}">
                                <a href="{{ route('article.news') }}">News</a>
                                <!-- drop of the page -->
                                <div class="drop">
                                    <ul>
                                        <li>
                                            <a href="{{ route('article.news') }}">All</a>
                                        </li>
                                        @foreach ($categoriesNav as $categoryNav)
                                            <li>
                                                <a href="{{ route('categories.detail', $categoryNav->slug) }}">{{ $categoryNav->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!-- drop of the page end -->
                            </li>

                            @auth
                            <li >
                                <a href="#" style="padding-left: 25px">
                                    <div style="position: absolute; left:0; top:-7px">
                                        <x-bladewind::avatar image="{{ Auth::user()->profile->photo ? asset(Auth::user()->profile->photo) : asset('img/user-default.png') }}"
                                            size="tiny" />
                                    </div>
                                    {{ Auth::user()->name }}</a>
                                <!-- drop of the page -->
                                <div class="drop">
                                    <ul>
                                        @can('admin.index')
                                        <li><a href="{{ route('admin.index') }}">Panel admin</a></li>
                                        @endcan
                                        <li><a href="{{ route('profile.show', Auth::user()->id) }}">Perfil</a></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                                    Cerrar sesión
                                                </a>
                                            </form>
                                        
                                        </li>
                                    </ul>
                                </div>
                                <!-- drop of the page end -->
                            </li>
                                <div class="drop">
                                    <ul>
                                        @can('admin.index')
                                        <li><a href="{{ route('admin.index') }}"></a>Panel admin</li>
                                        @endcan
                                        
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                Cerrar sesión
                                            </x-dropdown-link>
                                        </form>
                                    </ul>
                                </div>
                            @else
                                <li><a href="{{ route('login') }}">Entrar</a></li>
                                <li><a href="{{ route('register') }}">Registrarse</a></li>
                            @endauth
                        </ul>
                    </div>
                    <!-- Collapse navbar collapse of the page end -->
                    

                </nav>
                <!-- Nav of the page end -->
            </div>
@if (Route::currentRouteName() == 'welcome')
            </div>
        </div>
    </div>
</header>
@else
        </div>
    </div>
</header>
@endif