<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PartyPlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index(Request $request)
    {
        $query = Category::withCount('partyPlots');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by active status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active === '1');
        }

        // Order by sort_order, then name
        $categories = $query->orderBy('sort_order', 'asc')
                           ->orderBy('name', 'asc')
                           ->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            $data = $request->except(['image', '_token']);

            // Auto-generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);

                // Ensure uniqueness
                $originalSlug = $data['slug'];
                $count = 1;
                while (Category::where('slug', $data['slug'])->exists()) {
                    $data['slug'] = $originalSlug . '-' . $count;
                    $count++;
                }
            }

            $data['is_active'] = $request->has('is_active') ? true : false;

            // Handle image upload
            if ($request->hasFile('image')) {
                $data['image'] = uploadFile(
                    $request->file('image'),
                    'category',
                    'categories',
                    'admin'
                );
            }

            Category::create($data);

            return redirect()->route('admin.categories.index')
                            ->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error creating category: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Display the specified category
     */
    public function show($id)
    {
        $category = Category::withCount('partyPlots')->findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            $data = $request->except(['image', '_token', '_method']);

            // Auto-generate slug if name changed and slug is empty
            if ($category->name !== $data['name'] && empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);

                // Ensure uniqueness
                $originalSlug = $data['slug'];
                $count = 1;
                while (Category::where('slug', $data['slug'])->where('id', '!=', $id)->exists()) {
                    $data['slug'] = $originalSlug . '-' . $count;
                    $count++;
                }
            }

            $data['is_active'] = $request->has('is_active') ? true : false;

            // Handle image upload
            if ($request->hasFile('image')) {
                $data['image'] = uploadFile(
                    $request->file('image'),
                    'category',
                    'categories',
                    'admin',
                    $category->image // Delete old image
                );
            }

            // Handle image removal
            if ($request->has('remove_image') && $request->remove_image == '1') {
                if ($category->image) {
                    unlinkFile($category->image, 'categories', 'admin');
                }
                $data['image'] = null;
            }

            $category->update($data);

            return redirect()->route('admin.categories.index')
                            ->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error updating category: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Remove the specified category
     */
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);

            // Check if category has party plots
            if ($category->partyPlots()->count() > 0) {
                return redirect()->route('admin.categories.index')
                              ->with('error', 'Cannot delete category. It has ' . $category->partyPlots()->count() . ' associated party plots. Please reassign them first.');
            }

            // Delete image if exists
            if ($category->image) {
                unlinkFile($category->image, 'categories', 'admin');
            }

            $category->delete();

            return redirect()->route('admin.categories.index')
                            ->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error deleting category: ' . $e->getMessage());
        }
    }

    /**
     * Import categories from existing party plots suitable_events field
     */
    public function importFromPartyPlots()
    {
        try {
            DB::beginTransaction();

            // Get all unique category names from party_plots suitable_events
            $partyPlots = PartyPlot::whereNotNull('suitable_events')
                ->where('suitable_events', '!=', '')
                ->get();

            $categoryNames = [];
            foreach ($partyPlots as $plot) {
                $events = $plot->suitable_events_array;
                foreach ($events as $event) {
                    $event = trim($event);
                    if (!empty($event)) {
                        $categoryNames[$event] = true;
                    }
                }
            }

            $created = 0;
            $existing = 0;

            foreach (array_keys($categoryNames) as $categoryName) {
                // Check if category already exists
                $existingCategory = Category::where('name', $categoryName)->first();
                
                if (!$existingCategory) {
                    Category::create([
                        'name' => $categoryName,
                        'slug' => Str::slug($categoryName),
                        'is_active' => true,
                        'sort_order' => 0,
                    ]);
                    $created++;
                } else {
                    $existing++;
                }
            }

            DB::commit();

            return redirect()->route('admin.categories.index')
                            ->with('success', "Import completed. Created: {$created} categories. Already existing: {$existing}.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Error importing categories: ' . $e->getMessage());
        }
    }
}
