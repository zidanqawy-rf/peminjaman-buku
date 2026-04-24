<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;

class DashboardController extends Controller
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

        // ── Denda baru: menunggu bayar kerusakan ──────────────────
        $totalDidenda       = Peminjaman::where('status', 'didenda')->count();

        // ── Total denda terlambat yang sudah lunas ────────────────
        $totalDendaTerlambat = Peminjaman::where('status', 'dikembalikan')
            ->where('jumlah_denda', '>', 0)
            ->sum('jumlah_denda');

        // ── Total denda kerusakan yang sudah lunas ────────────────
        $totalDendaKerusakan = Peminjaman::where('status', 'dikembalikan')
            ->where('denda_kerusakan', '>', 0)
            ->sum('denda_kerusakan');

        // ── Grand total semua denda terkumpul ─────────────────────
        $totalDendaTerkumpul = $totalDendaTerlambat + $totalDendaKerusakan;

        // ── Denda yang belum terbayar (masih proses / didenda) ────
        $dendaBelumBayarTerlambat = Peminjaman::where('status', 'pengajuan_kembali')
            ->where('jumlah_denda', '>', 0)
            ->sum('jumlah_denda');

        $dendaBelumBayarKerusakan = Peminjaman::where('status', 'didenda')
            ->where('denda_kerusakan', '>', 0)
            ->sum('denda_kerusakan');

        $totalDendaBelumBayar = $dendaBelumBayarTerlambat + $dendaBelumBayarKerusakan;

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
            'totalDidenda',
            'totalDendaTerlambat',
            'totalDendaKerusakan',
            'totalDendaTerkumpul',
            'totalDendaBelumBayar',
            'peminjamanTerbaru',
        ));
    }
}