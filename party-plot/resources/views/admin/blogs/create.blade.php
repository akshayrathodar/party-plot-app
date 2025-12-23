@extends('layouts.admin')

@section('content')
<x-top-header title="Create Blog" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Add New Blog</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Basic Information -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">Basic Information</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <x-input name="title" label="Title" :required="true" />
                            </div>
                            <div class="col-md-4">
                                <x-input name="slug" label="Slug (auto-generated if empty)" />
                                <small class="form-text text-muted">Leave empty to auto-generate from title</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-textarea name="description" label="Description" :required="true" :rows="4" />
                                <small class="form-text text-muted">Short description that will appear in listings</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-text-editor name="content" label="Content" :required="true" :value="old('content')" />
                                <small class="form-text text-muted">Full blog content (supports HTML and rich text formatting)</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Featured Image</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                    <small class="form-text text-muted">Recommended size: 1200x630px (Max: 5MB)</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- SEO Information -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">SEO Information (Optional)</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-input name="meta_title" label="Meta Title" />
                                <small class="form-text text-muted">SEO title (recommended: 50-60 characters)</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-textarea name="meta_description" label="Meta Description" :rows="3" />
                                <small class="form-text text-muted">SEO description (recommended: 150-160 characters)</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-input name="meta_keywords" label="Meta Keywords" />
                                <small class="form-text text-muted">Comma-separated keywords for SEO</small>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Create Blog
                                </button>
                                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> Cancel
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

