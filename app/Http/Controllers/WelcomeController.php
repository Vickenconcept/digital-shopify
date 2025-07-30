<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DigitalProduct;
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

        // Get weekly theme
        $weeklyTheme = [
            'title' => 'Living That Spiritual Life – Awakening Your Spirit',
            'description' => 'Welcome to a space where transformation happens! Each week, we dive into topics that inspire spiritual awakening, deepen Kingdom relationships, and guide you on your journey toward spiritual growth. Ready to live with purpose? Start here.',
        ];

        return view('home', compact('featuredProducts', 'latestAudios', 'categories', 'weeklyTheme'));
    }
}
