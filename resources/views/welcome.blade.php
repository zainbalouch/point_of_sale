@extends('layouts.app')

@section('content')
<!-- property grid start -->
<section class="property-section pt-0 ratio_40">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 property-grid-3 p-0">
                <h1>Welcome to Invoice Manager</h1>
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
