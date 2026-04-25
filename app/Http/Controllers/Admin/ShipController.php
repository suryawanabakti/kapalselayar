<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ship;
use Illuminate\Http\Request;

class ShipController extends Controller
{
    public function index()
    {
        $ships = Ship::latest()->paginate(10);
        return view('admin.ships.index', compact('ships'));
    }

    public function create()
    {
        return view('admin.ships.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ships,name',
            'capacity' => 'required|integer|min:1',
        ]);

        Ship::create($request->all());

        return redirect()->route('admin.ships.index')->with('success', 'Kapal berhasil ditambahkan.');
    }

    public function edit(Ship $ship)
    {
        return view('admin.ships.edit', compact('ship'));
    }

    public function update(Request $request, Ship $ship)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ships,name,' . $ship->id,
            'capacity' => 'required|integer|min:1',
        ]);

        $ship->update($request->all());

        return redirect()->route('admin.ships.index')->with('success', 'Kapal berhasil diperbarui.');
    }

    public function destroy(Ship $ship)
    {
        if ($ship->schedules()->exists()) {
            return redirect()->route('admin.ships.index')->with('error', 'Kapal tidak dapat dihapus karena masih digunakan dalam jadwal.');
        }

        $ship->delete();

        return redirect()->route('admin.ships.index')->with('success', 'Kapal berhasil dihapus.');
    }
}
