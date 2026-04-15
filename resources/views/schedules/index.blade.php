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

            <!-- Schedules Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($schedules as $schedule)
                    <div
                        class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                        <!-- Ship Header -->
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-2xl font-bold mb-1">{{ $schedule->ship->name }}</h3>
                                    <p class="text-blue-100 text-sm font-semibold mb-1">
                                        ⛴️ {{ optional($schedule->originPort)->name }} ➔ {{ optional($schedule->destinationPort)->name }}
                                    </p>
                                    <p class="text-blue-100 text-sm">Kapasitas: {{ $schedule->ship->capacity }} orang
                                    </p>
                                </div>
                                <div class="bg-white bg-opacity-20 backdrop-blur-sm px-3 py-1 rounded-full">
                                    <span class="text-sm font-bold">{{ $schedule->quota }} Tersedia</span>
                                </div>
                            </div>
                        </div>

                        <!-- Schedule Details -->
                        <div class="p-6 space-y-4">
                            <div class="flex items-center text-gray-700">
                                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Tanggal Keberangkatan</p>
                                    <p class="font-semibold">
                                        {{ \Carbon\Carbon::parse($schedule->departure_date)->format('d M Y') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center text-gray-700">
                                <div class="bg-green-100 p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Waktu Keberangkatan</p>
                                    <p class="font-semibold">
                                        {{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }} WITA</p>
                                </div>
                            </div>

                            <div class="border-t pt-4 mt-4">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-gray-600">Harga per tiket</span>
                                    <span class="text-3xl font-bold text-blue-600">Rp
                                        {{ number_format($schedule->price, 0, ',', '.') }}</span>
                                </div>

                                <a href="{{ route('bookings.show', $schedule) }}"
                                    class="block w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-center font-bold py-3 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300">
                                    🎫 Pesan Tiket Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl border-2 border-dashed border-gray-300 p-12 text-center">
                            <div class="text-6xl mb-4">🚢</div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak Ada Jadwal Ditemukan</h3>
                            <p class="text-gray-600 mb-4">Coba ubah filter pencarian Anda</p>
                            <a href="{{ route('schedules.index') }}"
                                class="inline-block text-blue-600 hover:text-blue-800 font-medium">
                                Reset Filter →
                            </a>
                        </div>
                    </div>
                @endforelse
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
