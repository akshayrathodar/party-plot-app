@extends('layouts.admin')

@section('content')
<x-top-header title="Preview CSV Import" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Preview CSV Data</h5>
                    <p class="mb-0 text-muted">Review the data below before importing. Total rows: {{ count($csvData) }}</p>
                </div>
                <div class="card-body">
                    @if(count($csvData) > 0)
                        <div class="alert alert-info mb-3">
                            <strong>Found {{ count($csvData) }} rows</strong> in the CSV file.
                            <br>Please review the data below and click "Import Data" to proceed.
                        </div>

                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                            <table class="table table-bordered table-striped table-sm">
                                <thead class="thead-dark sticky-top">
                                    <tr>
                                        <th>#</th>
                                        @foreach($headers as $header)
                                            <th>{{ $header }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($csvData as $index => $row)
                                        <tr>
                                            <td><strong>{{ $index + 1 }}</strong></td>
                                            @foreach($headers as $header)
                                                <td>
                                                    @if(isset($row[$header]) && !empty($row[$header]))
                                                        {{ Str::limit($row[$header], 50) }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <form action="{{ route('admin.party-plots.csv-import') }}" method="POST">
                                @csrf
                                <div class="alert alert-warning">
                                    <h6><i class="fa fa-exclamation-triangle"></i> Import Summary</h6>
                                    <ul class="mb-0">
                                        <li>Rows will be matched by <strong>place_id</strong> or <strong>name + full_address</strong></li>
                                        <li>If a match is found, the existing record will be <strong>updated</strong></li>
                                        <li>If no match is found, a <strong>new record</strong> will be created</li>
                                        <li>All imported party plots will be assigned to the current admin user</li>
                                        <li>Missing or invalid data in optional fields will be skipped (won't break import)</li>
                                    </ul>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg" onclick="return confirm('Are you sure you want to import {{ count($csvData) }} rows?');">
                                    <i class="fa fa-download"></i> Import Data
                                </button>
                                <a href="{{ route('admin.party-plots.csv-upload') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Go Back
                                </a>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <h6>No data found in CSV file</h6>
                            <p>Please check your CSV file and try again.</p>
                        </div>
                        <a href="{{ route('admin.party-plots.csv-upload') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left"></i> Go Back
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

