@extends('layouts.app-admin')

@section('header') Pengaturan Denda @endsection

@section('content')
<style>
    .page-wrap { padding:2rem 1.5rem; max-width:1100px; margin:0 auto; }

    /* Stat cards */
    .stat-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:1.25rem; margin-bottom:2rem; }
    .stat-card { background:white; border-radius:1rem; padding:1.5rem; box-shadow:0 2px 12px rgba(0,0,0,.07); border:1px solid #e2e8f0; }
    .stat-card .label { font-size:.8rem; color:#64748b; font-weight:600; text-transform:uppercase; letter-spacing:.04em; margin-bottom:.5rem; }
    .stat-card .value { font-size:1.75rem; font-weight:800; }
    .stat-card .icon { font-size:1.75rem; margin-bottom:.5rem; }
    .val-red    { color:#ef4444; }
    .val-green  { color:#16a34a; }
    .val-yellow { color:#f59e0b; }
    .val-blue   { color:#3b82f6; }

    /* Section title */
    .section-title { font-size:1.1rem; font-weight:800; color:#14532d; margin-bottom:1rem; display:flex; align-items:center; gap:.5rem; }

    /* Alert */
    .alert-success { background:#f0fdf4; border:1px solid #86efac; color:#166534; padding:.85rem 1rem; border-radius:.75rem; margin-bottom:1.5rem; font-size:.875rem; }

    /* Setting card */
    .setting-card { background:white; border-radius:1rem; box-shadow:0 2px 12px rgba(0,0,0,.07); border:1px solid #e2e8f0; padding:2rem; margin-bottom:2rem; }

    /* Form */
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
    .form-group { margin-bottom:0; }
    .form-group.full { grid-column:span 2; }
    .form-label { display:block; font-size:.82rem; font-weight:600; color:#374151; margin-bottom:.4rem; }
    .form-input, .form-select, .form-textarea {
        width:100%; border:1.5px solid #d1d5db; border-radius:.65rem;
        padding:.7rem 1rem; font-size:.9rem; color:#111827; outline:none;
        transition:border-color .2s, box-shadow .2s; font-family:inherit; background:white;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color:#16a34a; box-shadow:0 0 0 3px rgba(22,163,74,.12);
    }
    .form-textarea { resize:vertical; min-height:80px; }
    .input-prefix { display:flex; align-items:center; }
    .input-prefix span {
        padding:.7rem .9rem; background:#f1f5f9; border:1.5px solid #d1d5db;
        border-right:none; border-radius:.65rem 0 0 .65rem; font-size:.9rem;
        color:#64748b; font-weight:600; white-space:nowrap;
    }
    .input-prefix .form-input { border-radius:0 .65rem .65rem 0; }
    .form-actions { margin-top:1.5rem; display:flex; gap:.75rem; justify-content:flex-end; }

    /* Buttons */
    .btn { display:inline-flex; align-items:center; gap:.4rem; padding:.65rem 1.35rem; border-radius:.65rem; font-size:.875rem; font-weight:600; border:none; cursor:pointer; transition:all .2s; }
    .btn-green { background:linear-gradient(135deg,#16a34a,#14532d); color:white; box-shadow:0 2px 8px rgba(22,163,74,.3); }
    .btn-green:hover { opacity:.9; transform:translateY(-1px); }
    .btn-sm { padding:.4rem .85rem; font-size:.78rem; }

    /* Info box */
    .info-box { background:#eff6ff; border:1px solid #bfdbfe; border-radius:.75rem; padding:1rem 1.25rem; margin-top:1rem; }
    .info-box p { font-size:.82rem; color:#1e40af; line-height:1.6; }

    /* Tabel denda aktif */
    .table-wrap { background:white; border-radius:1rem; box-shadow:0 2px 12px rgba(0,0,0,.07); overflow:hidden; border:1px solid #e2e8f0; }
    table { width:100%; border-collapse:collapse; }
    thead { background:linear-gradient(135deg,#16a34a,#14532d); }
    thead th { padding:.9rem 1rem; text-align:left; font-size:.78rem; font-weight:700; color:white; text-transform:uppercase; letter-spacing:.04em; }
    tbody tr { border-bottom:1px solid #f1f5f9; transition:background .15s; }
    tbody tr:hover { background:#f8fafc; }
    tbody tr:last-child { border-bottom:none; }
    td { padding:.85rem 1rem; font-size:.82rem; color:#374151; vertical-align:middle; }
    .badge { font-size:.7rem; font-weight:700; padding:.2rem .65rem; border-radius:99px; display:inline-block; }
    .badge-yellow { background:#fef9c3; color:#a16207; }
    .badge-green  { background:#dcfce7; color:#166534; }
    .badge-red    { background:#fee2e2; color:#991b1b; }

    /* Preview gambar */
    .img-thumb { width:3rem; height:3rem; object-fit:cover; border-radius:.5rem; border:1px solid #e2e8f0; cursor:pointer; }

    /* Modal */
    .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.6); z-index:1000; align-items:center; justify-content:center; padding:1rem; }
    .modal-overlay.active { display:flex; }
    .modal { background:white; border-radius:1.25rem; padding:2rem; width:100%; max-width:500px; max-height:90vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,.2); }
    .modal-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem; }
    .modal-title { font-size:1.1rem; font-weight:800; color:#14532d; }
    .modal-close { background:none; border:none; font-size:1.4rem; cursor:pointer; color:#64748b; }
    .modal img { width:100%; border-radius:.75rem; }
</style>

<div class="page-wrap">

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    {{-- Statistik Denda --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="icon">⚠️</div>
            <div class="label">Total Kasus Denda</div>
            <div class="value val-red">{{ $jumlahKasusDenda }}</div>
        </div>
        <div class="stat-card">
            <div class="icon">💰</div>
            <div class="label">Denda Belum Dibayar</div>
            <div class="value val-yellow">Rp {{ number_format($dendaBelumBayar, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="icon">✅</div>
            <div class="label">Total Denda Terkumpul</div>
            <div class="value val-green">Rp {{ number_format($totalDendaTerkumpul, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="icon">📅</div>
            <div class="label">Denda Per Hari</div>
            <div class="value val-blue">Rp {{ number_format($setting->denda_per_hari, 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- Form Pengaturan Denda --}}
    <div class="setting-card">
        <div class="section-title">⚙️ Pengaturan Denda</div>

        <form method="POST" action="{{ route('admin.denda.update') }}">
            @csrf
            <div class="form-grid">

                <div class="form-group">
                    <label class="form-label">💸 Denda Per Hari (Rp) *</label>
                    <div class="input-prefix">
                        <span>Rp</span>
                        <input type="number" name="denda_per_hari" class="form-input"
                            value="{{ $setting->denda_per_hari }}" min="0" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">🏦 Bank</label>
                    <select name="bank" class="form-select">
                        <option value="">-- Pilih Bank --</option>
                        @foreach(['BRI','BCA','BNI','Mandiri','BSI','DANA','GoPay','OVO','ShopeePay'] as $b)
                            <option value="{{ $b }}" {{ $setting->bank === $b ? 'selected' : '' }}>{{ $b }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">🔢 Nomor Rekening / Dompet Digital</label>
                    <input type="text" name="no_rekening" class="form-input"
                        value="{{ $setting->no_rekening }}" placeholder="Contoh: 1234567890">
                </div>

                <div class="form-group">
                    <label class="form-label">👤 Nama Pemilik Rekening</label>
                    <input type="text" name="nama_rekening" class="form-input"
                        value="{{ $setting->nama_rekening }}" placeholder="Nama pemilik rekening">
                </div>

                <div class="form-group full">
                    <label class="form-label">📝 Keterangan Pembayaran</label>
                    <textarea name="keterangan" class="form-textarea"
                        placeholder="Contoh: Transfer ke rekening BRI atas nama Admin Perpustakaan dengan berita: DENDA-[ID Peminjaman]">{{ $setting->keterangan }}</textarea>
                </div>

            </div>

            <div class="info-box">
                <p>ℹ️ <strong>Cara kerja denda:</strong> Jika siswa mengembalikan buku melebihi tanggal rencana kembali, sistem otomatis menghitung <strong>jumlah hari terlambat × denda per hari</strong>. Siswa wajib upload bukti pembayaran denda sebelum pengembalian diproses.</p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-green">💾 Simpan Pengaturan</button>
            </div>
        </form>
    </div>

    {{-- Tabel Riwayat Denda --}}
    <div class="section-title">📋 Riwayat Kasus Denda</div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Siswa</th>
                    <th>Buku</th>
                    <th>Tgl Rencana Kembali</th>
                    <th>Hari Terlambat</th>
                    <th>Jumlah Denda</th>
                    <th>Bukti Bayar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dendaAktif as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <strong style="display:block">{{ $p->user->name }}</strong>
                        <span style="color:#64748b;font-size:.75rem">{{ $p->user->kelas ?? '-' }} / {{ $p->user->jurusan ?? '-' }}</span>
                    </td>
                    <td>
                        {{-- ✅ Diperbaiki: $p->bukus → $p->buku (sesuai nama relasi di model) --}}
                        @foreach($p->buku as $bk)
                            <span style="display:block;font-size:.8rem">📖 {{ $bk->nama_buku }}</span>
                        @endforeach
                    </td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_rencana_kembali)->format('d M Y') }}</td>
                    <td>
                        <span style="color:#ef4444; font-weight:700">{{ $p->hari_terlambat }} hari</span>
                    </td>
                    <td>
                        <span style="color:#ef4444; font-weight:700">
                            Rp {{ number_format($p->jumlah_denda, 0, ',', '.') }}
                        </span>
                    </td>
                    <td>
                        @if($p->foto_bukti_denda)
                            <img src="{{ Storage::url($p->foto_bukti_denda) }}"
                                class="img-thumb"
                                onclick="lihatFoto('{{ Storage::url($p->foto_bukti_denda) }}')"
                                title="Klik untuk perbesar">
                        @else
                            <span style="color:#94a3b8;font-size:.75rem">Belum upload</span>
                        @endif
                    </td>
                    <td>
                        @if($p->status === 'pengajuan_kembali')
                            <span class="badge badge-yellow">⏳ Menunggu</span>
                        @elseif($p->status === 'dikembalikan')
                            <span class="badge badge-green">✅ Lunas</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; color:#94a3b8; padding:2.5rem;">
                        🎉 Tidak ada kasus denda
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- Modal Preview Foto --}}
<div class="modal-overlay" id="modalFoto">
    <div class="modal" style="max-width:600px">
        <div class="modal-header">
            <span class="modal-title">🖼️ Bukti Pembayaran Denda</span>
            <button class="modal-close" onclick="closeModal('modalFoto')">✕</button>
        </div>
        <img id="fotoPreview" src="" alt="Bukti Denda">
    </div>
</div>

<script>
function openModal(id) { document.getElementById(id).classList.add('active'); document.body.style.overflow='hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('active'); document.body.style.overflow=''; }
document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', e => { if(e.target===el) closeModal(el.id); });
});
function lihatFoto(url) {
    document.getElementById('fotoPreview').src = url;
    openModal('modalFoto');
}
</script>
@endsection