@extends('layouts.admin')

@section('content')
<x-top-header title="SEO Links" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <i class="fa fa-link me-2"></i>All SEO Links
                                <span class="badge badge-primary ms-2">{{ $seoLinks->total() }}</span>
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('admin.seo-links.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Add Link
                            </a>
                            <a href="{{ route('admin.seo-links.bulk-generate') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-magic"></i> Bulk Generate
                            </a>
                            <a href="{{ route('admin.seo-links.templates') }}" class="btn btn-info btn-sm">
                                <i class="fa fa-file-alt"></i> Templates
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

                    <!-- Filters -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <form method="GET" action="{{ route('admin.seo-links.index') }}" class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label small">Search</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                                        <input type="text" name="search" class="form-control form-control-sm"
                                               placeholder="Search by text, slug, city..."
                                               value="{{ request('search') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">Link Type</label>
                                    <select name="link_type" class="form-select form-select-sm">
                                        <option value="">All Types</option>
                                        @foreach($linkTypes as $value => $label)
                                            <option value="{{ $value }}" {{ request('link_type') === $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">Status</label>
                                    <select name="is_active" class="form-select form-select-sm">
                                        <option value="">All Status</option>
                                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">Homepage</label>
                                    <select name="show_on_homepage" class="form-select form-select-sm">
                                        <option value="">All</option>
                                        <option value="1" {{ request('show_on_homepage') === '1' ? 'selected' : '' }}>Shown</option>
                                        <option value="0" {{ request('show_on_homepage') === '0' ? 'selected' : '' }}>Hidden</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="fa fa-filter"></i> Filter
                                    </button>
                                </div>
                                @if(request()->hasAny(['search', 'link_type', 'is_active', 'show_on_homepage']))
                                <div class="col-12">
                                    <a href="{{ route('admin.seo-links.index') }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fa fa-times"></i> Clear Filters
                                    </a>
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">ID</th>
                                    <th>Link Text</th>
                                    <th>URL Slug</th>
                                    <th width="100">Type</th>
                                    <th width="120">Filter</th>
                                    <th width="80">Venues</th>
                                    <th width="60">Order</th>
                                    <th width="80">Status</th>
                                    <th width="80">Homepage</th>
                                    <th width="120" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($seoLinks as $link)
                                    <tr>
                                        <td><strong>#{{ $link->id }}</strong></td>
                                        <td>
                                            <strong>{{ $link->link_text }}</strong>
                                            <br><small class="text-muted">{{ Str::limit($link->meta_title, 40) }}</small>
                                        </td>
                                        <td>
                                            <code>/venues/{{ $link->slug }}</code>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $link->type_label }}</span>
                                        </td>
                                        <td>
                                            @if($link->city)
                                                <small><i class="fa fa-city"></i> {{ $link->city }}</small><br>
                                            @endif
                                            @if($link->area)
                                                <small><i class="fa fa-map-marker"></i> {{ $link->area }}</small><br>
                                            @endif
                                            @if($link->category)
                                                <small><i class="fa fa-tag"></i> {{ $link->category->name }}</small><br>
                                            @endif
                                            @if($link->tags)
                                                <small><i class="fa fa-hashtag"></i> {{ $link->tags }}</small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info">{{ $link->venue_count }}</span>
                                        </td>
                                        <td class="text-center">
                                            {{ $link->sort_order ?? 0 }}
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $link->is_active ? 'success' : 'danger' }}">
                                                {{ $link->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $link->show_on_homepage ? 'primary' : 'secondary' }}">
                                                {{ $link->show_on_homepage ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.seo-links.edit', $link->id) }}"
                                                   class="btn btn-success" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.seo-links.destroy', $link->id) }}"
                                                      method="POST" style="display:inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this SEO link?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fa fa-link fa-3x text-muted mb-3"></i>
                                                <h5>No SEO links found</h5>
                                                <p class="text-muted">Get started by creating templates and generating links in bulk.</p>
                                                <a href="{{ route('admin.seo-links.templates') }}" class="btn btn-info btn-sm mt-2 me-2">
                                                    <i class="fa fa-file-alt"></i> Create Template
                                                </a>
                                                <a href="{{ route('admin.seo-links.create') }}" class="btn btn-primary btn-sm mt-2">
                                                    <i class="fa fa-plus"></i> Add Link Manually
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
                        {{ $seoLinks->links('pagination::bootstrap-4') }}
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

    .badge {
        padding: 0.35em 0.65em;
        font-weight: 500;
    }
</style>
@endpush

@endsection


