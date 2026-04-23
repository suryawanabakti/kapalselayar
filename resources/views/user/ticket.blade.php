<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-md mx-auto px-4">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden relative">
                <!-- Ticket Top: Ship Info -->
                <div class="bg-blue-600 p-8 text-white relative">
                    <div class="flex justify-between items-center mb-6">
                        <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                            <span class="text-xs font-bold tracking-widest uppercase">E-Ticket</span>
                        </div>
                        <div class="text-right">
                            <p class="text-xs opacity-75">Boarding Pass</p>
                            <p class="font-mono font-bold">{{ $passenger->ticket_code }}</p>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-3xl font-bold leading-tight">{{ $passenger->order->schedule->originPort->name }}</h2>
                            <p class="text-sm opacity-75">{{ $passenger->order->schedule->originPort->location }}</p>
                        </div>
                        <div class="px-4">
                            <svg class="w-8 h-8 text-white/50 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <h2 class="text-3xl font-bold leading-tight">{{ $passenger->order->schedule->destinationPort->name }}</h2>
                            <p class="text-sm opacity-75">{{ $passenger->order->schedule->destinationPort->location }}</p>
                        </div>
                    </div>
                </div>

                <!-- Ticket Middle: Details -->
                <div class="p-8 pb-4">
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Nama Penumpang</p>
                            <p class="font-bold text-gray-900">{{ $passenger->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">NIK</p>
                            <p class="font-bold text-gray-900">{{ $passenger->nik }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Kapal</p>
                            <p class="font-bold text-gray-900">{{ $passenger->order->schedule->ship->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Tanggal</p>
                            <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($passenger->order->schedule->departure_date)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Waktu</p>
                            <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($passenger->order->schedule->departure_time)->format('H:i') }} WITA</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Status</p>
                            @if($passenger->is_validated)
                                <span class="text-green-600 font-bold flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Validated
                                </span>
                            @else
                                <span class="text-blue-600 font-bold flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Pending
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Perforation line -->
                    <div class="relative h-px w-full border-t-2 border-dashed border-gray-200 my-8">
                        <div class="absolute -left-12 -top-4 w-8 h-8 bg-gray-100 rounded-full"></div>
                        <div class="absolute -right-12 -top-4 w-8 h-8 bg-gray-100 rounded-full"></div>
                    </div>

                    <!-- QR Code Section -->
                    <div class="flex flex-col items-center justify-center p-4">
                        <div class="bg-white p-4 rounded-2xl shadow-inner mb-4 border border-gray-100">
                            {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($passenger->ticket_code) !!}
                        </div>
                        <p class="text-sm text-gray-500 text-center mb-8">
                            Scan QR Code ini di pelabuhan saat keberangkatan untuk validasi tiket.
                        </p>
                        
                        <button onclick="window.print()" class="w-full bg-gray-900 hover:bg-black text-white font-bold py-4 rounded-2xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2 print:hidden">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 00-2 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Download / Print Tiket
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 text-center print:hidden">
                <a href="{{ route('user.transactions') }}" class="text-gray-500 hover:text-gray-900 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Transaksi Saya
                </a>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body { background: white; }
            .py-12 { padding: 0; }
            .max-w-md { max-width: 100%; margin: 0; }
            .shadow-2xl { shadow: none; }
            .rounded-3xl { border-radius: 0; }
            .bg-gray-100 { background: white; }
        }
    </style>
</x-app-layout>
