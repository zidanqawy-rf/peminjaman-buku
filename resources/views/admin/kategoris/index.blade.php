@extends('layouts.app-admin')
@section('content')

@section('header') Kelola Kategori @endsection

@section('content')
<style>
    .page-wrap { padding:2rem 1.5rem; max-width:900px; margin:0 auto; }
    .top-bar { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; }
    .top-bar h2 { font-size:1.4rem; font-weight:800; color:#14532d; }
    .btn { display:inline-flex; align-items:center; gap:.4rem; padding:.6rem 1.2rem; border-radius:.65rem; font-size:.875rem; font-weight:600; border:none; cursor:pointer; text-decoration:none; transition:all .2s; }
    .btn-green { background:linear-gradient(135deg,#16a34a,#14532d); color:white; box-shadow:0 2px 8px rgba(22,163,74,.3); }
    .btn-green:hover { opacity:.9; transform:translateY(-1px); }
    .btn-yellow { background:#f59e0b; color:white; }
    .btn-yellow:hover { background:#d97706; }
    .btn-red { background:#ef4444; color:white; }
    .btn-red:hover { background:#dc2626; }
    .btn-gray { background:#e2e8f0; color:#374151; }
    .btn-gray:hover { background:#cbd5e1; }
    .btn-sm { padding:.4rem .85rem; font-size:.78rem; }
    .alert-success { background:#f0fdf4; border:1px solid #86efac; color:#166534; padding:.85rem 1rem; border-radius:.75rem; margin-bottom:1.25rem; font-size:.875rem; }
    .table-wrap { background:white; border-radius:1rem; box-shadow:0 2px 12px rgba(0,0,0,.07); overflow:hidden; border:1px solid #e2e8f0; }
    table { width:100%; border-collapse:collapse; }
    thead { background:linear-gradient(135deg,#16a34a,#14532d); }
    thead th { padding:.9rem 1.2rem; text-align:left; font-size:.82rem; font-weight:700; color:white; letter-spacing:.04em; text-transform:uppercase; }
    tbody tr { border-bottom:1px solid #f1f5f9; transition:background .15s; }
    tbody tr:hover { background:#f8fafc; }
    tbody tr:last-child { border-bottom:none; }
    td { padding:.85rem 1.2rem; font-size:.875rem; color:#374151; }
    .badge { background:#dcfce7; color:#166534; font-size:.72rem; font-weight:700; padding:.25rem .7rem; border-radius:99px; }
    .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:1000; align-items:center; justify-content:center; padding:1rem; }
    .modal-overlay.active { display:flex; }
    .modal { background:white; border-radius:1.25rem; padding:2rem; width:100%; max-width:440px; box-shadow:0 20px 60px rgba(0,0,0,.2); }
    .modal-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; }
    .modal-title { font-size:1.15rem; font-weight:800; color:#14532d; }
    .modal-close { background:none; border:none; font-size:1.4rem; cursor:pointer; color:#64748b; }
    .form-group { margin-bottom:1rem; }
    .form-label { display:block; font-size:.82rem; font-weight:600; color:#374151; margin-bottom:.4rem; }
    .form-input, .form-textarea { width:100%; border:1.5px solid #d1d5db; border-radius:.65rem; padding:.65rem .9rem; font-size:.9rem; color:#111827; outline:none; transition:border-color .2s; font-family:inherit; }
    .form-input:focus, .form-textarea:focus { border-color:#16a34a; box-shadow:0 0 0 3px rgba(22,163,74,.12); }
    .form-textarea { resize:vertical; min-height:80px; }
    .form-actions { display:flex; gap:.75rem; justify-content:flex-end; margin-top:1.25rem; }
</style>

<div class="page-wrap">

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="top-bar">
        <h2>🏷️ Kelola Kategori</h2>
        <button class="btn btn-green" onclick="openModal('modalTambah')">➕ Tambah Kategori</button>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Buku</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $i => $kat)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><span class="badge">{{ $kat->nama_kategori }}</span></td>
                    <td>{{ $kat->deskripsi ?? '-' }}</td>
                    <td>{{ $kat->bukus_count }} buku</td>
                    <td style="display:flex; gap:.5rem;">
                        <button class="btn btn-yellow btn-sm"
                            onclick="openEdit({{ $kat->id }}, '{{ addslashes($kat->nama_kategori) }}', '{{ addslashes($kat->deskripsi) }}')">
                            ✏️ Edit
                        </button>
                        <form method="POST" action="{{ route('admin.kategoris.destroy', $kat) }}" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-red btn-sm">🗑️</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; color:#94a3b8; padding:2.5rem;">Belum ada kategori</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal-overlay" id="modalTambah">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">➕ Tambah Kategori</span>
            <button class="modal-close" onclick="closeModal('modalTambah')">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.kategoris.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Kategori *</label>
                <input type="text" name="nama_kategori" class="form-input" required placeholder="Contoh: Fiksi, Sains, Sejarah...">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-textarea" placeholder="Deskripsi kategori (opsional)"></textarea>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-gray" onclick="closeModal('modalTambah')">Batal</button>
                <button type="submit" class="btn btn-green">💾 Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal-overlay" id="modalEdit">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">✏️ Edit Kategori</span>
            <button class="modal-close" onclick="closeModal('modalEdit')">✕</button>
        </div>
        <form method="POST" id="formEdit">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Nama Kategori *</label>
                <input type="text" name="nama_kategori" id="edit_nama" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="edit_deskripsi" class="form-textarea"></textarea>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-gray" onclick="closeModal('modalEdit')">Batal</button>
                <button type="submit" class="btn btn-green">💾 Update</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) { document.getElementById(id).classList.add('active'); document.body.style.overflow='hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('active'); document.body.style.overflow=''; }
document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', function(e) { if (e.target===this) closeModal(this.id); });
});
function openEdit(id, nama, deskripsi) {
    document.getElementById('formEdit').action = '/admin/kategoris/' + id;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_deskripsi').value = deskripsi;
    openModal('modalEdit');
}
</script>
@endsection