<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\KategoriController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard user
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
    });

require __DIR__.'/auth.php';