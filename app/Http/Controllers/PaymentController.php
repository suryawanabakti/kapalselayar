<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Notification;
use Midtrans\Config;
use Midtrans\Transaction;

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
        $this->updateStatus($notif);

        return response()->json(['message' => 'Success']);
    }

    public function finish(Request $request)
    {
        $order_id = $request->order_id;

        if ($order_id) {
            try {
                $status = Transaction::status($order_id);
                $this->updateStatus($status);
            } catch (\Exception $e) {
                // Fallback if status check fails
            }
        }

        return view('bookings.finish', [
            'order_id' => $order_id,
            'status' => $request->status ?? $request->transaction_status,
        ]);
    }

    private function updateStatus($notif)
    {
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        $order = Order::where('order_code', $order_id)->first();

        if (!$order) {
            return false;
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
                'midtrans_order_id' => $notif->transaction_id ?? $notif->transaction_id,
                'payment_type' => $type,
                'transaction_status' => $transaction,
                'payload' => json_decode(json_encode($notif), true),
            ]
        );

        return true;
    }
}
