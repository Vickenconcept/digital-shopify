<?php

namespace App\Support;

use App\Models\Order;
use App\Models\SiteSetting;

class OrderReceipt
{
    public static function forOrder(Order $order): array
    {
        $order->loadMissing('items.product', 'user');

        $subtotal = (float) $order->items->sum(fn ($item) => (float) $item->price * (int) $item->quantity);
        $total = (float) $order->total_amount;
        $taxRate = (float) (SiteSetting::first()?->tax_rate ?? config('shop.tax_rate', 0));
        $taxAmount = round($subtotal * ($taxRate / 100), 2);

        if (abs(($subtotal + $taxAmount) - $total) > 0.01) {
            $taxAmount = max(0, round($total - $subtotal, 2));
        }

        return [
            'subtotal' => $subtotal,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'total' => $total,
        ];
    }
}
