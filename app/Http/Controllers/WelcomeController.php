<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DigitalProduct;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Get featured products
        $featuredProducts = DigitalProduct::where('is_featured', true)
            ->where('is_active', true)
            ->latest('published_at')
            ->take(6)
            ->get();

        // Get latest audio messages
        $latestAudios = DigitalProduct::where('file_type', 'audio')
            ->where('is_active', true)
            ->latest('published_at')
            ->take(4)
            ->get();

        // Get categories with their products
        $categories = Category::where('is_active', true)
            ->withCount('digitalProducts')
            ->get();

        return view('home', compact('featuredProducts', 'latestAudios', 'categories'));
    }
}
