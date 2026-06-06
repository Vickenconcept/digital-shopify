<?php

namespace App\Services;

use App\Mail\NewOrderAdminMail;
use App\Mail\OrderConfirmationMail;
use App\Models\ActivityLog;
use App\Models\Order;
use App\Support\AdminNotifications;
use App\Support\MailRecipients;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderMailService
{
    public function __construct(
        private readonly ActivityLogger $activityLogger,
    ) {}

    public function sendOrderCompletedNotifications(Order $order): void
    {
        $order->loadMissing('items.product', 'user');

        if (!$order->user?->email) {
            Log::warning('Order confirmation skipped: missing customer email', ['order_id' => $order->id]);

            return;
        }

        try {
            Mail::to($order->user->email)->send(new OrderConfirmationMail($order));
            $this->activityLogger->log(
                ActivityLog::LOG_EMAIL,
                'sent',
                "Order receipt email queued for order #{$order->id}",
                $order,
                properties: ['recipient' => $order->user->email, 'template' => 'order_confirmation']
            );
        } catch (\Throwable $e) {
            Log::error('Customer order confirmation email failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
            $this->activityLogger->log(
                ActivityLog::LOG_EMAIL,
                'failed',
                "Order confirmation email failed for order #{$order->id}",
                $order,
                properties: ['error' => $e->getMessage()]
            );
        }

        if (!AdminNotifications::isEnabled('new_order')) {
            return;
        }

        try {
            Mail::to(MailRecipients::admin())->send(new NewOrderAdminMail($order));
            $this->activityLogger->log(
                ActivityLog::LOG_EMAIL,
                'sent',
                "Admin notified of new order #{$order->id}",
                $order,
                properties: ['template' => 'new_order_admin']
            );
        } catch (\Throwable $e) {
            Log::error('Admin new order email failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
            $this->activityLogger->log(
                ActivityLog::LOG_EMAIL,
                'failed',
                "Admin new-order email failed for order #{$order->id}",
                $order,
                properties: ['error' => $e->getMessage()]
            );
        }
    }
}
