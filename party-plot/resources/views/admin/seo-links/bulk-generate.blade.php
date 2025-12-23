@extends('layouts.admin')

@section('content')
<x-top-header title="Bulk Generate SEO Links" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <i class="fa fa-magic me-2"></i>Bulk Generate SEO Links
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('admin.seo-links.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to SEO Links
                            </a>
                            <a href="{{ route('admin.seo-links.templates') }}" class="btn btn-info btn-sm">
                                <i class="fa fa-file-alt"></i> Manage Templates
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

                    @if($templates->isEmpty())
                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle"></i> 
                            No active templates found. Please <a href="{{ route('admin.seo-links.templates.create') }}">create a template</a> first.
                        </div>
                    @else
                        <!-- Step 1: Select Template -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><i class="fa fa-1 me-2"></i>Step 1: Select Template</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.seo-links.bulk-generate.preview') }}" method="POST" class="row g-3">
                                    @csrf
                                    <div class="col-md-6">
                                        <label for="template_id" class="form-label">Choose Template <span class="text-danger">*</span></label>
                                        <select name="template_id" id="template_id" class="form-select" required>
                                            <option value="">-- Select a Template --</option>
                                            @foreach($templates as $t)
                                                <option value="{{ $t->id }}" 
                                                        {{ isset($template) && $template->id == $t->id ? 'selected' : '' }}>
                                                    {{ $t->name }} ({{ $t->type_label }}) - Min {{ $t->min_venues }} venues
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fa fa-eye"></i> Preview Links
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @if(isset($template) && isset($previewLinks))
                            <!-- Step 2: Preview & Select -->
                            <div class="card mb-4">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0"><i class="fa fa-2 me-2"></i>Step 2: Preview & Select Links to Generate</h6>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info">
                                        <strong>Template:</strong> {{ $template->name }}<br>
                                        <strong>Type:</strong> {{ $template->type_label }}<br>
                                        <strong>Link Text Template:</strong> <code>{{ $template->link_text_template }}</code><br>
                                        <strong>Slug Template:</strong> <code>{{ $template->slug_template }}</code><br>
                                        <strong>Minimum Venues:</strong> {{ $template->min_venues }}
                                    </div>

                                    @if(count($previewLinks) > 0)
                                        <form action="{{ route('admin.seo-links.bulk-generate.execute') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="template_id" value="{{ $template->id }}">

                                            <div class="mb-3">
                                                <button type="button" class="btn btn-sm btn-outline-primary" id="selectAll">
                                                    <i class="fa fa-check-square"></i> Select All
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAll">
                                                    <i class="fa fa-square"></i> Deselect All
                                                </button>
                                                <span class="ms-3 text-muted">
                                                    Total: {{ count($previewLinks) }} | 
                                                    New: {{ count(array_filter($previewLinks, fn($l) => !$l['exists'])) }} |
                                                    Already Exist: {{ count(array_filter($previewLinks, fn($l) => $l['exists'])) }}
                                                </span>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-hover table-bordered">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th width="40">
                                                                <input type="checkbox" class="form-check-input" id="checkAllBox">
                                                            </th>
                                                            <th>Link Text</th>
                                                            <th>URL Slug</th>
                                                            <th width="80">Venues</th>
                                                            <th width="100">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($previewLinks as $link)
                                                            <tr class="{{ $link['exists'] ? 'table-secondary' : '' }}">
                                                                <td>
                                                                    @if(!$link['exists'])
                                                                        <input type="checkbox" name="selected_links[]" 
                                                                               value="{{ $link['key'] }}" 
                                                                               class="form-check-input link-checkbox"
                                                                               checked>
                                                                    @else
                                                                        <i class="fa fa-check text-success" title="Already exists"></i>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <strong>{{ $link['link_text'] }}</strong>
                                                                    @if(isset($link['city']))
                                                                        <br><small class="text-muted"><i class="fa fa-city"></i> {{ $link['city'] }}</small>
                                                                    @endif
                                                                    @if(isset($link['area']))
                                                                        <br><small class="text-muted"><i class="fa fa-map-marker"></i> {{ $link['area'] }}</small>
                                                                    @endif
                                                                    @if(isset($link['category_name']))
                                                                        <br><small class="text-muted"><i class="fa fa-tag"></i> {{ $link['category_name'] }}</small>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <code>/venues/{{ $link['slug'] }}</code>
                                                                </td>
                                                                <td class="text-center">
                                                                    <span class="badge badge-info">{{ $link['venue_count'] }}</span>
                                                                </td>
                                                                <td>
                                                                    @if($link['exists'])
                                                                        <span class="badge badge-secondary">Exists</span>
                                                                    @else
                                                                        <span class="badge badge-success">New</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="mt-3">
                                                <button type="submit" class="btn btn-success btn-lg">
                                                    <i class="fa fa-magic me-1"></i> Generate Selected Links
                                                </button>
                                            </div>
                                        </form>
                                    @else
                                        <div class="alert alert-warning">
                                            <i class="fa fa-exclamation-triangle"></i> 
                                            No links to generate. Either all combinations already exist, or no venues meet the minimum requirement ({{ $template->min_venues }} venues).
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Select All
    document.getElementById('selectAll')?.addEventListener('click', function() {
        document.querySelectorAll('.link-checkbox').forEach(cb => cb.checked = true);
        document.getElementById('checkAllBox').checked = true;
    });

    // Deselect All
    document.getElementById('deselectAll')?.addEventListener('click', function() {
        document.querySelectorAll('.link-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('checkAllBox').checked = false;
    });

    // Toggle All checkbox
    document.getElementById('checkAllBox')?.addEventListener('change', function() {
        const isChecked = this.checked;
        document.querySelectorAll('.link-checkbox').forEach(cb => cb.checked = isChecked);
    });
</script>
@endpush

@push('styles')
<style>
    .table-secondary {
        opacity: 0.7;
    }
</style>
@endpush

@endsection






