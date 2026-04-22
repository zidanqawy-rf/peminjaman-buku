<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_buku',
        'deskripsi',
        'jumlah_buku',
        'stok_tersedia',
        'kategori_id',
        'gambar',
        'pengarang',
        'penerbit',
        'tahun_terbit',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}