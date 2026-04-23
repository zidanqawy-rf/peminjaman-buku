<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'user_id',
        'tanggal_pinjam',
        'tanggal_rencana_kembali',
        'tanggal_kembali',
        'status',
        'foto_pengembalian',
        'foto_bukti_denda',
        'catatan',
        'catatan_admin',
        'kondisi_buku',
        'hari_terlambat',
        'jumlah_denda',
        'denda_lunas',
    ];

    /**
     * Casting tipe data otomatis.
     */
    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_rencana_kembali' => 'date',
        'tanggal_kembali' => 'date',
        'denda_lunas' => 'boolean',
        'hari_terlambat' => 'integer',
        'jumlah_denda' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke model User (Peminjam).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi Many-to-Many ke model Buku.
     * Mengakses tabel pivot 'peminjaman_buku' dan mengambil kolom 'jumlah'.
     */
    public function buku()
    {
        return $this->belongsToMany(
            Buku::class,
            'peminjaman_buku',
            'peminjaman_id',
            'buku_id'
        )
        ->withPivot('jumlah')
        ->withTimestamps();
    }

    /**
     * Relasi Has-Many ke tabel pivot PeminjamanBuku (Detail).
     * Digunakan untuk fungsi withSum() di controller agar perhitungan jumlah buku akurat.
     */
    public function detailBuku()
    {
        // Pastikan nama model pivot Anda adalah PeminjamanBuku
        return $this->hasMany(PeminjamanBuku::class, 'peminjaman_id');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS & LOGIC
    |--------------------------------------------------------------------------
    */

    /**
     * Cek apakah peminjaman sudah melewati batas waktu.
     */
    public function isLate(): bool
    {
        $tanggalRencana = Carbon::parse($this->tanggal_rencana_kembali);
        $tanggalCheck = $this->tanggal_kembali 
            ? Carbon::parse($this->tanggal_kembali) 
            : Carbon::today();

        return $tanggalCheck->gt($tanggalRencana);
    }

    /**
     * Menghitung selisih hari keterlambatan.
     */
    public function hariTerlambat(): int
    {
        if (!is_null($this->hari_terlambat) && $this->hari_terlambat > 0) {
            return (int) $this->hari_terlambat;
        }

        $tanggalRencana = Carbon::parse($this->tanggal_rencana_kembali);
        $tanggalCheck = $this->tanggal_kembali 
            ? Carbon::parse($this->tanggal_kembali) 
            : Carbon::today();

        if ($tanggalCheck->lte($tanggalRencana)) {
            return 0;
        }

        return (int) $tanggalRencana->diffInDays($tanggalCheck);
    }

    /**
     * Menghitung total denda berdasarkan tarif denda per hari.
     */
    public function hitungDenda(int $dendaPerHari): int
    {
        if (!is_null($this->jumlah_denda) && $this->jumlah_denda > 0) {
            return (int) $this->jumlah_denda;
        }

        return $this->hariTerlambat() * $dendaPerHari;
    }

    /**
     * Mendapatkan label status dalam bahasa Indonesia yang lebih ramah.
     */
    public function statusLabel(): string
    {
        return match ($this->status) {
            'pengajuan' => 'Menunggu Persetujuan',
            'disetujui' => 'Sedang Dipinjam',
            'ditolak' => 'Ditolak',
            'pengajuan_kembali' => 'Proses Pengembalian',
            'dikembalikan' => 'Sudah Dikembalikan',
            default => ucfirst($this->status),
        };
    }

    /**
     * Mendapatkan warna status untuk keperluan styling UI.
     */
    public function statusColor(): string
    {
        return match ($this->status) {
            'pengajuan' => 'yellow',
            'disetujui' => 'blue',
            'ditolak' => 'red',
            'pengajuan_kembali' => 'purple',
            'dikembalikan' => 'green',
            default => 'gray',
        };
    }
}