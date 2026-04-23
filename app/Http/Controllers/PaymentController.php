<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Notification;
use Midtrans\Config;
use Midtrans\Transaction;
use Midtrans\Snap;

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

    public function pay(Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'pending') {
            abort(403);
        }

        try {
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_code,
                    'gross_amount' => $order->total_price,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name ?? 'Guest',
                    'email' => auth()->user()->email ?? 'guest@example.com',
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            return view('bookings.checkout', compact('order', 'snapToken'));
        } catch (\Exception $e) {
            $message = $e->getMessage();
            if (str_contains($message, 'order_id sudah digunakan') || str_contains($message, 'order_id already used')) {
                return redirect()->route('user.transactions')->with('error', 'Pembayaran tidak dapat dilanjutkan karena kode order ini sudah pernah digunakan di Midtrans. Silakan lakukan pemesanan tiket ulang (beli tiket baru).');
            }

            return redirect()->route('user.transactions')->with('error', 'Terjadi kesalahan saat menghubungi Midtrans: ' . $message);
        }
    }

    private function updateStatus($notif)
    {
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        $order = Order::with(['user', 'schedule.ship', 'schedule.originPort', 'schedule.destinationPort', 'passengers'])->where('order_code', $order_id)->first();

        if (!$order) {
            return false;
        }

        $oldStatus = $order->status;

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

        // Send email if status changed to paid
        if ($oldStatus !== 'paid' && $order->status === 'paid') {
            try {
                \Illuminate\Support\Facades\Mail::to($order->user->email)->send(new \App\Mail\OrderApprovedNotification($order));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send order approval email: ' . $e->getMessage());
            }
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
