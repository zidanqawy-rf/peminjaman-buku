@extends('layouts.app-admin')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div style="display:flex;flex-direction:column;gap:20px">

    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
        <div>
            <p style="font-size:11px;color:#94a3b8;margin-bottom:4px">Admin Panel › Kelola User</p>
            <h1 style="font-size:20px;font-weight:800;color:#0f172a;margin:0">Kelola User</h1>
            <p style="font-size:13px;color:#94a3b8;margin-top:3px">Daftar seluruh akun siswa yang terdaftar di sistem.</p>
        </div>
        <button onclick="document.getElementById('modalTambah').style.display='flex'"
            style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:12px;border:none;cursor:pointer;color:#fff;font-size:13.5px;font-weight:700;background:linear-gradient(135deg,#3b82f6,#2563eb);box-shadow:0 4px 12px rgba(59,130,246,.3);transition:transform .15s"
            onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">
            <svg style="width:15px;height:15px" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah User
        </button>
    </div>

    {{-- Flash Error --}}
    @if(session('error'))
    <div style="padding:12px 18px;border-radius:12px;background:#fef2f2;border:1px solid #fecaca;color:#dc2626;font-size:13px;font-weight:600">
        ⚠️ {{ session('error') }}
    </div>
    @endif

    {{-- Table Panel --}}
    <div style="background:#fff;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.05);overflow:hidden">

        {{-- Panel Header --}}
        <div style="padding:18px 24px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px">
            <div>
                <p style="font-size:14px;font-weight:700;color:#1e293b;margin:0">Daftar User Siswa</p>
                <p style="font-size:12px;color:#94a3b8;margin-top:2px" id="jumlahData">{{ $users->count() }} akun ditemukan</p>
            </div>
        </div>

        {{-- Search --}}
        <div style="padding:12px 24px;background:#f8fafc;border-bottom:1px solid #f1f5f9">
            <input type="text" id="searchInput" placeholder="Cari nama, email, atau NISN..."
                style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:9px 14px;font-size:13px;color:#1e293b;background:#fff;outline:none;box-sizing:border-box"
                onfocus="this.style.borderColor='#3b82f6';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'"
                oninput="filterTable(this.value)">
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto">
            <table style="width:100%;border-collapse:collapse">
                <thead>
                    <tr style="background:#f8fafc;border-bottom:2px solid #f1f5f9">
                        <th style="padding:12px 24px;text-align:left;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.7px;white-space:nowrap">Pengguna</th>
                        <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.7px">Kelas</th>
                        <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.7px">Jurusan</th>
                        <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.7px">NISN</th>
                        <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.7px">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($users as $index => $user)
                    @php
                        $colors = [
                            ['bg'=>'#eff6ff','color'=>'#1d4ed8'],
                            ['bg'=>'#f0fdf4','color'=>'#15803d'],
                            ['bg'=>'#faf5ff','color'=>'#7c3aed'],
                            ['bg'=>'#fff7ed','color'=>'#c2410c'],
                            ['bg'=>'#fef9c3','color'=>'#a16207'],
                        ];
                        $c = $colors[$index % count($colors)];
                    @endphp
                    <tr style="border-bottom:1px solid #f1f5f9;transition:background .1s"
                        onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'"
                        data-name="{{ strtolower($user->name) }}"
                        data-email="{{ strtolower($user->email) }}"
                        data-nisn="{{ strtolower($user->nisn ?? '') }}">
                        <td style="padding:14px 24px">
                            <div style="display:flex;align-items:center;gap:12px">
                                <div style="width:36px;height:36px;border-radius:10px;background:{{ $c['bg'] }};color:{{ $c['color'] }};display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;flex-shrink:0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p style="font-size:13.5px;font-weight:600;color:#1e293b;margin:0">{{ $user->name }}</p>
                                    <p style="font-size:12px;color:#94a3b8;margin:2px 0 0">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td style="padding:14px 16px">
                            <span style="display:inline-flex;padding:3px 10px;border-radius:20px;font-size:11.5px;font-weight:600;background:#eff6ff;color:#1d4ed8">
                                {{ $user->kelas ?? '—' }}
                            </span>
                        </td>
                        <td style="padding:14px 16px;font-size:13.5px;color:#475569">{{ $user->jurusan ?? '—' }}</td>
                        <td style="padding:14px 16px;font-size:12.5px;color:#94a3b8;font-family:monospace">{{ $user->nisn ?? '—' }}</td>
                        <td style="padding:14px 16px">
                            <div style="display:flex;align-items:center;gap:8px">

                                {{-- Tombol Edit --}}
                                <button type="button"
                                    onclick="openEditModal(
                                        {{ $user->id }},
                                        '{{ addslashes($user->name) }}',
                                        '{{ addslashes($user->email) }}',
                                        '{{ addslashes($user->kelas ?? '') }}',
                                        '{{ addslashes($user->jurusan ?? '') }}',
                                        '{{ addslashes($user->nisn ?? '') }}'
                                    )"
                                    style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;border:none;cursor:pointer;font-size:12px;font-weight:600;background:#eff6ff;color:#2563eb;transition:background .15s"
                                    onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='#eff6ff'">
                                    <svg style="width:13px;height:13px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 012.828 2.828L11.828 15.828a2 2 0 01-1.414.586H9v-2.414a2 2 0 01.586-1.414z"/>
                                    </svg>
                                    Edit
                                </button>

                                {{-- Form Hapus --}}
                                <form id="form-hapus-{{ $user->id }}"
                                      action="{{ route('admin.users.destroy', $user->id) }}"
                                      method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button"
                                    onclick="konfirmasiHapus({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                    style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;border:none;cursor:pointer;font-size:12px;font-weight:600;background:#fef2f2;color:#ef4444;transition:background .15s"
                                    onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#fef2f2'">
                                    <svg style="width:13px;height:13px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="emptyRow">
                        <td colspan="5" style="text-align:center;padding:60px 24px">
                            <div style="width:56px;height:56px;border-radius:16px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;margin:0 auto 14px">
                                <svg style="width:26px;height:26px;color:#cbd5e1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <p style="font-size:14px;font-weight:700;color:#1e293b;margin:0">Belum ada data user</p>
                            <p style="font-size:13px;color:#94a3b8;margin-top:4px">Tambahkan user pertama dengan tombol di atas.</p>
                        </td>
                    </tr>
                    @endforelse

                    {{-- Row tidak ditemukan saat search --}}
                    <tr id="notFoundRow" style="display:none">
                        <td colspan="5" style="text-align:center;padding:40px 24px;color:#94a3b8;font-size:13px">
                            Tidak ada data yang cocok dengan pencarian.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div style="padding:14px 24px;background:#f8fafc;border-top:1px solid #f1f5f9">
            <p style="font-size:12.5px;color:#94a3b8;margin:0" id="footerCount">Menampilkan {{ $users->count() }} data</p>
        </div>
    </div>
</div>

{{-- ===================== MODAL TAMBAH ===================== --}}
<div id="modalTambah"
     style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:100;align-items:center;justify-content:center;backdrop-filter:blur(4px)"
     onclick="if(event.target===this)this.style.display='none'">
    <div style="background:#fff;border-radius:20px;width:100%;max-width:460px;margin:16px;box-shadow:0 20px 60px rgba(0,0,0,.15);overflow:hidden;animation:slideUp .2s ease">

        <div style="padding:22px 28px 18px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between">
            <div style="display:flex;align-items:center;gap:12px">
                <div style="width:40px;height:40px;background:#eff6ff;border-radius:11px;display:flex;align-items:center;justify-content:center">
                    <svg style="width:18px;height:18px;color:#3b82f6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <div>
                    <p style="font-weight:800;font-size:15px;color:#0f172a;margin:0">Tambah User Baru</p>
                    <p style="font-size:12px;color:#94a3b8;margin:2px 0 0">Isi data akun siswa</p>
                </div>
            </div>
            <button onclick="document.getElementById('modalTambah').style.display='none'"
                style="width:32px;height:32px;border-radius:8px;background:#f1f5f9;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:20px;line-height:1"
                onmouseover="this.style.background='#fee2e2';this.style.color='#ef4444'"
                onmouseout="this.style.background='#f1f5f9';this.style.color='#94a3b8'">×</button>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}" style="padding:24px 28px;max-height:80vh;overflow-y:auto">
            @csrf

            {{-- Validasi Error --}}
            @if($errors->any())
            <div style="padding:12px 16px;border-radius:10px;background:#fef2f2;border:1px solid #fecaca;color:#dc2626;font-size:12.5px;margin-bottom:16px">
                <p style="font-weight:700;margin:0 0 4px">Terdapat kesalahan:</p>
                <ul style="margin:0;padding-left:16px">
                    @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                </ul>
            </div>
            @endif

            <div style="margin-bottom:16px">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">Nama Lengkap <span style="color:#ef4444">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap siswa" required
                    style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13.5px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box"
                    onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none'">
            </div>
            <div style="margin-bottom:16px">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">Email <span style="color:#ef4444">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="email@student.sch.id" required
                    style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13.5px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box"
                    onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none'">
            </div>
            <div style="margin-bottom:16px">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">Password <span style="color:#ef4444">*</span></label>
                <div style="position:relative">
                    <input type="password" name="password" id="pw_tambah" placeholder="Minimal 6 karakter" required
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 40px 10px 14px;font-size:13.5px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box"
                        onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                        onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none'">
                    <button type="button" onclick="togglePw('pw_tambah','eye_tambah')"
                        style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;padding:0">
                        <svg id="eye_tambah" style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px">
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">Kelas</label>
                    <input type="text" name="kelas" value="{{ old('kelas') }}" placeholder="cth: XII-A"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13.5px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box"
                        onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                        onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none'">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">Jurusan</label>
                    <input type="text" name="jurusan" value="{{ old('jurusan') }}" placeholder="cth: RPL"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13.5px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box"
                        onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                        onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none'">
                </div>
            </div>
            <div style="margin-bottom:24px">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">NISN</label>
                <input type="text" name="nisn" value="{{ old('nisn') }}" placeholder="10 digit NISN"
                    style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13.5px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box"
                    onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none'">
            </div>
            <div style="display:flex;gap:10px;padding-top:16px;border-top:1px solid #f1f5f9">
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

{{-- ===================== MODAL EDIT ===================== --}}
<div id="modalEdit"
     style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:100;align-items:center;justify-content:center;backdrop-filter:blur(4px)"
     onclick="if(event.target===this)this.style.display='none'">
    <div style="background:#fff;border-radius:20px;width:100%;max-width:460px;margin:16px;box-shadow:0 20px 60px rgba(0,0,0,.15);overflow:hidden;animation:slideUp .2s ease">

        <div style="padding:22px 28px 18px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between">
            <div style="display:flex;align-items:center;gap:12px">
                <div style="width:40px;height:40px;background:#fef9c3;border-radius:11px;display:flex;align-items:center;justify-content:center">
                    <svg style="width:18px;height:18px;color:#ca8a04" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 012.828 2.828L11.828 15.828a2 2 0 01-1.414.586H9v-2.414a2 2 0 01.586-1.414z"/>
                    </svg>
                </div>
                <div>
                    <p style="font-weight:800;font-size:15px;color:#0f172a;margin:0">Edit User</p>
                    <p style="font-size:12px;color:#94a3b8;margin:2px 0 0">Perbarui data akun siswa</p>
                </div>
            </div>
            <button onclick="document.getElementById('modalEdit').style.display='none'"
                style="width:32px;height:32px;border-radius:8px;background:#f1f5f9;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:20px;line-height:1"
                onmouseover="this.style.background='#fee2e2';this.style.color='#ef4444'"
                onmouseout="this.style.background='#f1f5f9';this.style.color='#94a3b8'">×</button>
        </div>

        <form id="formEdit" method="POST" style="padding:24px 28px;max-height:80vh;overflow-y:auto">
            @csrf
            @method('PUT')
            <div style="margin-bottom:16px">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">Nama Lengkap <span style="color:#ef4444">*</span></label>
                <input id="edit_name" type="text" name="name" required
                    style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13.5px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box"
                    onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none'">
            </div>
            <div style="margin-bottom:16px">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">Email <span style="color:#ef4444">*</span></label>
                <input id="edit_email" type="email" name="email" required
                    style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13.5px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box"
                    onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none'">
            </div>
            <div style="margin-bottom:16px">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">
                    Password
                    <span style="text-transform:none;font-weight:400;color:#94a3b8;letter-spacing:0">— kosongkan jika tidak diubah</span>
                </label>
                <div style="position:relative">
                    <input type="password" name="password" id="pw_edit" placeholder="••••••••"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 40px 10px 14px;font-size:13.5px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box"
                        onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                        onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none'">
                    <button type="button" onclick="togglePw('pw_edit','eye_edit')"
                        style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;padding:0">
                        <svg id="eye_edit" style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px">
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">Kelas</label>
                    <input id="edit_kelas" type="text" name="kelas" placeholder="cth: XII-A"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13.5px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box"
                        onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                        onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none'">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">Jurusan</label>
                    <input id="edit_jurusan" type="text" name="jurusan" placeholder="cth: RPL"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13.5px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box"
                        onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                        onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none'">
                </div>
            </div>
            <div style="margin-bottom:24px">
                <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:7px">NISN</label>
                <input id="edit_nisn" type="text" name="nisn" placeholder="10 digit NISN"
                    style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13.5px;color:#1e293b;background:#f8fafc;outline:none;box-sizing:border-box"
                    onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.1)'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none'">
            </div>
            <div style="display:flex;gap:10px;padding-top:16px;border-top:1px solid #f1f5f9">
                <button type="button"
                    onclick="document.getElementById('modalEdit').style.display='none'"
                    style="flex:1;padding:11px;border-radius:10px;background:#fff;border:1.5px solid #e2e8f0;color:#64748b;font-size:13px;font-weight:600;cursor:pointer"
                    onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
                    Batal
                </button>
                <button type="submit"
                    style="flex:1;padding:11px;border-radius:10px;border:none;color:#fff;font-size:13px;font-weight:700;cursor:pointer;background:linear-gradient(135deg,#f59e0b,#d97706);box-shadow:0 2px 8px rgba(245,158,11,.3)"
                    onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">
                    Simpan Perubahan
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
.swal-btn-hapus {
    background: linear-gradient(135deg,#ef4444,#dc2626) !important;
    border-radius: 10px !important; font-weight:700 !important;
    font-size:13.5px !important; padding:10px 24px !important;
    box-shadow:0 4px 12px rgba(239,68,68,.35) !important;
}
.swal-btn-batal {
    background:#f1f5f9 !important; color:#64748b !important;
    border-radius:10px !important; font-weight:600 !important;
    font-size:13.5px !important; padding:10px 24px !important;
}
.swal-btn-batal:hover { background:#e2e8f0 !important; }
</style>

<script>
// ── Toggle show/hide password ──────────────────────────────────
function togglePw(inputId, eyeId) {
    const input = document.getElementById(inputId);
    const eye   = document.getElementById(eyeId);
    if (input.type === 'password') {
        input.type = 'text';
        eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;
    } else {
        input.type = 'password';
        eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
    }
}

// ── Konfirmasi hapus ───────────────────────────────────────────
function konfirmasiHapus(id, nama) {
    Swal.fire({
        title: 'Hapus Akun?',
        html: `Akun <strong>${nama}</strong> akan dihapus secara permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        customClass: { confirmButton:'swal-btn-hapus', cancelButton:'swal-btn-batal' },
        buttonsStyling: false,
        reverseButtons: true,
        focusCancel: true,
    }).then(result => {
        if (result.isConfirmed) document.getElementById('form-hapus-' + id).submit();
    });
}

// ── Buka modal edit ────────────────────────────────────────────
function openEditModal(id, name, email, kelas, jurusan, nisn) {
    document.getElementById('edit_name').value    = name;
    document.getElementById('edit_email').value   = email;
    document.getElementById('edit_kelas').value   = kelas;
    document.getElementById('edit_jurusan').value = jurusan;
    document.getElementById('edit_nisn').value    = nisn;
    document.getElementById('pw_edit').value      = '';
    document.getElementById('formEdit').action    = '/admin/users/' + id;
    document.getElementById('modalEdit').style.display = 'flex';
}

// ── Filter tabel + update counter ─────────────────────────────
function filterTable(query) {
    const q    = query.toLowerCase().trim();
    const rows = document.querySelectorAll('#tableBody tr[data-name]');
    let visible = 0;

    rows.forEach(row => {
        const match = (row.dataset.name  || '').includes(q)
                   || (row.dataset.email || '').includes(q)
                   || (row.dataset.nisn  || '').includes(q);
        row.style.display = match ? '' : 'none';
        if (match) visible++;
    });

    // Tampilkan row "tidak ditemukan" jika semua tersembunyi
    const notFound = document.getElementById('notFoundRow');
    if (notFound) notFound.style.display = (visible === 0 && q !== '') ? '' : 'none';

    document.getElementById('footerCount').textContent = `Menampilkan ${visible} data`;
}

// ── Flash sukses toast ─────────────────────────────────────────
@if(session('success'))
Swal.fire({
    toast: true, position:'top-end', icon:'success',
    title: '{{ session('success') }}',
    showConfirmButton: false, timer: 3000, timerProgressBar: true,
    didOpen: (t) => {
        t.addEventListener('mouseenter', Swal.stopTimer);
        t.addEventListener('mouseleave', Swal.resumeTimer);
    }
});
@endif

// ── Buka modal tambah otomatis jika ada error validasi ─────────
@if($errors->any())
document.getElementById('modalTambah').style.display = 'flex';
@endif
</script>

@endsection