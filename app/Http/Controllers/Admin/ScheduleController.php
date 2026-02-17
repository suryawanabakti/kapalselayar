<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Ship;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with('ship');

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

        // Filter by status (quota)
        if ($request->filled('status')) {
            if ($request->status === 'available') {
                $query->where('quota', '>', 0);
            } elseif ($request->status === 'full') {
                $query->where('quota', '=', 0);
            }
        }

        $schedules = $query->orderBy('departure_date', 'asc')
            ->orderBy('departure_time', 'asc')
            ->paginate(15);

        $ships = Ship::all();

        return view('admin.schedules.index', compact('schedules', 'ships'));
    }

    public function create()
    {
        $ships = Ship::all();
        return view('admin.schedules.create', compact('ships'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ship_id' => 'required|exists:ships,id',
            'departure_date' => 'required|date',
            'departure_time' => 'required',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:0',
        ]);

        Schedule::create($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit(Schedule $schedule)
    {
        $ships = Ship::all();
        return view('admin.schedules.edit', compact('schedule', 'ships'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'ship_id' => 'required|exists:ships,id',
            'departure_date' => 'required|date',
            'departure_time' => 'required',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:0',
        ]);

        $schedule->update($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus!');
    }
}
