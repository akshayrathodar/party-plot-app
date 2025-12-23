@extends('layouts.admin')

@section('content')
<x-top-header title="Create SEO Link" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <i class="fa fa-plus me-2"></i>Add New SEO Link
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('admin.seo-links.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to SEO Links
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

                    <form action="{{ route('admin.seo-links.store') }}" method="POST">
                        @csrf

                        <!-- Link Type & Filter -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">
                                    <i class="fa fa-filter me-1"></i> Link Type & Filters
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="link_type" class="form-label">Link Type <span class="text-danger">*</span></label>
                                    <select name="link_type" id="link_type" class="form-select @error('link_type') is-invalid @enderror" required>
                                        @foreach($linkTypes as $value => $label)
                                            <option value="{{ $value }}" {{ old('link_type') === $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('link_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3" id="cityField">
                                <div class="mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <select name="city" id="city" class="form-select @error('city') is-invalid @enderror">
                                        <option value="">Select City</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city }}" {{ old('city') === $city ? 'selected' : '' }}>
                                                {{ $city }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3" id="areaField" style="display: none;">
                                <div class="mb-3">
                                    <label for="area" class="form-label">Area</label>
                                    <select name="area" id="area" class="form-select @error('area') is-invalid @enderror">
                                        <option value="">Select Area</option>
                                        @foreach($areas as $area)
                                            <option value="{{ $area }}" {{ old('area') === $area ? 'selected' : '' }}>
                                                {{ $area }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('area')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3" id="categoryField" style="display: none;">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3" id="tagsField" style="display: none;">
                                <div class="mb-3">
                                    <label for="tags" class="form-label">Tags</label>
                                    <select name="tags[]" id="tags" class="form-select @error('tags') is-invalid @enderror" multiple>
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag }}" {{ in_array($tag, explode(',', old('tags', ''))) ? 'selected' : '' }}>
                                                {{ $tag }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tags')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple tags</small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Link Display -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">
                                    <i class="fa fa-link me-1"></i> Link Display
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="link_text" class="form-label">Link Text <span class="text-danger">*</span></label>
                                    <input type="text" name="link_text" id="link_text" 
                                           class="form-control @error('link_text') is-invalid @enderror" 
                                           value="{{ old('link_text') }}" required
                                           placeholder="e.g., Party Plots in Ahmedabad">
                                    @error('link_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">This text will appear on the homepage in Related Links section</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug" class="form-label">URL Slug</label>
                                    <div class="input-group">
                                        <span class="input-group-text">/venues/</span>
                                        <input type="text" name="slug" id="slug" 
                                               class="form-control @error('slug') is-invalid @enderror" 
                                               value="{{ old('slug') }}"
                                               placeholder="party-plots-in-ahmedabad">
                                    </div>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Leave empty to auto-generate from link text</small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- SEO Settings -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">
                                    <i class="fa fa-search me-1"></i> SEO Meta Tags
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">Meta Title <span class="text-danger">*</span></label>
                                    <input type="text" name="meta_title" id="meta_title" 
                                           class="form-control @error('meta_title') is-invalid @enderror" 
                                           value="{{ old('meta_title') }}" required
                                           placeholder="e.g., Best Party Plots in Ahmedabad | PartyPlots.in">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">This appears in browser tab and search results</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                    <input type="text" name="meta_keywords" id="meta_keywords" 
                                           class="form-control @error('meta_keywords') is-invalid @enderror" 
                                           value="{{ old('meta_keywords') }}"
                                           placeholder="party plots, ahmedabad, wedding venue">
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea name="meta_description" id="meta_description" rows="2" 
                                              class="form-control @error('meta_description') is-invalid @enderror"
                                              placeholder="Find the best party plots in Ahmedabad. Compare prices, capacity, and amenities...">{{ old('meta_description') }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">This appears in search engine results (recommended: 150-160 characters)</small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Page Content -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">
                                    <i class="fa fa-file-alt me-1"></i> Page Content
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="page_title" class="form-label">Page Title (H1)</label>
                                    <input type="text" name="page_title" id="page_title" 
                                           class="form-control @error('page_title') is-invalid @enderror" 
                                           value="{{ old('page_title') }}"
                                           placeholder="e.g., Top Party Plots in Ahmedabad">
                                    @error('page_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Main heading shown on the page (H1 tag)</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="page_description" class="form-label">Page Description</label>
                                    <textarea name="page_description" id="page_description" rows="3" 
                                              class="form-control @error('page_description') is-invalid @enderror"
                                              placeholder="Discover the finest party plots in Ahmedabad for your special occasions...">{{ old('page_description') }}</textarea>
                                    @error('page_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Intro paragraph shown on the page before venue listings</small>
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
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <input type="number" name="sort_order" id="sort_order" 
                                           class="form-control @error('sort_order') is-invalid @enderror" 
                                           value="{{ old('sort_order', 0) }}" min="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Lower numbers appear first</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="is_active" id="is_active" 
                                               class="form-check-input" value="1" 
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label for="is_active" class="form-check-label">Active</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="show_on_homepage" id="show_on_homepage" 
                                               class="form-check-input" value="1" 
                                               {{ old('show_on_homepage', true) ? 'checked' : '' }}>
                                        <label for="show_on_homepage" class="form-check-label">Show on Homepage</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Submit -->
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save me-1"></i> Create SEO Link
                                </button>
                                <a href="{{ route('admin.seo-links.index') }}" class="btn btn-secondary">
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
    // Toggle fields based on link type
    document.getElementById('link_type').addEventListener('change', function() {
        const type = this.value;
        const cityField = document.getElementById('cityField');
        const areaField = document.getElementById('areaField');
        const categoryField = document.getElementById('categoryField');
        const tagsField = document.getElementById('tagsField');

        // Reset all
        cityField.style.display = 'none';
        areaField.style.display = 'none';
        categoryField.style.display = 'none';
        tagsField.style.display = 'none';

        switch(type) {
            case 'city':
                cityField.style.display = 'block';
                break;
            case 'area':
                areaField.style.display = 'block';
                break;
            case 'category':
                categoryField.style.display = 'block';
                break;
            case 'city_category':
                cityField.style.display = 'block';
                categoryField.style.display = 'block';
                break;
            case 'area_category':
                areaField.style.display = 'block';
                categoryField.style.display = 'block';
                break;
            case 'tags':
                tagsField.style.display = 'block';
                break;
            case 'city_tags':
                cityField.style.display = 'block';
                tagsField.style.display = 'block';
                break;
            case 'area_tags':
                areaField.style.display = 'block';
                tagsField.style.display = 'block';
                break;
            case 'category_tags':
                categoryField.style.display = 'block';
                tagsField.style.display = 'block';
                break;
        }
    });

    // Trigger change on page load
    document.getElementById('link_type').dispatchEvent(new Event('change'));

    // Auto-generate slug from link_text
    document.getElementById('link_text').addEventListener('blur', function() {
        const slugInput = document.getElementById('slug');
        if (slugInput.value === '') {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
            slugInput.value = slug;
        }
    });
</script>
@endpush

@endsection


