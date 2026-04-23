<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        // PERBAIKAN: Gunakan withSum untuk menjumlahkan kolom 'jumlah' pada relasi detailBuku
        // Ini memastikan jika 1 baris detail isinya 2 buku, maka akan terhitung 2, bukan 1.
        $query = Peminjaman::with(['user'])->withSum('detailBuku as total_buku', 'jumlah');

        // 1. Filter Nama Siswa (Search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        // 2. Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Filter Periode Tanggal
        if ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            $query->whereBetween('tanggal_pinjam', [$request->tgl_mulai, $request->tgl_selesai]);
        } elseif ($request->filled('tgl_mulai')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->tgl_mulai);
        } elseif ($request->filled('tgl_selesai')) {
            $query->whereDate('tanggal_pinjam', '<=', $request->tgl_selesai);
        }

        // Eksekusi pagination
        $peminjaman = $query->latest()->paginate(15)->withQueryString();

        // Statistik Dashboard (Tetap dipertahankan)
        $totalPengajuan = Peminjaman::where('status', 'pengajuan')->count();
        $totalKembali   = Peminjaman::where('status', 'pengajuan_kembali')->count();

        return view('admin.peminjaman.index', compact('peminjaman', 'totalPengajuan', 'totalKembali'));
    }

    public function show(Peminjaman $peminjaman)
    {
        // Load relasi agar detail buku muncul di halaman show
        $peminjaman->load(['user', 'detailBuku.buku']);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function setujui(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pengajuan') {
            return back()->withErrors(['status' => 'Status tidak sesuai.']);
        }

        $request->validate(['catatan_admin' => 'nullable|string|max:500']);

        // Kurangi stok berdasarkan jumlah di detail
        foreach ($peminjaman->detailBuku as $detail) {
            $buku = $detail->buku;
            if ($buku->jumlah_buku < $detail->jumlah) {
                return back()->withErrors(['stok' => "Stok buku \"{$buku->nama_buku}\" tidak mencukupi."]);
            }
            $buku->decrement('jumlah_buku', $detail->jumlah);
        }

        $peminjaman->update([
            'status'        => 'disetujui',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function tolak(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pengajuan') {
            return back()->withErrors(['status' => 'Status tidak sesuai.']);
        }

        $request->validate(['catatan_admin' => 'required|string|max:500']);

        $peminjaman->update([
            'status'        => 'ditolak',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Peminjaman ditolak.');
    }

    public function konfirmasiKembali(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pengajuan_kembali') {
            return back()->withErrors(['status' => 'Status tidak sesuai.']);
        }

        $request->validate([
            'kondisi_buku'  => 'required|string|max:255',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        // Kembalikan stok buku
        foreach ($peminjaman->detailBuku as $detail) {
            $detail->buku->increment('jumlah_buku', $detail->jumlah);
        }

        $peminjaman->update([
            'status'        => 'dikembalikan',
            'kondisi_buku'  => $request->kondisi_buku,
            'catatan_admin' => $request->catatan_admin,
            'denda_lunas'   => ($peminjaman->jumlah_denda > 0) ? true : false,
        ]);

        return back()->with('success', 'Pengembalian buku dikonfirmasi. Stok telah dipulihkan.');
    }
}