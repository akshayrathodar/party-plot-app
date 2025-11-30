<?php

namespace App\Http\Controllers;

use App\Models\PartyPlot;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the homepage
     */
    public function home()
    {
        // TODO: Fetch popular party plots from database
        $popularPlots = collect([]); // Replace with: PartyPlot::popular()->take(6)->get();

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

        // Fetch cities with counts and featured images for the destination slider
        $citiesWithCounts = PartyPlot::where('status', 'active')
            ->whereIn('listing_status', ['approved', 'pending'])
            ->whereNotNull('city')
            ->selectRaw('city, COUNT(*) as plot_count')
            ->groupBy('city')
            ->orderBy('plot_count', 'desc')
            ->orderBy('city', 'asc')
            ->limit(10)
            ->get();

        // Get featured image for each city (first party plot with image)
        $citiesWithData = $citiesWithCounts->map(function ($item) {
            $cityPlot = PartyPlot::where('status', 'active')
                ->whereIn('listing_status', ['approved', 'pending'])
                ->where('city', $item->city)
                ->whereNotNull('featured_image')
                ->where('featured_image', '!=', '')
                ->where('featured_image', '!=', 'null')
                ->orderBy('created_at', 'desc')
                ->first();

            return [
                'city' => $item->city,
                'count' => $item->plot_count,
                'image' => $cityPlot ? $cityPlot->featured_image : null
            ];
        });

        return view('pages.home', compact('popularPlots', 'seoTags', 'categories', 'cities', 'citiesWithData'));
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

        return view('pages.party-plots.index', compact('plots', 'categories', 'cities'));
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

        return view('pages.party-plots.show', compact('plot'));
    }

    /**
     * Show form to create party plot
     */
    public function createPartyPlot()
    {
        // TODO: Add authentication check
        // $this->middleware('auth');

        return view('pages.party-plots.create');
    }
}

