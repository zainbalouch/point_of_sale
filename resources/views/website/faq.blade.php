@extends('layouts.app')

@section('content')
<!-- breadcrumb start -->
<section class="breadcrumb-section p-0 ratio_40">
    <img src="{{ asset('assets/images/slides/slide_1.jpg') }}" class="bg-img img-fluid" alt="">
</section>
<!-- breadcrumb end -->

<!-- section start -->
<section class="faq-section log-in">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="faq-questions">
                    <div class="title-3 text-start">
                        <h2>Frequently ask question</h2>
                    </div>
                    <div id="accordion" class="accordion">
                        <div class="card">
                            <div class="card-header">
                                <a class="card-link" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="true">
                                    Different types of housing tenure can be used for the same physical type.
                                </a>
                            </div>
                            <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
                                <div class="card-body">
                                    In markets where land and building prices are rising, real estate is often purchased as an investment, whether or not the owner intends to use the property.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-bs-toggle="collapse" href="#collapseTwo">
                                    Section 1.10.32 of "de Finibus Bonorum et Malorum", written by
                                </a>
                            </div>
                            <div id="collapseTwo" class="collapse" data-bs-parent="#accordion">
                                <div class="card-body">
                                    In markets where land and building prices are rising, real estate is often purchased as an investment, whether or not the owner intends to use the property.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-bs-toggle="collapse" href="#collapseThree">
                                    Different types of housing tenure can be used for the same physical type.
                                </a>
                            </div>
                            <div id="collapseThree" class="collapse" data-bs-parent="#accordion">
                                <div class="card-body">
                                    In markets where land and building prices are rising, real estate is often purchased as an investment, whether or not the owner intends to use the property. In markets where land and building prices are rising, real estate is often purchased as an investment, whether or not the owner intends to use the property.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <a class="card-link" data-bs-toggle="collapse" href="#collapseFour">
                                    Different types of housing tenure can be used for the same physical type.
                                </a>
                            </div>
                            <div id="collapseFour" class="collapse" data-bs-parent="#accordion">
                                <div class="card-body">
                                    In markets where land and building prices are rising, real estate is often purchased as an investment, whether or not the owner intends to use the property. In markets where land and building prices are rising, real estate is often purchased as an investment, whether or not the owner intends to use the property.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-bs-toggle="collapse" href="#collapseFive">
                                    Section 1.10.32 of "de Finibus Bonorum et Malorum", written
                                </a>
                            </div>
                            <div id="collapseFive" class="collapse" data-bs-parent="#accordion">
                                <div class="card-body">
                                    In markets where land and building prices are rising, real estate is often purchased as an investment, whether or not the owner intends to use the property.In markets where land and building prices are rising, real estate is often purchased as an investment, whether or not the owner intends to use the property.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-bs-toggle="collapse" href="#collapseSix">
                                    Different types of housing tenure can be used for the same physical type.
                                </a>
                            </div>
                            <div id="collapseSix" class="collapse" data-bs-parent="#accordion">
                                <div class="card-body">
                                    In markets where land and building prices are rising, real estate is often purchased as an investment, whether or not the owner intends to use the property.In markets where land and building prices are rising, real estate is often purchased as an investment, whether or not the owner intends to use the property.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- section end -->
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