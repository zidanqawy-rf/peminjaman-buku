<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('denda_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('denda_per_hari')->default(1000);
            $table->string('no_rekening')->nullable();
            $table->string('nama_rekening')->nullable();
            $table->string('bank')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('denda_settings');
    }
};