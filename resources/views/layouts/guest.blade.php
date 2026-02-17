<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-Tiket Selayar') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>

<body class="h-full antialiased text-gray-900 bg-gray-50">
    <div class="flex min-h-full">
        <!-- Left side: Form -->
        <div
            class="flex flex-col justify-center flex-1 px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white shadow-2xl z-10 transition-all duration-500">
            <div class="w-full max-w-sm mx-auto lg:w-96">
                <div class="mb-10 text-center lg:text-left">
                    <a href="/" class="inline-block transform hover:scale-110 transition-transform duration-300">
                        <x-application-logo class="h-24 w-auto mx-auto lg:mx-0 drop-shadow-lg" />
                    </a>
                    <div class="mt-8">
                        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900">
                            {{ $title ?? 'Selamat Datang' }}
                        </h2>
                        <p class="mt-3 text-sm text-gray-600 font-medium">
                            {{ $subtitle ?? 'Silakan masuk ke akun Anda' }}
                        </p>
                    </div>
                </div>

                <div class="mt-8">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <!-- Right side: Image Background -->
        <div class="relative flex-1 hidden w-0 lg:block overflow-hidden bg-blue-900">
            <img class="absolute inset-0 object-cover w-full h-full opacity-80"
                src="{{ asset('images/selayar-bg.png') }}" alt="Selayar Island Landscape">

            <!-- Overlay with Text -->
            <div class="absolute inset-0 bg-gradient-to-t from-blue-950/90 via-blue-900/20 to-transparent"></div>

            <div class="absolute bottom-12 left-12 right-12 text-white">
                <div class="glass-effect p-10 rounded-3xl border border-white/30 shadow-2xl">
                    <h1 class="text-5xl font-extrabold mb-6 tracking-tight leading-tight">Jelajahi
                        Keindahan<br>Kepulauan Selayar</h1>
                    <p class="text-xl text-white/95 leading-relaxed font-medium mb-8">
                        Nikmati perjalanan tak terlupakan. Pesan tiket kapal Anda dengan mudah, cepat, dan aman hanya di
                        E-Tiket Selayar.
                    </p>
                    <div class="flex items-center space-x-6">
                        <div class="flex -space-x-3">
                            <div
                                class="h-12 w-12 rounded-full bg-blue-500 border-2 border-white flex items-center justify-center text-xs font-bold shadow-xl">
                                1k+</div>
                        </div>
                        <p class="text-base font-bold text-white drop-shadow-md">
                            Wisatawan terdafar
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
