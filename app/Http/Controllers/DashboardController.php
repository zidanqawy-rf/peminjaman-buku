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

        // ── Statistik Status ───────────────────────────────────────
        $totalPeminjaman     = Peminjaman::where('user_id', $user->id)->count();

        $sedangDipinjam      = Peminjaman::where('user_id', $user->id)
                                ->where('status', 'disetujui')->count();

        $sudahDikembalikan   = Peminjaman::where('user_id', $user->id)
                                ->where('status', 'dikembalikan')->count();

        $menungguPersetujuan = Peminjaman::where('user_id', $user->id)
                                ->where('status', 'pengajuan')->count();

        $prosesKembali       = Peminjaman::where('user_id', $user->id)
                                ->where('status', 'pengajuan_kembali')->count();

        $ditolak             = Peminjaman::where('user_id', $user->id)
                                ->where('status', 'ditolak')->count();

        // Ada tagihan denda kerusakan yang belum dibayar
        $adaTagihanDenda     = Peminjaman::where('user_id', $user->id)
                                ->where('status', 'didenda')->count();

        // ── Denda Keterlambatan ────────────────────────────────────
        $totalDendaTerlambat = Peminjaman::where('user_id', $user->id)
                                ->where('status', 'dikembalikan')
                                ->sum('jumlah_denda');

        // ── Denda Kerusakan/Kehilangan (sudah lunas) ──────────────
        $totalDendaKerusakan = Peminjaman::where('user_id', $user->id)
                                ->where('status', 'dikembalikan')
                                ->sum('denda_kerusakan');

        // ── Grand Total Semua Denda Pernah Dibayar ────────────────
        $totalDenda          = $totalDendaTerlambat + $totalDendaKerusakan;

        // ── Tagihan denda kerusakan yang belum dibayar ────────────
        $tagihan             = Peminjaman::where('user_id', $user->id)
                                ->where('status', 'didenda')
                                ->sum('denda_kerusakan');

        // ── Peminjaman Aktif ───────────────────────────────────────
        $peminjamanAktif     = Peminjaman::with('buku')
                                ->where('user_id', $user->id)
                                ->where('status', 'disetujui')
                                ->orderBy('tanggal_rencana_kembali')
                                ->get();

        // ── Tagihan Denda Kerusakan yang belum lunas ──────────────
        $peminjamanDidenda   = Peminjaman::with('buku')
                                ->where('user_id', $user->id)
                                ->where('status', 'didenda')
                                ->orderBy('updated_at', 'desc')
                                ->get();

        // ── Riwayat Terbaru ────────────────────────────────────────
        $riwayatTerbaru      = Peminjaman::with('buku')
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
            'adaTagihanDenda',
            'totalDendaTerlambat',
            'totalDendaKerusakan',
            'totalDenda',
            'tagihan',
            'peminjamanAktif',
            'peminjamanDidenda',
            'riwayatTerbaru',
        ));
    }
}