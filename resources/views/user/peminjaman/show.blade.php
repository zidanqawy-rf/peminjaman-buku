@extends('layouts.app')

@section('header')
    Detail Peminjaman
@endsection

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="show-wrap">

    {{-- Breadcrumb + Back --}}
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
        <div>
            <p style="font-size:11px;color:#94a3b8;margin-bottom:4px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">Perpustakaan › Peminjaman › Detail</p>
            <h1 style="font-size:20px;font-weight:800;color:#0f172a;margin:0;">Detail Peminjaman</h1>
        </div>
        <a href="{{ route('peminjaman.riwayat') }}"
            style="display:inline-flex;align-items:center;gap:7px;padding:9px 16px;border-radius:10px;border:1.5px solid #e2e8f0;background:#fff;color:#64748b;font-size:13px;font-weight:600;text-decoration:none;flex-shrink:0;"
            onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
            <svg style="width:14px;height:14px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
    </div>

    @if($errors->any())
    <div style="padding:14px 18px;border-radius:12px;background:#fef2f2;border:1px solid #fecaca;color:#dc2626;font-size:13px;">
        <p style="font-weight:700;margin-bottom:6px;">Terdapat kesalahan:</p>
        <ul style="padding-left:16px;margin:0;">
            @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
        </ul>
    </div>
    @endif

    @php
        $statusConfig = [
            'pengajuan'         => ['label' => 'Menunggu Persetujuan', 'bg' => '#fef9c3', 'color' => '#a16207'],
            'disetujui'         => ['label' => 'Dipinjam',             'bg' => '#eff6ff', 'color' => '#1d4ed8'],
            'ditolak'           => ['label' => 'Ditolak',              'bg' => '#fef2f2', 'color' => '#dc2626'],
            'pengajuan_kembali' => ['label' => 'Proses Pengembalian',  'bg' => '#faf5ff', 'color' => '#7c3aed'],
            'didenda'           => ['label' => 'Ada Tagihan Denda',    'bg' => '#fff7ed', 'color' => '#c2410c'],
            'dikembalikan'      => ['label' => 'Dikembalikan',         'bg' => '#f0fdf4', 'color' => '#15803d'],
        ];
        $s = $statusConfig[$peminjaman->status] ?? ['label' => ucfirst($peminjaman->status), 'bg' => '#f1f5f9', 'color' => '#64748b'];
    @endphp

    {{-- ═══ CARD UTAMA ═══ --}}
    <div class="show-card">
        <div class="show-card-header">
            <div>
                <p style="font-size:11px;color:#94a3b8;margin:0;font-weight:600;">ID Transaksi</p>
                <p style="font-size:16px;font-weight:800;color:#0f172a;margin:3px 0 0;">#{{ $peminjaman->id }}</p>
            </div>
            <span style="font-size:12px;font-weight:700;padding:5px 14px;border-radius:20px;background:{{ $s['bg'] }};color:{{ $s['color'] }};white-space:nowrap;">
                {{ $s['label'] }}
            </span>
        </div>

        {{-- Daftar Buku --}}
        <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;">
            <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#94a3b8;margin-bottom:10px;">Buku yang Dipinjam</p>
            <div style="display:flex;flex-direction:column;gap:8px;">
                @foreach($peminjaman->buku as $bk)
                <div style="display:flex;align-items:center;gap:11px;padding:11px 13px;border-radius:12px;background:#f8fafc;border:1px solid #f1f5f9;">
                    <div style="width:36px;height:44px;border-radius:8px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg style="width:15px;height:15px;color:#3b82f6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
                        </svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <p style="font-size:13.5px;font-weight:600;color:#1e293b;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $bk->nama_buku }}</p>
                        <p style="font-size:12px;color:#94a3b8;margin:2px 0 0;">{{ $bk->penulis ?? 'Penulis tidak diketahui' }}</p>
                    </div>
                    <span style="font-size:12px;font-weight:700;padding:3px 10px;border-radius:20px;background:#eff6ff;color:#1d4ed8;flex-shrink:0;">× {{ $bk->pivot->jumlah }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Tanggal --}}
        <div class="tanggal-grid">
            <div>
                <p style="font-size:11px;color:#94a3b8;font-weight:500;margin:0;">Tanggal Pinjam</p>
                <p style="font-size:13.5px;font-weight:700;color:#1e293b;margin:4px 0 0;">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
            </div>
            <div>
                <p style="font-size:11px;color:#94a3b8;font-weight:500;margin:0;">Rencana Kembali</p>
                <p style="font-size:13.5px;font-weight:700;margin:4px 0 0;color:{{ $hariTerlambat > 0 && $peminjaman->status === 'disetujui' ? '#dc2626' : '#1e293b' }};">
                    {{ $peminjaman->tanggal_rencana_kembali->format('d M Y') }}
                </p>
            </div>
            @if($peminjaman->tanggal_kembali)
            <div>
                <p style="font-size:11px;color:#94a3b8;font-weight:500;margin:0;">Tanggal Kembali</p>
                <p style="font-size:13.5px;font-weight:700;color:#1e293b;margin:4px 0 0;">{{ $peminjaman->tanggal_kembali->format('d M Y') }}</p>
            </div>
            @endif
        </div>

        {{-- Info Denda real-time (saat masih dipinjam & terlambat) --}}
        @if($hariTerlambat > 0 && $peminjaman->status === 'disetujui')
        <div style="padding:16px 20px;background:#fef2f2;border-bottom:1px solid #fecaca;">
            <div style="display:flex;align-items:flex-start;gap:12px;">
                <div style="width:38px;height:38px;border-radius:10px;background:#fee2e2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg style="width:17px;height:17px;color:#dc2626" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div style="flex:1;">
                    <p style="font-weight:800;color:#dc2626;font-size:14px;margin:0;">Terlambat {{ $hariTerlambat }} Hari</p>
                    <p style="font-size:13px;color:#ef4444;margin:4px 0 0;">
                        Estimasi denda keterlambatan: <strong>Rp {{ number_format($jumlahDenda, 0, ',', '.') }}</strong>
                    </p>
                    @if($dendaSetting && !empty($dendaSetting->no_rekening))
                    <div style="margin-top:10px;padding:12px 14px;border-radius:10px;background:#fff;border:1px solid #fecaca;">
                        <p style="font-size:11px;color:#94a3b8;margin:0 0 6px;">Bayar denda ke:</p>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <span style="font-size:22px;">🏦</span>
                            <div>
                                <p style="font-size:14px;font-weight:800;color:#1e293b;margin:0;letter-spacing:.5px;">{{ $dendaSetting->no_rekening }}</p>
                                <p style="font-size:12px;color:#64748b;margin:2px 0 0;">
                                    a/n <strong>{{ $dendaSetting->nama_rekening ?? 'Admin' }}</strong>
                                    &nbsp;·&nbsp;
                                    <span style="background:#fee2e2;color:#dc2626;padding:1px 8px;border-radius:20px;font-size:11px;font-weight:700;">{{ $dendaSetting->bank ?? '-' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Denda final setelah dikembalikan --}}
        @if(in_array($peminjaman->status, ['pengajuan_kembali', 'dikembalikan']) && $peminjaman->jumlah_denda > 0)
        <div style="padding:14px 20px;background:#fffbeb;border-bottom:1px solid #fde68a;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="font-size:18px;">💰</span>
                <p style="font-size:13px;color:#92400e;margin:0;">
                    Denda terlambat <strong>{{ $peminjaman->hari_terlambat }} hari</strong>:
                    <strong>Rp {{ number_format($peminjaman->jumlah_denda, 0, ',', '.') }}</strong>
                </p>
            </div>
        </div>
        @endif

    </div>{{-- /card utama --}}

    {{-- ═══ FORM PENGEMBALIAN ═══ --}}
    @if($peminjaman->status === 'disetujui')
    <div class="show-card">
        <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;">
            <p style="font-size:14px;font-weight:800;color:#1e293b;margin:0;">📦 Form Pengembalian</p>
            <p style="font-size:12px;color:#94a3b8;margin:3px 0 0;">Isi form di bawah untuk mengajukan pengembalian buku</p>
        </div>

        <form method="POST" action="{{ route('peminjaman.kembalikan', $peminjaman) }}"
              enctype="multipart/form-data" id="formKembali"
              style="padding:18px 20px;display:flex;flex-direction:column;gap:16px;">
            @csrf

            <div>
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:7px;">
                    Tanggal Pengembalian <span style="color:#ef4444;">*</span>
                </label>
                <input type="date" name="tanggal_kembali" id="tanggal_kembali" required
                    data-rencana="{{ $peminjaman->tanggal_rencana_kembali->format('Y-m-d') }}"
                    data-dendaperhari="{{ $dendaSetting->denda_per_hari ?? 0 }}"
                    data-norek="{{ $dendaSetting->no_rekening ?? '' }}"
                    data-namarek="{{ $dendaSetting->nama_rekening ?? 'Admin' }}"
                    data-bank="{{ $dendaSetting->bank ?? '-' }}"
                    min="{{ $today->format('Y-m-d') }}"
                    value="{{ old('tanggal_kembali', $today->format('Y-m-d')) }}"
                    style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:11px 13px;font-size:14px;box-sizing:border-box;outline:none;"
                    onfocus="this.style.borderColor='#3b82f6';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
            </div>

            <div id="infoDendaDinamis" style="display:none;padding:12px 14px;border-radius:10px;background:#fef2f2;border:1px solid #fecaca;">
                <p style="font-size:12px;color:#dc2626;font-weight:700;margin:0 0 6px;">⚠️ Terlambat — Denda: <span id="teksDendaDinamis">Rp 0</span></p>
                <div id="infoRekeningDinamis" style="padding:10px 12px;border-radius:8px;background:#fff;border:1px solid #fecaca;display:none;">
                    <p style="font-size:11px;color:#94a3b8;margin:0 0 4px;">Bayar ke:</p>
                    <p style="font-size:14px;font-weight:800;color:#1e293b;margin:0;" id="noRekDinamis"></p>
                    <p style="font-size:12px;color:#64748b;margin:2px 0 0;" id="namaRekDinamis"></p>
                </div>
            </div>

            <div>
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:7px;">
                    Foto Buku Dikembalikan <span style="color:#ef4444;">*</span>
                </label>
                <div onclick="document.getElementById('foto_pengembalian').click()"
                     class="upload-area"
                     onmouseover="this.style.borderColor='#3b82f6'" onmouseout="this.style.borderColor='#e2e8f0'">
                    <div id="previewFotoPlaceholder">
                        <div style="font-size:28px;">📷</div>
                        <p style="font-size:12px;color:#94a3b8;margin-top:4px;margin-bottom:0;">Klik untuk upload foto<br><span style="font-size:11px;">JPG, PNG · Maks 2MB</span></p>
                    </div>
                    <img id="imgPreviewFoto" src="" style="display:none;max-height:140px;margin:0 auto;border-radius:8px;">
                </div>
                <input type="file" id="foto_pengembalian" name="foto_pengembalian" accept="image/*" required style="display:none;"
                    onchange="previewGambar(this,'imgPreviewFoto','previewFotoPlaceholder')">
            </div>

            <div id="seksiBuktiBayar" style="display:none;">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:7px;">
                    Bukti Pembayaran Denda Terlambat <span style="color:#ef4444;">*</span>
                </label>
                <div onclick="document.getElementById('foto_bukti_denda').click()"
                     class="upload-area" style="border-color:#fca5a5;background:#fff8f8;"
                     onmouseover="this.style.borderColor='#ef4444'" onmouseout="this.style.borderColor='#fca5a5'">
                    <div id="previewDendaPlaceholder">
                        <div style="font-size:28px;">💳</div>
                        <p style="font-size:12px;color:#64748b;margin-top:4px;margin-bottom:0;">Upload Bukti Transfer<br><span style="font-size:11px;">JPG, PNG · Maks 2MB</span></p>
                    </div>
                    <img id="imgPreviewDenda" src="" style="display:none;max-height:140px;margin:0 auto;border-radius:8px;">
                </div>
                <input type="file" id="foto_bukti_denda" name="foto_bukti_denda" accept="image/*" style="display:none;"
                    onchange="previewGambar(this,'imgPreviewDenda','previewDendaPlaceholder')">
            </div>

            <button type="submit" id="btnSubmit"
                style="width:100%;padding:14px;border-radius:10px;border:none;color:#fff;font-weight:700;font-size:14px;cursor:pointer;background:linear-gradient(135deg,#3b82f6,#2563eb);box-shadow:0 4px 12px rgba(59,130,246,.3);transition:transform .15s;"
                onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">
                Ajukan Pengembalian
            </button>
        </form>
    </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- ═══ CARD BARU: TAGIHAN DENDA KERUSAKAN / KEHILANGAN ═══   --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    @if($peminjaman->status === 'didenda')
    <div class="show-card" style="border:2px solid #f97316;">
        <div style="padding:16px 20px;border-bottom:1px solid #fed7aa;background:#fff7ed;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:38px;height:38px;border-radius:10px;background:#ffedd5;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg style="width:18px;height:18px;color:#f97316" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
                <div>
                    <p style="font-size:14px;font-weight:800;color:#7c2d12;margin:0;">🚨 Ada Tagihan Denda</p>
                    <p style="font-size:12px;color:#9a3412;margin:2px 0 0;">Buku dinyatakan bermasalah oleh admin perpustakaan</p>
                </div>
            </div>
        </div>

        <div style="padding:18px 20px;display:flex;flex-direction:column;gap:14px;">

            {{-- Detail kondisi & denda --}}
            <div style="background:#fff7ed;border:1.5px solid #fed7aa;border-radius:12px;padding:16px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                    <span style="font-size:13px;color:#92400e;font-weight:600;">Kondisi Buku</span>
                    <span style="font-size:13px;font-weight:800;color:#c2410c;background:#fee2e2;padding:4px 12px;border-radius:20px;">
                        {{ $peminjaman->kondisi_buku }}
                    </span>
                </div>
                @if($peminjaman->catatan_kerusakan)
                <div style="background:#fff;border-radius:8px;padding:10px 12px;margin-bottom:10px;border:1px solid #fed7aa;">
                    <p style="font-size:11px;color:#92400e;margin:0 0 3px;font-weight:600;text-transform:uppercase;letter-spacing:.4px;">Keterangan dari Admin:</p>
                    <p style="font-size:13px;color:#7c2d12;margin:0;">{{ $peminjaman->catatan_kerusakan }}</p>
                </div>
                @endif
                <div style="border-top:1px dashed #fed7aa;padding-top:10px;display:flex;justify-content:space-between;align-items:center;">
                    <span style="font-size:14px;font-weight:700;color:#92400e;">💰 Total Tagihan:</span>
                    <span style="font-size:20px;font-weight:800;color:#c2410c;">Rp {{ number_format($peminjaman->denda_kerusakan,0,',','.') }}</span>
                </div>
            </div>

            {{-- Informasi rekening pembayaran --}}
            @if($dendaSetting && !empty($dendaSetting->no_rekening))
            <div style="background:#fff;border:1.5px solid #e2e8f0;border-radius:12px;padding:16px;">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:12px;">Bayar Denda ke Rekening Berikut:</p>
                <div style="display:flex;align-items:center;gap:12px;background:#f8fafc;border-radius:10px;padding:12px 14px;">
                    <span style="font-size:28px;">🏦</span>
                    <div style="flex:1;">
                        <p style="font-size:17px;font-weight:800;color:#1e293b;margin:0;letter-spacing:.5px;">{{ $dendaSetting->no_rekening }}</p>
                        <p style="font-size:12px;color:#64748b;margin:3px 0 0;">
                            a/n <strong>{{ $dendaSetting->nama_rekening ?? 'Admin' }}</strong>
                            &nbsp;·&nbsp;
                            <span style="background:#dbeafe;color:#1d4ed8;padding:2px 8px;border-radius:20px;font-size:11px;font-weight:700;">{{ $dendaSetting->bank ?? '-' }}</span>
                        </p>
                    </div>
                    {{-- Copy button --}}
                    <button onclick="salinNoRek('{{ $dendaSetting->no_rekening }}')"
                        style="padding:7px 12px;border-radius:8px;border:1.5px solid #e2e8f0;background:#fff;color:#475569;font-size:12px;font-weight:600;cursor:pointer;"
                        onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">
                        📋 Salin
                    </button>
                </div>
                @if(!empty($dendaSetting->keterangan))
                <p style="font-size:11.5px;color:#94a3b8;margin:10px 0 0;padding-top:10px;border-top:1px dashed #e2e8f0;">📝 {{ $dendaSetting->keterangan }}</p>
                @endif
            </div>
            @else
            <div style="padding:12px 14px;border-radius:10px;background:#fff;border:1px dashed #fca5a5;">
                <p style="font-size:12px;color:#ef4444;margin:0;">⚠️ Info rekening belum diatur. Hubungi admin untuk pembayaran denda.</p>
            </div>
            @endif

            {{-- Status upload bukti --}}
            @if($peminjaman->foto_bukti_denda_kerusakan)
                {{-- Sudah upload — menunggu konfirmasi admin --}}
                <div style="background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:12px;padding:16px;text-align:center;">
                    <div style="font-size:32px;margin-bottom:6px;">✅</div>
                    <p style="font-size:14px;font-weight:800;color:#166534;margin:0;">Bukti Pembayaran Terkirim</p>
                    <p style="font-size:12px;color:#15803d;margin:4px 0 0;">Menunggu konfirmasi dari admin perpustakaan.</p>
                    <img src="{{ Storage::url($peminjaman->foto_bukti_denda_kerusakan) }}"
                         style="max-height:120px;border-radius:8px;margin-top:12px;border:1px solid #bbf7d0;" alt="Bukti bayar">
                </div>
            @else
                {{-- Belum upload — tampilkan form upload --}}
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px;">
                        Upload Bukti Pembayaran Denda <span style="color:#ef4444;">*</span>
                    </label>
                    <form method="POST" action="{{ route('peminjaman.bayarDendaKerusakan', $peminjaman) }}"
                          enctype="multipart/form-data" id="formBayarDenda"
                          style="display:flex;flex-direction:column;gap:12px;">
                        @csrf
                        <div onclick="document.getElementById('foto_bukti_denda_kerusakan').click()"
                             class="upload-area" style="border-color:#fed7aa;background:#fffbf5;"
                             onmouseover="this.style.borderColor='#f97316'" onmouseout="this.style.borderColor='#fed7aa'">
                            <div id="previewBayarPlaceholder">
                                <div style="font-size:28px;">💳</div>
                                <p style="font-size:12px;color:#9a3412;margin-top:4px;margin-bottom:0;">
                                    Klik untuk upload bukti transfer<br>
                                    <span style="font-size:11px;color:#94a3b8;">JPG, PNG · Maks 2MB</span>
                                </p>
                            </div>
                            <img id="imgPreviewBayar" src="" style="display:none;max-height:140px;margin:0 auto;border-radius:8px;">
                        </div>
                        <input type="file" id="foto_bukti_denda_kerusakan" name="foto_bukti_denda_kerusakan"
                               accept="image/*" required style="display:none;"
                               onchange="previewGambar(this,'imgPreviewBayar','previewBayarPlaceholder')">

                        <button type="submit" id="btnKirimBukti"
                            style="width:100%;padding:14px;border-radius:10px;border:none;color:#fff;font-weight:700;font-size:14px;cursor:pointer;background:linear-gradient(135deg,#f97316,#ea580c);box-shadow:0 4px 12px rgba(249,115,22,.3);"
                            onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'"
                            style="transition:transform .15s;">
                            📤 Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Status Cards --}}
    @if($peminjaman->status === 'pengajuan')
    <div class="status-card" style="border-color:#fde68a;">
        <div class="status-icon" style="background:#fef9c3;">
            <svg style="width:24px;height:24px;color:#a16207;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/>
            </svg>
        </div>
        <p class="status-title" style="color:#a16207;">Menunggu Persetujuan Admin</p>
        <p class="status-sub">Pengajuan peminjaman kamu sedang ditinjau oleh admin.</p>
    </div>
    @endif

    @if($peminjaman->status === 'pengajuan_kembali')
    <div class="status-card" style="border-color:#ddd6fe;">
        <div class="status-icon" style="background:#faf5ff;">
            <svg style="width:24px;height:24px;color:#7c3aed;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
            </svg>
        </div>
        <p class="status-title" style="color:#7c3aed;">Pengembalian Sedang Diproses</p>
        <p class="status-sub">Admin sedang memverifikasi pengembalian buku kamu.</p>
        @if($peminjaman->foto_pengembalian)
        <div style="margin-top:14px;text-align:left;padding:12px 14px;border-radius:12px;background:#f5f3ff;border:1px solid #ddd6fe;">
            <p style="font-size:11px;font-weight:700;color:#7c3aed;text-transform:uppercase;letter-spacing:.5px;margin:0 0 8px;">Foto yang dikirim:</p>
            <img src="{{ Storage::url($peminjaman->foto_pengembalian) }}"
                 style="max-height:120px;border-radius:8px;border:1px solid #ddd6fe;" alt="Foto pengembalian">
        </div>
        @endif
    </div>
    @endif

    @if($peminjaman->status === 'dikembalikan')
    <div class="status-card" style="border-color:#bbf7d0;">
        <div class="status-icon" style="background:#f0fdf4;">
            <svg style="width:24px;height:24px;color:#15803d;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="status-title" style="color:#15803d;">Peminjaman Selesai ✓</p>
        <p class="status-sub">Terima kasih! Semua kewajiban telah selesai.</p>
        @if($peminjaman->denda_kerusakan > 0)
        <div style="margin-top:12px;padding:10px 14px;border-radius:10px;background:#f0fdf4;border:1px solid #bbf7d0;">
            <p style="font-size:12px;color:#166534;margin:0;">Denda kerusakan <strong>Rp {{ number_format($peminjaman->denda_kerusakan,0,',','.') }}</strong> — ✅ Lunas</p>
        </div>
        @endif
    </div>
    @endif

    @if($peminjaman->status === 'ditolak')
    <div class="status-card" style="border-color:#fecaca;">
        <div class="status-icon" style="background:#fef2f2;">
            <svg style="width:24px;height:24px;color:#dc2626;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="status-title" style="color:#dc2626;">Peminjaman Ditolak</p>
        <p class="status-sub">Pengajuan kamu tidak disetujui oleh admin.</p>
        @if($peminjaman->catatan_admin)
        <div style="margin-top:14px;padding:12px 14px;border-radius:10px;background:#fef2f2;border:1px solid #fecaca;text-align:left;">
            <p style="font-size:11px;font-weight:700;color:#dc2626;text-transform:uppercase;letter-spacing:.5px;margin:0 0 4px;">Alasan Penolakan:</p>
            <p style="font-size:13px;color:#7f1d1d;margin:0;">{{ $peminjaman->catatan_admin }}</p>
        </div>
        @endif
    </div>
    @endif

</div>{{-- /show-wrap --}}

<script>
function previewGambar(input, imgId, placeholderId) {
    const file = input.files[0];
    if (!file) return;
    if (file.size > 2097152) {
        Swal.fire({ icon:'error', title:'File Terlalu Besar', text:'Maksimal ukuran file adalah 2MB.' });
        input.value = '';
        return;
    }
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById(imgId);
        img.src = e.target.result;
        img.style.display = 'block';
        document.getElementById(placeholderId).style.display = 'none';
    };
    reader.readAsDataURL(file);
}

function salinNoRek(noRek) {
    navigator.clipboard.writeText(noRek).then(() => {
        Swal.fire({ toast:true, position:'top-end', icon:'success', title:'Nomor rekening disalin!', showConfirmButton:false, timer:2000 });
    });
}

const elTgl = document.getElementById('tanggal_kembali');
function cekDenda(el) {
    if (!el) return;
    const rencana      = new Date(el.dataset.rencana);
    const pilihan      = new Date(el.value);
    const dendaPerHari = parseInt(el.dataset.dendaperhari) || 0;
    const noRek        = el.dataset.norek   || '';
    const namaRek      = el.dataset.namarek || 'Admin';
    const bank         = el.dataset.bank    || '-';
    rencana.setHours(0,0,0,0);
    pilihan.setHours(0,0,0,0);

    const infoDenda   = document.getElementById('infoDendaDinamis');
    const seksiUpload = document.getElementById('seksiBuktiBayar');
    const inpDenda    = document.getElementById('foto_bukti_denda');
    const teksDenda   = document.getElementById('teksDendaDinamis');
    const infoRek     = document.getElementById('infoRekeningDinamis');
    const noRekEl     = document.getElementById('noRekDinamis');
    const namaRekEl   = document.getElementById('namaRekDinamis');

    if (pilihan > rencana) {
        const selisih = Math.ceil((pilihan - rencana) / 86400000);
        const total   = selisih * dendaPerHari;
        infoDenda.style.display  = 'block';
        teksDenda.innerText      = 'Rp ' + total.toLocaleString('id-ID');
        if (noRek) {
            infoRek.style.display = 'block';
            noRekEl.innerText     = noRek;
            namaRekEl.innerText   = 'a/n ' + namaRek + ' · ' + bank;
        } else {
            infoRek.style.display = 'none';
        }
        seksiUpload.style.display = 'block';
        if (inpDenda) inpDenda.required = true;
    } else {
        infoDenda.style.display   = 'none';
        seksiUpload.style.display = 'none';
        if (inpDenda) {
            inpDenda.required = false;
            inpDenda.value    = '';
            document.getElementById('imgPreviewDenda').style.display = 'none';
            document.getElementById('previewDendaPlaceholder').style.display = 'block';
        }
    }
}
if (elTgl) {
    cekDenda(elTgl);
    elTgl.addEventListener('change', function() { cekDenda(this); });
}

const form = document.getElementById('formKembali');
if (form) {
    form.addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.style.opacity = '0.7';
        btn.innerText = '⏳ Sedang Mengirim...';
    });
}

const formDenda = document.getElementById('formBayarDenda');
if (formDenda) {
    formDenda.addEventListener('submit', function() {
        const btn = document.getElementById('btnKirimBukti');
        btn.disabled = true;
        btn.style.opacity = '0.7';
        btn.innerText = '⏳ Mengirim...';
    });
}
</script>

<style>
.show-wrap {
    padding: 20px;
    max-width: 680px;
    margin: 0 auto 40px;
    display: flex;
    flex-direction: column;
    gap: 18px;
}
.show-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
    overflow: hidden;
}
.show-card-header {
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}
.tanggal-grid {
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(110px, 1fr));
    gap: 14px;
}
.upload-area {
    border: 2px dashed #e2e8f0;
    border-radius: 12px;
    padding: 22px 16px;
    text-align: center;
    cursor: pointer;
    transition: border-color .2s;
}
.status-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid;
    padding: 28px 20px;
    text-align: center;
}
.status-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
}
.status-title { font-weight: 800; font-size: 14px; margin: 0; }
.status-sub   { font-size: 12.5px; color: #94a3b8; margin: 6px 0 0; }

@media (max-width: 767px) {
    .show-wrap { padding: 12px; gap: 14px; margin-bottom: 24px; }
    .show-card-header { padding: 13px 16px; }
    .tanggal-grid { padding: 12px 16px; gap: 12px; }
    .show-wrap form { padding: 14px 16px !important; }
    .upload-area { padding: 18px 12px; }
    .status-card { padding: 22px 16px; }
    .status-icon { width: 46px; height: 46px; }
    .status-title { font-size: 13.5px; }
}
</style>

@if(session('success'))
<script>
Swal.fire({
    toast: true, position: 'top-end', icon: 'success',
    title: '{{ session('success') }}',
    showConfirmButton: false, timer: 3000, timerProgressBar: true,
});
</script>
@endif

@endsection