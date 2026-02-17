<x-guest-layout>
    <x-slot name="title">
        Masuk ke Akun
    </x-slot>
    <x-slot name="subtitle">
        Atau <a href="{{ route('register') }}"
            class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-200">daftar akun baru</a>
        jika belum punya
    </x-slot>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email</label>
            <div class="mt-1">
                <input id="email" name="email" type="email" autocomplete="email" required autofocus
                    class="block w-full px-4 py-3 bg-white border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    placeholder="nama@email.com" value="{{ old('email') }}">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-sm font-bold text-gray-700">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-xs font-bold text-blue-600 hover:text-blue-700 transition-colors duration-200">
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="mt-1 relative">
                <input id="password" name="password" type="password" autocomplete="current-password" required
                    class="block w-full px-4 py-3 bg-white border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
        </div>

        <div class="flex items-center">
            <input id="remember_me" name="remember" type="checkbox"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer transition-colors duration-200">
            <label for="remember_me" class="ml-2 block text-sm font-bold text-gray-700 cursor-pointer">
                Ingat saya
            </label>
        </div>

        <div>
            <button type="submit"
                class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-200 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:-translate-y-0.5 transition-all duration-200">
                Masuk Sekarang
            </button>
        </div>

        <div class="relative mt-8">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-100"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-3 bg-white text-gray-400 font-bold uppercase tracking-widest text-[10px]">Atau</span>
            </div>
        </div>

        <div class="mt-6">
            <a href="/"
                class="w-full flex justify-center py-3.5 px-4 border border-gray-200 rounded-xl bg-white text-sm font-bold text-gray-600 hover:bg-gray-50 hover:text-blue-600 hover:border-blue-200 transition-all duration-200">
                Kembali ke Beranda
            </a>
        </div>
    </form>
</x-guest-layout>
