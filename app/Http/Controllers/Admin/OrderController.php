<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        // Apply search filter
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('id', 'like', "%{$searchTerm}%")
                  ->orWhere('payment_id', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', "%{$searchTerm}%")
                               ->orWhere('email', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('items.product', function($productQuery) use ($searchTerm) {
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

        // Apply amount range filter
        if ($request->has('amount_from') && $request->amount_from) {
            $query->where('total_amount', '>=', $request->amount_from);
        }

        if ($request->has('amount_to') && $request->amount_to) {
            $query->where('total_amount', '<=', $request->amount_to);
        }

        // Apply sorting
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'oldest':
                $query->oldest();
                break;
            case 'amount_high':
                $query->orderBy('total_amount', 'desc');
                break;
            case 'amount_low':
                $query->orderBy('total_amount');
                break;
            case 'customer':
                $query->join('users', 'orders.user_id', '=', 'users.id')
                      ->orderBy('users.name')
                      ->select('orders.*');
                break;
            default:
                $query->latest();
                break;
        }

        $orders = $query->paginate(15)->withQueryString();

        // Get filter options
        $availableStatuses = Order::distinct()->pluck('payment_status');

        return view('admin.orders.index', compact('orders', 'availableStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }
}
