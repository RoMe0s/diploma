<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Checker') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.js') }}" defer></script>
    <script src="{{ asset('js/lang.js') }}" defer></script>
    @guest
        <script src="{{ asset('js/chunks/guest.js') }}" defer></script>
    @else
        <script src="{{ asset('js/chunks/auth.js') }}" defer></script>
        @customer
        <script src="{{ asset('js/chunks/customer.js') }}" defer></script>
        @else
            <script src="{{ asset('js/chunks/author.js') }}" defer></script>
            @endcustomer
        @endguest
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
              integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf"
              crossorigin="anonymous">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" :class="{'collapsed': collapsed, 'authenticated': authenticated}">
    @guest
        <guest-top-menu></guest-top-menu>
    @else
        <auth-top-menu></auth-top-menu>
        <sidebar></sidebar>
    @endif
    <div class="container container-fluid mt-4 mb-4">
        @yield('content')
    </div>
</div>
</body>
</html>
