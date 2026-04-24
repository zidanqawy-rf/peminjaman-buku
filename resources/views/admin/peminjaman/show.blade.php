{{-- resources/views/admin/peminjaman/show.blade.php --}}
@extends('layouts.app-admin')
@section('content')

<div style="display:flex;flex-direction:column;gap:20px">

    {{-- Back + Title --}}
    <div style="display:flex;align-items:center;gap:16px">
        <a href="{{ route('admin.peminjaman.index') }}"
            style="width:36px;height:36px;background:#f1f5f9;border-radius:10px;display:flex;align-items:center;justify-content:center;text-decoration:none;color:#64748b;border:none;cursor:pointer"
            onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
            <svg style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 style="font-size:20px;font-weight:800;color:#1e293b">Detail Peminjaman #{{ $peminjaman->id }}</h1>
            <p style="font-size:13px;color:#94a3b8;margin-top:2px">{{ $peminjaman->created_at->format('d M Y, H:i') }}</p>
        </div>
        @php
            $statusStyles = [
                'pengajuan'          => 'background:#fef9c3;color:#854d0e',
                'disetujui'          => 'background:#dbeafe;color:#1e40af',
                'ditolak'            => 'background:#fee2e2;color:#991b1b',
                'pengajuan_kembali'  => 'background:#f3e8ff;color:#6b21a8',
                'didenda'            => 'background:#fff7ed;color:#c2410c',
                'dikembalikan'       => 'background:#dcfce7;color:#14532d',
            ];
            $ss = $statusStyles[$peminjaman->status] ?? 'background:#f1f5f9;color:#475569';
        @endphp
        <span style="font-size:12px;font-weight:700;padding:6px 14px;border-radius:20px;{{ $ss }};margin-left:auto">
            {{ $peminjaman->statusLabel() }}
        </span>
    </div>

    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;border-radius:12px;padding:14px 18px;font-size:13px;display:flex;align-items:center;gap:10px">
        <svg style="width:18px;height:18px;flex-shrink:0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;border-radius:12px;padding:14px 18px;font-size:13px">
        <ul style="list-style:disc;padding-left:18px;margin:0;display:flex;flex-direction:column;gap:4px">
            @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
        </ul>
    </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

        {{-- ── LEFT: Info Siswa & Buku ── --}}
        <div style="display:flex;flex-direction:column;gap:16px">

            {{-- Info Siswa --}}
            <div style="background:#fff;border-radius:16px;padding:24px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.04)">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#94a3b8;margin-bottom:14px">Informasi Siswa</p>
                @php $u = $peminjaman->user @endphp
                <div style="display:flex;flex-direction:column;gap:10px">
                    <div style="display:flex;justify-content:space-between">
                        <span style="font-size:13px;color:#94a3b8">Nama</span>
                        <span style="font-size:13px;font-weight:700;color:#1e293b">{{ $u->name }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between">
                        <span style="font-size:13px;color:#94a3b8">Email</span>
                        <span style="font-size:13px;color:#475569">{{ $u->email }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between">
                        <span style="font-size:13px;color:#94a3b8">Kelas</span>
                        <span style="font-size:13px;color:#475569">{{ $u->kelas ?? '-' }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between">
                        <span style="font-size:13px;color:#94a3b8">Jurusan</span>
                        <span style="font-size:13px;color:#475569">{{ $u->jurusan ?? '-' }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between">
                        <span style="font-size:13px;color:#94a3b8">NISN</span>
                        <span style="font-size:13px;color:#475569">{{ $u->nisn ?? '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- Buku Dipinjam --}}
            <div style="background:#fff;border-radius:16px;padding:24px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.04)">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#94a3b8;margin-bottom:14px">Buku Dipinjam</p>
                <div style="display:flex;flex-direction:column;gap:10px">
                    @foreach($peminjaman->detailBuku as $d)
                    <div style="display:flex;align-items:center;gap:12px;background:#f8fafc;border-radius:12px;padding:12px">
                        <div style="width:40px;height:52px;background:#e8f5e9;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden">
                            @if($d->buku->gambar)
                            <img src="{{ Storage::url($d->buku->gambar) }}" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:8px">
                            @else
                            <svg style="width:18px;height:18px;color:#4ade80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
                            </svg>
                            @endif
                        </div>
                        <div style="flex:1;min-width:0">
                            <p style="font-size:13px;font-weight:700;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $d->buku->nama_buku }}</p>
                            <p style="font-size:11px;color:#94a3b8;margin-top:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                {{ $d->buku->pengarang ?? '-' }}
                                @if(!empty($d->buku->tahun_terbit)) &nbsp;·&nbsp;{{ $d->buku->tahun_terbit }} @endif
                                @if(!empty($d->buku->penerbit)) &nbsp;·&nbsp;{{ $d->buku->penerbit }} @endif
                            </p>
                        </div>
                        <span style="background:#dcfce7;color:#166534;font-size:12px;font-weight:700;padding:3px 10px;border-radius:8px;flex-shrink:0">
                            {{ $d->jumlah }} buku
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Tanggal & Catatan --}}
            <div style="background:#fff;border-radius:16px;padding:24px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.04)">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#94a3b8;margin-bottom:14px">Info Peminjaman</p>
                <div style="display:flex;flex-direction:column;gap:10px">
                    <div style="display:flex;justify-content:space-between">
                        <span style="font-size:13px;color:#94a3b8">Tgl Pinjam</span>
                        <span style="font-size:13px;font-weight:600;color:#1e293b">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between">
                        <span style="font-size:13px;color:#94a3b8">Rencana Kembali</span>
                        <span style="font-size:13px;font-weight:600;color:#1e293b">{{ $peminjaman->tanggal_rencana_kembali->format('d M Y') }}</span>
                    </div>
                    @if($peminjaman->tanggal_kembali)
                    <div style="display:flex;justify-content:space-between">
                        <span style="font-size:13px;color:#94a3b8">Tgl Kembali</span>
                        <span style="font-size:13px;font-weight:600;color:#1e293b">{{ $peminjaman->tanggal_kembali->format('d M Y') }}</span>
                    </div>
                    @endif
                    @if($peminjaman->kondisi_buku)
                    <div style="display:flex;justify-content:space-between">
                        <span style="font-size:13px;color:#94a3b8">Kondisi Buku</span>
                        <span style="font-size:13px;font-weight:600;color:#1e293b">{{ $peminjaman->kondisi_buku }}</span>
                    </div>
                    @endif
                    @if($peminjaman->catatan)
                    <div style="border-top:1px solid #f1f5f9;padding-top:10px;margin-top:4px">
                        <p style="font-size:12px;color:#94a3b8;margin-bottom:4px">Catatan / Keperluan</p>
                        <p style="font-size:13px;color:#475569">{{ $peminjaman->catatan }}</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>{{-- end left --}}

        {{-- ── RIGHT: Aksi & Bukti ── --}}
        <div style="display:flex;flex-direction:column;gap:16px">

            {{-- ═══ PANEL: VALIDASI PENGAJUAN ═══ --}}
            @if($peminjaman->status === 'pengajuan')
            <div style="background:#fff;border-radius:16px;padding:24px;border:2px solid #fbbf24;box-shadow:0 1px 4px rgba(0,0,0,.04)">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
                    <div style="width:36px;height:36px;background:#fef9c3;border-radius:10px;display:flex;align-items:center;justify-content:center">
                        <svg style="width:18px;height:18px;color:#d97706" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p style="font-size:15px;font-weight:800;color:#1e293b">Validasi Pengajuan</p>
                </div>
                <form method="POST" action="{{ route('admin.peminjaman.setujui', $peminjaman) }}" style="margin-bottom:12px">
                    @csrf
                    <textarea name="catatan_admin" rows="2" placeholder="Catatan untuk siswa (opsional)..."
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13px;color:#1e293b;background:#f8fafc;outline:none;resize:none;margin-bottom:10px;box-sizing:border-box"
                        onfocus="this.style.borderColor='#22c55e'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
                    <button type="submit"
                        style="width:100%;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;border:none;border-radius:10px;padding:12px;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 2px 8px rgba(34,197,94,.3)">
                        ✅ Setujui Peminjaman
                    </button>
                </form>
                <button onclick="document.getElementById('modalTolak').style.display='flex'"
                    style="width:100%;background:#fff;color:#ef4444;border:1.5px solid #fecaca;border-radius:10px;padding:11px;font-size:13px;font-weight:700;cursor:pointer">
                    ❌ Tolak Pengajuan
                </button>
            </div>
            @endif

            {{-- ═══ PANEL: KONFIRMASI PENGEMBALIAN ═══ --}}
            @if($peminjaman->status === 'pengajuan_kembali')
            <div style="background:#fff;border-radius:16px;padding:24px;border:2px solid #a855f7;box-shadow:0 1px 4px rgba(0,0,0,.04)">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
                    <div style="width:36px;height:36px;background:#faf5ff;border-radius:10px;display:flex;align-items:center;justify-content:center">
                        <svg style="width:18px;height:18px;color:#a855f7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                        </svg>
                    </div>
                    <p style="font-size:15px;font-weight:800;color:#1e293b">Konfirmasi Pengembalian</p>
                </div>

                @if($peminjaman->jumlah_denda > 0)
                <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:10px;padding:12px 14px;margin-bottom:14px">
                    <p style="font-size:13px;font-weight:700;color:#c2410c">
                        💰 Denda Terlambat: Rp {{ number_format($peminjaman->jumlah_denda,0,',','.') }}
                        ({{ $peminjaman->hari_terlambat }} hari)
                    </p>
                    @if($peminjaman->foto_bukti_denda)
                    <p style="font-size:12px;color:#ea580c;margin-top:4px">✅ Bukti bayar telah diupload siswa</p>
                    @else
                    <p style="font-size:12px;color:#f97316;margin-top:4px">⚠ Belum ada bukti pembayaran</p>
                    @endif
                </div>
                @endif

                <form method="POST" action="{{ route('admin.peminjaman.konfirmasiKembali', $peminjaman) }}" id="formKonfirmasi">
                    @csrf
                    <div style="margin-bottom:12px">
                        <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">Kondisi Buku *</label>
                        <select name="kondisi_buku" id="selectKondisi" required onchange="cekKondisiRusak(this.value)"
                            style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13px;color:#475569;background:#f8fafc;outline:none;cursor:pointer"
                            onfocus="this.style.borderColor='#a855f7'" onblur="this.style.borderColor='#e2e8f0'">
                            <option value="">Pilih kondisi...</option>
                            <option value="Baik">Baik</option>
                            <option value="Cukup Baik">Cukup Baik</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Rusak Berat">⚠️ Rusak Berat</option>
                            <option value="Hilang">❌ Hilang</option>
                        </select>
                    </div>

                    {{-- Panel denda kerusakan — muncul saat Rusak Berat / Hilang --}}
                    <div id="panelDendaKerusakan" style="display:none;background:#fff7ed;border:1.5px solid #fed7aa;border-radius:12px;padding:16px;margin-bottom:14px">
                        <p style="font-size:12px;font-weight:700;color:#c2410c;margin-bottom:12px">
                            🚨 Buku <span id="labelKondisi"></span> — Masukkan Tagihan Denda
                        </p>
                        <div style="margin-bottom:10px">
                            <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:6px">Nominal Denda (Rp) *</label>
                            <input type="number" name="denda_kerusakan" id="inputDendaKerusakan" min="1" placeholder="Contoh: 150000"
                                style="width:100%;border:1.5px solid #fed7aa;border-radius:10px;padding:10px 14px;font-size:13px;color:#1e293b;background:#fff;outline:none;box-sizing:border-box"
                                onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#fed7aa'"
                                oninput="updatePreviewDenda(this.value)">
                            <p id="previewDendaFormat" style="font-size:12px;color:#ea580c;margin-top:5px;font-weight:600"></p>
                        </div>
                        <div>
                            <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:6px">Keterangan / Alasan Denda *</label>
                            <textarea name="catatan_kerusakan" id="textareaKerusakan" rows="3"
                                placeholder="Jelaskan kondisi kerusakan atau bukti kehilangan buku..."
                                style="width:100%;border:1.5px solid #fed7aa;border-radius:10px;padding:10px 14px;font-size:13px;color:#1e293b;background:#fff;outline:none;resize:none;box-sizing:border-box"
                                onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#fed7aa'"></textarea>
                        </div>
                        <div style="margin-top:10px;padding:10px 12px;background:#fff;border-radius:8px;border:1px dashed #fed7aa">
                            <p style="font-size:11px;color:#92400e;margin:0;">
                                ℹ️ Siswa akan diminta untuk membayar denda ini dan mengupload bukti pembayaran sebelum peminjaman dinyatakan selesai.
                            </p>
                        </div>
                    </div>

                    <div style="margin-bottom:14px">
                        <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">Catatan Admin</label>
                        <textarea name="catatan_admin" rows="2" placeholder="Catatan tambahan (opsional)..."
                            style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13px;color:#1e293b;background:#f8fafc;outline:none;resize:none;box-sizing:border-box"
                            onfocus="this.style.borderColor='#a855f7'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
                    </div>
                    <button type="submit" id="btnKonfirmasi"
                        style="width:100%;background:linear-gradient(135deg,#a855f7,#7c3aed);color:#fff;border:none;border-radius:10px;padding:12px;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 2px 8px rgba(168,85,247,.3)">
                        ✅ Konfirmasi Buku Kembali
                    </button>
                </form>
            </div>
            @endif

            {{-- ═══ PANEL: STATUS DIDENDA — Menunggu Pembayaran Siswa ═══ --}}
            @if($peminjaman->status === 'didenda')
            <div style="background:#fff;border-radius:16px;padding:24px;border:2px solid #f97316;box-shadow:0 1px 4px rgba(0,0,0,.04)">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
                    <div style="width:36px;height:36px;background:#fff7ed;border-radius:10px;display:flex;align-items:center;justify-content:center">
                        <svg style="width:18px;height:18px;color:#f97316" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                    </div>
                    <p style="font-size:15px;font-weight:800;color:#1e293b">Tagihan Denda Kerusakan</p>
                </div>

                {{-- Info kondisi & denda --}}
                <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:12px;padding:14px;margin-bottom:14px">
                    <div style="display:flex;justify-content:space-between;margin-bottom:8px">
                        <span style="font-size:13px;color:#92400e">Kondisi Buku</span>
                        <span style="font-size:13px;font-weight:700;color:#c2410c">{{ $peminjaman->kondisi_buku }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:8px">
                        <span style="font-size:13px;color:#92400e">Denda Kerusakan</span>
                        <span style="font-size:14px;font-weight:800;color:#c2410c">Rp {{ number_format($peminjaman->denda_kerusakan,0,',','.') }}</span>
                    </div>
                    @if($peminjaman->catatan_kerusakan)
                    <div style="border-top:1px dashed #fed7aa;padding-top:8px;margin-top:4px">
                        <p style="font-size:11px;color:#92400e;margin-bottom:3px">Keterangan:</p>
                        <p style="font-size:13px;color:#7c2d12">{{ $peminjaman->catatan_kerusakan }}</p>
                    </div>
                    @endif
                </div>

                {{-- Status bukti bayar --}}
                @if($peminjaman->foto_bukti_denda_kerusakan)
                    {{-- Sudah upload — tampilkan tombol konfirmasi --}}
                    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 14px;margin-bottom:14px">
                        <p style="font-size:13px;font-weight:700;color:#166534;margin-bottom:8px">✅ Siswa sudah upload bukti pembayaran</p>
                        <img src="{{ Storage::url($peminjaman->foto_bukti_denda_kerusakan) }}" alt="Bukti Denda Kerusakan"
                            style="width:100%;border-radius:8px;object-fit:cover;max-height:180px;cursor:pointer"
                            onclick="bukaGambar('{{ Storage::url($peminjaman->foto_bukti_denda_kerusakan) }}')">
                    </div>
                    <form method="POST" action="{{ route('admin.peminjaman.konfirmasiDendaKerusakan', $peminjaman) }}">
                        @csrf
                        <textarea name="catatan_admin" rows="2" placeholder="Catatan tambahan (opsional)..."
                            style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13px;color:#1e293b;background:#f8fafc;outline:none;resize:none;margin-bottom:10px;box-sizing:border-box"></textarea>
                        <button type="submit"
                            style="width:100%;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;border:none;border-radius:10px;padding:12px;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 2px 8px rgba(34,197,94,.3)">
                            ✅ Konfirmasi Pembayaran — Selesaikan Peminjaman
                        </button>
                    </form>
                @else
                    {{-- Belum upload --}}
                    <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 14px;text-align:center">
                        <p style="font-size:28px;margin-bottom:6px">⏳</p>
                        <p style="font-size:13px;font-weight:700;color:#dc2626">Menunggu Pembayaran Siswa</p>
                        <p style="font-size:12px;color:#ef4444;margin-top:4px">Siswa belum mengupload bukti pembayaran denda.</p>
                    </div>
                @endif
            </div>
            @endif

            {{-- ═══ FOTO PENGEMBALIAN ═══ --}}
            @if($peminjaman->foto_pengembalian)
            <div style="background:#fff;border-radius:16px;padding:24px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.04)">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#94a3b8;margin-bottom:14px">📷 Foto Pengembalian Buku</p>
                <img src="{{ Storage::url($peminjaman->foto_pengembalian) }}" alt="Foto Pengembalian"
                    style="width:100%;border-radius:10px;object-fit:cover;max-height:220px;cursor:pointer"
                    onclick="bukaGambar('{{ Storage::url($peminjaman->foto_pengembalian) }}')">
            </div>
            @endif

            {{-- ═══ FOTO BUKTI DENDA KETERLAMBATAN ═══ --}}
            @if($peminjaman->foto_bukti_denda)
            <div style="background:#fff;border-radius:16px;padding:24px;border:1px solid #fed7aa;box-shadow:0 1px 4px rgba(0,0,0,.04)">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#94a3b8;margin-bottom:14px">💰 Bukti Pembayaran Denda Terlambat</p>
                <div style="background:#fff7ed;border-radius:10px;padding:10px 14px;margin-bottom:12px">
                    <p style="font-size:13px;font-weight:700;color:#c2410c">
                        Rp {{ number_format($peminjaman->jumlah_denda,0,',','.') }}
                        ({{ $peminjaman->hari_terlambat }} hari terlambat)
                    </p>
                </div>
                <img src="{{ Storage::url($peminjaman->foto_bukti_denda) }}" alt="Bukti Denda"
                    style="width:100%;border-radius:10px;object-fit:cover;max-height:220px;cursor:pointer"
                    onclick="bukaGambar('{{ Storage::url($peminjaman->foto_bukti_denda) }}')">
            </div>
            @endif

            {{-- ═══ INFO SUDAH SELESAI ═══ --}}
            @if($peminjaman->status === 'dikembalikan')
            <div style="background:#f0fdf4;border-radius:16px;padding:24px;border:1px solid #bbf7d0">
                <div style="text-align:center">
                    <div style="font-size:48px;margin-bottom:10px">✅</div>
                    <p style="font-size:15px;font-weight:800;color:#14532d">Peminjaman Selesai</p>
                    @if($peminjaman->kondisi_buku)
                    <p style="font-size:13px;color:#166534;margin-top:6px">Kondisi: <strong>{{ $peminjaman->kondisi_buku }}</strong></p>
                    @endif
                    @if($peminjaman->denda_kerusakan > 0)
                    <p style="font-size:13px;color:#166534;margin-top:4px">Denda kerusakan: <strong>Rp {{ number_format($peminjaman->denda_kerusakan,0,',','.') }}</strong> ✅ Lunas</p>
                    @endif
                    @if($peminjaman->catatan_admin)
                    <p style="font-size:13px;color:#166534;margin-top:4px">{{ $peminjaman->catatan_admin }}</p>
                    @endif
                </div>
            </div>
            @endif

            {{-- ═══ DITOLAK ═══ --}}
            @if($peminjaman->status === 'ditolak')
            <div style="background:#fef2f2;border-radius:16px;padding:24px;border:1px solid #fecaca">
                <div style="text-align:center">
                    <div style="font-size:48px;margin-bottom:10px">❌</div>
                    <p style="font-size:15px;font-weight:800;color:#991b1b">Pengajuan Ditolak</p>
                    @if($peminjaman->catatan_admin)
                    <p style="font-size:13px;color:#b91c1c;margin-top:6px">Alasan: {{ $peminjaman->catatan_admin }}</p>
                    @endif
                </div>
            </div>
            @endif

        </div>{{-- end right --}}
    </div>{{-- end grid --}}

</div>

{{-- ── Modal Tolak ── --}}
<div id="modalTolak"
     style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:100;align-items:center;justify-content:center;backdrop-filter:blur(4px)"
     onclick="if(event.target===this)this.style.display='none'">
    <div style="background:#fff;border-radius:20px;width:100%;max-width:440px;box-shadow:0 20px 60px rgba(0,0,0,.15);overflow:hidden;animation:slideUp .2s ease">
        <div style="padding:24px 28px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between">
            <div>
                <p style="font-weight:800;font-size:15px;color:#0f172a">Tolak Pengajuan</p>
                <p style="font-size:12px;color:#94a3b8;margin-top:1px">Berikan alasan penolakan kepada siswa</p>
            </div>
            <button onclick="document.getElementById('modalTolak').style.display='none'"
                style="width:32px;height:32px;border-radius:8px;background:#f1f5f9;border:none;cursor:pointer;font-size:18px;color:#94a3b8"
                onmouseover="this.style.background='#fee2e2';this.style.color='#ef4444'"
                onmouseout="this.style.background='#f1f5f9';this.style.color='#94a3b8'">×</button>
        </div>
        <form method="POST" action="{{ route('admin.peminjaman.tolak', $peminjaman) }}" style="padding:24px 28px">
            @csrf
            <div style="margin-bottom:16px">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">Alasan Penolakan *</label>
                <textarea name="catatan_admin" rows="3" required placeholder="Tulis alasan penolakan..."
                    style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13px;color:#1e293b;background:#f8fafc;outline:none;resize:none;box-sizing:border-box"
                    onfocus="this.style.borderColor='#ef4444'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
            </div>
            <div style="display:flex;gap:10px">
                <button type="button" onclick="document.getElementById('modalTolak').style.display='none'"
                    style="flex:1;padding:11px;border-radius:10px;background:#fff;border:1.5px solid #e2e8f0;color:#64748b;font-size:13px;font-weight:600;cursor:pointer">
                    Batal
                </button>
                <button type="submit"
                    style="flex:1;padding:11px;border-radius:10px;border:none;color:#fff;font-size:13px;font-weight:700;cursor:pointer;background:linear-gradient(135deg,#ef4444,#dc2626);box-shadow:0 2px 8px rgba(239,68,68,.3)">
                    Tolak Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Lightbox --}}
<div id="lightbox" onclick="this.style.display='none'"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:200;align-items:center;justify-content:center;cursor:zoom-out">
    <img id="lightboxImg" src="" alt="" style="max-width:90vw;max-height:90vh;border-radius:12px;object-fit:contain">
</div>

<style>
@keyframes slideUp {
    from { opacity:0;transform:translateY(12px) scale(.98) }
    to   { opacity:1;transform:translateY(0) scale(1) }
}
</style>

<script>
function bukaGambar(url) {
    document.getElementById('lightboxImg').src = url;
    document.getElementById('lightbox').style.display = 'flex';
}

// ── Tampilkan/sembunyikan panel denda kerusakan ──
function cekKondisiRusak(val) {
    const panel = document.getElementById('panelDendaKerusakan');
    const label = document.getElementById('labelKondisi');
    const inputDenda = document.getElementById('inputDendaKerusakan');
    const textarea = document.getElementById('textareaKerusakan');
    const btn = document.getElementById('btnKonfirmasi');

    const perluDenda = (val === 'Rusak Berat' || val === 'Hilang');

    if (panel) panel.style.display = perluDenda ? 'block' : 'none';
    if (label) label.textContent = val;
    if (inputDenda) inputDenda.required = perluDenda;
    if (textarea) textarea.required = perluDenda;

    if (btn) {
        if (perluDenda) {
            btn.textContent = '🚨 Konfirmasi & Kirim Tagihan Denda';
            btn.style.background = 'linear-gradient(135deg,#f97316,#ea580c)';
            btn.style.boxShadow = '0 2px 8px rgba(249,115,22,.3)';
        } else {
            btn.textContent = '✅ Konfirmasi Buku Kembali';
            btn.style.background = 'linear-gradient(135deg,#a855f7,#7c3aed)';
            btn.style.boxShadow = '0 2px 8px rgba(168,85,247,.3)';
        }
    }
}

// ── Preview format rupiah saat mengetik nominal ──
function updatePreviewDenda(val) {
    const el = document.getElementById('previewDendaFormat');
    if (!el) return;
    const num = parseInt(val) || 0;
    el.textContent = num > 0 ? '= Rp ' + num.toLocaleString('id-ID') : '';
}
</script>
@endsection