<x-mail::message>
    # Tiket Anda Telah Terbit!

    Halo {{ $order->user->name }},

    Terima kasih telah melakukan pembayaran. Pesanan Anda dengan kode **{{ $order->order_code }}** telah berhasil
    diverifikasi dan tiket Anda sudah terbit.

    **Detail Perjalanan:**
    - **Kapal:** {{ $order->schedule->ship->name }}
    - **Rute:** {{ $order->schedule->originPort->name }} → {{ $order->schedule->destinationPort->name }}
    - **Tanggal Berangkat:** {{ \Carbon\Carbon::parse($order->schedule->departure_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($order->schedule->departure_time)->format('H:i') }} WITA
    - **Jumlah Penumpang:** {{ $order->total_ticket }} orang

    **Daftar Tiket Penumpang:**
    @foreach($order->passengers as $passenger)
    - **{{ $passenger->name }}**: [Lihat Tiket & QR Code]({{ route('user.transactions.ticket', $passenger->ticket_code) }})
    @endforeach

    Silakan klik tautan di atas untuk melihat tiket dan QR Code masing-masing penumpang yang akan di-scan di pelabuhan.

    <x-mail::button :url="route('user.transactions')">
        Lihat Riwayat Transaksi
    </x-mail::button>

    Terima kasih telah menggunakan layanan kami.

    Salam,<br>
    {{ config('app.name') }}
</x-mail::message>
