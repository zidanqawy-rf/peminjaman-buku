{{-- resources/views/user/peminjaman/show.blade.php --}}
@extends('layouts.app')

@section('header')
    Detail Peminjaman
@endsection

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div style="display:flex;flex-direction:column;gap:20px;max-width:680px;margin-bottom: 50px;">

    {{-- Breadcrumb + Back --}}
    <div style="display:flex;align-items:center;justify-content:space-between">
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

    {{-- Logika Penentuan Status --}}
    @php
        $statusConfig = [
            'pengajuan'         => ['label' => 'Menunggu Persetujuan', 'bg' => '#fef9c3', 'color' => '#a16207'],
            'disetujui'         => ['label' => 'Dipinjam',             'bg' => '#eff6ff', 'color' => '#1d4ed8'],
            'ditolak'           => ['label' => 'Ditolak',              'bg' => '#fef2f2', 'color' => '#dc2626'],
            'pengajuan_kembali' => ['label' => 'Proses Pengembalian',   'bg' => '#faf5ff', 'color' => '#7c3aed'],
            'dikembalikan'      => ['label' => 'Dikembalikan',          'bg' => '#f0fdf4', 'color' => '#15803d'],
        ];
        $s = $statusConfig[$peminjaman->status] ?? ['label' => ucfirst($peminjaman->status), 'bg' => '#f1f5f9', 'color' => '#64748b'];
    @endphp

    <div style="background:#fff;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.05);overflow:hidden">
        {{-- Header Card --}}
        <div style="padding:18px 22px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between">
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
                        <p style="font-size:13.5px;font-weight:600;color:#1e293b;margin:0">{{ $bk->nama_buku }}</p>
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
        <div style="padding:16px 22px;border-bottom:1px solid #f1f5f9;display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px">
            <div>
                <p style="font-size:11px;color:#94a3b8;font-weight:500;margin:0">Tanggal Pinjam</p>
                <p style="font-size:13.5px;font-weight:700;color:#1e293b;margin:4px 0 0">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
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
                <p style="font-size:13.5px;font-weight:700;color:#1e293b;margin:4px 0 0">{{ $peminjaman->tanggal_kembali->format('d M Y') }}</p>
            </div>
            @endif
        </div>

        {{-- Denda Card (Hanya muncul jika sudah terlambat saat ini) --}}
        @if($hariTerlambat > 0)
        <div style="padding:16px 22px;background:#fef2f2;border-bottom:1px solid #fecaca">
            <div style="display:flex;align-items:flex-start;gap:12px">
                <div style="width:40px;height:40px;border-radius:10px;background:#fee2e2;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg style="width:18px;height:18px;color:#dc2626" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div style="flex:1">
                    <p style="font-weight:800;color:#dc2626;font-size:14px;margin:0">Terlambat {{ $hariTerlambat }} Hari</p>
                    <p style="font-size:13px;color:#ef4444;margin:4px 0 0">
                        Total denda estimasi: <strong>Rp {{ number_format($jumlahDenda, 0, ',', '.') }}</strong>
                    </p>
                    @if($dendaSetting && $dendaSetting->no_rekening)
                    <div style="margin-top:10px;padding:10px 14px;border-radius:10px;background:#fff;border:1px solid #fecaca">
                        <p style="font-size:11px;color:#94a3b8;margin:0">Bayar denda ke:</p>
                        <p style="font-size:14px;font-weight:800;color:#1e293b;margin:4px 0 2px">{{ $dendaSetting->no_rekening }}</p>
                        <p style="font-size:12px;color:#64748b;margin:0">a/n {{ $dendaSetting->nama_rekening ?? 'Admin' }} ({{ $dendaSetting->bank ?? '-' }})</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Form Pengembalian --}}
    @if($peminjaman->status === 'disetujui')
    <div style="background:#fff;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.05);overflow:hidden">
        <div style="padding:18px 22px;border-bottom:1px solid #f1f5f9">
            <p style="font-size:14px;font-weight:800;color:#1e293b;margin:0">Form Pengembalian</p>
        </div>

        <form method="POST" action="{{ route('peminjaman.kembalikan', $peminjaman) }}"
              enctype="multipart/form-data" id="formKembali"
              style="padding:20px 22px;display:flex;flex-direction:column;gap:16px">
            @csrf

            <div>
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:7px">Tanggal Pengembalian <span style="color:#ef4444">*</span></label>
                <input type="date" name="tanggal_kembali" id="tanggal_kembali" required
                    data-rencana="{{ $peminjaman->tanggal_rencana_kembali->format('Y-m-d') }}"
                    data-dendaperhari="{{ $dendaSetting->denda_per_hari ?? 0 }}"
                    min="{{ $today->format('Y-m-d') }}"
                    value="{{ old('tanggal_kembali', $today->format('Y-m-d')) }}"
                    style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13.5px;box-sizing:border-box">
            </div>

            <div>
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:7px">Foto Buku Dikembalikan <span style="color:#ef4444">*</span></label>
                <div onclick="document.getElementById('foto_pengembalian').click()" style="border:2px dashed #e2e8f0;border-radius:12px;padding:24px;text-align:center;cursor:pointer">
                    <div id="previewFotoPlaceholder">
                        <div style="font-size:24px">📷</div>
                        <p style="font-size:12px;color:#94a3b8;margin-top:4px">Klik untuk upload foto (Maks 2MB)</p>
                    </div>
                    <img id="imgPreviewFoto" src="" style="display:none;max-height:150px;margin:0 auto;border-radius:8px">
                </div>
                <input type="file" id="foto_pengembalian" name="foto_pengembalian" accept="image/*" required style="display:none"
                    onchange="previewGambar(this,'imgPreviewFoto','previewFotoPlaceholder')">
            </div>

            <div id="seksiBuktiBayar" style="display:none">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:7px">Bukti Pembayaran Denda <span style="color:#ef4444">*</span></label>
                <p style="font-size:12px;color:#dc2626;font-weight:600;margin-bottom:8px">Total Denda: <strong id="teksDenda">Rp 0</strong></p>
                <div onclick="document.getElementById('foto_bukti_denda').click()" style="border:2px dashed #fca5a5;border-radius:12px;padding:24px;text-align:center;cursor:pointer;background:#fff8f8">
                    <div id="previewDendaPlaceholder">
                        <div style="font-size:24px">💳</div>
                        <p style="font-size:12px;color:#64748b;margin-top:4px">Upload Bukti Transfer</p>
                    </div>
                    <img id="imgPreviewDenda" src="" style="display:none;max-height:150px;margin:0 auto;border-radius:8px">
                </div>
                <input type="file" id="foto_bukti_denda" name="foto_bukti_denda" accept="image/*" style="display:none"
                    onchange="previewGambar(this,'imgPreviewDenda','previewDendaPlaceholder')">
            </div>

            <button type="submit" id="btnSubmit"
                style="width:100%;padding:14px;border-radius:10px;border:none;color:#fff;font-weight:700;cursor:pointer;background:linear-gradient(135deg,#3b82f6,#2563eb)">
                Ajukan Pengembalian
            </button>
        </form>
    </div>
    @endif

    {{-- Status Lainnya (Sama seperti kodemu) --}}
    @if(in_array($peminjaman->status, ['pengajuan_kembali', 'dikembalikan', 'ditolak']))
    <div style="background:#fff;border-radius:16px;border:1px solid #e2e8f0;padding:40px;text-align:center">
        {{-- Logika Icon & Pesan berdasarkan status --}}
        @if($peminjaman->status === 'pengajuan_kembali')
            <p style="font-weight:800;color:#7c3aed">Pengembalian Sedang Diproses</p>
        @elseif($peminjaman->status === 'dikembalikan')
            <p style="font-weight:800;color:#15803d">Buku Sudah Dikembalikan</p>
        @else
            <p style="font-weight:800;color:#dc2626">Peminjaman Ditolak</p>
        @endif
    </div>
    @endif

</div>

<script>
// Validasi Ukuran File & Preview
function previewGambar(input, imgId, placeholderId) {
    const file = input.files[0];
    if (!file) return;

    if (file.size > 2097152) { // 2MB
        Swal.fire('File Terlalu Besar', 'Maksimal ukuran file adalah 2MB', 'error');
        input.value = "";
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById(imgId);
        img.src = e.target.result;
        img.style.display = 'block';
        document.getElementById(placeholderId).style.display = 'none';
    };
    reader.readAsDataURL(file);
}

// Kalkulasi Denda Dinamis
const elTgl = document.getElementById('tanggal_kembali');
function cekDenda(tglInput) {
    const rencana = new Date(tglInput.dataset.rencana);
    const pilihan = new Date(tglInput.value);
    const dendaPerHari = parseInt(tglInput.dataset.dendaperhari) || 0;
    const seksi = document.getElementById('seksiBuktiBayar');
    const inpDenda = document.getElementById('foto_bukti_denda');
    const teksDenda = document.getElementById('teksDenda');

    if (!seksi) return;
    rencana.setHours(0,0,0,0);
    pilihan.setHours(0,0,0,0);

    if (pilihan > rencana) {
        seksi.style.display = 'block';
        if (inpDenda) inpDenda.required = true;
        const selisih = Math.ceil((pilihan - rencana) / (1000 * 60 * 60 * 24)); 
        teksDenda.innerText = 'Rp ' + (selisih * dendaPerHari).toLocaleString('id-ID');
    } else {
        seksi.style.display = 'none';
        if (inpDenda) {
            inpDenda.required = false;
            inpDenda.value = ""; // Reset file jika user ganti ke tgl tidak denda
        }
    }
}

if (elTgl) {
    cekDenda(elTgl);
    elTgl.addEventListener('change', function() { cekDenda(this); });
}

// Proteksi Double Submit
const form = document.getElementById('formKembali');
if(form) {
    form.addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.style.opacity = '0.7';
        btn.innerText = 'Sedang Mengirim...';
    });
}
</script>

@if(session('success'))
<script>
Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: '{{ session('success') }}', showConfirmButton: false, timer: 3000 });
</script>
@endif

@endsection