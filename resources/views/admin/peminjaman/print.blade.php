<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Buku</title>
    <style>
        /* ── Reset & Base ── */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            color: #1e293b;
            background: #fff;
            padding: 30px 40px;
        }

        /* ── Header / Kop Laporan ── */
        .kop {
            display: flex;
            align-items: center;
            gap: 18px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 14px;
            margin-bottom: 18px;
        }
        .kop-icon {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .kop-icon svg { width: 28px; height: 28px; fill: #fff; }
        .kop-text h1 { font-size: 18px; font-weight: 800; color: #1e293b; }
        .kop-text p  { font-size: 11px; color: #64748b; margin-top: 2px; }

        /* ── Info Filter ── */
        .filter-info {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 16px;
            margin-bottom: 16px;
            display: flex;
            flex-wrap: wrap;
            gap: 6px 20px;
        }
        .filter-item { font-size: 11px; color: #475569; }
        .filter-item span { font-weight: 700; color: #1e293b; }

        /* ── Statistik Ringkas ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            margin-bottom: 18px;
        }
        .stat-box {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 12px;
            text-align: center;
        }
        .stat-box .val  { font-size: 22px; font-weight: 800; line-height: 1.1; }
        .stat-box .lbl  { font-size: 10px; color: #94a3b8; font-weight: 600; margin-top: 3px; }

        /* ── Tabel ── */
        table { width: 100%; border-collapse: collapse; }
        thead tr {
            background: #1e40af;
            color: #fff;
        }
        thead th {
            text-align: left;
            padding: 9px 10px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody tr { border-bottom: 1px solid #e2e8f0; }
        tbody td { padding: 8px 10px; font-size: 11px; vertical-align: middle; }
        tbody tr:last-child { border-bottom: none; }

        .badge {
            font-size: 9px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 20px;
            display: inline-block;
        }
        .badge-pengajuan      { background: #fef9c3; color: #854d0e; }
        .badge-disetujui      { background: #dbeafe; color: #1e40af; }
        .badge-ditolak        { background: #fee2e2; color: #991b1b; }
        .badge-pengajuan-kembali { background: #f3e8ff; color: #6b21a8; }
        .badge-dikembalikan   { background: #dcfce7; color: #14532d; }

        /* ── Footer ── */
        .footer {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .footer .meta { font-size: 10px; color: #94a3b8; }
        .footer .ttd  { text-align: center; font-size: 11px; color: #475569; }
        .footer .ttd .garis {
            width: 180px;
            border-top: 1.5px solid #1e293b;
            margin: 50px auto 6px;
        }

        /* ── Print Override ── */
        @media print {
            body { padding: 20px 28px; }
            .no-print { display: none !important; }
            table { page-break-inside: auto; }
            tr { page-break-inside: avoid; }
        }

        /* ── Action Bar (tidak ikut print) ── */
        .action-bar {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-bottom: 24px;
        }
        .btn {
            padding: 9px 20px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            text-decoration: none;
        }
        .btn-print { background: linear-gradient(135deg, #3b82f6, #2563eb); color: #fff; }
        .btn-back  { background: #f1f5f9; color: #475569; }
    </style>
</head>
<body>

    {{-- Action Bar (tidak ikut cetak) --}}
    <div class="action-bar no-print">
        <a href="{{ route('admin.peminjaman.index') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}"
           class="btn btn-back">← Kembali</a>
        <button onclick="window.print()" class="btn btn-print">🖨️ Cetak / Simpan PDF</button>
    </div>

    {{-- Kop Surat --}}
    <div class="kop">
        <div class="kop-icon">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
            </svg>
        </div>
        <div class="kop-text">
            <h1>Laporan Daftar Peminjaman Buku</h1>
            <p>Sistem Perpustakaan &nbsp;|&nbsp; Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
        </div>
    </div>

    {{-- Info Filter Aktif --}}
    <div class="filter-info">
        <div class="filter-item">Filter Status:
            <span>{{ request('status') ? strtoupper(str_replace('_',' ', request('status'))) : 'Semua Status' }}</span>
        </div>
        @if(request('search'))
        <div class="filter-item">Kata Kunci: <span>{{ request('search') }}</span></div>
        @endif
        @if(request('tgl_mulai') || request('tgl_selesai'))
        <div class="filter-item">Periode:
            <span>
                {{ request('tgl_mulai') ? \Carbon\Carbon::parse(request('tgl_mulai'))->format('d M Y') : '—' }}
                s/d
                {{ request('tgl_selesai') ? \Carbon\Carbon::parse(request('tgl_selesai'))->format('d M Y') : '—' }}
            </span>
        </div>
        @endif
        <div class="filter-item">Total Data: <span>{{ $peminjaman->count() }} record</span></div>
    </div>

    {{-- Statistik Ringkas --}}
    @php
        $counts = [
            ['label' => 'Pengajuan',    'val' => $peminjaman->where('status','pengajuan')->count(),          'color' => '#f59e0b'],
            ['label' => 'Disetujui',    'val' => $peminjaman->where('status','disetujui')->count(),          'color' => '#3b82f6'],
            ['label' => 'Proses Kembali','val'=> $peminjaman->where('status','pengajuan_kembali')->count(),  'color' => '#a855f7'],
            ['label' => 'Dikembalikan', 'val' => $peminjaman->where('status','dikembalikan')->count(),       'color' => '#22c55e'],
            ['label' => 'Ditolak',      'val' => $peminjaman->where('status','ditolak')->count(),            'color' => '#ef4444'],
        ];
    @endphp
    <div class="stats-row">
        @foreach($counts as $c)
        <div class="stat-box">
            <div class="val" style="color:{{ $c['color'] }}">{{ $c['val'] }}</div>
            <div class="lbl">{{ $c['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Tabel Laporan --}}
    <table>
        <thead>
            <tr>
                <th style="width:40px">#</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th style="width:60px;text-align:center">Jml Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Catatan Admin</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman as $i => $item)
            @php
                $badgeClass = [
                    'pengajuan'          => 'badge-pengajuan',
                    'disetujui'          => 'badge-disetujui',
                    'ditolak'            => 'badge-ditolak',
                    'pengajuan_kembali'  => 'badge-pengajuan-kembali',
                    'dikembalikan'       => 'badge-dikembalikan',
                ][$item->status] ?? '';
            @endphp
            <tr>
                <td style="color:#94a3b8">{{ $i + 1 }}</td>
                <td style="font-weight:700">{{ $item->user->name }}</td>
                <td style="color:#475569">{{ $item->user->kelas ?? '-' }}</td>
                <td style="text-align:center;font-weight:700;color:#166534">{{ $item->total_buku ?? 0 }}</td>
                <td>{{ $item->tanggal_pinjam->format('d M Y') }}</td>
                <td>{{ $item->tanggal_kembali ? $item->tanggal_kembali->format('d M Y') : '—' }}</td>
                <td>
                    <span class="badge {{ $badgeClass }}">
                        {{ strtoupper(str_replace('_',' ', $item->status)) }}
                    </span>
                </td>
                <td style="color:#64748b;font-style:italic">{{ $item->catatan_admin ?? '—' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;padding:24px;color:#94a3b8">
                    Tidak ada data untuk filter yang dipilih.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Footer --}}
    <div class="footer">
        <div class="meta">
            <p>Laporan ini digenerate otomatis oleh sistem.</p>
            <p>Perpustakaan — {{ now()->format('Y') }}</p>
        </div>
        <div class="ttd">
            <p>Mengetahui,</p>
            <p style="font-weight:700;margin-top:2px">Kepala Perpustakaan</p>
            <div class="garis"></div>
            <p>( _________________________ )</p>
            <p style="font-size:10px;color:#94a3b8;margin-top:2px">NIP. ____________________</p>
        </div>
    </div>

</body>
</html>