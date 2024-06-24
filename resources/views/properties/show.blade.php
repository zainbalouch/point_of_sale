@extends('layouts.app')

@section('styles')
<!--  map css  -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/leaflet.css') }}">

<style>
    #mapleaf {
        height: 400px;
    }

    .leaflet-touch .leaflet-control-layers, .leaflet-touch .leaflet-bar {
        z-index: 999;
    }
</style>
@endsection

@section('content')
<!-- single property header start -->
<section class="without-top property-main small-section">
    <div class="single-property-section">
        <div class="container">
            <div class="single-title">
                <div class="left-single">
                    <div class="d-flex">
                        <h2 class="mb-0">Orchard House </h2>
                        <span><span class="label label-shadow ms-2">For
                                Sale</span></span>
                    </div>
                    <p class="mt-1">Mina Road, Bur Dubai, Dubai, United
                        Arab
                        Emirates</p>
                    <ul>
                        <li>
                            <div>
                                <img src="{{ asset('assets/images/svg/icon/double-bed.svg') }}" class="img-fluid" alt="">
                                <span>4 Bedrooms</span>
                            </div>
                        </li>
                        <li>
                            <div>
                                <img src="{{ asset('assets/images/svg/icon/bathroom.svg') }}" class="img-fluid" alt="">
                                <span>4 Bathrooms</span>
                            </div>
                        </li>
                        <li>
                            <div>
                                <img src="{{ asset('assets/images/svg/icon/sofa.svg') }}" class="img-fluid" alt="">
                                <span>2 Halls</span>
                            </div>
                        </li>
                        <li>
                            <div>
                                <img src="{{ asset('assets/images/svg/icon/square-ruler-tool.svg') }}" class="img-fluid ruler-tool" alt="">
                                <span>5000 Sq ft</span>
                            </div>
                        </li>
                        <li>
                            <div>
                                <img src="{{ asset('assets/images/svg/icon/garage.svg') }}" class="img-fluid" alt="">
                                <span>1 Garage</span>
                            </div>
                        </li>
                    </ul>
                    <div class="share-buttons">
                        <div class="d-inline-block">
                            <a href="javascript:void(0)" class="btn btn-gradient btn-pill color-2"><i class="far fa-share-square"></i>
                                share
                            </a>
                            <div class="share-hover">
                                <ul>
                                    <li>
                                        <a href="https://www.facebook.com/" class="icon-facebook"><i data-feather="facebook"></i></a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/" class="icon-twitter"><i data-feather="twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/" class="icon-instagram"><i data-feather="instagram"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-dashed btn-pill color-2 ms-md-2 ms-1 save-btn"><i class="far fa-heart"></i>
                            Save</a>
                        <a href="javascript:void(0)" class="btn btn-dashed btn-pill color-2 ms-md-2 ms-1" onclick="myFunction()"><i data-feather="printer"></i>
                            Print</a>
                    </div>
                </div>
                <div class="right-single">
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <h2 class="price">$20,45,472 <span>/ start From</span></h2>
                    <div class="feature-label">
                        <span class="btn btn-dashed color-2 btn-pill">Wi-fi</span>
                        <span class="btn btn-dashed color-2 ms-1 btn-pill">Swimming Pool</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- single property header end -->

<!-- single property start -->
<section class="single-property mt-0 pt-0">
    <div class="container">
        <div class="row ratio_55">
            <div class="col-xl-9 col-lg-8">
                <div class="description-section tab-description">
                    <div class="description-details">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="single-gallery mb-4">
                                    <div class="gallery-for">
                                        <div>
                                            <div class="bg-size">
                                                <img src="{{ asset('assets/images/property/4.jpg') }}" class="bg-img" alt="">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="bg-size">
                                                <img src="{{ asset('assets/images/property/3.jpg') }}" class="bg-img" alt="">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="bg-size">
                                                <img src="{{ asset('assets/images/property/14.jpg') }}" class="bg-img" alt="">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="bg-size">
                                                <img src="{{ asset('assets/images/property/11.jpg') }}" class="bg-img" alt="">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="bg-size">
                                                <img src="{{ asset('assets/images/property/12.jpg') }}" class="bg-img" alt="">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="bg-size">
                                                <img src="{{ asset('assets/images/property/4.jpg') }}" class="bg-img" alt="">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="bg-size">
                                                <img src="{{ asset('assets/images/property/3.jpg') }}" class="bg-img" alt="">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="bg-size">
                                                <img src="{{ asset('assets/images/property/11.jpg') }}" class="bg-img" alt="">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="bg-size">
                                                <img src="{{ asset('assets/images/property/12.jpg') }}" class="bg-img" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gallery-nav">
                                        <div>
                                            <img src="{{ asset('assets/images/property/4.jpg') }}" class="img-fluid" alt="">
                                        </div>
                                        <div>
                                            <img src="{{ asset('assets/images/property/3.jpg') }}" class="img-fluid" alt="">
                                        </div>
                                        <div>
                                            <img src="{{ asset('assets/images/property/14.jpg') }}" class="img-fluid" alt="">
                                        </div>
                                        <div>
                                            <img src="{{ asset('assets/images/property/11.jpg') }}" class="img-fluid" alt="">
                                        </div>
                                        <div>
                                            <img src="{{ asset('assets/images/property/12.jpg') }}" class="img-fluid" alt="">
                                        </div>
                                        <div>
                                            <img src="{{ asset('assets/images/property/4.jpg') }}" class="img-fluid" alt="">
                                        </div>
                                        <div>
                                            <img src="{{ asset('assets/images/property/3.jpg') }}" class="img-fluid" alt="">
                                        </div>
                                        <div>
                                            <img src="{{ asset('assets/images/property/11.jpg') }}" class="img-fluid" alt="">
                                        </div>
                                        <div>
                                            <img src="{{ asset('assets/images/property/12.jpg') }}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="desc-box">
                            <ul class="nav nav-tabs line-tab" id="top-tab" role="tablist">
                                <li class="nav-item"><a data-bs-toggle="tab" class="nav-link active" href="#about">about</a></li>
                                <li class="nav-item"><a data-bs-toggle="tab" class="nav-link" href="#feature">feature</a></li>
                                <li class="nav-item"><a data-bs-toggle="tab" class="nav-link" href="#video">video</a>
                                </li>
                                <li class="nav-item"><a data-bs-toggle="tab" class="nav-link" href="#floor_plan">Floor
                                        plan</a></li>
                            </ul>
                            <div class=" tab-content" id="top-tabContent">
                                <div class="tab-pane fade show active about page-section" id="about">
                                    <h4 class="content-title">Property Details</h4>
                                    <div class="row">
                                        <div class="col-md-6 col-xl-4">
                                            <ul class="property-list-details">
                                                <li><span>Property Type :</span> House</li>
                                                <li><span>Property ID :</span> ZOEA245</li>
                                                <li><span>Property status :</span> For sale</li>
                                                <li><span>Operating Since :</span> 2008</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6 col-xl-4">
                                            <ul class="property-list-details">
                                                <li><span>Price :</span> $ 1,50,000</li>
                                                <li><span>Property Size :</span> 1730 sq / ft</li>
                                                <li><span>Balcony :</span> 2</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6 col-xl-4">
                                            <ul class="property-list-details">
                                                <li><span>City :</span> Newyork</li>
                                                <li><span>Bedrooms :</span> 8</li>
                                                <li><span>Bathrooms :</span> 4</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <h4 class="content-title mt-4">Attachments</h4>
                                    <a href="javascript:void(0)" class="attach-file"><i class="far fa-file-pdf"></i>Demo Property
                                        Document </a>
                                    <h4 class="mt-4">Property Brief</h4>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <p class="font-roboto">Residences can be classified by and how they are connected residences and land. Different types
                                                of housing tenure can be used for the same physical type.</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="font-roboto">Connected residences owned by a single entity leased out, or owned separately with an agreement covering the relationship between units and common areas.</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="font-roboto">Residential real estate may contain either a single family or multifamily structure that is available for occupation or
                                                for non-business purposes.</p>
                                        </div>
                                    </div>
                                    <h4 class="mt-4">Location on the</h4>
                                    <div class="map" id="mapleaf"></div>
                                </div>
                                <div class="tab-pane fade page-section" id="feature">
                                    <h4 class="content-title">features</h4>
                                    <div class="single-feature row">
                                        <div class="col-xl-3 col-6">
                                            <ul>
                                                <li>
                                                    <i class="fas fa-wifi"></i> Free Wi-Fi
                                                </li>
                                                <li>
                                                    <i class="fas fa-hands"></i> Elevator Lift
                                                </li>
                                                <li>
                                                    <i class="fas fa-power-off"></i> Power Backup
                                                </li>
                                                <li>
                                                    <i class="fas fa-monument"></i> Laundry Service
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-xl-3 col-6">
                                            <ul>
                                                <li>
                                                    <i class="fas fa-user-shield"></i> Security Guard
                                                </li>
                                                <li>
                                                    <i class="fas fa-video"></i> CCTV
                                                </li>
                                                <li>
                                                    <i class="fas fa-door-open"></i> Emergency Exit
                                                </li>
                                                <li>
                                                    <i class="fas fa-first-aid"></i> Doctor On Call
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-xl-3 col-6">
                                            <ul>
                                                <li>
                                                    <i class="fas fa-shower"></i> Shower
                                                </li>
                                                <li>
                                                    <i class="fas fa-car"></i> free Parking in the area
                                                </li>
                                                <li>
                                                    <i class="fas fa-fan"></i> Air Conditioning
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade page-section ratio3_2" id="gallery">
                                    <h4 class="content-title">gallery</h4>
                                </div>
                                <div class="tab-pane fade page-section ratio_40" id="video">
                                    <h4 class="content-title">video</h4>
                                    <div class="play-bg-image">
                                        <div class="bg-size">
                                            <img src="{{ asset('assets/images/property/11.jpg') }}" class="bg-img" alt="">
                                        </div>
                                        <div class="icon-video">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#videomodal">
                                                <i class="fas fa-play"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade page-section" id="floor_plan">
                                    <h4 class="content-title">Floor plan</h4>
                                    <img src="{{ asset('assets/images/single-property/floor-plan.png') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="desc-box">
                            <div class="page-section">
                                <h4 class="content-title">Reviews</h4>
                                <div class="review">
                                    <div class="review-box">
                                        <div class="media">
                                            <img src="{{ asset('assets/images/avatar/3.jpg') }}" class="img-70" alt="">
                                            <div class="media-body">
                                                <h6>Olive Yew</h6>
                                                <p>Sep 13, 2022</p>
                                                <p class="mb-0">The location, view from the rooms are just awesome. Very cool landscaping has been done Around the hotel.
                                                    There are small activities that you can indulge with your family.</p>
                                            </div>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-box review-child">
                                        <div class="media">
                                            <img src="{{ asset('assets/images/avatar/4.jpg') }}" class="img-70" alt="">
                                            <div class="media-body">
                                                <h6>Allie Grater</h6>
                                                <p>Sep 25, 2022</p>
                                                <p class="mb-0">We were there for 3 nights and hotel was too good. Greenery was flaunting everywhere. There were games kept for our
                                                    entertainment.</p>
                                            </div>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="media">
                                            <img src="{{ asset('assets/images/avatar/2.jpg') }}" class="img-70" alt="">
                                            <div class="media-body">
                                                <h6>Walter Melon</h6>
                                                <p>Oct 20, 2022</p>
                                                <p class="mb-0">There are small activities that you can indulge with your family. Very cool landscaping has been done Around the hotel. The location, view from the rooms are just awesome.</p>
                                            </div>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <h4 class="content-title">Write a Review</h4>
                                <form class="review-form">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Name" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Email" required>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" placeholder="Comment"></textarea>
                                    </div>
                                    <button type="submit" onclick="document.location='submit-property.html'" class="btn btn-gradient color-2 btn-pill">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4">
                <div class="left-sidebar sticky-cls single-sidebar">
                    <div class="filter-cards">
                        <div class="advance-card">
                            <h6>Contact Info</h6>
                            <div class="category-property">
                                <div class="agent-info">
                                    <div class="media">
                                        <img src="{{ asset('assets/images/testimonial/3.png') }}" class="img-50" alt="">
                                        <div class="media-body ms-2">
                                            <h6>Jonathan Scott</h6>
                                            <p>Contact@gmail.com</p>
                                        </div>
                                    </div>
                                </div>
                                <ul>
                                    <li>
                                        <i data-feather="map-pin" class="me-2"></i>A-32, Albany, Newyork.
                                    </li>
                                    <li>
                                        <i data-feather="phone-call" class="me-2"></i>(+066) 518 - 457 - 5181
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="advance-card">
                            <h6>Request exploration</h6>
                            <div class="category-property">
                            @include('layouts.partials._errors')
                                <form action="{{ route('reservations.store') }}" method="POST">
                                    @csrf
                                    <!-- <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Your Name" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Email Address" required>
                                    </div>
                                    <div class="form-group">
                                        <input placeholder="phone number" class="form-control" name="mobnumber" id="tbNumbers" oninput="maxLengthCheck(this)" type="tel" onkeypress="javascript:return isNumber(event)" maxlength="9" required="">
                                    </div>
                                    <div class="form-group">
                                        <textarea placeholder="Message" class="form-control" rows="3"></textarea>
                                    </div> -->
                                    <input type="hidden" name="property_id" value="{{ $property->id }}">
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="check_in" value="{{ now() }}">
                                    <input type="hidden" name="check_out" value="{{ now() }}">
                                    <input type="hidden" name="guests[adults]" value="1">
                                    <input type="hidden" name="guests[children]" value="1">
                                    <input type="hidden" name="guests[infants]" value="1">
                                    <input type="hidden" name="guests[pets]" value="1">
                                    <input type="hidden" name="total_price" value="10000">
                                    <input type="hidden" name="cleaning_fee" value="2500">
                                    <input type="hidden" name="service_fee" value="500">
                                    <input type="hidden" name="currency_id" value="1">
                                    <input type="hidden" name="special_request" value="Please change the towels">
                                    <button type="submit" class="btn btn-gradient color-2 btn-block btn-pill">Submit
                                        Request</button>
                                </form>
                            </div>
                        </div>
                        <div class="advance-card">
                            <h6>Mortgage</h6>
                            <div class="category-property">
                                <form>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" placeholder="Loan Amount" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" placeholder="Down Payment" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">%</span>
                                        <input type="number" class="form-control" placeholder="Rate of Interest" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" placeholder="Number Of years" required>
                                    </div>
                                    <button type="submit" class="btn btn-gradient color-2 btn-block btn-pill">Calculate</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- single property end -->
@endsection

@section('scripts')
<!-- map js -->
<script src="{{ asset('assets/js/map/leaflet.js') }}"></script>

<script src="{{ asset('assets/js/custom-slick.js') }}"></script>
<!--grid js -->
<script src="{{ asset('assets/js/grid-list.js') }}"></script>

<!-- range slider js -->
<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/jquery.ui.touch-punch.min.js') }}"></script>
<script src="{{ asset('assets/js/range-slider.js') }}"></script>

<script>
    var map;
    var propertyCoordinates = [{{ $property->latitude }}, {{ $property->longitude }}];

    function initMap() {
        map = L.map('mapleaf').setView(propertyCoordinates, 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker(propertyCoordinates).addTo(map);
    }

    document.addEventListener("DOMContentLoaded", function() {
        initMap();
    });
</script>
@endsection