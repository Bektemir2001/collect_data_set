<!DOCTYPE html>
<html class="wide wow-animation smoothscroll scrollTo" lang="en">
<head>
    <!-- Site Title-->
    @yield('title')
    <meta charset="utf-8">
    <meta property="og:site_name" content="YOUR DENTIST">
    <meta property="og:title" content="YOUR DENTIST">
    <meta property="og:url" content="https://www.dentistzone.co.uk">
    <meta property="og:type" content="website">
    <meta property="og:description" content="Modern dental practice offering routine and advanced dentistry. Restorative procedures. Endodontics. Improve your smile with Invisalign®. Cosmetic dentistry and facial aesthetics (wrinkle treatments, dermal fillers, lip fillers).">
    <meta property="og:image" content="http://static1.squarespace.com/static/5fef220856736819c1d47a47/t/5fef221156736819c1d47b2d/1571238018478/AdobeStock_246187812.jpeg?format=1500w">
    <meta property="og:image:width" content="1472">
    <meta property="og:image:height" content="615">
    <meta itemprop="name" content="YOUR DENTIST">
    <meta itemprop="url" content="https://www.dentistzone.co.uk">
    <meta itemprop="description" content="Modern dental practice offering routine and advanced dentistry. Restorative procedures. Endodontics. Improve your smile with Invisalign®. Cosmetic dentistry and facial aesthetics (wrinkle treatments, dermal fillers, lip fillers).">
    <meta itemprop="thumbnailUrl" content="http://static1.squarespace.com/static/5fef220856736819c1d47a47/t/5fef221156736819c1d47b2d/1571238018478/AdobeStock_246187812.jpeg?format=1500w">
    <link rel="image_src" href="http://static1.squarespace.com/static/5fef220856736819c1d47a47/t/5fef221156736819c1d47b2d/1571238018478/AdobeStock_246187812.jpeg?format=1500w">
    <meta itemprop="image" content="http://static1.squarespace.com/static/5fef220856736819c1d47a47/t/5fef221156736819c1d47b2d/1571238018478/AdobeStock_246187812.jpeg?format=1500w">
    <meta name="twitter:title" content="YOUR DENTIST">
    <meta name="twitter:image" content="http://static1.squarespace.com/static/5fef220856736819c1d47a47/t/5fef221156736819c1d47b2d/1571238018478/AdobeStock_246187812.jpeg?format=1500w">
    <meta name="twitter:url" content="https://www.dentistzone.co.uk">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:description" content="Modern dental practice offering routine and advanced dentistry. Restorative procedures. Endodontics. Improve your smile with Invisalign®. Cosmetic dentistry and facial aesthetics (wrinkle treatments, dermal fillers, lip fillers).">
    <meta name="description" content="Modern dental practice offering routine and advanced dentistry. Restorative
procedures. Endodontics. Improve your smile with Invisalign®. Cosmetic
dentistry and facial aesthetics (wrinkle treatments, dermal fillers, lip
fillers).">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="keywords" content="SANA design multipurpose template">
    <meta name="date" content="Dec 26">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">


    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Oswald%7CLato:400italic,400,700%7CSignika:400,600">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <head>
        <!-- Подключение стилей Leaflet -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />

        <!-- Подключение скриптов Leaflet -->
        <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
    </head>

    <style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>

    {{-- {!! $department->google_analitics !!} --}}
</head>
<body>
<div class="ie-panel"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="{{asset('assets/images/ie8-panel/warning_bar_0000_us.jpg')}}" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
<div class="preloader">
    <div class="preloader-body">
        <div class="cssload-container">
            <div class="cssload-speeding-wheel"></div>
        </div>
        <p>Loading...</p>
    </div>
</div>
<!-- Page-->
<div class="page text-center">
    <!-- Page Header-->
    @include('includes.header')
    <!-- Page content -->
    @yield('content')
    <!-- Footer -->
    @include('includes.notification')
    @include('includes.footer')
</div>
<!-- Global Mailform Output-->
<div class="snackbars" id="form-output-global"> </div>

<script src="{{asset('assets/js/core.min.js')}}"></script>
<script src="{{asset('assets/js/script.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
