<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ConnectFriend</title>

    @include('links.css')
    @include('links.scripts')
</head>

<body>
    @include('partials.navbar')

    @yield('css')

    <div class="content container-fluid px-0" style="min-height: 100dvh;">
        @yield('container')
    </div>

    @include('partials.footer')
</body>

</html>
