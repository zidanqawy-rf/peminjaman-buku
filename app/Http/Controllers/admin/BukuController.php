<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BukuImport;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::with('kategori')->latest()->get();
        $kategoris = Kategori::all();
        return view('admin.bukus.index', compact('bukus', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_buku'   => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'jumlah_buku' => 'required|integer|min:1',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'pengarang'   => 'nullable|string|max:255',
            'penerbit'    => 'nullable|string|max:255',
            'tahun_terbit'=> 'nullable|digits:4',
            'gambar'      => 'nullable|image|max:2048',
        ]);

        $data = $request->except('gambar');
        $data['stok_tersedia'] = $request->jumlah_buku;

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('bukus', 'public');
        }

        Buku::create($data);
        return back()->with('success', 'Buku berhasil ditambahkan');
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'nama_buku'   => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'jumlah_buku' => 'required|integer|min:1',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'pengarang'   => 'nullable|string|max:255',
            'penerbit'    => 'nullable|string|max:255',
            'tahun_terbit'=> 'nullable|digits:4',
            'gambar'      => 'nullable|image|max:2048',
        ]);

        $data = $request->except('gambar');

        // Sesuaikan stok jika jumlah_buku berubah
        $selisih = $request->jumlah_buku - $buku->jumlah_buku;
        $data['stok_tersedia'] = max(0, $buku->stok_tersedia + $selisih);

        if ($request->hasFile('gambar')) {
            if ($buku->gambar) Storage::disk('public')->delete($buku->gambar);
            $data['gambar'] = $request->file('gambar')->store('bukus', 'public');
        }

        $buku->update($data);
        return back()->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->gambar) Storage::disk('public')->delete($buku->gambar);
        $buku->delete();
        return back()->with('success', 'Buku berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new BukuImport, $request->file('file'));
        return back()->with('success', 'Data buku berhasil diimpor');
    }
}