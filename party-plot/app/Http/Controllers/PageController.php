<?php

namespace App\Http\Controllers;

use App\Models\PartyPlot;
use App\Models\Blog;
use App\Models\SeoLink;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the homepage
     */
    public function home()
    {
        // Fetch top 6 party plots with images and most views
        $popularPlots = PartyPlot::where('status', 'active')
            ->whereIn('listing_status', ['approved', 'pending'])
            ->where(function($query) {
                $query->whereNotNull('featured_image')
                    ->where('featured_image', '!=', '')
                    ->where('featured_image', '!=', 'null')
                    ->orWhereNotNull('gallery_images')
                    ->where('gallery_images', '!=', '[]')
                    ->where('gallery_images', '!=', '');
            })
            ->orderBy('visitors', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // TODO: Fetch SEO tags for location browsing
        $seoTags = collect([]); // Replace with: Tag::withCount('partyPlots')->take(8)->get();

        // Fetch categories and cities for homepage search form
        $categories = \App\Models\Category::active()->ordered()->get();
        $cities = PartyPlot::where('status', 'active')
            ->whereIn('listing_status', ['approved', 'pending'])
            ->whereNotNull('city')
            ->distinct()
            ->pluck('city')
            ->filter()
            ->sort()
            ->values();

        // Fetch categories with counts for homepage display
        $categoriesWithCounts = \App\Models\Category::active()
            ->withCount(['partyPlots' => function($query) {
                $query->where('status', 'active')
                    ->whereIn('listing_status', ['approved', 'pending']);
            }])
            ->having('party_plots_count', '>', 0)
            ->ordered()
            ->limit(10)
            ->get();

        // Fetch published blogs for homepage
        $blogs = Blog::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Calculate statistics for counter section
        $totalVenues = PartyPlot::where('status', 'active')
            ->whereIn('listing_status', ['approved', 'pending'])
            ->count();

        $totalVisitors = PartyPlot::where('status', 'active')
            ->whereIn('listing_status', ['approved', 'pending'])
            ->sum('visitors');

        // Calculate total cities with venues
        $totalCities = PartyPlot::where('status', 'active')
            ->whereIn('listing_status', ['approved', 'pending'])
            ->whereNotNull('city')
            ->distinct('city')
            ->count('city');

        // Calculate satisfaction rate (default value, can be calculated from reviews/ratings if available)
        $satisfactionRate = 98;

        // Fetch SEO links for homepage "Related Links" section
        $relatedLinks = SeoLink::where('is_active', true)
            ->where('show_on_homepage', true)
            ->ordered()
            ->get();

        return view('pages.home', compact('popularPlots', 'seoTags', 'categories', 'cities', 'categoriesWithCounts', 'blogs', 'totalVenues', 'totalVisitors', 'totalCities', 'satisfactionRate', 'relatedLinks'));
    }

    /**
     * Display the about page
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Display the contact page
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Handle search functionality
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        // TODO: Implement search logic
        // $results = PartyPlot::search($query)->get();

        return redirect()->route('party-plots.index', ['q' => $query]);
    }

    /**
     * Display all party plots
     */
    public function partyPlots(Request $request)
    {
        $query = PartyPlot::with('category')
            ->where('status', 'active')
            ->whereIn('listing_status', ['approved', 'pending']); // Show both approved and pending listings

        // Search filter - party plot name
        if ($request->filled('name')) {
            $name = $request->name;
            $query->where('name', 'like', "%{$name}%");
        }

        // Search filter - general search (for backward compatibility)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('full_address', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('area', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // City filter
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Area filter
        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }

        // Amenities filter
        if ($request->filled('parking')) {
            $query->where('parking', true);
        }
        if ($request->filled('ac_available')) {
            $query->where('ac_available', true);
        }
        if ($request->filled('generator_backup')) {
            $query->where('generator_backup', true);
        }

        // Sort by images first (those with featured_image on top), then by created_at
        // This ensures venues with images appear first for better UI
        $query->orderByRaw('CASE WHEN featured_image IS NOT NULL AND featured_image != "" AND featured_image != "null" THEN 0 ELSE 1 END')
              ->orderBy('created_at', 'desc');

        // Get sorting option
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price_range_min', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price_range_max', 'desc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        $plots = $query->paginate(12)->withQueryString();

        // Get filter data
        $categories = \App\Models\Category::active()->ordered()->get();
        $cities = PartyPlot::where('status', 'active')
            ->whereIn('listing_status', ['approved', 'pending'])
            ->whereNotNull('city')
            ->distinct()
            ->pluck('city')
            ->filter()
            ->sort()
            ->values();
        $areas = PartyPlot::where('status', 'active')
            ->whereIn('listing_status', ['approved', 'pending'])
            ->whereNotNull('area')
            ->where('area', '!=', '')
            ->distinct()
            ->pluck('area')
            ->filter()
            ->sort()
            ->values();

        return view('front.party-plots.index', compact('plots', 'categories', 'cities', 'areas'));
    }

    /**
     * Display party plots by tag
     */
    public function partyPlotsByTag($slug)
    {
        // TODO: Fetch party plots by tag
        // $tag = Tag::where('slug', $slug)->firstOrFail();
        // $plots = $tag->partyPlots()->paginate(12);

        return view('pages.party-plots.tag', [
            'tag' => (object)['name' => ucfirst($slug), 'slug' => $slug],
            'plots' => collect([]),
        ]);
    }

    /**
     * Display party plot details
     */
    public function partyPlotDetails($slug)
    {
        $plot = PartyPlot::where('slug', $slug)
            ->where('status', 'active')
            ->whereIn('listing_status', ['approved', 'pending'])
            ->firstOrFail();

        // Increment visitors count
        $plot->increment('visitors');

        return view('front.party-plots.show', compact('plot'));
    }

    /**
     * Show form to create party plot
     */
    public function createPartyPlot()
    {
        // TODO: Add authentication check
        // $this->middleware('auth');

        return view('front.party-plots.create');
    }

    /**
     * Display all blogs
     */
    public function blogs(Request $request)
    {
        $query = Blog::where('status', 'published');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $query->orderBy('created_at', 'desc');
        $blogs = $query->paginate(12)->withQueryString();

        return view('front.blogs.index', compact('blogs'));
    }

    /**
     * Display blog details
     */
    public function blogDetails($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment views count
        $blog->increment('views');

        // Get related blogs (same category or recent)
        $relatedBlogs = Blog::where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('front.blogs.show', compact('blog', 'relatedBlogs'));
    }

    /**
     * Display SEO link page with filtered party plots
     */
    public function seoLink(Request $request, $slug)
    {
        $seoLink = SeoLink::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get filtered party plots using the SEO link's query builder
        $query = $seoLink->getPartyPlotsQuery();

        // Additional filters from request
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('full_address', 'like', "%{$search}%");
            });
        }

        // Category filter (additional to SEO link's category)
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // City filter (additional to SEO link's city)
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Area filter (additional to SEO link's area)
        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }

        // Amenities filters
        if ($request->filled('parking')) {
            $query->where('parking', true);
        }
        if ($request->filled('ac_available')) {
            $query->where('ac_available', true);
        }
        if ($request->filled('generator_backup')) {
            $query->where('generator_backup', true);
        }

        // Handle sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price_range_min', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price_range_max', 'desc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        $plots = $query->paginate(12)->withQueryString();

        // Get filter data for sidebar/filters
        $categories = \App\Models\Category::active()->ordered()->get();
        $cities = PartyPlot::where('status', 'active')
            ->whereIn('listing_status', ['approved', 'pending'])
            ->whereNotNull('city')
            ->distinct()
            ->pluck('city')
            ->filter()
            ->sort()
            ->values();
        $areas = PartyPlot::where('status', 'active')
            ->whereIn('listing_status', ['approved', 'pending'])
            ->whereNotNull('area')
            ->where('area', '!=', '')
            ->distinct()
            ->pluck('area')
            ->filter()
            ->sort()
            ->values();

        return view('front.seo-links.show', compact('seoLink', 'plots', 'categories', 'cities', 'areas'));
    }
}

