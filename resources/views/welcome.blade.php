<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Perpustakaan') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green-dark:   #14532d;
            --green-mid:    #166534;
            --green-main:   #16a34a;
            --green-light:  #22c55e;
            --green-pale:   #dcfce7;
            --white:        #ffffff;
            --gray-50:      #f8fafc;
            --gray-100:     #f1f5f9;
            --gray-500:     #64748b;
            --gray-700:     #334155;
        }

        html, body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--gray-50);
            color: var(--gray-700);
            overflow-x: hidden;
        }

        /* ── Background decorative circles ── */
        .bg-decor {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }
        .bg-decor span {
            position: absolute;
            border-radius: 50%;
            opacity: .08;
            background: var(--green-main);
        }
        .bg-decor span:nth-child(1) { width: 600px; height: 600px; top: -180px; right: -160px; }
        .bg-decor span:nth-child(2) { width: 400px; height: 400px; bottom: -120px; left: -100px; }
        .bg-decor span:nth-child(3) { width: 200px; height: 200px; top: 40%; left: 38%; opacity: .05; }

        /* ── Layout ── */
        .page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Navbar ── */
        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 2.5rem;
            background: white;
            box-shadow: 0 1px 0 rgba(0,0,0,.07);
        }
        .nav-brand {
            display: flex;
            align-items: center;
            gap: .65rem;
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--green-mid);
            text-decoration: none;
        }
        .nav-brand .icon {
            width: 2.2rem; height: 2.2rem;
            background: linear-gradient(135deg, var(--green-main), var(--green-dark));
            border-radius: .6rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
        }
        .nav-links { display: flex; gap: .75rem; align-items: center; }
        .btn-outline {
            padding: .5rem 1.25rem;
            border: 1.5px solid var(--green-main);
            border-radius: .6rem;
            color: var(--green-mid);
            font-size: .875rem;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
        }
        .btn-outline:hover { background: var(--green-pale); }
        .btn-solid {
            padding: .5rem 1.25rem;
            background: linear-gradient(135deg, var(--green-main), var(--green-dark));
            border-radius: .6rem;
            color: white;
            font-size: .875rem;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
            box-shadow: 0 2px 8px rgba(22,163,74,.35);
        }
        .btn-solid:hover { opacity: .9; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(22,163,74,.4); }

        /* ── Hero ── */
        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 5rem 1.5rem 4rem;
            gap: 1.5rem;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: var(--green-pale);
            color: var(--green-mid);
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            padding: .35rem .9rem;
            border-radius: 99px;
            border: 1px solid #bbf7d0;
            animation: fadeUp .6s ease both;
        }
        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.4rem, 5vw, 4rem);
            font-weight: 900;
            line-height: 1.15;
            color: var(--green-dark);
            max-width: 700px;
            animation: fadeUp .6s .1s ease both;
        }
        .hero h1 span {
            background: linear-gradient(135deg, var(--green-main), var(--green-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero p {
            font-size: 1.1rem;
            color: var(--gray-500);
            max-width: 520px;
            line-height: 1.7;
            animation: fadeUp .6s .2s ease both;
        }
        .hero-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            animation: fadeUp .6s .3s ease both;
        }
        .btn-hero-solid {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .85rem 2rem;
            background: linear-gradient(135deg, var(--green-main), var(--green-dark));
            color: white;
            font-weight: 700;
            font-size: 1rem;
            border-radius: .75rem;
            text-decoration: none;
            box-shadow: 0 4px 16px rgba(22,163,74,.4);
            transition: all .2s;
        }
        .btn-hero-solid:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(22,163,74,.45); }
        .btn-hero-outline {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .85rem 2rem;
            border: 2px solid var(--green-main);
            color: var(--green-mid);
            font-weight: 700;
            font-size: 1rem;
            border-radius: .75rem;
            text-decoration: none;
            transition: all .2s;
            background: white;
        }
        .btn-hero-outline:hover { background: var(--green-pale); transform: translateY(-2px); }

        /* ── Feature cards ── */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.25rem;
            max-width: 860px;
            width: 100%;
            margin: 0 auto;
            padding: 0 1.5rem 4rem;
            animation: fadeUp .6s .4s ease both;
        }
        .feature-card {
            background: white;
            border-radius: 1.25rem;
            padding: 1.75rem 1.5rem;
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
            border: 1px solid #e2e8f0;
            transition: all .25s;
            text-align: center;
        }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 8px 28px rgba(22,163,74,.15); border-color: #bbf7d0; }
        .feature-icon {
            width: 3.2rem; height: 3.2rem;
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            border-radius: .9rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }
        .feature-card h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--green-dark);
            margin-bottom: .4rem;
        }
        .feature-card p {
            font-size: .85rem;
            color: var(--gray-500);
            line-height: 1.6;
        }

        /* ── Footer ── */
        footer {
            text-align: center;
            padding: 1.5rem;
            font-size: .82rem;
            color: var(--gray-500);
            border-top: 1px solid #e2e8f0;
            background: white;
        }

        /* ── Animations ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<div class="bg-decor">
    <span></span><span></span><span></span>
</div>

<div class="page">

    {{-- Navbar --}}
    <nav>
        <a href="/" class="nav-brand">
            <div class="icon">📖</div>
            Perpustakaan
        </a>
        <div class="nav-links">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-solid">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-outline">Masuk</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-solid">Daftar Sekarang</a>
                @endif
            @endauth
        </div>
    </nav>

    {{-- Hero --}}
    <section class="hero">
        <div class="badge">🏫 Sistem Perpustakaan Digital</div>

        <h1>Kelola Peminjaman Buku<br>dengan <span>Mudah & Cepat</span></h1>

        <p>Platform digital untuk siswa meminjam, mengembalikan, dan memantau riwayat buku perpustakaan sekolah — kapan saja, di mana saja.</p>

        <div class="hero-actions">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-hero-solid">🏠 Ke Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn-hero-solid">✨ Mulai Sekarang</a>
                <a href="{{ route('login') }}" class="btn-hero-outline">🔑 Masuk</a>
            @endauth
        </div>
    </section>

    {{-- Features --}}
    <div class="features">
        <div class="feature-card">
            <div class="feature-icon">📚</div>
            <h3>Pinjam Buku</h3>
            <p>Ajukan peminjaman buku koleksi perpustakaan dengan mudah melalui sistem digital.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📋</div>
            <h3>Riwayat Lengkap</h3>
            <p>Pantau semua histori peminjaman dan pengembalian buku secara real-time.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🛡️</div>
            <h3>Data Aman</h3>
            <p>Data akun dan riwayat peminjaman siswa tersimpan dengan aman dan terenkripsi.</p>
        </div>
    </div>

    {{-- Footer --}}
    <footer>
        &copy; {{ date('Y') }} Sistem Perpustakaan &mdash; Dibuat dengan ❤️ untuk kemudahan belajar
    </footer>

</div>
</body>
</html>