<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalProduct;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic Statistics
        $totalProducts = DigitalProduct::count();
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $totalCategories = Category::count();
        $totalRevenue = Order::where('payment_status', 'completed')->sum('total_amount');
        
        // Recent statistics (last 30 days)
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        $recentOrders = Order::where('created_at', '>=', $thirtyDaysAgo)->count();
        $recentRevenue = Order::where('payment_status', 'completed')
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->sum('total_amount');
        $recentUsers = User::where('created_at', '>=', $thirtyDaysAgo)->count();

        // Product statistics by type
        $audioProducts = DigitalProduct::where('file_type', 'audio')->count();
        $videoProducts = DigitalProduct::where('file_type', 'video')->count();
        $ebookProducts = DigitalProduct::where('file_type', 'ebook')->count();

        // Recent orders with relationships
        $recentOrdersList = Order::with(['user', 'items.product'])
            ->latest()
            ->take(10)
            ->get();

        // Top selling products
        $topProducts = DigitalProduct::withCount(['orderItems as total_sales' => function($query) {
                $query->whereHas('order', function($orderQuery) {
                    $orderQuery->where('payment_status', 'completed');
                });
            }])
            ->with('category')
            ->orderBy('total_sales', 'desc')
            ->take(5)
            ->get();

        // Monthly revenue chart data (last 12 months)
        $monthlyRevenue = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $revenue = Order::where('payment_status', 'completed')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_amount');
            
            $monthlyRevenue[] = [
                'month' => $date->format('M Y'),
                'revenue' => $revenue
            ];
        }

        // Order status breakdown
        $orderStatuses = Order::selectRaw('payment_status, count(*) as count')
            ->groupBy('payment_status')
            ->get()
            ->pluck('count', 'payment_status')
            ->toArray();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalUsers',
            'totalCategories',
            'totalRevenue',
            'recentOrders',
            'recentRevenue',
            'recentUsers',
            'audioProducts',
            'videoProducts',
            'ebookProducts',
            'recentOrdersList',
            'topProducts',
            'monthlyRevenue',
            'orderStatuses'
        ));
    }
}