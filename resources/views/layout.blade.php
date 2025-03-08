<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">

        <title>@yield('title', config('app.name'))</title>

        <!-- Scripts & CSS -->
        @vite(['resources/assets/sass/main.scss', 'resources/assets/js/app.js'])

        <!-- Manifest -->
        <link rel="manifest" href="{{ asset('manifest.json') }}">

        <!-- Icon -->
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    </head>
    <body>
    <div class="app">
        @yield('content')
    </div>
    </body>
</html>
