<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaksi Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Riwayat Pemesanan Tiket</h3>
                    
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if ($orders->count() > 0)
                        <div class="space-y-4">
                            @foreach ($orders as $order)
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Kode Pesanan</p>
                                            <p class="font-mono font-bold text-lg text-gray-900">
                                                {{ $order->order_code }}</p>
                                        </div>
                                        <div>
                                            @if ($order->status === 'paid')
                                                <span
                                                    class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    ✓ Lunas
                                                </span>
                                            @elseif($order->status === 'pending')
                                                <span
                                                    class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    ⏳ Menunggu Pembayaran
                                                </span>
                                            @else
                                                <span
                                                    class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    ✗ Gagal
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Kapal</p>
                                            <p class="font-semibold text-gray-900">{{ $order->schedule->ship->name }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Tanggal Keberangkatan</p>
                                            <p class="font-semibold text-gray-900">
                                                {{ \Carbon\Carbon::parse($order->schedule->departure_date)->format('d M Y') }}
                                                -
                                                {{ \Carbon\Carbon::parse($order->schedule->departure_time)->format('H:i') }}
                                                WITA
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Jumlah Penumpang</p>
                                            <p class="font-semibold text-gray-900">{{ $order->total_ticket }} orang</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Total Pembayaran</p>
                                            <p class="font-bold text-blue-600 text-lg">Rp
                                                {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>

                                    <div class="border-t pt-4">
                                        <p class="text-sm text-gray-500 mb-2">Daftar Penumpang:</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($order->passengers as $passenger)
                                                <span class="bg-gray-100 px-3 py-1 rounded-full text-sm text-gray-700">
                                                    {{ $passenger->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="mt-4 flex justify-between items-center">
                                        <p class="text-sm text-gray-500">
                                            Dipesan pada: {{ $order->created_at->format('d M Y H:i') }}
                                        </p>
                                        @if ($order->status === 'pending')
                                             <a href="{{ route('payment.pay', $order->order_code) }}"
                                                 class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                                                 Bayar Sekarang
                                             </a>
                                         @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">🎫</div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Transaksi</h3>
                            <p class="text-gray-600 mb-6">Anda belum melakukan pemesanan tiket.</p>
                            <a href="{{ route('bookings.index') }}"
                                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition">
                                Pesan Tiket Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
