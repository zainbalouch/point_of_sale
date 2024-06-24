<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg" data-preloader="disable" data-theme="default" data-topbar="light" data-bs-theme="light" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}" data-layout-width="fluid" data-sidebar-image="none" data-layout-position="fixed" data-layout-style="default">

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
    <script src="{{ asset('static/libs/toastify-js/src/toastify.js') }}"></script>

    @if(app()->getLocale() == 'ar')
    <!-- Bootstrap Css -->
    <link href="{{ asset('static/css/bootstrap-rtl.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ asset('static/css/app-rtl.min.css') }}" rel="stylesheet" type="text/css">
    @else
    <link href="{{ asset('static/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('static/css/app.min.css') }}" rel="stylesheet" type="text/css">
    @endif

    <!-- Icons Css -->
    <link href="{{ asset('static/css/icons.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Toastify Css-->
    <link href="{{ asset('static/css/toastify.min.css') }}" rel="stylesheet" type="text/css">

    <!-- custom Css-->
    <link href="{{ asset('static/css/custom.min.css') }}" rel="stylesheet" type="text/css">

    @yield('styles')
</head>

<body>
    <section class="auth-page-wrapper py-5 position-relative d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="card mb-0">
                        <div class="row g-0 align-items-center">
                            <div class="col-xxl-6 mx-auto">
                                <div class="card mb-0 border-0 shadow-none mb-0">
                                    <div class="card-body p-sm-5 m-lg-4">
                                        <div class="text-center">
                                            <div class="mb-5">
                                                <h3>GPS must be enabled to access the dashboard</h3>
                                            </div>
                                            <div class="mt-4 pt-3">
                                                <a href="{{ route('admin.dashboard.index') }}" class="btn btn-primary"><i class="ph ph-arrow-clockwise"></i> Retry</a>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                </div>
                <!--end col-->
            </div>
        </div>
    </section>

    <script src="{{ asset('static/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>