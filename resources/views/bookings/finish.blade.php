<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    @if ($status == 'success')
                        <div class="inline-block p-4 bg-green-100 rounded-full mb-6">
                            <span class="text-4xl">✅</span>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-800 mb-2">Pembayaran Berhasil!</h3>
                        <p class="text-gray-600 mb-8">Tiket Anda telah dikonfirmasi. Silakan cek email atau
                            riwayat pesanan Anda.</p>
                    @elseif($status == 'pending')
                        <div class="inline-block p-4 bg-yellow-100 rounded-full mb-6">
                            <span class="text-4xl">🕒</span>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-800 mb-2">Menunggu Pembayaran</h3>
                        <p class="text-gray-600 mb-8">Silakan selesaikan pembayaran Anda sesuai dengan petunjuk
                            di aplikasi Midtrans.</p>
                    @else
                        <div class="inline-block p-4 bg-red-100 rounded-full mb-6">
                            <span class="text-4xl">❌</span>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-800 mb-2">Pembayaran Gagal</h3>
                        <p class="text-gray-600 mb-8">Terjadi kesalahan saat memproses pembayaran. Silakan coba
                            lagi nanti.</p>
                    @endif
                    @if ($status == 'success')
                        <a href="{{ route('user.transactions') }}"
                            class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition shadow-md">
                            Lihat Tiket
                        </a>
                    @else
                        <a href="{{ route('bookings.index') }}"
                            class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition shadow-md">
                            Kembali ke Beranda
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
