{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles (Vite 8 & Tailwind v4) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900">

    {{-- 
        Sidebar (desktop) + Top bar & Bottom nav (mobile) 
        Pastikan file ini ada di resources/views/layouts/navigation.blade.php
    --}}
    @include('layouts.navigation')

    {{-- 
        MAIN WRAPPER 
        - md:ml-[260px]: Memberi ruang untuk sidebar di desktop (min-width: 768px)
        - pt-[60px]: Ruang untuk fixed top bar di mobile
        - pb-[64px]: Ruang untuk bottom nav di mobile
        - md:pt-0 / md:pb-0: Menghapus padding mobile saat di layar desktop
    --}}
    <div id="main-wrapper" class="min-h-screen flex flex-col md:ml-[260px] pt-[60px] pb-[64px] md:pt-0 md:pb-0 transition-all duration-300">

        {{-- Desktop Page Header — Hanya muncul di layar desktop (>= 768px) --}}
        @hasSection('header')
            <header id="desktop-page-header" class="hidden md:block bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                        @yield('header')
                    </h2>
                </div>
            </header>
        @endif

        {{-- Content Area --}}
        <main class="flex-1 p-4 md:p-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>

    </div>

</body>
</html>