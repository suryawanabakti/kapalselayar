<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lengkapi Data Penumpang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-8 border-b pb-4">
                        <h3 class="text-lg font-bold text-gray-800">{{ $schedule->ship->name }}</h3>
                        <p class="text-gray-600">
                            {{ \Carbon\Carbon::parse($schedule->departure_date)->format('d M Y') }} |
                            {{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }} WITA
                        </p>
                        <p class="text-blue-600 font-bold mt-1">Harga: Rp
                            {{ number_format($schedule->price, 0, ',', '.') }} / tiket</p>
                    </div>

                    <form action="{{ route('bookings.store') }}" method="POST" x-data="{
                        passengers: [{ name: '', nik: '' }],
                        price: {{ $schedule->price }},
                        addPassenger() {
                            this.passengers.push({ name: '', nik: '' });
                        },
                        removePassenger(index) {
                            if (this.passengers.length > 1) {
                                this.passengers.splice(index, 1);
                            }
                        }
                    }">
                        @csrf
                        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                        <div class="space-y-6">
                            <template x-for="(passenger, index) in passengers" :key="index">
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 relative">
                                    <div class="flex justify-between items-center mb-4">
                                        <h4 class="font-bold text-gray-700">Penumpang #<span x-text="index + 1"></span>
                                        </h4>
                                        <button type="button" @click="removePassenger(index)"
                                            x-show="passengers.length > 1" class="text-red-500 text-sm hover:underline">
                                            Hapus
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama
                                                Lengkap</label>
                                            <input type="text" :name="`passengers[${index}][name]`"
                                                x-model="passenger.name"
                                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                placeholder="Sesuai KTP" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">NIK (16
                                                Digit)</label>
                                            <input type="text" :name="`passengers[${index}][nik]`"
                                                x-model="passenger.nik"
                                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                placeholder="16 Digit NIK" maxlength="16" minlength="16" required>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="mt-6">
                            <button type="button" @click="addPassenger()"
                                class="text-blue-600 font-medium hover:text-blue-800 flex items-center">
                                <span class="text-xl mr-1">+</span> Tambah Penumpang Lain
                            </button>
                        </div>

                        <div class="mt-8 pt-6 border-t flex flex-col md:flex-row justify-between items-center gap-4">
                            <div>
                                <p class="text-gray-600 text-sm">Total Pembayaran:</p>
                                <p class="text-2xl font-bold text-blue-600">Rp <span
                                        x-text="(passengers.length * price).toLocaleString('id-ID')"></span></p>
                            </div>
                            <button type="submit"
                                class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-10 rounded-lg transition shadow-lg">
                                Lanjut ke Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
