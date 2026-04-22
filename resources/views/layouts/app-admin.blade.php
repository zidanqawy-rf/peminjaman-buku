<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Perpustakaan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:'Inter',sans-serif">

    @include('layouts.sidebar-admin')

    <main style="margin-left:260px;min-height:100vh;background:#f1f5f9">
        <div style="padding:32px 36px;max-width:1400px">

            @if(session('success'))
                <div style="display:flex;align-items:center;gap:10px;background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;font-size:13px;font-weight:600;padding:12px 18px;border-radius:12px;margin-bottom:20px">
                    <svg style="width:16px;height:16px;color:#22c55e;flex-shrink:0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="display:flex;align-items:center;gap:10px;background:#fef2f2;border:1px solid #fecaca;color:#dc2626;font-size:13px;font-weight:600;padding:12px 18px;border-radius:12px;margin-bottom:20px">
                    <svg style="width:16px;height:16px;flex-shrink:0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            {{ $slot ?? '' }}
            @yield('content')

        </div>
    </main>

</body>
</html>