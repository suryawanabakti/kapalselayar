<x-landing-layout>
    <style>
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .text-gradient {
            background: linear-gradient(to right, #FFFFFF, #A5D8FF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 20px 30px rgba(0, 0, 0, 0.2));
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        @keyframes scroll-dot {
            0% {
                opacity: 0;
                transform: translateY(-5px);
            }

            50% {
                opacity: 1;
                transform: translateY(5px);
            }

            100% {
                opacity: 0;
                transform: translateY(15px);
            }
        }

        .animate-scroll-dot {
            animation: scroll-dot 2s infinite;
        }

        .ship-track {
            background-image: radial-gradient(#3b82f6 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>

    <!-- Hero Section -->
    <div class="relative min-h-screen flex items-center justify-center text-white overflow-hidden bg-blue-950">
        <!-- Background Image with Parallax effect simulation -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/hero-ship.png') }}" alt="Hero Ship" class="w-full h-full object-cover scale-110">
            <div class="absolute inset-0 bg-gradient-to-b from-blue-950/70 via-blue-900/30 to-gray-50"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center">


            <h1 class="text-6xl md:text-8xl font-black mb-10 tracking-tighter leading-[0.9] animate-fade-in-up">
                <span class="block">REDEFINING</span>
                <span class="text-gradient drop-shadow-2xl">JOURNEYS.</span>
            </h1>

            <p
                class="text-lg md:text-2xl mb-16 text-white/85 max-w-4xl mx-auto leading-relaxed font-medium drop-shadow-lg" style="color: rgba(255, 255, 255, 0.85);">
                Gerbang digital menuju eksotisme Kepulauan Selayar. Nikmati pengalaman pemesanan tiket kapal tercepat,
                teraman, dan termudah.
            </p>
        </div>
    </div>

    <!-- Search Section -->
    <div id="search-section" class="relative z-20 -mt-24 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-32">
        <div
            class="glass-card rounded-[3.5rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.15)] p-12 md:p-16 border border-white/60">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div class="space-y-2">
                    <span class="text-blue-600 font-black tracking-widest uppercase text-xs">Quick Search</span>
                    <h2 class="text-5xl font-black text-gray-900 tracking-tighter">Cari Tiket Anda</h2>
                </div>
                <div
                    class="bg-blue-50/50 backdrop-blur-md px-6 py-3 rounded-2xl text-blue-700 font-black text-xs flex items-center border border-blue-100/50">
                    <span class="animate-pulse mr-3 h-3 w-3 rounded-full bg-blue-600"></span>
                    MIDTRANS SECURED GATEWAY
                </div>
            </div>

            <form action="{{ route('bookings.index') }}#jadwal" method="GET" class="space-y-10">
                <div class="grid grid-cols-1 lg:grid-cols-11 gap-8 items-center">
                    <!-- Origin -->
                    <div class="lg:col-span-5 relative group">
                        <label
                            class="block text-xs font-black text-blue-600 uppercase tracking-[0.2em] mb-3 ml-2">Pelabuhan
                            Asal</label>
                        <div
                            class="flex items-center bg-white border-2 border-gray-100 rounded-3xl px-8 py-6 focus-within:border-blue-500 focus-within:bg-white focus-within:shadow-2xl transition-all duration-500 group-hover:border-blue-200">
                            <div
                                class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center mr-6 group-hover:bg-blue-600 transition-all duration-500">
                                <svg class="w-6 h-6 text-blue-600 group-hover:text-white" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 21c-4.97 0-9-4.03-9-9s4.03-9 9-9 9 4.03 9 9-4.03 9-9 9zM12 7v10m-5-5h10">
                                    </path>
                                </svg>
                            </div>
                            <select name="origin_port_id"
                                class="w-full bg-transparent border-none focus:ring-0 p-0 text-gray-900 font-black text-xl cursor-pointer">
                                <option value="">Pilih Asal</option>
                                @foreach ($ports as $port)
                                    <option value="{{ $port->id }}"
                                        {{ request('origin_port_id') == $port->id ? 'selected' : '' }}>
                                        {{ $port->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Interchange Icon -->
                    <div class="lg:col-span-1 flex justify-center self-end pb-4">
                        <button type="button" onclick="swapPorts()"
                            class="bg-gray-100/80 text-gray-900 p-4 rounded-2xl shadow-xl hover:bg-blue-600 hover:text-white transition-all duration-500 transform hover:rotate-180 active:scale-90 group border border-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </button>
                    </div>

                    <!-- Destination -->
                    <div class="lg:col-span-5 relative group">
                        <label
                            class="block text-xs font-black text-indigo-600 uppercase tracking-[0.2em] mb-3 ml-2">Pelabuhan
                            Tujuan</label>
                        <div
                            class="flex items-center bg-white border-2 border-gray-100 rounded-3xl px-8 py-6 focus-within:border-blue-500 focus-within:bg-white focus-within:shadow-2xl transition-all duration-500 group-hover:border-indigo-200">
                            <div
                                class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center mr-6 group-hover:bg-indigo-600 transition-all duration-500">
                                <svg class="w-6 h-6 text-indigo-600 group-hover:text-white" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A2 2 0 013 15.488V5.111a2 2 0 011.106-1.789L9 1m0 19v-19m0 19l5-2.5m-5-16.5l5 2.5m0 14V3.5m0 14l5.447 2.724A2 2 0 0021 18.489V8.111a2 2 0 00-1.106-1.789L15 3.5">
                                    </path>
                                </svg>
                            </div>
                            <select name="destination_port_id"
                                class="w-full bg-transparent border-none focus:ring-0 p-0 text-gray-900 font-black text-xl cursor-pointer">
                                <option value="">Pilih Tujuan</option>
                                @foreach ($ports as $port)
                                    <option value="{{ $port->id }}"
                                        {{ request('destination_port_id') == $port->id ? 'selected' : '' }}>
                                        {{ $port->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end">
                    <div class="lg:col-span-8 relative group">
                        <label
                            class="block text-xs font-black text-emerald-600 uppercase tracking-[0.2em] mb-3 ml-2">Tanggal
                            Keberangkatan</label>
                        <div
                            class="flex items-center bg-white border-2 border-gray-100 rounded-3xl px-8 py-6 focus-within:border-blue-500 focus-within:bg-white focus-within:shadow-2xl transition-all duration-500 group-hover:border-emerald-200">
                            <div
                                class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center mr-6 group-hover:bg-emerald-600 transition-all duration-500">
                                <svg class="w-6 h-6 text-emerald-600 group-hover:text-white" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <input type="date" name="departure_date" value="{{ request('departure_date') }}"
                                class="w-full bg-transparent border-none focus:ring-0 p-0 text-gray-900 font-black text-xl cursor-pointer">
                        </div>
                    </div>

                    <div class="lg:col-span-4">
                        <button type="submit"
                            class="w-full h-[88px] bg-blue-600 hover:bg-blue-700 text-white font-black py-4 px-6 rounded-3xl text-2xl shadow-[0_25px_50px_-15px_rgba(37,99,235,0.4)] transform hover:-translate-y-2 active:scale-95 transition-all duration-500 flex items-center justify-center gap-4 group">
                            <span>Temukan Jadwal</span>
                            <svg class="w-8 h-8 transition-transform duration-300 group-hover:translate-x-2"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Trust Stats Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-40 reveal">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-12">
            <div class="text-center space-y-3">
                <p class="text-6xl font-black text-blue-600 tracking-tighter">10k+</p>
                <p class="text-sm font-black text-gray-400 uppercase tracking-[0.2em]">Wisatawan / Tahun</p>
            </div>
            <div class="text-center space-y-3">
                <p class="text-6xl font-black text-blue-600 tracking-tighter">100%</p>
                <p class="text-sm font-black text-gray-400 uppercase tracking-[0.2em]">Transaksi Aman</p>
            </div>
            <div class="text-center space-y-3">
                <p class="text-6xl font-black text-blue-600 tracking-tighter">24/7</p>
                <p class="text-sm font-black text-gray-400 uppercase tracking-[0.2em]">Dukungan Admin</p>
            </div>
            <div class="text-center space-y-3">
                <p class="text-6xl font-black text-blue-600 tracking-tighter">5.0</p>
                <p class="text-sm font-black text-gray-400 uppercase tracking-[0.2em]">Rating Pengguna</p>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="bg-gray-900 py-40 overflow-hidden relative" id="how-it-works">
        <div class="absolute inset-0 ship-track opacity-5"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-24 reveal">
                <span class="text-blue-500 font-black tracking-[0.3em] uppercase text-xs">Easy Process</span>
                <h2 class="text-5xl md:text-7xl font-black text-white mt-4 tracking-tighter">Hanya 3 Langkah Mudah</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-20">
                <div class="relative reveal" style="transition-delay: 100ms;">
                    <div class="text-[12rem] font-black text-white/5 absolute -top-32 -left-10 select-none">01</div>
                    <div class="relative space-y-8">
                        <div
                            class="w-24 h-24 bg-blue-600 rounded-[2.5rem] flex items-center justify-center shadow-2xl rotate-3">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black text-white">Cari Jadwal</h3>
                        <p class="text-gray-400 text-lg leading-relaxed">Pilih pelabuhan asal, tujuan, dan tanggal
                            keberangkatan yang Anda inginkan.</p>
                    </div>
                </div>

                <div class="relative reveal" style="transition-delay: 300ms;">
                    <div class="text-[12rem] font-black text-white/5 absolute -top-32 -left-10 select-none">02</div>
                    <div class="relative space-y-8">
                        <div
                            class="w-24 h-24 bg-indigo-600 rounded-[2.5rem] flex items-center justify-center shadow-2xl -rotate-3">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black text-white">Lakukan Pembayaran</h3>
                        <p class="text-gray-400 text-lg leading-relaxed">Isi data penumpang dan selesaikan pembayaran
                            melalui berbagai metode aman Midtrans.</p>
                    </div>
                </div>

                <div class="relative reveal" style="transition-delay: 500ms;">
                    <div class="text-[12rem] font-black text-white/5 absolute -top-32 -left-10 select-none">03</div>
                    <div class="relative space-y-8">
                        <div
                            class="w-24 h-24 bg-emerald-600 rounded-[2.5rem] flex items-center justify-center shadow-2xl rotate-6">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black text-white">Terima E-Tiket</h3>
                        <p class="text-gray-400 text-lg leading-relaxed">E-Tiket otomatis terbit dan siap digunakan
                            untuk masuk ke area pelabuhan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Section -->
    <div class="py-40 bg-gray-50 relative" id="jadwal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-end justify-between mb-24 gap-8 reveal">
                <div class="space-y-4">
                    <span class="text-blue-600 font-black tracking-[0.3em] uppercase text-xs">Available Trips</span>
                    <h2 class="text-5xl md:text-7xl font-black text-gray-900 tracking-tighter">Jadwal Keberangkatan
                    </h2>
                    <div class="w-32 h-3 bg-blue-600 rounded-full"></div>
                </div>
                <p class="text-gray-500 text-xl font-bold max-w-md leading-relaxed">Pilih jadwal kapal terbaik. Kami
                    menjamin ketepatan waktu dan kenyamanan selama perjalanan.</p>
            </div>

            @if (session('success'))
                <div
                    class="mb-16 p-8 rounded-[2.5rem] bg-emerald-50 border-2 border-emerald-100 flex items-center gap-6 shadow-2xl shadow-emerald-100 animate-bounce-in">
                    <div
                        class="w-16 h-16 bg-emerald-500 rounded-3xl flex items-center justify-center text-white shadow-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-black text-emerald-600 uppercase tracking-widest mb-1">Success
                            Transaction</p>
                        <p class="text-2xl font-black text-emerald-900">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                @forelse ($schedules as $schedule)
                    <div
                        class="group bg-white rounded-[3.5rem] overflow-hidden border border-gray-100 shadow-[0_30px_70px_-20px_rgba(0,0,0,0.05)] hover:shadow-[0_50px_100px_-20px_rgba(37,99,235,0.2)] transition-all duration-700 flex flex-col md:flex-row reveal">
                        <!-- Left: Ship Identity -->
                        <div
                            class="md:w-2/5 bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-950 p-10 text-white relative overflow-hidden flex flex-col justify-between">
                            <div
                                class="absolute -top-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:bg-blue-400/20 transition-all duration-700">
                            </div>

                            <div class="relative z-10 space-y-4">
                                <div
                                    class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-xl border border-white/20 text-[10px] font-black uppercase tracking-widest">
                                    ⛴️ Ferry Ship
                                </div>
                                <h3
                                    class="text-4xl font-black tracking-tighter leading-tight group-hover:scale-105 transition-transform origin-left">
                                    {{ $schedule->ship->name }}</h3>
                            </div>

                            <div class="relative z-10 mt-12">
                                <p class="text-xs font-black text-blue-300 uppercase tracking-widest mb-2">Capacity</p>
                                <p class="text-2xl font-black">{{ $schedule->ship->capacity }} <span
                                        class="text-xs text-blue-200 font-bold">Total Seats</span></p>
                            </div>
                        </div>

                        <!-- Right: Trip Info -->
                        <div class="md:w-3/5 p-12 flex flex-col justify-between space-y-10">
                            <div class="space-y-8">
                                <div class="flex items-center justify-between">
                                    <div class="space-y-1">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">From
                                        </p>
                                        <p class="text-xl font-black text-gray-900">
                                            {{ optional($schedule->originPort)->name }}</p>
                                    </div>
                                    <div class="w-12 h-[2px] bg-gray-100 relative">
                                        <div
                                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-4 h-4 bg-blue-100 rounded-full border-2 border-blue-600 animate-pulse">
                                        </div>
                                    </div>
                                    <div class="text-right space-y-1">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">To
                                        </p>
                                        <p class="text-xl font-black text-gray-900">
                                            {{ optional($schedule->destinationPort)->name }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <div class="space-y-1">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                            Departure</p>
                                        <p class="text-lg font-black text-gray-900">
                                            {{ \Carbon\Carbon::parse($schedule->departure_date)->format('d M Y') }}</p>
                                        <p class="text-sm font-bold text-blue-600">
                                            {{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }} WITA
                                        </p>
                                    </div>
                                    <div class="text-right space-y-1">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                            Available Quota</p>
                                        <p class="text-3xl font-black text-gray-900">{{ $schedule->quota }}</p>
                                        <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">
                                            Seats Left</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row items-center gap-6 pt-8 border-t border-gray-50">
                                <div class="flex-1">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                        Ticket Price</p>
                                    <p class="text-4xl font-black text-blue-600 tracking-tighter">Rp
                                        {{ number_format($schedule->price, 0, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('bookings.show', $schedule) }}"
                                    class="w-full sm:w-auto px-10 py-5 bg-gray-900 hover:bg-blue-600 text-white font-black rounded-2xl transition-all duration-500 shadow-xl hover:shadow-blue-200 transform hover:-translate-y-1 active:scale-95 text-center">
                                    Pesan Tiket
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div
                            class="bg-white rounded-[4rem] border-4 border-dashed border-gray-100 p-32 text-center reveal">
                            <div class="text-[10rem] mb-12 animate-float inline-block filter grayscale opacity-20">🚢
                            </div>
                            <h3 class="text-4xl font-black text-gray-900 mb-6 tracking-tighter">Belum Ada Jadwal</h3>
                            <p class="text-gray-400 text-xl font-bold max-w-xl mx-auto leading-relaxed">Mohon maaf,
                                saat ini belum ada jadwal keberangkatan yang tersedia untuk rute tersebut. Silakan
                                hubungi pusat informasi kami.</p>
                            <a href="/"
                                class="mt-12 inline-block px-12 py-5 bg-gray-900 text-white font-black rounded-2xl hover:bg-blue-600 transition-all shadow-2xl">Lihat
                                Semua Jadwal</a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- About Selayar Detail -->
    <div class="py-40 bg-white overflow-hidden" id="about">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-32 items-center">
                <div class="relative reveal">
                    <div
                        class="relative z-10 rounded-[4rem] overflow-hidden shadow-[0_80px_150px_-30px_rgba(0,0,0,0.3)] aspect-square border-[16px] border-white">
                        <img src="{{ asset('images/selayar-landscape.png') }}" alt="Selayar"
                            class="w-full h-full object-cover transform hover:scale-110 transition-all duration-1000">
                    </div>
                    <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-blue-600 rounded-[4rem] -z-0 rotate-12">
                    </div>
                    <div class="absolute -top-10 -left-10 w-40 h-40 bg-yellow-400 rounded-full blur-[80px] opacity-30">
                    </div>
                </div>

                <div class="space-y-12 reveal">
                    <div class="space-y-6">
                        <span class="text-blue-600 font-black tracking-[0.4em] uppercase text-xs">Unforgettable
                            Island</span>
                        <h2 class="text-6xl md:text-8xl font-black text-gray-900 tracking-tighter leading-[0.85]">
                            SELAYAR<br><span class="text-blue-600">ISLAND.</span></h2>
                        <div class="w-40 h-4 bg-gray-900 rounded-full"></div>
                    </div>

                    <p class="text-2xl text-gray-500 font-bold leading-relaxed">
                        Nikmati keindahan yang belum tersentuh. Dari Taman Nasional Taka Bonerate hingga pantai-pantai
                        berpasir putih yang memukau. Kepulauan Selayar menunggu kedatangan Anda.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-10">
                        <div class="space-y-4">
                            <div class="text-5xl">🏝️</div>
                            <h4 class="text-2xl font-black text-gray-900">Eksotis</h4>
                            <p class="text-gray-400 font-bold">Pantai dengan air kristal yang menenangkan jiwa.</p>
                        </div>
                        <div class="space-y-4">
                            <div class="text-5xl">🐡</div>
                            <h4 class="text-2xl font-black text-gray-900">Biodiversitas</h4>
                            <p class="text-gray-400 font-bold">Rumah bagi ribuan spesies terumbu karang langka.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Newsletter -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-40 reveal">
        <div
            class="bg-blue-600 rounded-[4rem] p-16 md:p-24 relative overflow-hidden shadow-[0_50px_100px_-20px_rgba(37,99,235,0.4)]">
            <div
                class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl">
            </div>
            <div class="relative z-10 text-center max-w-3xl mx-auto space-y-12">
                <h2 class="text-5xl md:text-7xl font-black text-white tracking-tighter">Stay Updated.</h2>
                <p class="text-xl text-blue-50 font-bold">Dapatkan info jadwal terbaru dan promo menarik langsung ke
                    email Anda.</p>
                <form class="flex flex-col sm:flex-row gap-4">
                    <input type="email" placeholder="Alamat Email Anda"
                        class="flex-1 px-10 py-6 rounded-3xl bg-white/10 border-2 border-white/20 text-white placeholder-blue-100 font-black focus:bg-white focus:text-blue-900 focus:outline-none transition-all duration-500 text-xl">
                    <button
                        class="px-12 py-6 bg-white text-blue-600 font-black rounded-3xl text-xl hover:bg-gray-900 hover:text-white transition-all duration-500 shadow-2xl">Subscribe</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-950 text-white pt-40 pb-20 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-600 via-indigo-600 to-emerald-600">
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-4 gap-24 mb-32">
                <div class="col-span-1 lg:col-span-2 space-y-12">
                    <a href="#" class="flex items-center group">
                        <img src="{{ asset('images/logo-selayar.png') }}" alt="SelayarTix Logo"
                            class="h-20 w-auto object-contain transition-all duration-500 group-hover:scale-110 drop-shadow-2xl">
                        <span class="text-4xl font-black tracking-tighter ml-4 text-white">SELAYAR<span
                                class="text-blue-600">TIX</span></span>
                    </a>
                    <p class="text-2xl text-gray-400 font-bold leading-relaxed max-w-xl">
                        Kami berkomitmen memberikan layanan transportasi laut terbaik demi kemajuan pariwisata dan
                        ekonomi Kepulauan Selayar.
                    </p>
                    <div class="flex gap-6">
                        @foreach (['twitter', 'facebook', 'instagram', 'youtube'] as $social)
                            <a href="#"
                                class="w-16 h-16 bg-white/5 rounded-3xl flex items-center justify-center hover:bg-blue-600 transition-all duration-500 border border-white/10 group">
                                <span class="text-2xl grayscale group-hover:grayscale-0">🔗</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-10">
                    <h4 class="text-xs font-black uppercase tracking-[0.4em] text-blue-500">Navigation</h4>
                    <ul class="space-y-6 text-xl font-bold text-gray-500">
                        <li><a href="#" class="hover:text-white transition-colors">Home</a></li>
                        <li><a href="#jadwal" class="hover:text-white transition-colors">Schedules</a></li>
                        <li><a href="#about" class="hover:text-white transition-colors">About Selayar</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">User Guide</a></li>
                    </ul>
                </div>

                <div class="space-y-10">
                    <h4 class="text-xs font-black uppercase tracking-[0.4em] text-blue-500">Support</h4>
                    <ul class="space-y-6 text-xl font-bold text-gray-500">
                        <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-20 border-t border-white/5 flex flex-col md:flex-row items-center justify-between gap-8">
                <p class="text-gray-600 font-bold text-lg">&copy; {{ date('Y') }} SelayarTix. Digitalizing the
                    South Sea.</p>
                <div class="flex gap-10">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
                        <span class="text-xs font-black text-gray-500 uppercase tracking-widest">Midtrans Active</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
                        <span class="text-xs font-black text-gray-500 uppercase tracking-widest">Cloudflare
                            Protected</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function swapPorts() {
            const originSelect = document.querySelector('select[name="origin_port_id"]');
            const destSelect = document.querySelector('select[name="destination_port_id"]');
            const tempVal = originSelect.value;
            originSelect.value = destSelect.value;
            destSelect.value = tempVal;
        }

        // Reveal animations on scroll
        function reveal() {
            var reveals = document.querySelectorAll(".reveal");
            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var elementTop = reveals[i].getBoundingClientRect().top;
                var elementVisible = 150;
                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add("active");
                }
            }
        }
        window.addEventListener("scroll", reveal);
        window.addEventListener("load", reveal);

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</x-landing-layout>
