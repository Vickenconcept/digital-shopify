<?php

namespace App\Services;

use App\Models\Order;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createPaymentIntent(Order $order)
    {
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => (int) ($order->total_amount * 100), // Convert to cents
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
            // Prepare line items for Stripe Checkout
            $lineItems = [];
            foreach ($order->items as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $item->product->title,
                            'description' => $item->product->description,
                        ],
                        'unit_amount' => (int) ($item->price * 100), // Convert to cents
                    ],
                    'quantity' => $item->quantity,
                ];
            }

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('home'),
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

    public function handleCheckoutSessionCompleted($sessionId)
    {
        try {
            $session = Session::retrieve($sessionId);
            $orderId = $session->metadata->order_id;

            $order = Order::find($orderId);
            if ($order && $order->payment_status !== 'completed') {
                $order->update([
                    'payment_status' => 'completed',
                    'payment_id' => $session->payment_intent,
                    'payment_method' => 'stripe',
                    'paid_at' => now(),
                ]);
                Log::info("Order {$orderId} payment completed via Checkout Session.");
            }
        } catch (ApiErrorException $e) {
            Log::error('Error handling checkout session completion: ' . $e->getMessage());
        }
    }

    public function handleSuccessfulPayment($paymentIntentId)
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            $orderId = $paymentIntent->metadata->order_id;

            $order = Order::find($orderId);
            if ($order && $order->payment_status !== 'completed') {
                $order->update([
                    'payment_status' => 'completed',
                    'payment_id' => $paymentIntentId,
                    'paid_at' => now(),
                ]);
            }

            return true;
        } catch (ApiErrorException $e) {
            Log::error('Failed to handle successful payment: ' . $e->getMessage());
            return false;
        }
    }

    public function handleFailedPayment($paymentIntentId)
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            $orderId = $paymentIntent->metadata->order_id;

            $order = Order::find($orderId);
            if ($order) {
                $order->update([
                    'payment_status' => 'failed',
                    'payment_id' => $paymentIntentId,
                ]);
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
                return true;
            }

            return false;
        } catch (ApiErrorException $e) {
            Log::error('Stripe Refund failed: ' . $e->getMessage());
            return false;
        }
    }
}