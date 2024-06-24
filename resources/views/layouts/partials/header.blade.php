@section('styles')

@endsection

<!-- header start -->
<header class="inner-page light-header shadow-cls">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="menu">
                    <div class="brand-logo">
                        <a href="/">
                            @if(app()->getLocale() == 'ar')
                                <img src="{{ asset('assets/images/logo/logo_ar.png') }}" alt="" class="img-fluid logo">
                            @else
                                <img src="{{ asset('assets/images/logo/logo_en.png') }}" alt="" class="img-fluid logo">
                            @endif
                        </a>
                    </div>
                    <nav>
                        <div class="main-navbar">
                            <div id="mainnav">
                                <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
                                <ul class="nav-menu">
                                    <li class="back-btn">
                                        <div class="mobile-back text-end">
                                            <span>Back</span>
                                            <i aria-hidden="true" class="fa fa-angle-right ps-2"></i>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="/" class="nav-link menu-title">Home page</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <ul class="header-right">
                        <li class="right-menu">
                            <ul class="nav-menu">
                                <li>
                                    <a href="{{ route('login') }}" class="nav-link menu-title">Login</a>
                                </li>
                                <li>
                                    <a href="{{ route('register') }}" class="nav-link menu-title">Register</a>
                                </li>
                                <li class="dropdown language">
                                    <a href="javascript:void(0)">
                                        <i data-feather="globe"></i>
                                    </a>
                                    <ul class="nav-submenu">
                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <!-- item-->
                                            <li>
                                                <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="dropdown-item notify-item language py-2" data-lang="en" title="$properties['native']">
                                                    @if($localeCode == 'en')
                                                        <img src="{{ asset('static/images/flags/us.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                                                    @elseif($localeCode == 'ar')
                                                        <img src="{{ asset('static/images/flags/sa.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                                                    @endif
                                                    <span class="align-middle">{{ $properties['native'] }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <!-- <li class="dropdown">
                                    <a href="user-favourites.html">
                                        <i data-feather="heart"></i>
                                    </a>
                                </li> -->
                                <!-- <li class="dropdown currency">
                                    <a href="javascript:void(0)">
                                        <i data-feather="dollar-sign"></i>
                                    </a>
                                    <ul class="nav-submenu">
                                        <li><a href="javascript:void(0)">Dollar</a></li>
                                        <li><a href="javascript:void(0)">Euro</a></li>
                                        <li><a href="javascript:void(0)">Pound</a></li>
                                        <li><a href="javascript:void(0)">Yuan</a></li>
                                    </ul>
                                </li> -->
                                <!-- <li class="dropdown">
                                    <a href="{{ route('login') }}">
                                        <i data-feather="user"></i>
                                    </a>
                                </li> -->
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<!--  header end -->