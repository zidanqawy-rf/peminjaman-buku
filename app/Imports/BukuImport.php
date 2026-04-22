<?php

namespace App\Imports;

use App\Models\Buku;
use App\Models\Kategori;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BukuImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Cari atau buat kategori
        $kategori = null;
        if (!empty($row['kategori'])) {
            $kategori = Kategori::firstOrCreate(['nama_kategori' => $row['kategori']]);
        }

        $jumlah = (int) ($row['jumlah_buku'] ?? 1);

        return new Buku([
            'nama_buku'    => $row['nama_buku'],
            'deskripsi'    => $row['deskripsi'] ?? null,
            'jumlah_buku'  => $jumlah,
            'stok_tersedia'=> $jumlah,
            'kategori_id'  => $kategori?->id,
            'pengarang'    => $row['pengarang'] ?? null,
            'penerbit'     => $row['penerbit'] ?? null,
            'tahun_terbit' => $row['tahun_terbit'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_buku' => 'required|string',
            'jumlah_buku' => 'required|integer|min:1',
        ];
    }
}