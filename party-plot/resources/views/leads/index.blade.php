@extends('layouts.admin')

@section('content')
<x-top-header title="Leads" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <i class="fa fa-envelope me-2"></i>All Leads
                                <span class="badge badge-primary ms-2">{{ $leads->total() }}</span>
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
                            <form method="GET" action="{{ route('admin.leads.index') }}" class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label small">Search</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                                        <input type="text" name="search" class="form-control form-control-sm"
                                               placeholder="Search by name, email, phone..."
                                               value="{{ request('search') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">Status</label>
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="">All Status</option>
                                        <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                                        <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                        <option value="converted" {{ request('status') == 'converted' ? 'selected' : '' }}>Converted</option>
                                        <option value="lost" {{ request('status') == 'lost' ? 'selected' : '' }}>Lost</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">Source</label>
                                    <select name="source" class="form-select form-select-sm">
                                        <option value="">All Sources</option>
                                        <option value="free" {{ request('source') == 'free' ? 'selected' : '' }}>Free</option>
                                        <option value="purchased" {{ request('source') == 'purchased' ? 'selected' : '' }}>Purchased</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">Party Plot</label>
                                    <select name="party_plot_id" class="form-select form-select-sm">
                                        <option value="">All Party Plots</option>
                                        @foreach($partyPlots as $id => $name)
                                            <option value="{{ $id }}" {{ request('party_plot_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">Date From</label>
                                    <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">Date To</label>
                                    <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label small">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="fa fa-filter"></i> Filter
                                    </button>
                                </div>
                                @if(request()->hasAny(['search', 'status', 'source', 'party_plot_id', 'date_from', 'date_to']))
                                <div class="col-12">
                                    <a href="{{ route('admin.leads.index') }}" class="btn btn-sm btn-outline-secondary">
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
                                    <th>Contact</th>
                                    <th>Party Plot</th>
                                    <th>Function Date</th>
                                    <th width="100">Status</th>
                                    <th width="100">Source</th>
                                    <th width="100">Created</th>
                                    <th width="120" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leads as $lead)
                                    <tr>
                                        <td><strong>#{{ $lead->id }}</strong></td>
                                        <td>
                                            <strong class="d-block">{{ $lead->name }}</strong>
                                            @if($lead->user)
                                                <small class="text-muted">User ID: {{ $lead->user_id }}</small>
                                            @else
                                                <small class="text-muted">Guest</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($lead->email)
                                            <div>
                                                <i class="fa fa-envelope text-primary me-1"></i>
                                                <small>{{ $lead->email }}</small>
                                            </div>
                                            @endif
                                            <div class="{{ $lead->email ? 'mt-1' : '' }}">
                                                <i class="fa fa-phone text-success me-1"></i>
                                                <small>{{ $lead->phone }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if($lead->partyPlot)
                                                <strong>{{ $lead->partyPlot->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $lead->partyPlot->city }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($lead->function_date)
                                                <i class="fa fa-calendar text-info me-1"></i>
                                                {{ $lead->function_date->format('M d, Y') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'new' => 'primary',
                                                    'contacted' => 'info',
                                                    'converted' => 'success',
                                                    'lost' => 'danger'
                                                ];
                                                $color = $statusColors[$lead->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge badge-{{ $color }}">
                                                {{ ucfirst($lead->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($lead->source == 'purchased')
                                                <span class="badge badge-warning">
                                                    <i class="fa fa-shopping-cart"></i> Purchased
                                                </span>
                                                @if($lead->lead_price)
                                                    <br><small class="text-muted">₹{{ number_format($lead->lead_price, 2) }}</small>
                                                @endif
                                            @else
                                                <span class="badge badge-success">Free</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ $lead->created_at->format('M d, Y') }}</small>
                                            <br>
                                            <small class="text-muted">{{ $lead->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.leads.show', $lead->id) }}"
                                                   class="btn btn-info" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <form action="{{ route('admin.leads.destroy', $lead->id) }}"
                                                      method="POST" style="display:inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this lead?');">
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
                                        <td colspan="9" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fa fa-envelope fa-3x text-muted mb-3"></i>
                                                <h5>No leads found</h5>
                                                <p class="text-muted">Leads will appear here when users submit enquiries.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $leads->links('pagination::bootstrap-4') }}
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

