<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Ship;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with('ship')->where('quota', '>', 0);

        // Filter by ship
        if ($request->filled('ship_id')) {
            $query->where('ship_id', $request->ship_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('departure_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('departure_date', '<=', $request->date_to);
        }

        // Filter by price range
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        $schedules = $query->orderBy('departure_date', 'asc')
            ->orderBy('departure_time', 'asc')
            ->paginate(12);

        $ships = Ship::all();

        return view('schedules.index', compact('schedules', 'ships'));
    }
}
