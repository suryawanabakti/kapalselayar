<x-guest-layout>
    <x-slot name="title">
        Daftar Akun Baru
    </x-slot>
    <x-slot name="subtitle">
        Sudah punya akun? <a href="{{ route('login') }}"
            class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-200">Masuk di sini</a>
    </x-slot>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
            <div class="mt-1">
                <input id="name" name="name" type="text" autocomplete="name" required autofocus
                    class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    placeholder="Nama lengkap sesuai KTP" value="{{ old('name') }}">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email</label>
            <div class="mt-1">
                <input id="email" name="email" type="email" autocomplete="email" required
                    class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    placeholder="nama@email.com" value="{{ old('email') }}">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
        </div>

        <!-- NIK -->
        <div>
            <label for="nik" class="block text-sm font-bold text-gray-700 mb-1">NIK (16 Digit)</label>
            <div class="mt-1">
                <input id="nik" name="nik" type="text" required maxlength="16" minlength="16"
                    class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    placeholder="16 digit nomor induk kependudukan" value="{{ old('nik') }}">
            </div>
            <x-input-error :messages="$errors->get('nik')" class="mt-2 text-xs" />
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block text-sm font-bold text-gray-700 mb-1">Nomor Telepon</label>
            <div class="mt-1">
                <input id="phone" name="phone" type="text" required
                    class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    placeholder="Contoh: 08123456789" value="{{ old('phone') }}">
            </div>
            <x-input-error :messages="$errors->get('phone')" class="mt-2 text-xs" />
        </div>

        <!-- Password -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="password" class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                <div class="mt-1">
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                        class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                        placeholder="••••••••">
                </div>
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1">Konfirmasi</label>
                <div class="mt-1">
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                        placeholder="••••••••">
                </div>
            </div>
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs" />

        <div class="pt-4">
            <button type="submit"
                class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-200 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:-translate-y-0.5 transition-all duration-200">
                Daftar Sekarang
            </button>
        </div>
    </form>
</x-guest-layout>
