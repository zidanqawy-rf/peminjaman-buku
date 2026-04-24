{{-- resources/views/dashboard.blade.php --}}

@extends('layouts.app')

@section('header')
    Dashboard Siswa
@endsection

@section('content')
<div class="dash-wrap">

    {{-- ═══ HERO GREETING ═══ --}}
    <div style="background:linear-gradient(135deg,#10b981,#047857);border-radius:20px;padding:28px 32px;color:white;box-shadow:0 10px 25px -5px rgba(16,185,129,0.2);">
        <div class="hero-inner">
            <div style="flex:1;min-width:0;">
                <h1 class="hero-title">
                    Selamat Datang, {{ $user->name }} 👋
                </h1>
                <p style="font-size:15px;color:#d1fae5;margin-top:8px;font-weight:500;opacity:.9;margin-bottom:0;">
                    Sistem Perpustakaan Digital. Kelola peminjaman dan jelajahi koleksi buku dengan lebih efisien.
                </p>
                <div style="display:flex;gap:10px;margin-top:14px;flex-wrap:wrap;">
                    @if($user->kelas)
                    <span style="background:rgba(255,255,255,.15);padding:5px 14px;border-radius:20px;font-size:12px;font-weight:700;">
                        🏫 Kelas {{ $user->kelas }}
                    </span>
                    @endif
                    @if($user->jurusan)
                    <span style="background:rgba(255,255,255,.15);padding:5px 14px;border-radius:20px;font-size:12px;font-weight:700;">
                        📖 {{ $user->jurusan }}
                    </span>
                    @endif
                    @if($user->nisn)
                    <span style="background:rgba(255,255,255,.15);padding:5px 14px;border-radius:20px;font-size:12px;font-weight:700;">
                        🪪 NISN: {{ $user->nisn }}
                    </span>
                    @endif
                </div>
            </div>
            <div class="hero-icon-wrap">
                <svg style="width:40px;height:40px;color:white;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- ═══ STATISTIK CARDS ═══ --}}
    <div class="stats-grid">
        <div class="stat-card">
            <p class="stat-label">Total Peminjaman</p>
            <h2 class="stat-num" style="color:#064e3b;">{{ $totalPeminjaman }}</h2>
            <p class="stat-sub">transaksi</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Sedang Dipinjam</p>
            <h2 class="stat-num" style="color:#1d4ed8;">{{ $sedangDipinjam }}</h2>
            <p class="stat-sub">aktif</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Menunggu</p>
            <h2 class="stat-num" style="color:#b45309;">{{ $menungguPersetujuan }}</h2>
            <p class="stat-sub">pengajuan</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Sudah Kembali</p>
            <h2 class="stat-num" style="color:#10b981;">{{ $sudahDikembalikan }}</h2>
            <p class="stat-sub">selesai</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Ditolak</p>
            <h2 class="stat-num" style="color:#dc2626;">{{ $ditolak }}</h2>
            <p class="stat-sub">pengajuan</p>
        </div>
        <div class="stat-card" style="border-color:#fed7aa;">
            <p class="stat-label">Total Denda</p>
            <h2 style="font-size:22px;font-weight:800;color:#c2410c;margin:8px 0 0;">
                Rp {{ number_format($totalDenda, 0, ',', '.') }}
            </h2>
            <p class="stat-sub">keseluruhan</p>
        </div>
    </div>

    {{-- ═══ PEMINJAMAN AKTIF ═══ --}}
    @if($peminjamanAktif->count() > 0)
    <div style="background:#fff;border-radius:20px;border:1px solid #e2e8f0;padding:24px;">
        <h3 style="font-size:16px;font-weight:800;color:#1e293b;margin:0 0 16px;display:flex;align-items:center;gap:10px;">
            <span style="width:4px;height:18px;background:#1d4ed8;border-radius:10px;flex-shrink:0;"></span>
            Peminjaman Aktif
        </h3>
        <div style="display:flex;flex-direction:column;gap:10px;">
            @foreach($peminjamanAktif as $p)
            @php
                $today     = \Carbon\Carbon::today();
                $rencana   = \Carbon\Carbon::parse($p->tanggal_rencana_kembali);
                $terlambat = $today->gt($rencana);
                $hariSisa  = $today->diffInDays($rencana, false);
            @endphp
            <div class="aktif-row" style="border-color:{{ $terlambat ? '#fecaca' : '#dcfce7' }};background:{{ $terlambat ? '#fef2f2' : '#f0fdf4' }};">
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:4px;">
                        @foreach($p->buku as $b)
                        <span style="font-size:13px;font-weight:700;color:#1e293b;">{{ $b->nama_buku }}</span>
                        @if(!$loop->last)<span style="color:#94a3b8;">·</span>@endif
                        @endforeach
                    </div>
                    <p style="font-size:12px;color:#64748b;margin:0;">
                        Rencana kembali: <strong>{{ $rencana->format('d M Y') }}</strong>
                    </p>
                </div>
                <span class="aktif-badge" style="{{ $terlambat ? 'background:#fee2e2;color:#991b1b;' : 'background:#dcfce7;color:#166534;' }}">
                    {{ $terlambat ? '⚠ '.abs($hariSisa).' hari' : $hariSisa.' hari lagi' }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ═══ BAWAH: Aksi Cepat + Info Akun ═══ --}}
    <div class="bottom-grid">

        {{-- Aksi Cepat --}}
        <div style="background:#fff;border-radius:20px;border:1px solid #e2e8f0;padding:24px;">
            <h3 style="font-size:16px;font-weight:800;color:#1e293b;margin:0 0 16px;display:flex;align-items:center;gap:10px;">
                <span style="width:4px;height:18px;background:#10b981;border-radius:10px;flex-shrink:0;"></span>
                Aksi Cepat
            </h3>
            <div style="display:grid;gap:12px;">
                <a href="{{ route('peminjaman.tambah') }}"
                   style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-radius:14px;background:#f0fdf4;border:1.5px solid #dcfce7;color:#166534;text-decoration:none;font-weight:700;transition:all 0.2s;"
                   onmouseover="this.style.background='#dcfce7';this.style.transform='translateX(4px)'"
                   onmouseout="this.style.background='#f0fdf4';this.style.transform='translateX(0)'">
                    <span style="display:flex;align-items:center;gap:12px;"><span style="font-size:20px;">📚</span> Tambah Peminjaman Baru</span>
                    <svg style="width:18px;height:18px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
                <a href="{{ route('peminjaman.riwayat') }}"
                   style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-radius:14px;background:#f8fafc;border:1.5px solid #f1f5f9;color:#475569;text-decoration:none;font-weight:700;transition:all 0.2s;"
                   onmouseover="this.style.background='#f1f5f9';this.style.transform='translateX(4px)'"
                   onmouseout="this.style.background='#f8fafc';this.style.transform='translateX(0)'">
                    <span style="display:flex;align-items:center;gap:12px;"><span style="font-size:20px;">📋</span> Lihat Riwayat Saya</span>
                    <svg style="width:18px;height:18px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>

            @if($riwayatTerbaru->count() > 0)
            <div style="margin-top:24px;padding-top:20px;border-top:1px solid #f1f5f9;">
                <p style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;margin:0 0 12px;">Aktivitas Terbaru</p>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @foreach($riwayatTerbaru as $r)
                    @php
                        $badgeStyle = match($r->status) {
                            'pengajuan'         => 'background:#fef9c3;color:#854d0e',
                            'disetujui'         => 'background:#dbeafe;color:#1e40af',
                            'ditolak'           => 'background:#fee2e2;color:#991b1b',
                            'pengajuan_kembali' => 'background:#f3e8ff;color:#6b21a8',
                            'dikembalikan'      => 'background:#dcfce7;color:#14532d',
                            default             => 'background:#f1f5f9;color:#475569',
                        };
                    @endphp
                    <a href="{{ route('peminjaman.show', $r->id) }}"
                       style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;border-radius:10px;background:#f8fafc;text-decoration:none;border:1px solid #f1f5f9;"
                       onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                        <div style="min-width:0;flex:1;">
                            <p style="font-size:12px;font-weight:700;color:#1e293b;margin:0;">#{{ $r->id }} · {{ $r->tanggal_pinjam->format('d M Y') }}</p>
                            <p style="font-size:11px;color:#94a3b8;margin:2px 0 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $r->buku->pluck('nama_buku')->implode(', ') }}</p>
                        </div>
                        <span style="font-size:10px;font-weight:700;padding:3px 8px;border-radius:8px;{{ $badgeStyle }};flex-shrink:0;margin-left:8px;white-space:nowrap;">{{ $r->statusLabel() }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Informasi Akun --}}
        <div style="background:#fff;border-radius:20px;border:1px solid #e2e8f0;padding:24px;">
            <h3 style="font-size:16px;font-weight:800;color:#1e293b;margin:0 0 16px;display:flex;align-items:center;gap:10px;">
                <span style="width:4px;height:18px;background:#64748b;border-radius:10px;flex-shrink:0;"></span>
                Informasi Akun
            </h3>
            <div style="display:flex;flex-direction:column;gap:14px;">
                <div style="padding-bottom:12px;border-bottom:1px dashed #e2e8f0;">
                    <p style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;margin:0 0 4px;">Nama Lengkap</p>
                    <p style="font-size:14px;font-weight:600;color:#1e293b;margin:0;">{{ $user->name }}</p>
                </div>
                <div style="padding-bottom:12px;border-bottom:1px dashed #e2e8f0;">
                    <p style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;margin:0 0 4px;">Email</p>
                    <p style="font-size:14px;font-weight:600;color:#1e293b;margin:0;word-break:break-all;">{{ $user->email }}</p>
                </div>
                @if($user->nisn)
                <div style="padding-bottom:12px;border-bottom:1px dashed #e2e8f0;">
                    <p style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;margin:0 0 4px;">NISN</p>
                    <p style="font-size:14px;font-weight:600;color:#1e293b;margin:0;">{{ $user->nisn }}</p>
                </div>
                @endif
                @if($user->kelas || $user->jurusan)
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;padding-bottom:12px;border-bottom:1px dashed #e2e8f0;">
                    <div>
                        <p style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;margin:0 0 4px;">Kelas</p>
                        <p style="font-size:14px;font-weight:600;color:#1e293b;margin:0;">{{ $user->kelas ?? '-' }}</p>
                    </div>
                    <div>
                        <p style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;margin:0 0 4px;">Jurusan</p>
                        <p style="font-size:14px;font-weight:600;color:#1e293b;margin:0;">{{ $user->jurusan ?? '-' }}</p>
                    </div>
                </div>
                @endif
                <div style="background:#f8fafc;border-radius:14px;padding:14px;display:flex;flex-direction:column;gap:8px;">
                    <p style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;margin:0 0 4px;">Rekap Peminjaman</p>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:12px;color:#64748b;font-weight:600;">Proses Kembali</span>
                        <span style="font-size:13px;font-weight:800;color:#6b21a8;">{{ $prosesKembali }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:12px;color:#64748b;font-weight:600;">Selesai</span>
                        <span style="font-size:13px;font-weight:800;color:#10b981;">{{ $sudahDikembalikan }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:12px;color:#64748b;font-weight:600;">Total Denda</span>
                        <span style="font-size:13px;font-weight:800;color:#c2410c;">Rp {{ number_format($totalDenda, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /bottom-grid --}}
</div>{{-- /dash-wrap --}}

<style>
.dash-wrap  { padding:24px; max-width:1100px; margin:0 auto; display:flex; flex-direction:column; gap:20px; }

.hero-inner      { display:flex; align-items:center; gap:20px; }
.hero-title      { font-size:26px; font-weight:800; margin:0; letter-spacing:-0.025em; }
.hero-icon-wrap  { background:rgba(255,255,255,.1); padding:15px; border-radius:16px; backdrop-filter:blur(4px); flex-shrink:0; }

.stats-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(150px,1fr)); gap:14px; }
.stat-card  { background:#fff; border-radius:18px; padding:18px; border:1px solid #e2e8f0; box-shadow:0 1px 3px rgba(0,0,0,.05); }
.stat-label { font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.05em; margin:0; }
.stat-num   { font-size:30px; font-weight:800; margin:8px 0 0; }
.stat-sub   { font-size:12px; color:#94a3b8; margin:2px 0 0; font-weight:600; }

.aktif-row  { display:flex; align-items:center; gap:12px; padding:14px 16px; border-radius:14px; border:1.5px solid; }
.aktif-badge{ font-size:11px; font-weight:800; padding:5px 12px; border-radius:10px; flex-shrink:0; white-space:nowrap; }

.bottom-grid { display:grid; grid-template-columns:1.5fr 1fr; gap:20px; }

@media (max-width:767px) {
    .dash-wrap   { padding:12px; gap:12px; }
    .hero-inner  { flex-direction:column; align-items:flex-start; gap:12px; }
    .hero-title  { font-size:20px; }
    .hero-icon-wrap { display:none; }
    .stats-grid  { grid-template-columns:repeat(2,1fr); gap:10px; }
    .stat-card   { padding:14px; }
    .stat-num    { font-size:24px; }
    .aktif-row   { flex-wrap:wrap; }
    .bottom-grid { grid-template-columns:1fr; }
}
</style>
@endsection