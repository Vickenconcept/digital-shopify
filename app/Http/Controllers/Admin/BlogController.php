<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Blog::with('user')->latest();

        // Apply search filter
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('content', 'like', "%{$searchTerm}%")
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'like', "%{$searchTerm}%");
                    });
            });
        }

        // Apply status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_published', $request->status);
        }

        // Apply featured filter
        if ($request->has('featured') && $request->featured !== '') {
            $query->where('is_featured', $request->featured);
        }

        // Apply date range filter
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('published_at', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('published_at', '<=', $request->to_date);
        }

        $blogs = $query->paginate(10)->withQueryString();

        return view('admin.blogs.index', compact('blogs'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = auth()->id();
            $data['slug'] = Str::slug($data['title']);
            $data['published_at'] = $data['is_published'] ? now() : null;

            if ($request->hasFile('featured_image')) {
                $path = $request->file('featured_image')->store('blog/images', 'public');
                $data['featured_image'] = $path;
            }

            Blog::create($data);

            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog post created successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to create blog post. ' . $e->getMessage())
                ->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view('admin.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, Blog $blog)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['title']);
            $data['published_at'] = $data['is_published'] ? ($blog->published_at ?? now()) : null;

            if ($request->hasFile('featured_image')) {
                $path = $request->file('featured_image')->store('blog/images', 'public');
                $data['featured_image'] = $path;
            }

            $blog->update($data);

            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog post updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to update blog post. ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully.');
    }

    /**
     * Toggle the published status of the blog post.
     */
    public function toggleStatus(Blog $blog)
    {
        $blog->update([
            'is_published' => !$blog->is_published,
            'published_at' => !$blog->is_published ? now() : null
        ]);

        return response()->json([
            'success' => true,
            'is_published' => $blog->is_published,
            'message' => 'Blog post status updated successfully.'
        ]);
    }
}
