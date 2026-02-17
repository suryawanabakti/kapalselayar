<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'paid_orders' => Order::where('status', 'paid')->count(),
            'total_revenue' => Order::where('status', 'paid')->sum('total_price'),
            'total_users' => User::where('role', 'user')->count(),
        ];

        // Chart data - Last 7 days revenue
        $revenueChart = Order::where('status', 'paid')
            ->where('created_at', '>=', now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as revenue'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Chart data - Last 7 days bookings
        $bookingsChart = Order::where('created_at', '>=', now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $recentOrders = Order::with(['user', 'schedule.ship', 'passengers'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.dashboard', compact('stats', 'recentOrders', 'revenueChart', 'bookingsChart'));
    }

    public function orders(Request $request)
    {
        $query = Order::with(['user', 'schedule.ship', 'passengers', 'payment']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by order code or user name
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('order_code', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function orderDetail($id)
    {
        $order = Order::with(['user', 'schedule.ship', 'passengers', 'payment'])
            ->findOrFail($id);

        return view('admin.orders.detail', compact('order'));
    }

    public function approveOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'paid']);

        // Send notification to user
        \Illuminate\Support\Facades\Mail::to($order->user->email)->send(new \App\Mail\OrderApprovedNotification($order));

        return redirect()->back()->with('success', 'Order berhasil di-approve!');
    }

    public function reports(Request $request)
    {
        $query = Order::with(['user', 'schedule.ship', 'passengers']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        $summary = [
            'total_orders' => $orders->count(),
            'total_revenue' => $orders->where('status', 'paid')->sum('total_price'),
            'total_passengers' => $orders->sum('total_ticket'),
            'pending_orders' => $orders->where('status', 'pending')->count(),
            'paid_orders' => $orders->where('status', 'paid')->count(),
        ];

        return view('admin.reports', compact('orders', 'summary'));
    }
}
