<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="/" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo.jpg')}}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo.jpg')}}" alt="" height="200">
            </span>
        </a>
        <a href="/" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo.jpg')}}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo.jpg')}}" alt="" height="200">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-3xl header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-menu">Menu</span></li>
                @role(['super_admin', 'admin'])
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard.index') }}" class="nav-link menu-link {{ request()->routeIs('admin.dashboard.index') ? 'active' : '' }}"> <i class="ph-gauge"></i> <span>@lang('site.dashboard')</span> </a>
                </li>
                @endrole
                <li class="nav-item">
                    <a href="#settings" class="nav-link menu-link" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->routeIs('settings.*') ? 'true' : 'false' }}" aria-controls="settings">
                        <i class="ph-wrench"></i> <span>Settings</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('admin.settings.*') ? 'collapse show' : '' }}" id="settings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.settings.general') }}" class="nav-link {{ request()->routeIs('admin.settings.general') ? 'active' : '' }}">General</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>

@section('scripts')

@endsection