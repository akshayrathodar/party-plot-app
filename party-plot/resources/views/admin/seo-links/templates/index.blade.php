@extends('layouts.admin')

@section('content')
<x-top-header title="SEO Link Templates" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <i class="fa fa-file-alt me-2"></i>SEO Link Templates
                                <span class="badge badge-primary ms-2">{{ $templates->total() }}</span>
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('admin.seo-links.templates.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Create Template
                            </a>
                            <a href="{{ route('admin.seo-links.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to SEO Links
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Info Box -->
                    <div class="alert alert-info mb-4">
                        <h6><i class="fa fa-info-circle"></i> About Templates</h6>
                        <p class="mb-2">Templates allow you to bulk generate SEO links using placeholders:</p>
                        <ul class="mb-0">
                            <li><code>{city}</code> - City name (e.g., Ahmedabad)</li>
                            <li><code>{area}</code> - Area name (e.g., Satellite)</li>
                            <li><code>{category}</code> - Category name (e.g., Party Plots)</li>
                            <li><code>{city_slug}</code>, <code>{area_slug}</code>, <code>{category_slug}</code> - URL-friendly versions</li>
                            <li><code>{count}</code> - Number of venues matching criteria</li>
                        </ul>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">ID</th>
                                    <th>Template Name</th>
                                    <th width="120">Type</th>
                                    <th>Link Text Template</th>
                                    <th>Slug Template</th>
                                    <th width="80">Min Venues</th>
                                    <th width="100">Generated</th>
                                    <th width="80">Status</th>
                                    <th width="150" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($templates as $template)
                                    <tr>
                                        <td><strong>#{{ $template->id }}</strong></td>
                                        <td>
                                            <strong>{{ $template->name }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $template->type_label }}</span>
                                        </td>
                                        <td>
                                            <code>{{ Str::limit($template->link_text_template, 30) }}</code>
                                        </td>
                                        <td>
                                            <code>{{ Str::limit($template->slug_template, 30) }}</code>
                                        </td>
                                        <td class="text-center">
                                            {{ $template->min_venues }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info">{{ $template->seo_links_count ?? 0 }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $template->is_active ? 'success' : 'danger' }}">
                                                {{ $template->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.seo-links.bulk-generate') }}?template_id={{ $template->id }}"
                                                   class="btn btn-primary" title="Use Template">
                                                    <i class="fa fa-magic"></i>
                                                </a>
                                                <a href="{{ route('admin.seo-links.templates.edit', $template->id) }}"
                                                   class="btn btn-success" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.seo-links.templates.destroy', $template->id) }}"
                                                      method="POST" style="display:inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this template?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" title="Delete"
                                                            {{ ($template->seo_links_count ?? 0) > 0 ? 'disabled' : '' }}>
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fa fa-file-alt fa-3x text-muted mb-3"></i>
                                                <h5>No templates found</h5>
                                                <p class="text-muted">Create your first template to start bulk generating SEO links.</p>
                                                <a href="{{ route('admin.seo-links.templates.create') }}" class="btn btn-primary btn-sm mt-2">
                                                    <i class="fa fa-plus"></i> Create Template
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $templates->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    .empty-state {
        padding: 2rem;
    }

    .empty-state i {
        opacity: 0.5;
    }
</style>
@endpush

@endsection






