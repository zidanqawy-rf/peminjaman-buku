<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DendaSetting extends Model
{
    protected $fillable = [
        'denda_per_hari',
        'no_rekening',
        'nama_rekening',
        'bank',
        'keterangan',
    ];
}