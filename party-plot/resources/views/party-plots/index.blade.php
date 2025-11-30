@extends('layouts.admin')

@section('content')
<x-top-header title="Party Plots" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <i class="fa fa-building me-2"></i>All Party Plots
                                <span class="badge badge-primary ms-2">{{ $partyPlots->total() }}</span>
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('admin.party-plots.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Add Party Plot
                            </a>
                            <a href="{{ route('admin.party-plots.csv-upload') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-upload"></i> Upload CSV
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Import Stats Alert -->
                    @if(session('import_stats'))
                        @php $stats = session('import_stats'); @endphp
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <h6 class="alert-heading"><i class="fa fa-info-circle"></i> Import Summary</h6>
                            <p class="mb-2">
                                <strong>Total:</strong> {{ $stats['total'] }} |
                                <strong>Created:</strong> <span class="text-success">{{ $stats['created'] }}</span> |
                                <strong>Updated:</strong> <span class="text-warning">{{ $stats['updated'] }}</span> |
                                <strong>Skipped:</strong> <span class="text-danger">{{ $stats['skipped'] }}</span>
                            </p>
                            @if(!empty($stats['errors']))
                                <hr>
                                <small><strong>Errors:</strong> {{ implode(', ', array_slice($stats['errors'], 0, 5)) }}
                                @if(count($stats['errors']) > 5)
                                    ... and {{ count($stats['errors']) - 5 }} more
                                @endif
                                </small>
                            @endif
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Filters -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <form method="GET" action="{{ route('admin.party-plots.index') }}" class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label small">Search</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                                        <input type="text" name="search" class="form-control form-control-sm"
                                               placeholder="Search by name, address, city..."
                                               value="{{ request('search') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">Status</label>
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="">All Status</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">Listing Status</label>
                                    <select name="listing_status" class="form-select form-select-sm">
                                        <option value="">All</option>
                                        <option value="pending" {{ request('listing_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ request('listing_status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ request('listing_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">City</label>
                                    <select name="city" class="form-select form-select-sm">
                                        <option value="">All Cities</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">Verified</label>
                                    <select name="verified" class="form-select form-select-sm">
                                        <option value="">All</option>
                                        <option value="1" {{ request('verified') == '1' ? 'selected' : '' }}>Verified</option>
                                        <option value="0" {{ request('verified') == '0' ? 'selected' : '' }}>Not Verified</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label small">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="fa fa-filter"></i> Filter
                                    </button>
                                </div>
                                @if(request()->hasAny(['search', 'status', 'listing_status', 'city', 'verified']))
                                <div class="col-12">
                                    <a href="{{ route('admin.party-plots.index') }}" class="btn btn-sm btn-outline-secondary">
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
                                    <th>Name</th>
                                    <th width="120">City</th>
                                    <th>Address</th>
                                    <th width="100">Category</th>
                                    <th width="80">Status</th>
                                    <th width="100">Listing</th>
                                    <th width="80">Verified</th>
                                    <th width="100">Visitors</th>
                                    <th width="100">Created</th>
                                    <th width="120" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($partyPlots as $plot)
                                    <tr>
                                        <td><strong>#{{ $plot->id }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($plot->featured_image)
                                                    <div class="avatar-sm me-2">
                                                        <img src="{{ $plot->featured_image }}" alt="{{ $plot->name }}"
                                                             class="img-thumbnail rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                    </div>
                                                @else
                                                    <div class="avatar-sm me-2 bg-light rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <i class="fa fa-building text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <strong class="d-block">{{ $plot->name }}</strong>
                                                    @if($plot->category)
                                                        <small class="text-muted">{{ $plot->category->name }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <i class="fa fa-map-marker-alt text-primary me-1"></i>
                                            {{ $plot->city }}
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ Str::limit($plot->full_address, 60) }}</small>
                                        </td>
                                        <td>
                                            @if($plot->category)
                                                <span class="badge badge-info">{{ $plot->category->name }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $plot->status == 'active' ? 'success' : 'danger' }}">
                                                {{ ucfirst($plot->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $plot->listing_status == 'approved' ? 'success' : ($plot->listing_status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($plot->listing_status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($plot->verified)
                                                <span class="badge badge-success">
                                                    <i class="fa fa-check-circle"></i> Yes
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">No</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-light">
                                                <i class="fa fa-eye"></i> {{ $plot->visitors ?? 0 }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ $plot->created_at->format('M d, Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.party-plots.edit', $plot->id) }}"
                                                   class="btn btn-success" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.party-plots.destroy', $plot->id) }}"
                                                      method="POST" style="display:inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this party plot?');">
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
                                        <td colspan="11" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fa fa-building fa-3x text-muted mb-3"></i>
                                                <h5>No party plots found</h5>
                                                <p class="text-muted">Get started by adding a new party plot or uploading a CSV file.</p>
                                                <a href="{{ route('admin.party-plots.create') }}" class="btn btn-primary btn-sm mt-2">
                                                    <i class="fa fa-plus"></i> Add Party Plot
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
                        {{ $partyPlots->links('pagination::bootstrap-4') }}
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

    .avatar-sm img {
        object-fit: cover;
    }

    .badge {
        padding: 0.35em 0.65em;
        font-weight: 500;
    }
</style>
@endpush

@endsection
