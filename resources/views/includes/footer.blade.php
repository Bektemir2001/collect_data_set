<!-- Page footer -->
<section class="section-two-column parallax-container" data-parallax-img="{{asset('assets/images/parallax-1.jpg')}}">
    <div class="parallax-content">
        
        <div class="container context-dark text-lg-left">
            <div class="row justify-content-lg-end justify-content-center">
                <div class="google-map-container col-sm-12 col-lg-6">
                    {!! $department->google_map !!}
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="section-85">
                        <h6 style="color: #00506d; font-size: x-large;">contact us</h6>
                        <hr>
                        <div class="text-center text-lg-left" style="font-size: large;">
                            <address class="contact-info d-md-inline-block text-left">
                                <div class="p unit unit-spacing-xxs flex-row">
                                    <div class="unit-left"><span class="icon icon-xxs mdi mdi-phone"></span></div>
                                    <div class="unit-body"><a href="tel:{{ $department->phone }}">{{ $department->phone }}</a></div>
                                </div>
                                <div class="p unit flex-row unit-spacing-xxs">
                                    <div class="unit-left"><span class="icon icon-xxs mdi mdi-map-marker"></span></div>
                                    <div class="unit-body"><a href="{{ $department->address_link }}">{!! $department->address !!}</a></div>
                                </div>
                                <div class="p unit unit-spacing-xxs flex-row offset-top-16">
                                    <div class="unit-left"><span class="icon icon-xxs mdi mdi-email-outline"></span></div>
                                    <div class="unit-body"><a href="mailto:{{ $department->email }}">{{ $department->email }}</a></div>
                                </div>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Default footer-->
<footer class="section-relative section-34 section-md-50 page-footer bg-default context-light">
    <div class="container">
        <div class="inset-xxl-left-30">
            <div class="row justify-content-md-center">
                <div class="col-md-8 col-lg-12">
                    <div class="row justify-content-lg-between align-items-lg-center row-50">
                        <div class="col-lg-4 col-xl-3 order-lg-1 text-lg-left">
                            <!-- Footer brand-->
                            <div class="footer-brand d-inline-block"><a href="home/"><img width='179' height='52' class='img-responsive' src="{{asset('assets/images/dyce-logo.png')}}" alt="dyce-logo"/></a></div>
                        </div>
                        <div class="col-lg-4 col-xl-3 order-lg-3 text-lg-right">
                            <ul class="list-inline">
                                <li class="list-inline-item"><a class="icon fa fa-facebook icon-xxs icon-circle icon-gray-light" href="{{ $department->facebook_link }}"></a></li>
                                <li class="list-inline-item"><a class="icon icon-xxs mdi mdi-email-outline icon-circle icon-gray-light" href="mailto:{{ $department->email }}"></a></li>
                            </ul>
                        </div>
                        <div class="col-lg-4 col-xl-6 order-lg-2">
                            <p class="text-gray mb-0">&copy; <span class="copyright-year"></span> All Rights Reserved. <a class="text-gray" href="#">Privacy Policy</a> <span> Design&nbsp;by&nbsp;<a class="text-gray" href="https://zemez.io/">Zemez</a></span><br>
                            <a class="text-gray" href="https://www.vecteezy.com/free-vector/profile">Profile Vectors by Vecteezy</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
