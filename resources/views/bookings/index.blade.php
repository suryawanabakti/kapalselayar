<x-app-layout>
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="absolute inset-0"
            style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.05&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-5xl md:text-6xl font-extrabold mb-6 animate-fade-in">
                    🚢 E-Tiket Kapal Selayar
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100 max-w-3xl mx-auto">
                    Pesan tiket kapal ferry Anda dengan mudah dan cepat. Nikmati perjalanan yang nyaman menuju
                    Kepulauan Selayar yang indah.
                </p>
                <a href="#jadwal"
                    class="inline-block bg-white text-blue-700 font-bold px-8 py-4 rounded-full shadow-2xl hover:bg-blue-50 transform hover:scale-105 transition-all duration-300">
                    Lihat Jadwal Keberangkatan →
                </a>
            </div>
        </div>

        <!-- Wave Separator -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z"
                    fill="#F3F4F6" />
            </svg>
        </div>
    </div>

    <!-- Search Section -->
    <div class="relative z-10 -mt-24 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Cari Tiket Anda</h2>
            <p class="text-gray-600 mb-6">Atur Jadwal Kedatangan Anda di Pelabuhan</p>

            <form action="{{ route('bookings.index') }}#jadwal" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center relative">
                    <!-- Origin -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pelabuhan Asal</label>
                        <div class="flex items-center border border-gray-300 rounded-xl p-4 hover:border-blue-500 transition-colors">
                            <span class="text-gray-400 mr-4 text-2xl">🚢</span>
                            <select name="origin_port_id" class="w-full bg-transparent border-none focus:ring-0 p-0 text-gray-800 font-medium">
                                <option value="">Pilih Asal</option>
                                @foreach($ports as $port)
                                    <option value="{{ $port->id }}" {{ request('origin_port_id') == $port->id ? 'selected' : '' }}>{{ $port->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Interchange Icon -->
                    <div class="hidden md:flex absolute left-1/2 top-[55%] transform -translate-x-1/2 -translate-y-1/2 z-20 items-center justify-center">
                        <div class="bg-white border-2 border-gray-100 p-2 rounded-full shadow-md text-gray-500 hover:text-blue-600 transition-colors cursor-pointer" onclick="swapPorts()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                    </div>

                    <!-- Destination -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pelabuhan Tujuan</label>
                        <div class="flex items-center border border-gray-300 rounded-xl p-4 hover:border-blue-500 transition-colors">
                            <span class="text-gray-400 mr-4 text-2xl">🚢</span>
                            <select name="destination_port_id" class="w-full bg-transparent border-none focus:ring-0 p-0 text-gray-800 font-medium">
                                <option value="">Pilih Tujuan</option>
                                @foreach($ports as $port)
                                    <option value="{{ $port->id }}" {{ request('destination_port_id') == $port->id ? 'selected' : '' }}>{{ $port->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 items-end">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Keberangkatan</label>
                        <div class="flex items-center border border-gray-300 rounded-xl p-4 hover:border-blue-500 transition-colors">
                            <span class="text-gray-400 mr-4 text-2xl">📅</span>
                            <input type="date" name="departure_date" value="{{ request('departure_date') }}" class="w-full bg-transparent border-none focus:ring-0 p-0 text-gray-800 font-medium">
                        </div>
                    </div>
                    
                    <div>
                        <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-4 px-6 rounded-xl text-lg transform hover:scale-105 transition-all duration-300 shadow-md">
                            🔍 Cari Jadwal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- About Selayar Section -->
    <div class="bg-gray-50 py-16" id="about">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Tentang Kepulauan Selayar</h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <p class="text-lg text-gray-700 leading-relaxed">
                        <span class="font-bold text-blue-700">Kepulauan Selayar</span> adalah salah satu destinasi
                        wisata tersembunyi di Sulawesi Selatan yang menawarkan keindahan alam bawah laut yang memukau,
                        pantai-pantai eksotis, dan budaya lokal yang kaya.
                    </p>
                    <p class="text-lg text-gray-700 leading-relaxed">
                        Terletak di ujung selatan Sulawesi, Selayar dapat diakses melalui jalur laut dari Pelabuhan
                        Bira. Perjalanan dengan kapal ferry menawarkan pemandangan laut yang spektakuler dan menjadi
                        bagian dari pengalaman wisata yang tak terlupakan.
                    </p>

                    <div class="grid grid-cols-2 gap-4 pt-4">
                        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-600">
                            <div class="text-3xl mb-2">🏖️</div>
                            <h3 class="font-bold text-gray-900 mb-1">Pantai Indah</h3>
                            <p class="text-sm text-gray-600">Pasir putih & air jernih</p>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-600">
                            <div class="text-3xl mb-2">🤿</div>
                            <h3 class="font-bold text-gray-900 mb-1">Diving Spot</h3>
                            <p class="text-sm text-gray-600">Terumbu karang terbaik</p>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-yellow-600">
                            <div class="text-3xl mb-2">🎭</div>
                            <h3 class="font-bold text-gray-900 mb-1">Budaya Lokal</h3>
                            <p class="text-sm text-gray-600">Tradisi yang unik</p>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-red-600">
                            <div class="text-3xl mb-2">🍽️</div>
                            <h3 class="font-bold text-gray-900 mb-1">Kuliner Khas</h3>
                            <p class="text-sm text-gray-600">Seafood segar</p>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="aspect-w-16 aspect-h-12 rounded-2xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800&h=600&fit=crop"
                            alt="Kepulauan Selayar"
                            class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="absolute -bottom-6 -right-6 bg-blue-600 text-white p-6 rounded-xl shadow-xl max-w-xs">
                        <p class="font-bold text-lg mb-1">Jarak Tempuh</p>
                        <p class="text-sm">Sekitar 2-3 jam perjalanan laut dari Bira</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Mengapa Pesan di Sini?</h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div
                    class="text-center p-8 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 hover:shadow-xl transition-shadow duration-300">
                    <div class="inline-block p-4 bg-blue-600 rounded-full mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Booking Cepat</h3>
                    <p class="text-gray-600">Pesan tiket dalam hitungan menit tanpa ribet</p>
                </div>

                <div
                    class="text-center p-8 rounded-2xl bg-gradient-to-br from-green-50 to-emerald-50 hover:shadow-xl transition-shadow duration-300">
                    <div class="inline-block p-4 bg-green-600 rounded-full mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Pembayaran Aman</h3>
                    <p class="text-gray-600">Transaksi terjamin dengan Midtrans</p>
                </div>

                <div
                    class="text-center p-8 rounded-2xl bg-gradient-to-br from-purple-50 to-pink-50 hover:shadow-xl transition-shadow duration-300">
                    <div class="inline-block p-4 bg-purple-600 rounded-full mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">E-Tiket Digital</h3>
                    <p class="text-gray-600">Tiket langsung dikirim ke email Anda</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Section -->
    <div class="bg-gray-50 py-16" id="jadwal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Jadwal Keberangkatan</h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto rounded-full mb-4"></div>
                <p class="text-gray-600 text-lg">Pilih jadwal yang sesuai dengan rencana perjalanan Anda</p>
            </div>

            @if (session('success'))
                <div class="mb-8 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md"
                    role="alert">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($schedules as $schedule)
                    <div
                        class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                        <!-- Ship Header -->
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-2xl font-bold mb-1">{{ $schedule->ship->name }}</h3>
                                    <p class="text-blue-100 text-sm font-semibold mb-1">
                                        ⛴️ {{ optional($schedule->originPort)->name }} ➔ {{ optional($schedule->destinationPort)->name }}
                                    </p>
                                    <p class="text-blue-100 text-sm">Kapasitas: {{ $schedule->ship->capacity }} orang
                                    </p>
                                </div>
                                <div class="bg-white bg-opacity-20 backdrop-blur-sm px-3 py-1 rounded-full">
                                    <span class="text-sm font-bold">{{ $schedule->quota }} Tersedia</span>
                                </div>
                            </div>
                        </div>

                        <!-- Schedule Details -->
                        <div class="p-6 space-y-4">
                            <div class="flex items-center text-gray-700">
                                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Tanggal Keberangkatan</p>
                                    <p class="font-semibold">
                                        {{ \Carbon\Carbon::parse($schedule->departure_date)->format('d M Y') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center text-gray-700">
                                <div class="bg-green-100 p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Waktu Keberangkatan</p>
                                    <p class="font-semibold">
                                        {{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }} WITA</p>
                                </div>
                            </div>

                            <div class="border-t pt-4 mt-4">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-gray-600">Harga per tiket</span>
                                    <span class="text-3xl font-bold text-blue-600">Rp
                                        {{ number_format($schedule->price, 0, ',', '.') }}</span>
                                </div>

                                <a href="{{ route('bookings.show', $schedule) }}"
                                    class="block w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-center font-bold py-3 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300">
                                    🎫 Pesan Tiket Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl border-2 border-dashed border-gray-300 p-12 text-center">
                            <div class="text-6xl mb-4">🚢</div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Jadwal Tersedia</h3>
                            <p class="text-gray-600">Jadwal keberangkatan akan segera diumumkan. Silakan cek kembali
                                nanti.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">E-Tiket Kapal Selayar</h3>
                    <p class="text-gray-400">Solusi pemesanan tiket kapal ferry terpercaya untuk perjalanan Anda ke
                        Kepulauan Selayar.</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Kontak</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li>📧 Email: info@etiketselayar.com</li>
                        <li>📱 WhatsApp: +62 812-3456-7890</li>
                        <li>📍 Pelabuhan Bira, Bulukumba</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Jam Operasional</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li>Senin - Jumat: 08.00 - 17.00 WITA</li>
                        <li>Sabtu: 08.00 - 14.00 WITA</li>
                        <li>Minggu & Libur: Tutup</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} E-Tiket Kapal Selayar. All rights reserved.</p>
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
    </script>
</x-app-layout>
