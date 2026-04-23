<?php

namespace App\Providers;

use App\Models\Peminjaman;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * View Composer untuk mengirim data notifikasi ke semua view (termasuk sidebar)
         */
        view()->composer('*', function ($view) {
            // Hitung data dengan status pengajuan
            $notifPeminjaman = Peminjaman::where('status', 'pengajuan')->count();
            
            // Hitung data dengan status pengajuan_kembali
            $notifPengembalian = Peminjaman::where('status', 'pengajuan_kembali')->count();
            
            // Kirim ke view
            $view->with([
                'countNotifTotal' => $notifPeminjaman + $notifPengembalian,
                'countNotifPeminjaman' => $notifPeminjaman,
                'countNotifPengembalian' => $notifPengembalian
            ]);
        });
    }
}