@extends('layouts.app')

@section('title', 'Blogs - Party Plot & Wedding Venue Insights')

@push('meta')
<meta name="description" content="Read our latest blogs about party plots, wedding venues, banquet halls, and event planning tips. Get insights and guides for your special occasions.">
<meta name="keywords" content="party plot blog, wedding venue tips, banquet hall guide, event planning, venue selection">
<meta property="og:title" content="Blogs - Party Plot & Wedding Venue Insights">
<meta property="og:description" content="Read our latest blogs about party plots, wedding venues, banquet halls, and event planning tips.">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ route('blogs.index') }}">
@endpush

@section('content')
<!-- Breadcrumb section Start-->
<div class="breadcrumb-section" style="background-image:linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url({{ asset('theme/assets/img/innerpages/breadcrumb-bg3.jpg') }});">
    <div class="container">
        <div class="banner-content">
            <h1>Our Blogs</h1>
            <ul class="breadcrumb-list">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Blogs</li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumb section End-->

<!-- Blog Listing Page Start-->
<div class="blog-listing-page pt-100 mb-100">
    <div class="container">
        <!-- Search Section -->
        <div class="row mb-50">
            <div class="col-lg-12">
                <form method="GET" action="{{ route('blogs.index') }}" class="blog-search-form">
                    <div class="form-inner2">
                        <input type="text" name="search" placeholder="Search blogs..." value="{{ request('search') }}">
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Blog Grid -->
        <div class="row gy-4">
            @forelse($blogs as $blog)
            <div class="col-lg-4 col-md-6">
                <div class="blog-card">
                    <a href="{{ route('blogs.show', $blog->slug) }}" class="blog-img">
                        @if($blog->image)
                            <img src="{{ getFile($blog->image, 'blogs', 'admin') }}" alt="{{ $blog->title }}">
                        @else
                            <img src="{{ asset('theme/assets/img/home1/blog-img1.jpg') }}" alt="{{ $blog->title }}">
                        @endif
                    </a>
                    <div class="blog-content">
                        <div class="blog-content-top">
                            <h4><a href="{{ route('blogs.show', $blog->slug) }}">{{ $blog->title }}</a></h4>
                            <a href="{{ route('blogs.show', $blog->slug) }}" class="blog-date">
                                <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path
                                            d="M5.33329 9.66683C5.70148 9.66683 5.99996 9.36835 5.99996 9.00016C5.99996 8.63197 5.70148 8.3335 5.33329 8.3335C4.9651 8.3335 4.66663 8.63197 4.66663 9.00016C4.66663 9.36835 4.9651 9.66683 5.33329 9.66683Z"/>
                                        <path
                                            d="M5.33329 12.3333C5.70148 12.3333 5.99996 12.0349 5.99996 11.6667C5.99996 11.2985 5.70148 11 5.33329 11C4.9651 11 4.66663 11.2985 4.66663 11.6667C4.66663 12.0349 4.9651 12.3333 5.33329 12.3333Z"/>
                                        <path
                                            d="M7.99998 9.66683C8.36817 9.66683 8.66665 9.36835 8.66665 9.00016C8.66665 8.63197 8.36817 8.3335 7.99998 8.3335C7.63179 8.3335 7.33331 8.63197 7.33331 9.00016C7.33331 9.36835 7.63179 9.66683 7.99998 9.66683Z"/>
                                        <path
                                            d="M7.99998 12.3333C8.36817 12.3333 8.66665 12.0349 8.66665 11.6667C8.66665 11.2985 8.36817 11 7.99998 11C7.63179 11 7.33331 11.2985 7.33331 11.6667C7.33331 12.0349 7.63179 12.3333 7.99998 12.3333Z"/>
                                        <path
                                            d="M10.6667 9.66683C11.0349 9.66683 11.3333 9.36835 11.3333 9.00016C11.3333 8.63197 11.0349 8.3335 10.6667 8.3335C10.2985 8.3335 10 8.63197 10 9.00016C10 9.36835 10.2985 9.66683 10.6667 9.66683Z"/>
                                        <path
                                            d="M10.6667 12.3333C11.0349 12.3333 11.3333 12.0349 11.3333 11.6667C11.3333 11.2985 11.0349 11 10.6667 11C10.2985 11 10 11.2985 10 11.6667C10 12.0349 10.2985 12.3333 10.6667 12.3333Z"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.833313 13.0002V4.3335C0.833666 3.67056 1.09717 3.03488 1.56594 2.56612C2.0347 2.09735 2.67038 1.83385 3.33331 1.8335H5.49998V3.66683C5.49998 3.79944 5.55266 3.92661 5.64643 4.02038C5.74019 4.11415 5.86737 4.16683 5.99998 4.16683C6.13259 4.16683 6.25976 4.11415 6.35353 4.02038C6.4473 3.92661 6.49998 3.79944 6.49998 3.66683V1.8335H10.8333V3.66683C10.8333 3.79944 10.886 3.92661 10.9798 4.02038C11.0735 4.11415 11.2007 4.16683 11.3333 4.16683C11.4659 4.16683 11.5931 4.11415 11.6869 4.02038C11.7806 3.92661 11.8333 3.79944 11.8333 3.66683V1.8335H12.6666C13.3296 1.83385 13.9653 2.09735 14.434 2.56612C14.9028 3.03488 15.1663 3.67056 15.1666 4.3335V13.0002C15.1663 13.6631 14.9028 14.2988 14.434 14.7675C13.9653 15.2363 13.3296 15.4998 12.6666 15.5002H3.33331C2.67038 15.4998 2.0347 15.2363 1.56594 14.7675C1.09717 14.2988 0.833666 13.6631 0.833313 13.0002ZM1.83331 6.50016V13.0002C1.83331 13.398 1.99135 13.7795 2.27265 14.0608C2.55396 14.3421 2.93549 14.5002 3.33331 14.5002H12.6666C13.0645 14.5002 13.446 14.3421 13.7273 14.0608C14.0086 13.7795 14.1666 13.398 14.1666 13.0002V6.50016H1.83331Z"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10.1666 1C10.1666 0.867392 10.2193 0.740215 10.3131 0.646447C10.4069 0.552678 10.534 0.5 10.6666 0.5C10.7993 0.5 10.9264 0.552678 11.0202 0.646447C11.114 0.740215 11.1666 0.867392 11.1666 1V3.66667C11.1666 3.79927 11.114 3.92645 11.0202 4.02022C10.9264 4.11399 10.7993 4.16667 10.6666 4.16667C10.534 4.16667 10.4069 4.11399 10.3131 4.02022C10.2193 3.92645 10.1666 3.79927 10.1666 3.66667V1ZM4.83331 1C4.83331 0.867392 4.88599 0.740215 4.97976 0.646447C5.07353 0.552678 5.2007 0.5 5.33331 0.5C5.46592 0.5 5.5931 0.552678 5.68687 0.646447C5.78063 0.740215 5.83331 0.867392 5.83331 1V3.66667C5.83331 3.79927 5.78063 3.92645 5.68687 4.02022C5.5931 4.11399 5.46592 4.16667 5.33331 4.16667C5.2007 4.16667 5.07353 4.11399 4.97976 4.02022C4.88599 3.92645 4.83331 3.79927 4.83331 3.66667V1Z"/>
                                    </g>
                                </svg>
                                {{ $blog->created_at->format('d F, Y') }}
                            </a>
                        </div>
                        <svg class="divider" height="6" viewBox="0 0 288 6" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 2.5L0 0.113249V5.88675L5 3.5V2.5ZM283 3.5L288 5.88675V0.113249L283 2.5V3.5ZM4.5 3.5H283.5V2.5H4.5V3.5Z"/>
                        </svg>
                        <p>{{ Str::limit(strip_tags($blog->description), 150) }}</p>
                        <div class="blog-meta">
                            <span><i class="fa fa-eye"></i> {{ $blog->views }} views</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-lg-12">
                <div class="text-center py-5">
                    <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                    <h4>No blogs found</h4>
                    <p class="text-muted">Check back later for new blog posts.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($blogs->hasPages())
        <div class="row mt-50">
            <div class="col-lg-12">
                <div class="pagination-area">
                    {{ $blogs->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- Blog Listing Page End-->
@endsection









