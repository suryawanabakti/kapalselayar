<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Transaksi #{{ $order->order_code }}
            </h2>
            <a href="{{ route('user.transactions') }}" class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <!-- Status Banner -->
                    <div class="mb-8 p-6 rounded-2xl flex items-center justify-between {{ $order->status === 'paid' ? 'bg-green-50 border border-green-100' : ($order->status === 'pending' ? 'bg-yellow-50 border border-yellow-100' : 'bg-red-50 border border-red-100') }}">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $order->status === 'paid' ? 'bg-green-100 text-green-600' : ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600') }}">
                                @if($order->status === 'paid')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @elseif($order->status === 'pending')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 uppercase tracking-wider font-bold">Status Pembayaran</p>
                                <p class="text-xl font-bold {{ $order->status === 'paid' ? 'text-green-700' : ($order->status === 'pending' ? 'text-yellow-700' : 'text-red-700') }}">
                                    {{ $order->status === 'paid' ? 'LUNAS' : ($order->status === 'pending' ? 'MENUNGGU PEMBAYARAN' : 'GAGAL') }}
                                </p>
                            </div>
                        </div>
                        @if($order->status === 'pending')
                            <a href="{{ route('payment.pay', $order->order_code) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-lg hover:shadow-xl">
                                Bayar Sekarang
                            </a>
                        @endif
                    </div>

                    <div class="grid md:grid-cols-2 gap-12">
                        <!-- Left Side: Order Details -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-6 border-b pb-2">Informasi Keberangkatan</h3>
                            <div class="space-y-6">
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-bold">Kapal</p>
                                        <p class="font-bold text-gray-900 text-lg">{{ $order->schedule->ship->name }}</p>
                                    </div>
                                </div>

                                <div class="relative pl-10">
                                    <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-blue-100"></div>
                                    <div class="absolute left-2.5 top-0 w-3.5 h-3.5 bg-blue-600 rounded-full border-2 border-white"></div>
                                    <div class="absolute left-2.5 bottom-0 w-3.5 h-3.5 bg-blue-600 rounded-full border-2 border-white"></div>
                                    
                                    <div class="mb-8">
                                        <p class="text-xs text-gray-500 uppercase font-bold">Dari (Asal)</p>
                                        <p class="font-bold text-gray-900">{{ $order->schedule->originPort->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $order->schedule->originPort->location }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-bold">Ke (Tujuan)</p>
                                        <p class="font-bold text-gray-900">{{ $order->schedule->destinationPort->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $order->schedule->destinationPort->location }}</p>
                                    </div>
                                </div>

                                <div class="flex gap-12 pt-4 border-t">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-bold">Tanggal</p>
                                        <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($order->schedule->departure_date)->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-bold">Waktu</p>
                                        <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($order->schedule->departure_time)->format('H:i') }} WITA</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Passengers -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-6 border-b pb-2">Daftar Penumpang</h3>
                            <div class="space-y-4">
                                @foreach($order->passengers as $passenger)
                                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 flex items-center justify-between">
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $passenger->name }}</p>
                                            <p class="text-sm text-gray-500">NIK: {{ $passenger->nik }}</p>
                                        </div>
                                        @if($order->status === 'paid')
                                            <a href="{{ route('user.transactions.ticket', $passenger->ticket_code) }}" class="bg-white hover:bg-blue-50 text-blue-600 border border-blue-200 font-bold py-2 px-4 rounded-xl text-sm transition shadow-sm">
                                                Lihat Tiket
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-8 p-6 bg-blue-600 rounded-2xl text-white">
                                <div class="flex justify-between items-center mb-2">
                                    <p class="opacity-75">Harga per Tiket</p>
                                    <p class="font-bold">Rp {{ number_format($order->schedule->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex justify-between items-center mb-4">
                                    <p class="opacity-75">Jumlah Penumpang</p>
                                    <p class="font-bold">{{ $order->total_ticket }} orang</p>
                                </div>
                                <div class="border-t border-white/20 pt-4 flex justify-between items-center">
                                    <p class="text-lg font-bold">Total Bayar</p>
                                    <p class="text-2xl font-black">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
