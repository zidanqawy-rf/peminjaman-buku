<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\DendaController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\User\PeminjamanController as UserPeminjamanController;

Route::get('/', function () {
    return view('welcome');
});

// ─── User (auth) ───────────────────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Peminjaman User
    Route::get('/peminjaman/tambah',  [UserPeminjamanController::class, 'create'])->name('peminjaman.tambah');
    Route::post('/peminjaman',        [UserPeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/riwayat', [UserPeminjamanController::class, 'riwayat'])->name('peminjaman.riwayat');
    Route::get('/peminjaman/{peminjaman}',                          [UserPeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::post('/peminjaman/{peminjaman}/kembalikan',              [UserPeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::post('/peminjaman/{peminjaman}/bayar-denda-kerusakan',   [UserPeminjamanController::class, 'bayarDendaKerusakan'])->name('peminjaman.bayarDendaKerusakan');

});

// ─── Admin ─────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Users
        Route::resource('users', UserController::class);

        // Buku
        Route::post('bukus/import', [BukuController::class, 'import'])->name('bukus.import');
        Route::resource('bukus', BukuController::class)->except(['show', 'create', 'edit']);

        // Kategori
        Route::resource('kategoris', KategoriController::class)->except(['show', 'create', 'edit']);

        // Peminjaman Admin
        // ⚠️ export-pdf & route statis HARUS didaftarkan SEBELUM /{peminjaman}
        Route::get('/peminjaman',             [AdminPeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('/peminjaman/export-pdf',  [AdminPeminjamanController::class, 'exportPdf'])->name('peminjaman.exportPdf');
        Route::get('/peminjaman/{peminjaman}',                              [AdminPeminjamanController::class, 'show'])->name('peminjaman.show');
        Route::post('/peminjaman/{peminjaman}/setujui',                     [AdminPeminjamanController::class, 'setujui'])->name('peminjaman.setujui');
        Route::post('/peminjaman/{peminjaman}/tolak',                       [AdminPeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
        Route::post('/peminjaman/{peminjaman}/konfirmasi-kembali',          [AdminPeminjamanController::class, 'konfirmasiKembali'])->name('peminjaman.konfirmasiKembali');
        Route::post('/peminjaman/{peminjaman}/konfirmasi-denda-kerusakan',  [AdminPeminjamanController::class, 'konfirmasiPembayaranDendaKerusakan'])->name('peminjaman.konfirmasiDendaKerusakan');

        // Denda Setting
        Route::get('/denda',  [DendaController::class, 'index'])->name('denda.index');
        Route::post('/denda', [DendaController::class, 'update'])->name('denda.update');
    });

require __DIR__.'/auth.php';