@extends('layouts.admin')

@section('content')
<x-top-header title="Edit Party Plot" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Party Plot: {{ $partyPlot->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.party-plots.update', $partyPlot->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Required Fields -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">Required Information</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-input name="name" label="Name" :value="old('name', $partyPlot->name)" :required="true" />
                            </div>
                            <div class="col-md-6">
                                <x-input name="slug" label="Slug" :value="old('slug', $partyPlot->slug)" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-textarea name="description" label="Description / Introduction" 
                                            :value="old('description', $partyPlot->description)" 
                                            placeholder="Enter a brief introduction or description of the party plot" 
                                            :rows="4" />
                                <small class="form-text text-muted">
                                    Provide an introduction or description of the party plot. This will be displayed on the listing page.
                                </small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-textarea name="full_address" label="Full Address" :value="old('full_address', $partyPlot->full_address)" :required="true" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <x-input name="city" label="City" :value="old('city', $partyPlot->city)" :required="true" />
                            </div>
                            <div class="col-md-4">
                                <x-input name="latitude" type="number" step="0.00000001" label="Latitude" 
                                         :value="old('latitude', $partyPlot->latitude)" :required="true" />
                            </div>
                            <div class="col-md-4">
                                <x-input name="longitude" type="number" step="0.00000001" label="Longitude" 
                                         :value="old('longitude', $partyPlot->longitude)" :required="true" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-input name="place_id" label="Place ID" :value="old('place_id', $partyPlot->place_id)" />
                            </div>
                        </div>

                        @if($partyPlot->featured_image)
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Current Featured Image</label>
                                    <div>
                                        <img src="{{ getFile($partyPlot->featured_image, 'party-plots', 'admin') }}" 
                                             alt="Featured Image" style="max-width: 200px; max-height: 200px;" class="img-thumbnail">
                                    </div>
                                </div>
                            </div>
                        @endif

                        <hr class="my-4">

                        <!-- Venue Details -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3 text-primary">Venue Details (Optional)</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <x-input name="capacity_min" type="number" label="Min Capacity" 
                                         :value="old('capacity_min', $partyPlot->capacity_min)" />
                            </div>
                            <div class="col-md-3">
                                <x-input name="capacity_max" type="number" label="Max Capacity" 
                                         :value="old('capacity_max', $partyPlot->capacity_max)" />
                            </div>
                            <div class="col-md-3">
                                <x-input name="price_range_min" type="number" step="0.01" label="Min Price" 
                                         :value="old('price_range_min', $partyPlot->price_range_min)" />
                            </div>
                            <div class="col-md-3">
                                <x-input name="price_range_max" type="number" step="0.01" label="Max Price" 
                                         :value="old('price_range_max', $partyPlot->price_range_max)" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-input name="area_lawn" label="Lawn Area" :value="old('area_lawn', $partyPlot->area_lawn)" />
                            </div>
                            <div class="col-md-6">
                                <x-input name="area_banquet" label="Banquet Area" :value="old('area_banquet', $partyPlot->area_banquet)" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-textarea name="suitable_events" label="Suitable Events (comma-separated)" 
                                            :value="old('suitable_events', $partyPlot->suitable_events)" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-textarea name="tags" label="Tags (comma-separated, e.g., rajkot, kothariya, banquet) - For SEO" 
                                            :value="old('tags', is_array($partyPlot->tags) ? implode(', ', $partyPlot->tags) : ($partyPlot->tags ?? ''))" 
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
                                <x-checkbox name="parking" label="Parking" value="1" 
                                           :checked="old('parking', $partyPlot->parking)" />
                            </div>
                            <div class="col-md-3">
                                <x-checkbox name="rooms" label="Rooms" value="1" 
                                           :checked="old('rooms', $partyPlot->rooms)" />
                            </div>
                            <div class="col-md-3">
                                <x-checkbox name="dj_allowed" label="DJ Allowed" value="1" 
                                           :checked="old('dj_allowed', $partyPlot->dj_allowed)" />
                            </div>
                            <div class="col-md-3">
                                <x-checkbox name="decoration_allowed" label="Decoration Allowed" value="1"
                                            :checked="old('decoration_allowed', $partyPlot->decoration_allowed)" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <x-checkbox name="catering_allowed" label="Catering Allowed" value="1"
                                            :checked="old('catering_allowed', $partyPlot->catering_allowed)" />
                            </div>
                            <div class="col-md-3">
                                <x-checkbox name="generator_backup" label="Generator Backup" value="1"
                                            :checked="old('generator_backup', $partyPlot->generator_backup)" />
                            </div>
                            <div class="col-md-3">
                                <x-checkbox name="ac_available" label="AC Available" value="1"
                                            :checked="old('ac_available', $partyPlot->ac_available)" />
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
                                <x-file name="featured_image" label="Featured Image (leave empty to keep current)" accept="image/*" />
                            </div>
                        </div>

                        @if($partyPlot->gallery_images && count($partyPlot->gallery_images) > 0)
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Current Gallery Images</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($partyPlot->gallery_images as $image)
                                            <img src="{{ getFile($image, 'party-plots', 'admin') }}" 
                                                 alt="Gallery Image" style="max-width: 150px; max-height: 150px;" class="img-thumbnail">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Add More Gallery Images</label>
                                <input type="file" name="gallery_images[]" class="form-control" multiple accept="image/*">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <x-textarea name="video_links" label="Video Links (comma-separated URLs)" 
                                            :value="old('video_links', is_array($partyPlot->video_links) ? implode(', ', $partyPlot->video_links) : $partyPlot->video_links)" />
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
                                <x-input name="google_rating" type="number" step="0.01" min="0" max="5" label="Google Rating" 
                                         :value="old('google_rating', $partyPlot->google_rating)" />
                            </div>
                            <div class="col-md-4">
                                <x-input name="google_review_count" type="number" label="Review Count" 
                                         :value="old('google_review_count', $partyPlot->google_review_count)" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-textarea name="google_review_text" label="Review Text" 
                                            :value="old('google_review_text', $partyPlot->google_review_text)" />
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
                                <x-input name="instagram" type="url" label="Instagram URL" 
                                         :value="old('instagram', $partyPlot->instagram)" />
                            </div>
                            <div class="col-md-3">
                                <x-input name="facebook" type="url" label="Facebook URL" 
                                         :value="old('facebook', $partyPlot->facebook)" />
                            </div>
                            <div class="col-md-3">
                                <x-input name="twitter" type="url" label="Twitter URL" 
                                         :value="old('twitter', $partyPlot->twitter)" />
                            </div>
                            <div class="col-md-3">
                                <x-input name="youtube" type="url" label="YouTube URL" 
                                         :value="old('youtube', $partyPlot->youtube)" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <x-input name="website" type="url" label="Website URL" 
                                         :value="old('website', $partyPlot->website)" />
                            </div>
                            <div class="col-md-4">
                                <x-input name="email" type="email" label="Email" 
                                         :value="old('email', $partyPlot->email)" />
                            </div>
                            <div class="col-md-4">
                                <x-input name="phone" label="Phone" :value="old('phone', $partyPlot->phone)" />
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
                                          :selected="old('status', $partyPlot->status)" />
                            </div>
                            <div class="col-md-4">
                                <x-select name="listing_status" label="Listing Status" 
                                          :options="['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected']" 
                                          :selected="old('listing_status', $partyPlot->listing_status)" />
                            </div>
                            <div class="col-md-4">
                                <x-checkbox name="verified" label="Verified" value="1" 
                                           :checked="old('verified', $partyPlot->verified)" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update Party Plot
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

