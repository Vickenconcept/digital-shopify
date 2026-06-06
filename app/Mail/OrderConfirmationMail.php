<?php

namespace App\Mail;

use App\Models\Order;
use App\Services\OrderReceiptPdfService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(public Order $order) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your receipt & order confirmation #' . $this->order->id . ' — ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        $this->order->loadMissing('items.product', 'user');

        return new Content(
            view: 'emails.order-confirmation',
            with: [
                'order' => $this->order,
                'receipt' => \App\Support\OrderReceipt::forOrder($this->order),
            ],
        );
    }

    public function attachments(): array
    {
        $pdf = app(OrderReceiptPdfService::class)->generate($this->order);

        return [
            Attachment::fromData(fn () => $pdf, 'receipt-order-' . $this->order->id . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}

