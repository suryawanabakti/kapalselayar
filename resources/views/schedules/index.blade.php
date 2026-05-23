<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Keberangkatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">🔍 Filter Jadwal</h3>
                <form method="GET" action="{{ route('schedules.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kapal</label>
                            <select name="ship_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Kapal</option>
                                @foreach ($ships as $ship)
                                    <option value="{{ $ship->id }}"
                                        {{ request('ship_id') == $ship->id ? 'selected' : '' }}>
                                        {{ $ship->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pelabuhan Asal</label>
                            <select name="origin_port_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Asal</option>
                                @foreach($ports ?? [] as $port)
                                    <option value="{{ $port->id }}" {{ request('origin_port_id') == $port->id ? 'selected' : '' }}>{{ $port->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pelabuhan Tujuan</label>
                            <select name="destination_port_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Tujuan</option>
                                @foreach($ports ?? [] as $port)
                                    <option value="{{ $port->id }}" {{ request('destination_port_id') == $port->id ? 'selected' : '' }}>{{ $port->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Harga Maksimal</label>
                            <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Rp"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="mt-4 flex gap-2">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition shadow-lg">
                            Terapkan Filter
                        </button>
                        <a href="{{ route('schedules.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg transition">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Schedules Table -->
            <div class="bg-white rounded-2xl shadow p-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kapal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rute</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Kapasitas</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($schedules as $schedule)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ $schedule->ship->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ optional($schedule->originPort)->name }} → {{ optional($schedule->destinationPort)->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ \Carbon\Carbon::parse($schedule->departure_date)->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }} WITA</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-right text-blue-600">Rp {{ number_format($schedule->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">{{ $schedule->quota }} / {{ $schedule->ship->capacity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <a href="{{ route('bookings.show', $schedule) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded-md shadow-sm">🎫 Pesan</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">Tidak Ada Jadwal Ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($schedules->hasPages())
                <div class="mt-8">
                    {{ $schedules->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
