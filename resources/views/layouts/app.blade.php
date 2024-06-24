<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sheltos - Filter search tab & fixed header home page">
    <meta name="keywords" content="sheltos">
    <meta name="author" content="sheltos">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon" />


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!--Google font-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,500,500i,600,600i,700,700i,800,800i"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i" rel="stylesheet">

    <!-- magnific css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/magnific-popup.css') }}">

    <!-- range slider css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery-ui.css') }}">

    <!-- animate css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/animate.css') }}">

    <!-- Template css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/color1.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom_styles.css') }}">

    @yield('styles')
    
</head>
<body @if(app()->getLocale() == 'ar') class="rtl" @endif>
    <!-- Loader start -->
    <div class="loader-wrapper">
        <div class="row loader-img">
            <div class="col-12">
                <img src="{{ asset('assets/images/loader/loader-2.gif') }}" class="img-fluid" alt="">
            </div>
        </div>
    </div>
    <!-- Loader end -->

    @include('layouts.partials.header')

    @yield('content')

    <!-- tap to top start -->
    <div class="tap-top color-4">
        <div>
            <i class="fas fa-arrow-up"></i>
        </div>
    </div>
    <!-- tap to top end -->

    @include('layouts.partials.footer')

    <!-- latest jquery-->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

    <!-- popper js-->
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>

    <!-- magnific js -->
    <script src="{{ asset('assets/js/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/js/zoom-gallery.js') }}"></script>

    <!-- Bootstrap js-->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- feather icon js-->
    <script src="{{ asset('assets/js/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/feather-icon/feather-icon.js') }}"></script>

    <!-- wow js-->
    <script src="{{ asset('assets/js/wow.min.js') }}" ></script>

    <!-- slick js -->
    <script src="{{ asset('assets/js/slick.js') }}"></script>
    <script src="{{ asset('assets/js/slick-animation.min.js') }}"></script>

    <!-- login js -->
    <script src="{{ asset('assets/js/login.js') }}"></script>

    <!-- Template js-->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    @yield('scripts')
</body>
</html>
