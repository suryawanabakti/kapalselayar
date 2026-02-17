<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Notification;
use Midtrans\Config;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function notification(Request $request)
    {
        $notif = new Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        $order = Order::where('order_code', $order_id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $order->update(['status' => 'pending']);
                } else {
                    $order->update(['status' => 'paid']);
                }
            }
        } else if ($transaction == 'settlement') {
            $order->update(['status' => 'paid']);
        } else if ($transaction == 'pending') {
            $order->update(['status' => 'pending']);
        } else if ($transaction == 'deny') {
            $order->update(['status' => 'cancel']);
        } else if ($transaction == 'expire') {
            $order->update(['status' => 'cancel']);
        } else if ($transaction == 'cancel') {
            $order->update(['status' => 'cancel']);
        }

        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'midtrans_order_id' => $notif->transaction_id,
                'payment_type' => $type,
                'transaction_status' => $transaction,
                'payload' => json_decode(json_encode($notif), true),
            ]
        );

        return response()->json(['message' => 'Success']);
    }

    public function finish(Request $request)
    {
        return view('bookings.finish', [
            'order_id' => $request->order_id,
            'status' => $request->transaction_status,
        ]);
    }
}
