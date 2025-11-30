<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index(Request $request)
    {
        $query = Category::query();

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

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('categories.create');
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
            'image' => 'nullable|string|max:255',
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

        $data = $validator->validated();

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

        Category::create($data);

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified category
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
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
            'image' => 'nullable|string|max:255',
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

        $data = $validator->validated();

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

        $category->update($data);

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Check if category has party plots
        if ($category->partyPlots()->count() > 0) {
            return redirect()->route('admin.categories.index')
                          ->with('error', 'Cannot delete category. It has associated party plots.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Category deleted successfully.');
    }
}

