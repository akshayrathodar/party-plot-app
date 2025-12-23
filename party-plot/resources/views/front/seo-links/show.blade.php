@extends('layouts.app')

@section('title', $seoLink->meta_title)

@push('styles')
<meta name="description" content="{{ $seoLink->meta_description }}">
@if($seoLink->meta_keywords)
<meta name="keywords" content="{{ $seoLink->meta_keywords }}">
@endif

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $seoLink->meta_title }}">
<meta property="og:description" content="{{ $seoLink->meta_description }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="{{ $seoLink->meta_title }}">
<meta property="twitter:description" content="{{ $seoLink->meta_description }}">

<!-- Canonical URL -->
<link rel="canonical" href="{{ url()->current() }}">
@endpush

@section('content')
<!-- Breadcrumb section Start-->
<div class="breadcrumb-section" style="background-image:linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url({{ asset('theme/assets/img/innerpages/breadcrumb-bg3.jpg') }});">
    <div class="container">
        <div class="banner-content">
            <h1>{{ $seoLink->page_title ?: $seoLink->link_text }}</h1>
            <ul class="breadcrumb-list">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>{{ $seoLink->link_text }}</li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumb section End-->

<!-- Package Grid Page Start-->
<div class="package-grid-page pt-100 mb-100">
    <div class="container">
        @if($seoLink->page_description)
        <div class="row mb-4">
            <div class="col-12">
                <div class="seo-description">
                    <p class="lead">{{ $seoLink->page_description }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-lg-4">
                <div class="package-sidebar-area">
                    <div class="sidebar-wrapper">
                        <div class="title-area">
                            <h5>Filter</h5>
                            <span id="clear-filters">Clear All</span>
                        </div>

                        <form method="GET" action="{{ route('seo-link.show', $seoLink->slug) }}" id="filter-form">
                        <!-- Search Filter -->
                        <div class="single-widgets">
                            <div class="widget-title">
                                <h5>Search</h5>
                            </div>
                            <div class="form-inner2">
                                <input type="text" name="search" placeholder="Search venues..." value="{{ request('search') }}">
                                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div class="single-widgets">
                            <div class="widget-title">
                                <h5>Category</h5>
                            </div>
                            <div class="checkbox-container">
                                <ul>
                                    @foreach($categories as $category)
                                    <li>
                                        <label class="containerss">
                                            <input type="checkbox" name="category" value="{{ $category->id }}"
                                                {{ request('category') == $category->id || $seoLink->category_id == $category->id ? 'checked' : '' }}>
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
                            <div class="checkbox-container">
                                <ul>
                                    @foreach($cities as $city)
                                    <li>
                                        <label class="containerss">
                                            <input type="checkbox" name="city" value="{{ $city }}"
                                                {{ request('city') == $city || $seoLink->city == $city ? 'checked' : '' }}>
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
                            <div class="checkbox-container">
                                <ul>
                                    @foreach($areas as $area)
                                    <li>
                                        <label class="containerss">
                                            <input type="checkbox" name="area" value="{{ $area }}"
                                                {{ request('area') == $area || $seoLink->area == $area ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                            <strong><span>{{ $area }}</span></strong>
                                        </label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        <!-- Active Filters Info -->
                        @if($seoLink->city || $seoLink->area || $seoLink->category || $seoLink->tags)
                        <div class="single-widgets">
                            <div class="widget-title">
                                <h5>Active Filters</h5>
                            </div>
                            <div class="active-filters-info">
                                @if($seoLink->city)
                                <span class="filter-badge">
                                    <i class="fa-solid fa-city"></i> {{ $seoLink->city }}
                                </span>
                                @endif
                                @if($seoLink->area)
                                <span class="filter-badge">
                                    <i class="fa-solid fa-map-marker"></i> {{ $seoLink->area }}
                                </span>
                                @endif
                                @if($seoLink->category)
                                <span class="filter-badge">
                                    <i class="fa-solid fa-tag"></i> {{ $seoLink->category->name }}
                                </span>
                                @endif
                                @if($seoLink->tags)
                                @php
                                    $tagsArray = explode(',', $seoLink->tags);
                                @endphp
                                @foreach($tagsArray as $tag)
                                <span class="filter-badge">
                                    <i class="fa-solid fa-hashtag"></i> {{ trim($tag) }}
                                </span>
                                @endforeach
                                @endif
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
                            <form method="GET" action="{{ route('seo-link.show', $seoLink->slug) }}" id="sort-form">
                                @foreach(request()->except('sort') as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <select name="sort" class="nice-select" onchange="document.getElementById('sort-form').submit();">
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
                                        @php
                                            $imageUrl = '';
                                            // First try featured image
                                            if ($plot->featured_image && trim($plot->featured_image) !== '') {
                                                if (filter_var($plot->featured_image, FILTER_VALIDATE_URL)) {
                                                    $imageUrl = $plot->featured_image;
                                                } elseif (strpos($plot->featured_image, 'http') === 0) {
                                                    $imageUrl = $plot->featured_image;
                                                } else {
                                                    // Check if it's stored in uploads/admin/party-plots (from admin upload)
                                                    $adminPath = 'uploads/admin/party-plots/' . $plot->featured_image;
                                                    if (file_exists(public_path($adminPath))) {
                                                        $imageUrl = asset($adminPath);
                                                    }
                                                    // Check other possible paths
                                                    elseif (file_exists(public_path($plot->featured_image))) {
                                                        $imageUrl = asset($plot->featured_image);
                                                    } elseif (file_exists(storage_path('app/public/' . $plot->featured_image))) {
                                                        $imageUrl = asset('storage/' . $plot->featured_image);
                                                    } elseif (file_exists(public_path('theme/' . $plot->featured_image))) {
                                                        $imageUrl = asset('theme/' . $plot->featured_image);
                                                    }
                                                }
                                            }

                                            // If no featured image, try gallery images
                                            if (empty($imageUrl) && $plot->gallery_images && is_array($plot->gallery_images) && count($plot->gallery_images) > 0) {
                                                foreach ($plot->gallery_images as $galleryImg) {
                                                    if (filter_var($galleryImg, FILTER_VALIDATE_URL)) {
                                                        $imageUrl = $galleryImg;
                                                        break;
                                                    } elseif (strpos($galleryImg, 'http') === 0) {
                                                        $imageUrl = $galleryImg;
                                                        break;
                                                    } else {
                                                        // Check if it's stored in uploads/admin/party-plots (from admin upload)
                                                        $adminPath = 'uploads/admin/party-plots/' . $galleryImg;
                                                        if (file_exists(public_path($adminPath))) {
                                                            $imageUrl = asset($adminPath);
                                                            break;
                                                        }
                                                        // Check other possible paths
                                                        elseif (file_exists(public_path($galleryImg))) {
                                                            $imageUrl = asset($galleryImg);
                                                            break;
                                                        } elseif (file_exists(storage_path('app/public/' . $galleryImg))) {
                                                            $imageUrl = asset('storage/' . $galleryImg);
                                                            break;
                                                        } elseif (file_exists(public_path('theme/' . $galleryImg))) {
                                                            $imageUrl = asset('theme/' . $galleryImg);
                                                            break;
                                                        }
                                                    }
                                                }
                                            }

                                            // If still no image, use demo/placeholder image
                                            if (empty($imageUrl)) {
                                                // Try to find a demo image from theme
                                                $demoImages = [
                                                    'theme/assets/img/home1/tour-package-img1.jpg',
                                                    'theme/assets/img/home1/tour-package-img2.jpg',
                                                    'theme/assets/img/home1/tour-package-img3.jpg',
                                                    'theme/assets/img/home1/destination-img1.jpg',
                                                    'theme/assets/img/home1/destination-img2.jpg',
                                                ];
                                                
                                                foreach ($demoImages as $demoImg) {
                                                    if (file_exists(public_path($demoImg))) {
                                                        $imageUrl = asset($demoImg);
                                                        break;
                                                    }
                                                }
                                            }
                                        @endphp
                                        @if($imageUrl)
                                            <img src="{{ $imageUrl }}" alt="{{ $plot->name }}" class="venue-card-image">
                                        @else
                                            <div class="no-image-placeholder">
                                                <i class="fa-solid fa-image"></i>
                                                <p>No Image Available</p>
                                            </div>
                                        @endif
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
                            <div class="no-results text-center py-5">
                                <i class="fa-solid fa-inbox fa-3x text-muted mb-3"></i>
                                <h4>No venues found</h4>
                                <p class="text-muted">Try adjusting your filters or search criteria.</p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pagination -->
                @if($plots->hasPages())
                <div class="pagination-wrapper mt-4">
                    {{ $plots->links('pagination::bootstrap-4') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Package Grid Page End-->

@push('styles')
<style>
    .active-filters-info {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 20px;
    }

    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        background: var(--theme-default, #ff6b35);
        color: #fff;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }

    .filter-badge i {
        font-size: 12px;
    }

    /* Enhanced Venue Card Styles */
    .enhanced-venue-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .enhanced-venue-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    /* Image Styles - Minimum Size */
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
        min-height: 140px;
        max-height: 160px;
        height: 140px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .enhanced-venue-card .venue-card-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 12px 12px 0 0;
        transition: transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .enhanced-venue-card:hover .venue-card-image {
        transform: scale(1.1);
    }

    .enhanced-venue-card .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.2) 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
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
        font-size: 48px;
        margin-bottom: 10px;
        opacity: 0.8;
    }

    .enhanced-venue-card .no-image-placeholder p {
        margin: 0;
        font-size: 13px;
        font-weight: 500;
        opacity: 0.9;
    }

    /* Badges */
    .enhanced-venue-card .batch {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 2;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .enhanced-venue-card .verified-badge {
        background: rgba(40, 167, 69, 0.95);
        backdrop-filter: blur(10px);
        color: white;
        padding: 6px 12px;
        border-radius: 100px;
        font-size: 11px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        box-shadow: 0 3px 10px rgba(40, 167, 69, 0.3);
        transition: all 0.3s ease;
    }

    .enhanced-venue-card .verified-badge:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 14px rgba(40, 167, 69, 0.4);
    }

    .enhanced-venue-card .verified-badge i {
        font-size: 12px;
    }

    /* Price Badge */
    .enhanced-venue-card .price-badge {
        position: absolute;
        bottom: 12px;
        left: 12px;
        z-index: 2;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 8px 16px;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
    }

    .enhanced-venue-card .price-badge span {
        font-size: 16px;
        font-weight: 700;
        color: var(--primary-color1, #007bff);
        font-family: var(--font-poppins, 'Poppins', sans-serif);
    }

    /* Card Content Enhancements - Compact Design */
    .enhanced-venue-card .package-content {
        padding: 16px 16px 14px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .enhanced-venue-card .package-content h5 {
        margin-bottom: 8px;
        font-size: 20px;
        line-height: 1.3;
        font-weight: 600;
    }

    .enhanced-venue-card .package-content h5 a {
        color: var(--title-color);
        transition: color 0.3s ease;
        text-decoration: none;
        display: block;
    }

    .enhanced-venue-card .package-content h5 a:hover {
        color: var(--primary-color1);
    }

    .enhanced-venue-card .package-content p {
        color: var(--text-color);
        line-height: 1.5;
        margin-bottom: 12px;
        font-size: 13px;
        flex-grow: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Location and Category */
    .enhanced-venue-card .location-and-time {
        margin-bottom: 0;
        padding-bottom: 12px;
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

    /* Responsive Design */
    @media (max-width: 1200px) {
        .enhanced-venue-card .package-img {
            min-height: 130px;
            max-height: 150px;
            height: 130px;
        }

        .enhanced-venue-card .package-content {
            padding: 14px 14px 12px;
        }
    }

    @media (max-width: 992px) {
        .enhanced-venue-card .package-img {
            min-height: 120px;
            max-height: 140px;
            height: 120px;
        }
    }

    @media (max-width: 768px) {
        .enhanced-venue-card .package-img {
            min-height: 180px;
            max-height: 200px;
            height: 180px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Sort functionality
    document.getElementById('sort-select')?.addEventListener('change', function() {
        const url = new URL(window.location.href);
        if (this.value) {
            url.searchParams.set('sort', this.value);
        } else {
            url.searchParams.delete('sort');
        }
        window.location.href = url.toString();
    });

    // Clear filters
    document.getElementById('clear-filters')?.addEventListener('click', function() {
        window.location.href = '{{ route("seo-link.show", $seoLink->slug) }}';
    });

    // Auto-submit on filter change
    document.querySelectorAll('#filter-form input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            // Optional: Auto-submit on filter change
            // document.getElementById('filter-form').submit();
        });
    });
</script>
@endpush

@endsection

