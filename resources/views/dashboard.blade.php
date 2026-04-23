{{-- resources/views/dashboard.blade.php --}}

@extends('layouts.app')

@section('header')
    Dashboard Siswa
@endsection

@section('content')
<div style="padding: 24px; max-width: 1100px; margin: 0 auto; display: flex; flex-direction: column; gap: 24px;">

    <div style="background: linear-gradient(135deg, #10b981, #047857); border-radius: 20px; padding: 32px; color: white; box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.2);">
        <div style="display: flex; align-items: center; gap: 20px;">
            <div style="flex: 1;">
                <h1 style="font-size: 28px; font-weight: 800; margin: 0; letter-spacing: -0.025em;">
                    Selamat Datang, {{ auth()->user()->name }} 👋
                </h1>
                <p style="font-size: 15px; color: #d1fae5; margin-top: 8px; font-weight: 500; opacity: 0.9;">
                    Sistem Perpustakaan Digital. Kelola peminjaman dan jelajahi koleksi buku dengan lebih efisien.
                </p>
            </div>
            <div style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 16px; backdrop-filter: blur(4px);">
                <svg style="width: 40px; height: 40px; color: white;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
        <div style="background: #fff; border-radius: 18px; padding: 24px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <p style="font-size: 13px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Total Peminjaman</p>
            <div style="display: flex; align-items: baseline; gap: 8px; margin-top: 12px;">
                <h2 style="font-size: 36px; font-weight: 800; color: #064e3b; margin: 0;">{{ $totalPeminjaman ?? 0 }}</h2>
                <span style="font-size: 14px; color: #94a3b8; font-weight: 600;">transaksi</span>
            </div>
        </div>

        <div style="background: #fff; border-radius: 18px; padding: 24px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <p style="font-size: 13px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Sedang Dipinjam</p>
            <div style="display: flex; align-items: baseline; gap: 8px; margin-top: 12px;">
                <h2 style="font-size: 36px; font-weight: 800; color: #b45309; margin: 0;">{{ $sedangDipinjam ?? 0 }}</h2>
                <span style="font-size: 14px; color: #94a3b8; font-weight: 600;">buku</span>
            </div>
        </div>

        <div style="background: #fff; border-radius: 18px; padding: 24px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <p style="font-size: 13px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Sudah Kembali</p>
            <div style="display: flex; align-items: baseline; gap: 8px; margin-top: 12px;">
                <h2 style="font-size: 36px; font-weight: 800; color: #10b981; margin: 0;">{{ $sudahDikembalikan ?? 0 }}</h2>
                <span style="font-size: 14px; color: #94a3b8; font-weight: 600;">selesai</span>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 24px;">
        
        <div style="background: #fff; border-radius: 20px; border: 1px solid #e2e8f0; padding: 28px;">
            <h3 style="font-size: 18px; font-weight: 800; color: #1e293b; margin: 0 0 20px 0; display: flex; align-items: center; gap: 10px;">
                <span style="width: 4px; height: 18px; background: #10b981; border-radius: 10px;"></span>
                Aksi Cepat
            </h3>
            <div style="display: grid; gap: 12px;">
                <a href="{{ route('peminjaman.tambah') }}" 
                   style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-radius: 14px; background: #f0fdf4; border: 1.5px solid #dcfce7; color: #166534; text-decoration: none; font-weight: 700; transition: all 0.2s;"
                   onmouseover="this.style.background='#dcfce7'; this.style.transform='translateX(4px)'" 
                   onmouseout="this.style.background='#f0fdf4'; this.style.transform='translateX(0)'">
                    <span style="display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 20px;">📚</span> Tambah Peminjaman Baru
                    </span>
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>

                <a href="{{ route('peminjaman.riwayat') }}" 
                   style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-radius: 14px; background: #f8fafc; border: 1.5px solid #f1f5f9; color: #475569; text-decoration: none; font-weight: 700; transition: all 0.2s;"
                   onmouseover="this.style.background='#f1f5f9'; this.style.transform='translateX(4px)'" 
                   onmouseout="this.style.background='#f8fafc'; this.style.transform='translateX(0)'">
                    <span style="display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 20px;">📋</span> Lihat Riwayat Saya
                    </span>
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>
        </div>

        <div style="background: #fff; border-radius: 20px; border: 1px solid #e2e8f0; padding: 28px;">
            <h3 style="font-size: 18px; font-weight: 800; color: #1e293b; margin: 0 0 20px 0; display: flex; align-items: center; gap: 10px;">
                <span style="width: 4px; height: 18px; background: #64748b; border-radius: 10px;"></span>
                Informasi Akun
            </h3>
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div style="padding-bottom: 12px; border-bottom: 1px dashed #e2e8f0;">
                    <p style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin: 0 0 4px 0;">Nama Lengkap</p>
                    <p style="font-size: 14px; font-weight: 600; color: #1e293b; margin: 0;">{{ auth()->user()->name }}</p>
                </div>
                <div style="padding-bottom: 12px; border-bottom: 1px dashed #e2e8f0;">
                    <p style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin: 0 0 4px 0;">Email</p>
                    <p style="font-size: 14px; font-weight: 600; color: #1e293b; margin: 0;">{{ auth()->user()->email }}</p>
                </div>
                @if(auth()->user()->kelas || auth()->user()->nisn)
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div>
                        <p style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin: 0 0 4px 0;">Kelas</p>
                        <p style="font-size: 14px; font-weight: 600; color: #1e293b; margin: 0;">{{ auth()->user()->kelas ?? '-' }}</p>
                    </div>
                    <div>
                        <p style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin: 0 0 4px 0;">NISN</p>
                        <p style="font-size: 14px; font-weight: 600; color: #1e293b; margin: 0;">{{ auth()->user()->nisn ?? '-' }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection