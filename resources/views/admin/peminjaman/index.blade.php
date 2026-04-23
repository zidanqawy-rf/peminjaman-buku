@extends('layouts.app-admin')

@section('content')
<div style="display:flex;flex-direction:column;gap:20px;padding:20px">

    {{-- Header --}}
    <div style="display:flex;justify-content:space-between;align-items:flex-start">
        <div>
            <h1 style="font-size:20px;font-weight:800;color:#1e293b">Daftar Peminjaman</h1>
            <p style="font-size:13px;color:#94a3b8;margin-top:3px">Kelola semua pengajuan dan pengembalian buku</p>
        </div>

        {{-- Tombol Cetak PDF — membawa filter yang sedang aktif --}}
        <a href="{{ route('admin.peminjaman.exportPdf', request()->only(['search','status','tgl_mulai','tgl_selesai'])) }}"
           target="_blank"
           style="display:inline-flex;align-items:center;gap:8px;
                  background:linear-gradient(135deg,#ef4444,#dc2626);
                  color:#fff;border-radius:10px;padding:10px 18px;
                  font-size:13px;font-weight:700;text-decoration:none;
                  box-shadow:0 2px 8px rgba(220,38,38,.25);
                  transition:opacity .2s"
           onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                <rect x="6" y="14" width="12" height="8" rx="1"/>
            </svg>
            Cetak PDF
        </a>
    </div>

    {{-- Kartu Statistik --}}
    <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:14px">
        @php
            $stats = [
                ['label'=>'Pengajuan Masuk', 'val'=> $totalPengajuan, 'color'=>'#f59e0b'],
                ['label'=>'Disetujui', 'val'=> \App\Models\Peminjaman::where('status','disetujui')->count(), 'color'=>'#3b82f6'],
                ['label'=>'Proses Kembali', 'val'=> $totalKembali, 'color'=>'#a855f7'],
                ['label'=>'Dikembalikan', 'val'=> \App\Models\Peminjaman::where('status','dikembalikan')->count(), 'color'=>'#22c55e'],
                ['label'=>'Ditolak', 'val'=> \App\Models\Peminjaman::where('status','ditolak')->count(), 'color'=>'#ef4444'],
            ];
        @endphp
        @foreach($stats as $s)
        <div style="background:#fff;border-radius:14px;padding:18px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.04)">
            <p style="font-size:11px;color:#94a3b8;font-weight:600;margin-bottom:8px">{{ $s['label'] }}</p>
            <p style="font-size:30px;font-weight:800;color:{{ $s['color'] }};line-height:1">{{ $s['val'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Filter & Search --}}
    <div style="background:#fff;border-radius:16px;padding:18px 20px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.04)">
        <form method="GET" action="{{ route('admin.peminjaman.index') }}"
              style="display:flex;gap:12px;flex-wrap:wrap;align-items:center">

            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="🔍 Cari nama siswa..."
                style="flex:1;min-width:180px;border:1.5px solid #e2e8f0;border-radius:10px;padding:9px 14px;font-size:13px;color:#1e293b;background:#f8fafc;outline:none">

            <select name="status"
                style="border:1.5px solid #e2e8f0;border-radius:10px;padding:9px 14px;font-size:13px;color:#475569;background:#f8fafc;outline:none;cursor:pointer">
                <option value="">Semua Status</option>
                <option value="pengajuan"          {{ request('status')=='pengajuan'?'selected':'' }}>Pengajuan</option>
                <option value="disetujui"          {{ request('status')=='disetujui'?'selected':'' }}>Disetujui</option>
                <option value="pengajuan_kembali"  {{ request('status')=='pengajuan_kembali'?'selected':'' }}>Proses Kembali</option>
                <option value="dikembalikan"       {{ request('status')=='dikembalikan'?'selected':'' }}>Dikembalikan</option>
                <option value="ditolak"            {{ request('status')=='ditolak'?'selected':'' }}>Ditolak</option>
            </select>

            <div style="display:flex;align-items:center;gap:8px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:10px;padding:4px 10px">
                <span style="font-size:12px;color:#94a3b8">Dari:</span>
                <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}"
                    style="border:none;background:transparent;font-size:13px;color:#475569;outline:none">
                <span style="font-size:12px;color:#94a3b8">Sampai:</span>
                <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}"
                    style="border:none;background:transparent;font-size:13px;color:#475569;outline:none">
            </div>

            <button type="submit"
                style="background:linear-gradient(135deg,#3b82f6,#2563eb);color:#fff;border:none;border-radius:10px;padding:9px 20px;font-size:13px;font-weight:700;cursor:pointer">
                Terapkan Filter
            </button>

            @if(request()->hasAny(['search','status','tgl_mulai','tgl_selesai']))
            <a href="{{ route('admin.peminjaman.index') }}"
                style="color:#94a3b8;font-size:13px;text-decoration:none;padding:9px 14px">Reset</a>
            @endif
        </form>
    </div>

    {{-- Tabel Data --}}
    <div style="background:#fff;border-radius:16px;border:1px solid #e2e8f0;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,.04)">
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="background:#f8fafc;border-bottom:1px solid #e2e8f0">
                    <th style="text-align:left;padding:14px 16px;font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase">#</th>
                    <th style="text-align:left;padding:14px 16px;font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase">SISWA</th>
                    <th style="text-align:left;padding:14px 16px;font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase">BUKU</th>
                    <th style="text-align:left;padding:14px 16px;font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase">TGL PINJAM</th>
                    <th style="text-align:left;padding:14px 16px;font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase">STATUS</th>
                    <th style="text-align:center;padding:14px 16px;font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $item)
                <tr style="border-bottom:1px solid #f1f5f9" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <td style="padding:14px 16px;font-size:13px;color:#94a3b8">#{{ $item->id }}</td>
                    <td style="padding:14px 16px">
                        <p style="font-size:13px;font-weight:700;color:#1e293b">{{ $item->user->name }}</p>
                        <p style="font-size:11px;color:#94a3b8">{{ $item->user->kelas ?? 'XII' }}</p>
                    </td>
                    <td style="padding:14px 16px">
                        <span style="background:#f0fdf4;color:#166534;font-size:11px;font-weight:600;padding:3px 8px;border-radius:6px">
                            {{ $item->total_buku ?? 0 }} Buku
                        </span>
                    </td>
                    <td style="padding:14px 16px;font-size:13px;color:#475569">{{ $item->tanggal_pinjam->format('d M Y') }}</td>
                    <td style="padding:14px 16px">
                        @php
                            $statusStyles = [
                                'pengajuan'          => 'background:#fef9c3;color:#854d0e',
                                'disetujui'          => 'background:#dbeafe;color:#1e40af',
                                'ditolak'            => 'background:#fee2e2;color:#991b1b',
                                'pengajuan_kembali'  => 'background:#f3e8ff;color:#6b21a8',
                                'dikembalikan'       => 'background:#dcfce7;color:#14532d',
                            ];
                            $ss = $statusStyles[$item->status] ?? 'background:#f1f5f9;color:#475569';
                        @endphp
                        <span style="font-size:11px;font-weight:700;padding:4px 10px;border-radius:20px;{{ $ss }}">
                            {{ strtoupper(str_replace('_', ' ', $item->status)) }}
                        </span>
                    </td>
                    <td style="padding:14px 16px;text-align:center">
                        <a href="{{ route('admin.peminjaman.show', $item) }}"
                           style="background:#eff6ff;color:#3b82f6;border-radius:8px;padding:7px 14px;font-size:12px;font-weight:700;text-decoration:none">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;padding:48px;color:#94a3b8;font-size:14px">Tidak ada data ditemukan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:10px">
        {{ $peminjaman->links() }}
    </div>
</div>
@endsection