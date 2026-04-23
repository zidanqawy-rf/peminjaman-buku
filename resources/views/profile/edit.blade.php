{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.app')

@section('header')
    Profil Saya
@endsection

@section('content')
<div style="display:flex;flex-direction:column;gap:20px;max-width:680px;margin-bottom: 50px;">

    {{-- Breadcrumb --}}
    <div>
        <p style="font-size:11px;color:#94a3b8;margin-bottom:4px">Pengaturan › Profil</p>
        <h1 style="font-size:20px;font-weight:800;color:#0f172a;margin:0">Pengaturan Akun</h1>
    </div>

    {{-- Section: Update Informasi Profil --}}
    <div style="background:#fff;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.05);overflow:hidden">
        <div style="padding:22px">
            <div style="max-width: 100%">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>

    {{-- Section: Ganti Password --}}
    <div style="background:#fff;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.05);overflow:hidden">
        <div style="padding:22px">
            <div style="max-width: 100%">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>

    {{-- Section: Hapus Akun --}}
    <div style="background:#fff;border-radius:16px;border:1px solid #fecaca;box-shadow:0 1px 4px rgba(0,0,0,.05);overflow:hidden">
        <div style="padding:22px; background: #fff8f8">
            <div style="max-width: 100%">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>

</div>

<style>
    /* Mengatasi styling default form Breeze agar lebih menyatu dengan desain baru */
    input[type="text"], input[type="email"], input[type="password"] {
        width: 100%;
        border: 1.5px solid #e2e8f0 !important;
        border-radius: 10px !important;
        padding: 10px 14px !important;
        font-size: 13.5px !important;
        margin-top: 5px !important;
        background: #f8fafc !important;
    }
    
    section header h2 {
        font-size: 16px !important;
        font-weight: 800 !important;
        color: #0f172a !important;
    }

    section header p {
        font-size: 13px !important;
        color: #64748b !important;
        margin-bottom: 15px !important;
    }

    /* Tombol simpan default Breeze */
    .inline-flex.items-center.px-4.py-2.bg-gray-800 {
        background: linear-gradient(135deg,#3b82f6,#2563eb) !important;
        border-radius: 10px !important;
        font-weight: 700 !important;
        text-transform: none !important;
        letter-spacing: normal !important;
        border: none !important;
    }
</style>
@endsection