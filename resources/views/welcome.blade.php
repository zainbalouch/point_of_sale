@extends('layouts.app')

@section('content')
<!-- property grid start -->
<section class="property-section pt-0 ratio_40">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 property-grid-3 p-0">
                <div class="property-box">
                    <div class="property-image">
                        <div class="property-slider">
                            <a href="javascript:void(0)">
                                <img src="{{ asset('assets/images/slides/slide_1.jpg') }}" class="bg-img" alt="">
                            </a>
                            <a href="javascript:void(0)">
                                <img src="{{ asset('assets/images/slides/slide_2.jpg') }}" class="bg-img" alt="">
                            </a>
                            <a href="javascript:void(0)">
                                <img src="{{ asset('assets/images/slides/slide_3.jpg') }}" class="bg-img" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- property grid end -->
@endsection

@section('scripts')
<script src="{{ asset('assets/js/custom-slick.js') }}"></script>
<!--grid js -->
<script src="{{ asset('assets/js/grid-list.js') }}"></script>

<!-- range slider js -->
<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/jquery.ui.touch-punch.min.js') }}"></script>
<script src="{{ asset('assets/js/range-slider.js') }}"></script>
@endsection
