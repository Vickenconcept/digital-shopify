<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function orders(Request $request): StreamedResponse
    {
        $query = Order::with(['user', 'items.product'])->latest();

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $filename = 'orders-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Order ID', 'Date', 'Customer', 'Email', 'Status', 'Payment Method',
                'Items', 'Total', 'Paid At',
            ]);

            $query->chunk(200, function ($orders) use ($handle) {
                foreach ($orders as $order) {
                    fputcsv($handle, [
                        $order->id,
                        $order->created_at?->toDateTimeString(),
                        $order->user?->name,
                        $order->user?->email,
                        $order->payment_status,
                        $order->payment_method,
                        $order->items->pluck('product.title')->filter()->implode('; '),
                        $order->total_amount,
                        $order->paid_at?->toDateTimeString(),
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public function customers(Request $request): StreamedResponse
    {
        $query = User::role('customer')->withCount([
            'orders as completed_orders_count' => fn ($q) => $q->where('payment_status', 'completed'),
        ])->withSum([
            'orders as lifetime_value' => fn ($q) => $q->where('payment_status', 'completed'),
        ], 'total_amount')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
        }

        $filename = 'customers-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'ID', 'Name', 'Email', 'Verified', 'Registered', 'Completed Orders', 'Lifetime Value',
            ]);

            $query->chunk(200, function ($users) use ($handle) {
                foreach ($users as $user) {
                    fputcsv($handle, [
                        $user->id,
                        $user->name,
                        $user->email,
                        $user->email_verified_at ? 'Yes' : 'No',
                        $user->created_at?->toDateTimeString(),
                        $user->completed_orders_count ?? 0,
                        number_format((float) ($user->lifetime_value ?? 0), 2, '.', ''),
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
