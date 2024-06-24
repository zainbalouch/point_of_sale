<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg" data-preloader="disable" data-theme="default" data-topbar="light" data-bs-theme="light" dir="ltr" data-layout-width="fluid" data-sidebar-image="none" data-layout-position="fixed" data-layout-style="default">
<head>
    <meta charset="utf-8">    

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="AFAQ CRM" name="description">
    <meta content="AFAQ" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('static/images/favicon.ico') }}">

    <!-- Fonts css load -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link id="fontsLink" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Layout config Js -->
    <script src="{{ asset('static/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('static/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{ asset('static/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ asset('static/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <!-- custom Css-->
    <link href="{{ asset('static/css/custom.min.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
    @yield('content')
    
    @include('layouts.partials.footer')

    <!-- JAVASCRIPT -->
    <script src="{{ asset('static/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('static/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('static/js/plugins.js') }}"></script>

    @yield('javascript')

    <!-- App js -->
    <script src="{{ asset('static/js/app.js') }}"></script>
    
</body>
</html>
