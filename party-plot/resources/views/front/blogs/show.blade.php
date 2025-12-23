@extends('layouts.app')

@section('title', ($blog->meta_title ?: $blog->title) . ' - Party Plot & Wedding Venue Blog')

@push('meta')
<meta name="description" content="{{ $blog->meta_description ?: Str::limit(strip_tags($blog->description), 160) }}">
@if($blog->meta_keywords)
<meta name="keywords" content="{{ $blog->meta_keywords }}">
@endif
<meta property="og:title" content="{{ $blog->meta_title ?: $blog->title }}">
<meta property="og:description" content="{{ $blog->meta_description ?: Str::limit(strip_tags($blog->description), 160) }}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{ route('blogs.show', $blog->slug) }}">
@if($blog->image)
<meta property="og:image" content="{{ getFile($blog->image, 'blogs', 'admin') }}">
@endif
<meta property="article:published_time" content="{{ $blog->created_at->toIso8601String() }}">
<meta property="article:modified_time" content="{{ $blog->updated_at->toIso8601String() }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $blog->meta_title ?: $blog->title }}">
<meta name="twitter:description" content="{{ $blog->meta_description ?: Str::limit(strip_tags($blog->description), 160) }}">
@if($blog->image)
<meta name="twitter:image" content="{{ getFile($blog->image, 'blogs', 'admin') }}">
@endif
<link rel="canonical" href="{{ route('blogs.show', $blog->slug) }}">
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BlogPosting',
    'headline' => $blog->title,
    'description' => strip_tags($blog->description),
    'image' => $blog->image ? getFile($blog->image, 'blogs', 'admin') : '',
    'datePublished' => $blog->created_at->toIso8601String(),
    'dateModified' => $blog->updated_at->toIso8601String(),
    'author' => [
        '@type' => 'Organization',
        'name' => getSetting('company_name', 'Party Plot Platform')
    ],
    'publisher' => [
        '@type' => 'Organization',
        'name' => getSetting('company_name', 'Party Plot Platform'),
        'logo' => [
            '@type' => 'ImageObject',
            'url' => getCompanyLogo()
        ]
    ],
    'mainEntityOfPage' => [
        '@type' => 'WebPage',
        '@id' => route('blogs.show', $blog->slug)
    ]
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')
<!-- Breadcrumb section Start-->
<div class="breadcrumb-section" style="background-image:linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url({{ $blog->image ? getFile($blog->image, 'blogs', 'admin') : asset('theme/assets/img/innerpages/breadcrumb-bg3.jpg') }});">
    <div class="container">
        <div class="banner-content">
            <h1>{{ $blog->title }}</h1>
            <ul class="breadcrumb-list">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('blogs.index') }}">Blogs</a></li>
                <li>{{ Str::limit($blog->title, 30) }}</li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumb section End-->

<!-- Blog Detail Page Start-->
<div class="blog-detail-page pt-100 mb-100">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <article class="blog-detail-content">
                    <!-- Featured Image -->
                    @if($blog->image)
                    <div class="blog-featured-image mb-50">
                        <img src="{{ getFile($blog->image, 'blogs', 'admin') }}" alt="{{ $blog->title }}" class="img-fluid">
                    </div>
                    @endif

                    <!-- Blog Header -->
                    <div class="blog-header mb-40">
                        <div class="blog-meta-tags mb-20">
                            <span class="blog-category-badge">Blog</span>
                            <span class="blog-date-badge">
                                <i class="fa fa-calendar"></i>
                                {{ $blog->created_at->format('F d, Y') }}
                            </span>
                            <span class="blog-views-badge">
                                <i class="fa fa-eye"></i>
                                {{ $blog->views }} views
                            </span>
                        </div>
                        <h1 class="blog-title">{{ $blog->title }}</h1>
                    </div>

                    <!-- Blog Description -->
                    <div class="blog-description mb-50">
                        <p class="blog-excerpt">{{ $blog->description }}</p>
                    </div>

                    <!-- Blog Content -->
                    <div class="blog-content-wrapper">
                        <div class="blog-content">
                            {!! $blog->content !!}
                        </div>
                    </div>

                    <!-- Share Section -->
                    <div class="blog-share-section mt-60">
                        <div class="share-section-header">
                            <h5>Share this article</h5>
                            <p>Help others discover this content</p>
                        </div>
                        <div class="share-buttons-wrapper">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blogs.show', $blog->slug)) }}" 
                               target="_blank" 
                               class="share-btn facebook"
                               rel="noopener noreferrer">
                                <i class="fab fa-facebook-f"></i>
                                <span>Facebook</span>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blogs.show', $blog->slug)) }}&text={{ urlencode($blog->title) }}" 
                               target="_blank" 
                               class="share-btn twitter"
                               rel="noopener noreferrer">
                                <i class="fab fa-twitter"></i>
                                <span>Twitter</span>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blogs.show', $blog->slug)) }}&title={{ urlencode($blog->title) }}" 
                               target="_blank" 
                               class="share-btn linkedin"
                               rel="noopener noreferrer">
                                <i class="fab fa-linkedin-in"></i>
                                <span>LinkedIn</span>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($blog->title . ' ' . route('blogs.show', $blog->slug)) }}" 
                               target="_blank" 
                               class="share-btn whatsapp"
                               rel="noopener noreferrer">
                                <i class="fab fa-whatsapp"></i>
                                <span>WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="blog-sidebar">
                    <!-- Related Blogs -->
                    @if($relatedBlogs->count() > 0)
                    <div class="sidebar-widget">
                        <div class="widget-header">
                            <h5 class="widget-title">Related Articles</h5>
                        </div>
                        <div class="related-blogs-list">
                            @foreach($relatedBlogs as $relatedBlog)
                            <div class="related-blog-card">
                                <a href="{{ route('blogs.show', $relatedBlog->slug) }}" class="related-blog-image">
                                    @if($relatedBlog->image)
                                        <img src="{{ getFile($relatedBlog->image, 'blogs', 'admin') }}" alt="{{ $relatedBlog->title }}">
                                    @else
                                        <img src="{{ asset('theme/assets/img/home1/blog-img1.jpg') }}" alt="{{ $relatedBlog->title }}">
                                    @endif
                                </a>
                                <div class="related-blog-info">
                                    <h6><a href="{{ route('blogs.show', $relatedBlog->slug) }}">{{ $relatedBlog->title }}</a></h6>
                                    <div class="related-blog-meta">
                                        <span class="related-blog-date">
                                            <i class="fa fa-calendar"></i>
                                            {{ $relatedBlog->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- CTA Widget -->
                    <div class="sidebar-widget">
                        <div class="cta-widget-card">
                            <div class="cta-icon">
                                <i class="fa fa-building"></i>
                            </div>
                            <h5>Looking for a Venue?</h5>
                            <p>Find the perfect party plot or wedding venue for your special occasion.</p>
                            <a href="{{ route('party-plots.index') }}" class="primary-btn1">
                                <span>Browse Venues</span>
                                <span>Browse Venues</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog Detail Page End-->

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
/* Blog Detail Content */
.blog-detail-content {
    background: var(--white-color);
    padding: 0;
    border-radius: 0;
    box-shadow: none;
}

/* Featured Image */
.blog-featured-image {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 40px;
    max-width: 100%;
}

.blog-featured-image img {
    width: 100%;
    max-height: 500px;
    height: auto;
    object-fit: cover;
    display: block;
    transition: transform 0.5s ease;
}

.blog-featured-image:hover img {
    transform: scale(1.05);
}

/* Blog Header */
.blog-header {
    padding-bottom: 30px;
    border-bottom: 2px solid var(--borders-color);
}

.blog-meta-tags {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.blog-category-badge,
.blog-date-badge,
.blog-views-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.blog-category-badge {
    background: linear-gradient(135deg, var(--primary-color1) 0%, var(--primary-color2) 100%);
    color: var(--white-color);
}

.blog-date-badge,
.blog-views-badge {
    background: #F0F0F0;
    color: var(--text-color);
}

.blog-date-badge i,
.blog-views-badge i {
    font-size: 12px;
    opacity: 0.8;
}

.blog-title {
    font-size: 36px;
    font-weight: 700;
    font-family: var(--font-poppins);
    color: var(--title-color);
    line-height: 1.3;
    margin: 0;
}

/* Blog Description */
.blog-description {
    padding: 30px 0;
}

.blog-excerpt {
    font-size: 18px;
    line-height: 1.8;
    color: var(--text-color);
    font-weight: 400;
    margin: 0;
    padding: 25px;
    background: #F8F9FA;
    border-left: 4px solid var(--primary-color1);
    border-radius: 8px;
}

/* Blog Content */
.blog-content-wrapper {
    margin-top: 40px;
}

.blog-content {
    font-size: 16px;
    line-height: 1.9;
    color: var(--text-color);
    font-family: var(--font-roboto);
}

.blog-content h1,
.blog-content h2,
.blog-content h3,
.blog-content h4 {
    color: var(--title-color);
    font-family: var(--font-poppins);
    font-weight: 600;
    margin-top: 40px;
    margin-bottom: 20px;
    line-height: 1.4;
}

.blog-content h1 { font-size: 28px; }
.blog-content h2 { font-size: 24px; }
.blog-content h3 { font-size: 20px; }
.blog-content h4 { font-size: 18px; }

.blog-content p {
    margin-bottom: 24px;
    text-align: justify;
}

.blog-content ul,
.blog-content ol {
    margin: 20px 0;
    padding-left: 30px;
}

.blog-content li {
    margin-bottom: 12px;
    line-height: 1.8;
}

.blog-content img {
    max-width: 80%;
    max-height: 400px;
    height: auto;
    width: auto;
    border-radius: 12px;
    margin: 30px auto;
    display: block;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    object-fit: contain;
}

.blog-content blockquote {
    border-left: 4px solid var(--primary-color1);
    padding: 20px 25px;
    margin: 30px 0;
    background: #F8F9FA;
    border-radius: 8px;
    font-style: italic;
    color: var(--text-color);
}

.blog-content a {
    color: var(--primary-color1);
    text-decoration: none;
    transition: all 0.3s ease;
    border-bottom: 1px solid transparent;
}

.blog-content a:hover {
    color: var(--primary-color2);
    border-bottom-color: var(--primary-color2);
}

.blog-content code {
    background: #F0F0F0;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 14px;
    color: var(--title-color);
}

.blog-content pre {
    background: #F0F0F0;
    padding: 20px;
    border-radius: 8px;
    overflow-x: auto;
    margin: 20px 0;
}

/* Share Section */
.blog-share-section {
    padding: 40px;
    background: linear-gradient(135deg, #F8F9FA 0%, #FFFFFF 100%);
    border-radius: 20px;
    border: 1px solid var(--borders-color);
    margin-top: 50px;
}

.share-section-header {
    text-align: center;
    margin-bottom: 30px;
}

.share-section-header h5 {
    font-size: 22px;
    font-weight: 600;
    color: var(--title-color);
    margin-bottom: 8px;
    font-family: var(--font-poppins);
}

.share-section-header p {
    color: var(--text-color);
    font-size: 14px;
    margin: 0;
    opacity: 0.8;
}

.share-buttons-wrapper {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
}

.share-btn {
    padding: 14px 24px;
    border-radius: 12px;
    color: var(--white-color);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    font-weight: 500;
    font-size: 14px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.share-btn i {
    font-size: 16px;
}

.share-btn.facebook { 
    background: linear-gradient(135deg, #1877f2 0%, #0d5dbf 100%);
}

.share-btn.twitter { 
    background: linear-gradient(135deg, #1da1f2 0%, #0c85d0 100%);
}

.share-btn.linkedin { 
    background: linear-gradient(135deg, #0077b5 0%, #005885 100%);
}

.share-btn.whatsapp { 
    background: linear-gradient(135deg, #25d366 0%, #1da851 100%);
}

.share-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

/* Sidebar */
.blog-sidebar {
    position: sticky;
    top: 100px;
}

.sidebar-widget {
    background: var(--white-color);
    border: 1px solid var(--borders-color);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.widget-header {
    margin-bottom: 25px;
    padding-bottom: 20px;
    border-bottom: 2px solid var(--borders-color);
}

.widget-title {
    font-size: 20px;
    font-weight: 600;
    color: var(--title-color);
    font-family: var(--font-poppins);
    margin: 0;
}

/* Related Blogs */
.related-blogs-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.related-blog-card {
    display: flex;
    gap: 15px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--borders-color);
    transition: all 0.3s ease;
}

.related-blog-card:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.related-blog-card:hover {
    transform: translateX(5px);
}

.related-blog-image {
    width: 120px;
    height: 90px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.related-blog-image:hover {
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
}

.related-blog-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.related-blog-image:hover img {
    transform: scale(1.1);
}

.related-blog-info {
    flex: 1;
}

.related-blog-info h6 {
    font-size: 15px;
    font-weight: 600;
    line-height: 1.4;
    margin-bottom: 10px;
    font-family: var(--font-poppins);
}

.related-blog-info h6 a {
    color: var(--title-color);
    text-decoration: none;
    transition: color 0.3s ease;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.related-blog-info h6 a:hover {
    color: var(--primary-color1);
}

.related-blog-meta {
    display: flex;
    align-items: center;
    gap: 15px;
}

.related-blog-date {
    font-size: 12px;
    color: var(--text-color);
    opacity: 0.7;
    display: flex;
    align-items: center;
    gap: 5px;
}

.related-blog-date i {
    font-size: 11px;
}

/* CTA Widget */
.cta-widget-card {
    background: linear-gradient(135deg, var(--primary-color1) 0%, var(--primary-color2) 100%);
    padding: 40px 30px;
    border-radius: 20px;
    color: var(--white-color);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.cta-widget-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: pulse 3s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

.cta-icon {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 30px;
    color: var(--white-color);
}

.cta-widget-card h5 {
    color: var(--white-color);
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 15px;
    font-family: var(--font-poppins);
    position: relative;
    z-index: 1;
}

.cta-widget-card p {
    color: rgba(255, 255, 255, 0.95);
    margin-bottom: 25px;
    font-size: 15px;
    line-height: 1.6;
    position: relative;
    z-index: 1;
}

.cta-widget-card .primary-btn1 {
    position: relative;
    z-index: 1;
    background: var(--white-color);
    color: var(--primary-color1);
}

.cta-widget-card .primary-btn1:hover {
    background: rgba(255, 255, 255, 0.95);
}

/* Responsive Design */
@media (max-width: 991px) {
    .blog-sidebar {
        position: static;
        margin-top: 50px;
    }
}

@media (max-width: 768px) {
    .blog-title {
        font-size: 26px;
    }
    
    .blog-excerpt {
        font-size: 16px;
        padding: 20px;
    }
    
    .blog-content {
        font-size: 15px;
    }
    
    .blog-featured-image img {
        max-height: 300px;
    }
    
    .blog-content img {
        max-width: 100%;
        max-height: 300px;
    }
    
    .blog-share-section {
        padding: 30px 20px;
    }
    
    .share-buttons-wrapper {
        flex-direction: column;
    }
    
    .share-btn {
        width: 100%;
        justify-content: center;
    }
    
    .related-blog-card {
        flex-direction: column;
    }
    
    .related-blog-image {
        width: 100%;
        height: 200px;
    }
    
    .sidebar-widget {
        padding: 20px;
    }
    
    .cta-widget-card {
        padding: 30px 20px;
    }
}

@media (max-width: 576px) {
    .blog-title {
        font-size: 22px;
    }
    
    .blog-meta-tags {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .blog-featured-image {
        border-radius: 15px;
    }
    
    .blog-featured-image img {
        max-height: 250px;
    }
    
    .blog-content img {
        max-width: 100%;
        max-height: 250px;
    }
}
</style>
@endpush
@endsection

