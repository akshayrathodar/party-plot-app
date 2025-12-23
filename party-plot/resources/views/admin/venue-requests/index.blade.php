@extends('layouts.admin')

@section('content')
<x-top-header title="Venue Requests" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <i class="fa fa-building me-2"></i>All Venue Requests
                                <span class="badge badge-primary ms-2">{{ $venueRequests->total() }}</span>
                            </h5>
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

                    <!-- Filters -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <form method="GET" action="{{ route('admin.venue-requests.index') }}" class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label small">Search</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                                        <input type="text" name="search" class="form-control form-control-sm"
                                               placeholder="Search by name, city, phone..."
                                               value="{{ request('search') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">Status</label>
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="">All Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary btn-sm w-100">
                                            <i class="fa fa-filter"></i> Filter
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">&nbsp;</label>
                                    <div>
                                        <a href="{{ route('admin.venue-requests.index') }}" class="btn btn-secondary btn-sm w-100">
                                            <i class="fa fa-times"></i> Clear
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">ID</th>
                                    <th>Name</th>
                                    <th width="150">City</th>
                                    <th width="150">Phone</th>
                                    <th width="120">Status</th>
                                    <th width="150">Submitted</th>
                                    <th width="200" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($venueRequests as $request)
                                <tr>
                                    <td>{{ $request->id }}</td>
                                    <td>
                                        <strong>{{ $request->name }}</strong>
                                    </td>
                                    <td>{{ $request->city }}</td>
                                    <td>
                                        <a href="tel:{{ $request->phone }}">{{ $request->phone }}</a>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'contacted' => 'info',
                                                'completed' => 'success',
                                                'rejected' => 'danger'
                                            ];
                                            $color = $statusColors[$request->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge badge-{{ $color }}">{{ ucfirst($request->status) }}</span>
                                    </td>
                                    <td>
                                        <small>{{ $request->created_at->format('M d, Y') }}</small><br>
                                        <small class="text-muted">{{ $request->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#statusModal{{ $request->id }}">
                                            <i class="fa fa-edit"></i> Update Status
                                        </button>
                                    </td>
                                </tr>

                                <!-- Status Update Modal -->
                                <div class="modal fade" id="statusModal{{ $request->id }}" tabindex="-1" aria-labelledby="statusModalLabel{{ $request->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.venue-requests.updateStatus', $request->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="statusModalLabel{{ $request->id }}">Update Status - {{ $request->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label>
                                                        <select name="status" class="form-select" required>
                                                            <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                            <option value="contacted" {{ $request->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                                            <option value="completed" {{ $request->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                            <option value="rejected" {{ $request->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Notes</label>
                                                        <textarea name="notes" class="form-control" rows="3" placeholder="Add any notes...">{{ $request->notes }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Request Details</label>
                                                        <div class="card bg-light">
                                                            <div class="card-body">
                                                                <p class="mb-1"><strong>Name:</strong> {{ $request->name }}</p>
                                                                <p class="mb-1"><strong>City:</strong> {{ $request->city }}</p>
                                                                <p class="mb-0"><strong>Phone:</strong> <a href="tel:{{ $request->phone }}">{{ $request->phone }}</a></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No venue requests found.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($venueRequests->hasPages())
                    <div class="mt-3">
                        {{ $venueRequests->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection









