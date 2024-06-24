@extends('layouts.app')

@section('content')
<!-- breadcrumb start -->
<section class="breadcrumb-section p-0 ratio_40">
    <img src="{{ asset('assets/images/slides/slide_1.jpg') }}" class="bg-img img-fluid" alt="">
</section>
<!-- breadcrumb end -->

<!-- Get in touch section start -->
<section class="small-section contact-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="log-in theme-card">
                    <div class="title-3 text-start">
                        <h2>Let's Get In Touch</h2>
                    </div>
                    <form class="row gx-3 get-in-touch">
                        <div class="form-group col-md-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i data-feather="user"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter your name" required="">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i data-feather="phone"></i>
                                    </div>
                                </div>
                                <input placeholder="phone number" class="form-control" name="mobnumber" id="tbNumbers" oninput="maxLengthCheck(this)" type="tel" onkeypress="javascript:return isNumber(event)" maxlength="9" required="">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i data-feather="mail"></i>
                                    </div>
                                </div>
                                <input type="email" class="form-control" placeholder="email address" required="">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="6">Write here something
                                </textarea>
                        </div>
                        <div class="col-md-12 submit-btn">
                            <button class="btn btn-gradient color-2 btn-pill" type="submit">Send Your Message</button>
                        </div>
                    </form>
                </div>
                <div class="theme-card">
                    <div class="contact-bottom">
                        <div class="contact-map">
                            <iframe title="Location" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d906.1122234390152!2d46.67386576968786!3d24.711464716919238!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e2f03b84fbeb5dd%3A0x9bbd76df896e6355!2z2KjYsdisINin2YTZhdmF2YTZg9ip!5e0!3m2!1sen!2sro!4v1719134815654!5m2!1sen!2sro" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 contact_section contact_right">
                <div class="row">
                    <div class="col-lg-12 col-sm-6">
                        <div class="contact_wrap">
                            <i data-feather="map-pin"></i>
                            <h4>Where ?</h4>
                            <p class="font-roboto">549 Sulphur Springs Road <br>
                                Downers Grove, IL 60515 <br>
                                +91 361264100
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6">
                        <div class="contact_wrap">
                            <i data-feather="map-pin"></i>
                            <h4>Second branch</h4>
                            <p class="font-roboto">5415 Spring garden Road <br>
                                Halifax, IL 97230 <br>
                                +91 187230014
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6">
                        <div class="contact_wrap">
                            <i data-feather="mail"></i>
                            <h4>Online service</h4>
                            <ul>
                                <li>Inquiries: sheltos@.in</li>
                                <li>Careers: hr@.in</li>
                                <li>Support: help@.in</li>
                                <li>+86 163 - 451 - 7894</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Get in touch section end -->
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