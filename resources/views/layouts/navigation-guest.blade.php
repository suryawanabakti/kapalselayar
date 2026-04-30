<nav x-data="{ open: false }" class="nav-transparent border-none transition-all duration-500 py-4"
    style="font-family: 'Lexend', sans-serif;">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-24 transition-all duration-500" id="nav-content-height">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center group">
                        <div class="relative">
                            <img src="{{ asset('images/logo-selayar.png') }}" alt="SelayarTix Logo"
                                class="h-16 w-auto object-contain transition-all duration-500 group-hover:scale-110 drop-shadow-2xl">
                            <div
                                class="absolute -inset-2 bg-blue-500/20 blur-2xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </div>
                        <div class="flex flex-col ml-4 -space-y-1">
                            <span
                                class="logo-text text-2xl font-black tracking-tighter text-white transition-all duration-500">SELAYAR</span>

                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-12 sm:flex">
                    @php
                        $links = [
                            [
                                'url' => url('/'),
                                'label' => 'Beranda',
                                'id' => 'nav-beranda',
                                'active' => request()->is('/') || request()->routeIs('bookings.index'),
                            ],
                            [
                                'url' => '#search-section',
                                'label' => 'Cari Tiket',
                                'id' => 'nav-cari-tiket',
                                'active' => false,
                            ],
                            [
                                'url' => '#jadwal',
                                'label' => 'Jadwal',
                                'id' => 'nav-jadwal',
                                'active' => false,
                            ],
                        ];

                        if (auth()->check()) {
                            if (auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin') {
                                $links[] = [
                                    'url' => route('admin.dashboard'),
                                    'label' => 'Dashboard',
                                    'id' => 'nav-dashboard',
                                    'active' => request()->routeIs('admin.dashboard'),
                                ];
                            } else {
                                $links[] = [
                                    'url' => route('user.transactions'),
                                    'label' => 'Tiket Saya',
                                    'id' => 'nav-tiket-saya',
                                    'active' => request()->routeIs('user.*'),
                                ];
                            }
                        }
                    @endphp

                    @foreach ($links as $link)
                        <a href="{{ $link['url'] }}" id="{{ $link['id'] }}"
                            class="nav-link relative px-5 py-2 text-xs font-black uppercase tracking-[0.2em] transition-all duration-500 {{ $link['active'] ? 'text-[#38BDF8] active-link' : 'text-white/70 hover:text-white' }}"
                            style="{{ $link['active'] ? 'color: #38BDF8;' : 'color: rgba(255, 255, 255, 0.7);' }}">
                            {{ $link['label'] }}
                            <span
                                class="active-indicator absolute bottom-0 left-5 right-5 h-1 bg-[#38BDF8] rounded-full shadow-[0_0_15px_rgba(56,189,248,0.5)] {{ $link['active'] ? 'opacity-100' : 'opacity-0' }} transition-opacity duration-500"></span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-6">
                @auth
                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button
                                class="user-dropdown-btn inline-flex items-center px-5 py-2.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl text-sm font-black text-white hover:bg-white/20 hover:shadow-2xl transition-all duration-500 focus:outline-none">
                                <div
                                    class="w-9 h-9 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-4 text-white shadow-lg border border-white/20">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="mr-2">{{ Auth::user()->name }}</div>
                                <svg class="h-4 w-4 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Authenticated as
                                </p>
                                <p class="text-sm font-black text-gray-900 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="p-2 space-y-1">
                                <x-dropdown-link :href="route('profile.edit')" class="rounded-xl font-bold">
                                    My Account
                                </x-dropdown-link>
                                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin')
                                    <x-dropdown-link :href="route('admin.dashboard')"
                                        class="rounded-xl font-bold text-blue-600 bg-blue-50">
                                        Admin Panel
                                    </x-dropdown-link>
                                @endif
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="rounded-xl font-bold text-red-600 hover:bg-red-50">
                                        Sign Out
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}"
                            class="sign-in-btn px-6 py-2.5 text-xs font-black text-white hover:text-blue-400 tracking-[0.2em] transition-all duration-500 uppercase">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-8 py-4 bg-blue-600 text-[10px] font-black text-white rounded-2xl shadow-[0_15px_30px_-5px_rgba(37,99,235,0.4)] hover:bg-blue-700 hover:shadow-[0_20px_40px_-5px_rgba(37,99,235,0.5)] transition-all transform hover:-translate-y-1 active:scale-95 tracking-[0.3em] uppercase">
                            Register Now
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="hamburger-btn inline-flex items-center justify-center p-3.5 rounded-2xl text-white bg-white/10 backdrop-blur-md border border-white/20 hover:text-blue-400 focus:outline-none transition duration-300">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }"
        class="hidden sm:hidden bg-gray-950/95 backdrop-blur-2xl border-t border-white/5 animate-fade-in-down">
        <div class="pt-6 pb-8 space-y-2 px-6">
            @auth
                <div class="bg-white/5 p-5 rounded-3xl mb-6 flex items-center gap-5 border border-white/10">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-2xl">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-black text-white text-lg tracking-tight">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-blue-500 font-black uppercase tracking-widest">{{ Auth::user()->role }}
                        </p>
                    </div>
                </div>

                @foreach ($links as $link)
                    <a href="{{ $link['url'] }}"
                        class="block px-6 py-4 rounded-2xl font-black text-lg {{ $link['active'] ? 'bg-blue-600 text-white shadow-2xl' : 'text-white/60 hover:text-white hover:bg-white/5' }} transition-all duration-300">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            @else
                <div class="grid grid-cols-1 gap-4 pt-4">
                    <a href="{{ route('login') }}"
                        class="flex items-center justify-center py-5 rounded-2xl bg-white/5 border border-white/10 font-black text-white tracking-widest text-sm uppercase">Sign
                        In</a>
                    <a href="{{ route('register') }}"
                        class="flex items-center justify-center py-5 rounded-2xl bg-blue-600 font-black text-white shadow-2xl tracking-widest text-sm uppercase">Create
                        Account</a>
                </div>
            @endauth
        </div>

        @auth
            <div class="pt-6 pb-10 border-t border-white/5 px-6 space-y-3">
                <a href="{{ route('profile.edit') }}"
                    class="block px-6 py-4 rounded-2xl font-black text-white/60 hover:text-white hover:bg-white/5 transition-all">Account
                    Settings</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-6 py-4 rounded-2xl font-black text-red-500 hover:bg-red-500/10 transition-all">Sign
                        Out System</button>
                </form>
            </div>
        @endauth
    </div>
</nav>

<style>
    /* Active Scroll State for Navigation */
    .glass-nav-active .logo-text {
        color: #111827 !important;
        /* text-gray-900 */
    }

    .glass-nav-active .logo-subtext {
        color: #6b7280 !important;
        /* text-gray-500 */
    }

    .glass-nav-active .nav-link {
        color: #4b5563 !important;
        /* text-gray-600 */
    }

    .glass-nav-active .nav-link.active-link {
        color: #2563eb !important;
        /* text-blue-600 */
    }

    .glass-nav-active .nav-link:hover {
        color: #111827 !important;
    }

    .glass-nav-active .user-dropdown-btn {
        background-color: #f9fafb !important;
        /* bg-gray-50 */
        border-color: #f3f4f6 !important;
        /* border-gray-100 */
        color: #374151 !important;
        /* text-gray-700 */
    }

    .glass-nav-active .sign-in-btn {
        color: #374151 !important;
    }

    .glass-nav-active .user-dropdown-btn:hover {
        background-color: #E0F2FE !important;
    }

    .glass-nav-active .hamburger-btn:hover {
        background-color: #E0F2FE !important;
    }
</style>
