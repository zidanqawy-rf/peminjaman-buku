<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // ─────────────────────────────────────────────
    //  Helper: query builder dengan filter yang sama
    // ─────────────────────────────────────────────
    private function buildQuery(Request $request)
    {
        $query = Peminjaman::with(['user'])->withSum('detailBuku as total_buku', 'jumlah');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            $query->whereBetween('tanggal_pinjam', [$request->tgl_mulai, $request->tgl_selesai]);
        } elseif ($request->filled('tgl_mulai')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->tgl_mulai);
        } elseif ($request->filled('tgl_selesai')) {
            $query->whereDate('tanggal_pinjam', '<=', $request->tgl_selesai);
        }

        return $query;
    }

    // ─────────────────────────────────────────────
    //  index
    // ─────────────────────────────────────────────
    public function index(Request $request)
    {
        $peminjaman = $this->buildQuery($request)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $totalPengajuan = Peminjaman::where('status', 'pengajuan')->count();
        $totalKembali   = Peminjaman::where('status', 'pengajuan_kembali')->count();
        $totalDidenda   = Peminjaman::where('status', 'didenda')->count();

        return view('admin.peminjaman.index', compact(
            'peminjaman', 'totalPengajuan', 'totalKembali', 'totalDidenda'
        ));
    }

    // ─────────────────────────────────────────────
    //  exportPdf
    // ─────────────────────────────────────────────
    public function exportPdf(Request $request)
    {
        $peminjaman = $this->buildQuery($request)->latest()->get();
        return view('admin.peminjaman.print', compact('peminjaman'));
    }

    // ─────────────────────────────────────────────
    //  show
    // ─────────────────────────────────────────────
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'detailBuku.buku']);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    // ─────────────────────────────────────────────
    //  setujui
    // ─────────────────────────────────────────────
    public function setujui(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pengajuan') {
            return back()->withErrors(['status' => 'Status tidak sesuai.']);
        }

        $request->validate(['catatan_admin' => 'nullable|string|max:500']);

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

    // ─────────────────────────────────────────────
    //  tolak
    // ─────────────────────────────────────────────
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

    // ─────────────────────────────────────────────
    //  konfirmasiKembali
    //  ► Jika kondisi Rusak Berat / Hilang → status "didenda"
    //  ► Selain itu → status "dikembalikan"
    // ─────────────────────────────────────────────
    public function konfirmasiKembali(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pengajuan_kembali') {
            return back()->withErrors(['status' => 'Status tidak sesuai.']);
        }

        $request->validate([
            'kondisi_buku'    => 'required|string|max:255',
            'catatan_admin'   => 'nullable|string|max:500',
            // Wajib diisi jika kondisi Rusak Berat atau Hilang
            'denda_kerusakan' => 'nullable|integer|min:0',
            'catatan_kerusakan' => 'nullable|string|max:1000',
        ]);

        $kondisiYangDidenda = ['Rusak Berat', 'Hilang'];
        $perluDenda = in_array($request->kondisi_buku, $kondisiYangDidenda);

        if ($perluDenda) {
            // Validasi tambahan: nominal denda wajib diisi
            $request->validate([
                'denda_kerusakan'   => 'required|integer|min:1',
                'catatan_kerusakan' => 'required|string|max:1000',
            ]);

            // Stok BELUM dikembalikan — buku rusak/hilang tidak kembali ke rak
            // Stok baru dipulihkan setelah admin konfirmasi selesai (jika hilang: tidak pulihkan stok)
            // Untuk Rusak Berat: admin bisa memutuskan sendiri nanti lewat panel lain

            $peminjaman->update([
                'status'              => 'didenda',
                'kondisi_buku'        => $request->kondisi_buku,
                'catatan_admin'       => $request->catatan_admin,
                'denda_kerusakan'     => $request->denda_kerusakan,
                'catatan_kerusakan'   => $request->catatan_kerusakan,
                'denda_kerusakan_lunas' => false,
                'denda_lunas'         => ($peminjaman->jumlah_denda > 0) ? true : false,
            ]);

            return back()->with('success', 'Buku dinyatakan ' . strtolower($request->kondisi_buku) . '. Tagihan denda telah dikirim ke siswa.');
        }

        // ── Kondisi normal (Baik / Cukup Baik / Rusak Ringan) ──
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

    // ─────────────────────────────────────────────
    //  konfirmasiPembayaranDendaKerusakan
    //  ► Dipanggil setelah user upload bukti bayar denda kerusakan
    //  ► Admin klik tombol "Konfirmasi Pembayaran"
    // ─────────────────────────────────────────────
    public function konfirmasiPembayaranDendaKerusakan(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'didenda') {
            return back()->withErrors(['status' => 'Status tidak sesuai.']);
        }

        if (!$peminjaman->foto_bukti_denda_kerusakan) {
            return back()->withErrors(['bukti' => 'Siswa belum mengupload bukti pembayaran denda.']);
        }

        $request->validate(['catatan_admin' => 'nullable|string|max:500']);

        // Pulihkan stok hanya jika kondisi bukan Hilang
        if ($peminjaman->kondisi_buku !== 'Hilang') {
            foreach ($peminjaman->detailBuku as $detail) {
                $detail->buku->increment('jumlah_buku', $detail->jumlah);
            }
        }

        $peminjaman->update([
            'status'                => 'dikembalikan',
            'denda_kerusakan_lunas' => true,
            'catatan_admin'         => $request->catatan_admin ?? $peminjaman->catatan_admin,
        ]);

        return back()->with('success', 'Pembayaran denda dikonfirmasi. Peminjaman selesai.');
    }
}