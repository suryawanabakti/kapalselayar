@component('mail::message')

# Tiket Anda

Halo {{ $passenger->name }},

Terima kasih, pesanan tiket Anda berhasil dibuat. Berikut detail tiket Anda:

- **Kode Tiket:** {{ $passenger->ticket_code }}
- **Nama Pemesan (Order):** {{ $passenger->order->user->name ?? '–' }}
- **Kapal:** {{ $passenger->order->schedule->ship->name ?? '–' }}
- **Rute:** {{ optional($passenger->order->schedule->originPort)->name ?? '–' }} ➔ {{ optional($passenger->order->schedule->destinationPort)->name ?? '–' }}
- **Tanggal & Waktu:** {{ \Carbon\Carbon::parse($passenger->order->schedule->departure_date)->format('d M Y') }} {{ \Carbon\Carbon::parse($passenger->order->schedule->departure_time)->format('H:i') }}

Jika Anda memesan lebih dari 1 tiket, penumpang lain juga menerima notifikasi ini.

@component('mail::button', ['url' => route('user.transactions.ticket', $passenger->ticket_code)])
Lihat Tiket
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}

@endcomponent
