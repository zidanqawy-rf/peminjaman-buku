{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* ─── Main content area: responsive offsets ─────────────────── */
            #main-wrapper {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            /* Desktop: offset for the 260px sidebar */
            @media (min-width: 768px) {
                #main-wrapper {
                    margin-left: 260px;
                }
                #mobile-page-header { display: none; }
            }

            /* Mobile: offset for fixed top bar (60px) and bottom nav (64px) */
            @media (max-width: 767px) {
                #main-wrapper {
                    margin-left: 0;
                    padding-top: 60px;
                    padding-bottom: 64px;
                }

                /* On mobile, hide the standard desktop page header
                   (page title is visible in the top bar instead)       */
                #desktop-page-header { display: none; }
            }

            /* ─── Scrollbar polish ───────────────────────────────────────── */
            ::-webkit-scrollbar { width: 6px; height: 6px; }
            ::-webkit-scrollbar-track { background: #f1f5f9; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100">

        {{-- Sidebar (desktop) + Top bar & Bottom nav (mobile) --}}
        @include('layouts.navigation')

        <div id="main-wrapper">

            {{-- Desktop page header — shown only on ≥768px --}}
            @hasSection('header')
                <header id="desktop-page-header" class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h2 class="text-xl font-semibold text-gray-800">
                            @yield('header')
                        </h2>
                    </div>
                </header>
            @endif

            <main class="flex-1">
                @yield('content')
            </main>

        </div>

    </body>
</html>