<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $orders = Order::with(['schedule.ship', 'passengers', 'payment'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.transactions', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['schedule.ship', 'passengers', 'payment'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('user.transaction-detail', compact('order'));
    }

    public function ticket($ticket_code)
    {
        $passenger = \App\Models\Passenger::with(['order.schedule.ship', 'order.schedule.originPort', 'order.schedule.destinationPort'])
            ->where('ticket_code', $ticket_code)
            ->firstOrFail();

        return view('user.ticket', compact('passenger'));
    }
}
