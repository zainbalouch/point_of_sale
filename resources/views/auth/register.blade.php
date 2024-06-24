@extends('layouts.app')

@section('content')
<!-- section start -->
<section class="login-wrap">
    <div class="container">
        <div class="row log-in">
            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 col-12">
                <div class="theme-card">
                    <div class="title-3 text-start">
                        <h2>{{ __('Register') }}</h2>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i data-feather="user"></i>
                                    </div>
                                </div>
                                <input id="first-name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder="{{ __('First name') }}">
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i data-feather="user"></i>
                                    </div>
                                </div>
                                <input id="last-name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus placeholder="{{ __('Last name') }}">
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i data-feather="user"></i>
                                    </div>
                                </div>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('Email Address') }}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i data-feather="lock"></i>
                                    </div>
                                </div>
                                <input type="password" id="pwd-input" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" name="password" required autocomplete="new-password">
                                <div class="input-group-apend">
                                    <div class="input-group-text">
                                        <i id="pwd-icon" class="far fa-eye-slash"></i>
                                    </div>
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="important-note">
                                password should be a minimum of 8 characters and should contains letters and numbers
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i data-feather="lock"></i>
                                    </div>
                                </div>
                                <input type="password" id="pwd-input" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="{{ __('Password confirmation') }}" name="password_confirmation" required autocomplete="new-password">
                                <div class="input-group-apend">
                                    <div class="input-group-text">
                                        <i id="pwd-icon" class="far fa-eye-slash"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-gradient btn-pill color-2 me-sm-3 me-2">{{ __('Register') }}</button>
                            <a href="{{ route('login') }}" class="btn btn-dashed btn-pill color-2">{{ __('Login') }}</a>
                        </div>
                        <div class="divider">
                            <h6>or</h6>
                        </div>
                        <div>
                            <h6>Log in with</h6>
                            <div class="row social-connect">
                                <div class="col-6">
                                    <a href="https://www.facebook.com/" class="btn btn-social btn-flat facebook p-0">
                                        <i class="fab fa-facebook-f"></i>
                                        <span>Facebook</span>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="https://account.google.com" class="btn btn-social btn-flat google p-0">
                                        <i class="fab fa-google"></i>
                                        <span>Google</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- section end -->
@endsection