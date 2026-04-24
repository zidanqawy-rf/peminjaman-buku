<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DendaSetting;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function index()
    {
        $setting = DendaSetting::first();

        if (!$setting) {
            $setting = DendaSetting::create([
                'denda_per_hari' => 1000,
                'no_rekening'    => '',
                'nama_rekening'  => '',
                'bank'           => '',
                'keterangan'     => '',
            ]);
        }

        // ── Denda keterlambatan (pengajuan_kembali & dikembalikan) ──
        $dendaTerlambat = Peminjaman::with(['user', 'buku'])
            ->where('jumlah_denda', '>', 0)
            ->whereIn('status', ['pengajuan_kembali', 'dikembalikan'])
            ->latest()
            ->get();

        // ── Denda kerusakan/kehilangan (didenda & dikembalikan) ─────
        $dendaKerusakan = Peminjaman::with(['user', 'buku'])
            ->where('denda_kerusakan', '>', 0)
            ->whereIn('status', ['didenda', 'dikembalikan'])
            ->latest()
            ->get();

        // ── Gabungan semua record yang punya denda (union by id) ────
        $dendaAktif = Peminjaman::with(['user', 'buku'])
            ->where(function ($q) {
                $q->where('jumlah_denda', '>', 0)
                  ->orWhere('denda_kerusakan', '>', 0);
            })
            ->whereIn('status', ['pengajuan_kembali', 'didenda', 'dikembalikan'])
            ->latest()
            ->get();

        // ── Statistik ────────────────────────────────────────────────

        // Denda terlambat sudah lunas
        $totalDendaTerlambatLunas = Peminjaman::where('status', 'dikembalikan')
            ->where('jumlah_denda', '>', 0)
            ->sum('jumlah_denda');

        // Denda kerusakan sudah lunas
        $totalDendaKerusakanLunas = Peminjaman::where('status', 'dikembalikan')
            ->where('denda_kerusakan', '>', 0)
            ->sum('denda_kerusakan');

        // Grand total terkumpul
        $totalDendaTerkumpul = $totalDendaTerlambatLunas + $totalDendaKerusakanLunas;

        // Denda terlambat belum bayar
        $dendaBelumBayarTerlambat = Peminjaman::where('status', 'pengajuan_kembali')
            ->where('jumlah_denda', '>', 0)
            ->sum('jumlah_denda');

        // Denda kerusakan belum bayar
        $dendaBelumBayarKerusakan = Peminjaman::where('status', 'didenda')
            ->where('denda_kerusakan', '>', 0)
            ->sum('denda_kerusakan');

        // Grand total belum bayar
        $dendaBelumBayar = $dendaBelumBayarTerlambat + $dendaBelumBayarKerusakan;

        // Jumlah kasus
        $jumlahKasusTerlambat  = Peminjaman::where('jumlah_denda', '>', 0)->count();
        $jumlahKasusKerusakan  = Peminjaman::where('denda_kerusakan', '>', 0)->count();
        $jumlahKasusDenda      = $jumlahKasusTerlambat + $jumlahKasusKerusakan;

        return view('admin.denda.index', compact(
            'setting',
            'dendaAktif',
            'dendaTerlambat',
            'dendaKerusakan',
            'totalDendaTerkumpul',
            'totalDendaTerlambatLunas',
            'totalDendaKerusakanLunas',
            'dendaBelumBayar',
            'dendaBelumBayarTerlambat',
            'dendaBelumBayarKerusakan',
            'jumlahKasusDenda',
            'jumlahKasusTerlambat',
            'jumlahKasusKerusakan',
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'denda_per_hari' => 'required|integer|min:0',
            'no_rekening'    => 'nullable|string|max:50',
            'nama_rekening'  => 'nullable|string|max:100',
            'bank'           => 'nullable|string|max:50',
            'keterangan'     => 'nullable|string|max:500',
        ]);

        $setting = DendaSetting::first();

        if ($setting) {
            $setting->update($request->all());
        } else {
            DendaSetting::create($request->all());
        }

        return back()->with('success', 'Pengaturan denda berhasil disimpan');
    }
}