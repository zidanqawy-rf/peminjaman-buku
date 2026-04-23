<?php

namespace App\Imports;

use App\Models\Buku;
use App\Models\Kategori;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;

class BukuImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnFailure,     // Lewati baris yang gagal validasi (tidak throw exception)
    SkipsOnError        // Lewati baris yang error database
{
    use SkipsFailures, SkipsErrors;

    public function model(array $row)
    {
        // Abaikan baris kosong
        if (empty(trim($row['nama_buku'] ?? ''))) {
            return null;
        }

        // Cari atau buat kategori
        $kategoriId = null;
        if (!empty(trim($row['kategori'] ?? ''))) {
            $kategori = Kategori::firstOrCreate(
                ['nama_kategori' => trim($row['kategori'])]
            );
            $kategoriId = $kategori->id;
        }

        $jumlah = max(1, (int) ($row['jumlah_buku'] ?? 1));

        return new Buku([
            'nama_buku'    => trim($row['nama_buku']),
            'deskripsi'    => $row['deskripsi']    ?? null,
            'jumlah_buku'  => $jumlah,
            'stok_tersedia'=> $jumlah,
            'kategori_id'  => $kategoriId,
            'pengarang'    => $row['pengarang']    ?? null,
            'penerbit'     => $row['penerbit']     ?? null,
            'tahun_terbit' => !empty($row['tahun_terbit']) ? (int) $row['tahun_terbit'] : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_buku'   => 'required|string|max:255',
            'jumlah_buku' => 'required|integer|min:1',
        ];
    }

    /**
     * Pesan validasi kustom (opsional, memudahkan debug)
     */
    public function customValidationMessages(): array
    {
        return [
            'nama_buku.required'   => 'Kolom nama_buku wajib diisi.',
            'jumlah_buku.required' => 'Kolom jumlah_buku wajib diisi.',
            'jumlah_buku.integer'  => 'Kolom jumlah_buku harus berupa angka.',
        ];
    }
}