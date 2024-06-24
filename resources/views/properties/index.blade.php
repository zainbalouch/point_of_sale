@extends('layouts.app')


@section('styles')
<!--  map css  -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/leaflet.css') }}">

<style>
    .slick-slide img {
        width: 100%;
    }

    .price-label {
        display: inline-block;
        width: auto;
        /* Ensures the width fits the content */
        text-align: center;
        white-space: nowrap;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 2px 5px;
        border-radius: 3px;
    }

    .spinner {
        display: none;
        /* Hidden by default */
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #f13439;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        position: relative;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        z-index: 410;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .loading {
        display: block;
    }
</style>
@endsection

@section('content')
<!-- property grid start -->
<section class="property-section section-sm">
    <div class="container-fluid">
        <div class="row ratio_70 property-grid-2 property-map">
            <div class="col-12">
                <div class="filter-panel">
                    <div class="top-panel">
                        <div>
                            <h2>Properties Listing</h2>
                            <span class="show-result">Showing <span>1-15 of 69</span> Listings</span>
                        </div>
                        <ul class="grid-list-filter">
                            <li>
                                <div class="filter-bottom-title">
                                    <h6 class="mb-0 font-roboto">Advanced search <i data-feather="align-center" class="float-end ms-2"></i></h6>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown">
                                    <span class="dropdown-toggle font-rubik" data-bs-toggle="dropdown"><span>Sort by
                                            Newest</span> <i class="fas fa-angle-down ms-lg-3 ms-2"></i></span>
                                    <div class="dropdown-menu text-start">
                                        <a class="dropdown-item" href="javascript:void(0)">Sort by Newest</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Sort by Oldest</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Sory by featured</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Sort by price (Low to
                                            high)</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="left-sidebar filter-bottom-content">
                    <h6 class="d-lg-none d-block text-end"><a href="javascript:void(0)" class="close-filter-bottom">Close filter</a></h6>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="dropdown">
                                <span class="dropdown-toggle font-rubik" data-bs-toggle="dropdown"><span>Property
                                        Status</span> <i class="fas fa-angle-down"></i></span>
                                <div class="dropdown-menu text-start">
                                    <a class="dropdown-item" href="javascript:void(0)">Property Status</a>
                                    <a class="dropdown-item" href="javascript:void(0)">For Rent</a>
                                    <a class="dropdown-item" href="javascript:void(0)">For Sale</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="dropdown">
                                <span class="dropdown-toggle font-rubik" data-bs-toggle="dropdown"><span>Property
                                        Type</span> <i class="fas fa-angle-down"></i></span>
                                <div class="dropdown-menu text-start">
                                    <a class="dropdown-item" href="javascript:void(0)">Property Type</a>
                                    <a class="dropdown-item" href="javascript:void(0)">Apartment</a>
                                    <a class="dropdown-item" href="javascript:void(0)">Family House</a>
                                    <a class="dropdown-item" href="javascript:void(0)">Cottage</a>
                                    <a class="dropdown-item" href="javascript:void(0)">Condominium</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="dropdown">
                                <span class="dropdown-toggle font-rubik" data-bs-toggle="dropdown"><span>Property
                                        Location</span> <i class="fas fa-angle-down"></i></span>
                                <div class="dropdown-menu text-start">
                                    <a class="dropdown-item" href="javascript:void(0)">Property Location</a>
                                    <a class="dropdown-item" href="javascript:void(0)">Austria</a>
                                    <a class="dropdown-item" href="javascript:void(0)">Brazil</a>
                                    <a class="dropdown-item" href="javascript:void(0)">New york</a>
                                    <a class="dropdown-item" href="javascript:void(0)">USA</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="dropdown">
                                <span class="dropdown-toggle font-rubik" data-bs-toggle="dropdown"><span>Max
                                        Rooms</span> <i class="fas fa-angle-down"></i></span>
                                <div class="dropdown-menu text-start">
                                    <a class="dropdown-item" href="javascript:void(0)">Max Rooms</a>
                                    <a class="dropdown-item" href="javascript:void(0)">1</a>
                                    <a class="dropdown-item" href="javascript:void(0)">2</a>
                                    <a class="dropdown-item" href="javascript:void(0)">3</a>
                                    <a class="dropdown-item" href="javascript:void(0)">4</a>
                                    <a class="dropdown-item" href="javascript:void(0)">5</a>
                                    <a class="dropdown-item" href="javascript:void(0)">6</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="dropdown">
                                <span class="dropdown-toggle font-rubik" data-bs-toggle="dropdown"><span>Bed</span> <i class="fas fa-angle-down"></i></span>
                                <div class="dropdown-menu text-start">
                                    <a class="dropdown-item" href="javascript:void(0)">Bed</a>
                                    <a class="dropdown-item" href="javascript:void(0)">1</a>
                                    <a class="dropdown-item" href="javascript:void(0)">2</a>
                                    <a class="dropdown-item" href="javascript:void(0)">3</a>
                                    <a class="dropdown-item" href="javascript:void(0)">4</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="dropdown">
                                <span class="dropdown-toggle font-rubik" data-bs-toggle="dropdown"><span>Bath</span> <i class="fas fa-angle-down"></i></span>
                                <div class="dropdown-menu text-start">
                                    <a class="dropdown-item" href="javascript:void(0)">Bath</a>
                                    <a class="dropdown-item" href="javascript:void(0)">1</a>
                                    <a class="dropdown-item" href="javascript:void(0)">2</a>
                                    <a class="dropdown-item" href="javascript:void(0)">3</a>
                                    <a class="dropdown-item" href="javascript:void(0)">4</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="dropdown">
                                <span class="dropdown-toggle font-rubik" data-bs-toggle="dropdown"><span>Agencies</span> <i class="fas fa-angle-down"></i></span>
                                <div class="dropdown-menu text-start">
                                    <a class="dropdown-item" href="javascript:void(0)">Agencies</a>
                                    <a class="dropdown-item" href="javascript:void(0)">Lincoln</a>
                                    <a class="dropdown-item" href="javascript:void(0)">Blue Sky</a>
                                    <a class="dropdown-item" href="javascript:void(0)">Zephyr</a>
                                    <a class="dropdown-item" href="javascript:void(0)">Premiere</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="price-range">
                                <label for="amount">Price : </label>
                                <input type="text" id="amount" readonly>
                                <div id="slider-range" class="theme-range-2"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="price-range">
                                <label for="amount">Area : </label>
                                <input type="text" id="amount1" readonly>
                                <div id="slider-range1" class="theme-range-2"></div>
                            </div>
                        </div>
                        <div class="col-12 text-end">
                            <a href="javascript:void(0)" class="mt-3 btn btn-gradient color-2 btn-pill">Search Property</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 order-2 order-xxl-1">
                <div id="propertySpinner" class="spinner"></div>
                <div class="property-2 row column-sm property-label property-grid">

                </div>
                <nav class="theme-pagination"></nav>
            </div>
            <div class="col-xl-6 order-1 order-xxl-2  map-section">
                <div class="map" id="mapleaf">
                    <div id="mapSpinner" class="spinner"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- property grid end -->
@endsection

@section('scripts')

<!-- map js -->
<script src="{{ asset('assets/js/map/leaflet.js') }}"></script>
<script src="{{ asset('assets/js/map/leaflet-info.js') }}"></script>

<!--grid js -->
<!-- <script src="{{ asset('assets/js/grid-list.js') }}"></script> -->

<!-- range slider js -->
<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/jquery.ui.touch-punch.min.js') }}"></script>
<script src="{{ asset('assets/js/range-slider.js') }}"></script>
@endsection