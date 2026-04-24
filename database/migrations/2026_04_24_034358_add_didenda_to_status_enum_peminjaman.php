<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status ENUM(
            'pengajuan',
            'disetujui',
            'ditolak',
            'pengajuan_kembali',
            'didenda',
            'dikembalikan'
        ) NOT NULL DEFAULT 'pengajuan'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status ENUM(
            'pengajuan',
            'disetujui',
            'ditolak',
            'pengajuan_kembali',
            'dikembalikan'
        ) NOT NULL DEFAULT 'pengajuan'");
    }
};