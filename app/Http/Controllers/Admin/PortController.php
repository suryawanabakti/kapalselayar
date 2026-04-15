<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Port;
use Illuminate\Http\Request;

class PortController extends Controller
{
    public function index()
    {
        $ports = Port::latest()->paginate(10);
        return view('admin.ports.index', compact('ports'));
    }

    public function create()
    {
        return view('admin.ports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ports,name',
        ]);

        Port::create($request->all());

        return redirect()->route('admin.ports.index')->with('success', 'Pelabuhan berhasil ditambahkan.');
    }

    public function edit(Port $port)
    {
        return view('admin.ports.edit', compact('port'));
    }

    public function update(Request $request, Port $port)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ports,name,' . $port->id,
        ]);

        $port->update($request->all());

        return redirect()->route('admin.ports.index')->with('success', 'Pelabuhan berhasil diperbarui.');
    }

    public function destroy(Port $port)
    {
        // Optional: Check if port is used in any schedules
        if ($port->schedulesAsOrigin()->exists() || $port->schedulesAsDestination()->exists()) {
            return redirect()->route('admin.ports.index')->with('error', 'Pelabuhan tidak dapat dihapus karena masih digunakan dalam jadwal.');
        }

        $port->delete();

        return redirect()->route('admin.ports.index')->with('success', 'Pelabuhan berhasil dihapus.');
    }
}
