@extends('layouts.app')

@section('title', 'Venue Listing - Party Plot Listing Platform')

@section('content')
<!-- Breadcrumb section Start-->
<div class="breadcrumb-section video-breadcrumb">
    <div class="banner-video-area">
        <img src="{{ asset('assets/images/partyplot.gif') }}" alt="Party Venues">
        <div class="video-overlay"></div>
    </div>
    <div class="container">
        <div class="banner-content">
            <h1>All Venues</h1>
            <ul class="breadcrumb-list">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>All Venues</li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumb section End-->

<!-- Package Grid Page Start-->
<div class="package-grid-page pt-100 mb-100">
    <div class="container">
        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-lg-4">
                <div class="package-sidebar-area">
                    <div class="sidebar-wrapper">
                        <div class="title-area">
                            <h5>Filter</h5>
                            <span id="clear-filters">Clear All</span>
                        </div>

                        <form method="GET" action="{{ route('party-plots.index') }}" id="filter-form">
                        <!-- Search Filter -->
                        <div class="single-widgets">
                            <div class="widget-title">
                                <h5>Search</h5>
                            </div>
                            <div class="form-inner2">
                                <input type="text" name="search" placeholder="Search venues..." value="{{ request('name') ?: request('search') }}">
                                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div class="single-widgets">
                            <div class="widget-title">
                                <h5>Category</h5>
                            </div>
                            <div class="checkbox-container scrollable-filter">
                                <ul>
                                    @foreach($categories as $index => $category)
                                    <li class="{{ $index >= 7 ? 'filter-item-hidden' : '' }}">
                                        <label class="containerss">
                                            <input type="checkbox" name="category" value="{{ $category->id }}"
                                                {{ request('category') == $category->id ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                            <strong><span>{{ $category->name }}</span></strong>
                                        </label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- City Filter -->
                        <div class="single-widgets">
                            <div class="widget-title">
                                <h5>Location</h5>
                            </div>
                            <div class="checkbox-container scrollable-filter">
                                <ul>
                                    @foreach($cities as $index => $city)
                                    <li class="{{ $index >= 7 ? 'filter-item-hidden' : '' }}">
                                        <label class="containerss">
                                            <input type="checkbox" name="city" value="{{ $city }}"
                                                {{ request('city') == $city ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                            <strong><span>{{ $city }}</span></strong>
                                        </label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Area Filter -->
                        @if(isset($areas) && count($areas) > 0)
                        <div class="single-widgets">
                            <div class="widget-title">
                                <h5>Area</h5>
                            </div>
                            <div class="checkbox-container scrollable-filter">
                                <ul>
                                    @foreach($areas as $index => $area)
                                    <li class="{{ $index >= 7 ? 'filter-item-hidden' : '' }}">
                                        <label class="containerss">
                                            <input type="checkbox" name="area" value="{{ $area }}"
                                                {{ request('area') == $area ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                            <strong><span>{{ $area }}</span></strong>
                                        </label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        <!-- Amenities Filter -->
                        <div class="single-widgets">
                            <div class="widget-title">
                                <h5>Amenities</h5>
                            </div>
                            <div class="checkbox-container">
                                <ul>
                                    <li>
                                        <label class="containerss">
                                            <input type="checkbox" name="parking" value="1" {{ request('parking') ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                            <strong><span>Parking</span></strong>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="containerss">
                                            <input type="checkbox" name="ac_available" value="1" {{ request('ac_available') ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                            <strong><span>AC Available</span></strong>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="containerss">
                                            <input type="checkbox" name="generator_backup" value="1" {{ request('generator_backup') ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                            <strong><span>Generator Backup</span></strong>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Apply Filters Button -->
                        <div class="single-widgets">
                            <button type="submit" class="primary-btn1">
                                <span>Apply Filters</span>
                                <span>Apply Filters</span>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Listing Area -->
            <div class="col-lg-8">
                <div class="package-grid-top-area">
                    <span><strong>{{ $plots->total() }}</strong> Venues Available</span>
                    <div class="selector-and-list-grid-area">
                        <div class="filter-btn d-lg-none d-flex">
                            <i class="fa-solid fa-filter"></i>
                            <span>Filters</span>
                        </div>
                        <div class="selector-area">
                            <span>Sort By:</span>
                            <form method="GET" action="{{ route('party-plots.index') }}" id="sort-form">
                                @foreach(request()->except('sort') as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <select name="sort" onchange="document.getElementById('sort-form').submit();">
                                    <option value="">Default</option>
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="list-grid-product-wrap">
                    <div class="row gy-md-5 gy-4">
                        @forelse($plots as $plot)
                        <div class="col-xl-4 col-lg-4 col-md-6 item wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                            <div class="package-card enhanced-venue-card">
                                <div class="package-img-wrap">
                                    <a href="{{ route('party-plots.show', $plot->slug) }}" class="package-img">
                                        <div class="no-image-placeholder">
                                            <i class="fa-solid fa-image"></i>
                                            <p>No Image Available</p>
                                        </div>
                                        <div class="image-overlay"></div>
                                    </a>
                                    @if($plot->verified)
                                    <div class="batch">
                                        <span class="verified-badge"><i class="fa-solid fa-check-circle"></i> Verified</span>
                                    </div>
                                    @endif
                                    @if($plot->price_range_min || $plot->price_range_max)
                                    <div class="price-badge">
                                        <span>₹{{ number_format($plot->price_range_min ?? $plot->price_range_max) }}</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="package-content">
                                    <h5><a href="{{ route('party-plots.show', $plot->slug) }}">{{ $plot->name }}</a></h5>

                                    @if($plot->description)
                                    <p>
                                        {{ Str::limit(strip_tags($plot->description), 120) }}
                                    </p>
                                    @endif

                                    <div class="location-and-time">
                                        <div class="location">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <a href="{{ route('party-plots.index', ['city' => $plot->city]) }}">{{ $plot->city }}</a>
                                        </div>
                                        @if($plot->category)
                                        <i class="fa-solid fa-circle" style="font-size: 6px;"></i>
                                        <span>{{ $plot->category->name }}</span>
                                        @endif
                                    </div>
                                    <ul class="package-info">
                                        @if($plot->capacity_min && $plot->capacity_max)
                                        <li>
                                            <i class="fa-solid fa-users"></i>
                                            <span>Capacity: {{ number_format($plot->capacity_min) }} - {{ number_format($plot->capacity_max) }} guests</span>
                                        </li>
                                        @endif
                                        @if($plot->google_rating)
                                        <li>
                                            <i class="fa-solid fa-star"></i>
                                            <span>{{ number_format($plot->google_rating, 1) }} Rating</span>
                                        </li>
                                        @endif
                                        @if($plot->parking || $plot->ac_available || $plot->generator_backup)
                                        <li>
                                            <i class="fa-solid fa-circle-check"></i>
                                            <span>
                                                @if($plot->parking) Parking @endif
                                                @if($plot->parking && $plot->ac_available), @endif
                                                @if($plot->ac_available) AC @endif
                                                @if(($plot->parking || $plot->ac_available) && $plot->generator_backup), @endif
                                                @if($plot->generator_backup) Generator @endif
                                            </span>
                                        </li>
                                        @endif
                                    </ul>
                                    <div class="btn-and-price-area">
                                        <a href="{{ route('party-plots.show', $plot->slug) }}" class="primary-btn1">
                                            <span>
                                                View Details
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </span>
                                            <span>
                                                View Details
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </span>
                                        </a>
                                    </div>
                                    <svg class="divider" height="6" viewBox="0 0 374 6" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 2.5L0 0.113249V5.88675L5 3.5V2.5ZM369 3.5L374 5.88675V0.113249L369 2.5V3.5ZM4.5 3.5H369.5V2.5H4.5V3.5Z"/>
                                    </svg>
                                    <div class="bottom-area">
                                        <ul>
                                            <li>
                                                <i class="fa-solid fa-location-dot"></i>
                                                {{ $plot->city }}, {{ $plot->area ?? 'India' }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <h4>No venues found</h4>
                                <p>Try adjusting your filters to see more results.</p>
                                <a href="{{ route('party-plots.index') }}" class="primary-btn1">
                                    <span>Clear Filters</span>
                                    <span>Clear Filters</span>
                                </a>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pagination -->
                @if($plots->hasPages())
                    {{ $plots->links('vendor.pagination.gofly-theme') }}
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Package Grid Page End-->

@push('styles')
<style>
    /* Video Breadcrumb Styles */
    .breadcrumb-section.video-breadcrumb {
        position: relative;
        min-height: 350px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .breadcrumb-section.video-breadcrumb .banner-video-area {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
    }

    .breadcrumb-section.video-breadcrumb .banner-video-area video,
    .breadcrumb-section.video-breadcrumb .banner-video-area img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .breadcrumb-section.video-breadcrumb .banner-video-area .video-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.5));
        z-index: 1;
    }

    .breadcrumb-section.video-breadcrumb .container {
        position: relative;
        z-index: 2;
    }

    .breadcrumb-section.video-breadcrumb .banner-content {
        text-align: center;
    }

    .breadcrumb-section.video-breadcrumb .banner-content h1 {
        color: #fff;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .breadcrumb-section.video-breadcrumb .breadcrumb-list li,
    .breadcrumb-section.video-breadcrumb .breadcrumb-list li a {
        color: #fff;
    }

    .breadcrumb-section.video-breadcrumb .breadcrumb-list li a:hover {
        color: var(--primary-color1);
    }

    @media (max-width: 768px) {
        .breadcrumb-section.video-breadcrumb {
            min-height: 280px;
        }
    }

    @media (max-width: 576px) {
        .breadcrumb-section.video-breadcrumb {
            min-height: 220px;
        }
    }

    /* ========================================
       FILTER SIDEBAR STYLES
       ======================================== */
    
    /* Sidebar Container */
    .package-sidebar-area .sidebar-wrapper {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        padding: 20px;
        border: 1px solid #e5e7eb;
    }

    .package-sidebar-area .sidebar-wrapper .title-area {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 14px;
        margin-bottom: 16px;
        border-bottom: 1px solid #e5e7eb;
    }

    .package-sidebar-area .sidebar-wrapper .title-area h5 {
        font-size: 18px;
        font-weight: 600;
        color: #1a1a2e;
        margin: 0;
    }

    .package-sidebar-area .sidebar-wrapper .title-area #clear-filters {
        font-size: 13px;
        color: var(--primary-color1);
        cursor: pointer;
        font-weight: 500;
    }

    .package-sidebar-area .sidebar-wrapper .title-area #clear-filters:hover {
        text-decoration: underline;
    }

    /* Search Box Styles */
    .package-sidebar-area .sidebar-wrapper .single-widgets .form-inner2 {
        display: flex;
        align-items: center;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
    }

    .package-sidebar-area .sidebar-wrapper .single-widgets .form-inner2:focus-within {
        border-color: var(--primary-color1);
    }

    .package-sidebar-area .sidebar-wrapper .single-widgets .form-inner2 input {
        flex: 1;
        border: none;
        background: transparent;
        padding: 10px 12px;
        font-size: 14px;
        color: #1a1a2e;
        outline: none;
    }

    .package-sidebar-area .sidebar-wrapper .single-widgets .form-inner2 input::placeholder {
        color: #94a3b8;
    }

    .package-sidebar-area .sidebar-wrapper .single-widgets .form-inner2 button {
        background: var(--primary-color1);
        border: none;
        padding: 10px 14px;
        cursor: pointer;
    }

    .package-sidebar-area .sidebar-wrapper .single-widgets .form-inner2 button i {
        color: #fff;
        font-size: 14px;
    }

    /* Widget Titles */
    .package-sidebar-area .sidebar-wrapper .single-widgets .widget-title h5 {
        font-size: 15px;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 10px;
    }

    /* Scrollable Filter Container */
    .package-sidebar-area .sidebar-wrapper .single-widgets .checkbox-container.scrollable-filter {
        max-height: 280px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .package-sidebar-area .sidebar-wrapper .single-widgets .checkbox-container.scrollable-filter ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .package-sidebar-area .sidebar-wrapper .single-widgets .checkbox-container.scrollable-filter ul li {
        margin-bottom: 8px;
    }

    .package-sidebar-area .sidebar-wrapper .single-widgets .checkbox-container.scrollable-filter ul li.filter-item-hidden {
        display: block;
    }

    /* Custom Scrollbar for Filter Containers */
    .package-sidebar-area .sidebar-wrapper .single-widgets .checkbox-container.scrollable-filter::-webkit-scrollbar {
        width: 6px;
    }

    .package-sidebar-area .sidebar-wrapper .single-widgets .checkbox-container.scrollable-filter::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .package-sidebar-area .sidebar-wrapper .single-widgets .checkbox-container.scrollable-filter::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .package-sidebar-area .sidebar-wrapper .single-widgets .checkbox-container.scrollable-filter::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Checkbox Checkmark - Font Awesome Override */
    .package-sidebar-area .sidebar-wrapper .single-widgets .checkbox-container ul li .containerss input:checked ~ .checkmark::after {
        content: "\f00c" !important;
        font-family: "Font Awesome 7 Free" !important;
        font-weight: 900 !important;
        color: var(--white-color) !important;
        line-height: 1 !important;
        font-size: 10px !important;
        left: 50% !important;
        top: 50% !important;
        transform: translate(-50%, -50%) !important;
        position: absolute !important;
        width: 100% !important;
        height: 100% !important;
        background: var(--primary-color1) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    /* Apply Filters Button */
    .package-sidebar-area .sidebar-wrapper .single-widgets .primary-btn1 {
        width: 100%;
        justify-content: center;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 8px;
        margin-top: 8px;
    }

    /* ========================================
       TOP AREA - VENUES COUNT & SORT
       ======================================== */
    
    .package-grid-top-area {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 0 20px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .package-grid-top-area > span {
        font-size: 15px;
        color: #64748b;
    }

    .package-grid-top-area > span strong {
        color: #1a1a2e;
        font-weight: 600;
    }

    .package-grid-top-area .selector-and-list-grid-area {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .package-grid-top-area .selector-area {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .package-grid-top-area .selector-area > span {
        font-size: 14px;
        color: #64748b;
    }

    /* Sort Dropdown Styles */
    .package-grid-top-area .selector-area form {
        display: inline-block;
    }

    .package-grid-top-area .selector-area select,
    .package-grid-top-area .selector-area form select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L1 3h10z'/%3E%3C/svg%3E") no-repeat right 12px center;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        padding: 8px 32px 8px 12px;
        font-size: 14px;
        font-weight: 500;
        color: #1a1a2e;
        cursor: pointer;
        min-width: 140px;
        outline: none;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    .package-grid-top-area .selector-area select:hover {
        border-color: #9ca3af;
    }

    .package-grid-top-area .selector-area select:focus {
        border-color: var(--primary-color1);
    }

    /* Hide nice-select wrapper if it exists */
    .package-grid-top-area .selector-area .nice-select {
        display: none !important;
    }

    /* Filter Button (Mobile) */
    .package-grid-top-area .filter-btn {
        background: #f1f5f9;
        color: #1a1a2e;
        padding: 8px 14px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        border: 1px solid #e2e8f0;
    }

    .filter-btn i {
        font-size: 14px;
        margin-right: 5px;
    }

    /* ========================================
       ICON STYLING - FONT AWESOME
       ======================================== */

    .package-card .package-content .location-and-time .location i,
    .package-card .package-content .package-info li i {
        font-size: 14px;
        color: var(--text-color);
    }

    .package-card .package-content .location-and-time .fa-circle {
        font-size: 6px;
        color: var(--text-color);
        opacity: 0.6;
    }

    .package-card .package-content .package-info li i.fa-star {
        color: #FFC107;
    }

    .package-card .package-content .package-info li i.fa-circle-check {
        color: var(--primary-color1);
    }

    /* Card Description Styling - Minimal override for text truncation */
    .package-card .package-content p {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Category Tag Styling - Minimal override */
    .package-card .package-content .location-and-time .category-tag {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ========================================
       RESPONSIVE ADJUSTMENTS
       ======================================== */
    
    @media (max-width: 768px) {
        .package-grid-top-area {
            flex-direction: column;
            gap: 16px;
            padding: 16px;
        }

        .package-grid-top-area .selector-and-list-grid-area {
            width: 100%;
            justify-content: space-between;
        }

        .package-sidebar-area .sidebar-wrapper {
            padding: 20px;
        }
    }

    @media (max-width: 576px) {
        .package-grid-top-area .selector-area .nice-select {
            min-width: 140px;
        }
    }

    /* Pagination Disabled State - Required for disabled buttons */
    .pagination-area .paginations-button span.disabled {
        min-width: 88px;
        max-width: 88px;
        height: 88px;
        border-radius: 50%;
        border: 1px solid var(--borders-color);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        color: var(--text-color);
        font-family: var(--font-poppins);
        font-size: 16px;
        font-weight: 600;
        line-height: 1;
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }
    @media (max-width: 576px) {
        .pagination-area .paginations-button span.disabled {
            min-width: 65px;
            max-width: 65px;
            height: 65px;
            font-size: 14px;
        }
    }
    .pagination-area .paginations-button span.disabled svg {
        fill: none;
        stroke: var(--text-color);
        opacity: 0.5;
    }
    .pagination-area .paginations .page-item.disabled span {
        color: var(--text-color);
        opacity: 0.5;
        padding: 0 10px;
    }

    /* ========================================
       ENHANCED VENUE CARD STYLES
       ======================================== */
    
    .enhanced-venue-card {
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
    }

    .enhanced-venue-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        border-color: #d1d5db;
    }

    /* Image Styles */
    .enhanced-venue-card .package-img-wrap {
        position: relative;
        overflow: hidden;
        border-radius: 12px 12px 0 0;
        margin-bottom: 0;
        flex-shrink: 0;
    }

    .enhanced-venue-card .package-img {
        display: block;
        position: relative;
        overflow: hidden;
        border-radius: 12px 12px 0 0;
        height: 150px;
        background: #f1f5f9;
    }

    .enhanced-venue-card .venue-card-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 12px 12px 0 0;
        transition: transform 0.4s ease;
    }

    .enhanced-venue-card .venue-card-image.default-venue-image {
        object-position: center;
    }

    .enhanced-venue-card:hover .venue-card-image {
        transform: scale(1.05);
    }

    .enhanced-venue-card .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.2) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 12px 12px 0 0;
        pointer-events: none;
    }

    .enhanced-venue-card:hover .image-overlay {
        opacity: 1;
    }

    /* No Image Placeholder */
    .enhanced-venue-card .no-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px 12px 0 0;
        color: white;
        text-align: center;
    }

    .enhanced-venue-card .no-image-placeholder i {
        font-size: 36px;
        margin-bottom: 8px;
        opacity: 0.8;
    }

    .enhanced-venue-card .no-image-placeholder p {
        margin: 0;
        font-size: 12px;
        font-weight: 500;
        opacity: 0.9;
    }

    /* Badges */
    .enhanced-venue-card .batch {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 2;
    }

    .enhanced-venue-card .verified-badge {
        background: #10b981;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .enhanced-venue-card .verified-badge i {
        font-size: 11px;
    }

    /* Price Badge */
    .enhanced-venue-card .price-badge {
        position: absolute;
        bottom: 10px;
        left: 10px;
        z-index: 2;
        background: rgba(255, 255, 255, 0.95);
        padding: 6px 10px;
        border-radius: 6px;
    }

    .enhanced-venue-card .price-badge span {
        font-size: 14px;
        font-weight: 700;
        color: var(--primary-color1);
    }

    /* Card Content */
    .enhanced-venue-card .package-content {
        padding: 14px 16px 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #fff;
        border-radius: 0 0 12px 12px;
    }

    .enhanced-venue-card .package-content h5 {
        margin-bottom: 6px;
        font-size: 16px;
        line-height: 1.3;
        font-weight: 600;
    }

    .enhanced-venue-card .package-content h5 a {
        color: #1a1a2e;
        transition: color 0.2s ease;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .enhanced-venue-card .package-content h5 a:hover {
        color: var(--primary-color1);
    }

    .enhanced-venue-card .package-content p {
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 10px;
        font-size: 13px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Location and Category */
    .enhanced-venue-card .location-and-time {
        margin: 0 !important;
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .enhanced-venue-card .location-and-time .location {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .enhanced-venue-card .location-and-time .location i {
        color: var(--primary-color1);
        font-size: 14px;
    }

    .enhanced-venue-card .location-and-time .location a {
        color: var(--text-color);
        text-decoration: none;
        transition: color 0.3s ease;
        font-weight: 500;
        font-size: 14px;
    }

    .enhanced-venue-card .location-and-time .location a:hover {
        color: var(--primary-color1);
    }

    .enhanced-venue-card .location-and-time .fa-circle {
        font-size: 6px;
        color: #999;
        opacity: 0.6;
    }

    .enhanced-venue-card .location-and-time span {
        color: var(--text-color);
        font-size: 14px;
        font-weight: 500;
    }

    /* Package Info */
    .enhanced-venue-card .package-info {
        margin-bottom: 8px;
        list-style: none;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex-grow: 0;
    }

    .enhanced-venue-card .package-info li {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: var(--text-color);
        line-height: 1.4;
    }

    .enhanced-venue-card .package-info li i {
        color: var(--primary-color1);
        font-size: 13px;
        width: 16px;
        text-align: center;
        flex-shrink: 0;
    }

    .enhanced-venue-card .package-info li i.fa-star {
        color: #FFC107;
    }

    .enhanced-venue-card .package-info li i.fa-circle-check {
        color: var(--primary-color1);
    }

    /* Button Area */
    .enhanced-venue-card .btn-and-price-area {
        margin-top: auto;
        padding-top: 8px;
        border-top: 1px solid rgba(0, 0, 0, 0.08);
    }

    .enhanced-venue-card .primary-btn1 {
        width: 100%;
        text-align: center;
        justify-content: center;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 600;
    }

    /* Divider */
    .enhanced-venue-card .divider {
        margin: 12px 0;
        width: 100%;
        opacity: 0.3;
    }

    /* Bottom Area */
    .enhanced-venue-card .bottom-area {
        margin-top: 0;
        padding-top: 12px;
        border-top: 1px solid rgba(0, 0, 0, 0.08);
    }

    .enhanced-venue-card .bottom-area ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .enhanced-venue-card .bottom-area li {
        font-size: 13px;
        color: var(--text-color);
        opacity: 0.8;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .enhanced-venue-card .bottom-area li i {
        color: var(--primary-color1);
        font-size: 14px;
    }

    /* ========================================
       CARD RESPONSIVE DESIGN
       ======================================== */
    
    @media (max-width: 992px) {
        .enhanced-venue-card .package-img {
            height: 140px;
        }

        .enhanced-venue-card .package-content h5 {
            font-size: 16px;
        }
    }

    @media (max-width: 768px) {
        .enhanced-venue-card .package-img {
            height: 160px;
        }

        .enhanced-venue-card .package-content {
            padding: 14px;
        }
    }

    @media (max-width: 576px) {
        .enhanced-venue-card .package-img {
            height: 140px;
        }

        .enhanced-venue-card .package-content {
            padding: 12px;
        }

        .enhanced-venue-card .price-badge {
            padding: 6px 10px;
        }

        .enhanced-venue-card .price-badge span {
            font-size: 14px;
        }

        .enhanced-venue-card .verified-badge {
            padding: 4px 8px;
            font-size: 10px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Handle filter form submission
    document.getElementById('filter-form')?.addEventListener('submit', function(e) {
        // Remove unchecked checkboxes from form submission
        const form = this;
        const allCheckboxes = form.querySelectorAll('input[type="checkbox"]');

        allCheckboxes.forEach(function(checkbox) {
            if (!checkbox.checked) {
                // Create a hidden input to exclude unchecked values
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = checkbox.name;
                hidden.value = '';
                hidden.style.display = 'none';
                form.appendChild(hidden);
            }
        });

        // Only submit first checked category if multiple
        const categoryCheckboxes = form.querySelectorAll('input[name="category"]:checked');
        if (categoryCheckboxes.length > 0) {
            // Remove all category inputs first
            form.querySelectorAll('input[name="category"]').forEach(cb => {
                if (cb.type === 'checkbox') return;
                cb.remove();
            });
            const categoryInput = document.createElement('input');
            categoryInput.type = 'hidden';
            categoryInput.name = 'category';
            categoryInput.value = categoryCheckboxes[0].value;
            form.appendChild(categoryInput);
        }

        // Only submit first checked city if multiple
        const cityCheckboxes = form.querySelectorAll('input[name="city"]:checked');
        if (cityCheckboxes.length > 0) {
            // Remove all city inputs first
            form.querySelectorAll('input[name="city"]').forEach(cb => {
                if (cb.type === 'checkbox') return;
                cb.remove();
            });
            const cityInput = document.createElement('input');
            cityInput.type = 'hidden';
            cityInput.name = 'city';
            cityInput.value = cityCheckboxes[0].value;
            form.appendChild(cityInput);
        }

        // Only submit first checked area if multiple
        const areaCheckboxes = form.querySelectorAll('input[name="area"]:checked');
        if (areaCheckboxes.length > 0) {
            // Remove all area inputs first
            form.querySelectorAll('input[name="area"]').forEach(cb => {
                if (cb.type === 'checkbox') return;
                cb.remove();
            });
            const areaInput = document.createElement('input');
            areaInput.type = 'hidden';
            areaInput.name = 'area';
            areaInput.value = areaCheckboxes[0].value;
            form.appendChild(areaInput);
        }
    });

    // Clear filters
    document.getElementById('clear-filters')?.addEventListener('click', function() {
        window.location.href = '{{ route("party-plots.index") }}';
    });
</script>
@endpush
@endsection

