<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderReceiptPdfService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderReceiptController extends Controller
{
    public function __construct(
        private readonly OrderReceiptPdfService $pdfService,
    ) {}

    public function download(Order $order): Response
    {
        $user = Auth::user();

        if ($user->hasAnyRole(['admin', 'super-admin'])) {
            // admins can download any receipt
        } elseif ($order->user_id !== $user->id || $order->payment_status !== 'completed') {
            abort(403);
        }

        $pdf = $this->pdfService->generate($order);

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="receipt-order-' . $order->id . '.pdf"',
        ]);
    }
}
