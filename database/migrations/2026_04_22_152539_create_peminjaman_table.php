<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Tanggal
            $table->date('tanggal_pinjam');
            $table->date('tanggal_rencana_kembali');
            $table->date('tanggal_kembali')->nullable();

            // Status alur peminjaman
            // pengajuan → disetujui → pengajuan_kembali → dikembalikan
            // atau: ditolak (admin menolak pengajuan)
            $table->enum('status', [
                'pengajuan',           // user baru submit
                'disetujui',           // admin setujui
                'ditolak',             // admin tolak
                'pengajuan_kembali',   // user submit pengembalian
                'dikembalikan',        // admin konfirmasi kembali
            ])->default('pengajuan');

            // Pengembalian
            $table->string('foto_pengembalian')->nullable();  // bukti foto buku
            $table->string('foto_bukti_denda')->nullable();   // bukti bayar denda

            // Info peminjaman
            $table->text('catatan')->nullable();              // keperluan dari user
            $table->string('kondisi_buku')->nullable();       // diisi admin saat validasi kembali
            $table->text('catatan_admin')->nullable();        // catatan dari admin

            // Denda
            $table->integer('hari_terlambat')->default(0);
            $table->decimal('jumlah_denda', 10, 2)->default(0);
            $table->boolean('denda_lunas')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};