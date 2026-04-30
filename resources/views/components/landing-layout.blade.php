<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SelayarTix') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900" style="font-family: 'Lexend', sans-serif;">
    <div class="min-h-screen">
        <!-- Navigation Wrapper -->
        <div class="fixed top-0 left-0 right-0 z-[100] transition-all duration-500" id="main-nav-container">
            @include('layouts.navigation-guest')
        </div>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('scripts')

    <script>
        // Handle Navigation Scroll Effect
        const navContainer = document.getElementById('main-nav-container');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 80) {
                navContainer.classList.add('glass-nav-active');
            } else {
                navContainer.classList.remove('glass-nav-active');
            }
        });

        if (window.scrollY > 80) {
            navContainer.classList.add('glass-nav-active');
        }

        // Smooth Scroll for Anchor Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#') return;

                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    const offset = 120; // Adjust based on nav height
                    const bodyRect = document.body.getBoundingClientRect().top;
                    const elementRect = target.getBoundingClientRect().top;
                    const elementPosition = elementRect - bodyRect;
                    const offsetPosition = elementPosition - offset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Update Active Link on Scroll
        const sections = [{
                id: 'search-section',
                navId: 'nav-cari-tiket'
            },
            {
                id: 'jadwal',
                navId: 'nav-jadwal'
            }
        ];

        window.addEventListener('scroll', () => {
            let current = 'nav-beranda';

            sections.forEach(section => {
                const element = document.getElementById(section.id);
                if (element) {
                    const rect = element.getBoundingClientRect();
                    if (rect.top <= 150) {
                        current = section.navId;
                    }
                }
            });

            document.querySelectorAll('.nav-link').forEach(link => {
                const indicator = link.querySelector('.active-indicator');
                if (link.id === current) {
                    link.classList.add('text-blue-400', 'active-link');
                    link.classList.remove('text-white/80');
                    if (indicator) indicator.classList.replace('opacity-0', 'opacity-100');
                } else {
                    link.classList.remove('text-blue-400', 'active-link');
                    link.classList.add('text-white/80');
                    if (indicator) indicator.classList.replace('opacity-100', 'opacity-0');
                }
            });
        });

        // Auto-scroll to results if search is active
        window.addEventListener('load', () => {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('origin_port_id') || urlParams.has('destination_port_id') || urlParams.has(
                    'departure_date')) {
                const target = document.getElementById('jadwal');
                if (target) {
                    setTimeout(() => {
                        const offset = 120;
                        const bodyRect = document.body.getBoundingClientRect().top;
                        const elementRect = target.getBoundingClientRect().top;
                        const elementPosition = elementRect - bodyRect;
                        const offsetPosition = elementPosition - offset;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                    }, 500); // Small delay for rendering
                }
            }
        });
    </script>

    <style>
        /* Modern Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }

        /* Active Navigation Styles */
        .glass-nav-active {
            padding: 1rem 1.5rem;
        }

        .glass-nav-active nav {
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(255, 255, 255, 0.5) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1) !important;
            border-radius: 2.5rem !important;
            padding-top: 0.25rem !important;
            padding-bottom: 0.25rem !important;
        }

        .glass-nav-active nav .flex.justify-between {
            height: 4.5rem !important;
        }
    </style>
</body>

</html>
