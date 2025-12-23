@extends('layouts.admin')

@section('content')
<x-top-header title="Create Category" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <i class="fa fa-plus me-2"></i>Add New Category
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to Categories
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

                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" name="slug" id="slug" 
                                           class="form-control @error('slug') is-invalid @enderror" 
                                           value="{{ old('slug') }}"
                                           placeholder="Auto-generated if empty">
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Leave empty to auto-generate from name</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" rows="3" 
                                              class="form-control @error('description') is-invalid @enderror"
                                              placeholder="Enter category description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Media -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">
                                    <i class="fa fa-image me-1"></i> Category Image (Optional)
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Category Image</label>
                                    <input type="file" name="image" id="image" 
                                           class="form-control @error('image') is-invalid @enderror" 
                                           accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Accepted formats: JPEG, PNG, JPG, GIF, WEBP. Max size: 5MB
                                    </small>
                                </div>
                                <div id="imagePreview" class="mt-2" style="display: none;">
                                    <img src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="icon" class="form-label">Icon Class</label>
                                    <input type="text" name="icon" id="icon" 
                                           class="form-control @error('icon') is-invalid @enderror" 
                                           value="{{ old('icon') }}"
                                           placeholder="e.g., fa fa-home, bi bi-house">
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">FontAwesome or Bootstrap icon class</small>
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
                            <div class="col-md-4">
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
                            <div class="col-md-4">
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
                        </div>

                        <hr class="my-4">

                        <!-- SEO -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">
                                    <i class="fa fa-search me-1"></i> SEO Settings (Optional)
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text" name="meta_title" id="meta_title" 
                                           class="form-control @error('meta_title') is-invalid @enderror" 
                                           value="{{ old('meta_title') }}">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                    <input type="text" name="meta_keywords" id="meta_keywords" 
                                           class="form-control @error('meta_keywords') is-invalid @enderror" 
                                           value="{{ old('meta_keywords') }}"
                                           placeholder="keyword1, keyword2, keyword3">
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
                                              placeholder="Enter meta description for SEO">{{ old('meta_description') }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Submit -->
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save me-1"></i> Create Category
                                </button>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
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
    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.querySelector('img').src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });

    // Auto-generate slug from name
    document.getElementById('name').addEventListener('blur', function() {
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






