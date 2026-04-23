<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DendaSetting;

class DendaSettingSeeder extends Seeder
{
    public function run(): void
    {
        DendaSetting::firstOrCreate([], [
            'denda_per_hari' => 1000,
            'no_rekening'    => '1234567890',
            'nama_rekening'  => 'Admin Perpustakaan',
            'bank'           => 'BRI',
            'keterangan'     => 'Denda keterlambatan pengembalian buku per hari',
        ]);
    }
}