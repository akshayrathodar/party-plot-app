@extends('layouts.admin')

@section('content')
<x-top-header title="Blogs" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <i class="fa fa-blog me-2"></i>All Blogs
                                <span class="badge badge-primary ms-2">{{ $blogs->total() }}</span>
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Add Blog
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
                            <form method="GET" action="{{ route('admin.blogs.index') }}" class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small">Search</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                                        <input type="text" name="search" class="form-control form-control-sm"
                                               placeholder="Search by title, description..."
                                               value="{{ request('search') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small">Status</label>
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="">All Status</option>
                                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small">Sort By</label>
                                    <select name="sort_by" class="form-select form-select-sm">
                                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Date</option>
                                        <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
                                        <option value="views" {{ request('sort_by') == 'views' ? 'selected' : '' }}>Views</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">&nbsp;</label>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-filter"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Blogs Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="80">Image</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Views</th>
                                    <th>Created</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($blogs as $blog)
                                    <tr>
                                        <td>
                                            @if($blog->image)
                                                <img src="{{ getFile($blog->image, 'blogs', 'admin') }}"
                                                     alt="{{ $blog->title }}"
                                                     class="img-thumbnail"
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center"
                                                     style="width: 60px; height: 60px;">
                                                    <i class="fa fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $blog->title }}</strong>
                                            <br>
                                            <small class="text-muted">{{ Str::limit($blog->description, 80) }}</small>
                                        </td>
                                        <td>
                                            @if($blog->status == 'published')
                                                <span class="badge badge-success">Published</span>
                                            @else
                                                <span class="badge badge-warning">Draft</span>
                                            @endif
                                        </td>
                                        <td>
                                            <i class="fa fa-eye"></i> {{ $blog->views }}
                                        </td>
                                        <td>
                                            <small>{{ $blog->created_at->format('M d, Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                                                   class="btn btn-sm btn-primary"
                                                   title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.blogs.destroy', $blog->id) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No blogs found.</p>
                                            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary btn-sm">
                                                <i class="fa fa-plus"></i> Create First Blog
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($blogs->hasPages())
                        <div class="mt-3">
                            {{ $blogs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection









