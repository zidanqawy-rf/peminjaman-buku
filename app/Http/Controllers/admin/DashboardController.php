<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;

class DashboardController extends Controller  // ✅ Nama disesuaikan dengan file
{
    public function index()
    {
        $totalUser          = User::where('role', '!=', 'admin')->count();
        $totalBuku          = Buku::count();
        $totalStokBuku      = Buku::sum('stok_tersedia');

        $totalPengajuan     = Peminjaman::where('status', 'pengajuan')->count();
        $totalAktif         = Peminjaman::where('status', 'disetujui')->count();
        $totalProsesKembali = Peminjaman::where('status', 'pengajuan_kembali')->count();
        $totalSelesai       = Peminjaman::where('status', 'dikembalikan')->count();
        $totalDitolak       = Peminjaman::where('status', 'ditolak')->count();

        $peminjamanTerbaru  = Peminjaman::with(['user'])
            ->withSum('detailBuku as total_buku', 'jumlah')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUser',
            'totalBuku',
            'totalStokBuku',
            'totalPengajuan',
            'totalAktif',
            'totalProsesKembali',
            'totalSelesai',
            'totalDitolak',
            'peminjamanTerbaru',
        ));
    }
}