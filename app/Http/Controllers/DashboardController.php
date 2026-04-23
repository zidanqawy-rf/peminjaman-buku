<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ── Statistik Peminjaman ───────────────────────────────────
        $totalPeminjaman    = Peminjaman::where('user_id', $user->id)->count();

        $sedangDipinjam     = Peminjaman::where('user_id', $user->id)
                                ->where('status', 'disetujui')
                                ->count();

        $sudahDikembalikan  = Peminjaman::where('user_id', $user->id)
                                ->where('status', 'dikembalikan')
                                ->count();

        $menungguPersetujuan = Peminjaman::where('user_id', $user->id)
                                ->where('status', 'pengajuan')
                                ->count();

        $prosesKembali      = Peminjaman::where('user_id', $user->id)
                                ->where('status', 'pengajuan_kembali')
                                ->count();

        $ditolak            = Peminjaman::where('user_id', $user->id)
                                ->where('status', 'ditolak')
                                ->count();

        // ── Total Denda ────────────────────────────────────────────
        $totalDenda         = Peminjaman::where('user_id', $user->id)
                                ->where('status', 'dikembalikan')
                                ->sum('jumlah_denda');

        // ── Peminjaman Aktif (terlambat atau tidak) ────────────────
        $peminjamanAktif    = Peminjaman::with('buku')
                                ->where('user_id', $user->id)
                                ->where('status', 'disetujui')
                                ->orderBy('tanggal_rencana_kembali')
                                ->get();

        // ── Riwayat Terbaru (5 terakhir) ──────────────────────────
        $riwayatTerbaru     = Peminjaman::with('buku')
                                ->where('user_id', $user->id)
                                ->latest()
                                ->take(5)
                                ->get();

        return view('dashboard', compact(
            'user',
            'totalPeminjaman',
            'sedangDipinjam',
            'sudahDikembalikan',
            'menungguPersetujuan',
            'prosesKembali',
            'ditolak',
            'totalDenda',
            'peminjamanAktif',
            'riwayatTerbaru',
        ));
    }
}