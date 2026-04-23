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
        $bukus    = Buku::with('kategori')->latest()->get();
        $kategoris = Kategori::all();
        return view('admin.bukus.index', compact('bukus', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_buku'    => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'jumlah_buku'  => 'required|integer|min:1',
            'kategori_id'  => 'nullable|exists:kategoris,id',
            'pengarang'    => 'nullable|string|max:255',
            'penerbit'     => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|digits:4',
            'gambar'       => 'nullable|image|max:2048',
        ]);

        $data = $request->except('gambar');
        $data['stok_tersedia'] = $request->jumlah_buku;

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('bukus', 'public');
        }

        Buku::create($data);
        return back()->with('success', 'Buku berhasil ditambahkan.');
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'nama_buku'    => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'jumlah_buku'  => 'required|integer|min:1',
            'kategori_id'  => 'nullable|exists:kategoris,id',
            'pengarang'    => 'nullable|string|max:255',
            'penerbit'     => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|digits:4',
            'gambar'       => 'nullable|image|max:2048',
        ]);

        $data = $request->except('gambar');

        // Sesuaikan stok proporsional terhadap perubahan jumlah
        $selisih = $request->jumlah_buku - $buku->jumlah_buku;
        $data['stok_tersedia'] = max(0, $buku->stok_tersedia + $selisih);

        if ($request->hasFile('gambar')) {
            if ($buku->gambar) Storage::disk('public')->delete($buku->gambar);
            $data['gambar'] = $request->file('gambar')->store('bukus', 'public');
        }

        $buku->update($data);
        return back()->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->gambar) Storage::disk('public')->delete($buku->gambar);
        $buku->delete();
        return back()->with('success', 'Buku berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            $import = new BukuImport;
            Excel::import($import, $request->file('file'));

            // Kumpulkan error baris yang dilewati
            $failures = $import->failures();
            $errors   = $import->errors();

            if ($failures->isNotEmpty() || count($errors) > 0) {
                $pesan = [];

                foreach ($failures as $failure) {
                    $pesan[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
                }
                foreach ($errors as $error) {
                    $pesan[] = $error->getMessage();
                }

                // Import tetap dijalankan untuk baris yang valid,
                // tapi beritahu admin baris mana yang bermasalah
                return back()
                    ->with('success', 'Import selesai, namun beberapa baris dilewati.')
                    ->with('import_errors', $pesan);
            }

            return back()->with('success', 'Data buku berhasil diimpor seluruhnya.');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = collect($e->failures())->map(function ($f) {
                return "Baris {$f->row()}: " . implode(', ', $f->errors());
            })->toArray();

            return back()
                ->withErrors(['file' => 'Import gagal karena data tidak valid.'])
                ->with('import_errors', $failures);

        } catch (\Exception $e) {
            return back()->withErrors([
                'file' => 'Gagal mengimpor file: ' . $e->getMessage(),
            ]);
        }
    }
}