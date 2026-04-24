<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

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
        // ── Kolom baru untuk denda kerusakan/kehilangan ──
        'denda_kerusakan',
        'catatan_kerusakan',
        'foto_bukti_denda_kerusakan',
        'denda_kerusakan_lunas',
    ];

    protected $casts = [
        'tanggal_pinjam'          => 'date',
        'tanggal_rencana_kembali' => 'date',
        'tanggal_kembali'         => 'date',
        'denda_lunas'             => 'boolean',
        'denda_kerusakan_lunas'   => 'boolean',
        'hari_terlambat'          => 'integer',
        'jumlah_denda'            => 'integer',
        'denda_kerusakan'         => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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

    public function detailBuku()
    {
        return $this->hasMany(PeminjamanBuku::class, 'peminjaman_id');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS & LOGIC
    |--------------------------------------------------------------------------
    */

    public function isLate(): bool
    {
        $tanggalRencana = Carbon::parse($this->tanggal_rencana_kembali);
        $tanggalCheck   = $this->tanggal_kembali
            ? Carbon::parse($this->tanggal_kembali)
            : Carbon::today();

        return $tanggalCheck->gt($tanggalRencana);
    }

    public function hariTerlambat(): int
    {
        if (!is_null($this->hari_terlambat) && $this->hari_terlambat > 0) {
            return (int) $this->hari_terlambat;
        }

        $tanggalRencana = Carbon::parse($this->tanggal_rencana_kembali);
        $tanggalCheck   = $this->tanggal_kembali
            ? Carbon::parse($this->tanggal_kembali)
            : Carbon::today();

        if ($tanggalCheck->lte($tanggalRencana)) {
            return 0;
        }

        return (int) $tanggalRencana->diffInDays($tanggalCheck);
    }

    public function hitungDenda(int $dendaPerHari): int
    {
        if (!is_null($this->jumlah_denda) && $this->jumlah_denda > 0) {
            return (int) $this->jumlah_denda;
        }

        return $this->hariTerlambat() * $dendaPerHari;
    }

    /**
     * Total seluruh tagihan (denda keterlambatan + denda kerusakan/kehilangan).
     */
    public function totalDenda(): int
    {
        return ((int) $this->jumlah_denda) + ((int) $this->denda_kerusakan);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pengajuan'         => 'Menunggu Persetujuan',
            'disetujui'         => 'Sedang Dipinjam',
            'ditolak'           => 'Ditolak',
            'pengajuan_kembali' => 'Proses Pengembalian',
            'didenda'           => 'Ada Tagihan Denda',   // ← STATUS BARU
            'dikembalikan'      => 'Sudah Dikembalikan',
            default             => ucfirst($this->status),
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'pengajuan'         => 'yellow',
            'disetujui'         => 'blue',
            'ditolak'           => 'red',
            'pengajuan_kembali' => 'purple',
            'didenda'           => 'orange',              // ← STATUS BARU
            'dikembalikan'      => 'green',
            default             => 'gray',
        };
    }
}