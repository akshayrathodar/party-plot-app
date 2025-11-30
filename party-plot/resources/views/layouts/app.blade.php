<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Party Plot Listing Platform')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('theme/assets/img/fav-icon.svg') }}" type="image/gif" sizes="20x20">

    <!-- CSS Files -->
    <link href="{{ asset('theme/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/boxicons.min.css') }}" rel="stylesheet">
    <!-- Font Awesome 7.0.1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/fontawesome.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/solid.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('theme/assets/css/calendar-css.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/daterangepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/dropzone.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/jquery.fancybox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/leaflet.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/nice-select.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/swiper-bundle.min.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>
    @include('components.header')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    <!-- JavaScript Files -->
    <script src="{{ asset('theme/assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('theme/assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/custom-calendar.js') }}"></script>
    <script src="{{ asset('theme/assets/js/custom-range-calendar.js') }}"></script>
    <script src="{{ asset('theme/assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/select-dropdown.js') }}"></script>
    <script src="{{ asset('theme/assets/js/slick.js') }}"></script>
    <script src="{{ asset('theme/assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/leaflet.js') }}"></script>
    <script src="{{ asset('theme/assets/js/range-slider.js') }}"></script>
    <script src="{{ asset('theme/assets/js/dropzone-min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/gsap.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/ScrollTrigger.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/helper.js') }}"></script>
    <script src="{{ asset('theme/assets/js/custom.js') }}"></script>

    @stack('scripts')
</body>
</html>
