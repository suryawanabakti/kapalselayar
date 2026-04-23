<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Transaksi #{{ $order->order_code }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.orders.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg transition text-sm">
                    Kembali
                </a>
                @if ($order->status === 'pending')
                    <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Approve order ini?')">
                        @csrf
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition text-sm">
                            Approve Pembayaran
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Order Info -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Informasi Pesanan
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Status</p>
                                @if ($order->status === 'paid')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                                @elseif($order->status === 'pending')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Failed</span>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Total Pembayaran</p>
                                <p class="font-bold text-blue-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Tanggal Pesan</p>
                                <p class="font-semibold text-gray-900">{{ $order->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Passenger List -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Daftar Penumpang & Validasi Tiket
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama / NIK</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Tiket</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Validasi</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu Validasi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($order->passengers as $passenger)
                                        <tr>
                                            <td class="px-4 py-4">
                                                <div class="text-sm font-bold text-gray-900">{{ $passenger->name }}</div>
                                                <div class="text-xs text-gray-500">NIK: {{ $passenger->nik }}</div>
                                            </td>
                                            <td class="px-4 py-4">
                                                <span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded">{{ $passenger->ticket_code }}</span>
                                            </td>
                                            <td class="px-4 py-4">
                                                @if($passenger->is_validated)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Validated</span>
                                                @else
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Not Validated</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 text-sm text-gray-500">
                                                {{ $passenger->validated_at ? $passenger->validated_at->format('d M Y H:i') : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- Customer Info -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Customer</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Nama</p>
                                <p class="font-semibold">{{ $order->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Email</p>
                                <p class="font-semibold">{{ $order->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule Info -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Jadwal</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Kapal</p>
                                <p class="font-semibold">{{ $order->schedule->ship->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Rute</p>
                                <p class="font-semibold text-blue-600">{{ $order->schedule->originPort->name }} → {{ $order->schedule->destinationPort->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Waktu Keberangkatan</p>
                                <p class="font-semibold">{{ \Carbon\Carbon::parse($order->schedule->departure_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($order->schedule->departure_time)->format('H:i') }} WITA</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
