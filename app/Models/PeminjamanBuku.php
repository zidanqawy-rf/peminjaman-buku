<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamanBuku extends Model
{
    protected $table = 'peminjaman_buku'; // sesuaikan dengan nama tabel kamu

    protected $fillable = [
        'peminjaman_id',
        'buku_id',
        'jumlah',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}