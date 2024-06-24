@extends('layouts.guest')

@section('content')
<!-- section start -->
<section class="auth-page-wrapper py-5 position-relative d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="card mb-0">
                    <div class="row g-0 align-items-center">
                        <div class="col-xxl-5">
                            <div class="card auth-card bg-secondary h-100 border-0 shadow-none d-none d-sm-block mb-0">
                                <div class="card-body py-5 d-flex justify-content-between flex-column h-100">
                                    <div class="text-center">
                                        <h3 class="text-white">Start your journey with us.</h3>
                                        <p class="text-white opacity-75 fs-base">It brings together your tasks, projects, timelines, files and more</p>
                                    </div>

                                    <div class="auth-effect-main my-5 position-relative rounded-circle d-flex align-items-center justify-content-center mx-auto">
                                        <div class="effect-circle-1 position-relative mx-auto rounded-circle d-flex align-items-center justify-content-center">
                                            <div class="effect-circle-2 position-relative mx-auto rounded-circle d-flex align-items-center justify-content-center">
                                                <div class="effect-circle-3 mx-auto rounded-circle position-relative text-white fs-4xl d-flex align-items-center justify-content-center">
                                                    Welcome to <span class="text-primary ms-1">AFAC CRM</span>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="auth-user-list list-unstyled">
                                            <li>
                                                <div class="avatar-sm d-inline-block">
                                                    <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                        <img src="{{ asset('static/images/users/avatar-1.jpg' ) }}" alt="" class="img-fluid">
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="avatar-sm d-inline-block">
                                                    <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                        <img src="{{ asset('static/images/users/avatar-2.jpg' ) }}" alt="" class="img-fluid">
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="avatar-sm d-inline-block">
                                                    <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                        <img src="{{ asset('static/images/users/avatar-3.jpg' ) }}" alt="" class="img-fluid">
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="avatar-sm d-inline-block">
                                                    <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                        <img src="{{ asset('static/images/users/avatar-4.jpg' ) }}" alt="" class="img-fluid">
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="avatar-sm d-inline-block">
                                                    <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                        <img src="{{ asset('static/images/users/avatar-5.jpg' ) }}" alt="" class="img-fluid">
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="text-center">
                                        <p class="text-white opacity-75 mb-0 mt-3">
                                            &copy;
                                            <script>document.write(new Date().getFullYear())</script> AFAQ CRM. Developed by VOLKOD
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-6 mx-auto">
                            <div class="card mb-0 border-0 shadow-none mb-0">
                                <div class="card-body p-sm-5 m-lg-4">
                                    <div class="text-center mt-2">
                                        <h5 class="fs-3xl">Login</h5>
                                        <p class="text-muted">Contact us to get AFAQ CRM account now</p>
                                    </div>
                                    <div class="p-2 mt-5">
                                        <form class="needs-validation" novalidate method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="email" class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter your Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="password-input">{{ __('Password') }} <span class="text-danger">*</span></label>
                                                <div class="position-relative auth-pass-inputgroup">
                                                    <input type="password" class="form-control password-input pe-5 @error('password') is-invalid @enderror" onpaste="return false" placeholder="Enter password" id="password-input" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="password" required autocomplete="new-password">
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <p class="mb-0 fs-xs text-muted fst-italic">By using AFAQ CRM you agree to the AFAC CRM <a href="/pages/term_conditions" class="text-primary text-decoration-underline fst-normal fw-medium">Terms And Conditions</a></p>
                                            </div>

                                            <div class="mt-4">
                                                <button class="btn btn-primary w-100" type="submit">Sign in</button>
                                            </div>
                                        </form>
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
        <!--end row-->
    </div>
    <!--end container-->
</section>
<!-- section end -->
@endsection