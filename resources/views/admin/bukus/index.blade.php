@extends('layouts.app-admin')
@section('content')

<style>
    .page-wrap { padding: 2rem 1.5rem; max-width: 1200px; margin: 0 auto; }

    /* Top bar */
    .top-bar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; margin-bottom:1.5rem; }
    .top-bar h2 { font-size:1.4rem; font-weight:800; color:#14532d; }
    .top-actions { display:flex; gap:.75rem; flex-wrap:wrap; }

    /* Buttons */
    .btn { display:inline-flex; align-items:center; gap:.4rem; padding:.6rem 1.2rem; border-radius:.65rem; font-size:.875rem; font-weight:600; border:none; cursor:pointer; text-decoration:none; transition:all .2s; }
    .btn-green  { background:linear-gradient(135deg,#16a34a,#14532d); color:white; box-shadow:0 2px 8px rgba(22,163,74,.3); }
    .btn-green:hover  { opacity:.9; transform:translateY(-1px); }
    .btn-yellow { background:#f59e0b; color:white; }
    .btn-yellow:hover { background:#d97706; }
    .btn-red    { background:#ef4444; color:white; }
    .btn-red:hover    { background:#dc2626; }
    .btn-gray   { background:#e2e8f0; color:#374151; }
    .btn-gray:hover   { background:#cbd5e1; }
    .btn-blue   { background:#3b82f6; color:white; }
    .btn-blue:hover   { background:#2563eb; }
    .btn-sm { padding:.4rem .85rem; font-size:.78rem; }

    /* Alerts */
    .alert-success { background:#f0fdf4; border:1px solid #86efac; color:#166534; padding:.85rem 1rem; border-radius:.75rem; margin-bottom:1.25rem; font-size:.875rem; }
    .alert-error   { background:#fef2f2; border:1px solid #fca5a5; color:#991b1b; padding:.85rem 1rem; border-radius:.75rem; margin-bottom:1.25rem; font-size:.875rem; }
    .alert-warning { background:#fffbeb; border:1px solid #fcd34d; color:#92400e; padding:.85rem 1rem; border-radius:.75rem; margin-bottom:1.25rem; font-size:.875rem; }
    .alert-warning ul { margin:.4rem 0 0 1.2rem; }
    .alert-warning li { font-size:.82rem; margin-bottom:.2rem; }

    /* Grid buku */
    .book-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(220px,1fr)); gap:1.25rem; }
    .book-card { background:white; border-radius:1rem; box-shadow:0 2px 12px rgba(0,0,0,.07); border:1px solid #e2e8f0; overflow:hidden; transition:all .25s; }
    .book-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(22,163,74,.15); border-color:#bbf7d0; }
    .book-img { width:100%; height:160px; object-fit:cover; background:#f1f5f9; display:flex; align-items:center; justify-content:center; font-size:3.5rem; }
    .book-img img { width:100%; height:100%; object-fit:cover; }
    .book-body { padding:1rem; }
    .book-title { font-weight:700; font-size:.95rem; color:#1e293b; margin-bottom:.25rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .book-author { font-size:.78rem; color:#64748b; margin-bottom:.5rem; }
    .book-meta { display:flex; align-items:center; justify-content:space-between; margin-bottom:.75rem; }
    .badge-kategori { background:#dcfce7; color:#166534; font-size:.7rem; font-weight:600; padding:.2rem .6rem; border-radius:99px; }
    .stok-info { font-size:.78rem; font-weight:600; }
    .stok-ok { color:#16a34a; }
    .stok-low { color:#f59e0b; }
    .stok-empty { color:#ef4444; }
    .book-actions { display:flex; gap:.5rem; }

    /* Modal */
    .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:1000; align-items:center; justify-content:center; padding:1rem; }
    .modal-overlay.active { display:flex; }
    .modal { background:white; border-radius:1.25rem; padding:2rem; width:100%; max-width:580px; max-height:90vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,.2); }
    .modal-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; }
    .modal-title { font-size:1.2rem; font-weight:800; color:#14532d; }
    .modal-close { background:none; border:none; font-size:1.4rem; cursor:pointer; color:#64748b; padding:.2rem .5rem; border-radius:.5rem; }
    .modal-close:hover { background:#f1f5f9; }

    /* Form */
    .form-group { margin-bottom:1rem; }
    .form-label { display:block; font-size:.82rem; font-weight:600; color:#374151; margin-bottom:.4rem; }
    .form-input, .form-select, .form-textarea {
        width:100%; border:1.5px solid #d1d5db; border-radius:.65rem;
        padding:.65rem .9rem; font-size:.9rem; color:#111827; outline:none;
        transition:border-color .2s, box-shadow .2s; font-family:inherit;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color:#16a34a; box-shadow:0 0 0 3px rgba(22,163,74,.12);
    }
    .form-textarea { resize:vertical; min-height:80px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
    .form-actions { display:flex; gap:.75rem; justify-content:flex-end; margin-top:1.25rem; }

    /* Import box */
    .import-box { background:#f8fafc; border:1.5px dashed #94a3b8; border-radius:.75rem; padding:1.25rem; margin-bottom:1rem; }
    .import-box p { font-size:.82rem; color:#64748b; margin-top:.5rem; }

    /* Empty state */
    .empty-state { text-align:center; padding:4rem 1rem; color:#94a3b8; }
    .empty-state .icon { font-size:3.5rem; margin-bottom:1rem; }

    /* Filter bar */
    .filter-bar { display:flex; gap:.75rem; margin-bottom:1.5rem; flex-wrap:wrap; align-items:center; }
    .filter-bar input, .filter-bar select {
        padding:.55rem .9rem; border:1.5px solid #d1d5db; border-radius:.65rem;
        font-size:.875rem; outline:none; color:#374151;
    }
    .filter-bar input:focus, .filter-bar select:focus { border-color:#16a34a; }
    .filter-bar input { flex:1; min-width:180px; }
</style>

<div class="page-wrap">

    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    {{-- Alert Error file import --}}
    @if($errors->has('file'))
        <div class="alert-error">❌ {{ $errors->first('file') }}</div>
    @endif

    {{-- Alert Baris yang Dilewati Saat Import --}}
    @if(session('import_errors'))
        <div class="alert-warning">
            ⚠️ Beberapa baris dilewati karena data tidak valid:
            <ul>
                @foreach(session('import_errors') as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="top-bar">
        <h2>📚 Kelola Buku</h2>
        <div class="top-actions">
            <button class="btn btn-blue" onclick="openModal('modalImport')">📥 Import Excel</button>
            <button class="btn btn-green" onclick="openModal('modalTambah')">➕ Tambah Buku</button>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-bar">
        <input type="text" id="searchInput" placeholder="🔍 Cari nama buku, pengarang..." onkeyup="filterBuku()">
        <select id="filterKategori" onchange="filterBuku()">
            <option value="">Semua Kategori</option>
            @foreach($kategoris as $kat)
                <option value="{{ $kat->nama_kategori }}">{{ $kat->nama_kategori }}</option>
            @endforeach
        </select>
    </div>

    {{-- Grid Buku --}}
    @if($bukus->isEmpty())
        <div class="empty-state">
            <div class="icon">📭</div>
            <p>Belum ada data buku. Tambahkan buku pertama!</p>
        </div>
    @else
        <div class="book-grid" id="bookGrid">
            @foreach($bukus as $buku)
            <div class="book-card"
                 data-nama="{{ strtolower($buku->nama_buku) }}"
                 data-pengarang="{{ strtolower($buku->pengarang ?? '') }}"
                 data-kategori="{{ $buku->kategori?->nama_kategori }}">
                <div class="book-img">
                    @if($buku->gambar)
                        <img src="{{ Storage::url($buku->gambar) }}" alt="{{ $buku->nama_buku }}">
                    @else
                        📖
                    @endif
                </div>
                <div class="book-body">
                    <div class="book-title" title="{{ $buku->nama_buku }}">{{ $buku->nama_buku }}</div>
                    <div class="book-author">{{ $buku->pengarang ?? 'Pengarang tidak diketahui' }}</div>
                    <div class="book-meta">
                        <span class="badge-kategori">{{ $buku->kategori?->nama_kategori ?? 'Tanpa Kategori' }}</span>
                        @php $stok = $buku->stok_tersedia; @endphp
                        <span class="stok-info {{ $stok > 3 ? 'stok-ok' : ($stok > 0 ? 'stok-low' : 'stok-empty') }}">
                            Stok: {{ $stok }}/{{ $buku->jumlah_buku }}
                        </span>
                    </div>
                    <div class="book-actions">
                        <button class="btn btn-yellow btn-sm" style="flex:1"
                            onclick="openEdit(
                                {{ $buku->id }},
                                '{{ addslashes($buku->nama_buku) }}',
                                '{{ addslashes($buku->deskripsi ?? '') }}',
                                {{ $buku->jumlah_buku }},
                                '{{ $buku->kategori_id ?? '' }}',
                                '{{ addslashes($buku->pengarang ?? '') }}',
                                '{{ addslashes($buku->penerbit ?? '') }}',
                                '{{ $buku->tahun_terbit ?? '' }}'
                            )">✏️ Edit</button>
                        <form method="POST" action="{{ route('admin.bukus.destroy', $buku) }}"
                              onsubmit="return confirm('Hapus buku ini?')" style="flex:1">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-red btn-sm" style="width:100%">🗑️ Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

{{-- ═══════════════════ MODAL TAMBAH ═══════════════════ --}}
<div class="modal-overlay" id="modalTambah">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">➕ Tambah Buku</span>
            <button class="modal-close" onclick="closeModal('modalTambah')">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.bukus.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label">Nama Buku *</label>
                    <input type="text" name="nama_buku" class="form-input" required placeholder="Judul buku" value="{{ old('nama_buku') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Pengarang</label>
                    <input type="text" name="pengarang" class="form-input" placeholder="Nama pengarang" value="{{ old('pengarang') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Penerbit</label>
                    <input type="text" name="penerbit" class="form-input" placeholder="Nama penerbit" value="{{ old('penerbit') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Jumlah Buku *</label>
                    <input type="number" name="jumlah_buku" class="form-input" required min="1" placeholder="0" value="{{ old('jumlah_buku') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" class="form-input" placeholder="{{ date('Y') }}" min="1900" max="{{ date('Y') }}" value="{{ old('tahun_terbit') }}">
                </div>
                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" class="form-select">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-textarea" placeholder="Deskripsi singkat buku...">{{ old('deskripsi') }}</textarea>
                </div>
                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label">Gambar Cover</label>
                    <input type="file" name="gambar" class="form-input" accept="image/*">
                </div>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-gray" onclick="closeModal('modalTambah')">Batal</button>
                <button type="submit" class="btn btn-green">💾 Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════ MODAL EDIT ═══════════════════ --}}
<div class="modal-overlay" id="modalEdit">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">✏️ Edit Buku</span>
            <button class="modal-close" onclick="closeModal('modalEdit')">✕</button>
        </div>
        <form method="POST" id="formEdit" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-row">
                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label">Nama Buku *</label>
                    <input type="text" name="nama_buku" id="edit_nama_buku" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Pengarang</label>
                    <input type="text" name="pengarang" id="edit_pengarang" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Penerbit</label>
                    <input type="text" name="penerbit" id="edit_penerbit" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Jumlah Buku *</label>
                    <input type="number" name="jumlah_buku" id="edit_jumlah_buku" class="form-input" required min="1">
                </div>
                <div class="form-group">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" id="edit_tahun_terbit" class="form-input" min="1900" max="{{ date('Y') }}">
                </div>
                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" id="edit_kategori_id" class="form-select">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="edit_deskripsi" class="form-textarea"></textarea>
                </div>
                <div class="form-group" style="grid-column:span 2">
                    <label class="form-label">Gambar Cover <small style="color:#94a3b8">(kosongkan jika tidak diubah)</small></label>
                    <input type="file" name="gambar" class="form-input" accept="image/*">
                </div>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-gray" onclick="closeModal('modalEdit')">Batal</button>
                <button type="submit" class="btn btn-green">💾 Update</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════ MODAL IMPORT ═══════════════════ --}}
<div class="modal-overlay" id="modalImport">
    <div class="modal" style="max-width:460px">
        <div class="modal-header">
            <span class="modal-title">📥 Import Data Buku</span>
            <button class="modal-close" onclick="closeModal('modalImport')">✕</button>
        </div>

        {{-- Tampilkan error validasi file di dalam modal --}}
        @if($errors->has('file'))
        <div style="background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;padding:.75rem 1rem;border-radius:.65rem;margin-bottom:1rem;font-size:.82rem;">
            ❌ {{ $errors->first('file') }}
        </div>
        @endif

        <form method="POST" action="{{ route('admin.bukus.import') }}" enctype="multipart/form-data">
            @csrf
            <div class="import-box">
                <input type="file" name="file" class="form-input" accept=".xlsx,.xls,.csv" required>
                <p style="margin-top:.75rem">Format: <strong>.xlsx / .xls / .csv</strong> &nbsp;|&nbsp; Maks: <strong>5 MB</strong></p>
                <p style="margin-top:.4rem">Kolom wajib: <strong>nama_buku, jumlah_buku</strong></p>
                <p style="margin-top:.2rem">Kolom opsional: deskripsi, kategori, pengarang, penerbit, tahun_terbit</p>
            </div>

            {{-- Contoh header Excel --}}
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:.65rem;padding:.75rem 1rem;margin-bottom:1rem;font-size:.78rem;color:#166534;">
                <strong>📋 Pastikan header Excel persis:</strong><br>
                <code style="font-size:.75rem;letter-spacing:.5px">nama_buku | jumlah_buku | deskripsi | kategori | pengarang | penerbit | tahun_terbit</code>
            </div>

            <a href="#" onclick="downloadTemplate(); return false;"
               style="display:block;font-size:.82rem;color:#16a34a;margin-bottom:1rem;text-decoration:underline;">
                📄 Download template CSV
            </a>

            <div class="form-actions">
                <button type="button" class="btn btn-gray" onclick="closeModal('modalImport')">Batal</button>
                <button type="submit" class="btn btn-green">📤 Import</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('active');
    document.body.style.overflow = '';
}

// Tutup saat klik di luar modal
document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});

function openEdit(id, nama, deskripsi, jumlah, kategoriId, pengarang, penerbit, tahun) {
    document.getElementById('formEdit').action = '/admin/bukus/' + id;
    document.getElementById('edit_nama_buku').value    = nama;
    document.getElementById('edit_deskripsi').value   = deskripsi;
    document.getElementById('edit_jumlah_buku').value = jumlah;
    document.getElementById('edit_kategori_id').value = kategoriId;
    document.getElementById('edit_pengarang').value   = pengarang;
    document.getElementById('edit_penerbit').value    = penerbit;
    document.getElementById('edit_tahun_terbit').value = tahun;
    openModal('modalEdit');
}

// Filter buku
function filterBuku() {
    const search  = document.getElementById('searchInput').value.toLowerCase();
    const kategori = document.getElementById('filterKategori').value.toLowerCase();
    document.querySelectorAll('.book-card').forEach(card => {
        const nama      = card.dataset.nama      || '';
        const pengarang = card.dataset.pengarang || '';
        const kat       = (card.dataset.kategori || '').toLowerCase();
        const matchSearch = nama.includes(search) || pengarang.includes(search);
        const matchKat    = !kategori || kat === kategori;
        card.style.display = (matchSearch && matchKat) ? '' : 'none';
    });
}

// Download template CSV
function downloadTemplate() {
    const csv = [
        'nama_buku,jumlah_buku,deskripsi,kategori,pengarang,penerbit,tahun_terbit',
        'Laskar Pelangi,5,Novel inspiratif,Fiksi,Andrea Hirata,Bentang Pustaka,2005',
        'Belajar Laravel,3,Panduan web development,Teknologi,Pak Budi,Elex Media,2023',
    ].join('\n');
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const url  = URL.createObjectURL(blob);
    const a    = document.createElement('a');
    a.href = url;
    a.download = 'template_import_buku.csv';
    a.click();
    URL.revokeObjectURL(url);
}

// Buka modal yang relevan jika ada error
@if($errors->has('file'))
    openModal('modalImport');
@elseif($errors->any())
    openModal('modalTambah');
@endif
</script>

@endsection