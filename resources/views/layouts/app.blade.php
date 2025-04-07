<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="GIANT">
    <meta name="msapplication-TileImage" content="{{ asset('/assets/icon/apple-icon-144.png') }}">
    <meta name="msapplication-TileColor" content="#fff">
    <meta name="theme-color" content="#fff">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts & CSS -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- Icon -->
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    <link rel="apple-touch-icon" href="{{ asset('/assets/icon/apple-icon-57.png') }}" sizes="57x57">
    <link rel="apple-touch-icon" href="{{ asset('/assets/icon/apple-icon-60.png') }}" sizes="60x60">
    <link rel="apple-touch-icon" href="{{ asset('/assets/icon/apple-icon-72.png') }}" sizes="72x72">
    <link rel="apple-touch-icon" href="{{ asset('/assets/icon/apple-icon-76.png') }}" sizes="76x76">
    <link rel="apple-touch-icon" href="{{ asset('/assets/icon/apple-icon-114.png') }}" sizes="114x114">
    <link rel="apple-touch-icon" href="{{ asset('/assets/icon/apple-icon-120.png') }}" sizes="120x120">
    <link rel="apple-touch-icon" href="{{ asset('/assets/icon/apple-icon-144.png') }}" sizes="144x144">
    <link rel="apple-touch-icon" href="{{ asset('/assets/icon/apple-icon-152.png') }}" sizes="152x152">
    <link rel="apple-touch-icon" href="{{ asset('/assets/icon/apple-icon-180.png') }}" sizes="180x180">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
