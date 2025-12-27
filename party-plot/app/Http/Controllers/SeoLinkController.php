<?php

namespace App\Http\Controllers;

use App\Models\SeoLink;
use App\Models\SeoLinkTemplate;
use App\Models\Category;
use App\Models\PartyPlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SeoLinkController extends Controller
{
    /**
     * Display a listing of SEO links
     */
    public function index(Request $request)
    {
        $query = SeoLink::with('category');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('link_text', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('area', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        // Filter by link type
        if ($request->filled('link_type')) {
            $query->where('link_type', $request->link_type);
        }

        // Filter by active status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active === '1');
        }

        // Filter by homepage visibility
        if ($request->filled('show_on_homepage')) {
            $query->where('show_on_homepage', $request->show_on_homepage === '1');
        }

        // Order
        $seoLinks = $query->orderBy('sort_order', 'asc')
                         ->orderBy('link_text', 'asc')
                         ->paginate(20);

        // Get link type options for filter
        $linkTypes = [
            'city' => 'City',
            'area' => 'Area',
            'category' => 'Category',
            'city_category' => 'City + Category',
            'area_category' => 'Area + Category',
            'tags' => 'Tags',
            'city_tags' => 'City + Tags',
            'area_tags' => 'Area + Tags',
            'category_tags' => 'Category + Tags',
        ];

        return view('admin.seo-links.index', compact('seoLinks', 'linkTypes'));
    }

    /**
     * Show the form for creating a new SEO link
     */
    public function create()
    {
        $categories = Category::active()->ordered()->get();
        $cities = $this->getUniqueCities();
        $areas = $this->getUniqueAreas();
        $tags = $this->getUniqueTags();
        
        $linkTypes = [
            'city' => 'City Only',
            'area' => 'Area Only',
            'category' => 'Category Only',
            'city_category' => 'City + Category',
            'area_category' => 'Area + Category',
            'tags' => 'Tags Only',
            'city_tags' => 'City + Tags',
            'area_tags' => 'Area + Tags',
            'category_tags' => 'Category + Tags',
        ];

        return view('admin.seo-links.create', compact('categories', 'cities', 'areas', 'tags', 'linkTypes'));
    }

    /**
     * Store a newly created SEO link
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'link_type' => 'required|in:city,area,category,city_category,area_category',
            'city' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'link_text' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:seo_links,slug',
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
            'page_title' => 'nullable|string|max:255',
            'page_description' => 'nullable|string',
            'is_active' => 'boolean',
            'show_on_homepage' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            $data = $request->except(['_token']);
            
            // Handle tags - convert array to comma-separated string
            if ($request->has('tags') && is_array($request->tags)) {
                $data['tags'] = implode(',', array_filter($request->tags));
            } elseif ($request->has('tags') && is_string($request->tags)) {
                $data['tags'] = $request->tags;
            } else {
                $data['tags'] = null;
            }
            
            // Auto-generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['link_text']);
                
                // Ensure uniqueness
                $originalSlug = $data['slug'];
                $count = 1;
                while (SeoLink::where('slug', $data['slug'])->exists()) {
                    $data['slug'] = $originalSlug . '-' . $count;
                    $count++;
                }
            }

            $data['is_active'] = $request->has('is_active') ? true : false;
            $data['show_on_homepage'] = $request->has('show_on_homepage') ? true : false;

            SeoLink::create($data);

            return redirect()->route('admin.seo-links.index')
                            ->with('success', 'SEO Link created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error creating SEO link: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Show the form for editing the specified SEO link
     */
    public function edit($id)
    {
        $seoLink = SeoLink::findOrFail($id);
        $categories = Category::active()->ordered()->get();
        $cities = $this->getUniqueCities();
        $areas = $this->getUniqueAreas();
        $tags = $this->getUniqueTags();
        
        $linkTypes = [
            'city' => 'City Only',
            'area' => 'Area Only',
            'category' => 'Category Only',
            'city_category' => 'City + Category',
            'area_category' => 'Area + Category',
            'tags' => 'Tags Only',
            'city_tags' => 'City + Tags',
            'area_tags' => 'Area + Tags',
            'category_tags' => 'Category + Tags',
        ];

        return view('admin.seo-links.edit', compact('seoLink', 'categories', 'cities', 'areas', 'tags', 'linkTypes'));
    }

    /**
     * Update the specified SEO link
     */
    public function update(Request $request, $id)
    {
        $seoLink = SeoLink::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'link_type' => 'required|in:city,area,category,city_category,area_category,tags,city_tags,area_tags,category_tags',
            'city' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|string|max:255',
            'link_text' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:seo_links,slug,' . $id,
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
            'page_title' => 'nullable|string|max:255',
            'page_description' => 'nullable|string',
            'is_active' => 'boolean',
            'show_on_homepage' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            $data = $request->except(['_token', '_method']);

            // Handle tags - convert array to comma-separated string
            if ($request->has('tags') && is_array($request->tags)) {
                $data['tags'] = implode(',', array_filter($request->tags));
            } elseif ($request->has('tags') && is_string($request->tags)) {
                $data['tags'] = $request->tags;
            } else {
                $data['tags'] = null;
            }

            $data['is_active'] = $request->has('is_active') ? true : false;
            $data['show_on_homepage'] = $request->has('show_on_homepage') ? true : false;

            $seoLink->update($data);

            return redirect()->route('admin.seo-links.index')
                            ->with('success', 'SEO Link updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error updating SEO link: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Remove the specified SEO link
     */
    public function destroy($id)
    {
        try {
            $seoLink = SeoLink::findOrFail($id);
            $seoLink->delete();

            return redirect()->route('admin.seo-links.index')
                            ->with('success', 'SEO Link deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error deleting SEO link: ' . $e->getMessage());
        }
    }

    /**
     * Delete all SEO links
     */
    public function deleteAll()
    {
        try {
            $count = SeoLink::count();
            
            if ($count === 0) {
                return redirect()->route('admin.seo-links.index')
                                ->with('info', 'No SEO links to delete.');
            }

            SeoLink::truncate();

            return redirect()->route('admin.seo-links.index')
                            ->with('success', "Successfully deleted all {$count} SEO link(s).");
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error deleting SEO links: ' . $e->getMessage());
        }
    }

    // ==================== TEMPLATES ====================

    /**
     * Display a listing of templates
     */
    public function templates(Request $request)
    {
        $query = SeoLinkTemplate::withCount('seoLinks');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $templates = $query->orderBy('name', 'asc')->paginate(20);

        return view('admin.seo-links.templates.index', compact('templates'));
    }

    /**
     * Show form to create a new template
     */
    public function createTemplate()
    {
        $templateTypes = [
            'city' => 'City Only',
            'area' => 'Area Only',
            'category' => 'Category Only',
            'city_category' => 'City + Category',
            'area_category' => 'Area + Category',
            'tags' => 'Tags Only',
            'city_tags' => 'City + Tags',
            'area_tags' => 'Area + Tags',
            'category_tags' => 'Category + Tags',
        ];

        $placeholders = SeoLinkTemplate::getPlaceholders();

        return view('admin.seo-links.templates.create', compact('templateTypes', 'placeholders'));
    }

    /**
     * Store a new template
     */
    public function storeTemplate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'template_type' => 'required|in:city,area,category,city_category,area_category,tags,city_tags,area_tags,category_tags',
            'link_text_template' => 'required|string|max:255',
            'slug_template' => 'required|string|max:255',
            'meta_title_template' => 'required|string|max:255',
            'meta_description_template' => 'nullable|string',
            'meta_keywords_template' => 'nullable|string|max:255',
            'page_title_template' => 'nullable|string|max:255',
            'page_description_template' => 'nullable|string',
            'is_active' => 'boolean',
            'min_venues' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            $data = $request->except(['_token']);
            $data['is_active'] = $request->has('is_active') ? true : false;
            $data['min_venues'] = $data['min_venues'] ?? 1;

            SeoLinkTemplate::create($data);

            return redirect()->route('admin.seo-links.templates')
                            ->with('success', 'Template created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error creating template: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Show form to edit a template
     */
    public function editTemplate($id)
    {
        $template = SeoLinkTemplate::findOrFail($id);

        $templateTypes = [
            'city' => 'City Only',
            'area' => 'Area Only',
            'category' => 'Category Only',
            'city_category' => 'City + Category',
            'area_category' => 'Area + Category',
            'tags' => 'Tags Only',
            'city_tags' => 'City + Tags',
            'area_tags' => 'Area + Tags',
            'category_tags' => 'Category + Tags',
        ];

        $placeholders = SeoLinkTemplate::getPlaceholders();

        return view('admin.seo-links.templates.edit', compact('template', 'templateTypes', 'placeholders'));
    }

    /**
     * Update a template
     */
    public function updateTemplate(Request $request, $id)
    {
        $template = SeoLinkTemplate::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'template_type' => 'required|in:city,area,category,city_category,area_category,tags,city_tags,area_tags,category_tags',
            'link_text_template' => 'required|string|max:255',
            'slug_template' => 'required|string|max:255',
            'meta_title_template' => 'required|string|max:255',
            'meta_description_template' => 'nullable|string',
            'meta_keywords_template' => 'nullable|string|max:255',
            'page_title_template' => 'nullable|string|max:255',
            'page_description_template' => 'nullable|string',
            'is_active' => 'boolean',
            'min_venues' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            $data = $request->except(['_token', '_method']);
            $data['is_active'] = $request->has('is_active') ? true : false;

            $template->update($data);

            return redirect()->route('admin.seo-links.templates')
                            ->with('success', 'Template updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error updating template: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Delete a template
     */
    public function destroyTemplate($id)
    {
        try {
            $template = SeoLinkTemplate::findOrFail($id);
            
            // Check if template has generated links
            if ($template->seoLinks()->count() > 0) {
                return redirect()->route('admin.seo-links.templates')
                              ->with('error', 'Cannot delete template. It has ' . $template->seoLinks()->count() . ' generated links.');
            }

            $template->delete();

            return redirect()->route('admin.seo-links.templates')
                            ->with('success', 'Template deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error deleting template: ' . $e->getMessage());
        }
    }

    // ==================== BULK GENERATION ====================

    /**
     * Show bulk generation page
     */
    public function bulkGenerate()
    {
        $templates = SeoLinkTemplate::active()->get();
        
        return view('admin.seo-links.bulk-generate', compact('templates'));
    }

    /**
     * Preview links that would be generated from a template
     */
    public function previewBulkGenerate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'template_id' => 'required|exists:seo_link_templates,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $template = SeoLinkTemplate::findOrFail($request->template_id);
        $previewLinks = $this->generatePreviewLinks($template);
        $templates = SeoLinkTemplate::active()->get();

        return view('admin.seo-links.bulk-generate', compact('templates', 'template', 'previewLinks'));
    }

    /**
     * Execute bulk generation
     */
    public function executeBulkGenerate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'template_id' => 'required|exists:seo_link_templates,id',
            'selected_links' => 'required|array|min:1',
            'selected_links.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            DB::beginTransaction();

            $template = SeoLinkTemplate::findOrFail($request->template_id);
            $selectedLinks = $request->selected_links;
            $created = 0;
            $skipped = 0;

            foreach ($selectedLinks as $linkKey) {
                $result = $this->createLinkFromTemplate($template, $linkKey);
                if ($result) {
                    $created++;
                } else {
                    $skipped++;
                }
            }

            DB::commit();

            return redirect()->route('admin.seo-links.index')
                            ->with('success', "Bulk generation completed. Created: {$created} links. Skipped: {$skipped} (already exist).");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Error during bulk generation: ' . $e->getMessage())
                           ->withInput();
        }
    }

    // ==================== HELPER METHODS ====================

    /**
     * Get unique cities from party plots
     */
    private function getUniqueCities()
    {
        return PartyPlot::where('status', 'active')
            ->whereIn('listing_status', ['approved', 'pending'])
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->pluck('city')
            ->filter()
            ->sort()
            ->values();
    }

    /**
     * Get unique areas from party plots
     */
    private function getUniqueAreas()
    {
        return PartyPlot::where('status', 'active')
            ->whereIn('listing_status', ['approved', 'pending'])
            ->whereNotNull('area')
            ->where('area', '!=', '')
            ->distinct()
            ->pluck('area')
            ->filter()
            ->sort()
            ->values();
    }

    /**
     * Get unique tags from party plots
     */
    private function getUniqueTags()
    {
        $partyPlots = PartyPlot::where('status', 'active')
            ->whereIn('listing_status', ['approved', 'pending'])
            ->whereNotNull('tags')
            ->where('tags', '!=', '[]')
            ->where('tags', '!=', '')
            ->get();

        $allTags = [];
        foreach ($partyPlots as $plot) {
            if ($plot->tags) {
                $tags = is_array($plot->tags) ? $plot->tags : json_decode($plot->tags, true);
                if (is_array($tags)) {
                    foreach ($tags as $tag) {
                        $tag = trim($tag);
                        if (!empty($tag)) {
                            $allTags[$tag] = true;
                        }
                    }
                }
            }
        }

        $uniqueTags = array_keys($allTags);
        sort($uniqueTags);
        return collect($uniqueTags);
    }

    /**
     * Generate preview links based on template
     */
    private function generatePreviewLinks(SeoLinkTemplate $template): array
    {
        $previewLinks = [];
        $categories = Category::active()->ordered()->get();

        switch ($template->template_type) {
            case 'city':
                $cities = $this->getUniqueCities();
                foreach ($cities as $city) {
                    $count = $this->getVenueCount(['city' => $city]);
                    if ($count >= $template->min_venues) {
                        $key = "city:{$city}";
                        $linkText = $this->replacePlaceholders($template->link_text_template, [
                            'city' => $city,
                            'count' => $count,
                        ]);
                        $slug = $this->replacePlaceholders($template->slug_template, [
                            'city_slug' => Str::slug($city),
                        ]);
                        
                        $exists = SeoLink::where('slug', $slug)->exists();
                        
                        $previewLinks[] = [
                            'key' => $key,
                            'link_text' => $linkText,
                            'slug' => $slug,
                            'venue_count' => $count,
                            'exists' => $exists,
                            'city' => $city,
                        ];
                    }
                }
                break;

            case 'area':
                $areas = $this->getUniqueAreas();
                foreach ($areas as $area) {
                    $count = $this->getVenueCount(['area' => $area]);
                    if ($count >= $template->min_venues) {
                        $key = "area:{$area}";
                        $linkText = $this->replacePlaceholders($template->link_text_template, [
                            'area' => $area,
                            'count' => $count,
                        ]);
                        $slug = $this->replacePlaceholders($template->slug_template, [
                            'area_slug' => Str::slug($area),
                        ]);
                        
                        $exists = SeoLink::where('slug', $slug)->exists();
                        
                        $previewLinks[] = [
                            'key' => $key,
                            'link_text' => $linkText,
                            'slug' => $slug,
                            'venue_count' => $count,
                            'exists' => $exists,
                            'area' => $area,
                        ];
                    }
                }
                break;

            case 'category':
                foreach ($categories as $category) {
                    $count = $this->getVenueCount(['category_id' => $category->id]);
                    if ($count >= $template->min_venues) {
                        $key = "category:{$category->id}";
                        $linkText = $this->replacePlaceholders($template->link_text_template, [
                            'category' => $category->name,
                            'count' => $count,
                        ]);
                        $slug = $this->replacePlaceholders($template->slug_template, [
                            'category_slug' => $category->slug,
                        ]);
                        
                        $exists = SeoLink::where('slug', $slug)->exists();
                        
                        $previewLinks[] = [
                            'key' => $key,
                            'link_text' => $linkText,
                            'slug' => $slug,
                            'venue_count' => $count,
                            'exists' => $exists,
                            'category_id' => $category->id,
                            'category_name' => $category->name,
                        ];
                    }
                }
                break;

            case 'city_category':
                $cities = $this->getUniqueCities();
                foreach ($cities as $city) {
                    foreach ($categories as $category) {
                        $count = $this->getVenueCount(['city' => $city, 'category_id' => $category->id]);
                        if ($count >= $template->min_venues) {
                            $key = "city_category:{$city}:{$category->id}";
                            $linkText = $this->replacePlaceholders($template->link_text_template, [
                                'city' => $city,
                                'category' => $category->name,
                                'count' => $count,
                            ]);
                            $slug = $this->replacePlaceholders($template->slug_template, [
                                'city_slug' => Str::slug($city),
                                'category_slug' => $category->slug,
                            ]);
                            
                            $exists = SeoLink::where('slug', $slug)->exists();
                            
                            $previewLinks[] = [
                                'key' => $key,
                                'link_text' => $linkText,
                                'slug' => $slug,
                                'venue_count' => $count,
                                'exists' => $exists,
                                'city' => $city,
                                'category_id' => $category->id,
                                'category_name' => $category->name,
                            ];
                        }
                    }
                }
                break;

            case 'area_category':
                $areas = $this->getUniqueAreas();
                foreach ($areas as $area) {
                    foreach ($categories as $category) {
                        $count = $this->getVenueCount(['area' => $area, 'category_id' => $category->id]);
                        if ($count >= $template->min_venues) {
                            $key = "area_category:{$area}:{$category->id}";
                            $linkText = $this->replacePlaceholders($template->link_text_template, [
                                'area' => $area,
                                'category' => $category->name,
                                'count' => $count,
                            ]);
                            $slug = $this->replacePlaceholders($template->slug_template, [
                                'area_slug' => Str::slug($area),
                                'category_slug' => $category->slug,
                            ]);
                            
                            $exists = SeoLink::where('slug', $slug)->exists();
                            
                            $previewLinks[] = [
                                'key' => $key,
                                'link_text' => $linkText,
                                'slug' => $slug,
                                'venue_count' => $count,
                                'exists' => $exists,
                                'area' => $area,
                                'category_id' => $category->id,
                                'category_name' => $category->name,
                            ];
                        }
                    }
                }
                break;

            case 'tags':
                $tags = $this->getUniqueTags();
                foreach ($tags as $tag) {
                    $count = $this->getVenueCount(['tags' => $tag]);
                    if ($count >= $template->min_venues) {
                        $key = "tags:{$tag}";
                        $linkText = $this->replacePlaceholders($template->link_text_template, [
                            'tags' => $tag,
                            'count' => $count,
                        ]);
                        $slug = $this->replacePlaceholders($template->slug_template, [
                            'tags_slug' => Str::slug($tag),
                        ]);
                        
                        $exists = SeoLink::where('slug', $slug)->exists();
                        
                        $previewLinks[] = [
                            'key' => $key,
                            'link_text' => $linkText,
                            'slug' => $slug,
                            'venue_count' => $count,
                            'exists' => $exists,
                            'tags' => $tag,
                        ];
                    }
                }
                break;

            case 'city_tags':
                $cities = $this->getUniqueCities();
                $tags = $this->getUniqueTags();
                foreach ($cities as $city) {
                    foreach ($tags as $tag) {
                        $count = $this->getVenueCount(['city' => $city, 'tags' => $tag]);
                        if ($count >= $template->min_venues) {
                            $key = "city_tags:{$city}:{$tag}";
                            $linkText = $this->replacePlaceholders($template->link_text_template, [
                                'city' => $city,
                                'tags' => $tag,
                                'count' => $count,
                            ]);
                            $slug = $this->replacePlaceholders($template->slug_template, [
                                'city_slug' => Str::slug($city),
                                'tags_slug' => Str::slug($tag),
                            ]);
                            
                            $exists = SeoLink::where('slug', $slug)->exists();
                            
                            $previewLinks[] = [
                                'key' => $key,
                                'link_text' => $linkText,
                                'slug' => $slug,
                                'venue_count' => $count,
                                'exists' => $exists,
                                'city' => $city,
                                'tags' => $tag,
                            ];
                        }
                    }
                }
                break;

            case 'area_tags':
                $areas = $this->getUniqueAreas();
                $tags = $this->getUniqueTags();
                foreach ($areas as $area) {
                    foreach ($tags as $tag) {
                        $count = $this->getVenueCount(['area' => $area, 'tags' => $tag]);
                        if ($count >= $template->min_venues) {
                            $key = "area_tags:{$area}:{$tag}";
                            $linkText = $this->replacePlaceholders($template->link_text_template, [
                                'area' => $area,
                                'tags' => $tag,
                                'count' => $count,
                            ]);
                            $slug = $this->replacePlaceholders($template->slug_template, [
                                'area_slug' => Str::slug($area),
                                'tags_slug' => Str::slug($tag),
                            ]);
                            
                            $exists = SeoLink::where('slug', $slug)->exists();
                            
                            $previewLinks[] = [
                                'key' => $key,
                                'link_text' => $linkText,
                                'slug' => $slug,
                                'venue_count' => $count,
                                'exists' => $exists,
                                'area' => $area,
                                'tags' => $tag,
                            ];
                        }
                    }
                }
                break;

            case 'category_tags':
                $categories = Category::active()->ordered()->get();
                $tags = $this->getUniqueTags();
                foreach ($categories as $category) {
                    foreach ($tags as $tag) {
                        $count = $this->getVenueCount(['category_id' => $category->id, 'tags' => $tag]);
                        if ($count >= $template->min_venues) {
                            $key = "category_tags:{$category->id}:{$tag}";
                            $linkText = $this->replacePlaceholders($template->link_text_template, [
                                'category' => $category->name,
                                'tags' => $tag,
                                'count' => $count,
                            ]);
                            $slug = $this->replacePlaceholders($template->slug_template, [
                                'category_slug' => $category->slug,
                                'tags_slug' => Str::slug($tag),
                            ]);
                            
                            $exists = SeoLink::where('slug', $slug)->exists();
                            
                            $previewLinks[] = [
                                'key' => $key,
                                'link_text' => $linkText,
                                'slug' => $slug,
                                'venue_count' => $count,
                                'exists' => $exists,
                                'category_id' => $category->id,
                                'category_name' => $category->name,
                                'tags' => $tag,
                            ];
                        }
                    }
                }
                break;
        }

        return $previewLinks;
    }

    /**
     * Get venue count based on filters
     */
    private function getVenueCount(array $filters): int
    {
        $query = PartyPlot::where('status', 'active')
            ->whereIn('listing_status', ['approved', 'pending']);

        if (!empty($filters['city'])) {
            $query->where('city', $filters['city']);
        }

        if (!empty($filters['area'])) {
            $query->where('area', $filters['area']);
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['tags'])) {
            $tag = $filters['tags'];
            $query->whereJsonContains('tags', $tag);
        }

        return $query->count();
    }

    /**
     * Replace placeholders in template string
     */
    private function replacePlaceholders(string $template, array $values): string
    {
        $replacements = [
            '{city}' => $values['city'] ?? '',
            '{area}' => $values['area'] ?? '',
            '{category}' => $values['category'] ?? '',
            '{tags}' => $values['tags'] ?? '',
            '{city_slug}' => $values['city_slug'] ?? '',
            '{area_slug}' => $values['area_slug'] ?? '',
            '{category_slug}' => $values['category_slug'] ?? '',
            '{tags_slug}' => $values['tags_slug'] ?? '',
            '{count}' => $values['count'] ?? '',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $template);
    }

    /**
     * Create a single link from template and key
     */
    private function createLinkFromTemplate(SeoLinkTemplate $template, string $key): bool
    {
        // Parse the key to get values
        $parts = explode(':', $key);
        $type = $parts[0];
        
        $city = null;
        $area = null;
        $categoryId = null;
        $category = null;
        $tags = null;

        switch ($type) {
            case 'city':
                $city = $parts[1];
                break;
            case 'area':
                $area = $parts[1];
                break;
            case 'category':
                $categoryId = $parts[1];
                $category = Category::find($categoryId);
                break;
            case 'city_category':
                $city = $parts[1];
                $categoryId = $parts[2];
                $category = Category::find($categoryId);
                break;
            case 'area_category':
                $area = $parts[1];
                $categoryId = $parts[2];
                $category = Category::find($categoryId);
                break;
            case 'tags':
                $tags = $parts[1];
                break;
            case 'city_tags':
                $city = $parts[1];
                $tags = $parts[2];
                break;
            case 'area_tags':
                $area = $parts[1];
                $tags = $parts[2];
                break;
            case 'category_tags':
                $categoryId = $parts[1];
                $category = Category::find($categoryId);
                $tags = $parts[2];
                break;
        }

        // Calculate count
        $count = $this->getVenueCount([
            'city' => $city,
            'area' => $area,
            'category_id' => $categoryId,
            'tags' => $tags,
        ]);

        // Build replacement values
        $values = [
            'city' => $city,
            'area' => $area,
            'category' => $category ? $category->name : '',
            'tags' => $tags,
            'city_slug' => $city ? Str::slug($city) : '',
            'area_slug' => $area ? Str::slug($area) : '',
            'category_slug' => $category ? $category->slug : '',
            'tags_slug' => $tags ? Str::slug($tags) : '',
            'count' => $count,
        ];

        // Generate slug
        $slug = $this->replacePlaceholders($template->slug_template, $values);

        // Check if link already exists
        if (SeoLink::where('slug', $slug)->exists()) {
            return false;
        }

        // Create the link
        SeoLink::create([
            'link_type' => $template->template_type,
            'city' => $city,
            'area' => $area,
            'category_id' => $categoryId,
            'tags' => $tags,
            'link_text' => $this->replacePlaceholders($template->link_text_template, $values),
            'slug' => $slug,
            'meta_title' => $this->replacePlaceholders($template->meta_title_template, $values),
            'meta_description' => $template->meta_description_template ? $this->replacePlaceholders($template->meta_description_template, $values) : null,
            'meta_keywords' => $template->meta_keywords_template ? $this->replacePlaceholders($template->meta_keywords_template, $values) : null,
            'page_title' => $template->page_title_template ? $this->replacePlaceholders($template->page_title_template, $values) : null,
            'page_description' => $template->page_description_template ? $this->replacePlaceholders($template->page_description_template, $values) : null,
            'is_active' => true,
            'show_on_homepage' => true,
            'sort_order' => 0,
            'template_id' => $template->id,
        ]);

        return true;
    }
}


