<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $featuredPosts = Blog::where('is_featured', true)
            ->where('is_published', true)
            ->latest('published_at')
            ->take(3)
            ->get();

        $latestPosts = Blog::where('is_published', true)
            ->latest('published_at')
            ->paginate(9);

        return view('blog.index', compact('featuredPosts', 'latestPosts'));
    }

    public function show(Blog $blog)
    {
        if (!$blog->is_published) {
            abort(404);
        }

        $relatedPosts = Blog::where('is_published', true)
            ->where('id', '!=', $blog->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('blog.show', compact('blog', 'relatedPosts'));
    }

    public function archive(Request $request)
    {
        $query = Blog::where('is_published', true)->latest('published_at');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(12)->withQueryString();

        return view('blog.archive', compact('posts'));
    }
}
