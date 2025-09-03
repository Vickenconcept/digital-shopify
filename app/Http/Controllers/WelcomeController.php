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

        // Get site settings or create default
        $siteSettings = SiteSetting::first();
        if (!$siteSettings) {
            $siteSettings = new SiteSetting();
        }

        // Get weekly theme
        $weeklyTheme = [
            'title' => $siteSettings->weekly_theme_title ?? 'Your Journey Voices – Stories That Travel With You',
            'description' => $siteSettings->weekly_theme_description ?? 'Discover inspiring Christian audiobooks, children\'s bedtime stories, and motivational content perfect for commuters. Your Journey Voices brings you stories that inspire, educate, and travel with you wherever life takes you.',
        ];

        return view('home', compact('featuredProducts', 'latestAudios', 'categories', 'siteSettings', 'weeklyTheme'));
    }
}
