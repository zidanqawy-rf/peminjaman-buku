<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus'; // ⚠️ pastikan sesuai database kamu (bukus / buku)

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

    // ── RELASI ────────────────────────────────
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function peminjaman()
    {
        return $this->belongsToMany(Peminjaman::class, 'peminjaman_buku')
            ->withPivot('jumlah')
            ->withTimestamps();
    }
}