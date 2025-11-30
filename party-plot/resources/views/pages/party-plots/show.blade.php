@extends('layouts.app')

@section('title', $plot->name . ' - Party Plot Details')

@section('content')
<!-- Breadcrumb section Start-->
@php
    $bannerImages = [];
    // Add featured image first
    if ($plot->featured_image && trim($plot->featured_image) !== '') {
        if (filter_var($plot->featured_image, FILTER_VALIDATE_URL)) {
            $bannerImages[] = $plot->featured_image;
        } elseif (strpos($plot->featured_image, 'http') === 0) {
            $bannerImages[] = $plot->featured_image;
        } else {
            // Check if it's stored in uploads/admin/party-plots (from admin upload)
            $adminPath = 'uploads/admin/party-plots/' . $plot->featured_image;
            if (file_exists(public_path($adminPath))) {
                $bannerImages[] = asset($adminPath);
            }
            // Check other possible paths
            elseif (file_exists(public_path($plot->featured_image))) {
                $bannerImages[] = asset($plot->featured_image);
            } elseif (file_exists(storage_path('app/public/' . $plot->featured_image))) {
                $bannerImages[] = asset('storage/' . $plot->featured_image);
            } elseif (file_exists(public_path('theme/' . $plot->featured_image))) {
                $bannerImages[] = asset('theme/' . $plot->featured_image);
            }
        }
    }
    // Add all gallery images
    if ($plot->gallery_images && is_array($plot->gallery_images)) {
        foreach ($plot->gallery_images as $galleryImg) {
            if (filter_var($galleryImg, FILTER_VALIDATE_URL)) {
                $bannerImages[] = $galleryImg;
            } elseif (strpos($galleryImg, 'http') === 0) {
                $bannerImages[] = $galleryImg;
            } else {
                // Check if it's stored in uploads/admin/party-plots (from admin upload)
                $adminPath = 'uploads/admin/party-plots/' . $galleryImg;
                if (file_exists(public_path($adminPath))) {
                    $bannerImages[] = asset($adminPath);
                }
                // Check other possible paths
                elseif (file_exists(public_path($galleryImg))) {
                    $bannerImages[] = asset($galleryImg);
                } elseif (file_exists(storage_path('app/public/' . $galleryImg))) {
                    $bannerImages[] = asset('storage/' . $galleryImg);
                } elseif (file_exists(public_path('theme/' . $galleryImg))) {
                    $bannerImages[] = asset('theme/' . $galleryImg);
                }
            }
        }
    }
    // If no images, use default theme images
    if (count($bannerImages) == 0) {
        $bannerImages = [
            asset('theme/assets/img/innerpages/package-breadcrumb-bg1.jpg'),
            asset('theme/assets/img/innerpages/package-breadcrumb-bg2.jpg'),
            asset('theme/assets/img/innerpages/breadcrumb-bg9.jpg')
        ];
    } elseif (count($bannerImages) == 1) {
        $bannerImages[] = asset('theme/assets/img/innerpages/package-breadcrumb-bg2.jpg');
        $bannerImages[] = asset('theme/assets/img/innerpages/breadcrumb-bg9.jpg');
    } elseif (count($bannerImages) == 2) {
        $bannerImages[] = asset('theme/assets/img/innerpages/breadcrumb-bg9.jpg');
    }
@endphp
<div class="breadcrumb-section two">
    <div class="swiper home2-banner-slider">
        <div class="swiper-wrapper">
            @foreach($bannerImages as $bannerImg)
            <div class="swiper-slide">
                <div class="banner-bg" style="background-image:linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url({{ $bannerImg }});"></div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="banner-content-wrap">
        <div class="container">
            <div class="banner-content">
                @if($plot->price_range_min || $plot->price_range_max)
                <span>Starting From <strong>₹{{ number_format($plot->price_range_min ?? $plot->price_range_max) }}</strong></span>
                @endif
                <h1>{{ $plot->name }}</h1>
                <div class="batch">
                    @php
                        $batchItems = [];
                        if ($plot->capacity_min && $plot->capacity_max) {
                            $batchItems[] = number_format($plot->capacity_min) . '-' . number_format($plot->capacity_max) . ' Capacity';
                        }
                        if ($plot->city) {
                            $batchItems[] = $plot->city;
                        }
                        if ($plot->category) {
                            $batchItems[] = $plot->category->name;
                        }
                    @endphp
                    <span>{{ implode(' | ', $batchItems) }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="slider-btn-grp">
        <div class="slider-btn banner-slider-prev">
            <svg width="22" height="22" viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 10.0571H22V11.9428H0V10.0571Z" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0.942857 11.9429C5.3768 11.9429 9.00115 8.0432 9.00115 3.88457V2.94171H7.11543V3.88457C7.11543 7.04251 4.29566 10.0571 0.942857 10.0571H0V11.9429H0.942857Z" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0.942857 10.0571C5.3768 10.0571 9.00115 13.9568 9.00115 18.1154V19.0583H7.11543V18.1154C7.11543 14.9587 4.29566 11.9428 0.942857 11.9428H0V10.0571H0.942857Z" />
                </g>
            </svg>
        </div>
        <div class="slider-btn banner-slider-next">
            <svg width="22" height="22" viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M22 10.0571H-5.72205e-06V11.9428H22V10.0571Z" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M21.0571 11.9429C16.6232 11.9429 12.9989 8.0432 12.9989 3.88457V2.94171H14.8846V3.88457C14.8846 7.04251 17.7043 10.0571 21.0571 10.0571H22V11.9429H21.0571Z" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M21.0571 10.0571C16.6232 10.0571 12.9989 13.9568 12.9989 18.1154V19.0583H14.8846V18.1154C14.8846 14.9587 17.7043 11.9428 21.0571 11.9428H22V10.0571H21.0571Z" />
                </g>
            </svg>
        </div>
    </div>
</div>
<div class="package-details-breadcrumb-bottom">
    <div class="container">
        <div class="details-breadcrumb-bottom-wrapper">
            <div class="left-content">
                <ul>
                    <li>
                        <svg width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.544 3.68665L4.87161 10.3626C4.76529 10.4653 4.63053 10.5186 4.49589 10.5186C4.42605 10.5187 4.35687 10.505 4.29236 10.4782C4.22785 10.4514 4.16929 10.4122 4.12005 10.3626L0.457651 6.70021C0.248491 6.49453 0.248491 6.15781 0.457651 5.94865L1.75173 4.65097C1.95033 4.45249 2.30481 4.45249 2.50341 4.65097L4.49589 6.64346L9.49833 1.63741C9.54761 1.58803 9.60613 1.54883 9.67055 1.52206C9.73498 1.49529 9.80405 1.48148 9.87381 1.48141C10.0155 1.48141 10.1503 1.53817 10.2495 1.63741L11.5436 2.93521C11.7531 3.14437 11.7531 3.48109 11.544 3.68665Z" />
                        </svg>
                        No Booking Fee
                    </li>
                    <li>
                        <svg width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.544 3.68665L4.87161 10.3626C4.76529 10.4653 4.63053 10.5186 4.49589 10.5186C4.42605 10.5187 4.35687 10.505 4.29236 10.4782C4.22785 10.4514 4.16929 10.4122 4.12005 10.3626L0.457651 6.70021C0.248491 6.49453 0.248491 6.15781 0.457651 5.94865L1.75173 4.65097C1.95033 4.45249 2.30481 4.45249 2.50341 4.65097L4.49589 6.64346L9.49833 1.63741C9.54761 1.58803 9.60613 1.54883 9.67055 1.52206C9.73498 1.49529 9.80405 1.48148 9.87381 1.48141C10.0155 1.48141 10.1503 1.53817 10.2495 1.63741L11.5436 2.93521C11.7531 3.14437 11.7531 3.48109 11.544 3.68665Z" />
                        </svg>
                        Best Price Ever
                    </li>
                </ul>
                @if($plot->google_rating)
                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($plot->full_address) }}" class="rating-area" target="_blank">
                    <img src="{{ asset('theme/assets/img/innerpages/icon/tripadvisor-rating.svg') }}" alt="">
                    <strong>({{ number_format($plot->google_rating, 1) }}/5)</strong>
                    <span>based on {{ number_format($plot->google_review_count ?? 0) }} reviews</span>
                </a>
                @endif
            </div>
            <div class="right-content">
                <span>
                    <img src="{{ asset('theme/assets/img/innerpages/icon/carbon-icon.svg') }}" alt="">
                    100% Carbon Neutral
                </span>
                <div class="share-btn">
                    <div class="share-icon">
                        <svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 0C3.13401 0 0 3.13401 0 7C0 10.866 3.13401 14 7 14C10.866 14 14 10.866 14 7C14 3.13401 10.866 0 7 0ZM7 12.6C4.1863 12.6 1.9 10.3137 1.9 7.5C1.9 4.6863 4.1863 2.4 7 2.4C9.8137 2.4 12.1 4.6863 12.1 7.5C12.1 10.3137 9.8137 12.6 7 12.6Z" />
                            <path d="M7 3.5C5.067 3.5 3.5 5.067 3.5 7C3.5 8.933 5.067 10.5 7 10.5C8.933 10.5 10.5 8.933 10.5 7C10.5 5.067 8.933 3.5 7 3.5Z" />
                        </svg>
                    </div>
                    <span>Share</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb section End-->

<!-- Package Details Page Start-->
<div class="package-details-page pt-100 mb-100">
    <div class="container">
        <div class="row g-lg-4 gy-5 justify-content-between">
            <!-- Main Content -->
            <div class="col-xl-7 col-lg-8">
                <div class="package-details-warpper">
                    <!-- About Section -->
                    <div class="package-info-wrap mb-60">
                        <h4>About Venue</h4>
                        @if($plot->description)
                        <p>{{ $plot->description }}</p>
                        @else
                        <p>Experience the perfect venue for your special occasions at {{ $plot->name }}. Located in {{ $plot->city }}{{ $plot->area ? ', ' . $plot->area : '' }}, this venue offers exceptional facilities and amenities for your events.</p>
                        @endif

                        <ul class="package-info-list">
                            @if($plot->capacity_min && $plot->capacity_max)
                            <li>
                                <svg width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 7.5C13.5166 7.5 12.0666 7.93987 10.8332 8.76398C9.59986 9.58809 8.63856 10.7594 8.07091 12.1299C7.50325 13.5003 7.35472 15.0083 7.64411 16.4632C7.9335 17.918 8.64781 19.2544 9.6967 20.3033C10.7456 21.3522 12.082 22.0665 13.5368 22.3559C14.9917 22.6453 16.4997 22.4968 17.8701 21.9291C19.2406 21.3614 20.4119 20.4001 21.236 19.1668C22.0601 17.9334 22.5 16.4834 22.5 15C22.4977 13.0116 21.7068 11.1052 20.3008 9.6992C18.8948 8.29317 16.9884 7.50226 15 7.5ZM15 21.5625C13.7021 21.5625 12.4333 21.1776 11.3541 20.4565C10.2749 19.7354 9.43374 18.7105 8.93704 17.5114C8.44034 16.3122 8.31038 14.9927 8.5636 13.7197C8.81682 12.4467 9.44183 11.2774 10.3596 10.3596C11.2774 9.44183 12.4467 8.81681 13.7197 8.5636C14.9927 8.31038 16.3122 8.44034 17.5114 8.93704C18.7105 9.43374 19.7354 10.2749 20.4565 11.3541C21.1776 12.4333 21.5625 13.7021 21.5625 15C21.5605 16.7399 20.8685 18.4079 19.6382 19.6382C18.4079 20.8685 16.7399 21.5605 15 21.5625Z" />
                                    <path d="M14.9995 25.8957C11.8192 25.8957 8.82259 24.667 6.56136 22.4362C6.50199 22.3776 6.45506 22.3076 6.42338 22.2305C6.3917 22.1533 6.37593 22.0706 6.377 21.9872C6.39342 20.6736 6.69743 19.4152 7.28065 18.2472C8.7517 15.3008 11.7092 13.4706 14.9996 13.4706C19.6974 13.4706 23.5672 17.2912 23.6258 21.9872C23.6269 22.0706 23.6111 22.1534 23.5793 22.2306C23.5476 22.3077 23.5006 22.3777 23.4411 22.4362C21.1802 24.6673 18.1823 25.8957 14.9995 25.8957ZM7.62427 21.7389C9.62799 23.6221 12.2363 24.6561 14.9995 24.6561C17.7649 24.6561 20.3748 23.6224 22.3785 21.7392C22.1904 17.8396 18.9341 14.7098 14.9995 14.7098C12.182 14.7098 9.64904 16.2772 8.38965 18.8006C7.92947 19.7222 7.67262 20.7092 7.62427 21.7389ZM24.4612 13.2562C22.5809 13.2562 21.0509 11.7262 21.0509 9.84586C21.0509 7.96547 22.5809 6.43591 24.4612 6.43591C26.3416 6.43591 27.8715 7.96583 27.8715 9.84621C27.8715 11.7266 26.3419 13.2562 24.4612 13.2562ZM24.4612 7.67544C23.2645 7.67544 22.2905 8.64938 22.2905 9.84615C22.2905 11.0429 23.2645 12.0169 24.4612 12.0169C25.658 12.0169 26.632 11.0429 26.632 9.84615C26.632 8.64938 25.6583 7.67544 24.4612 7.67544Z" />
                                </svg>
                                <div class="content">
                                    <span>Capacity</span>
                                    <strong>{{ number_format($plot->capacity_min) }} - {{ number_format($plot->capacity_max) }} guests</strong>
                                </div>
                            </li>
                            @endif

                            @if($plot->price_range_min || $plot->price_range_max)
                            <li>
                                <svg width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M23.207 4.6875H6.80078C6.47723 4.6875 6.21484 4.94988 6.21484 5.27344V15C6.21484 15.3236 6.47723 15.5859 6.80078 15.5859H23.207C23.5306 15.5859 23.793 15.3236 23.793 15V5.27344C23.793 4.94988 23.5306 4.6875 23.207 4.6875ZM14.418 14.4141H7.38672V5.85938H14.418V14.4141ZM22.6211 14.4141H15.5898V5.85938H22.6211V14.4141ZM17.3477 2.34375H12.6602C12.3366 2.34375 12.0742 2.60613 12.0742 2.92969C12.0742 3.25324 12.3366 3.51562 12.6602 3.51562H17.3477C17.6712 3.51562 17.9336 3.25324 17.9336 2.92969C17.9336 2.60613 17.6712 2.34375 17.3477 2.34375ZM21.4492 17.3438C20.1569 17.3438 19.1055 18.3952 19.1055 19.6875C19.1055 20.9798 20.1569 22.0312 21.4492 22.0312C22.7416 22.0312 23.793 20.9798 23.793 19.6875C23.793 18.3952 22.7416 17.3438 21.4492 17.3438ZM21.4492 20.8594C20.803 20.8594 20.2773 20.3337 20.2773 19.6875C20.2773 19.0413 20.803 18.5156 21.4492 18.5156C22.0954 18.5156 22.6211 19.0413 22.6211 19.6875C22.6211 20.3337 22.0954 20.8594 21.4492 20.8594ZM8.55859 17.3438C7.26625 17.3438 6.21484 18.3952 6.21484 19.6875C6.21484 20.9798 7.26631 22.0312 8.55859 22.0312C9.85094 22.0312 10.9023 20.9798 10.9023 19.6875C10.9023 18.3952 9.85094 17.3438 8.55859 17.3438ZM8.55859 20.8594C7.91242 20.8594 7.38672 20.3337 7.38672 19.6875C7.38672 19.0413 7.91242 18.5156 8.55859 18.5156C9.20477 18.5156 9.73047 19.0413 9.73047 19.6875C9.73047 20.3337 9.20477 20.8594 8.55859 20.8594ZM17.3477 17.9297H12.6602C12.3366 17.9297 12.0742 18.1921 12.0742 18.5156C12.0742 18.8392 12.3366 19.1016 12.6602 19.1016H17.3477C17.6712 19.1016 17.9336 18.8392 17.9336 18.5156C17.9336 18.1921 17.6713 17.9297 17.3477 17.9297ZM17.3477 20.2734H12.6602C12.3366 20.2734 12.0742 20.5358 12.0742 20.8594C12.0742 21.1829 12.3366 21.4453 12.6602 21.4453H17.3477C17.6712 21.4453 17.9336 21.1829 17.9336 20.8594C17.9336 20.5358 17.6713 20.2734 17.3477 20.2734Z" />
                                </svg>
                                <div class="content">
                                    <span>Price Range</span>
                                    <strong>₹{{ number_format($plot->price_range_min ?? 0) }} - ₹{{ number_format($plot->price_range_max ?? 0) }}</strong>
                                </div>
                            </li>
                            @endif

                            @if($plot->area_lawn || $plot->area_banquet)
                            <li>
                                <svg width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M27.6562 3.75H25.7812V2.34375C25.7812 1.05141 24.7298 0 23.4375 0C22.1452 0 21.0938 1.05141 21.0938 2.34375V3.75H8.90625V2.34375C8.90625 1.05141 7.85484 0 6.5625 0C5.27016 0 4.21875 1.05141 4.21875 2.34375V3.75H2.34375C1.05141 3.75 0 4.80141 0 6.09375V27.6562C0 28.9486 1.05141 30 2.34375 30H27.6562C28.9486 30 30 28.9486 30 27.6562V6.09375C30 4.80141 28.9486 3.75 27.6562 3.75Z" />
                                </svg>
                                <div class="content">
                                    <span>Area</span>
                                    <strong>
                                        @if($plot->area_lawn) Lawn: {{ $plot->area_lawn }} @endif
                                        @if($plot->area_lawn && $plot->area_banquet) | @endif
                                        @if($plot->area_banquet) Banquet: {{ $plot->area_banquet }} @endif
                                    </strong>
                                </div>
                            </li>
                            @endif

                            @if($plot->category)
                            <li>
                                <svg width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.55227 10.4163C6.94457 10.4159 6.36185 10.1745 5.93203 9.74487C5.50221 9.31529 5.26043 8.7327 5.25977 8.12501C5.25977 6.86251 6.28852 5.83376 7.55227 5.83376C8.81477 5.83376 9.84352 6.86126 9.84352 8.12501C9.84352 9.38751 8.81602 10.4163 7.55227 10.4163ZM7.55227 6.97876C7.25752 6.99252 6.97941 7.1193 6.77569 7.33276C6.57197 7.54621 6.45831 7.82994 6.45831 8.12501C6.45831 8.42007 6.57197 8.7038 6.77569 8.91725C6.97941 9.13071 7.25752 9.25749 7.55227 9.27126C7.84701 9.25749 8.12512 9.13071 8.32884 8.91725C8.53256 8.7038 8.64622 8.42007 8.64622 8.12501C8.64622 7.82994 8.53256 7.54621 8.32884 7.33276C8.12512 7.1193 7.84701 6.99252 7.55227 6.97876ZM24.166 7.26501H12.7085C12.5567 7.26501 12.4111 7.20469 12.3037 7.09732C12.1963 6.98996 12.136 6.84434 12.136 6.69251C12.136 6.54067 12.1963 6.39505 12.3037 6.28769C12.4111 6.18032 12.5567 6.12001 12.7085 6.12001H24.166C24.3179 6.12001 24.4635 6.18032 24.5708 6.28769C24.6782 6.39505 24.7385 6.54067 24.7385 6.69251C24.7385 6.84434 24.6782 6.98996 24.5708 7.09732C24.4635 7.20469 24.3179 7.26501 24.166 7.26501ZM19.5835 10.13H12.7085C12.5567 10.13 12.4111 10.0697 12.3037 9.96232C12.1963 9.85496 12.136 9.70934 12.136 9.55751C12.136 9.40567 12.1963 9.26005 12.3037 9.15269C12.4111 9.04532 12.5567 8.98501 12.7085 8.98501H19.5835C19.7354 8.98501 19.881 9.04532 19.9883 9.15269C20.0957 9.26005 20.156 9.40567 20.156 9.55751C20.156 9.70934 20.0957 9.85496 19.9883 9.96232C19.881 10.0697 19.7354 10.13 19.5835 10.13ZM7.55227 17.2913C6.94457 17.2909 6.36185 17.0495 5.93203 16.6199C5.50221 16.1903 5.26043 15.6077 5.25977 15C5.25977 13.7375 6.28852 12.7088 7.55227 12.7088C8.81477 12.7088 9.84352 13.7363 9.84352 15C9.84352 16.2625 8.81602 17.2913 7.55227 17.2913ZM7.55227 13.8538C7.25752 13.8675 6.97941 13.9943 6.77569 14.2078C6.57197 14.4212 6.45831 14.7049 6.45831 15C6.45831 15.2951 6.57197 15.5788 6.77569 15.7923C6.97941 16.0057 7.25752 16.1325 7.55227 16.1463C7.84701 16.1325 8.12512 16.0057 8.32884 15.7923C8.53256 15.5788 8.64622 15.2951 8.64622 15C8.64622 14.7049 8.53256 14.4212 8.32884 14.2078C8.12512 13.9943 7.84701 13.8675 7.55227 13.8538ZM24.166 14.1413H12.7085C12.5565 14.1413 12.4107 14.0809 12.3033 13.9734C12.1958 13.8659 12.1354 13.7201 12.1354 13.5681C12.1354 13.4161 12.1958 13.2704 12.3033 13.1629C12.4107 13.0554 12.5565 12.995 12.7085 12.995H24.166C24.3179 12.995 24.4635 13.0553 24.5708 13.1627C24.6782 13.2701 24.7385 13.4157 24.7385 13.5675C24.7385 13.7193 24.6782 13.865 24.5708 13.9723C24.4635 14.0797 24.3179 14.1413 24.166 14.1413ZM19.5835 17.005H12.7085C12.5567 17.005 12.4111 16.9447 12.3037 16.8373C12.1963 16.73 12.136 16.5843 12.136 16.4325C12.136 16.2807 12.1963 16.1351 12.3037 16.0277C12.4111 15.9203 12.5567 15.86 12.7085 15.86H19.5835C19.7354 15.86 19.881 15.9203 19.9883 16.0277C20.0957 16.1351 20.156 16.2807 20.156 16.4325C20.156 16.5843 20.0957 16.73 19.9883 16.8373C19.881 16.9447 19.7354 17.005 19.5835 17.005ZM7.55227 24.1663C6.94457 24.1659 6.36185 23.9245 5.93203 23.4949C5.50221 23.0653 5.26043 22.4827 5.25977 21.875C5.25977 20.6125 6.28852 19.5838 7.55227 19.5838C8.81477 19.5838 9.84352 20.6113 9.84352 21.875C9.84352 23.1375 8.81602 24.1663 7.55227 24.1663ZM7.55227 20.7288C7.25752 20.7425 6.97941 20.8693 6.77569 21.0828C6.57197 21.2962 6.45831 21.5799 6.45831 21.875C6.45831 22.1701 6.57197 22.4538 6.77569 22.6673C6.97941 22.8807 7.25752 23.0075 7.55227 23.0213C7.84701 23.0075 8.12512 22.8807 8.32884 22.6673C8.53256 22.4538 8.64622 22.1701 8.64622 21.875C8.64622 21.5799 8.53256 21.2962 8.32884 21.0828C8.12512 20.8693 7.84701 20.7425 7.55227 20.7288ZM24.166 21.0163H12.7085C12.5565 21.0163 12.4107 20.9559 12.3033 20.8484C12.1958 20.7409 12.1354 20.5951 12.1354 20.4431C12.1354 20.2911 12.1958 20.1454 12.3033 20.0379C12.4107 19.9304 12.5565 19.87 12.7085 19.87H24.166C24.3179 19.87 24.4635 19.9303 24.5708 20.0377C24.6782 20.1451 24.7385 20.2907 24.7385 20.4425C24.7385 20.5943 24.6782 20.74 24.5708 20.8473C24.4635 20.9547 24.3179 21.0163 24.166 21.0163ZM19.5835 23.88H12.7085C12.5567 23.88 12.4111 23.8197 12.3037 23.7123C12.1963 23.605 12.136 23.4593 12.136 23.3075C12.136 23.1557 12.1963 23.0101 12.3037 22.9027C12.4111 22.7953 12.5567 22.735 12.7085 22.735H19.5835C19.7354 22.735 19.881 22.7953 19.9883 22.9027C20.0957 23.0101 20.156 23.1557 20.156 23.3075C20.156 23.4593 20.0957 23.605 19.9883 23.7123C19.881 23.8197 19.7354 23.88 19.5835 23.88Z"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M21.4162 2.39625H8.58375C7.28125 2.39625 6.3725 2.39625 5.66625 2.455C4.9725 2.51125 4.575 2.6175 4.2725 2.77C3.62556 3.09959 3.09959 3.62556 2.77 4.2725C2.61625 4.575 2.51125 4.9725 2.455 5.66625C2.39625 6.3725 2.39625 7.28125 2.39625 8.58375V21.4162C2.39625 22.7187 2.39625 23.6262 2.455 24.3337C2.51125 25.0275 2.6175 25.425 2.77 25.7275C3.09959 26.3744 3.62556 26.9004 4.2725 27.23C4.575 27.3837 4.9725 27.4887 5.66625 27.545C6.3725 27.6037 7.28125 27.6037 8.58375 27.6037H21.4162C22.7187 27.6037 23.6262 27.6037 24.3337 27.545C25.0275 27.4887 25.425 27.3825 25.7275 27.23C26.3744 26.9004 26.9004 26.3744 27.23 25.7275C27.3837 25.425 27.4887 25.0275 27.545 24.3337C27.6037 23.6262 27.6037 22.7187 27.6037 21.4162V8.58375C27.6037 7.28125 27.6037 6.3725 27.545 5.66625C27.4887 4.9725 27.3825 4.575 27.23 4.2725C26.9004 3.62556 26.3744 3.09959 25.7275 2.77C25.425 2.61625 25.0275 2.51125 24.3337 2.455C23.6262 2.39625 22.7187 2.39625 21.4162 2.39625ZM1.75 3.7525C1.25 4.7325 1.25 6.01625 1.25 8.58375V21.4162C1.25 23.9837 1.25 25.2662 1.75 26.2475C2.18875 27.11 2.89 27.81 3.7525 28.25C4.7325 28.75 6.01625 28.75 8.58375 28.75H21.4162C23.9837 28.75 25.2662 28.75 26.2475 28.25C27.1096 27.8105 27.8105 27.1096 28.25 26.2475C28.75 25.2675 28.75 23.9837 28.75 21.4162V8.58375C28.75 6.01625 28.75 4.73375 28.25 3.7525C27.8106 2.89036 27.1096 2.1894 26.2475 1.75C25.2675 1.25 23.9837 1.25 21.4162 1.25H8.58375C6.01625 1.25 4.73375 1.25 3.7525 1.75C2.89 2.18875 2.19 2.89 1.75 3.7525Z"></path>
                                </svg>
                                <div class="content">
                                    <span>Category</span>
                                    <strong>{{ $plot->category->name }}</strong>
                                </div>
                            </li>
                            @endif

                            @if($plot->google_rating)
                            <li>
                                <svg width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 0L18.3677 10.1823L29 11.7553L21.5 19.3177L23.1353 29.7553L15 24.5L6.86466 29.7553L8.5 19.3177L1 11.7553L11.6323 10.1823L15 0Z" />
                                </svg>
                                <div class="content">
                                    <span>Rating</span>
                                    <strong>{{ number_format($plot->google_rating, 1) }} @if($plot->google_review_count) ({{ number_format($plot->google_review_count) }} reviews) @endif</strong>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>

                    <!-- Amenities Section -->
                    @if($plot->parking || $plot->ac_available || $plot->generator_backup || $plot->rooms || $plot->dj_allowed || $plot->decoration_allowed || $plot->catering_allowed)
                    <div class="highlights-tour-area mb-60">
                        <h4>Amenities & Facilities</h4>
                        <div class="highlights-wrap">
                            <ul class="items-list">
                                @if($plot->parking)
                                <li>
                                    <i class="fa-solid fa-car" style="color: var(--primary-color1); font-size: 16px;"></i>
                                    Parking Available
                                </li>
                                @endif
                                @if($plot->ac_available)
                                <li>
                                    <i class="fa-solid fa-snowflake" style="color: var(--primary-color1); font-size: 16px;"></i>
                                    Air Conditioning
                                </li>
                                @endif
                                @if($plot->generator_backup)
                                <li>
                                    <i class="fa-solid fa-plug" style="color: var(--primary-color1); font-size: 16px;"></i>
                                    Generator Backup
                                </li>
                                @endif
                                @if($plot->rooms)
                                <li>
                                    <i class="fa-solid fa-door-open" style="color: var(--primary-color1); font-size: 16px;"></i>
                                    Rooms Available
                                </li>
                                @endif
                                @if($plot->dj_allowed)
                                <li>
                                    <i class="fa-solid fa-music" style="color: var(--primary-color1); font-size: 16px;"></i>
                                    DJ Allowed
                                </li>
                                @endif
                                @if($plot->decoration_allowed)
                                <li>
                                    <i class="fa-solid fa-paintbrush" style="color: var(--primary-color1); font-size: 16px;"></i>
                                    Decoration Allowed
                                </li>
                                @endif
                                @if($plot->catering_allowed)
                                <li>
                                    <i class="fa-solid fa-utensils" style="color: var(--primary-color1); font-size: 16px;"></i>
                                    Catering Allowed
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    @endif

                    <!-- Suitable Events -->
                    @if($plot->suitable_events)
                    @php
                        $events = $plot->suitable_events_array;
                    @endphp
                    @if(count($events) > 0)
                    <div class="highlights-tour-area mb-60">
                        <h4>Suitable Events</h4>
                        <div class="highlights-wrap">
                            <ul class="items-list">
                                @foreach($events as $event)
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15 8C15 4.13401 11.866 1 8 1C4.13401 1 1 4.13401 1 8C1 11.866 4.13401 15 8 15V16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8C16 12.4183 12.4183 16 8 16V15C11.866 15 15 11.866 15 8Z" />
                                        <path d="M11.6947 6.45795L7.24644 10.9086C7.17556 10.9771 7.08572 11.0126 6.99596 11.0126C6.9494 11.0127 6.90328 11.0035 6.86027 10.9857C6.81727 10.9678 6.77822 10.9416 6.7454 10.9086L4.3038 8.46699C4.16436 8.32987 4.16436 8.10539 4.3038 7.96595L5.16652 7.10083C5.29892 6.96851 5.53524 6.96851 5.66764 7.10083L6.99596 8.42915L10.3309 5.09179C10.3638 5.05887 10.4028 5.03274 10.4457 5.01489C10.4887 4.99705 10.5347 4.98784 10.5812 4.98779C10.6757 4.98779 10.7656 5.02563 10.8317 5.09179L11.6944 5.95699C11.8341 6.09643 11.8341 6.32091 11.6947 6.45795Z" />
                                    </svg>
                                    {{ $event }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                    @endif

                    <!-- Tags -->
                    @if($plot->tags && is_array($plot->tags) && count($plot->tags) > 0)
                    <div class="highlights-tour-area mb-60">
                        <h4>Tags</h4>
                        <div class="highlights-wrap">
                            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                @foreach($plot->tags as $tag)
                                <span style="background: var(--primary-color1); color: white; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 500;">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Location Map -->
                    @if($plot->latitude && $plot->longitude)
                    <div class="map-area mb-60">
                        <h4>Venue Location Map</h4>
                        <div id="map" style="height: 400px; border-radius: 10px; margin-top: 20px;"></div>
                    </div>
                    @endif

                    <!-- Features List -->
                    <div class="feature-list-area mb-60">
                        <h4>Venue Features List</h4>
                        <div class="row gy-md-5 gy-4 justify-content-between">
                            <div class="col-lg-5 col-md-6">
                                <div class="single-feature-list">
                                    <h5>Include Features</h5>
                                    <ul class="items-list two">
                                        @if($plot->parking)
                                        <li>
                                            <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15 8C15 4.13401 11.866 1 8 1C4.13401 1 1 4.13401 1 8C1 11.866 4.13401 15 8 15V16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8C16 12.4183 12.4183 16 8 16V15C11.866 15 15 11.866 15 8Z" />
                                                <path d="M11.6947 6.45795L7.24644 10.9086C7.17556 10.9771 7.08572 11.0126 6.99596 11.0126C6.9494 11.0127 6.90328 11.0035 6.86027 10.9857C6.81727 10.9678 6.77822 10.9416 6.7454 10.9086L4.3038 8.46699C4.16436 8.32987 4.16436 8.10539 4.3038 7.96595L5.16652 7.10083C5.29892 6.96851 5.53524 6.96851 5.66764 7.10083L6.99596 8.42915L10.3309 5.09179C10.3638 5.05887 10.4028 5.03274 10.4457 5.01489C10.4887 4.99705 10.5347 4.98784 10.5812 4.98779C10.6757 4.98779 10.7656 5.02563 10.8317 5.09179L11.6944 5.95699C11.8341 6.09643 11.8341 6.32091 11.6947 6.45795Z" />
                                            </svg>
                                            Parking Facility
                                        </li>
                                        @endif
                                        @if($plot->ac_available)
                                        <li>
                                            <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15 8C15 4.13401 11.866 1 8 1C4.13401 1 1 4.13401 1 8C1 11.866 4.13401 15 8 15V16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8C16 12.4183 12.4183 16 8 16V15C11.866 15 15 11.866 15 8Z" />
                                                <path d="M11.6947 6.45795L7.24644 10.9086C7.17556 10.9771 7.08572 11.0126 6.99596 11.0126C6.9494 11.0127 6.90328 11.0035 6.86027 10.9857C6.81727 10.9678 6.77822 10.9416 6.7454 10.9086L4.3038 8.46699C4.16436 8.32987 4.16436 8.10539 4.3038 7.96595L5.16652 7.10083C5.29892 6.96851 5.53524 6.96851 5.66764 7.10083L6.99596 8.42915L10.3309 5.09179C10.3638 5.05887 10.4028 5.03274 10.4457 5.01489C10.4887 4.99705 10.5347 4.98784 10.5812 4.98779C10.6757 4.98779 10.7656 5.02563 10.8317 5.09179L11.6944 5.95699C11.8341 6.09643 11.8341 6.32091 11.6947 6.45795Z" />
                                            </svg>
                                            Air Conditioning
                                        </li>
                                        @endif
                                        @if($plot->generator_backup)
                                        <li>
                                            <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15 8C15 4.13401 11.866 1 8 1C4.13401 1 1 4.13401 1 8C1 11.866 4.13401 15 8 15V16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8C16 12.4183 12.4183 16 8 16V15C11.866 15 15 11.866 15 8Z" />
                                                <path d="M11.6947 6.45795L7.24644 10.9086C7.17556 10.9771 7.08572 11.0126 6.99596 11.0126C6.9494 11.0127 6.90328 11.0035 6.86027 10.9857C6.81727 10.9678 6.77822 10.9416 6.7454 10.9086L4.3038 8.46699C4.16436 8.32987 4.16436 8.10539 4.3038 7.96595L5.16652 7.10083C5.29892 6.96851 5.53524 6.96851 5.66764 7.10083L6.99596 8.42915L10.3309 5.09179C10.3638 5.05887 10.4028 5.03274 10.4457 5.01489C10.4887 4.99705 10.5347 4.98784 10.5812 4.98779C10.6757 4.98779 10.7656 5.02563 10.8317 5.09179L11.6944 5.95699C11.8341 6.09643 11.8341 6.32091 11.6947 6.45795Z" />
                                            </svg>
                                            Generator Backup
                                        </li>
                                        @endif
                                        @if($plot->rooms)
                                        <li>
                                            <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15 8C15 4.13401 11.866 1 8 1C4.13401 1 1 4.13401 1 8C1 11.866 4.13401 15 8 15V16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8C16 12.4183 12.4183 16 8 16V15C11.866 15 15 11.866 15 8Z" />
                                                <path d="M11.6947 6.45795L7.24644 10.9086C7.17556 10.9771 7.08572 11.0126 6.99596 11.0126C6.9494 11.0127 6.90328 11.0035 6.86027 10.9857C6.81727 10.9678 6.77822 10.9416 6.7454 10.9086L4.3038 8.46699C4.16436 8.32987 4.16436 8.10539 4.3038 7.96595L5.16652 7.10083C5.29892 6.96851 5.53524 6.96851 5.66764 7.10083L6.99596 8.42915L10.3309 5.09179C10.3638 5.05887 10.4028 5.03274 10.4457 5.01489C10.4887 4.99705 10.5347 4.98784 10.5812 4.98779C10.6757 4.98779 10.7656 5.02563 10.8317 5.09179L11.6944 5.95699C11.8341 6.09643 11.8341 6.32091 11.6947 6.45795Z" />
                                            </svg>
                                            Rooms Available
                                        </li>
                                        @endif
                                        @if($plot->dj_allowed)
                                        <li>
                                            <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15 8C15 4.13401 11.866 1 8 1C4.13401 1 1 4.13401 1 8C1 11.866 4.13401 15 8 15V16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8C16 12.4183 12.4183 16 8 16V15C11.866 15 15 11.866 15 8Z" />
                                                <path d="M11.6947 6.45795L7.24644 10.9086C7.17556 10.9771 7.08572 11.0126 6.99596 11.0126C6.9494 11.0127 6.90328 11.0035 6.86027 10.9857C6.81727 10.9678 6.77822 10.9416 6.7454 10.9086L4.3038 8.46699C4.16436 8.32987 4.16436 8.10539 4.3038 7.96595L5.16652 7.10083C5.29892 6.96851 5.53524 6.96851 5.66764 7.10083L6.99596 8.42915L10.3309 5.09179C10.3638 5.05887 10.4028 5.03274 10.4457 5.01489C10.4887 4.99705 10.5347 4.98784 10.5812 4.98779C10.6757 4.98779 10.7656 5.02563 10.8317 5.09179L11.6944 5.95699C11.8341 6.09643 11.8341 6.32091 11.6947 6.45795Z" />
                                            </svg>
                                            DJ Allowed
                                        </li>
                                        @endif
                                        @if($plot->decoration_allowed)
                                        <li>
                                            <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15 8C15 4.13401 11.866 1 8 1C4.13401 1 1 4.13401 1 8C1 11.866 4.13401 15 8 15V16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8C16 12.4183 12.4183 16 8 16V15C11.866 15 15 11.866 15 8Z" />
                                                <path d="M11.6947 6.45795L7.24644 10.9086C7.17556 10.9771 7.08572 11.0126 6.99596 11.0126C6.9494 11.0127 6.90328 11.0035 6.86027 10.9857C6.81727 10.9678 6.77822 10.9416 6.7454 10.9086L4.3038 8.46699C4.16436 8.32987 4.16436 8.10539 4.3038 7.96595L5.16652 7.10083C5.29892 6.96851 5.53524 6.96851 5.66764 7.10083L6.99596 8.42915L10.3309 5.09179C10.3638 5.05887 10.4028 5.03274 10.4457 5.01489C10.4887 4.99705 10.5347 4.98784 10.5812 4.98779C10.6757 4.98779 10.7656 5.02563 10.8317 5.09179L11.6944 5.95699C11.8341 6.09643 11.8341 6.32091 11.6947 6.45795Z" />
                                            </svg>
                                            Decoration Allowed
                                        </li>
                                        @endif
                                        @if($plot->catering_allowed)
                                        <li>
                                            <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15 8C15 4.13401 11.866 1 8 1C4.13401 1 1 4.13401 1 8C1 11.866 4.13401 15 8 15V16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8C16 12.4183 12.4183 16 8 16V15C11.866 15 15 11.866 15 8Z" />
                                                <path d="M11.6947 6.45795L7.24644 10.9086C7.17556 10.9771 7.08572 11.0126 6.99596 11.0126C6.9494 11.0127 6.90328 11.0035 6.86027 10.9857C6.81727 10.9678 6.77822 10.9416 6.7454 10.9086L4.3038 8.46699C4.16436 8.32987 4.16436 8.10539 4.3038 7.96595L5.16652 7.10083C5.29892 6.96851 5.53524 6.96851 5.66764 7.10083L6.99596 8.42915L10.3309 5.09179C10.3638 5.05887 10.4028 5.03274 10.4457 5.01489C10.4887 4.99705 10.5347 4.98784 10.5812 4.98779C10.6757 4.98779 10.7656 5.02563 10.8317 5.09179L11.6944 5.95699C11.8341 6.09643 11.8341 6.32091 11.6947 6.45795Z" />
                                            </svg>
                                            Catering Allowed
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6">
                                <div class="single-feature-list">
                                    <h5>Additional Information</h5>
                                    <ul class="items-list two">
                                        @if($plot->capacity_min && $plot->capacity_max)
                                        <li>
                                            <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15 8C15 4.13401 11.866 1 8 1C4.13401 1 1 4.13401 1 8C1 11.866 4.13401 15 8 15V16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8C16 12.4183 12.4183 16 8 16V15C11.866 15 15 11.866 15 8Z" />
                                                <path d="M11.6947 6.45795L7.24644 10.9086C7.17556 10.9771 7.08572 11.0126 6.99596 11.0126C6.9494 11.0127 6.90328 11.0035 6.86027 10.9857C6.81727 10.9678 6.77822 10.9416 6.7454 10.9086L4.3038 8.46699C4.16436 8.32987 4.16436 8.10539 4.3038 7.96595L5.16652 7.10083C5.29892 6.96851 5.53524 6.96851 5.66764 7.10083L6.99596 8.42915L10.3309 5.09179C10.3638 5.05887 10.4028 5.03274 10.4457 5.01489C10.4887 4.99705 10.5347 4.98784 10.5812 4.98779C10.6757 4.98779 10.7656 5.02563 10.8317 5.09179L11.6944 5.95699C11.8341 6.09643 11.8341 6.32091 11.6947 6.45795Z" />
                                            </svg>
                                            Capacity: {{ number_format($plot->capacity_min) }} - {{ number_format($plot->capacity_max) }} guests
                                        </li>
                                        @endif
                                        @if($plot->area_lawn || $plot->area_banquet)
                                        <li>
                                            <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15 8C15 4.13401 11.866 1 8 1C4.13401 1 1 4.13401 1 8C1 11.866 4.13401 15 8 15V16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8C16 12.4183 12.4183 16 8 16V15C11.866 15 15 11.866 15 8Z" />
                                                <path d="M11.6947 6.45795L7.24644 10.9086C7.17556 10.9771 7.08572 11.0126 6.99596 11.0126C6.9494 11.0127 6.90328 11.0035 6.86027 10.9857C6.81727 10.9678 6.77822 10.9416 6.7454 10.9086L4.3038 8.46699C4.16436 8.32987 4.16436 8.10539 4.3038 7.96595L5.16652 7.10083C5.29892 6.96851 5.53524 6.96851 5.66764 7.10083L6.99596 8.42915L10.3309 5.09179C10.3638 5.05887 10.4028 5.03274 10.4457 5.01489C10.4887 4.99705 10.5347 4.98784 10.5812 4.98779C10.6757 4.98779 10.7656 5.02563 10.8317 5.09179L11.6944 5.95699C11.8341 6.09643 11.8341 6.32091 11.6947 6.45795Z" />
                                            </svg>
                                            @if($plot->area_lawn) Lawn Area: {{ $plot->area_lawn }} @endif
                                            @if($plot->area_lawn && $plot->area_banquet) | @endif
                                            @if($plot->area_banquet) Banquet Area: {{ $plot->area_banquet }} @endif
                                        </li>
                                        @endif
                                        @if($plot->google_rating)
                                        <li>
                                            <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15 8C15 4.13401 11.866 1 8 1C4.13401 1 1 4.13401 1 8C1 11.866 4.13401 15 8 15V16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8C16 12.4183 12.4183 16 8 16V15C11.866 15 15 11.866 15 8Z" />
                                                <path d="M11.6947 6.45795L7.24644 10.9086C7.17556 10.9771 7.08572 11.0126 6.99596 11.0126C6.9494 11.0127 6.90328 11.0035 6.86027 10.9857C6.81727 10.9678 6.77822 10.9416 6.7454 10.9086L4.3038 8.46699C4.16436 8.32987 4.16436 8.10539 4.3038 7.96595L5.16652 7.10083C5.29892 6.96851 5.53524 6.96851 5.66764 7.10083L6.99596 8.42915L10.3309 5.09179C10.3638 5.05887 10.4028 5.03274 10.4457 5.01489C10.4887 4.99705 10.5347 4.98784 10.5812 4.98779C10.6757 4.98779 10.7656 5.02563 10.8317 5.09179L11.6944 5.95699C11.8341 6.09643 11.8341 6.32091 11.6947 6.45795Z" />
                                            </svg>
                                            Google Rating: {{ number_format($plot->google_rating, 1) }}/5
                                        </li>
                                        @endif
                                        @if($plot->verified)
                                        <li>
                                            <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15 8C15 4.13401 11.866 1 8 1C4.13401 1 1 4.13401 1 8C1 11.866 4.13401 15 8 15V16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8C16 12.4183 12.4183 16 8 16V15C11.866 15 15 11.866 15 8Z" />
                                                <path d="M11.6947 6.45795L7.24644 10.9086C7.17556 10.9771 7.08572 11.0126 6.99596 11.0126C6.9494 11.0127 6.90328 11.0035 6.86027 10.9857C6.81727 10.9678 6.77822 10.9416 6.7454 10.9086L4.3038 8.46699C4.16436 8.32987 4.16436 8.10539 4.3038 7.96595L5.16652 7.10083C5.29892 6.96851 5.53524 6.96851 5.66764 7.10083L6.99596 8.42915L10.3309 5.09179C10.3638 5.05887 10.4028 5.03274 10.4457 5.01489C10.4887 4.99705 10.5347 4.98784 10.5812 4.98779C10.6757 4.98779 10.7656 5.02563 10.8317 5.09179L11.6944 5.95699C11.8341 6.09643 11.8341 6.32091 11.6947 6.45795Z" />
                                            </svg>
                                            Verified Venue
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="additional-info mb-60">
                        <h4>Additional Info</h4>
                        <ul class="items-list two">
                            <li>
                                <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 8C15 4.13401 11.866 1 8 1C4.13401 1 1 4.13401 1 8C1 11.866 4.13401 15 8 15V16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8C16 12.4183 12.4183 16 8 16V15C11.866 15 15 11.866 15 8Z" />
                                    <path d="M11.6947 6.45795L7.24644 10.9086C7.17556 10.9771 7.08572 11.0126 6.99596 11.0126C6.9494 11.0127 6.90328 11.0035 6.86027 10.9857C6.81727 10.9678 6.77822 10.9416 6.7454 10.9086L4.3038 8.46699C4.16436 8.32987 4.16436 8.10539 4.3038 7.96595L5.16652 7.10083C5.29892 6.96851 5.53524 6.96851 5.66764 7.10083L6.99596 8.42915L10.3309 5.09179C10.3638 5.05887 10.4028 5.03274 10.4457 5.01489C10.4887 4.99705 10.5347 4.98784 10.5812 4.98779C10.6757 4.98779 10.7656 5.02563 10.8317 5.09179L11.6944 5.95699C11.8341 6.09643 11.8341 6.32091 11.6947 6.45795Z" />
                                </svg>
                                <div class="content">
                                    <span>Free Cancellation</span> – Some venues offer free cancellation up to a certain period (e.g., 24–48 hours before the event).
                                </div>
                            </li>
                            <li>
                                <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 8C15 4.13401 11.866 1 8 1C4.13401 1 1 4.13401 1 8C1 11.866 4.13401 15 8 15V16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8C16 12.4183 12.4183 16 8 16V15C11.866 15 15 11.866 15 8Z" />
                                    <path d="M11.6947 6.45795L7.24644 10.9086C7.17556 10.9771 7.08572 11.0126 6.99596 11.0126C6.9494 11.0127 6.90328 11.0035 6.86027 10.9857C6.81727 10.9678 6.77822 10.9416 6.7454 10.9086L4.3038 8.46699C4.16436 8.32987 4.16436 8.10539 4.3038 7.96595L5.16652 7.10083C5.29892 6.96851 5.53524 6.96851 5.66764 7.10083L6.99596 8.42915L10.3309 5.09179C10.3638 5.05887 10.4028 5.03274 10.4457 5.01489C10.4887 4.99705 10.5347 4.98784 10.5812 4.98779C10.6757 4.98779 10.7656 5.02563 10.8317 5.09179L11.6944 5.95699C11.8341 6.09643 11.8341 6.32091 11.6947 6.45795Z" />
                                </svg>
                                <div class="content">
                                    <span>Health & Safety Guidelines</span> – COVID-19 regulations, safety measures, or venue restrictions.
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- FAQ Section -->
                    <div class="faq-area mb-60">
                        <h4>Frequently Asked & Question</h4>
                        <div class="faq-wrap">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h5 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#flush-collapseOne" aria-expanded="false"
                                            aria-controls="flush-collapseOne">What is the capacity of this venue?</button>
                                    </h5>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            @if($plot->capacity_min && $plot->capacity_max)
                                            This venue can accommodate {{ number_format($plot->capacity_min) }} to {{ number_format($plot->capacity_max) }} guests, making it perfect for both intimate gatherings and large celebrations.
                                            @else
                                            Please contact us for specific capacity details based on your event requirements.
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h5 class="accordion-header" id="flush-headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                            aria-controls="flush-collapseTwo">What amenities are included?</button>
                                    </h5>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            The venue includes various amenities such as @if($plot->parking) parking, @endif @if($plot->ac_available) air conditioning, @endif @if($plot->generator_backup) generator backup, @endif and more. Please check the amenities section above for a complete list of available facilities.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h5 class="accordion-header" id="flush-headingThree">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseThree"
                                            aria-expanded="false" aria-controls="flush-collapseThree">What is the pricing structure?</button>
                                    </h5>
                                    <div id="flush-collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            @if($plot->price_range_min || $plot->price_range_max)
                                            Pricing starts from ₹{{ number_format($plot->price_range_min ?? $plot->price_range_max) }} and varies based on event type, duration, and additional services. Please contact us for a detailed quote tailored to your specific requirements.
                                            @else
                                            Pricing varies based on event type, duration, and additional services. Please contact us for a detailed quote tailored to your specific requirements.
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h5 class="accordion-header" id="flush-headingFour">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseFour"
                                            aria-expanded="false" aria-controls="flush-collapseFour">Can I customize the venue setup?</button>
                                    </h5>
                                    <div id="flush-collapseFour" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            @if($plot->decoration_allowed)
                                            Yes, decoration is allowed at this venue. You can customize the setup according to your preferences. Please discuss your specific requirements with our team during booking.
                                            @else
                                            Please contact us to discuss customization options and any restrictions that may apply to venue setup.
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="package-details-sidebar">
                    <div class="pricing-and-booking-area mb-40">
                        @if($plot->price_range_min || $plot->price_range_max)
                        <div class="price-area">
                            <h6>Starting From</h6>
                            <span>₹{{ number_format($plot->price_range_min ?? $plot->price_range_max) }}</span>
                        </div>
                        @endif

                        <!-- Enquiry Form -->
                        <form id="sidebarEnquiryForm">
                            @csrf
                            <input type="hidden" name="party_plot_id" value="{{ $plot->id }}">
                            <div class="single-input-box mb-20">
                                <label>Your Name *</label>
                                <input type="text" name="name" placeholder="Your Name" required>
                            </div>
                            <div class="single-input-box mb-20">
                                <label>Event Date</label>
                                <input type="date" name="event_date" class="calendar-field">
                            </div>
                            <div class="single-input-box mb-20">
                                <label>Mobile Number *</label>
                                <input type="tel" name="phone" id="phone-input" placeholder="Your Mobile Number" required>
                                <small class="text-muted d-block mt-1">Enter 10-digit mobile number or with country code (+91)</small>
                            </div>
                            <button type="submit" class="primary-btn1 w-100">
                                <span>Enquire Now</span>
                                <span>Enquire Now</span>
                            </button>
                        </form>
                        @if($plot->verified)
                        <div class="batch mt-3" style="display: inline-block;">
                            <span><i class="fa-solid fa-check-circle"></i> Verified Venue</span>
                        </div>
                        @endif
                    </div>

                    <!-- Contact Information Card -->
                    @php
                        $phoneNumbers = [];
                        if ($plot->phone) {
                            // Check if phone contains multiple numbers (comma or semicolon separated)
                            $phones = preg_split('/[,;]/', $plot->phone);
                            foreach ($phones as $phone) {
                                $phone = trim($phone);
                                if ($phone) {
                                    $phoneNumbers[] = $phone;
                                }
                            }
                        }
                    @endphp
                    @if(count($phoneNumbers) > 0 || $plot->email || $plot->full_address)
                    <div class="contact-info-banner-wrap">
                        <h2><span>Get In</span> Touch!</h2>
                        <ul>
                            @if(count($phoneNumbers) > 0)
                            <li>
                                <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="9" cy="9" r="8.5" />
                                    <path d="M13.6193 7.0722L8.05903 12.6355C7.97043 12.7211 7.85813 12.7655 7.74593 12.7655C7.68772 12.7656 7.63008 12.7541 7.57632 12.7318C7.52256 12.7095 7.47376 12.6768 7.43272 12.6355L4.38073 9.5835C4.20642 9.4121 4.20642 9.1315 4.38073 8.9572L5.45912 7.8758C5.62462 7.7104 5.92002 7.7104 6.08552 7.8758L7.74593 9.5362L11.9146 5.3645C11.9557 5.32334 12.0045 5.29068 12.0581 5.26837C12.1118 5.24606 12.1694 5.23455 12.2275 5.2345C12.3456 5.2345 12.4579 5.2818 12.5406 5.3645L13.619 6.446C13.7936 6.6203 13.7936 6.9009 13.6193 7.0722Z" />
                                </svg>
                                @foreach($phoneNumbers as $index => $phone)
                                    @if($index > 0), @endif{{ $phone }}
                                @endforeach
                            </li>
                            @endif
                            @if($plot->email)
                            <li>
                                <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="9" cy="9" r="8.5" />
                                    <path d="M13.6193 7.0722L8.05903 12.6355C7.97043 12.7211 7.85813 12.7655 7.74593 12.7655C7.68772 12.7656 7.63008 12.7541 7.57632 12.7318C7.52256 12.7095 7.47376 12.6768 7.43272 12.6355L4.38073 9.5835C4.20642 9.4121 4.20642 9.1315 4.38073 8.9572L5.45912 7.8758C5.62462 7.7104 5.92002 7.7104 6.08552 7.8758L7.74593 9.5362L11.9146 5.3645C11.9557 5.32334 12.0045 5.29068 12.0581 5.26837C12.1118 5.24606 12.1694 5.23455 12.2275 5.2345C12.3456 5.2345 12.4579 5.2818 12.5406 5.3645L13.619 6.446C13.7936 6.6203 13.7936 6.9009 13.6193 7.0722Z" />
                                </svg>
                                {{ $plot->email }}
                            </li>
                            @endif
                            @if($plot->full_address || $plot->city)
                            <li>
                                <i class="fa fa-map-marker"></i>
                                {{ $plot->full_address }}{{ $plot->city ? ', ' . $plot->city : '' }}{{ $plot->area ? ', ' . $plot->area : '' }}
                            </li>
                            @endif
                        </ul>
                        @if(count($phoneNumbers) > 0)
                        <div class="contact-action-area">
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phoneNumbers[0]) }}" class="primary-btn1 two contact-bg">
                                <span>
                                    Call Now
                                    <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.73535 1.14746C9.57033 1.97255 9.32924 3.26406 9.24902 4.66797C9.16817 6.08312 9.25559 7.5453 9.70214 8.73633C9.84754 9.12406 9.65129 9.55659 9.26367 9.70215C8.9001 9.83849 8.4969 9.67455 8.32812 9.33398L8.29785 9.26367L8.19921 8.98438C7.73487 7.5758 7.67054 5.98959 7.75097 4.58203C7.77875 4.09598 7.82525 3.62422 7.87988 3.17969L1.53027 9.53027C1.23738 9.82317 0.762615 9.82317 0.469722 9.53027C0.176829 9.23738 0.176829 8.76262 0.469722 8.46973L6.83593 2.10254C6.3319 2.16472 5.79596 2.21841 5.25 2.24902C3.8302 2.32862 2.2474 2.26906 0.958003 1.79102L0.704097 1.68945L0.635738 1.65527C0.303274 1.47099 0.157578 1.06102 0.310542 0.704102C0.463655 0.347333 0.860941 0.170391 1.22363 0.28418L1.29589 0.310547L1.48828 0.387695C2.47399 0.751207 3.79966 0.827571 5.16601 0.750977C6.60111 0.670504 7.97842 0.428235 8.86132 0.262695L9.95312 0.0585938L9.73535 1.14746Z" />
                                    </path>
                                </svg>
                            </span>
                            <span>
                                Call Now
                                <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.73535 1.14746C9.57033 1.97255 9.32924 3.26406 9.24902 4.66797C9.16817 6.08312 9.25559 7.5453 9.70214 8.73633C9.84754 9.12406 9.65129 9.55659 9.26367 9.70215C8.9001 9.83849 8.4969 9.67455 8.32812 9.33398L8.29785 9.26367L8.19921 8.98438C7.73487 7.5758 7.67054 5.98959 7.75097 4.58203C7.77875 4.09598 7.82525 3.62422 7.87988 3.17969L1.53027 9.53027C1.23738 9.82317 0.762615 9.82317 0.469722 9.53027C0.176829 9.23738 0.176829 8.76262 0.469722 8.46973L6.83593 2.10254C6.3319 2.16472 5.79596 2.21841 5.25 2.24902C3.8302 2.32862 2.2474 2.26906 0.958003 1.79102L0.704097 1.68945L0.635738 1.65527C0.303274 1.47099 0.157578 1.06102 0.310542 0.704102C0.463655 0.347333 0.860941 0.170391 1.22363 0.28418L1.29589 0.310547L1.48828 0.387695C2.47399 0.751207 3.79966 0.827571 5.16601 0.750977C6.60111 0.670504 7.97842 0.428235 8.86132 0.262695L9.95312 0.0585938L9.73535 1.14746Z" />
                                </path>
                            </svg>
                        </span>
                    </a>
                        </div>
                        @endif
                    </div>
                    @endif
                    <!-- Social Links -->
                    @if($plot->website || $plot->facebook || $plot->instagram || $plot->twitter || $plot->youtube)
                    <div class="single-widgets mb-40">
                        <div class="widget-title">
                            <h5>Follow Us</h5>
                        </div>
                        <div class="social-links d-flex gap-2">
                            @if($plot->website)
                            <a href="{{ $plot->website }}" target="_blank"><i class="fa-solid fa-globe"></i></a>
                            @endif
                            @if($plot->facebook)
                            <a href="{{ $plot->facebook }}" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                            @endif
                            @if($plot->instagram)
                            <a href="{{ $plot->instagram }}" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                            @endif
                            @if($plot->twitter)
                            <a href="{{ $plot->twitter }}" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                            @endif
                            @if($plot->youtube)
                            <a href="{{ $plot->youtube }}" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                            @endif
                        </div>
                    </div>
                    @endif
                    <!-- Visitors Count -->
                    @if($plot->visitors > 0)
                    <div class="single-widgets mb-40">
                        <div class="widget-title">
                            <h5>Statistics</h5>
                        </div>
                        <div class="form-inner">
                            <p style="margin: 0;"><i class="fa-solid fa-eye"></i> {{ number_format($plot->visitors) }} views</p>
                        </div>
                    </div>
                    @endif

                    <!-- Customize Package Banner -->
                    <div class="customize-package-banner-wrap">
                        <h2><span>Customize</span> Your Event!</h2>
                        <ul>
                            <li>
                                <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="9" cy="9" r="8.5" />
                                    <path d="M13.6193 7.0722L8.05903 12.6355C7.97043 12.7211 7.85813 12.7655 7.74593 12.7655C7.68772 12.7656 7.63008 12.7541 7.57632 12.7318C7.52256 12.7095 7.47376 12.6768 7.43272 12.6355L4.38073 9.5835C4.20642 9.4121 4.20642 9.1315 4.38073 8.9572L5.45912 7.8758C5.62462 7.7104 5.92002 7.7104 6.08552 7.8758L7.74593 9.5362L11.9146 5.3645C11.9557 5.32334 12.0045 5.29068 12.0581 5.26837C12.1118 5.24606 12.1694 5.23455 12.2275 5.2345C12.3456 5.2345 12.4579 5.2818 12.5406 5.3645L13.619 6.446C13.7936 6.6203 13.7936 6.9009 13.6193 7.0722Z" />
                                </svg>
                                Make Your Favourite Event
                            </li>
                            <li>
                                <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="9" cy="9" r="8.5" />
                                    <path d="M13.6193 7.0722L8.05903 12.6355C7.97043 12.7211 7.85813 12.7655 7.74593 12.7655C7.68772 12.7656 7.63008 12.7541 7.57632 12.7318C7.52256 12.7095 7.47376 12.6768 7.43272 12.6355L4.38073 9.5835C4.20642 9.4121 4.20642 9.1315 4.38073 8.9572L5.45912 7.8758C5.62462 7.7104 5.92002 7.7104 6.08552 7.8758L7.74593 9.5362L11.9146 5.3645C11.9557 5.32334 12.0045 5.29068 12.0581 5.26837C12.1118 5.24606 12.1694 5.23455 12.2275 5.2345C12.3456 5.2345 12.4579 5.2818 12.5406 5.3645L13.619 6.446C13.7936 6.6203 13.7936 6.9009 13.6193 7.0722Z" />
                                </svg>
                                Enjoy Your Celebration
                            </li>
                        </ul>
                        <div class="counter-area">
                            <ul class="counter-img-grp">
                                <li><img src="{{ asset('theme/assets/img/home3/counter-people-img1.png') }}" alt=""></li>
                                <li><img src="{{ asset('theme/assets/img/home3/counter-people-img2.png') }}" alt=""></li>
                                <li><img src="{{ asset('theme/assets/img/home3/counter-people-img3.png') }}" alt=""></li>
                            </ul>
                            <h6> <strong><span class="counter">60</span>+</strong> Events Hosted Successfully</h6>
                        </div>
                        <a href="#sidebarEnquiryForm" class="primary-btn1 two black-bg" onclick="document.getElementById('sidebarEnquiryForm').scrollIntoView({behavior: 'smooth', block: 'start'}); return false;">
                            <span>
                                Customize Event
                                <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.73535 1.14746C9.57033 1.97255 9.32924 3.26406 9.24902 4.66797C9.16817 6.08312 9.25559 7.5453 9.70214 8.73633C9.84754 9.12406 9.65129 9.55659 9.26367 9.70215C8.9001 9.83849 8.4969 9.67455 8.32812 9.33398L8.29785 9.26367L8.19921 8.98438C7.73487 7.5758 7.67054 5.98959 7.75097 4.58203C7.77875 4.09598 7.82525 3.62422 7.87988 3.17969L1.53027 9.53027C1.23738 9.82317 0.762615 9.82317 0.469722 9.53027C0.176829 9.23738 0.176829 8.76262 0.469722 8.46973L6.83593 2.10254C6.3319 2.16472 5.79596 2.21841 5.25 2.24902C3.8302 2.32862 2.2474 2.26906 0.958003 1.79102L0.704097 1.68945L0.635738 1.65527C0.303274 1.47099 0.157578 1.06102 0.310542 0.704102C0.463655 0.347333 0.860941 0.170391 1.22363 0.28418L1.29589 0.310547L1.48828 0.387695C2.47399 0.751207 3.79966 0.827571 5.16601 0.750977C6.60111 0.670504 7.97842 0.428235 8.86132 0.262695L9.95312 0.0585938L9.73535 1.14746Z" />
                                </path>
                            </svg>
                            </span>
                            <span>
                                Customize Event
                                <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.73535 1.14746C9.57033 1.97255 9.32924 3.26406 9.24902 4.66797C9.16817 6.08312 9.25559 7.5453 9.70214 8.73633C9.84754 9.12406 9.65129 9.55659 9.26367 9.70215C8.9001 9.83849 8.4969 9.67455 8.32812 9.33398L8.29785 9.26367L8.19921 8.98438C7.73487 7.5758 7.67054 5.98959 7.75097 4.58203C7.77875 4.09598 7.82525 3.62422 7.87988 3.17969L1.53027 9.53027C1.23738 9.82317 0.762615 9.82317 0.469722 9.53027C0.176829 9.23738 0.176829 8.76262 0.469722 8.46973L6.83593 2.10254C6.3319 2.16472 5.79596 2.21841 5.25 2.24902C3.8302 2.32862 2.2474 2.26906 0.958003 1.79102L0.704097 1.68945L0.635738 1.65527C0.303274 1.47099 0.157578 1.06102 0.310542 0.704102C0.463655 0.347333 0.860941 0.170391 1.22363 0.28418L1.29589 0.310547L1.48828 0.387695C2.47399 0.751207 3.79966 0.827571 5.16601 0.750977C6.60111 0.670504 7.97842 0.428235 8.86132 0.262695L9.95312 0.0585938L9.73535 1.14746Z" />
                                </path>
                            </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Package Details Page End-->

<!-- Enquiry Modal -->
<div class="modal fade" id="enquiryModal" tabindex="-1" aria-labelledby="enquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enquiryModalLabel">Send Enquiry for {{ $plot->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="enquiryForm">
                    @csrf
                    <input type="hidden" name="party_plot_id" value="{{ $plot->id }}">
                    <div class="single-input-box mb-20">
                        <label>Your Name *</label>
                        <input type="text" name="name" required>
                    </div>
                    <div class="single-input-box mb-20">
                        <label>Email *</label>
                        <input type="email" name="email" required>
                    </div>
                    <div class="single-input-box mb-20">
                        <label>Phone *</label>
                        <input type="tel" name="phone" required>
                    </div>
                    <div class="single-input-box mb-20">
                        <label>Event Date</label>
                        <input type="date" name="event_date">
                    </div>
                    <div class="single-input-box mb-20">
                        <label>Message</label>
                        <textarea name="message" rows="4"></textarea>
                    </div>
                    <button type="submit" class="primary-btn1 w-100">
                        <span>Submit Enquiry</span>
                        <span>Submit Enquiry</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/brands.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    /* Contact Information Card Styles */
    .contact-info-card {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .contact-item-card {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 20px;
        display: flex;
        align-items: flex-start;
        gap: 15px;
        transition: all 0.3s ease;
    }
    .contact-item-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    .contact-icon {
        width: 45px;
        height: 45px;
        min-width: 45px;
        background: var(--primary-color1);
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    .contact-content {
        flex: 1;
    }
    .contact-content h6 {
        font-size: 14px;
        font-weight: 600;
        color: var(--title-color);
        margin-bottom: 8px;
    }
    .phone-item {
        margin-bottom: 5px;
    }
    .phone-link {
        color: var(--text-color);
        text-decoration: none;
        font-size: 15px;
        font-weight: 500;
        transition: color 0.3s ease;
    }
    .phone-link:hover {
        color: var(--primary-color1);
    }
    .call-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--primary-color1);
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        margin-top: 10px;
        transition: all 0.3s ease;
    }
    .call-btn:hover {
        background: var(--primary-color2);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
    .call-btn i {
        font-size: 14px;
    }
    .email-link {
        color: var(--text-color);
        text-decoration: none;
        font-size: 15px;
        transition: color 0.3s ease;
    }
    .email-link:hover {
        color: var(--primary-color1);
    }
    .address-text {
        color: var(--text-color);
        font-size: 14px;
        line-height: 1.6;
        margin: 0;
    }

    .social-links a {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-color1);
        color: white;
        border-radius: 50%;
        text-decoration: none;
        transition: all 0.3s;
    }
    .social-links a:hover {
        background: var(--title-color);
        transform: translateY(-3px);
    }
    #map {
        width: 100%;
    }
    /* Smooth scroll for anchor links */
    html {
        scroll-behavior: smooth;
    }
    /* Fix for customize banner section */
    .customize-package-banner-wrap {
        margin-top: 60px;
    }
    /* Contact Information Banner Card - Simple Design */
    .contact-info-banner-wrap {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 15px;
        padding: 30px 25px;
        margin: 40px 0;
    }
    .contact-info-banner-wrap h2 {
        color: var(--title-color);
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 20px;
    }
    .contact-info-banner-wrap h2 span {
        color: var(--primary-color1);
    }
    .contact-info-banner-wrap ul {
        list-style: none;
        padding: 0;
        margin: 0 0 25px 0;
    }
    .contact-info-banner-wrap ul li {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
        font-size: 15px;
        color: var(--text-color);
    }
    .contact-info-banner-wrap ul li svg {
        min-width: 18px;
        width: 18px;
        height: 18px;
    }
    .contact-info-banner-wrap ul li svg circle {
        fill: transparent;
        stroke: var(--primary-color1);
    }
    .contact-info-banner-wrap ul li svg path {
        fill: var(--primary-color1);
    }
    .contact-action-area {
        margin-top: 20px;
    }
    .contact-bg {
        background: var(--primary-color1) !important;
        color: white !important;
    }
    .contact-bg:hover {
        background: var(--primary-color2) !important;
        color: white !important;
    }
    .contact-bg span {
        color: inherit;
    }
    /* Form styling fixes */
    .single-input-box {
        position: relative;
    }
    .single-input-box label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--title-color);
    }
    .single-input-box input[type="text"],
    .single-input-box input[type="tel"],
    .single-input-box input[type="date"] {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        font-size: 14px;
        transition: all 0.3s;
    }
    .single-input-box input:focus {
        outline: none;
        border-color: var(--primary-color1);
    }
</style>
@endpush

@push('scripts')
@if($plot->latitude && $plot->longitude)
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initMap&libraries=places" async defer></script>
@endif
<script>
    // Initialize banner slider
    $(document).ready(function() {
        if (typeof Swiper !== 'undefined') {
            var bannerSlider = new Swiper(".home2-banner-slider", {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                navigation: {
                    nextEl: ".banner-slider-next",
                    prevEl: ".banner-slider-prev",
                },
            });
        }
    });

    // Initialize Google Map
    @if($plot->latitude && $plot->longitude)
    function initMap() {
        var location = { lat: {{ $plot->latitude }}, lng: {{ $plot->longitude }} };
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: location,
            mapTypeControl: true,
            streetViewControl: true,
            fullscreenControl: true
        });
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            title: "{{ addslashes($plot->name) }}"
        });
        var infoWindow = new google.maps.InfoWindow({
            content: '<div style="padding: 10px;"><h6 style="margin: 0 0 5px 0; font-weight: 600;">{{ addslashes($plot->name) }}</h6><p style="margin: 0; font-size: 14px;">{{ addslashes($plot->full_address) }}</p></div>'
        });
        marker.addListener('click', function() {
            infoWindow.open(map, marker);
        });
        infoWindow.open(map, marker);
    }
    @endif

    // Sidebar enquiry form submission
    document.getElementById('sidebarEnquiryForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);

        // Validate form
        const name = formData.get('name');
        let phone = formData.get('phone');

        if (!name || !phone) {
            alert('Please fill in all required fields.');
            return;
        }

        // Normalize phone number (remove spaces, dashes, etc.)
        phone = phone.replace(/\s+/g, '').replace(/-/g, '');

        // Validate mobile number - accepts +91XXXXXXXXXX or XXXXXXXXXX (10 digits starting with 6-9)
        let phoneRegex;
        let normalizedPhone = phone;

        // Check if it starts with +91
        if (phone.startsWith('+91')) {
            // Remove +91 and get the remaining digits
            normalizedPhone = phone.substring(3);
            // Validate: should be 10 digits starting with 6-9
            phoneRegex = /^[6-9]\d{9}$/;
            if (!phoneRegex.test(normalizedPhone)) {
                alert('Please enter a valid mobile number. After +91, it should be 10 digits starting with 6, 7, 8, or 9.');
                return;
            }
        } else {
            // Validate: should be 10 digits starting with 6-9
            phoneRegex = /^[6-9]\d{9}$/;
            if (!phoneRegex.test(phone)) {
                alert('Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9, or use format +91XXXXXXXXXX.');
                return;
            }
            normalizedPhone = phone;
        }

        // Update form data with normalized phone number
        formData.set('phone', normalizedPhone);

        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>Submitting...</span>';

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                         document.querySelector('input[name="_token"]')?.value;

        // Submit to backend
        fetch('{{ route("leads.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message || 'Thank you! Your enquiry has been submitted successfully. We will contact you soon.');
                form.reset();
            } else {
                alert('Error: ' + (data.message || 'Something went wrong. Please try again.'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Thank you! Your enquiry has been submitted. We will contact you soon.');
            form.reset();
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
</script>
@endpush
@endsection

