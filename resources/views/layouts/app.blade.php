<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Pusher --}}
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    {{-- Laravel Echo --}}
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.13.0/dist/echo.iife.js"></script>
</head>

<body>

    <div id="app">
        @include('partials.navbar')
        @yield('css')
        <main class="content py-4">
            @yield('content')
        </main>
        @yield('scripts')
        @include('partials.footer')
    </div>

</body>

</html>
