<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Jadwal Keberangkatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.schedules.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="ship_id" class="block text-sm font-medium text-gray-700 mb-1">Kapal</label>
                            <select name="ship_id" id="ship_id" required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Kapal</option>
                                @foreach ($ships as $ship)
                                    <option value="{{ $ship->id }}"
                                        {{ old('ship_id') == $ship->id ? 'selected' : '' }}>
                                        {{ $ship->name }} (Kapasitas: {{ $ship->capacity }})
                                    </option>
                                @endforeach
                            </select>
                            @error('ship_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="departure_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                    Keberangkatan</label>
                                <input type="date" name="departure_date" id="departure_date"
                                    value="{{ old('departure_date') }}" required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('departure_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="departure_time" class="block text-sm font-medium text-gray-700 mb-1">Waktu
                                    Keberangkatan</label>
                                <input type="time" name="departure_time" id="departure_time"
                                    value="{{ old('departure_time') }}" required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('departure_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga
                                    (Rp)</label>
                                <input type="number" name="price" id="price" value="{{ old('price') }}"
                                    required min="0"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="quota" class="block text-sm font-medium text-gray-700 mb-1">Kuota</label>
                                <input type="number" name="quota" id="quota" value="{{ old('quota') }}"
                                    required min="0"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('quota')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                                Simpan
                            </button>
                            <a href="{{ route('admin.schedules.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg transition">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
