<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DigitalProduct;
use Illuminate\Http\Request;

class SeoCategoryController extends Controller
{
    public function christianAudiobooks()
    {
        $products = DigitalProduct::whereHas('category', function($query) {
            $query->where('name', 'like', '%christian%')
                  ->orWhere('name', 'like', '%faith%')
                  ->orWhere('name', 'like', '%bible%')
                  ->orWhere('name', 'like', '%spiritual%');
        })
        ->where('is_active', true)
        ->where('file_type', 'audio')
        ->latest('published_at')
        ->paginate(12);

        $featuredProducts = DigitalProduct::whereHas('category', function($query) {
            $query->where('name', 'like', '%christian%')
                  ->orWhere('name', 'like', '%faith%')
                  ->orWhere('name', 'like', '%bible%')
                  ->orWhere('name', 'like', '%spiritual%');
        })
        ->where('is_active', true)
        ->where('is_featured', true)
        ->where('file_type', 'audio')
        ->take(4)
        ->get();

        return view('seo.christian-audiobooks', compact('products', 'featuredProducts'));
    }

    public function childrenStories()
    {
        $products = DigitalProduct::whereHas('category', function($query) {
            $query->where('name', 'like', '%children%')
                  ->orWhere('name', 'like', '%kids%')
                  ->orWhere('name', 'like', '%family%')
                  ->orWhere('name', 'like', '%bedtime%');
        })
        ->where('is_active', true)
        ->latest('published_at')
        ->paginate(12);

        $featuredProducts = DigitalProduct::whereHas('category', function($query) {
            $query->where('name', 'like', '%children%')
                  ->orWhere('name', 'like', '%kids%')
                  ->orWhere('name', 'like', '%family%')
                  ->orWhere('name', 'like', '%bedtime%');
        })
        ->where('is_active', true)
        ->where('is_featured', true)
        ->take(4)
        ->get();

        return view('seo.children-stories', compact('products', 'featuredProducts'));
    }

    public function commuterAudiobooks()
    {
        $products = DigitalProduct::where('is_active', true)
            ->where('file_type', 'audio')
            ->latest('published_at')
            ->paginate(12);

        $featuredProducts = DigitalProduct::where('is_active', true)
            ->where('is_featured', true)
            ->where('file_type', 'audio')
            ->take(4)
            ->get();

        return view('seo.commuter-audiobooks', compact('products', 'featuredProducts'));
    }

    public function inspirationHealth()
    {
        $products = DigitalProduct::whereHas('category', function($query) {
            $query->where('name', 'like', '%inspiration%')
                  ->orWhere('name', 'like', '%motivation%')
                  ->orWhere('name', 'like', '%health%')
                  ->orWhere('name', 'like', '%wellness%')
                  ->orWhere('name', 'like', '%self-improvement%');
        })
        ->where('is_active', true)
        ->latest('published_at')
        ->paginate(12);

        $featuredProducts = DigitalProduct::whereHas('category', function($query) {
            $query->where('name', 'like', '%inspiration%')
                  ->orWhere('name', 'like', '%motivation%')
                  ->orWhere('name', 'like', '%health%')
                  ->orWhere('name', 'like', '%wellness%')
                  ->orWhere('name', 'like', '%self-improvement%');
        })
        ->where('is_active', true)
        ->where('is_featured', true)
        ->take(4)
        ->get();

        return view('seo.inspiration-health', compact('products', 'featuredProducts'));
    }
}
