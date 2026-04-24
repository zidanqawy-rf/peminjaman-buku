{{-- resources/views/user/peminjaman/riwayat.blade.php --}}
@extends('layouts.app')

@section('header')
    Riwayat Peminjaman
@endsection

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="riwayat-wrap">

    {{-- Page Header --}}
    <div class="page-header-row">
        <div>
            <p class="breadcrumb-text">Perpustakaan › Aktivitas</p>
            <h1 class="page-title">Riwayat Peminjaman</h1>
            <p class="page-subtitle">Pantau status peminjaman dan tenggat waktu buku Anda.</p>
        </div>
        <a href="{{ route('peminjaman.tambah') }}" class="btn-pinjam-baru">
            <svg style="width:17px;height:17px;flex-shrink:0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            <span class="btn-label-full">Pinjam Buku Baru</span>
            <span class="btn-label-short">Pinjam</span>
        </a>
    </div>

    {{-- Stats Cards --}}
    @php
        $total    = $peminjaman->total();
        $menunggu = $peminjaman->getCollection()->where('status', 'pengajuan')->count();
        $aktif    = $peminjaman->getCollection()->where('status', 'disetujui')->count();
        $selesai  = $peminjaman->getCollection()->where('status', 'dikembalikan')->count();
    @endphp
    <div class="stats-row">
        <div class="stat-card stat-default">
            <div class="stat-icon" style="background:#f8fafc;border:1.5px solid #f1f5f9;">
                <svg style="width:20px;height:20px;color:#64748b" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Total</p>
                <p class="stat-num" style="color:#1e293b;">{{ $total }}</p>
            </div>
        </div>

        <div class="stat-card" style="border-color:#fef9c3;">
            <div class="stat-icon" style="background:#fffbeb;">
                <svg style="width:20px;height:20px;color:#d97706" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="stat-label" style="color:#d97706;">Menunggu</p>
                <p class="stat-num" style="color:#92400e;">{{ $menunggu }}</p>
            </div>
        </div>

        <div class="stat-card" style="border-color:#dcfce7;">
            <div class="stat-icon" style="background:#ecfdf5;">
                <svg style="width:20px;height:20px;color:#10b981" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
            </div>
            <div>
                <p class="stat-label" style="color:#059669;">Dipinjam</p>
                <p class="stat-num" style="color:#064e3b;">{{ $aktif }}</p>
            </div>
        </div>

        <div class="stat-card stat-default">
            <div class="stat-icon" style="background:#f1f5f9;border:1px solid #e2e8f0;">
                <svg style="width:20px;height:20px;color:#94a3b8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Selesai</p>
                <p class="stat-num" style="color:#475569;">{{ $selesai }}</p>
            </div>
        </div>
    </div>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('peminjaman.riwayat') }}" class="filter-form">
        <div class="filter-search">
            <label class="filter-label">Cari Judul Buku</label>
            <div style="position:relative;">
                <svg style="position:absolute;left:13px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:#94a3b8;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik judul buku..."
                    style="width:100%;padding:11px 12px 11px 40px;border-radius:12px;border:1.5px solid #e2e8f0;font-size:14px;outline:none;box-sizing:border-box;background:#f8fafc;"
                    onfocus="this.style.borderColor='#10b981';this.style.background='#fff'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'">
            </div>
        </div>

        <div class="filter-date">
            <label class="filter-label">Tanggal Pinjam</label>
            <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                style="width:100%;padding:10px 12px;border-radius:12px;border:1.5px solid #e2e8f0;font-size:14px;outline:none;box-sizing:border-box;color:#475569;background:#f8fafc;font-weight:600;"
                onfocus="this.style.borderColor='#10b981';this.style.background='#fff'"
                onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'">
        </div>

        <div class="filter-actions">
            <button type="submit" style="padding:11px 20px;border-radius:12px;background:#1e293b;border:none;color:#fff;font-size:13px;font-weight:700;cursor:pointer;white-space:nowrap;transition:all .15s;"
                onmouseover="this.style.background='#0f172a'" onmouseout="this.style.background='#1e293b'">
                Terapkan
            </button>
            @if(request('search') || request('tanggal'))
            <a href="{{ route('peminjaman.riwayat') }}"
                style="padding:11px 16px;border-radius:12px;background:#fef2f2;color:#dc2626;font-size:13px;text-decoration:none;font-weight:700;white-space:nowrap;transition:all .2s;"
                onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#fef2f2'">
                Reset
            </a>
            @endif
        </div>
    </form>

    {{-- List Peminjaman --}}
    <div style="display:flex;flex-direction:column;gap:14px;">

        @forelse($peminjaman as $item)
        @php
            $statusMap = [
                'pengajuan'         => ['label' => 'Menunggu',  'bg' => '#fef9c3', 'color' => '#854d0e'],
                'disetujui'         => ['label' => 'Dipinjam',  'bg' => '#dcfce7', 'color' => '#166534'],
                'ditolak'           => ['label' => 'Ditolak',   'bg' => '#fef2f2', 'color' => '#991b1b'],
                'pengajuan_kembali' => ['label' => 'Verifikasi','bg' => '#f3f4f6', 'color' => '#374151'],
                'dikembalikan'      => ['label' => 'Selesai',   'bg' => '#f0fdf4', 'color' => '#15803d'],
            ];
            $s = $statusMap[$item->status] ?? ['label' => ucfirst($item->status), 'bg' => '#f1f5f9', 'color' => '#64748b'];
            $terlambat = $item->hariTerlambat();
        @endphp

        <div class="pinjam-card" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">

            {{-- Card Header --}}
            <div class="card-header-row">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:38px;height:38px;border-radius:11px;background:#fff;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 4px rgba(0,0,0,.05);flex-shrink:0;">
                        <span style="font-weight:800;color:#10b981;font-size:13px;">#</span>
                    </div>
                    <div>
                        <p style="font-size:14px;font-weight:800;color:#1e293b;margin:0;">ID Pinjam {{ $item->id }}</p>
                        <p class="card-date">{{ $item->tanggal_pinjam->format('d M Y') }}</p>
                    </div>
                </div>
                <div class="badge-group">
                    @if($terlambat > 0 && $item->status === 'disetujui')
                    <span class="badge-terlambat">⚠ {{ $terlambat }}h</span>
                    @endif
                    <span class="badge-status" style="background:{{ $s['bg'] }};color:{{ $s['color'] }};">
                        <span style="width:6px;height:6px;border-radius:50%;background:{{ $s['color'] }};display:inline-block;flex-shrink:0;"></span>
                        {{ $s['label'] }}
                    </span>
                </div>
            </div>

            {{-- Buku --}}
            <div style="padding:16px 20px;display:flex;flex-direction:column;gap:8px;">
                <p style="font-size:11px;font-weight:800;color:#94a3b8;text-transform:uppercase;margin:0;">Daftar Buku</p>
                <div style="display:flex;flex-wrap:wrap;gap:8px;">
                    @foreach($item->buku as $bk)
                    <div style="display:inline-flex;align-items:center;gap:7px;padding:7px 12px;border-radius:10px;background:#f8fafc;border:1px solid #f1f5f9;">
                        <svg style="width:13px;height:13px;color:#10b981;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
                        </svg>
                        <span style="font-size:13px;font-weight:700;color:#334155;">{{ $bk->nama_buku }}</span>
                        <span style="font-size:11px;font-weight:800;background:#e2e8f0;color:#475569;padding:1px 6px;border-radius:5px;">{{ $bk->pivot->jumlah }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Footer --}}
            <div class="card-footer-row">
                <div class="card-dates">
                    <div>
                        <p style="font-size:10px;color:#94a3b8;font-weight:700;margin:0;text-transform:uppercase;">Wajib Kembali</p>
                        <p style="font-size:13px;font-weight:800;color:{{ $terlambat > 0 && $item->status === 'disetujui' ? '#dc2626' : '#1e293b' }};margin:3px 0 0;">
                            {{ $item->tanggal_rencana_kembali->format('d M Y') }}
                        </p>
                    </div>
                    @if($item->tanggal_kembali)
                    <div>
                        <p style="font-size:10px;color:#94a3b8;font-weight:700;margin:0;text-transform:uppercase;">Kembali</p>
                        <p style="font-size:13px;font-weight:800;color:#10b981;margin:3px 0 0;">{{ $item->tanggal_kembali->format('d M Y') }}</p>
                    </div>
                    @endif
                </div>

                <a href="{{ route('peminjaman.show', $item) }}" class="btn-detail {{ $item->status === 'disetujui' ? 'btn-detail-active' : 'btn-detail-plain' }}">
                    @if($item->status === 'disetujui')
                        <span class="btn-detail-full">Proses Pengembalian</span>
                        <span class="btn-detail-short">Kembalikan</span>
                    @else
                        <span class="btn-detail-full">Lihat Detail</span>
                        <span class="btn-detail-short">Detail</span>
                    @endif
                    <svg style="width:13px;height:13px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

        </div>
        @empty
        <div style="background:#fff;border-radius:24px;border:2px dashed #e2e8f0;padding:60px 24px;text-align:center;">
            <div style="width:72px;height:72px;border-radius:50%;background:#f8fafc;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <svg style="width:32px;height:32px;color:#cbd5e1;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
            </div>
            <h3 style="font-size:17px;font-weight:800;color:#1e293b;margin:0;">Belum ada aktivitas</h3>
            <p style="font-size:13px;color:#94a3b8;margin-top:6px;max-width:280px;margin-left:auto;margin-right:auto;">Anda belum memiliki riwayat peminjaman atau pencarian tidak cocok.</p>
        </div>
        @endforelse

    </div>

    {{-- Pagination --}}
    @if($peminjaman->hasPages())
    <div style="display:flex;justify-content:center;margin-top:8px;">
        {{ $peminjaman->appends(request()->query())->links() }}
    </div>
    @endif

</div>{{-- /riwayat-wrap --}}

<style>
/* ─── Wrapper ─────────────────────────────────────────────── */
.riwayat-wrap {
    padding: 20px;
    max-width: 1100px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* ─── Page header ─────────────────────────────────────────── */
.page-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
}
.breadcrumb-text { font-size:11px;color:#94a3b8;margin-bottom:4px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px; }
.page-title      { font-size:22px;font-weight:800;color:#064e3b;margin:0;letter-spacing:-0.025em; }
.page-subtitle   { font-size:13px;color:#64748b;margin-top:3px;margin-bottom:0; }

.btn-pinjam-baru {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 11px 20px;
    border-radius: 13px;
    color: #fff;
    font-size: 13px;
    font-weight: 800;
    background: linear-gradient(135deg,#10b981,#059669);
    box-shadow: 0 4px 14px rgba(16,185,129,.3);
    text-decoration: none;
    transition: all .2s;
    white-space: nowrap;
    flex-shrink: 0;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}
.btn-pinjam-baru:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(16,185,129,.4); }
.btn-label-short { display: none; }

/* ─── Stats ───────────────────────────────────────────────── */
.stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
}
.stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 18px 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,.04);
    display: flex;
    align-items: center;
    gap: 14px;
}
.stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.stat-label {
    font-size: 10px;
    color: #94a3b8;
    font-weight: 800;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.stat-num {
    font-size: 24px;
    font-weight: 800;
    line-height: 1;
    margin: 4px 0 0;
}

/* ─── Filter ──────────────────────────────────────────────── */
.filter-form {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #e2e8f0;
    padding: 18px 20px;
    display: flex;
    gap: 14px;
    align-items: flex-end;
    box-shadow: 0 4px 15px rgba(0,0,0,.02);
}
.filter-search { flex: 2; }
.filter-date   { flex: 1; }
.filter-label {
    display: block;
    font-size: 11px;
    font-weight: 800;
    color: #64748b;
    margin-bottom: 7px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.filter-actions { display: flex; gap: 8px; align-items: center; }

/* ─── Peminjaman card ─────────────────────────────────────── */
.pinjam-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0,0,0,.03);
    overflow: hidden;
    transition: transform .2s;
}
.card-header-row {
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fafafa;
    gap: 10px;
    flex-wrap: wrap;
}
.card-date { font-size:12px;color:#94a3b8;margin:2px 0 0;font-weight:600; }
.badge-group {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}
.badge-terlambat {
    font-size: 11px;
    font-weight: 800;
    padding: 4px 10px;
    border-radius: 9px;
    background: #991b1b;
    color: #fff;
    animation: pulse 2s infinite;
    white-space: nowrap;
}
.badge-status {
    font-size: 11px;
    font-weight: 800;
    padding: 5px 12px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
}

.card-footer-row {
    padding: 14px 20px;
    background: #f8fafc;
    border-top: 1px dashed #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
}
.card-dates { display: flex; gap: 24px; }

.btn-detail {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 18px;
    border-radius: 11px;
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
    transition: all .2s;
    white-space: nowrap;
    flex-shrink: 0;
}
.btn-detail:hover { transform: translateX(3px); }
.btn-detail-active { background: linear-gradient(135deg,#10b981,#059669); color: #fff; box-shadow: 0 4px 10px rgba(16,185,129,.2); }
.btn-detail-plain  { background: #fff; color: #475569; border: 1.5px solid #e2e8f0; }
.btn-detail-short  { display: none; }

@keyframes pulse {
    0%   { opacity: 1; }
    50%  { opacity: .7; }
    100% { opacity: 1; }
}

/* ─── MOBILE ────────────────────────────────────────────────── */
@media (max-width: 767px) {
    .riwayat-wrap   { padding: 12px; gap: 12px; }
    .page-title     { font-size: 18px; }
    .page-subtitle  { display: none; }

    /* Button: shorter label */
    .btn-label-full  { display: none; }
    .btn-label-short { display: inline; }
    .btn-pinjam-baru { padding: 10px 14px; font-size: 12px; }

    /* Stats: 2×2 */
    .stats-row { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .stat-card { padding: 14px 12px; gap: 10px; }
    .stat-icon { width: 38px; height: 38px; }
    .stat-num  { font-size: 20px; }

    /* Filter: stack vertically */
    .filter-form {
        flex-direction: column;
        gap: 12px;
        align-items: stretch;
        padding: 14px 16px;
    }
    .filter-search { flex: none; }
    .filter-date   { flex: none; }
    .filter-actions { flex-direction: row; }

    /* Card */
    .card-header-row { padding: 12px 14px; }
    .card-date       { font-size: 11px; }
    .badge-terlambat { font-size: 10px; padding: 3px 7px; }
    .badge-status    { font-size: 10px; padding: 4px 10px; }

    .card-footer-row { flex-direction: column; align-items: flex-start; padding: 12px 14px; gap: 10px; }
    .card-dates      { gap: 16px; }

    /* Button shorter label */
    .btn-detail-full  { display: none; }
    .btn-detail-short { display: inline; }
    .btn-detail { padding: 8px 14px; font-size: 12px; align-self: flex-end; }
}
</style>

@if(session('success'))
<script>
Swal.fire({
    toast: true, position: 'top-end', icon: 'success',
    title: '{{ session('success') }}',
    showConfirmButton: false, timer: 3000, timerProgressBar: true,
    background: '#f0fdf4', color: '#15803d'
});
</script>
@endif

@endsection