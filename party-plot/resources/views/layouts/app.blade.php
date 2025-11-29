<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('theme/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/jquery-ui.css') }}" rel="stylesheet">
    <!-- Bootstrap Icon CSS -->
    <link href="{{ asset('theme/assets/css/bootstrap-icons.css') }}" rel="stylesheet">
    <!-- CSS -->
    <link href="{{ asset('theme/assets/css/animate.min.css') }}" rel="stylesheet">
    <!-- FancyBox CSS -->
    <link href="{{ asset('theme/assets/css/jquery.fancybox.min.css') }}" rel="stylesheet">
    <!-- Nice Select CSS -->
    <link href="{{ asset('theme/assets/css/nice-select.css') }}" rel="stylesheet">
    <!-- Swiper slider CSS -->
    <link rel="stylesheet" href="{{ asset('theme/assets/css/swiper-bundle.min.css') }}">
    <!-- Slick slider CSS -->
    <link rel="stylesheet" href="{{ asset('theme/assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/assets/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/assets/css/daterangepicker.css') }}">
    <!-- BoxIcon  CSS -->
    <link href="{{ asset('theme/assets/css/boxicons.min.css') }}" rel="stylesheet">
    <!--  Style CSS  -->
    <link rel="stylesheet" href="{{ asset('theme/assets/css/style.css') }}">
    <!-- Title -->
    <title>@yield('title', 'Party Plot Listing Platform')</title>
    <link rel="icon" href="{{ asset('theme/assets/img/fav-icon.svg') }}" type="image/gif" sizes="20x20">

    @stack('styles')
</head>

<body class="tt-magic-cursor">

    <div id="magic-cursor">
        <div id="ball"></div>
    </div>

    <!-- Back To Top -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
        </svg>
        <svg class="arrow" width="22" height="25" viewBox="0 0 24 23" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M0.556131 11.4439L11.8139 0.186067L13.9214 2.29352L13.9422 20.6852L9.70638 20.7061L9.76793 8.22168L3.6064 14.4941L0.556131 11.4439Z"/>
            <path d="M23.1276 11.4999L16.0288 4.40105L15.9991 10.4203L20.1031 14.5243L23.1276 11.4999Z"/>
        </svg>
    </div>

    <!-- Header Section -->
    @include('components.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer Section -->
    @include('components.footer')

    <!--  Main jQuery  -->
    <script data-cfasync="false" src="{{ asset('cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('theme/assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/daterangepicker.min.js') }}"></script>

    <!-- Popper and Bootstrap JS -->
    <script src="{{ asset('theme/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/popper.min.js') }}"></script>
    <!-- Swiper slider JS -->
    <script src="{{ asset('theme/assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/slick.js') }}"></script>
    <!-- Waypoints JS -->
    <script src="{{ asset('theme/assets/js/waypoints.min.js') }}"></script>
    <!-- Counterup JS -->
    <script src="{{ asset('theme/assets/js/jquery.counterup.min.js') }}"></script>
    <!-- Nice Select JS -->
    <script src="{{ asset('theme/assets/js/jquery.nice-select.min.js') }}"></script>
    <!-- Wow JS -->
    <script src="{{ asset('theme/assets/js/wow.min.js') }}"></script>
    <!-- Gsap  JS -->
    <script src="{{ asset('theme/assets/js/gsap.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/ScrollTrigger.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/jquery.fancybox.min.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('theme/assets/js/select-dropdown.js') }}"></script>
    <script src="{{ asset('theme/assets/js/custom.js') }}"></script>

    @stack('scripts')
</body>

</html>



