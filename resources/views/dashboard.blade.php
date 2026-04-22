{{-- resources/views/dashboard.blade.php --}}

@extends('layouts.app')

@section('header')
    Dashboard Siswa
@endsection

@section('content')
<div class="py-8 px-6">
    <div class="max-w-5xl mx-auto space-y-8">

        <!-- Welcome -->
        <div class="bg-gradient-to-r from-green-500 to-green-700 text-white rounded-2xl shadow-lg p-8">
            <h1 class="text-3xl font-bold mb-2">
                Selamat Datang, {{ auth()->user()->name }} 👋
            </h1>
            <p class="text-green-100 text-lg">
                Gunakan sistem perpustakaan untuk peminjaman dan pengembalian buku dengan mudah.
            </p>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow p-6">
                <p class="text-gray-500 text-sm">Total Peminjaman</p>
                <h2 class="text-4xl font-bold text-green-700 mt-2">{{ $totalPeminjaman ?? 0 }}</h2>
            </div>
            <div class="bg-white rounded-2xl shadow p-6">
                <p class="text-gray-500 text-sm">Sedang Dipinjam</p>
                <h2 class="text-4xl font-bold text-yellow-500 mt-2">{{ $sedangDipinjam ?? 0 }}</h2>
            </div>
            <div class="bg-white rounded-2xl shadow p-6">
                <p class="text-gray-500 text-sm">Sudah Dikembalikan</p>
                <h2 class="text-4xl font-bold text-green-500 mt-2">{{ $sudahDikembalikan ?? 0 }}</h2>
            </div>
        </div>

        <!-- Aksi Cepat -->
        <div class="bg-white rounded-2xl shadow p-8">
            <h3 class="text-xl font-bold mb-5 text-gray-700">Aksi Cepat</h3>
            <div class="grid md:grid-cols-2 gap-4">
                <a href="#"
                    class="block text-center bg-green-500 hover:bg-green-600 text-white py-4 rounded-xl font-semibold transition shadow">
                    📚 Tambah Peminjaman
                </a>
                <a href="#"
                    class="block text-center bg-green-700 hover:bg-green-800 text-white py-4 rounded-xl font-semibold transition shadow">
                    📋 Riwayat Peminjaman
                </a>
            </div>
        </div>

        <!-- Info Akun -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Informasi Akun</h3>
            <div class="grid md:grid-cols-2 gap-4 text-sm text-gray-600">
                <div><span class="font-medium text-gray-700">Nama: </span>{{ auth()->user()->name }}</div>
                <div><span class="font-medium text-gray-700">Email: </span>{{ auth()->user()->email }}</div>
                @if(auth()->user()->kelas)
                <div><span class="font-medium text-gray-700">Kelas: </span>{{ auth()->user()->kelas }}</div>
                @endif
                @if(auth()->user()->jurusan)
                <div><span class="font-medium text-gray-700">Jurusan: </span>{{ auth()->user()->jurusan }}</div>
                @endif
                @if(auth()->user()->nisn)
                <div><span class="font-medium text-gray-700">NISN: </span>{{ auth()->user()->nisn }}</div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection