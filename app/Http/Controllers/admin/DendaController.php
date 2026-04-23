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

        // Jika belum ada, buat default
        if (!$setting) {
            $setting = DendaSetting::create([
                'denda_per_hari' => 1000,
                'no_rekening'    => '',
                'nama_rekening'  => '',
                'bank'           => '',
                'keterangan'     => '',
            ]);
        }

        // ✅ Diperbaiki: 'bukus' → 'buku' (sesuai nama relasi di model Peminjaman)
        $dendaAktif = Peminjaman::with(['user', 'buku'])
            ->where('hari_terlambat', '>', 0)
            ->whereIn('status', ['pengajuan_kembali', 'dikembalikan'])
            ->latest()
            ->get();

        // Statistik denda
        $totalDendaTerkumpul = Peminjaman::where('status', 'dikembalikan')
            ->where('jumlah_denda', '>', 0)
            ->sum('jumlah_denda');

        $dendaBelumBayar = Peminjaman::where('status', 'pengajuan_kembali')
            ->where('jumlah_denda', '>', 0)
            ->sum('jumlah_denda');

        $jumlahKasusDenda = Peminjaman::where('hari_terlambat', '>', 0)->count();

        return view('admin.denda.index', compact(
            'setting',
            'dendaAktif',
            'totalDendaTerkumpul',
            'dendaBelumBayar',
            'jumlahKasusDenda'
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