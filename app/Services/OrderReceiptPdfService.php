<?php

namespace App\Services;

use App\Models\Order;
use App\Support\OrderReceipt;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderReceiptPdfService
{
    public function generate(Order $order): string
    {
        $order->loadMissing('items.product', 'user');
        $receipt = OrderReceipt::forOrder($order);

        return Pdf::loadView('pdf.order-receipt', [
            'order' => $order,
            'receipt' => $receipt,
        ])->setPaper('a4')->output();
    }
}
