<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DigitalProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = DigitalProduct::where('is_active', true);

        // Search functionality
        if ($request->has('search') && !empty($request->get('search'))) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Filter by categories (multiple)
        if ($request->has('category')) {
            $categories = (array)$request->get('category');
            $query->whereHas('category', function ($q) use ($categories) {
                $q->whereIn('slug', $categories);
            });
        }

        // Filter by type
        if ($request->has('type')) {
            $query->where('file_type', $request->type);
        }

        // Sort products
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(DigitalProduct $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        $relatedProducts = DigitalProduct::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $limit = $request->get('limit', 10);

        if (empty($query)) {
            // Return featured products when no search query
            $products = DigitalProduct::where('is_active', true)
                ->where('is_featured', true)
                ->with('category')
                ->take($limit)
                ->get();
        } else {
            // Search in title, description, and author
            $products = DigitalProduct::where('is_active', true)
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%")
                      ->orWhere('author', 'like', "%{$query}%");
                })
                ->with('category')
                ->take($limit)
                ->get();
        }

        return response()->json([
            'products' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'author' => $product->author,
                    'price' => $product->price,
                    'thumbnail' => $product->thumbnail_path ? (str_starts_with($product->thumbnail_path, 'http') ? $product->thumbnail_path : (str_starts_with($product->thumbnail_path, 'storage/') ? asset($product->thumbnail_path) : asset('storage/' . $product->thumbnail_path))) : 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="%23e5e7eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21,15 16,10 5,21"></polyline></svg>'),
                    'slug' => $product->slug,
                    'category' => $product->category ? $product->category->name : null,
                    'is_free' => $product->is_free,
                ];
            })
        ]);
    }
}