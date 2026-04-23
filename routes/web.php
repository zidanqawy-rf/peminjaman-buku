<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\DendaController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard user
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Peminjaman
    Route::get('/peminjaman/tambah',    [App\Http\Controllers\User\PeminjamanController::class, 'create'])->name('peminjaman.tambah');
    Route::post('/peminjaman',          [App\Http\Controllers\User\PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/riwayat',   [App\Http\Controllers\User\PeminjamanController::class, 'riwayat'])->name('peminjaman.riwayat');
    Route::get('/peminjaman/{peminjaman}', [App\Http\Controllers\User\PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::post('/peminjaman/{peminjaman}/kembalikan', [App\Http\Controllers\User\PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');

    
});

// Admin
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('users', UserController::class);

        Route::resource('bukus', BukuController::class)->except(['show', 'create', 'edit']);
        Route::post('bukus/import', [BukuController::class, 'import'])->name('bukus.import');

        Route::resource('kategoris', KategoriController::class)->except(['show', 'create', 'edit']);

        // Peminjaman
        Route::get('/peminjaman',           [App\Http\Controllers\Admin\PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('/peminjaman/{peminjaman}', [App\Http\Controllers\Admin\PeminjamanController::class, 'show'])->name('peminjaman.show');
        Route::post('/peminjaman/{peminjaman}/setujui',          [App\Http\Controllers\Admin\PeminjamanController::class, 'setujui'])->name('peminjaman.setujui');
        Route::post('/peminjaman/{peminjaman}/tolak',            [App\Http\Controllers\Admin\PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
        Route::post('/peminjaman/{peminjaman}/konfirmasi-kembali',[App\Http\Controllers\Admin\PeminjamanController::class, 'konfirmasiKembali'])->name('peminjaman.konfirmasiKembali');

        // Denda
        Route::get('/denda', [DendaController::class, 'index'])->name('denda.index');
        Route::post('/denda', [DendaController::class, 'update'])->name('denda.update');
});
    

require __DIR__.'/auth.php';