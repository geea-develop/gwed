<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <!-- Branding Image -->
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

                @if (Auth::check())
                    <router-link tag="li" to="/" class="nav-item" exact>
                        <a class="nav-link">Dashboard</a>
                    </router-link>
                    {{--<router-link tag="li" to="/wedding" class="nav-item" exact>--}}
                        {{--<a class="nav-link">Create Wedding</a>--}}
                    {{--</router-link>--}}
                    @if (Auth::user()->admin)
                        <router-link tag="li" to="/vendors" class="nav-item" exact>
                            <a class="nav-link">Vendors</a>
                        </router-link>
                        <router-link tag="li" to="/professions" class="nav-item" exact>
                            <a class="nav-link">Professions</a>
                        </router-link>
                        <router-link tag="li" to="/products" class="nav-item" exact>
                            <a class="nav-link">Products</a>
                        </router-link>
                    @endif
                @endif
            </ul>

            <div class="my-2 my-lg-0">
                <ul class="navbar-nav mr-auto">
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}" class="nav-item my-2 mr-4">Login</a></li>
                        <li><a href="{{ route('register') }}" class="nav-item">Register</a></li>
                    @else
                        <span class="navbar-text">
                            Welcome
                        </span>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>