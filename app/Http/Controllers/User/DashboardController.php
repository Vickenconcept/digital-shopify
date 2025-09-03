<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = $user->orders()
            ->where('payment_status', 'completed')
            ->with('items.product.category');

        // Get all purchased products with search and filter functionality
        $purchasedProducts = $query->latest()
            ->get()
            ->pluck('items')
            ->flatten()
            ->pluck('product')
            ->unique('id');

        // Apply search filter
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $purchasedProducts = $purchasedProducts->filter(function ($product) use ($searchTerm) {
                return stripos($product->title, $searchTerm) !== false ||
                       stripos($product->description, $searchTerm) !== false;
            });
        }

        // Apply type filter
        if ($request->has('type') && $request->type) {
            $purchasedProducts = $purchasedProducts->where('file_type', $request->type);
        }

        // Apply category filter
        if ($request->has('category') && $request->category) {
            $purchasedProducts = $purchasedProducts->where('category_id', $request->category);
        }

        // Get available filter options
        $allPurchasedProducts = $user->orders()
            ->where('payment_status', 'completed')
            ->with('items.product.category')
            ->latest()
            ->get()
            ->pluck('items')
            ->flatten()
            ->pluck('product')
            ->unique('id');

        $availableTypes = $allPurchasedProducts->pluck('file_type')->unique()->values();
        $availableCategories = $allPurchasedProducts->pluck('category')->unique('id')->values();

        return view('user.dashboard', compact('purchasedProducts', 'availableTypes', 'availableCategories'));
    }

    public function orders(Request $request)
    {
        $query = Auth::user()->orders()->with(['items.product']);

        // Apply search filter
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('id', 'like', "%{$searchTerm}%")
                  ->orWhereHas('items.product', function ($productQuery) use ($searchTerm) {
                      $productQuery->where('title', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Apply status filter
        if ($request->has('status') && $request->status) {
            $query->where('payment_status', $request->status);
        }

        // Apply date range filter
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        // Get available filter options
        $availableStatuses = Auth::user()->orders()->distinct()->pluck('payment_status');

        return view('user.orders', compact('orders', 'availableStatuses'));
    }

    public function download(Request $request, $productId)
    {
        $user = Auth::user();
        $hasPurchased = $user->orders()
            ->where('payment_status', 'completed')
            ->whereHas('items', function ($query) use ($productId) {
                $query->where('digital_product_id', $productId);
            })
            ->exists();

        if (!$hasPurchased) {
            abort(403, 'You have not purchased this product.');
        }

        $product = \App\Models\DigitalProduct::findOrFail($productId);
        
        // Check if file path exists (Cloudinary URL)
        if (!$product->file_path) {
            abort(404, 'File not found.');
        }

        // Redirect to Cloudinary URL for download
        return redirect($product->file_path);
    }

    public function stream(Request $request, $productId)
    {
        $user = Auth::user();
        $hasPurchased = $user->orders()
            ->where('payment_status', 'completed')
            ->whereHas('items', function ($query) use ($productId) {
                $query->where('digital_product_id', $productId);
            })
            ->exists();

        if (!$hasPurchased) {
            abort(403, 'You have not purchased this product.');
        }

        $product = \App\Models\DigitalProduct::findOrFail($productId);
        
        // Check if file path exists (Cloudinary URL)
        if (!$product->file_path) {
            abort(404, 'File not found.');
        }

        // Redirect to Cloudinary URL for streaming
        return redirect($product->file_path);
    }
}