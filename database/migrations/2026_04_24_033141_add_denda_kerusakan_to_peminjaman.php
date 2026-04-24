<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Nominal denda kerusakan/kehilangan yang diinput admin
            $table->unsignedInteger('denda_kerusakan')->default(0)->after('jumlah_denda');

            // Catatan admin mengenai kerusakan/kehilangan
            $table->text('catatan_kerusakan')->nullable()->after('denda_kerusakan');

            // Foto bukti pembayaran denda kerusakan (diupload ulang oleh user)
            $table->string('foto_bukti_denda_kerusakan')->nullable()->after('catatan_kerusakan');

            // Status pembayaran denda kerusakan
            $table->boolean('denda_kerusakan_lunas')->default(false)->after('foto_bukti_denda_kerusakan');
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn([
                'denda_kerusakan',
                'catatan_kerusakan',
                'foto_bukti_denda_kerusakan',
                'denda_kerusakan_lunas',
            ]);
        });
    }
};