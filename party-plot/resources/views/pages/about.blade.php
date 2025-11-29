@extends('layouts.app')

@section('title', 'About Us - Party Plot Listing Platform')

@section('content')
<!-- Breadcrumb Section Start-->
<div class="breadcrumb-section mb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-wrap">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">About</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section End-->

<!-- About Section Start-->
<div class="about-page-about-section mb-100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="about-content wow animate fadeInLeft" data-wow-delay="200ms" data-wow-duration="1500ms">
                    <div class="section-title">
                        <h2>Why We're Best Platform</h2>
                        <h4>Welcome to Party Plot Listing Platform – Your Gateway to Perfect Celebrations!</h4>
                        <p>Party Plot Listing Platform is a trusted name in the event venue industry, offering seamless venue discovery, personalized recommendations, and unforgettable celebrations. With years of experience and a network of premium venues, we ensure a hassle-free and memorable experience for every event organizer.</p>
                        <p>We believe that every celebration deserves the perfect venue—it's about creating unforgettable experiences, making lifelong memories, and celebrating life's special moments in style.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-lg-block d-none wow animate fadeInRight" data-wow-delay="200ms" data-wow-duration="1500ms">
                <div class="about-img">
                    <img src="{{ asset('theme/assets/img/home3/about-img.png') }}" alt="About Us">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About Section End-->

<!-- Service Section Start-->
<div class="home1-service-section mb-100">
    <div class="container">
        <div class="service-wrapper">
            <div class="row justify-content-center wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                <div class="col-lg-9">
                    <div class="section-title">
                        <h2>We're Providing Best Service Ever!</h2>
                        <svg height="6" viewBox="0 0 872 6" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 2.5L0 0.113249V5.88675L5 3.5V2.5ZM867 3.5L872 5.88675V0.113249L867 2.5V3.5ZM4.5 3.5H867.5V2.5H4.5V3.5Z" />
                        </svg>
                    </div>
                </div>
            </div>
            <ul class="service-list wow animate fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                <li class="single-service">
                    <div class="icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div class="content">
                        <h4>Verified Venues</h4>
                        <p>All our party plots are verified and quality-checked for your peace of mind.</p>
                    </div>
                </li>
                <li class="single-service">
                    <div class="icon">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <div class="content">
                        <h4>Easy Booking</h4>
                        <p>Simple and hassle-free booking process with instant confirmations.</p>
                    </div>
                </li>
                <li class="single-service">
                    <div class="icon">
                        <i class="bi bi-currency-rupee"></i>
                    </div>
                    <div class="content">
                        <h4>Best Prices</h4>
                        <p>Competitive pricing with no hidden charges. Transparent pricing for all venues.</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Service Section End-->
@endsection

