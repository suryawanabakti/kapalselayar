<x-mail::message>
    # Tiket Anda Telah Terbit!

    Halo {{ $order->user->name }},

    Terima kasih telah melakukan pembayaran. Pesanan Anda dengan kode **{{ $order->order_code }}** telah berhasil
    diverifikasi dan tiket Anda sudah terbit.

    **Detail Perjalanan:**
    - **Kapal:** {{ $order->schedule->ship->name }}
    - **Rute:** {{ $order->schedule->ship->rute }}
    - **Tanggal Berangkat:** {{ \Carbon\Carbon::parse($order->schedule->departure_date)->format('d M Y H:i') }}
    - **Jumlah Penumpang:** {{ $order->total_ticket }} orang

    Silakan login ke akun Anda untuk mengunduh E-Tiket atau cek riwayat transaksi.

    <x-mail::button :url="route('user.transactions')">
        Unduh E-Tiket
    </x-mail::button>

    Terima kasih telah menggunakan layanan kami.

    Salam,<br>
    {{ config('app.name') }}
</x-mail::message>
