@extends('layouts.admin')

@section('content')
<x-top-header title="Create SEO Link Template" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <i class="fa fa-plus me-2"></i>Create New Template
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('admin.seo-links.templates') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to Templates
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Placeholders Reference -->
                    <div class="alert alert-info mb-4">
                        <h6><i class="fa fa-info-circle"></i> Available Placeholders</h6>
                        <div class="row">
                            @foreach($placeholders as $placeholder => $description)
                                <div class="col-md-4">
                                    <code>{{ $placeholder }}</code> - {{ $description }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <form action="{{ route('admin.seo-links.templates.store') }}" method="POST">
                        @csrf

                        <!-- Basic Information -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">
                                    <i class="fa fa-info-circle me-1"></i> Basic Information
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Template Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" required
                                           placeholder="e.g., City Links Template">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="template_type" class="form-label">Template Type <span class="text-danger">*</span></label>
                                    <select name="template_type" id="template_type" class="form-select @error('template_type') is-invalid @enderror" required>
                                        @foreach($templateTypes as $value => $label)
                                            <option value="{{ $value }}" {{ old('template_type') === $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('template_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="min_venues" class="form-label">Minimum Venues</label>
                                    <input type="number" name="min_venues" id="min_venues" 
                                           class="form-control @error('min_venues') is-invalid @enderror" 
                                           value="{{ old('min_venues', 1) }}" min="1">
                                    @error('min_venues')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Only generate links for combinations with this many venues</small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Link Templates -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">
                                    <i class="fa fa-link me-1"></i> Link Templates
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="link_text_template" class="form-label">Link Text Template <span class="text-danger">*</span></label>
                                    <input type="text" name="link_text_template" id="link_text_template" 
                                           class="form-control @error('link_text_template') is-invalid @enderror" 
                                           value="{{ old('link_text_template') }}" required
                                           placeholder="e.g., Party Plots in {city}">
                                    @error('link_text_template')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Text displayed on the homepage</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug_template" class="form-label">URL Slug Template <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">/venues/</span>
                                        <input type="text" name="slug_template" id="slug_template" 
                                               class="form-control @error('slug_template') is-invalid @enderror" 
                                               value="{{ old('slug_template') }}" required
                                               placeholder="e.g., party-plots-in-{city_slug}">
                                    </div>
                                    @error('slug_template')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Use {city_slug}, {area_slug}, {category_slug} for URL-safe values</small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- SEO Templates -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">
                                    <i class="fa fa-search me-1"></i> SEO Meta Tag Templates
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meta_title_template" class="form-label">Meta Title Template <span class="text-danger">*</span></label>
                                    <input type="text" name="meta_title_template" id="meta_title_template" 
                                           class="form-control @error('meta_title_template') is-invalid @enderror" 
                                           value="{{ old('meta_title_template') }}" required
                                           placeholder="e.g., Best Party Plots in {city} | PartyPlots.in">
                                    @error('meta_title_template')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meta_keywords_template" class="form-label">Meta Keywords Template</label>
                                    <input type="text" name="meta_keywords_template" id="meta_keywords_template" 
                                           class="form-control @error('meta_keywords_template') is-invalid @enderror" 
                                           value="{{ old('meta_keywords_template') }}"
                                           placeholder="e.g., party plots, {city}, wedding venue, banquet hall">
                                    @error('meta_keywords_template')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="meta_description_template" class="form-label">Meta Description Template</label>
                                    <textarea name="meta_description_template" id="meta_description_template" rows="2" 
                                              class="form-control @error('meta_description_template') is-invalid @enderror"
                                              placeholder="e.g., Find {count}+ verified party plots in {city}. Compare prices, capacity, and amenities...">{{ old('meta_description_template') }}</textarea>
                                    @error('meta_description_template')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Page Content Templates -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">
                                    <i class="fa fa-file-alt me-1"></i> Page Content Templates
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="page_title_template" class="form-label">Page Title (H1) Template</label>
                                    <input type="text" name="page_title_template" id="page_title_template" 
                                           class="form-control @error('page_title_template') is-invalid @enderror" 
                                           value="{{ old('page_title_template') }}"
                                           placeholder="e.g., Top Party Plots in {city}">
                                    @error('page_title_template')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="page_description_template" class="form-label">Page Description Template</label>
                                    <textarea name="page_description_template" id="page_description_template" rows="3" 
                                              class="form-control @error('page_description_template') is-invalid @enderror"
                                              placeholder="e.g., Discover the finest party plots in {city} for your special occasions. Browse {count}+ venues...">{{ old('page_description_template') }}</textarea>
                                    @error('page_description_template')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Settings -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">
                                    <i class="fa fa-cog me-1"></i> Settings
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="is_active" id="is_active" 
                                               class="form-check-input" value="1" 
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label for="is_active" class="form-check-label">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Submit -->
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save me-1"></i> Create Template
                                </button>
                                <a href="{{ route('admin.seo-links.templates') }}" class="btn btn-secondary">
                                    <i class="fa fa-times me-1"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-suggest based on template type
    document.getElementById('template_type').addEventListener('change', function() {
        const type = this.value;
        const linkTextInput = document.getElementById('link_text_template');
        const slugInput = document.getElementById('slug_template');
        const metaTitleInput = document.getElementById('meta_title_template');
        
        // Only suggest if fields are empty
        if (!linkTextInput.value && !slugInput.value) {
            const suggestions = {
                'city': {
                    link: 'Party Plots in {city}',
                    slug: 'party-plots-in-{city_slug}',
                    title: 'Best Party Plots in {city} | PartyPlots.in'
                },
                'area': {
                    link: 'Venues in {area}',
                    slug: 'venues-in-{area_slug}',
                    title: 'Top Venues in {area} | PartyPlots.in'
                },
                'category': {
                    link: '{category} for Events',
                    slug: '{category_slug}',
                    title: 'Best {category} for Events | PartyPlots.in'
                },
                'city_category': {
                    link: '{category} in {city}',
                    slug: '{category_slug}-in-{city_slug}',
                    title: 'Best {category} in {city} | PartyPlots.in'
                },
                'area_category': {
                    link: '{category} near {area}',
                    slug: '{category_slug}-near-{area_slug}',
                    title: 'Best {category} near {area} | PartyPlots.in'
                },
                'tags': {
                    link: 'Venues with {tags}',
                    slug: 'venues-with-{tags_slug}',
                    title: 'Best Venues with {tags} | PartyPlots.in'
                },
                'city_tags': {
                    link: '{tags} Venues in {city}',
                    slug: '{tags_slug}-venues-in-{city_slug}',
                    title: 'Best {tags} Venues in {city} | PartyPlots.in'
                },
                'area_tags': {
                    link: '{tags} Venues in {area}',
                    slug: '{tags_slug}-venues-in-{area_slug}',
                    title: 'Best {tags} Venues in {area} | PartyPlots.in'
                },
                'category_tags': {
                    link: '{category} with {tags}',
                    slug: '{category_slug}-with-{tags_slug}',
                    title: 'Best {category} with {tags} | PartyPlots.in'
                }
            };
            
            if (suggestions[type]) {
                linkTextInput.value = suggestions[type].link;
                slugInput.value = suggestions[type].slug;
                metaTitleInput.value = suggestions[type].title;
            }
        }
    });
</script>
@endpush

@endsection


