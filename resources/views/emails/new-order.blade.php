<x-mail::message>
    # Pesanan Baru Masuk

    Halo Admin, ada pesanan tiket baru yang perlu diproses.

    **Detail Pesanan:**
    - **Kode Pesanan:** {{ $order->order_code }}
    - **Nama Pemesan:** {{ $order->user->name }}
    - **Kapal:** {{ $order->schedule->ship->name }}
    - **Rute:** {{ $order->schedule->ship->rute }}
    - **Tanggal Berangkat:** {{ \Carbon\Carbon::parse($order->schedule->departure_date)->format('d M Y H:i') }}
    - **Jumlah Penumpang:** {{ $order->total_ticket }} orang
    - **Total Harga:** Rp {{ number_format($order->total_price, 0, ',', '.') }}

    <x-mail::button :url="route('admin.orders.detail', $order->id)">
        Lihat Detail Pesanan
    </x-mail::button>

    Mohon segera cek dashboard admin untuk memproses pesanan ini.

    Terima kasih,<br>
    {{ config('app.name') }}
</x-mail::message>
