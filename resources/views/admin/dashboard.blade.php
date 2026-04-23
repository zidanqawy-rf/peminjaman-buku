@extends('layouts.app-admin')
@section('content')

<div style="display:flex;flex-direction:column;gap:20px">

    {{-- Row 1: Banner + Total User --}}
    <div style="display:grid;grid-template-columns:1fr 280px;gap:20px;align-items:stretch">

        {{-- Welcome Banner --}}
        <div style="background:linear-gradient(135deg,#3b82f6 0%,#2563eb 100%);border-radius:16px;padding:32px 36px;color:#fff;position:relative;overflow:hidden;min-height:160px">
            <div style="position:absolute;top:-40px;right:-40px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,.07);pointer-events:none"></div>
            <div style="position:absolute;bottom:-30px;right:80px;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,.05);pointer-events:none"></div>
            <p style="font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:10px">Admin Panel</p>
            <h2 style="font-size:22px;font-weight:800;margin-bottom:8px">Selamat datang, {{ Auth::user()->name }}</h2>
            <p style="font-size:13.5px;color:rgba(255,255,255,.75);line-height:1.5">Kelola user, buku, peminjaman, dan laporan perpustakaan sekolah Anda.</p>
        </div>

        {{-- Total User --}}
        <div style="background:#fff;border-radius:16px;padding:24px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.05);display:flex;flex-direction:column;justify-content:space-between">
            <div style="display:flex;align-items:center;justify-content:space-between">
                <p style="font-size:13px;color:#64748b;font-weight:500">Total User</p>
                <div style="width:44px;height:44px;border-radius:12px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg style="width:22px;height:22px;color:#60a5fa" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <div>
                <p style="font-size:42px;font-weight:800;color:#1e293b;line-height:1">{{ \App\Models\User::count() }}</p>
                <p style="font-size:12px;color:#94a3b8;margin-top:6px">Akun terdaftar</p>
            </div>
        </div>

    </div>

    {{-- Row 2: Peminjaman Aktif + Selesai --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

        {{-- Peminjaman Aktif --}}
        <div style="background:#fff;border-radius:16px;padding:24px 28px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.05);display:flex;align-items:center;justify-content:space-between">
            <div>
                <p style="font-size:13px;color:#64748b;font-weight:500;margin-bottom:10px">Peminjaman Aktif</p>
                <p style="font-size:42px;font-weight:800;color:#a855f7;line-height:1">0</p>
                <p style="font-size:12px;color:#94a3b8;margin-top:6px">Disetujui &amp; Sedang Dipinjam</p>
            </div>
            <div style="width:52px;height:52px;border-radius:14px;background:#faf5ff;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg style="width:24px;height:24px;color:#c084fc" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        {{-- Peminjaman Selesai --}}
        <div style="background:#fff;border-radius:16px;padding:24px 28px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.05);display:flex;align-items:center;justify-content:space-between">
            <div>
                <p style="font-size:13px;color:#64748b;font-weight:500;margin-bottom:10px">Peminjaman Selesai</p>
                <p style="font-size:42px;font-weight:800;color:#22c55e;line-height:1">0</p>
                <p style="font-size:12px;color:#94a3b8;margin-top:6px">Berhasil dikembalikan</p>
            </div>
            <div style="width:52px;height:52px;border-radius:14px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg style="width:24px;height:24px;color:#4ade80" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

    </div>

    {{-- Row 3: Aksi Cepat --}}
    <div style="background:#fff;border-radius:16px;padding:24px 28px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.05)">
        <p style="font-size:15px;font-weight:700;color:#1e293b;margin-bottom:16px">Aksi Cepat</p>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px">

            {{-- Buka modal tambah user --}}
            <button onclick="bukaTambahUser()"
                style="display:flex;align-items:center;justify-content:center;gap:10px;padding:14px 16px;border-radius:12px;border:none;cursor:pointer;color:#fff;font-size:13.5px;font-weight:700;background:linear-gradient(135deg,#3b82f6,#2563eb);box-shadow:0 4px 12px rgba(59,130,246,.3);transition:transform .15s"
                onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                <svg style="width:16px;height:16px;flex-shrink:0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah User Baru
            </button>

            {{-- ✅ Diperbaiki: users.index → admin.users.index --}}
            <a href="{{ route('admin.users.index') }}"
                style="display:flex;align-items:center;justify-content:center;gap:10px;padding:14px 16px;border-radius:12px;color:#fff;font-size:13.5px;font-weight:700;text-decoration:none;background:linear-gradient(135deg,#a855f7,#7c3aed);box-shadow:0 4px 12px rgba(168,85,247,.3);transition:transform .15s"
                onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                <svg style="width:16px;height:16px;flex-shrink:0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Kelola User
            </a>

            <a href="{{ route('admin.peminjaman.index') }}"
                style="display:flex;align-items:center;justify-content:center;gap:10px;padding:14px 16px;border-radius:12px;color:#fff;font-size:13.5px;font-weight:700;text-decoration:none;background:linear-gradient(135deg,#f59e0b,#d97706);box-shadow:0 4px 12px rgba(245,158,11,.3);transition:transform .15s"
                onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                <svg style="width:16px;height:16px;flex-shrink:0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Daftar Peminjaman
            </a>

        </div>
    </div>

    {{-- Row 4: Feature Cards --}}
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px">

        <div style="background:#fff;border-radius:16px;padding:24px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.05)">
            <div style="width:44px;height:44px;border-radius:12px;background:#eff6ff;display:flex;align-items:center;justify-content:center;margin-bottom:16px">
                <svg style="width:20px;height:20px;color:#3b82f6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <p style="font-weight:700;color:#1e293b;font-size:14px;margin-bottom:6px">Kelola User</p>
            <p style="font-size:13px;color:#94a3b8;line-height:1.5">Tambah, edit, dan hapus pengguna dengan mudah.</p>
        </div>

        <div style="background:#fff;border-radius:16px;padding:24px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.05)">
            <div style="width:44px;height:44px;border-radius:12px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;margin-bottom:16px">
                <svg style="width:20px;height:20px;color:#22c55e" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
            </div>
            <p style="font-weight:700;color:#1e293b;font-size:14px;margin-bottom:6px">Kelola Buku</p>
            <p style="font-size:13px;color:#94a3b8;line-height:1.5">Pantau dan kelola koleksi buku perpustakaan.</p>
        </div>

        <div style="background:#fff;border-radius:16px;padding:24px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.05)">
            <div style="width:44px;height:44px;border-radius:12px;background:#faf5ff;display:flex;align-items:center;justify-content:center;margin-bottom:16px">
                <svg style="width:20px;height:20px;color:#a855f7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
            </div>
            <p style="font-weight:700;color:#1e293b;font-size:14px;margin-bottom:6px">Daftar Peminjaman</p>
            <p style="font-size:13px;color:#94a3b8;line-height:1.5">Monitor semua aktivitas peminjaman secara real-time.</p>
        </div>

    </div>

</div>

{{-- Modal Tambah User --}}
<div id="modalTambah"
     style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:100;align-items:center;justify-content:center;backdrop-filter:blur(4px)"
     onclick="if(event.target===this)this.style.display='none'">
    <div style="background:#fff;border-radius:20px;width:100%;max-width:460px;box-shadow:0 20px 60px rgba(0,0,0,.15);overflow:hidden;animation:slideUp .2s ease">

        <div style="padding:24px 28px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between">
            <div style="display:flex;align-items:center;gap:12px">
                <div style="width:40px;height:40px;background:#eff6ff;border-radius:11px;display:flex;align-items:center;justify-content:center">
                    <svg style="width:18px;height:18px;color:#3b82f6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <div>
                    <p style="font-weight:800;font-size:15px;color:#0f172a">Tambah User Baru</p>
                    <p style="font-size:12px;color:#94a3b8;margin-top:1px">Isi data akun siswa</p>
                </div>
            </div>
            <button onclick="document.getElementById('modalTambah').style.display='none'"
                style="width:32px;height:32px;border-radius:8px;background:#f1f5f9;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:18px;line-height:1"
                onmouseover="this.style.background='#fee2e2';this.style.color='#ef4444'"
                onmouseout="this.style.background='#f1f5f9';this.style.color='#94a3b8'">×</button>
        </div>

        {{-- ✅ Diperbaiki: users.store → admin.users.store --}}
        <form method="POST" action="{{ route('admin.users.store') }}" style="padding:24px 28px">
            @csrf
            <div style="margin-bottom:16px">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">Nama Lengkap</label>
                <input type="text" name="name" placeholder="Nama lengkap siswa" required
                    style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13.5px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box"
                    onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none'">
            </div>
            <div style="margin-bottom:16px">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">Email</label>
                <input type="email" name="email" placeholder="email@student.sch.id" required
                    style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13.5px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box"
                    onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none'">
            </div>
            <div style="margin-bottom:16px">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">Password</label>
                <input type="password" name="password" placeholder="••••••••" required
                    style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13.5px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box"
                    onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none'">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px">
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">Kelas</label>
                    <input type="text" name="kelas" placeholder="cth: XII-A"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13.5px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box"
                        onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                        onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none'">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">Jurusan</label>
                    <input type="text" name="jurusan" placeholder="cth: RPL"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13.5px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box"
                        onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                        onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none'">
                </div>
            </div>
            <div style="margin-bottom:24px">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">NISN</label>
                <input type="text" name="nisn" placeholder="10 digit NISN"
                    style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13.5px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box"
                    onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none'">
            </div>
            <div style="display:flex;gap:10px;padding-top:4px;border-top:1px solid #f1f5f9">
                <button type="button"
                    onclick="document.getElementById('modalTambah').style.display='none'"
                    style="flex:1;padding:11px;border-radius:10px;background:#fff;border:1.5px solid #e2e8f0;color:#64748b;font-size:13px;font-weight:600;cursor:pointer"
                    onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
                    Batal
                </button>
                <button type="submit"
                    style="flex:1;padding:11px;border-radius:10px;border:none;color:#fff;font-size:13px;font-weight:700;cursor:pointer;background:linear-gradient(135deg,#3b82f6,#2563eb);box-shadow:0 2px 8px rgba(59,130,246,.3)"
                    onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes slideUp {
        from { opacity:0; transform:translateY(12px) scale(.98) }
        to   { opacity:1; transform:translateY(0) scale(1) }
    }
</style>

<script>
    function bukaTambahUser() {
        document.getElementById('modalTambah').style.display = 'flex';
    }
</script>

@endsection