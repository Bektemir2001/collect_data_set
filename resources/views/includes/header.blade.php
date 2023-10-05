<header class="page-head">
    <!-- RD Navbar Transparent-->
    <div class="rd-navbar-wrap">
        <nav class="rd-navbar rd-navbar-minimal rd-navbar-light" data-layout="rd-navbar-fixed" data-sm-device-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-lg-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-fixed" data-xl-device-layout="rd-navbar-static" data-xl-layout="rd-navbar-static" data-lg-auto-height="true" data-lg-stick-up="true">
            <div class="rd-navbar-inner">
                <div class="rd-navbar-top-panel">
                    <address class="contact-info d-md-inline-block text-left offset-none">
                        <div class="p unit unit-spacing-xs flex-row">
                            <div class="unit-left"><span class="icon icon-xs icon-circle icon-gray-light mdi mdi-phone text-primary"></span></div>
                            @if ($department->mobile == null)
                                <div class="unit-body"><a class="text-gray-darker" href="tel:{{ $department->phone }}">{{ $department->phone }}</a></div>    
                            @else
                                <div class="unit-body">
                                    <a class="text-gray-darker" href="tel:{{ $department->phone }}">{{ $department->phone }}</a> <br>
                                    <a class="text-gray-darker" href="tel:{{ $department->mobile }}">{{ $department->mobile }}</a>
                                </div>
                            @endif
                            
                        </div>
                    </address>
                    <!--Navbar Brand-->
                    <div class="rd-navbar-brand d-none d-lg-inline-block"><a href="home"><img width='179' height='52' class='img-responsive' src=" {{ asset('assets/images/dyce-logo.png') }} " alt=''/></a></div>
                    <address class="contact-info d-md-inline-block text-left offset-top-10 offset-md-top-0">
                        <div class="p unit flex-row unit-spacing-xs">
                            <div class="unit-left"><span class="icon icon-xs icon-circle icon-gray-light mdi mdi-map-marker text-primary"></span></div>
                            <div class="unit-body"><a class="text-gray-darker" href="{{ $department->address_link }}">{!! $department->address !!}</a></div>
                        </div>
                    </address>
                </div>
                <!-- RD Navbar Panel-->
                <div class="rd-navbar-panel">
                    <!-- RD Navbar Toggle-->
                    <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar, .rd-navbar-nav-wrap"><span></span></button>
                    <!--Navbar Brand-->
                    <div class="rd-navbar-brand d-xl-none"><a href="home"><img width='179' height='52' class='img-responsive' src='{{asset('assets/images/dyce-logo.png')}}' alt=''/></a></div>
                    <button class="rd-navbar-top-panel-toggle" data-rd-navbar-toggle=".rd-navbar, .rd-navbar-top-panel"><span></span></button>
                </div>
                <div class="rd-navbar-menu-wrap">
                    <div class="rd-navbar-nav-wrap">
                        <div class="rd-navbar-mobile-scroll">
                            <!--Navbar Brand Mobile-->
                            <div class="rd-navbar-mobile-brand"><a href="home"><img width='179' height='52' class='img-responsive' src='{{asset('assets/images/dyce-logo.png')}}' alt=''/></a></div>
                            <!-- RD Navbar Nav-->
                            <ul class="rd-navbar-nav">
                                {!! $menu !!}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!--Swiper-->

</header>
