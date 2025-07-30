<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\DigitalProduct;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\Webhook;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    private PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Create a payment intent for an order.
     *
     * @param Order $order
     * @return JsonResponse
     */
    public function checkout(Request $request): JsonResponse
    {
        try {
            // Validate cart data
            $cartItems = $request->input('cart');
            if (empty($cartItems)) {
                return response()->json(['error' => 'Cart is empty'], Response::HTTP_BAD_REQUEST);
            }

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => collect($cartItems)->sum(function($item) {
                    return $item['price'] * $item['quantity'];
                }),
                'payment_status' => 'pending',
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                $product = DigitalProduct::findOrFail($item['id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'digital_product_id' => $product->id,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                ]);
            }

            // Create Stripe Checkout session
            $checkoutSession = $this->paymentService->createCheckoutSession($order);

            if (!$checkoutSession) {
                throw new \Exception('Failed to create checkout session');
            }

            return response()->json([
                'checkoutUrl' => $checkoutSession->url,
                'orderId' => $order->id,
            ]);
        } catch (\Exception $e) {
            \Log::error('Checkout error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function createPaymentIntent(Order $order): JsonResponse
    {
        try {
            $paymentIntent = $this->paymentService->createPaymentIntent($order);
            return response()->json($paymentIntent);
        } catch (ApiErrorException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Handle Stripe webhook events.
     *
     * @param Request $request
     * @return Response
     */
    public function handleCheckoutSuccess(Request $request)
    {
        try {
            $sessionId = $request->query('session_id');
            if (!$sessionId) {
                return redirect()->route('home')->with('error', 'Invalid checkout session');
            }

            $this->paymentService->handleCheckoutSessionCompleted($sessionId);
            
            // Clear cart from local storage via JavaScript
            return view('payment.success')->with('success', 'Payment completed successfully!');
        } catch (\Exception $e) {
            Log::error('Checkout success handling error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Payment processing failed');
        }
    }

    public function handleWebhook(Request $request): Response
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                config('services.stripe.webhook_secret')
            );

            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $this->paymentService->handleSuccessfulPayment($event->data->object->id);
                    break;
                case 'payment_intent.payment_failed':
                    $this->paymentService->handleFailedPayment($event->data->object->id);
                    break;
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Process a refund for an order.
     *
     * @param Order $order
     * @return JsonResponse
     */
    public function refund(Order $order): JsonResponse
    {
        try {
            $success = $this->paymentService->processRefund($order);
            if ($success) {
                return response()->json(['status' => 'success']);
            }
            return response()->json(['error' => 'Unable to process refund'], Response::HTTP_BAD_REQUEST);
        } catch (ApiErrorException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}