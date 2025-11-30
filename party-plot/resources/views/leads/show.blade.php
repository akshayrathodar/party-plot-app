@extends('layouts.admin')

@section('content')
<x-top-header title="Lead Details" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <i class="fa fa-envelope me-2"></i>Lead #{{ $lead->id }}
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('admin.leads.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to Leads
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

                    <div class="row">
                        <!-- Lead Information -->
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fa fa-user me-2"></i>Lead Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <strong>Name:</strong>
                                            <p class="mb-0">{{ $lead->name }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Phone:</strong>
                                            <p class="mb-0">
                                                <a href="tel:{{ $lead->phone }}">{{ $lead->phone }}</a>
                                            </p>
                                        </div>
                                    </div>
                                    @if($lead->email)
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <strong>Email:</strong>
                                            <p class="mb-0">
                                                <a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a>
                                            </p>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                        <div class="col-md-6">
                                            <strong>Function Date:</strong>
                                            <p class="mb-0">
                                                @if($lead->function_date)
                                                    <i class="fa fa-calendar text-info me-1"></i>
                                                    {{ $lead->function_date->format('F d, Y') }}
                                                @else
                                                    <span class="text-muted">Not specified</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    @if($lead->message)
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <strong>Message:</strong>
                                            <p class="mb-0">{{ $lead->message }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Party Plot Information -->
                            @if($lead->partyPlot)
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fa fa-building me-2"></i>Party Plot Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <strong>Party Plot:</strong>
                                            <p class="mb-0">
                                                <a href="{{ route('admin.party-plots.edit', $lead->partyPlot->id) }}" target="_blank">
                                                    {{ $lead->partyPlot->name }}
                                                </a>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Location:</strong>
                                            <p class="mb-0">
                                                <i class="fa fa-map-marker-alt text-primary me-1"></i>
                                                {{ $lead->partyPlot->city }}{{ $lead->partyPlot->area ? ', ' . $lead->partyPlot->area : '' }}
                                            </p>
                                        </div>
                                    </div>
                                    @if($lead->partyPlot->full_address)
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <strong>Address:</strong>
                                            <p class="mb-0">{{ $lead->partyPlot->full_address }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Admin Notes -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fa fa-sticky-note me-2"></i>Admin Notes</h6>
                                </div>
                                <div class="card-body">
                                    @if($lead->admin_notes)
                                        <p class="mb-0">{{ $lead->admin_notes }}</p>
                                    @else
                                        <p class="text-muted mb-0">No admin notes added yet.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-md-4">
                            <!-- Status Update -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fa fa-info-circle me-2"></i>Status & Details</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('admin.leads.updateStatus', $lead->id) }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label"><strong>Status</strong></label>
                                            <select name="status" class="form-select" required>
                                                <option value="new" {{ $lead->status == 'new' ? 'selected' : '' }}>New</option>
                                                <option value="contacted" {{ $lead->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                                <option value="converted" {{ $lead->status == 'converted' ? 'selected' : '' }}>Converted</option>
                                                <option value="lost" {{ $lead->status == 'lost' ? 'selected' : '' }}>Lost</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><strong>Admin Notes</strong></label>
                                            <textarea name="admin_notes" class="form-control" rows="4" placeholder="Add notes about this lead...">{{ $lead->admin_notes }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fa fa-save"></i> Update Status
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Lead Details -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fa fa-info-circle me-2"></i>Lead Details</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <strong>Source:</strong>
                                        @if($lead->source == 'purchased')
                                            <span class="badge badge-warning">
                                                <i class="fa fa-shopping-cart"></i> Purchased
                                            </span>
                                            @if($lead->lead_price)
                                                <br><small class="text-muted">Price: ₹{{ number_format($lead->lead_price, 2) }}</small>
                                            @endif
                                        @else
                                            <span class="badge badge-success">Free</span>
                                        @endif
                                    </div>
                                    <div class="mb-2">
                                        <strong>Vendor:</strong>
                                        @if($lead->vendor)
                                            <p class="mb-0">{{ $lead->vendor->name }}</p>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                    <div class="mb-2">
                                        <strong>Submitted:</strong>
                                        <p class="mb-0">
                                            {{ $lead->created_at->format('M d, Y') }}<br>
                                            <small class="text-muted">{{ $lead->created_at->format('h:i A') }}</small>
                                        </p>
                                    </div>
                                    @if($lead->purchased_at)
                                    <div class="mb-2">
                                        <strong>Purchased At:</strong>
                                        <p class="mb-0">
                                            {{ $lead->purchased_at->format('M d, Y') }}<br>
                                            <small class="text-muted">{{ $lead->purchased_at->format('h:i A') }}</small>
                                        </p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fa fa-cog me-2"></i>Actions</h6>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.leads.destroy', $lead->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this lead?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="fa fa-trash"></i> Delete Lead
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

