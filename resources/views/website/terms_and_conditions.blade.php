@extends('layouts.app')

@section('content')
<!-- breadcrumb start -->
<section class="breadcrumb-section p-0 ratio_40">
    <img src="{{ asset('assets/images/slides/slide_1.jpg') }}" class="bg-img img-fluid" alt="">
</section>
<!-- breadcrumb end -->

<!-- section start -->
<section class="user-dashboard terms-section">
    <div class="container">
        <div class="row log-in">
            <div class="col-xl-12 col-lg-8 col-12">
                <div class="theme-card">
                    <h2>Terms & Conditions</h2>
                    <div class="terms-wrap">
                        <div class="terms-wrapper" id="intro">
                            <h4>Introduction</h4>
                            <p>These Website Standard Terms and Conditions written on this webpage shall manage your use of our website, Sheltos accessible at sheltos.com.</p>
                            <p>These Terms will be applied fully and affect to your use of this Website. By using this Website, you agreed to accept all terms and conditions written in here. You must not use this Website if you disagree with any of these Website Standard Terms and Conditions.</p>
                        </div>
                        <div class="terms-wrapper" id="restriction">
                            <h4>Restrictions</h4>
                            <p>You are specifically restricted from all of the following:</p>
                            <ul>
                                <li>
                                    selling, sublicensing and/or otherwise commercializing any Website material;
                                </li>
                                <li>
                                    publishing any Website material in any other media;
                                </li>
                                <li>
                                    using this Website in any way that is or may be damaging to this Website;
                                </li>
                                <li>
                                    using this Website to engage in any advertising or marketing.
                                </li>
                            </ul>
                        </div>
                        <div class="terms-wrapper" id="limitation">
                            <h4>Limitation of liability</h4>
                            <p>In no event shall Pixelstrap, nor any of its officers, directors and employees, shall be held liable for anything arising out of or in any way connected with your use of this Website whether such liability is under contract. Pixelstrap, including its officers, directors and employees shall not be held liable for any indirect, consequential or special liability arising out of or in any way related to your use of this Website.</p>
                        </div>
                        <div class="terms-wrapper" id="reservation">
                            <h4>Reservation of Rights</h4>
                            <p>We reserve the right to request that you remove all links or any particular link to our Website. You approve to immediately remove all links to our Website upon request. We also reserve the right to amen these terms and conditions and it's linking policy at any time. By continuously linking to our Website, you agree to be bound to and follow these linking terms and conditions.</p>
                        </div>
                        <div class="terms-wrapper" id="disclaimer">
                            <h4>Disclaimer</h4>
                            <p>The limitations and prohibitions of liability set in this Section and elsewhere in this disclaimer: (a) are subject to the preceding paragraph; and (b) govern all liabilities arising under the disclaimer, including liabilities arising in contract, in tort and for breach of statutory duty.</p>
                            <p>As long as the website and the information and services on the website are provided free of charge, we will not be liable for any loss or damage of any nature.</p>
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