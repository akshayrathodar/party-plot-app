@extends('layouts.admin')

@section('content')
<x-top-header title="Categories" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <i class="fa fa-tags me-2"></i>All Categories
                                <span class="badge badge-primary ms-2">{{ $categories->total() }}</span>
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Add Category
                            </a>
                            <form action="{{ route('admin.categories.import') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-info btn-sm" 
                                        onclick="return confirm('This will import categories from party plots. Continue?')">
                                    <i class="fa fa-download"></i> Import from Party Plots
                                </button>
                            </form>
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
                            <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small">Search</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                                        <input type="text" name="search" class="form-control form-control-sm"
                                               placeholder="Search by name, slug, description..."
                                               value="{{ request('search') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small">Status</label>
                                    <select name="is_active" class="form-select form-select-sm">
                                        <option value="">All Status</option>
                                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="fa fa-filter"></i> Filter
                                    </button>
                                </div>
                                @if(request()->hasAny(['search', 'is_active']))
                                <div class="col-12">
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary">
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
                                    <th width="80">Image</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th width="100">Party Plots</th>
                                    <th width="80">Order</th>
                                    <th width="80">Status</th>
                                    <th width="120">Created</th>
                                    <th width="120" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td><strong>#{{ $category->id }}</strong></td>
                                        <td>
                                            @if($category->image)
                                                <img src="{{ getFile($category->image, 'categories', 'admin') ?: asset('uploads/admin/categories/' . $category->image) }}" 
                                                     alt="{{ $category->name }}"
                                                     class="img-thumbnail rounded" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fa fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $category->name }}</strong>
                                            @if($category->description)
                                                <br><small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <code>{{ $category->slug }}</code>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info">{{ $category->party_plots_count ?? 0 }}</span>
                                        </td>
                                        <td class="text-center">
                                            {{ $category->sort_order ?? 0 }}
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $category->is_active ? 'success' : 'danger' }}">
                                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ $category->created_at->format('M d, Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                   class="btn btn-success" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                                      method="POST" style="display:inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" title="Delete"
                                                            {{ ($category->party_plots_count ?? 0) > 0 ? 'disabled' : '' }}>
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
                                                <i class="fa fa-tags fa-3x text-muted mb-3"></i>
                                                <h5>No categories found</h5>
                                                <p class="text-muted">Get started by adding a new category or importing from party plots.</p>
                                                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm mt-2">
                                                    <i class="fa fa-plus"></i> Add Category
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
                        {{ $categories->links('pagination::bootstrap-4') }}
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






