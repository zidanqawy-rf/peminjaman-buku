{{-- resources/views/dashboard.blade.php --}}

@extends('layouts.app')

@section('header')
    Dashboard Siswa
@endsection

@section('content')
<div style="padding: 24px; max-width: 1100px; margin: 0 auto; display: flex; flex-direction: column; gap: 24px;">

    {{-- ═══ HERO GREETING ═══ --}}
    <div style="background: linear-gradient(135deg, #10b981, #047857); border-radius: 20px; padding: 32px; color: white; box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.2);">
        <div style="display: flex; align-items: center; gap: 20px;">
            <div style="flex: 1;">
                <h1 style="font-size: 28px; font-weight: 800; margin: 0; letter-spacing: -0.025em;">
                    Selamat Datang, {{ $user->name }} 👋
                </h1>
                <p style="font-size: 15px; color: #d1fae5; margin-top: 8px; font-weight: 500; opacity: 0.9;">
                    Sistem Perpustakaan Digital. Kelola peminjaman dan jelajahi koleksi buku dengan lebih efisien.
                </p>
                <div style="display: flex; gap: 16px; margin-top: 16px; flex-wrap: wrap;">
                    @if($user->kelas)
                    <span style="background: rgba(255,255,255,0.15); padding: 5px 14px; border-radius: 20px; font-size: 13px; font-weight: 700;">
                        🏫 Kelas {{ $user->kelas }}
                    </span>
                    @endif
                    @if($user->jurusan)
                    <span style="background: rgba(255,255,255,0.15); padding: 5px 14px; border-radius: 20px; font-size: 13px; font-weight: 700;">
                        📖 {{ $user->jurusan }}
                    </span>
                    @endif
                    @if($user->nisn)
                    <span style="background: rgba(255,255,255,0.15); padding: 5px 14px; border-radius: 20px; font-size: 13px; font-weight: 700;">
                        🪪 NISN: {{ $user->nisn }}
                    </span>
                    @endif
                </div>
            </div>
            <div style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 16px; backdrop-filter: blur(4px); flex-shrink: 0;">
                <svg style="width: 40px; height: 40px; color: white;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- ═══ STATISTIK CARDS ═══ --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px;">

        <div style="background: #fff; border-radius: 18px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <p style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Total Peminjaman</p>
            <h2 style="font-size: 32px; font-weight: 800; color: #064e3b; margin: 10px 0 0;">{{ $totalPeminjaman }}</h2>
            <p style="font-size: 12px; color: #94a3b8; margin: 2px 0 0; font-weight: 600;">transaksi</p>
        </div>

        <div style="background: #fff; border-radius: 18px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <p style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Sedang Dipinjam</p>
            <h2 style="font-size: 32px; font-weight: 800; color: #1d4ed8; margin: 10px 0 0;">{{ $sedangDipinjam }}</h2>
            <p style="font-size: 12px; color: #94a3b8; margin: 2px 0 0; font-weight: 600;">aktif</p>
        </div>

        <div style="background: #fff; border-radius: 18px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <p style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Menunggu</p>
            <h2 style="font-size: 32px; font-weight: 800; color: #b45309; margin: 10px 0 0;">{{ $menungguPersetujuan }}</h2>
            <p style="font-size: 12px; color: #94a3b8; margin: 2px 0 0; font-weight: 600;">pengajuan</p>
        </div>

        <div style="background: #fff; border-radius: 18px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <p style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Sudah Kembali</p>
            <h2 style="font-size: 32px; font-weight: 800; color: #10b981; margin: 10px 0 0;">{{ $sudahDikembalikan }}</h2>
            <p style="font-size: 12px; color: #94a3b8; margin: 2px 0 0; font-weight: 600;">selesai</p>
        </div>

        <div style="background: #fff; border-radius: 18px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <p style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Ditolak</p>
            <h2 style="font-size: 32px; font-weight: 800; color: #dc2626; margin: 10px 0 0;">{{ $ditolak }}</h2>
            <p style="font-size: 12px; color: #94a3b8; margin: 2px 0 0; font-weight: 600;">pengajuan</p>
        </div>

        <div style="background: #fff; border-radius: 18px; padding: 20px; border: 1px solid #fed7aa; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <p style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Total Denda</p>
            <h2 style="font-size: 24px; font-weight: 800; color: #c2410c; margin: 10px 0 0;">
                Rp {{ number_format($totalDenda, 0, ',', '.') }}
            </h2>
            <p style="font-size: 12px; color: #94a3b8; margin: 2px 0 0; font-weight: 600;">keseluruhan</p>
        </div>

    </div>

    {{-- ═══ PEMINJAMAN AKTIF ═══ --}}
    @if($peminjamanAktif->count() > 0)
    <div style="background: #fff; border-radius: 20px; border: 1px solid #e2e8f0; padding: 28px;">
        <h3 style="font-size: 16px; font-weight: 800; color: #1e293b; margin: 0 0 18px 0; display: flex; align-items: center; gap: 10px;">
            <span style="width: 4px; height: 18px; background: #1d4ed8; border-radius: 10px;"></span>
            Peminjaman Aktif
        </h3>
        <div style="display: flex; flex-direction: column; gap: 10px;">
            @foreach($peminjamanAktif as $p)
            @php
                $today = \Carbon\Carbon::today();
                $rencana = \Carbon\Carbon::parse($p->tanggal_rencana_kembali);
                $terlambat = $today->gt($rencana);
                $hariSisa = $today->diffInDays($rencana, false);
            @endphp
            <div style="display: flex; align-items: center; gap: 14px; padding: 14px 16px; border-radius: 14px; border: 1.5px solid {{ $terlambat ? '#fecaca' : '#dcfce7' }}; background: {{ $terlambat ? '#fef2f2' : '#f0fdf4' }};">
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 4px;">
                        @foreach($p->buku as $b)
                        <span style="font-size: 13px; font-weight: 700; color: #1e293b;">{{ $b->nama_buku }}</span>
                        @if(!$loop->last)<span style="color: #94a3b8;">·</span>@endif
                        @endforeach
                    </div>
                    <p style="font-size: 12px; color: #64748b; margin: 0;">
                        Rencana kembali: <strong>{{ $rencana->format('d M Y') }}</strong>
                    </p>
                </div>
                <span style="font-size: 11px; font-weight: 800; padding: 5px 12px; border-radius: 10px; flex-shrink: 0;
                    {{ $terlambat ? 'background:#fee2e2;color:#991b1b;' : 'background:#dcfce7;color:#166534;' }}">
                    {{ $terlambat ? 'Terlambat ' . abs($hariSisa) . ' hari' : $hariSisa . ' hari lagi' }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ═══ BAWAH: Aksi Cepat + Info Akun ═══ --}}
    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 24px;">

        {{-- Aksi Cepat --}}
        <div style="background: #fff; border-radius: 20px; border: 1px solid #e2e8f0; padding: 28px;">
            <h3 style="font-size: 16px; font-weight: 800; color: #1e293b; margin: 0 0 18px 0; display: flex; align-items: center; gap: 10px;">
                <span style="width: 4px; height: 18px; background: #10b981; border-radius: 10px;"></span>
                Aksi Cepat
            </h3>
            <div style="display: grid; gap: 12px;">
                <a href="{{ route('peminjaman.tambah') }}"
                   style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-radius: 14px; background: #f0fdf4; border: 1.5px solid #dcfce7; color: #166534; text-decoration: none; font-weight: 700; transition: all 0.2s;"
                   onmouseover="this.style.background='#dcfce7'; this.style.transform='translateX(4px)'"
                   onmouseout="this.style.background='#f0fdf4'; this.style.transform='translateX(0)'">
                    <span style="display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 20px;">📚</span> Tambah Peminjaman Baru
                    </span>
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
                <a href="{{ route('peminjaman.riwayat') }}"
                   style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-radius: 14px; background: #f8fafc; border: 1.5px solid #f1f5f9; color: #475569; text-decoration: none; font-weight: 700; transition: all 0.2s;"
                   onmouseover="this.style.background='#f1f5f9'; this.style.transform='translateX(4px)'"
                   onmouseout="this.style.background='#f8fafc'; this.style.transform='translateX(0)'">
                    <span style="display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 20px;">📋</span> Lihat Riwayat Saya
                    </span>
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>

            {{-- Riwayat Terbaru --}}
            @if($riwayatTerbaru->count() > 0)
            <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid #f1f5f9;">
                <p style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 12px 0;">Aktivitas Terbaru</p>
                <div style="display: flex; flex-direction: column; gap: 8px;">
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
                        <div>
                            <p style="font-size:12px;font-weight:700;color:#1e293b;margin:0;">
                                #{{ $r->id }} · {{ $r->tanggal_pinjam->format('d M Y') }}
                            </p>
                            <p style="font-size:11px;color:#94a3b8;margin:2px 0 0;">
                                {{ $r->buku->pluck('nama_buku')->implode(', ') }}
                            </p>
                        </div>
                        <span style="font-size:10px;font-weight:700;padding:3px 8px;border-radius:8px;{{ $badgeStyle }};flex-shrink:0;margin-left:8px;">
                            {{ $r->statusLabel() }}
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Informasi Akun --}}
        <div style="background: #fff; border-radius: 20px; border: 1px solid #e2e8f0; padding: 28px;">
            <h3 style="font-size: 16px; font-weight: 800; color: #1e293b; margin: 0 0 18px 0; display: flex; align-items: center; gap: 10px;">
                <span style="width: 4px; height: 18px; background: #64748b; border-radius: 10px;"></span>
                Informasi Akun
            </h3>
            <div style="display: flex; flex-direction: column; gap: 14px;">

                <div style="padding-bottom: 12px; border-bottom: 1px dashed #e2e8f0;">
                    <p style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin: 0 0 4px 0;">Nama Lengkap</p>
                    <p style="font-size: 14px; font-weight: 600; color: #1e293b; margin: 0;">{{ $user->name }}</p>
                </div>

                <div style="padding-bottom: 12px; border-bottom: 1px dashed #e2e8f0;">
                    <p style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin: 0 0 4px 0;">Email</p>
                    <p style="font-size: 14px; font-weight: 600; color: #1e293b; margin: 0;">{{ $user->email }}</p>
                </div>

                @if($user->nisn)
                <div style="padding-bottom: 12px; border-bottom: 1px dashed #e2e8f0;">
                    <p style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin: 0 0 4px 0;">NISN</p>
                    <p style="font-size: 14px; font-weight: 600; color: #1e293b; margin: 0;">{{ $user->nisn }}</p>
                </div>
                @endif

                @if($user->kelas || $user->jurusan)
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; padding-bottom: 12px; border-bottom: 1px dashed #e2e8f0;">
                    <div>
                        <p style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin: 0 0 4px 0;">Kelas</p>
                        <p style="font-size: 14px; font-weight: 600; color: #1e293b; margin: 0;">{{ $user->kelas ?? '-' }}</p>
                    </div>
                    <div>
                        <p style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin: 0 0 4px 0;">Jurusan</p>
                        <p style="font-size: 14px; font-weight: 600; color: #1e293b; margin: 0;">{{ $user->jurusan ?? '-' }}</p>
                    </div>
                </div>
                @endif

                {{-- Rekap Mini --}}
                <div style="background: #f8fafc; border-radius: 14px; padding: 14px; display: flex; flex-direction: column; gap: 8px;">
                    <p style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin: 0 0 4px 0;">Rekap Peminjaman</p>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 12px; color: #64748b; font-weight: 600;">Proses Kembali</span>
                        <span style="font-size: 13px; font-weight: 800; color: #6b21a8;">{{ $prosesKembali }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 12px; color: #64748b; font-weight: 600;">Selesai</span>
                        <span style="font-size: 13px; font-weight: 800; color: #10b981;">{{ $sudahDikembalikan }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 12px; color: #64748b; font-weight: 600;">Total Denda</span>
                        <span style="font-size: 13px; font-weight: 800; color: #c2410c;">
                            Rp {{ number_format($totalDenda, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection