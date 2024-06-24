<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="/" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/logo/logo_ar.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo/logo_ar.png') }}" alt="" height="22">
                        </span>
                    </a>

                    <a href="/" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/logo/logo_ar.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo/logo_ar.png') }}" alt="" height="22">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>

            <div class="d-flex align-items-center">
                <div class="dropdown ms-1 topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(LaravelLocalization::getCurrentLocale() == 'ar')
                            <img id="header-lang-img" src="{{ asset('static/images/flags/sa.svg') }}" alt="Header Language" height="20" class="rounded">
                        @else
                            <img id="header-lang-img" src="{{ asset('static/images/flags/us.svg') }}" alt="Header Language" height="20" class="rounded">
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">


                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <!-- item-->
                            <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="dropdown-item notify-item language py-2" data-lang="en" title="$properties['native']">
                                @if($localeCode == 'en')
                                    <img src="{{ asset('static/images/flags/us.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                                @elseif($localeCode == 'ar')
                                    <img src="{{ asset('static/images/flags/sa.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                                @endif
                                <span class="align-middle">{{ $properties['native'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown"  data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <i class='bi bi-bell fs-2xl'></i>
                        @if(auth()->user()->unreadnotifications->count() > 0)
                            <span class="position-absolute topbar-badge fs-3xs translate-middle badge rounded-pill bg-danger">
                                <span class="notification-badge">{{ auth()->user()->unreadnotifications->count() }}</span>
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head rounded-top">
                            <div class="p-3 border-bottom border-bottom-dashed">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="mb-0 fs-lg fw-semibold"> Notifications <span class="badge bg-danger-subtle text-danger fs-sm notification-badge"> {{ auth()->user()->unreadnotifications->count() }}</span></h6>
                                        <p class="fs-md text-muted mt-1 mb-0">You have <span class="fw-semibold notification-unread">{{ auth()->user()->unreadnotifications->count() }}</span> unread messages</p>
                                    </div>
                                    <div class="col-auto dropdown">
                                        <a href="javascript:void(0);" data-bs-toggle="dropdown" class="link-secondary fs-md"><i class="bi bi-three-dots-vertical"></i></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('notifications.markAllAsRead') }}">Mark all as read</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="py-2 ps-2" id="notificationItemsTabContent">
                            <div data-simplebar style="max-height: 300px;" class="pe-2">
                                <h6 class="text-overflow text-muted fs-sm my-2 text-uppercase notification-title">New</h6>
                                @forelse(auth()->user()->unreadnotifications as $unreadNotification)
                                    <div class="text-reset notification-item d-block dropdown-item position-relative unread-message">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <a href="{{ route('notifications.markAsRead', ['id' => $unreadNotification->id]) }}" class="stretched-link">
                                                    <h6 class="mt-0 fs-md mb-2 lh-base">{{ $unreadNotification->data['body'] }}</h6>
                                                </a>
                                                <p class="mb-0 fs-2xs fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> {{ $unreadNotification->created_at->diffForHumans() }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-reset notification-item d-block dropdown-item position-relative unread-message">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <a href="#" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-md text-muted">There are no new notifications</h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse

                                <h6 class="text-overflow text-muted fs-sm my-2 text-uppercase notification-title">Read Before</h6>
                                @forelse(auth()->user()->readnotifications as $readNotification)
                                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <a href="{{ route('notifications.markAsRead', ['id' => $readNotification->id]) }}" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-md text-muted">{{ $readNotification->data['body'] }}</h6>
                                                </a>
                                                <p class="mb-0 fs-2xs fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> {{ $readNotification->created_at->diffForHumans() }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-md fw-semibold">There are no read notifications</h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            <!-- <div class="notification-actions" id="notification-actions">
                                <div class="d-flex text-muted justify-content-center align-items-center">
                                    Select <div id="select-content" class="text-body fw-semibold px-1">0</div> Result <button type="button" class="btn btn-link link-danger p-0 ms-2" data-bs-toggle="modal" data-bs-target="#removeNotificationModal">Remove</button>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <!-- <img class="rounded-circle header-profile-user" src="{{ asset('static/images/users/32/avatar-1.jpg') }}" alt="Header Avatar"> -->
                            <i class="mdi mdi-account-circle text-muted fs-lg align-middle me-1" style="font-size: 25px !important;"></i> 
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ auth()->user()->full_name }}</span>
                                <span class="d-none d-xl-block ms-1 fs-sm user-name-sub-text">{{ auth()->user()->roles()->first()->display_name }}</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome {{ auth()->user()->full_name }}</h6>
                        <a class="dropdown-item" href="{{ route('admin.users.edit', auth()->user()->id) }}"><i class="mdi mdi-account-circle text-muted fs-lg align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                        <!--
                        <a class="dropdown-item" href="/apps/chat"><i class="mdi mdi-message-text-outline text-muted fs-lg align-middle me-1"></i> <span class="align-middle">Messages</span></a>
                        <a class="dropdown-item" href="/apps/support-tickets/overview"><i class="mdi mdi-calendar-check-outline text-muted fs-lg align-middle me-1"></i> <span class="align-middle">Taskboard</span></a>
                        <a class="dropdown-item" href="/pages/faqs"><i class="mdi mdi-lifebuoy text-muted fs-lg align-middle me-1"></i> <span class="align-middle">Help</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/pages/profile"><i class="mdi mdi-wallet text-muted fs-lg align-middle me-1"></i> <span class="align-middle">Balance : <b>$8451.36</b></span></a>
                        <a class="dropdown-item" href="/pages/profile_settings"><span class="badge bg-success-subtle text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-lg align-middle me-1"></i> <span class="align-middle">Settings</span></a>
                        <a class="dropdown-item" href="/pages/authentication/lockscreen"><i class="mdi mdi-lock text-muted fs-lg align-middle me-1"></i> <span class="align-middle">Lock screen</span></a> -->
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="mdi mdi-logout text-muted fs-lg align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- removeNotificationModal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body p-md-5">
                <div class="text-center">
                    <div class="text-danger">
                        <i class="bi bi-trash display-4"></i>
                    </div>
                    <div class="mt-4 fs-base">
                        <h4 class="mb-1">Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- removeCartModal -->
<div id="removeCartModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-cartmodal"></button>
            </div>
            <div class="modal-body p-md-5">
                <div class="text-center">
                    <div class="text-danger">
                        <i class="bi bi-trash display-5"></i>
                    </div>
                    <div class="mt-4">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this product ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="remove-cartproduct">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@section('scripts')

@endsection
