@extends('layouts.app')

@section('title', 'Venue Listing - Party Plot Listing Platform')

@section('content')
<!-- Breadcrumb section Start-->
<div class="breadcrumb-section" style="background-image:linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url({{ asset('theme/assets/img/innerpages/breadcrumb-bg3.jpg') }});">
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
                            <div class="checkbox-container">
                                <ul>
                                    @foreach($categories as $category)
                                    <li>
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
                            <div class="checkbox-container">
                                <ul>
                                    @foreach($cities as $city)
                                    <li>
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
                        <div class="col-md-6 item wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                            <div class="package-card">
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
                                        @endphp
                                        @if($imageUrl)
                                            <img src="{{ $imageUrl }}" alt="{{ $plot->name }}" style="width: 100%; height: 250px; object-fit: cover;">
                                        @else
                                            <div style="width: 100%; height: 250px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                                                <div style="text-align: center; color: white;">
                                                    <i class="fa-solid fa-image" style="font-size: 64px; margin-bottom: 10px; display: block;"></i>
                                                    <p style="margin: 0; font-size: 14px; font-weight: 500;">No Image Available</p>
                                                </div>
                                            </div>
                                        @endif
                                    </a>
                                    @if($plot->verified)
                                    <div class="batch">
                                        <span>Verified</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="package-content">
                                    <h5><a href="{{ route('party-plots.show', $plot->slug) }}">{{ $plot->name }}</a></h5>

                                    @if($plot->description)
                                    <p>
                                        {{ Str::limit(strip_tags($plot->description), 100) }}
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
                                        @if($plot->price_range_min || $plot->price_range_max)
                                        <div class="price-area">
                                            <h6>Starting From</h6>
                                            <span>₹{{ number_format($plot->price_range_min ?? $plot->price_range_max) }}</span>
                                        </div>
                                        @endif
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

    /* Icon Styling - Font Awesome */
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

    .filter-btn i {
        font-size: 18px;
        margin-right: 5px;
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
</style>
@endpush

@push('scripts')
<script>
    // Initialize nice-select for dropdowns
    $(document).ready(function() {
        $('select.nice-select').niceSelect();
    });

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
    });

    // Clear filters
    document.getElementById('clear-filters')?.addEventListener('click', function() {
        window.location.href = '{{ route("party-plots.index") }}';
    });
</script>
@endpush
@endsection

