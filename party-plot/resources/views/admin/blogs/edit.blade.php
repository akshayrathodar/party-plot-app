@extends('layouts.admin')

@section('content')
<x-top-header title="Edit Blog" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Blog</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

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
                                <x-input name="title" label="Title" :required="true" :value="$blog->title" />
                            </div>
                            <div class="col-md-4">
                                <x-input name="slug" label="Slug" :value="$blog->slug" />
                                <small class="form-text text-muted">Leave empty to auto-generate from title</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-textarea name="description" label="Description" :required="true" :rows="4" :value="$blog->description" />
                                <small class="form-text text-muted">Short description that will appear in listings</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-text-editor name="content" label="Content" :required="true" :value="old('content', $blog->content)" />
                                <small class="form-text text-muted">Full blog content (supports HTML and rich text formatting)</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Featured Image</label>
                                    @if($blog->image)
                                        <div class="mb-2">
                                            <img src="{{ getFile($blog->image, 'blogs', 'admin') }}"
                                                 alt="{{ $blog->title }}"
                                                 class="img-thumbnail"
                                                 style="max-width: 200px; max-height: 200px;">
                                            <br>
                                            <small class="text-muted">Current image</small>
                                        </div>
                                    @endif
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                    <small class="form-text text-muted">Leave empty to keep current image. Recommended size: 1200x630px (Max: 5MB)</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="draft" {{ old('status', $blog->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status', $blog->status) == 'published' ? 'selected' : '' }}>Published</option>
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
                                <x-input name="meta_title" label="Meta Title" :value="$blog->meta_title" />
                                <small class="form-text text-muted">SEO title (recommended: 50-60 characters)</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-textarea name="meta_description" label="Meta Description" :rows="3" :value="$blog->meta_description" />
                                <small class="form-text text-muted">SEO description (recommended: 150-160 characters)</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-input name="meta_keywords" label="Meta Keywords" :value="$blog->meta_keywords" />
                                <small class="form-text text-muted">Comma-separated keywords for SEO</small>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update Blog
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

