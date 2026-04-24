<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\PeminjamanBuku;
use App\Models\DendaSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORM PEMINJAMAN
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $buku = Buku::where('jumlah_buku', '>', 0)->orderBy('nama_buku')->get();
        return view('user.peminjaman.create', compact('buku'));
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN PEMINJAMAN
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pinjam'          => 'required|date|after_or_equal:today',
            'tanggal_rencana_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'catatan'                 => 'nullable|string|max:500',
            'buku'                    => 'required|array|min:1',
            'buku.*.id'               => 'required|exists:bukus,id',
            'buku.*.jumlah'           => 'required|integer|min:1',
        ]);

        foreach ($request->buku as $item) {
            $bk = Buku::findOrFail($item['id']);
            if ($bk->jumlah_buku < $item['jumlah']) {
                return back()->withErrors([
                    'stok' => 'Stok buku "' . $bk->nama_buku . '" tidak mencukupi. Sisa stok: ' . $bk->jumlah_buku
                ])->withInput();
            }
        }

        $peminjaman = Peminjaman::create([
            'user_id'                 => Auth::id(),
            'tanggal_pinjam'          => $request->tanggal_pinjam,
            'tanggal_rencana_kembali' => $request->tanggal_rencana_kembali,
            'catatan'                 => $request->catatan,
            'status'                  => 'pengajuan',
        ]);

        foreach ($request->buku as $item) {
            PeminjamanBuku::create([
                'peminjaman_id' => $peminjaman->id,
                'buku_id'       => $item['id'],
                'jumlah'        => $item['jumlah'],
            ]);
        }

        return redirect()->route('peminjaman.riwayat')->with('success', 'Peminjaman berhasil diajukan.');
    }

    /*
    |--------------------------------------------------------------------------
    | RIWAYAT PEMINJAMAN
    |--------------------------------------------------------------------------
    */
    public function riwayat(Request $request)
    {
        $query = Peminjaman::with('buku')->where('user_id', Auth::id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('buku', function ($q) use ($search) {
                $q->where('nama_buku', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_pinjam', $request->tanggal);
        }

        $peminjaman = $query->latest()->paginate(10)->withQueryString();

        return view('user.peminjaman.index', compact('peminjaman'));
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL PEMINJAMAN
    |--------------------------------------------------------------------------
    */
    public function show(Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== Auth::id()) {
            abort(403);
        }

        $dendaSetting = DendaSetting::first();
        $dendaPerHari = $dendaSetting?->denda_per_hari ?? 1000;
        $today        = Carbon::today();

        $tanggalPatokan = $peminjaman->tanggal_kembali
            ? Carbon::parse($peminjaman->tanggal_kembali)
            : Carbon::today();

        $tanggalRencana = Carbon::parse($peminjaman->tanggal_rencana_kembali);

        $hariTerlambat = $tanggalPatokan->gt($tanggalRencana)
            ? $tanggalRencana->diffInDays($tanggalPatokan)
            : 0;

        $jumlahDenda = $hariTerlambat * $dendaPerHari;

        return view('user.peminjaman.show', compact(
            'peminjaman', 'dendaSetting', 'hariTerlambat', 'jumlahDenda', 'today'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | AJUKAN PENGEMBALIAN
    |--------------------------------------------------------------------------
    */
    public function kembalikan(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== Auth::id()) abort(403);

        if ($peminjaman->status !== 'disetujui') {
            return back()->withErrors(['status' => 'Peminjaman ini tidak dapat diajukan pengembalian.']);
        }

        $request->validate([
            'tanggal_kembali'   => 'required|date|after_or_equal:today',
            'foto_pengembalian' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'foto_bukti_denda'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $tanggalKembali = Carbon::parse($request->tanggal_kembali);
        $tanggalRencana = Carbon::parse($peminjaman->tanggal_rencana_kembali);
        $dendaSetting   = DendaSetting::first();
        $dendaPerHari   = $dendaSetting?->denda_per_hari ?? 1000;

        $hariTerlambat = $tanggalKembali->gt($tanggalRencana)
            ? $tanggalRencana->diffInDays($tanggalKembali)
            : 0;

        $jumlahDenda = $hariTerlambat * $dendaPerHari;

        if ($jumlahDenda > 0 && !$request->hasFile('foto_bukti_denda')) {
            return back()->withErrors([
                'foto_bukti_denda' => 'Bukti pembayaran denda wajib diupload karena terjadi keterlambatan.'
            ])->withInput();
        }

        $fotoPengembalian = $request->file('foto_pengembalian')->store('pengembalian', 'public');
        $fotoBuktiDenda   = null;

        if ($request->hasFile('foto_bukti_denda')) {
            $fotoBuktiDenda = $request->file('foto_bukti_denda')->store('bukti_denda', 'public');
        }

        $peminjaman->update([
            'tanggal_kembali'   => $tanggalKembali,
            'foto_pengembalian' => $fotoPengembalian,
            'foto_bukti_denda'  => $fotoBuktiDenda,
            'hari_terlambat'    => $hariTerlambat,
            'jumlah_denda'      => $jumlahDenda,
            'status'            => 'pengajuan_kembali',
        ]);

        return redirect()->route('peminjaman.riwayat')
            ->with('success', 'Pengembalian berhasil diajukan dan menunggu konfirmasi admin.');
    }

    /*
    |--------------------------------------------------------------------------
    | BAYAR DENDA KERUSAKAN / KEHILANGAN  ← METHOD BARU
    |  Dipanggil saat user upload bukti pembayaran denda kerusakan
    |--------------------------------------------------------------------------
    */
    public function bayarDendaKerusakan(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== Auth::id()) abort(403);

        if ($peminjaman->status !== 'didenda') {
            return back()->withErrors(['status' => 'Status peminjaman tidak sesuai.']);
        }

        $request->validate([
            'foto_bukti_denda_kerusakan' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $foto = $request->file('foto_bukti_denda_kerusakan')
            ->store('bukti_denda_kerusakan', 'public');

        $peminjaman->update([
            'foto_bukti_denda_kerusakan' => $foto,
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu konfirmasi admin.');
    }
}