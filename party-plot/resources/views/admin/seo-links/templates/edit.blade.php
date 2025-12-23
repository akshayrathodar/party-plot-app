@extends('layouts.admin')

@section('content')
<x-top-header title="Edit SEO Link Template" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <i class="fa fa-edit me-2"></i>Edit Template: {{ $template->name }}
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

                    <form action="{{ route('admin.seo-links.templates.update', $template->id) }}" method="POST">
                        @csrf
                        @method('PUT')

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
                                           value="{{ old('name', $template->name) }}" required>
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
                                            <option value="{{ $value }}" {{ old('template_type', $template->template_type) === $value ? 'selected' : '' }}>
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
                                           value="{{ old('min_venues', $template->min_venues) }}" min="1">
                                    @error('min_venues')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                           value="{{ old('link_text_template', $template->link_text_template) }}" required>
                                    @error('link_text_template')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug_template" class="form-label">URL Slug Template <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">/venues/</span>
                                        <input type="text" name="slug_template" id="slug_template" 
                                               class="form-control @error('slug_template') is-invalid @enderror" 
                                               value="{{ old('slug_template', $template->slug_template) }}" required>
                                    </div>
                                    @error('slug_template')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                           value="{{ old('meta_title_template', $template->meta_title_template) }}" required>
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
                                           value="{{ old('meta_keywords_template', $template->meta_keywords_template) }}">
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
                                              class="form-control @error('meta_description_template') is-invalid @enderror">{{ old('meta_description_template', $template->meta_description_template) }}</textarea>
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
                                           value="{{ old('page_title_template', $template->page_title_template) }}">
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
                                              class="form-control @error('page_description_template') is-invalid @enderror">{{ old('page_description_template', $template->page_description_template) }}</textarea>
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
                                               {{ old('is_active', $template->is_active) ? 'checked' : '' }}>
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
                                    <i class="fa fa-save me-1"></i> Update Template
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

@endsection






