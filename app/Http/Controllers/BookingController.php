<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Order;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Midtrans\Config;

class BookingController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function index(Request $request)
    {
        $query = Schedule::with(['ship', 'originPort', 'destinationPort'])->where('quota', '>', 0);

        if ($request->filled('origin_port_id')) {
            $query->where('origin_port_id', $request->origin_port_id);
        }

        if ($request->filled('destination_port_id')) {
            $query->where('destination_port_id', $request->destination_port_id);
        }

        if ($request->filled('departure_date')) {
            $query->whereDate('departure_date', $request->departure_date);
        }

        $schedules = $query->orderBy('departure_date', 'asc')->orderBy('departure_time', 'asc')->get();
        $ports = \App\Models\Port::orderBy('name')->get();

        return view('bookings.index', compact('schedules', 'ports'));
    }

    public function show(Schedule $schedule)
    {
        return view('bookings.show', compact('schedule'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'passengers' => 'required|array|min:1',
            'passengers.*.name' => 'required|string',
            'passengers.*.nik' => 'required|string|size:16',
        ]);

        $schedule = Schedule::findOrFail($request->schedule_id);
        $totalTicket = count($request->passengers);
        $totalPrice = $schedule->price * $totalTicket;

        return DB::transaction(function () use ($request, $schedule, $totalTicket, $totalPrice) {
            $order = Order::create([
                'order_code' => 'ORD-' . strtoupper(Str::random(10)),
                'user_id' => auth()->id(),
                'schedule_id' => $schedule->id,
                'total_ticket' => $totalTicket,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            foreach ($request->passengers as $passengerData) {
                $order->passengers()->create($passengerData);
            }

            // Create Midtrans Transaction
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

            // Send notification to admins
            $admins = \App\Models\User::whereIn('role', ['admin', 'super_admin'])->get();
            foreach ($admins as $admin) {
                \Illuminate\Support\Facades\Mail::to($admin->email)->send(new \App\Mail\NewOrderNotification($order));
            }

            return view('bookings.checkout', compact('order', 'snapToken'));
        });
    }
}
