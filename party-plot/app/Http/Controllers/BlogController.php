<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of blogs
     */
    public function index(Request $request)
    {
        $query = Blog::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $blogs = $query->paginate(20);

        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new blog
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created blog
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'status' => 'nullable|in:draft,published',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->all();

            // Handle slug generation
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
                $originalSlug = $data['slug'];
                $count = 1;
                while (Blog::where('slug', $data['slug'])->exists()) {
                    $data['slug'] = $originalSlug . '-' . $count;
                    $count++;
                }
            }

            // Handle image upload
            if ($request->hasFile('image')) {
                $data['image'] = uploadFile(
                    $request->file('image'),
                    'blog-image',
                    'blogs',
                    'admin'
                );
            }

            // Set default status
            $data['status'] = $data['status'] ?? 'draft';

            $blog = Blog::create($data);

            return redirect()
                ->route('admin.blogs.index')
                ->with('success', 'Blog created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating blog: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing a blog
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update a blog
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug,' . $id,
            'description' => 'required|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'status' => 'nullable|in:draft,published',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->all();

            // Handle slug generation
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
                $originalSlug = $data['slug'];
                $count = 1;
                while (Blog::where('slug', $data['slug'])->where('id', '!=', $id)->exists()) {
                    $data['slug'] = $originalSlug . '-' . $count;
                    $count++;
                }
            }

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($blog->image) {
                    unlinkFile($blog->image, 'blogs', 'admin');
                }
                $data['image'] = uploadFile(
                    $request->file('image'),
                    'blog-image',
                    'blogs',
                    'admin'
                );
            } else {
                // Keep existing image if not uploading new one
                $data['image'] = $blog->image;
            }

            $blog->update($data);

            return redirect()
                ->route('admin.blogs.index')
                ->with('success', 'Blog updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating blog: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified blog
     */
    public function destroy($id)
    {
        try {
            $blog = Blog::findOrFail($id);

            // Delete image if exists
            if ($blog->image) {
                unlinkFile($blog->image, 'blogs', 'admin');
            }

            $blog->delete();

            return redirect()
                ->route('admin.blogs.index')
                ->with('success', 'Blog deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting blog: ' . $e->getMessage());
        }
    }
}









