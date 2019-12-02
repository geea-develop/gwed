<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Icon -->
        <link href="{{ asset('ring.ico') }}" rel="icon" type="image/png">

        <link href="{{ asset('css/web.css') }}" rel="stylesheet">

    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                @include('flash::message')

                <div class="links">
                    <a href="/#" class="title">
                        {{ config('app.name') }}
                    </a>
                    <a >|</a>
                    <a href="{{ url('/dashboard') }}">Get Started</a>
                    <a href="{{ url('/shop') }}">Shop</a>
                    <a href="{{ url('/about') }}">About</a>
                    <a href="{{ url('/documentation') }}">Documentation</a>
                    <a href="{{ url('/contact') }}">Contact</a>

                    @if (Route::has('login'))
                        <a >|</a>
                            @if (Auth::check())
                                <a href="{{ url('/dashboard') }}">Dashboard</a>
                            @else
                                <a href="{{ url('/login') }}">Login</a>
                                <a href="{{ url('/register') }}">Register</a>
                            @endif

                    @endif
                </div>

            </div>

            <div class="content">
                @yield('content')
            </div>


        </div>
    </body>
</html>
