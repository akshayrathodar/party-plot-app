@extends('layouts.admin')

@section('content')
<x-top-header title="Create Party Plot" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Add New Party Plot</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.party-plots.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Required Fields -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">Required Information</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-input name="name" label="Name" :required="true" />
                            </div>
                            <div class="col-md-6">
                                <x-input name="slug" label="Slug (auto-generated if empty)" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-textarea name="description" label="Description / Introduction" 
                                            placeholder="Enter a brief introduction or description of the party plot" 
                                            :rows="4" />
                                <small class="form-text text-muted">
                                    Provide an introduction or description of the party plot. This will be displayed on the listing page.
                                </small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-textarea name="full_address" label="Full Address" :required="true" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <x-input name="city" label="City" :required="true" />
                            </div>
                            <div class="col-md-4">
                                <x-input name="latitude" type="number" step="0.00000001" label="Latitude" :required="true" />
                            </div>
                            <div class="col-md-4">
                                <x-input name="longitude" type="number" step="0.00000001" label="Longitude" :required="true" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-input name="place_id" label="Place ID (for CSV matching)" />
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Venue Details -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">Venue Details (Optional)</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <x-input name="capacity_min" type="number" label="Min Capacity" />
                            </div>
                            <div class="col-md-3">
                                <x-input name="capacity_max" type="number" label="Max Capacity" />
                            </div>
                            <div class="col-md-3">
                                <x-input name="price_range_min" type="number" step="0.01" label="Min Price" />
                            </div>
                            <div class="col-md-3">
                                <x-input name="price_range_max" type="number" step="0.01" label="Max Price" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-input name="area_lawn" label="Lawn Area" />
                            </div>
                            <div class="col-md-6">
                                <x-input name="area_banquet" label="Banquet Area" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-textarea name="suitable_events" label="Suitable Events (comma-separated)" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-textarea name="tags" label="Tags (comma-separated, e.g., rajkot, kothariya, banquet) - For SEO" 
                                            placeholder="Enter tags separated by commas (e.g., rajkot, kothariya, banquet, wedding)" />
                                <small class="form-text text-muted">
                                    These tags will be used for SEO. Party plots with matching tags will appear on pages like "party plot in rajkot"
                                </small>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Amenities -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">Amenities (Optional)</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <x-checkbox name="parking" label="Parking" value="1" />
                            </div>
                            <div class="col-md-3">
                                <x-checkbox name="rooms" label="Rooms" value="1" />
                            </div>
                            <div class="col-md-3">
                                <x-checkbox name="dj_allowed" label="DJ Allowed" value="1" />
                            </div>
                            <div class="col-md-3">
                                <x-checkbox name="decoration_allowed" label="Decoration Allowed" value="1" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <x-checkbox name="catering_allowed" label="Catering Allowed" value="1" />
                            </div>
                            <div class="col-md-3">
                                <x-checkbox name="generator_backup" label="Generator Backup" value="1" />
                            </div>
                            <div class="col-md-3">
                                <x-checkbox name="ac_available" label="AC Available" value="1" />
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Media -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">Media (Optional)</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-file name="featured_image" label="Featured Image" accept="image/*" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Gallery Images</label>
                                <input type="file" name="gallery_images[]" class="form-control" multiple accept="image/*">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <x-textarea name="video_links" label="Video Links (comma-separated URLs)" />
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Ratings -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">Google Ratings (Optional)</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <x-input name="google_rating" type="number" step="0.01" min="0" max="5" label="Google Rating" />
                            </div>
                            <div class="col-md-4">
                                <x-input name="google_review_count" type="number" label="Review Count" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-textarea name="google_review_text" label="Review Text" />
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Social & Contact -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">Social & Contact (Optional)</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <x-input name="instagram" type="url" label="Instagram URL" />
                            </div>
                            <div class="col-md-3">
                                <x-input name="facebook" type="url" label="Facebook URL" />
                            </div>
                            <div class="col-md-3">
                                <x-input name="twitter" type="url" label="Twitter URL" />
                            </div>
                            <div class="col-md-3">
                                <x-input name="youtube" type="url" label="YouTube URL" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <x-input name="website" type="url" label="Website URL" />
                            </div>
                            <div class="col-md-4">
                                <x-input name="email" type="email" label="Email" />
                            </div>
                            <div class="col-md-4">
                                <x-input name="phone" label="Phone" />
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- System Fields -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">System Settings</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <x-select name="status" label="Status" :options="['active' => 'Active', 'inactive' => 'Inactive']" 
                                          :selected="old('status', 'active')" />
                            </div>
                            <div class="col-md-4">
                                <x-select name="listing_status" label="Listing Status" 
                                          :options="['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected']" 
                                          :selected="old('listing_status', 'pending')" />
                            </div>
                            <div class="col-md-4">
                                <x-checkbox name="verified" label="Verified" value="1" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Create Party Plot
                                </button>
                                <a href="{{ route('admin.party-plots.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

