@extends('layouts.app')

@section('header')
    Detail Peminjaman
@endsection

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div style="display:flex;flex-direction:column;gap:20px;max-width:680px;margin-bottom:50px">

    {{-- Breadcrumb + Back --}}
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px">
        <div>
            <p style="font-size:11px;color:#94a3b8;margin-bottom:4px">Perpustakaan › Peminjaman › Detail</p>
            <h1 style="font-size:20px;font-weight:800;color:#0f172a;margin:0">Detail Peminjaman</h1>
        </div>
        <a href="{{ route('peminjaman.riwayat') }}"
            style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:10px;border:1.5px solid #e2e8f0;background:#fff;color:#64748b;font-size:13px;font-weight:600;text-decoration:none"
            onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
            <svg style="width:14px;height:14px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Flash Error --}}
    @if($errors->any())
    <div style="padding:14px 18px;border-radius:12px;background:#fef2f2;border:1px solid #fecaca;color:#dc2626;font-size:13px">
        <p style="font-weight:700;margin-bottom:6px">Terdapat kesalahan:</p>
        <ul style="padding-left:16px;margin:0">
            @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
        </ul>
    </div>
    @endif

    {{-- Status Config --}}
    @php
        $statusConfig = [
            'pengajuan'         => ['label' => 'Menunggu Persetujuan', 'bg' => '#fef9c3', 'color' => '#a16207'],
            'disetujui'         => ['label' => 'Dipinjam',             'bg' => '#eff6ff', 'color' => '#1d4ed8'],
            'ditolak'           => ['label' => 'Ditolak',              'bg' => '#fef2f2', 'color' => '#dc2626'],
            'pengajuan_kembali' => ['label' => 'Proses Pengembalian',  'bg' => '#faf5ff', 'color' => '#7c3aed'],
            'dikembalikan'      => ['label' => 'Dikembalikan',         'bg' => '#f0fdf4', 'color' => '#15803d'],
        ];
        $s = $statusConfig[$peminjaman->status] ?? ['label' => ucfirst($peminjaman->status), 'bg' => '#f1f5f9', 'color' => '#64748b'];
    @endphp

    {{-- ═══ CARD UTAMA ═══ --}}
    <div style="background:#fff;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.05);overflow:hidden">

        {{-- Header --}}
        <div style="padding:18px 22px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px">
            <div>
                <p style="font-size:11px;color:#94a3b8;margin:0">ID Transaksi</p>
                <p style="font-size:16px;font-weight:800;color:#0f172a;margin:3px 0 0">#{{ $peminjaman->id }}</p>
            </div>
            <span style="font-size:12px;font-weight:700;padding:5px 14px;border-radius:20px;background:{{ $s['bg'] }};color:{{ $s['color'] }}">
                {{ $s['label'] }}
            </span>
        </div>

        {{-- Daftar Buku --}}
        <div style="padding:18px 22px;border-bottom:1px solid #f1f5f9">
            <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#94a3b8;margin-bottom:10px">Buku yang Dipinjam</p>
            <div style="display:flex;flex-direction:column;gap:8px">
                @foreach($peminjaman->buku as $bk)
                <div style="display:flex;align-items:center;gap:12px;padding:12px 14px;border-radius:12px;background:#f8fafc;border:1px solid #f1f5f9">
                    <div style="width:38px;height:46px;border-radius:8px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <svg style="width:16px;height:16px;color:#3b82f6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
                        </svg>
                    </div>
                    <div style="flex:1;min-width:0">
                        <p style="font-size:13.5px;font-weight:600;color:#1e293b;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $bk->nama_buku }}</p>
                        <p style="font-size:12px;color:#94a3b8;margin:2px 0 0">{{ $bk->penulis ?? 'Penulis tidak diketahui' }}</p>
                    </div>
                    <span style="font-size:12px;font-weight:700;padding:3px 10px;border-radius:20px;background:#eff6ff;color:#1d4ed8;flex-shrink:0">
                        × {{ $bk->pivot->jumlah }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Tanggal --}}
        <div style="padding:16px 22px;border-bottom:1px solid #f1f5f9;display:grid;grid-template-columns:repeat(auto-fit,minmax(120px,1fr));gap:16px">
            <div>
                <p style="font-size:11px;color:#94a3b8;font-weight:500;margin:0">Tanggal Pinjam</p>
                <p style="font-size:13.5px;font-weight:700;color:#1e293b;margin:4px 0 0">
                    {{ $peminjaman->tanggal_pinjam->format('d M Y') }}
                </p>
            </div>
            <div>
                <p style="font-size:11px;color:#94a3b8;font-weight:500;margin:0">Rencana Kembali</p>
                <p style="font-size:13.5px;font-weight:700;margin:4px 0 0;color:{{ $hariTerlambat > 0 && $peminjaman->status === 'disetujui' ? '#dc2626' : '#1e293b' }}">
                    {{ $peminjaman->tanggal_rencana_kembali->format('d M Y') }}
                </p>
            </div>
            @if($peminjaman->tanggal_kembali)
            <div>
                <p style="font-size:11px;color:#94a3b8;font-weight:500;margin:0">Tanggal Kembali</p>
                <p style="font-size:13.5px;font-weight:700;color:#1e293b;margin:4px 0 0">
                    {{ $peminjaman->tanggal_kembali->format('d M Y') }}
                </p>
            </div>
            @endif
        </div>

        {{-- ✅ Info Denda (terlambat real-time saat status disetujui) --}}
        @if($hariTerlambat > 0 && $peminjaman->status === 'disetujui')
        <div style="padding:16px 22px;background:#fef2f2;border-bottom:1px solid #fecaca">
            <div style="display:flex;align-items:flex-start;gap:12px">
                <div style="width:40px;height:40px;border-radius:10px;background:#fee2e2;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg style="width:18px;height:18px;color:#dc2626" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div style="flex:1">
                    <p style="font-weight:800;color:#dc2626;font-size:14px;margin:0">
                        Terlambat {{ $hariTerlambat }} Hari
                    </p>
                    <p style="font-size:13px;color:#ef4444;margin:4px 0 0">
                        Estimasi denda: <strong>Rp {{ number_format($jumlahDenda, 0, ',', '.') }}</strong>
                    </p>

                    {{-- ✅ Info rekening — cek dengan !empty agar string kosong tidak lolos --}}
                    @if($dendaSetting && !empty($dendaSetting->no_rekening))
                    <div style="margin-top:10px;padding:12px 14px;border-radius:10px;background:#fff;border:1px solid #fecaca">
                        <p style="font-size:11px;color:#94a3b8;margin:0 0 6px">Bayar denda ke:</p>
                        <div style="display:flex;align-items:center;gap:10px">
                            <span style="font-size:24px">🏦</span>
                            <div>
                                <p style="font-size:15px;font-weight:800;color:#1e293b;margin:0;letter-spacing:.5px">
                                    {{ $dendaSetting->no_rekening }}
                                </p>
                                <p style="font-size:12px;color:#64748b;margin:2px 0 0">
                                    a/n <strong>{{ $dendaSetting->nama_rekening ?? 'Admin' }}</strong>
                                    &nbsp;·&nbsp;
                                    <span style="background:#fee2e2;color:#dc2626;padding:1px 8px;border-radius:20px;font-size:11px;font-weight:700">
                                        {{ $dendaSetting->bank ?? '-' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        @if(!empty($dendaSetting->keterangan))
                        <p style="font-size:11.5px;color:#94a3b8;margin:8px 0 0;padding-top:8px;border-top:1px dashed #fecaca">
                            📝 {{ $dendaSetting->keterangan }}
                        </p>
                        @endif
                    </div>
                    @else
                    <div style="margin-top:10px;padding:10px 14px;border-radius:10px;background:#fff;border:1px dashed #fca5a5">
                        <p style="font-size:12px;color:#ef4444;margin:0">
                            ⚠️ Info rekening belum diatur. Hubungi admin untuk pembayaran denda.
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- ✅ Info denda final setelah dikembalikan (tampilkan denda yang sudah tersimpan) --}}
        @if(in_array($peminjaman->status, ['pengajuan_kembali', 'dikembalikan']) && $peminjaman->jumlah_denda > 0)
        <div style="padding:14px 22px;background:#fffbeb;border-bottom:1px solid #fde68a">
            <div style="display:flex;align-items:center;gap:8px">
                <span style="font-size:18px">💰</span>
                <p style="font-size:13px;color:#92400e;margin:0">
                    Denda terlambat <strong>{{ $peminjaman->hari_terlambat }} hari</strong>:
                    <strong>Rp {{ number_format($peminjaman->jumlah_denda, 0, ',', '.') }}</strong>
                </p>
            </div>
        </div>
        @endif

    </div>{{-- end card utama --}}

    {{-- ═══ FORM PENGEMBALIAN (status: disetujui) ═══ --}}
    @if($peminjaman->status === 'disetujui')
    <div style="background:#fff;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.05);overflow:hidden">
        <div style="padding:18px 22px;border-bottom:1px solid #f1f5f9">
            <p style="font-size:14px;font-weight:800;color:#1e293b;margin:0">📦 Form Pengembalian</p>
            <p style="font-size:12px;color:#94a3b8;margin:3px 0 0">Isi form di bawah untuk mengajukan pengembalian buku</p>
        </div>

        <form method="POST" action="{{ route('peminjaman.kembalikan', $peminjaman) }}"
              enctype="multipart/form-data" id="formKembali"
              style="padding:20px 22px;display:flex;flex-direction:column;gap:16px">
            @csrf

            {{-- Tanggal Kembali --}}
            <div>
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:7px">
                    Tanggal Pengembalian <span style="color:#ef4444">*</span>
                </label>
                <input type="date" name="tanggal_kembali" id="tanggal_kembali" required
                    data-rencana="{{ $peminjaman->tanggal_rencana_kembali->format('Y-m-d') }}"
                    data-dendaperhari="{{ $dendaSetting->denda_per_hari ?? 0 }}"
                    data-norek="{{ $dendaSetting->no_rekening ?? '' }}"
                    data-namarek="{{ $dendaSetting->nama_rekening ?? 'Admin' }}"
                    data-bank="{{ $dendaSetting->bank ?? '-' }}"
                    min="{{ $today->format('Y-m-d') }}"
                    value="{{ old('tanggal_kembali', $today->format('Y-m-d')) }}"
                    style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13.5px;box-sizing:border-box;outline:none"
                    onfocus="this.style.borderColor='#3b82f6';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
            </div>

            {{-- Preview Denda Dinamis --}}
            <div id="infoDendaDinamis" style="display:none;padding:12px 14px;border-radius:10px;background:#fef2f2;border:1px solid #fecaca">
                <p style="font-size:12px;color:#dc2626;font-weight:700;margin:0 0 6px">
                    ⚠️ Terlambat — Denda: <span id="teksDendaDinamis">Rp 0</span>
                </p>
                <div id="infoRekeningDinamis" style="padding:10px 12px;border-radius:8px;background:#fff;border:1px solid #fecaca;display:none">
                    <p style="font-size:11px;color:#94a3b8;margin:0 0 4px">Bayar ke:</p>
                    <p style="font-size:14px;font-weight:800;color:#1e293b;margin:0" id="noRekDinamis"></p>
                    <p style="font-size:12px;color:#64748b;margin:2px 0 0" id="namaRekDinamis"></p>
                </div>
            </div>

            {{-- Upload Foto Buku --}}
            <div>
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:7px">
                    Foto Buku Dikembalikan <span style="color:#ef4444">*</span>
                </label>
                <div onclick="document.getElementById('foto_pengembalian').click()"
                     style="border:2px dashed #e2e8f0;border-radius:12px;padding:24px;text-align:center;cursor:pointer;transition:border-color .2s"
                     onmouseover="this.style.borderColor='#3b82f6'" onmouseout="this.style.borderColor='#e2e8f0'">
                    <div id="previewFotoPlaceholder">
                        <div style="font-size:28px">📷</div>
                        <p style="font-size:12px;color:#94a3b8;margin-top:4px">Klik untuk upload foto<br><span style="font-size:11px">JPG, PNG · Maks 2MB</span></p>
                    </div>
                    <img id="imgPreviewFoto" src="" style="display:none;max-height:150px;margin:0 auto;border-radius:8px">
                </div>
                <input type="file" id="foto_pengembalian" name="foto_pengembalian" accept="image/*" required style="display:none"
                    onchange="previewGambar(this,'imgPreviewFoto','previewFotoPlaceholder')">
            </div>

            {{-- Upload Bukti Denda (muncul jika terlambat) --}}
            <div id="seksiBuktiBayar" style="display:none">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:7px">
                    Bukti Pembayaran Denda <span style="color:#ef4444">*</span>
                </label>
                <div onclick="document.getElementById('foto_bukti_denda').click()"
                     style="border:2px dashed #fca5a5;border-radius:12px;padding:24px;text-align:center;cursor:pointer;background:#fff8f8;transition:border-color .2s"
                     onmouseover="this.style.borderColor='#ef4444'" onmouseout="this.style.borderColor='#fca5a5'">
                    <div id="previewDendaPlaceholder">
                        <div style="font-size:28px">💳</div>
                        <p style="font-size:12px;color:#64748b;margin-top:4px">Upload Bukti Transfer<br><span style="font-size:11px">JPG, PNG · Maks 2MB</span></p>
                    </div>
                    <img id="imgPreviewDenda" src="" style="display:none;max-height:150px;margin:0 auto;border-radius:8px">
                </div>
                <input type="file" id="foto_bukti_denda" name="foto_bukti_denda" accept="image/*" style="display:none"
                    onchange="previewGambar(this,'imgPreviewDenda','previewDendaPlaceholder')">
            </div>

            <button type="submit" id="btnSubmit"
                style="width:100%;padding:14px;border-radius:10px;border:none;color:#fff;font-weight:700;font-size:14px;cursor:pointer;background:linear-gradient(135deg,#3b82f6,#2563eb);box-shadow:0 4px 12px rgba(59,130,246,.3);transition:transform .15s"
                onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">
                Ajukan Pengembalian
            </button>
        </form>
    </div>
    @endif

    {{-- ═══ STATUS CARD: Menunggu Persetujuan ═══ --}}
    @if($peminjaman->status === 'pengajuan')
    <div style="background:#fff;border-radius:16px;border:1px solid #fde68a;padding:32px;text-align:center">
        <div style="width:56px;height:56px;border-radius:16px;background:#fef9c3;display:flex;align-items:center;justify-content:center;margin:0 auto 14px">
            <svg style="width:26px;height:26px;color:#a16207" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/>
            </svg>
        </div>
        <p style="font-weight:800;color:#a16207;font-size:15px;margin:0">Menunggu Persetujuan Admin</p>
        <p style="font-size:12.5px;color:#94a3b8;margin:6px 0 0">Pengajuan peminjaman kamu sedang ditinjau oleh admin.</p>
    </div>
    @endif

    {{-- ═══ STATUS CARD: Proses Pengembalian ═══ --}}
    @if($peminjaman->status === 'pengajuan_kembali')
    <div style="background:#fff;border-radius:16px;border:1px solid #ddd6fe;padding:32px;text-align:center">
        <div style="width:56px;height:56px;border-radius:16px;background:#faf5ff;display:flex;align-items:center;justify-content:center;margin:0 auto 14px">
            <svg style="width:26px;height:26px;color:#7c3aed" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
            </svg>
        </div>
        <p style="font-weight:800;color:#7c3aed;font-size:15px;margin:0">Pengembalian Sedang Diproses</p>
        <p style="font-size:12.5px;color:#94a3b8;margin:6px 0 0">Admin sedang memverifikasi pengembalian buku kamu.</p>
        @if($peminjaman->foto_pengembalian)
        <div style="margin-top:16px;text-align:left;padding:12px 16px;border-radius:12px;background:#f5f3ff;border:1px solid #ddd6fe">
            <p style="font-size:11px;font-weight:700;color:#7c3aed;text-transform:uppercase;letter-spacing:.5px;margin:0 0 8px">Foto yang dikirim:</p>
            <img src="{{ Storage::url($peminjaman->foto_pengembalian) }}"
                 style="max-height:120px;border-radius:8px;border:1px solid #ddd6fe"
                 alt="Foto pengembalian">
        </div>
        @endif
    </div>
    @endif

    {{-- ═══ STATUS CARD: Dikembalikan ═══ --}}
    @if($peminjaman->status === 'dikembalikan')
    <div style="background:#fff;border-radius:16px;border:1px solid #bbf7d0;padding:32px;text-align:center">
        <div style="width:56px;height:56px;border-radius:16px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;margin:0 auto 14px">
            <svg style="width:26px;height:26px;color:#15803d" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p style="font-weight:800;color:#15803d;font-size:15px;margin:0">Buku Sudah Dikembalikan ✓</p>
        <p style="font-size:12.5px;color:#94a3b8;margin:6px 0 0">Terima kasih! Peminjaman telah selesai.</p>
    </div>
    @endif

    {{-- ═══ STATUS CARD: Ditolak ═══ --}}
    @if($peminjaman->status === 'ditolak')
    <div style="background:#fff;border-radius:16px;border:1px solid #fecaca;padding:32px;text-align:center">
        <div style="width:56px;height:56px;border-radius:16px;background:#fef2f2;display:flex;align-items:center;justify-content:center;margin:0 auto 14px">
            <svg style="width:26px;height:26px;color:#dc2626" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p style="font-weight:800;color:#dc2626;font-size:15px;margin:0">Peminjaman Ditolak</p>
        <p style="font-size:12.5px;color:#94a3b8;margin:6px 0 0">Pengajuan kamu tidak disetujui oleh admin.</p>
        @if($peminjaman->catatan_admin)
        <div style="margin-top:14px;padding:12px 16px;border-radius:10px;background:#fef2f2;border:1px solid #fecaca;text-align:left">
            <p style="font-size:11px;font-weight:700;color:#dc2626;text-transform:uppercase;letter-spacing:.5px;margin:0 0 4px">Alasan Penolakan:</p>
            <p style="font-size:13px;color:#7f1d1d;margin:0">{{ $peminjaman->catatan_admin }}</p>
        </div>
        @endif
    </div>
    @endif

</div>

<script>
// ── Preview Gambar & Validasi Ukuran ───────────────────────────
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

// ── Kalkulasi Denda Dinamis + Tampilkan Info Rekening ─────────
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

    const infoDenda    = document.getElementById('infoDendaDinamis');
    const seksiUpload  = document.getElementById('seksiBuktiBayar');
    const inpDenda     = document.getElementById('foto_bukti_denda');
    const teksDenda    = document.getElementById('teksDendaDinamis');
    const infoRek      = document.getElementById('infoRekeningDinamis');
    const noRekEl      = document.getElementById('noRekDinamis');
    const namaRekEl    = document.getElementById('namaRekDinamis');

    if (pilihan > rencana) {
        const selisih  = Math.ceil((pilihan - rencana) / 86400000);
        const total    = selisih * dendaPerHari;

        // Tampilkan info denda
        infoDenda.style.display  = 'block';
        teksDenda.innerText      = 'Rp ' + total.toLocaleString('id-ID');

        // Tampilkan info rekening jika ada
        if (noRek) {
            infoRek.style.display  = 'block';
            noRekEl.innerText      = noRek;
            namaRekEl.innerText    = 'a/n ' + namaRek + ' · ' + bank;
        } else {
            infoRek.style.display  = 'none';
        }

        // Tampilkan upload bukti
        seksiUpload.style.display = 'block';
        if (inpDenda) inpDenda.required = true;

    } else {
        infoDenda.style.display   = 'none';
        seksiUpload.style.display = 'none';
        if (inpDenda) {
            inpDenda.required = false;
            inpDenda.value    = '';
            // Reset preview
            document.getElementById('imgPreviewDenda').style.display = 'none';
            document.getElementById('previewDendaPlaceholder').style.display = 'block';
        }
    }
}

if (elTgl) {
    cekDenda(elTgl);
    elTgl.addEventListener('change', function() { cekDenda(this); });
}

// ── Proteksi Double Submit ─────────────────────────────────────
const form = document.getElementById('formKembali');
if (form) {
    form.addEventListener('submit', function() {
        const btn      = document.getElementById('btnSubmit');
        btn.disabled   = true;
        btn.style.opacity = '0.7';
        btn.innerText  = '⏳ Sedang Mengirim...';
    });
}
</script>

{{-- Flash success toast --}}
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