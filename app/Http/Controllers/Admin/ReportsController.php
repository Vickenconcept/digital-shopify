<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalProduct;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportsController extends Controller
{
    public function index(Request $request): View
    {
        $period = $request->get('period', '30');
        $from = match ($period) {
            '7' => Carbon::now()->subDays(7),
            '90' => Carbon::now()->subDays(90),
            '365' => Carbon::now()->subYear(),
            default => Carbon::now()->subDays(30),
        };

        $completedOrders = Order::where('payment_status', 'completed')
            ->where('created_at', '>=', $from);

        $stats = [
            'revenue' => (clone $completedOrders)->sum('total_amount'),
            'orders' => (clone $completedOrders)->count(),
            'avg_order' => (clone $completedOrders)->avg('total_amount') ?? 0,
            'failed' => Order::where('payment_status', 'failed')->where('created_at', '>=', $from)->count(),
            'refunded' => Order::where('payment_status', 'refunded')->where('created_at', '>=', $from)->count(),
            'pending' => Order::where('payment_status', 'pending')->where('created_at', '>=', $from)->count(),
        ];

        $totalAttempts = $stats['orders'] + $stats['failed'] + $stats['refunded'];
        $stats['failure_rate'] = $totalAttempts > 0 ? round(($stats['failed'] / $totalAttempts) * 100, 1) : 0;
        $stats['refund_rate'] = $stats['orders'] > 0 ? round(($stats['refunded'] / max(1, $stats['orders'] + $stats['refunded'])) * 100, 1) : 0;

        $topProducts = DigitalProduct::query()
            ->select('digital_products.id', 'digital_products.title')
            ->selectRaw('COUNT(order_items.id) as sales_count')
            ->selectRaw('COALESCE(SUM(order_items.price * order_items.quantity), 0) as revenue')
            ->join('order_items', 'order_items.digital_product_id', '=', 'digital_products.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.payment_status', 'completed')
            ->where('orders.created_at', '>=', $from)
            ->groupBy('digital_products.id', 'digital_products.title')
            ->orderByDesc('sales_count')
            ->limit(10)
            ->get();

        $revenueByMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $revenueByMonth[] = [
                'label' => $month->format('M Y'),
                'revenue' => Order::where('payment_status', 'completed')
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('total_amount'),
            ];
        }

        return view('admin.reports.index', compact('stats', 'topProducts', 'revenueByMonth', 'period', 'from'));
    }
}
