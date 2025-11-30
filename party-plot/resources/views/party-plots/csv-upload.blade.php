@extends('layouts.admin')

@section('content')
<x-top-header title="Upload CSV" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Upload Party Plots CSV</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="fa fa-info-circle"></i> CSV Upload Instructions</h6>
                        <ul class="mb-0">
                            <li>Upload a CSV file with party plot data</li>
                            <li>Required columns: <strong>name</strong>, <strong>full_address</strong>, <strong>city</strong>, <strong>latitude</strong>, <strong>longitude</strong></li>
                            <li>Optional columns: All other fields (capacity_min, capacity_max, price_range_min, price_range_max, amenities, social links, etc.)</li>
                            <li>If a row already exists (matched by place_id or name + full_address), it will be updated</li>
                            <li>Missing columns will be ignored - they won't break the upload</li>
                            <li>You'll be able to preview the data before final import</li>
                        </ul>
                    </div>

                    <form action="{{ route('admin.party-plots.csv-preview') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="csv_file" class="form-label">
                                        Select CSV File <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" name="csv_file" id="csv_file"
                                           class="form-control @error('csv_file') is-invalid @enderror"
                                           accept=".csv,.txt,text/csv,application/vnd.ms-excel"
                                           required>
                                    @error('csv_file')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Maximum file size: 10MB. Supported formats: CSV, TXT
                                    </small>
                                    <div id="file-selected" class="mt-2" style="display: none;">
                                        <span class="badge bg-success">
                                            <i class="fa fa-check"></i> File selected: <span id="file-name"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-upload"></i> Upload & Preview
                                </button>
                                <a href="{{ route('admin.party-plots.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="alert alert-warning">
                        <h6><i class="fa fa-exclamation-triangle"></i> Column Name Mapping</h6>
                        <p class="mb-2">The system will automatically map CSV columns to model fields. Supported column names include:</p>
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Required:</strong>
                                <ul class="small">
                                    <li>name, title, venue_name</li>
                                    <li>full_address, address, location</li>
                                    <li>city, city_name</li>
                                    <li>latitude, lat</li>
                                    <li>longitude, lng, lon, long</li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <strong>Optional Venue:</strong>
                                <ul class="small">
                                    <li>capacity_min, min_capacity</li>
                                    <li>capacity_max, max_capacity</li>
                                    <li>price_range_min, min_price</li>
                                    <li>price_range_max, max_price</li>
                                    <li>area_lawn, lawn_area</li>
                                    <li>area_banquet, banquet_area</li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <strong>Optional Social:</strong>
                                <ul class="small">
                                    <li>email, contact_email</li>
                                    <li>phone, contact_phone</li>
                                    <li>website, website_url</li>
                                    <li>instagram, facebook, etc.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('csv_file');
        const fileSelected = document.getElementById('file-selected');
        const fileName = document.getElementById('file-name');

        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                if (this.files && this.files.length > 0) {
                    fileName.textContent = this.files[0].name;
                    fileSelected.style.display = 'block';
                } else {
                    fileSelected.style.display = 'none';
                }
            });
        }
    });
</script>
@endpush
@endsection

