<?php

namespace App\Http\Controllers;

use App\Models\PartyPlot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PartyPlotController extends Controller
{
    /**
     * Display a listing of party plots
     */
    public function index(Request $request)
    {
        $query = PartyPlot::with(['creator', 'claimedBy']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('full_address', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('listing_status')) {
            $query->where('listing_status', $request->listing_status);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('verified')) {
            $query->where('verified', $request->verified === '1');
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $partyPlots = $query->paginate(20);

        // Get unique cities for filter
        $cities = PartyPlot::distinct()->pluck('city')->filter()->sort()->values();

        return view('party-plots.index', compact('partyPlots', 'cities'));
    }

    /**
     * Show the form for creating a new party plot
     */
    public function create()
    {
        return view('party-plots.create');
    }

    /**
     * Store a newly created party plot
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'full_address' => 'required|string',
            'city' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'slug' => 'nullable|string|max:255|unique:party_plots,slug',
            'place_id' => 'nullable|string|unique:party_plots,place_id',

            // Optional fields
            'capacity_min' => 'nullable|integer|min:0',
            'capacity_max' => 'nullable|integer|min:0|gte:capacity_min',
            'price_range_min' => 'nullable|numeric|min:0',
            'price_range_max' => 'nullable|numeric|min:0|gte:price_range_min',
            'area_lawn' => 'nullable|string|max:255',
            'area_banquet' => 'nullable|string|max:255',
            'suitable_events' => 'nullable|string',
            'tags' => 'nullable|string',

            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',

            'google_rating' => 'nullable|numeric|between:0,5',
            'google_review_count' => 'nullable|integer|min:0',
            'google_review_text' => 'nullable|string',

            'instagram' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',

            'status' => 'nullable|in:active,inactive',
            'listing_status' => 'nullable|in:pending,approved,rejected',
            'verified' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $data = $request->all();

            // Set creator to current admin user
            $data['creator_user_id'] = Auth::id();

            // Handle slug generation
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
                $originalSlug = $data['slug'];
                $count = 1;
                while (PartyPlot::where('slug', $data['slug'])->exists()) {
                    $data['slug'] = $originalSlug . '-' . $count;
                    $count++;
                }
            }

            // Handle featured image
            if ($request->hasFile('featured_image')) {
                $data['featured_image'] = uploadFile(
                    $request->file('featured_image'),
                    'featured_image',
                    'party-plots',
                    'admin'
                );
            }

            // Handle gallery images
            if ($request->hasFile('gallery_images')) {
                $galleryImages = [];
                foreach ($request->file('gallery_images') as $image) {
                    $galleryImages[] = uploadFile($image, 'gallery', 'party-plots', 'admin');
                }
                $data['gallery_images'] = $galleryImages;
            }

            // Handle video links (comma-separated or array)
            if ($request->filled('video_links')) {
                $videoLinks = is_array($request->video_links)
                    ? $request->video_links
                    : array_filter(array_map('trim', explode(',', $request->video_links)));
                $data['video_links'] = $videoLinks;
            }

            // Handle suitable events
            if ($request->filled('suitable_events')) {
                $data['suitable_events'] = $request->suitable_events;
            }

            // Handle tags (comma-separated to array)
            if ($request->filled('tags')) {
                $tags = is_array($request->tags)
                    ? $request->tags
                    : array_filter(array_map('trim', explode(',', $request->tags)));
                $data['tags'] = $tags;
            }

            // Handle boolean checkboxes (if not present, set to false)
            $booleanFields = ['parking', 'rooms', 'dj_allowed', 'decoration_allowed', 'catering_allowed', 'generator_backup', 'ac_available', 'verified'];
            foreach ($booleanFields as $field) {
                $data[$field] = isset($data[$field]) && $data[$field] == '1' ? true : false;
            }

            // Set defaults
            $data['status'] = $data['status'] ?? 'active';
            $data['listing_status'] = $data['listing_status'] ?? 'pending';

            $partyPlot = PartyPlot::create($data);

            DB::commit();

            return redirect()
                ->route('admin.party-plots.index')
                ->with('success', 'Party plot created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error creating party plot: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing a party plot
     */
    public function edit($id)
    {
        $partyPlot = PartyPlot::findOrFail($id);
        return view('party-plots.edit', compact('partyPlot'));
    }

    /**
     * Update a party plot
     */
    public function update(Request $request, $id)
    {
        $partyPlot = PartyPlot::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'full_address' => 'required|string',
            'city' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'slug' => 'nullable|string|max:255|unique:party_plots,slug,' . $id,
            'place_id' => 'nullable|string|unique:party_plots,place_id,' . $id,

            // Optional fields
            'capacity_min' => 'nullable|integer|min:0',
            'capacity_max' => 'nullable|integer|min:0|gte:capacity_min',
            'price_range_min' => 'nullable|numeric|min:0',
            'price_range_max' => 'nullable|numeric|min:0|gte:price_range_min',
            'area_lawn' => 'nullable|string|max:255',
            'area_banquet' => 'nullable|string|max:255',
            'suitable_events' => 'nullable|string',
            'tags' => 'nullable|string',

            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',

            'google_rating' => 'nullable|numeric|between:0,5',
            'google_review_count' => 'nullable|integer|min:0',
            'google_review_text' => 'nullable|string',

            'instagram' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',

            'status' => 'nullable|in:active,inactive',
            'listing_status' => 'nullable|in:pending,approved,rejected',
            'verified' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $data = $request->all();

            // Handle slug generation if changed
            if (empty($data['slug']) || $data['slug'] !== $partyPlot->slug) {
                if (empty($data['slug'])) {
                    $data['slug'] = Str::slug($data['name']);
                }
                $originalSlug = $data['slug'];
                $count = 1;
                while (PartyPlot::where('slug', $data['slug'])->where('id', '!=', $id)->exists()) {
                    $data['slug'] = $originalSlug . '-' . $count;
                    $count++;
                }
            }

            // Handle featured image
            if ($request->hasFile('featured_image')) {
                $oldImage = $partyPlot->featured_image;
                $data['featured_image'] = uploadFile(
                    $request->file('featured_image'),
                    'featured_image',
                    'party-plots',
                    'admin',
                    $oldImage
                );
            }

            // Handle gallery images
            if ($request->hasFile('gallery_images')) {
                $oldGallery = $partyPlot->gallery_images ?? [];
                $newGalleryImages = [];
                foreach ($request->file('gallery_images') as $image) {
                    $newGalleryImages[] = uploadFile($image, 'gallery', 'party-plots', 'admin');
                }
                // Merge with existing if needed, or replace
                $data['gallery_images'] = $newGalleryImages;
            }

            // Handle video links
            if ($request->filled('video_links')) {
                $videoLinks = is_array($request->video_links)
                    ? $request->video_links
                    : array_filter(array_map('trim', explode(',', $request->video_links)));
                $data['video_links'] = $videoLinks;
            }

            // Handle tags (comma-separated to array)
            if ($request->filled('tags')) {
                $tags = is_array($request->tags)
                    ? $request->tags
                    : array_filter(array_map('trim', explode(',', $request->tags)));
                $data['tags'] = $tags;
            }

            // Handle boolean checkboxes (if not present, set to false)
            $booleanFields = ['parking', 'rooms', 'dj_allowed', 'decoration_allowed', 'catering_allowed', 'generator_backup', 'ac_available', 'verified'];
            foreach ($booleanFields as $field) {
                $data[$field] = isset($data[$field]) && $data[$field] == '1' ? true : false;
            }

            $partyPlot->update($data);

            DB::commit();

            return redirect()
                ->route('admin.party-plots.index')
                ->with('success', 'Party plot updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating party plot: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete a party plot
     */
    public function destroy($id)
    {
        try {
            $partyPlot = PartyPlot::findOrFail($id);

            // Delete images
            if ($partyPlot->featured_image) {
                unlinkFile($partyPlot->featured_image, 'party-plots', 'admin');
            }

            if ($partyPlot->gallery_images) {
                foreach ($partyPlot->gallery_images as $image) {
                    unlinkFile($image, 'party-plots', 'admin');
                }
            }

            $partyPlot->delete();

            return redirect()
                ->route('admin.party-plots.index')
                ->with('success', 'Party plot deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting party plot: ' . $e->getMessage());
        }
    }

    /**
     * Show CSV upload form
     */
    public function showCsvUpload()
    {
        return view('party-plots.csv-upload');
    }

    /**
     * Preview CSV before import
     */
    public function previewCsv(Request $request)
    {
        // Custom validation for CSV file
        $validator = Validator::make($request->all(), [
            'csv_file' => [
                'required',
                'file',
                'max:10240',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $extension = strtolower($value->getClientOriginalExtension());
                        $allowedExtensions = ['csv', 'txt'];

                        if (!in_array($extension, $allowedExtensions)) {
                            $fail('The file must be a CSV file (.csv or .txt).');
                        }
                    }
                },
            ],
        ], [
            'csv_file.required' => 'Please select a CSV file to upload.',
            'csv_file.file' => 'The uploaded file is not valid.',
            'csv_file.max' => 'The file size must not exceed 10MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $file = $request->file('csv_file');

            // Additional check if file is actually uploaded
            if (!$file || !$file->isValid()) {
                return redirect()->back()
                    ->with('error', 'Please select a valid CSV file to upload.')
                    ->withInput();
            }
            $path = $file->getRealPath();

            $csvData = [];
            $headers = [];

            // Try to detect encoding and handle BOM
            $content = file_get_contents($path);
            // Remove BOM if present
            if (substr($content, 0, 3) === "\xEF\xBB\xBF") {
                $content = substr($content, 3);
                file_put_contents($path, $content);
            }

            if (($handle = fopen($path, 'r')) !== false) {
                // Get headers
                $headers = fgetcsv($handle, 0, ',', '"', '\\');
                if ($headers === false || empty($headers)) {
                    fclose($handle);
                    return redirect()->back()
                        ->with('error', 'Could not read CSV headers. Please check the file format.')
                        ->withInput();
                }
                $headers = array_map('trim', $headers);

                // Read data rows
                $rowNum = 1;
                while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
                    $rowNum++;
                    // Trim all values
                    $row = array_map('trim', $row);

                    // Handle rows with different column counts (pad or trim)
                    if (count($row) < count($headers)) {
                        // Pad with empty strings
                        $row = array_pad($row, count($headers), '');
                    } elseif (count($row) > count($headers)) {
                        // Trim to match headers
                        $row = array_slice($row, 0, count($headers));
                    }

                    // Combine headers with row data
                    $csvData[] = array_combine($headers, $row);
                }
                fclose($handle);
            } else {
                return redirect()->back()
                    ->with('error', 'Could not open CSV file. Please check the file format.')
                    ->withInput();
            }

            // Validate that we have data
            if (empty($csvData)) {
                return redirect()->back()
                    ->with('error', 'No data rows found in CSV file. Please check the file format.')
                    ->withInput();
            }

            // Store CSV data in session for import
            session(['csv_import_data' => $csvData]);
            session(['csv_import_headers' => $headers]);

            return view('party-plots.csv-preview', compact('csvData', 'headers'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error reading CSV file: ' . $e->getMessage());
        }
    }

    /**
     * Import CSV data
     */
    public function importCsv(Request $request)
    {
        $csvData = session('csv_import_data', []);
        $headers = session('csv_import_headers', []);

        if (empty($csvData)) {
            return redirect()->route('admin.party-plots.csv-upload')
                ->with('error', 'No CSV data found. Please upload CSV again.');
        }

        // Field mapping - map CSV column names to model fields
        $fieldMapping = [
            'name' => ['name', 'title', 'venue_name', 'plot_name'],
            'description' => ['description', 'intro', 'introduction', 'about', 'overview'],
            'full_address' => ['full address', 'full_address', 'address', 'complete_address', 'location'],
            'city' => ['city', 'city_name', 'location_city'],
            'area' => ['area', 'area_name', 'locality', 'neighborhood'],
            'latitude' => ['latitude', 'lat', 'lat_coordinate'],
            'longitude' => ['longitude', 'lng', 'lon', 'long', 'long_coordinate'],
            'place_id' => ['place_id', 'google_place_id', 'placeId'],
            'slug' => ['slug', 'url_slug'],
            'capacity_min' => ['capacity_min', 'min_capacity', 'capacity_minimum'],
            'capacity_max' => ['capacity_max', 'max_capacity', 'capacity_maximum'],
            'price_range_min' => ['price_range_min', 'min_price', 'price_min', 'starting_price'],
            'price_range_max' => ['price_range_max', 'max_price', 'price_max'],
            'area_lawn' => ['area_lawn', 'lawn_area', 'lawn_size'],
            'area_banquet' => ['area_banquet', 'banquet_area', 'banquet_size'],
            'suitable_events' => ['suitable_events', 'events', 'event_types'],
            'categories' => ['categories', 'category', 'category_name'],
            'tags' => ['tags', 'tag', 'seo_tags', 'keywords'],
            'parking' => ['parking', 'has_parking', 'parking_available'],
            'rooms' => ['rooms', 'has_rooms', 'rooms_available'],
            'dj_allowed' => ['dj_allowed', 'dj', 'allow_dj'],
            'decoration_allowed' => ['decoration_allowed', 'decoration', 'allow_decoration'],
            'catering_allowed' => ['catering_allowed', 'catering', 'allow_catering'],
            'generator_backup' => ['generator_backup', 'generator', 'has_generator'],
            'ac_available' => ['ac_available', 'ac', 'air_conditioning', 'has_ac'],
            // 'featured_image' => ['featured_image', 'image', 'main_image', 'primary_image'], // Ignored - will be added manually
            'gallery_images' => ['gallery_images', 'gallery', 'images'],
            'video_links' => ['video_links', 'videos', 'video_urls'],
            'google_rating' => ['average rating', 'google_rating', 'rating', 'google_rating_value'],
            'google_review_count' => ['review count', 'google_review_count', 'review_count', 'reviews_count'],
            'google_review_text' => ['google_review_text', 'review_text', 'reviews'],
            'instagram' => ['instagram', 'instagram_url', 'insta'],
            'facebook' => ['facebook', 'facebook_url', 'fb'],
            'twitter' => ['twitter', 'twitter_url', 'tw'],
            'youtube' => ['youtube', 'youtube_url', 'yt'],
            'website' => ['website', 'website_url', 'url', 'web'],
            'email' => ['email', 'contact_email', 'email_address'],
            'phone' => ['phone', 'contact_phone', 'phone_number', 'mobile'],
            'status' => ['status', 'active_status'],
            'listing_status' => ['listing_status', 'approval_status', 'status'],
            'verified' => ['verified', 'is_verified', 'verification_status'],
        ];

        // Find column mapping - map to header names (associative array keys)
        $columnMap = [];
        foreach ($fieldMapping as $modelField => $possibleColumns) {
            foreach ($possibleColumns as $possibleColumn) {
                $found = false;
                foreach ($headers as $header) {
                    if (strtolower(trim($header)) === strtolower(trim($possibleColumn))) {
                        $columnMap[$modelField] = $header; // Store header name, not index
                        $found = true;
                        break;
                    }
                }
                if ($found) break;
            }
        }

        $stats = [
            'total' => count($csvData),
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
            'errors' => [],
        ];

        DB::beginTransaction();

        try {
            $adminUserId = Auth::id();

            foreach ($csvData as $rowIndex => $row) {
                try {
                    // Map CSV row to model data
                    $data = [];

                    // Required fields
                    $name = $this->getCsvValue($row, $columnMap, 'name', $headers);
                    $fullAddress = $this->getCsvValue($row, $columnMap, 'full_address', $headers);
                    $city = $this->getCsvValue($row, $columnMap, 'city', $headers);
                    $latitude = $this->getCsvValue($row, $columnMap, 'latitude', $headers);
                    $longitude = $this->getCsvValue($row, $columnMap, 'longitude', $headers);

                    // Skip if required fields are missing
                    if (empty($name) || empty($fullAddress) || empty($city) ||
                        empty($latitude) || empty($longitude)) {
                        $stats['skipped']++;
                        $stats['errors'][] = "Row " . ($rowIndex + 2) . ": Missing required fields";
                        continue;
                    }

                    $data['name'] = trim($name);
                    $data['full_address'] = trim($fullAddress);
                    $data['city'] = trim($city);
                    // Optional area
                    if ($val = $this->getCsvValue($row, $columnMap, 'area', $headers)) {
                        $data['area'] = trim($val);
                    }
                    $data['latitude'] = (float) $latitude;
                    $data['longitude'] = (float) $longitude;
                    $data['creator_user_id'] = $adminUserId;

                    // Optional description
                    if ($val = $this->getCsvValue($row, $columnMap, 'description', $headers)) {
                        $data['description'] = trim($val);
                    }

                    // Optional fields
                    $placeId = $this->getCsvValue($row, $columnMap, 'place_id', $headers);
                    if (!empty($placeId)) {
                        $data['place_id'] = trim($placeId);
                    }

                    $slug = $this->getCsvValue($row, $columnMap, 'slug', $headers);
                    if (!empty($slug)) {
                        $data['slug'] = Str::slug(trim($slug));
                    } else {
                        $data['slug'] = Str::slug($data['name']);
                    }

                    // Ensure slug uniqueness
                    $originalSlug = $data['slug'];
                    $count = 1;
                    while (PartyPlot::where('slug', $data['slug'])->exists()) {
                        $data['slug'] = $originalSlug . '-' . $count;
                        $count++;
                    }

                    // Optional venue details
                    if ($val = $this->getCsvValue($row, $columnMap, 'capacity_min', $headers)) {
                        $data['capacity_min'] = (int) $val;
                    }
                    if ($val = $this->getCsvValue($row, $columnMap, 'capacity_max', $headers)) {
                        $data['capacity_max'] = (int) $val;
                    }
                    if ($val = $this->getCsvValue($row, $columnMap, 'price_range_min', $headers)) {
                        $data['price_range_min'] = (float) $val;
                    }
                    if ($val = $this->getCsvValue($row, $columnMap, 'price_range_max', $headers)) {
                        $data['price_range_max'] = (float) $val;
                    }
                    if ($val = $this->getCsvValue($row, $columnMap, 'area_lawn', $headers)) {
                        $data['area_lawn'] = trim($val);
                    }
                    if ($val = $this->getCsvValue($row, $columnMap, 'area_banquet', $headers)) {
                        $data['area_banquet'] = trim($val);
                    }
                    if ($val = $this->getCsvValue($row, $columnMap, 'suitable_events', $headers)) {
                        $data['suitable_events'] = trim($val);
                    }

                    // Handle Categories - map to category_id
                    if ($val = $this->getCsvValue($row, $columnMap, 'categories', $headers)) {
                        $categoryNames = array_map('trim', explode(',', $val));
                        // Get first category (primary category)
                        $categoryName = $categoryNames[0];
                        $category = \App\Models\Category::where('name', $categoryName)->first();
                        if ($category) {
                            $data['category_id'] = $category->id;
                        } else {
                            // Create category if it doesn't exist
                            $category = \App\Models\Category::create([
                                'name' => $categoryName,
                                'slug' => Str::slug($categoryName),
                                'is_active' => true,
                            ]);
                            $data['category_id'] = $category->id;
                        }
                        // Store all categories in suitable_events
                        $data['suitable_events'] = implode(', ', $categoryNames);
                    }

                    if ($val = $this->getCsvValue($row, $columnMap, 'tags', $headers)) {
                        $tags = array_filter(array_map('trim', explode(',', $val)));
                        $data['tags'] = $tags;
                    }

                    // Boolean amenities
                    $data['parking'] = $this->parseBoolean($this->getCsvValue($row, $columnMap, 'parking', $headers));
                    $data['rooms'] = $this->parseBoolean($this->getCsvValue($row, $columnMap, 'rooms', $headers));
                    $data['dj_allowed'] = $this->parseBoolean($this->getCsvValue($row, $columnMap, 'dj_allowed', $headers));
                    $data['decoration_allowed'] = $this->parseBoolean($this->getCsvValue($row, $columnMap, 'decoration_allowed', $headers));
                    $data['catering_allowed'] = $this->parseBoolean($this->getCsvValue($row, $columnMap, 'catering_allowed', $headers));
                    $data['generator_backup'] = $this->parseBoolean($this->getCsvValue($row, $columnMap, 'generator_backup', $headers));
                    $data['ac_available'] = $this->parseBoolean($this->getCsvValue($row, $columnMap, 'ac_available', $headers));

                    // Media (URLs only in CSV, not file uploads)
                    // Featured image ignored - will be added manually after CSV import
                    // if ($val = $this->getCsvValue($row, $columnMap, 'featured_image', $headers)) {
                    //     $data['featured_image'] = trim($val);
                    // }
                    if ($val = $this->getCsvValue($row, $columnMap, 'gallery_images', $headers)) {
                        $images = array_filter(array_map('trim', explode(',', $val)));
                        $data['gallery_images'] = $images;
                    }
                    if ($val = $this->getCsvValue($row, $columnMap, 'video_links', $headers)) {
                        $videos = array_filter(array_map('trim', explode(',', $val)));
                        $data['video_links'] = $videos;
                    }

                    // Ratings
                    if ($val = $this->getCsvValue($row, $columnMap, 'google_rating', $headers)) {
                        $data['google_rating'] = (float) $val;
                    }
                    if ($val = $this->getCsvValue($row, $columnMap, 'google_review_count', $headers)) {
                        $data['google_review_count'] = (int) $val;
                    }
                    if ($val = $this->getCsvValue($row, $columnMap, 'google_review_text', $headers)) {
                        $data['google_review_text'] = trim($val);
                    }

                    // Social
                    if ($val = $this->getCsvValue($row, $columnMap, 'instagram', $headers)) {
                        $data['instagram'] = trim($val);
                    }
                    if ($val = $this->getCsvValue($row, $columnMap, 'facebook', $headers)) {
                        $data['facebook'] = trim($val);
                    }
                    if ($val = $this->getCsvValue($row, $columnMap, 'twitter', $headers)) {
                        $data['twitter'] = trim($val);
                    }
                    if ($val = $this->getCsvValue($row, $columnMap, 'youtube', $headers)) {
                        $data['youtube'] = trim($val);
                    }
                    if ($val = $this->getCsvValue($row, $columnMap, 'website', $headers)) {
                        $data['website'] = trim($val);
                    }
                    if ($val = $this->getCsvValue($row, $columnMap, 'email', $headers)) {
                        $data['email'] = trim($val);
                    }
                    if ($val = $this->getCsvValue($row, $columnMap, 'phone', $headers)) {
                        $data['phone'] = trim($val);
                    }

                    // System fields
                    $data['status'] = 'active';
                    $data['listing_status'] = 'pending';
                    $data['verified'] = false;

                    // Check if exists (by place_id or name + full_address)
                    $existing = null;
                    if (!empty($data['place_id'])) {
                        $existing = PartyPlot::where('place_id', $data['place_id'])->first();
                    }

                    if (!$existing) {
                        $existing = PartyPlot::where('name', $data['name'])
                            ->where('full_address', $data['full_address'])
                            ->first();
                    }

                    if ($existing) {
                        // Update existing
                        $existing->update($data);
                        $stats['updated']++;
                    } else {
                        // Create new
                        PartyPlot::create($data);
                        $stats['created']++;
                    }
                } catch (\Exception $e) {
                    $stats['skipped']++;
                    $stats['errors'][] = "Row " . ($rowIndex + 2) . ": " . $e->getMessage();
                }
            }

            DB::commit();

            // Clear session
            session()->forget(['csv_import_data', 'csv_import_headers']);

            $message = "CSV import completed. Total: {$stats['total']}, Created: {$stats['created']}, Updated: {$stats['updated']}, Skipped: {$stats['skipped']}";

            if (!empty($stats['errors'])) {
                $message .= ". Errors: " . count($stats['errors']) . " rows had issues.";
            }

            return redirect()
                ->route('admin.party-plots.index')
                ->with('success', $message)
                ->with('import_stats', $stats);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error importing CSV: ' . $e->getMessage());
        }
    }

    /**
     * Helper to get CSV value by field mapping
     */
    private function getCsvValue($row, $columnMap, $field, $headers)
    {
        // $row is now an associative array with header names as keys
        // First try the column map
        if (isset($columnMap[$field]) && isset($row[$columnMap[$field]])) {
            $value = $row[$columnMap[$field]];
            return !empty($value) ? $value : null;
        }

        // Try direct header name match (case-insensitive)
        foreach ($headers as $header) {
            if (strtolower(trim($header)) === strtolower($field)) {
                if (isset($row[$header])) {
                    $value = $row[$header];
                    return !empty($value) ? $value : null;
                }
            }
        }

        // Try partial match (header contains field name or vice versa)
        foreach ($headers as $header) {
            $headerLower = strtolower(trim($header));
            $fieldLower = strtolower(trim($field));
            if (strpos($headerLower, $fieldLower) !== false || strpos($fieldLower, $headerLower) !== false) {
                if (isset($row[$header])) {
                    $value = $row[$header];
                    return !empty($value) ? $value : null;
                }
            }
        }

        return null;
    }

    /**
     * Parse boolean value from CSV
     */
    private function parseBoolean($value)
    {
        if (empty($value)) {
            return false;
        }

        $value = strtolower(trim($value));
        return in_array($value, ['1', 'true', 'yes', 'y', 'on']);
    }
}

