@extends('layouts.app')

@section('header')
    Tambah Peminjaman
@endsection

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="tambah-wrap">

    {{-- Page Header --}}
    <div class="page-header-row">
        <div>
            <p class="breadcrumb-text">Perpustakaan › Peminjaman › Tambah</p>
            <h1 class="page-title">Pinjam Buku</h1>
            <p class="page-subtitle">Pilih koleksi buku dan tentukan durasi peminjaman.</p>
        </div>
        <a href="{{ route('peminjaman.riwayat') }}" class="btn-back">
            <svg style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            <span class="btn-back-label">Kembali</span>
        </a>
    </div>

    @if($errors->any())
    <div style="padding:16px 20px;border-radius:14px;background:#fef2f2;border:1px solid #fecaca;color:#991b1b;font-size:13px;">
        <p style="font-weight:800;margin-bottom:8px;display:flex;align-items:center;gap:8px;">
            <svg style="width:18px;height:18px;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Mohon perhatikan kesalahan berikut:
        </p>
        <ul style="padding-left:26px;margin:0;font-weight:500;">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('peminjaman.store') }}">
        @csrf
        <div id="hiddenInputs"></div>

        <div class="tambah-grid">

            {{-- ═══ KIRI: Daftar Buku ═══ --}}
            <div style="display:flex;flex-direction:column;gap:16px;">
                <div style="background:#fff;border-radius:20px;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(0,0,0,.05);overflow:hidden;">
                    <div style="padding:18px 20px;border-bottom:1px solid #f1f5f9;background:#fafafa;">
                        <p style="font-size:15px;font-weight:800;color:#1e293b;margin:0;">Koleksi Tersedia</p>
                        <p style="font-size:12px;color:#94a3b8;margin-top:2px;margin-bottom:0;">Klik pada kartu buku untuk memasukkan ke keranjang.</p>
                    </div>

                    {{-- Search --}}
                    <div style="padding:14px 16px;background:#fff;border-bottom:1px solid #f1f5f9;">
                        <input type="text" id="cariInput" placeholder="Cari judul atau penulis..."
                            style="width:100%;border:1.5px solid #e2e8f0;border-radius:12px;padding:11px 14px;font-size:14px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box;transition:all 0.2s;"
                            onfocus="this.style.borderColor='#10b981';this.style.background='#fff';this.style.boxShadow='0 0 0 4px rgba(16,185,129,0.1)'"
                            onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none'"
                            oninput="cariBuku(this.value)">
                    </div>

                    {{-- List Buku --}}
                    <div class="list-buku-scroll" id="listBuku">
                        @forelse($buku as $b)
                        @php $stok = $b->stok_tersedia ?? $b->jumlah_buku; @endphp
                        <div class="item-buku"
                             data-judul="{{ strtolower($b->nama_buku) }} {{ strtolower($b->pengarang ?? '') }}"
                             style="padding:10px 12px;border-radius:12px;margin-bottom:4px;display:flex;align-items:center;gap:12px;transition:all .15s;border:1.5px solid transparent;{{ $stok <= 0 ? 'opacity:0.5;cursor:not-allowed;' : 'cursor:pointer;' }}"
                             @if($stok > 0)
                             onmouseover="this.style.background='#f0fdf4';this.style.borderColor='#bbf7d0'"
                             onmouseout="this.style.background='transparent';this.style.borderColor='transparent'"
                             onclick="tambahKeKeranjang({{ $b->id }}, '{{ addslashes($b->nama_buku) }}', {{ $stok }})"
                             @endif>

                            <div style="width:44px;height:56px;border-radius:8px;overflow:hidden;flex-shrink:0;border:1px solid #e2e8f0;background:linear-gradient(135deg,#ecfdf5,#d1fae5);display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(0,0,0,.08);">
                                @if($b->gambar)
                                    <img src="{{ Storage::url($b->gambar) }}" alt="{{ $b->nama_buku }}"
                                         style="width:100%;height:100%;object-fit:cover;"
                                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                    <div style="display:none;width:100%;height:100%;align-items:center;justify-content:center;">
                                        <svg style="width:20px;height:20px;color:#059669" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
                                        </svg>
                                    </div>
                                @else
                                    <svg style="width:20px;height:20px;color:#059669" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
                                    </svg>
                                @endif
                            </div>

                            <div style="flex:1;min-width:0;">
                                <p style="font-size:13.5px;font-weight:700;color:#1e293b;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $b->nama_buku }}
                                </p>
                                <p style="font-size:12px;color:#64748b;margin:2px 0 0;font-weight:500;">
                                    {{ $b->pengarang ?? 'Tanpa Penulis' }}
                                </p>
                                @if($b->kategori)
                                <span style="font-size:10px;font-weight:700;padding:2px 7px;border-radius:6px;background:#ecfdf5;color:#065f46;margin-top:4px;display:inline-block;">
                                    {{ $b->kategori->nama_kategori }}
                                </span>
                                @endif
                            </div>

                            <div style="text-align:right;flex-shrink:0;">
                                <span style="font-size:11px;font-weight:800;padding:4px 9px;border-radius:8px;
                                    {{ $stok > 3 ? 'background:#dcfce7;color:#166534;' : ($stok > 0 ? 'background:#fef9c3;color:#854d0e;' : 'background:#fee2e2;color:#991b1b;') }}
                                    text-transform:uppercase;display:block;margin-bottom:2px;white-space:nowrap;">
                                    {{ $stok <= 0 ? 'Habis' : 'Stok: '.$stok }}
                                </span>
                                <span style="font-size:10px;color:#94a3b8;font-weight:500;">dari {{ $b->jumlah_buku }}</span>
                            </div>
                        </div>
                        @empty
                        <div style="padding:60px 20px;text-align:center;color:#94a3b8;">
                            <p style="font-size:36px;margin-bottom:10px;">📭</p>
                            <p style="font-size:14px;font-weight:500;">Koleksi buku belum tersedia.</p>
                        </div>
                        @endforelse
                        <div id="tidakDitemukan" style="display:none;padding:40px 20px;text-align:center;color:#94a3b8;">
                            <p style="font-size:28px;margin-bottom:8px;">🔍</p>
                            <p style="font-size:14px;font-weight:500;">Buku tidak ditemukan.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ KANAN: Keranjang & Form ═══ --}}
            <div class="sidebar-panel">

                {{-- Keranjang --}}
                <div style="background:#fff;border-radius:20px;border:1px solid #e2e8f0;box-shadow:0 4px 15px rgba(0,0,0,0.04);overflow:hidden;">
                    <div style="padding:16px 18px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;background:#f8fafc;">
                        <p style="font-size:14px;font-weight:800;color:#1e293b;margin:0;">Buku Dipilih</p>
                        <span id="badgeJumlah" style="font-size:11px;font-weight:800;padding:4px 10px;border-radius:10px;background:#10b981;color:#fff;">0 Buku</span>
                    </div>
                    <div id="keranjangList" style="padding:10px 18px;min-height:80px;">
                        <div id="keranjangKosong" style="text-align:center;padding:28px 0;color:#94a3b8;">
                            <div style="font-size:30px;margin-bottom:8px;filter:grayscale(1);">📚</div>
                            <p style="font-size:13px;font-weight:500;margin:0;">Keranjang masih kosong</p>
                        </div>
                    </div>
                </div>

                {{-- Form Waktu --}}
                <div style="background:#fff;border-radius:20px;border:1px solid #e2e8f0;box-shadow:0 4px 15px rgba(0,0,0,0.04);overflow:hidden;">
                    <div style="padding:16px 18px;border-bottom:1px solid #f1f5f9;background:#f8fafc;">
                        <p style="font-size:14px;font-weight:800;color:#1e293b;margin:0;">Pengaturan Waktu</p>
                    </div>
                    <div style="padding:18px;display:flex;flex-direction:column;gap:16px;">

                        <div>
                            <label style="display:block;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;color:#64748b;margin-bottom:7px;">
                                Tanggal Mulai Pinjam
                            </label>
                            <input type="date" name="tanggal_pinjam" id="inputTglPinjam" required
                                value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                                min="{{ date('Y-m-d') }}"
                                style="width:100%;border:1.5px solid #e2e8f0;border-radius:12px;padding:11px;font-size:14px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box;font-weight:600;"
                                onfocus="this.style.borderColor='#10b981';this.style.background='#fff'"
                                onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'"
                                onchange="updateMinKembali(this.value)">
                        </div>

                        <div>
                            <label style="display:block;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;color:#64748b;margin-bottom:7px;">
                                Target Pengembalian
                            </label>
                            <input type="date" name="tanggal_rencana_kembali" id="inputTglKembali" required
                                value="{{ old('tanggal_rencana_kembali') }}"
                                min="{{ date('Y-m-d') }}"
                                style="width:100%;border:1.5px solid #e2e8f0;border-radius:12px;padding:11px;font-size:14px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box;font-weight:600;"
                                onfocus="this.style.borderColor='#10b981';this.style.background='#fff'"
                                onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'">
                            <p style="font-size:11px;color:#94a3b8;margin:5px 0 0;">⚠️ Minimal sama dengan tanggal pinjam</p>
                        </div>

                        <div>
                            <label style="display:block;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;color:#64748b;margin-bottom:7px;">Catatan Tambahan</label>
                            <textarea name="catatan" rows="3" placeholder="Contoh: Titip ke ketua kelas..."
                                style="width:100%;border:1.5px solid #e2e8f0;border-radius:12px;padding:11px;font-size:14px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box;resize:none;font-family:inherit;"
                                onfocus="this.style.borderColor='#10b981';this.style.background='#fff'"
                                onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'">{{ old('catatan') }}</textarea>
                        </div>

                        <button type="submit" id="btnSubmit"
                            style="width:100%;padding:13px;border-radius:14px;border:none;color:#fff;font-size:14px;font-weight:800;cursor:pointer;background:linear-gradient(135deg,#10b981,#047857);box-shadow:0 4px 12px rgba(16,185,129,.3);transition:all .2s;opacity:.5;pointer-events:none;text-transform:uppercase;letter-spacing:0.5px;"
                            onmouseover="if(this.style.opacity==='1'){this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(16,185,129,.4)'}"
                            onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 12px rgba(16,185,129,.3)'">
                            Konfirmasi Pinjaman
                        </button>
                    </div>
                </div>

            </div>{{-- /sidebar-panel --}}
        </div>{{-- /tambah-grid --}}
    </form>
</div>{{-- /tambah-wrap --}}

<script>
const keranjang = {};

function updateMinKembali(tglPinjam) {
    const inputKembali = document.getElementById('inputTglKembali');
    if (!tglPinjam || !inputKembali) return;
    inputKembali.min = tglPinjam;
    if (!inputKembali.value || inputKembali.value < tglPinjam) inputKembali.value = tglPinjam;
}

function render() {
    const ids    = Object.keys(keranjang);
    const badge  = document.getElementById('badgeJumlah');
    const list   = document.getElementById('keranjangList');
    const kosong = document.getElementById('keranjangKosong');
    const btn    = document.getElementById('btnSubmit');

    badge.textContent = ids.length + ' Buku';

    if (ids.length === 0) {
        kosong.style.display = 'block';
        btn.style.opacity = '.5';
        btn.style.pointerEvents = 'none';
    } else {
        kosong.style.display = 'none';
        btn.style.opacity = '1';
        btn.style.pointerEvents = 'auto';
    }

    list.querySelectorAll('.keranjang-item').forEach(el => el.remove());

    document.getElementById('hiddenInputs').innerHTML = ids.map((id, idx) =>
        `<input type="hidden" name="buku[${idx}][id]" value="${id}">
         <input type="hidden" name="buku[${idx}][jumlah]" value="${keranjang[id].jumlah}">`
    ).join('');

    ids.forEach((id) => {
        const item = keranjang[id];
        const div  = document.createElement('div');
        div.className = 'keranjang-item';
        div.style.cssText = 'display:flex;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid #f1f5f9;animation:slideIn .2s ease-out';
        div.innerHTML = `
            <div style="width:34px;height:44px;border-radius:6px;overflow:hidden;flex-shrink:0;border:1px solid #e2e8f0;background:linear-gradient(135deg,#ecfdf5,#d1fae5);display:flex;align-items:center;justify-content:center;">
                ${item.gambar
                    ? `<img src="${item.gambar}" alt="${item.nama}" style="width:100%;height:100%;object-fit:cover;" onerror="this.parentElement.innerHTML='📖'">`
                    : `<span style="font-size:15px">📖</span>`}
            </div>
            <div style="flex:1;min-width:0;">
                <p style="font-size:12.5px;font-weight:700;color:#1e293b;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${item.nama}</p>
                <p style="font-size:11px;color:#94a3b8;margin:2px 0 0;font-weight:600;">Stok: ${item.stok}</p>
            </div>
            <div style="display:flex;align-items:center;gap:3px;flex-shrink:0;">
                <button type="button" onclick="ubahJumlah(${id},-1)" style="width:26px;height:26px;border-radius:7px;border:1.5px solid #e2e8f0;background:#fff;cursor:pointer;font-size:15px;color:#64748b;font-weight:700;display:flex;align-items:center;justify-content:center;">−</button>
                <span style="font-size:13px;font-weight:800;color:#1e293b;min-width:22px;text-align:center;">${item.jumlah}</span>
                <button type="button" onclick="ubahJumlah(${id},1)"  style="width:26px;height:26px;border-radius:7px;border:1.5px solid #e2e8f0;background:#fff;cursor:pointer;font-size:15px;color:#64748b;font-weight:700;display:flex;align-items:center;justify-content:center;">+</button>
                <button type="button" onclick="hapusDariKeranjang(${id})" style="width:26px;height:26px;border-radius:7px;border:none;background:#fff5f5;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#ef4444;margin-left:2px;">
                    <svg style="width:13px;height:13px" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>`;
        list.appendChild(div);
    });
}

function tambahKeKeranjang(id, nama, stok) {
    const el = event.currentTarget;
    const img = el.querySelector('img');
    const gambar = img ? img.src : null;
    if (stok <= 0) return;
    if (keranjang[id]) {
        if (keranjang[id].jumlah < stok) { keranjang[id].jumlah++; }
        else { Swal.fire({ toast:true, position:'top-end', icon:'warning', title:'Stok buku terbatas!', showConfirmButton:false, timer:2000 }); return; }
    } else {
        keranjang[id] = { nama, jumlah:1, stok, gambar };
    }
    render();
}

function ubahJumlah(id, delta) {
    if (!keranjang[id]) return;
    const baru = keranjang[id].jumlah + delta;
    if (baru <= 0) { hapusDariKeranjang(id); return; }
    if (baru > keranjang[id].stok) { Swal.fire({ toast:true, position:'top-end', icon:'warning', title:'Melebihi stok tersedia!', showConfirmButton:false, timer:2000 }); return; }
    keranjang[id].jumlah = baru;
    render();
}

function hapusDariKeranjang(id) { delete keranjang[id]; render(); }

function cariBuku(q) {
    const qLow = q.toLowerCase().trim();
    let visible = 0;
    document.querySelectorAll('.item-buku').forEach(el => {
        const match = el.dataset.judul.includes(qLow);
        el.style.display = match ? 'flex' : 'none';
        if (match) visible++;
    });
    const notFound = document.getElementById('tidakDitemukan');
    if (notFound) notFound.style.display = (visible === 0 && qLow !== '') ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', function () {
    const tglPinjam = document.getElementById('inputTglPinjam');
    if (tglPinjam && tglPinjam.value) updateMinKembali(tglPinjam.value);
});
</script>

<style>
.tambah-wrap {
    padding: 20px;
    max-width: 1100px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* Page header */
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

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 18px;
    border-radius: 12px;
    border: 1.5px solid #e2e8f0;
    background: #fff;
    color: #475569;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
    flex-shrink: 0;
    transition: all .2s;
}
.btn-back:hover { background: #f8fafc; border-color: #cbd5e1; }

/* Two-column grid */
.tambah-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 20px;
    align-items: start;
}

.sidebar-panel {
    display: flex;
    flex-direction: column;
    gap: 18px;
    position: sticky;
    top: 20px;
}

/* Book list scrollable */
.list-buku-scroll {
    max-height: 480px;
    overflow-y: auto;
    padding: 8px;
}
.list-buku-scroll::-webkit-scrollbar { width: 5px; }
.list-buku-scroll::-webkit-scrollbar-track { background: #f1f5f9; }
.list-buku-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

@keyframes slideIn {
    from { opacity:0; transform:translateY(8px); }
    to   { opacity:1; transform:translateY(0); }
}

/* ─── MOBILE ───────────────────────────────────────────── */
@media (max-width: 767px) {
    .tambah-wrap     { padding: 12px; gap: 14px; }
    .page-title      { font-size: 18px; }
    .page-subtitle   { display: none; }
    .btn-back-label  { display: none; }
    .btn-back        { padding: 10px 12px; }

    /* Stack: book list first, then cart + form below */
    .tambah-grid {
        grid-template-columns: 1fr;
        gap: 14px;
    }

    .sidebar-panel {
        position: static; /* no sticky on mobile */
    }

    .list-buku-scroll { max-height: 320px; }
}
</style>
@endsection