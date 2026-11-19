<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderPaySuccessNotification;
use Illuminate\Http\Request;

class StripeWebhookController extends Controller
{
    //
    public function handleWebhook(Request $request)
    {
        $signature = $request->header('Stripe-Signature');
        $payload = $request->getContent();

        try {
            // Verify the webhook signature
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $signature,
                config('services.stripe.webhook_secret')
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $orderId = $session->metadata->order_id ?? null;

                if ($orderId) {
                    $order = Order::with('details.product')->find($orderId);
                    if ($order && $order->status !== 'pagado') {
                        $order->update([
                            'status' => 'pagado',
                            'paid_at' => now(),
                        ]);

                        foreach ($order->details as $detail) {
                            if ($detail->product) {
                                $detail->product->decrement('stock', $detail->quantity);
                            }
                        }
                    }

                    $user = $order->customer->user;
                    $user->notify(new OrderPaySuccessNotification($order));
                }
                break;

            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                $session = \Stripe\Checkout\Session::retrieve($paymentIntent->id);
                $orderId = $session->metadata->order_id ?? null;

                if ($orderId) {
                    $order = Order::with('details.product')->find($orderId);
                    if ($order && $order->status !== 'pagado') {
                        $order->update([
                            'status' => 'fallido',
                            'paid_at' => now(),
                        ]);
                    }
                }
                break;

            default:
                break;
        }

        return response()->json(['message' => 'Webhook received successfully'], 200);
    }
}
