<!DOCTYPE html>
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

        <title>@yield('title', config('app.name'))</title>

        <!-- Scripts & CSS -->
        @vite(['resources/assets/sass/main.scss', 'resources/assets/js/app.js'])

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
    <div class="app">
        @yield('content')
    </div>
    </body>
</html>
