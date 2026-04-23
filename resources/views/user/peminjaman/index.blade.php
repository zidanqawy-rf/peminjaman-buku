{{-- resources/views/user/peminjaman/riwayat.blade.php --}}
@extends('layouts.app')

@section('header')
    Riwayat Peminjaman
@endsection

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div style="display:flex;flex-direction:column;gap:24px; max-width: 1100px; margin: 0 auto; padding: 10px;">

    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between">
        <div>
            <p style="font-size:11px;color:#94a3b8;margin-bottom:4px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Perpustakaan › Aktivitas</p>
            <h1 style="font-size:24px;font-weight:800;color:#064e3b;margin:0; letter-spacing: -0.025em;">Riwayat Peminjaman</h1>
            <p style="font-size:14px;color:#64748b;margin-top:3px">Pantau status peminjaman dan tenggat waktu buku Anda.</p>
        </div>
        <a href="{{ route('peminjaman.tambah') }}"
            style="display:flex;align-items:center;gap:10px;padding:12px 24px;border-radius:14px;border:none;cursor:pointer;color:#fff;font-size:14px;font-weight:800;background:linear-gradient(135deg,#10b981,#059669);box-shadow:0 4px 14px rgba(16,185,129,.3);text-decoration:none;transition:all .2s; text-transform: uppercase; letter-spacing: 0.5px;"
            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(16,185,129,.4)'" 
            onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 14px rgba(16,185,129,.3)'">
            <svg style="width:18px;height:18px" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Pinjam Buku Baru
        </a>
    </div>

    {{-- Stats Cards --}}
    @php
        $total      = $peminjaman->total();
        $menunggu   = $peminjaman->getCollection()->where('status', 'pengajuan')->count();
        $aktif      = $peminjaman->getCollection()->where('status', 'disetujui')->count();
        $selesai    = $peminjaman->getCollection()->where('status', 'dikembalikan')->count();
    @endphp
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px">
        {{-- Card Total --}}
        <div style="background:#fff;border-radius:18px;padding:20px;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(0,0,0,.04);display:flex;align-items:center;gap:16px">
            <div style="width:48px;height:48px;border-radius:12px;background:#f8fafc;display:flex;align-items:center;justify-content:center;flex-shrink:0; border: 1.5px solid #f1f5f9;">
                <svg style="width:22px;height:22px;color:#64748b" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p style="font-size:11px;color:#94a3b8;font-weight:800;margin:0; text-transform: uppercase;">Total</p>
                <p style="font-size:26px;font-weight:800;color:#1e293b;line-height:1;margin:4px 0 0">{{ $total }}</p>
            </div>
        </div>
        {{-- Card Menunggu --}}
        <div style="background:#fff;border-radius:18px;padding:20px;border:1px solid #fef9c3;box-shadow:0 4px 6px -1px rgba(254,249,195,0.4);display:flex;align-items:center;gap:16px">
            <div style="width:48px;height:48px;border-radius:12px;background:#fffbeb;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:22px;height:22px;color:#d97706" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p style="font-size:11px;color:#d97706;font-weight:800;margin:0; text-transform: uppercase;">Menunggu</p>
                <p style="font-size:26px;font-weight:800;color:#92400e;line-height:1;margin:4px 0 0">{{ $menunggu }}</p>
            </div>
        </div>
        {{-- Card Dipinjam --}}
        <div style="background:#fff;border-radius:18px;padding:20px;border:1px solid #dcfce7;box-shadow:0 4px 6px -1px rgba(220,252,231,0.4);display:flex;align-items:center;gap:16px">
            <div style="width:48px;height:48px;border-radius:12px;background:#ecfdf5;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:22px;height:22px;color:#10b981" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
            </div>
            <div>
                <p style="font-size:11px;color:#059669;font-weight:800;margin:0; text-transform: uppercase;">Dipinjam</p>
                <p style="font-size:26px;font-weight:800;color:#064e3b;line-height:1;margin:4px 0 0">{{ $aktif }}</p>
            </div>
        </div>
        {{-- Card Selesai --}}
        <div style="background:#fff;border-radius:18px;padding:20px;border:1px solid #e2e8f0;display:flex;align-items:center;gap:16px">
            <div style="width:48px;height:48px;border-radius:12px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:22px;height:22px;color:#94a3b8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p style="font-size:11px;color:#94a3b8;font-weight:800;margin:0; text-transform: uppercase;">Selesai</p>
                <p style="font-size:26px;font-weight:800;color:#475569;line-height:1;margin:4px 0 0">{{ $selesai }}</p>
            </div>
        </div>
    </div>

    {{-- Filter Seksi --}}
    <form method="GET" action="{{ route('peminjaman.riwayat') }}" 
        style="background:#fff;border-radius:20px;border:1px solid #e2e8f0;padding:20px;display:flex;gap:16px;align-items:flex-end;box-shadow:0 10px 15px -3px rgba(0,0,0,0.02)">
        
        <div style="flex:2">
            <label style="display:block;font-size:11px;font-weight:800;color:#64748b;margin-bottom:8px;text-transform:uppercase; letter-spacing: 0.5px;">Cari Judul Buku</label>
            <div style="position:relative">
                <svg style="position:absolute;left:14px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik judul buku..."
                    style="width:100%;padding:12px 12px 12px 42px;border-radius:12px;border:1.5px solid #e2e8f0;font-size:14px;outline:none;box-sizing:border-box; background: #f8fafc; transition: all 0.2s;"
                    onfocus="this.style.borderColor='#10b981'; this.style.background='#fff'">
            </div>
        </div>

        <div style="flex:1">
            <label style="display:block;font-size:11px;font-weight:800;color:#64748b;margin-bottom:8px;text-transform:uppercase; letter-spacing: 0.5px;">Tanggal Pinjam</label>
            <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                style="width:100%;padding:11px 12px;border-radius:12px;border:1.5px solid #e2e8f0;font-size:14px;outline:none;box-sizing:border-box;color:#475569; background: #f8fafc; font-weight: 600;"
                onfocus="this.style.borderColor='#10b981'; this.style.background='#fff'">
        </div>

        <button type="submit" 
            style="padding:12px 24px;border-radius:12px;background:#1e293b;border:none;color:#fff;font-size:14px;font-weight:700;cursor:pointer;transition:all .15s"
            onmouseover="this.style.background='#0f172a'" onmouseout="this.style.background='#1e293b'">
            Terapkan Filter
        </button>

        @if(request('search') || request('tanggal'))
        <a href="{{ route('peminjaman.riwayat') }}" 
            style="padding:12px 18px;border-radius:12px;background:#fef2f2;color:#dc2626;font-size:14px;text-decoration:none;font-weight:700; transition: all 0.2s;"
            onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#fef2f2'">
            Reset
        </a>
        @endif
    </form>

    {{-- List Peminjaman --}}
    <div style="display:flex;flex-direction:column;gap:16px">

        @forelse($peminjaman as $item)
        @php
            $statusMap = [
                'pengajuan'         => ['label' => 'Menunggu Persetujuan', 'bg' => '#fef9c3', 'color' => '#854d0e', 'icon' => 'clock'],
                'disetujui'         => ['label' => 'Sedang Dipinjam',      'bg' => '#dcfce7', 'color' => '#166534', 'icon' => 'book-open'],
                'ditolak'           => ['label' => 'Pengajuan Ditolak',    'bg' => '#fef2f2', 'color' => '#991b1b', 'icon' => 'x-circle'],
                'pengajuan_kembali' => ['label' => 'Proses Verifikasi',    'bg' => '#f3f4f6', 'color' => '#374151', 'icon' => 'refresh'],
                'dikembalikan'      => ['label' => 'Selesai Dikembalikan', 'bg' => '#f0fdf4', 'color' => '#15803d', 'icon' => 'check-circle'],
            ];
            $s = $statusMap[$item->status] ?? ['label' => ucfirst($item->status), 'bg' => '#f1f5f9', 'color' => '#64748b', 'icon' => 'info'];
            $terlambat = $item->hariTerlambat();
        @endphp

        <div style="background:#fff;border-radius:20px;border:1px solid #e2e8f0;box-shadow:0 4px 6px -1px rgba(0,0,0,0.02);overflow:hidden; transition: transform 0.2s;"
             onmouseover="this.style.transform='scale(1.005)'" onmouseout="this.style.transform='none'">

            {{-- Card Header --}}
            <div style="padding:18px 24px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between; background: #fafafa;">
                <div style="display:flex;align-items:center;gap:14px">
                    <div style="width:40px;height:40px;border-radius:12px;background:#fff;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <span style="font-weight: 800; color: #10b981; font-size: 14px;">#</span>
                    </div>
                    <div>
                        <p style="font-size:15px;font-weight:800;color:#1e293b;margin:0">ID Pinjam {{ $item->id }}</p>
                        <p style="font-size:12px;color:#94a3b8;margin:2px 0 0; font-weight: 600;">{{ $item->tanggal_pinjam->format('l, d M Y') }}</p>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:10px">
                    @if($terlambat > 0 && in_array($item->status, ['disetujui']))
                    <span style="font-size:11px;font-weight:800;padding:5px 12px;border-radius:10px;background:#991b1b;color:#fff; text-transform: uppercase; animation: pulse 2s infinite;">
                        ⚠ Terlambat {{ $terlambat }} Hari
                    </span>
                    @endif
                    <span style="font-size:12px;font-weight:800;padding:6px 14px;border-radius:12px;background:{{ $s['bg'] }};color:{{ $s['color'] }}; display: flex; align-items: center; gap: 6px;">
                        <span style="width:6px;height:6px;border-radius:50%;background:{{ $s['color'] }}"></span>
                        {{ $s['label'] }}
                    </span>
                </div>
            </div>

            {{-- Buku --}}
            <div style="padding:20px 24px; display: flex; flex-direction: column; gap: 10px;">
                <p style="font-size:11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin: 0;">Daftar Buku:</p>
                <div style="display:flex;flex-wrap:wrap;gap:10px">
                    @foreach($item->buku as $bk)
                    <div style="display:inline-flex;align-items:center;gap:8px;padding:8px 14px;border-radius:12px;background:#f8fafc;border:1px solid #f1f5f9; transition: all 0.2s;"
                         onmouseover="this.style.borderColor='#10b981'; this.style.background='#fff'">
                        <svg style="width:14px;height:14px;color:#10b981;flex-shrink:0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
                        </svg>
                        <span style="font-size:13px;font-weight:700;color:#334155">{{ $bk->nama_buku }}</span>
                        <span style="font-size:12px;font-weight:800;background:#e2e8f0; color:#475569; padding: 2px 6px; border-radius: 6px;">{{ $bk->pivot->jumlah }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Footer Info --}}
            <div style="padding:16px 24px;background:#f8fafc;display:flex;align-items:center;justify-content:space-between; border-top: 1px dashed #e2e8f0;">
                <div style="display:flex;gap:32px">
                    <div>
                        <p style="font-size:11px;color:#94a3b8;font-weight:700;margin:0; text-transform: uppercase;">Wajib Kembali</p>
                        <p style="font-size:14px;font-weight:800;color:{{ $terlambat > 0 && $item->status === 'disetujui' ? '#dc2626' : '#1e293b' }};margin:4px 0 0">
                            {{ $item->tanggal_rencana_kembali->format('d M Y') }}
                        </p>
                    </div>
                    @if($item->tanggal_kembali)
                    <div>
                        <p style="font-size:11px;color:#94a3b8;font-weight:700;margin:0; text-transform: uppercase;">Realisasi Kembali</p>
                        <p style="font-size:14px;font-weight:800;color:#10b981;margin:4px 0 0">{{ $item->tanggal_kembali->format('d M Y') }}</p>
                    </div>
                    @endif
                </div>

                <a href="{{ route('peminjaman.show', $item) }}"
                    style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:12px;background:{{ $item->status === 'disetujui' ? 'linear-gradient(135deg,#10b981,#059669)' : '#fff' }};color:{{ $item->status === 'disetujui' ? '#fff' : '#475569' }};font-size:13px;font-weight:800;text-decoration:none;box-shadow:{{ $item->status === 'disetujui' ? '0 4px 10px rgba(16,185,129,.2)' : 'none' }}; border: {{ $item->status === 'disetujui' ? 'none' : '1.5px solid #e2e8f0' }}; transition: all 0.2s;"
                    onmouseover="this.style.transform='translateX(3px)'" onmouseout="this.style.transform='none'">
                    @if($item->status === 'disetujui')
                        Proses Pengembalian
                    @else
                        Lihat Detail
                    @endif
                    <svg style="width:14px;height:14px" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

        </div>
        @empty
        <div style="background:#fff;border-radius:24px;border:2px dashed #e2e8f0;padding:80px 24px;text-align:center">
            <div style="width:80px;height:80px;border-radius:50%;background:#f8fafc;display:flex;align-items:center;justify-content:center;margin:0 auto 20px">
                <svg style="width:36px;height:36px;color:#cbd5e1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
            </div>
            <h3 style="font-size:18px;font-weight:800;color:#1e293b;margin:0">Belum ada aktivitas</h3>
            <p style="font-size:14px;color:#94a3b8;margin-top:6px; max-width: 300px; margin-left: auto; margin-right: auto;">Anda belum memiliki riwayat peminjaman buku atau pencarian tidak cocok.</p>
        </div>
        @endforelse

    </div>

    {{-- Pagination --}}
    @if($peminjaman->hasPages())
    <div style="display:flex;justify-content:center;margin-top:16px">
        {{ $peminjaman->appends(request()->query())->links() }}
    </div>
    @endif

</div>

<style>
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }
</style>

@if(session('success'))
<script>
Swal.fire({
    toast: true, position: 'top-end', icon: 'success',
    title: '{{ session('success') }}',
    showConfirmButton: false, timer: 3000, timerProgressBar: true,
    background: '#f0fdf4',
    color: '#15803d'
});
</script>
@endif

@endsection