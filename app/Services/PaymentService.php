<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public function __construct(
        private readonly OrderMailService $orderMailService,
        private readonly ActivityLogger $activityLogger,
    ) {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createPaymentIntent(Order $order)
    {
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => (int) ($order->total_amount * 100),
                'currency' => 'usd',
                'metadata' => [
                    'order_id' => $order->id,
                ],
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            return $paymentIntent;
        } catch (ApiErrorException $e) {
            Log::error('Stripe Payment Intent creation failed: ' . $e->getMessage());
            return null;
        }
    }

    public function createCheckoutSession(Order $order): ?Session
    {
        try {
            $lineItems = [];
            foreach ($order->items as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $item->product->title,
                            'description' => $item->product->description,
                        ],
                        'unit_amount' => (int) ($item->price * 100),
                    ],
                    'quantity' => $item->quantity,
                ];
            }

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('landing'),
                'metadata' => [
                    'order_id' => $order->id,
                ],
                'customer_email' => $order->user->email,
            ]);

            return $session;
        } catch (ApiErrorException $e) {
            Log::error('Stripe Checkout Session creation failed: ' . $e->getMessage());
            return null;
        }
    }

    public function handleCheckoutSessionCompleted($sessionId): void
    {
        try {
            $session = Session::retrieve($sessionId);
            $orderId = $session->metadata->order_id ?? null;

            if (!$orderId) {
                Log::warning('Checkout session missing order_id metadata', ['session_id' => $sessionId]);

                return;
            }

            $this->markOrderPaidAndNotify((int) $orderId, $this->resolvePaymentIntentId($session->payment_intent), 'stripe');
        } catch (ApiErrorException $e) {
            Log::error('Error handling checkout session completion: ' . $e->getMessage());
        }
    }

    public function handleSuccessfulPayment($paymentIntentId): bool
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            $orderId = $paymentIntent->metadata->order_id ?? null;

            if (!$orderId) {
                return false;
            }

            return $this->markOrderPaidAndNotify((int) $orderId, $paymentIntentId, $paymentIntent->payment_method_types[0] ?? 'stripe');
        } catch (ApiErrorException $e) {
            Log::error('Failed to handle successful payment: ' . $e->getMessage());
            return false;
        }
    }

    public function handleFailedPayment($paymentIntentId): bool
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            $orderId = $paymentIntent->metadata->order_id ?? null;

            $order = $orderId ? Order::find($orderId) : null;
            if ($order) {
                $order->update([
                    'payment_status' => 'failed',
                    'payment_id' => $paymentIntentId,
                ]);

                $this->activityLogger->log(
                    ActivityLog::LOG_PAYMENT,
                    'failed',
                    "Payment failed for order #{$order->id}",
                    $order,
                    properties: ['payment_id' => $paymentIntentId]
                );
            }

            return true;
        } catch (ApiErrorException $e) {
            Log::error('Failed to handle failed payment: ' . $e->getMessage());
            return false;
        }
    }

    public function processRefund(Order $order)
    {
        try {
            if (!$order->payment_id) {
                throw new \Exception('No payment ID found for this order.');
            }

            $refund = \Stripe\Refund::create([
                'payment_intent' => $order->payment_id,
            ]);

            if ($refund->status === 'succeeded') {
                $order->update(['payment_status' => 'refunded']);

                $this->activityLogger->log(
                    ActivityLog::LOG_PAYMENT,
                    'refunded',
                    "Order #{$order->id} refunded",
                    $order,
                    properties: ['refund_id' => $refund->id]
                );

                return true;
            }

            return false;
        } catch (ApiErrorException $e) {
            Log::error('Stripe Refund failed: ' . $e->getMessage());
            return false;
        }
    }

    private function markOrderPaidAndNotify(int $orderId, ?string $paymentId, string $paymentMethod): bool
    {
        $order = Order::find($orderId);

        if (!$order || $order->payment_status === 'completed') {
            return (bool) $order;
        }

        $order->update([
            'payment_status' => 'completed',
            'payment_id' => $paymentId,
            'payment_method' => $paymentMethod,
            'paid_at' => now(),
        ]);

        Log::info("Order {$orderId} payment completed.");

        $this->activityLogger->log(
            ActivityLog::LOG_PAYMENT,
            'completed',
            "Payment completed for order #{$order->id} (\${$order->total_amount})",
            $order,
            properties: [
                'payment_id' => $paymentId,
                'payment_method' => $paymentMethod,
            ]
        );

        $this->orderMailService->sendOrderCompletedNotifications($order->fresh());

        return true;
    }

    private function resolvePaymentIntentId(mixed $paymentIntent): ?string
    {
        if (is_string($paymentIntent)) {
            return $paymentIntent;
        }

        if (is_object($paymentIntent) && isset($paymentIntent->id)) {
            return $paymentIntent->id;
        }

        return null;
    }
}
