<aside style="position:fixed;top:0;left:0;height:100vh;width:260px;background:#1a2035;display:flex;flex-direction:column;z-index:50">

    {{-- Logo Section --}}
    <div style="padding:24px;border-bottom:1px solid rgba(255,255,255,.06)">
        <h1 style="color:#fff;font-weight:700;font-size:17px;letter-spacing:.3px;margin:0">Perpustakaan</h1>
        <p style="color:rgba(255,255,255,.35);font-size:11.5px;margin:4px 0 0">Sistem Peminjaman Buku</p>
    </div>

    {{-- Navigation Section --}}
    <nav style="flex:1;padding:16px 12px;display:flex;flex-direction:column;gap:4px;overflow-y:auto">

        @php
            $linkBase = "display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:12px;font-size:13.5px;font-weight:500;text-decoration:none;transition:all .2s ease";
            $linkActive = $linkBase . ";color:#fff;background:linear-gradient(135deg,#3b82f6,#2563eb);box-shadow:0 4px 12px rgba(59,130,246,.3)";
            $linkInactive = $linkBase . ";color:rgba(255,255,255,.5)";
            
            $spanBase = "width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0";
            $spanActive = $spanBase . ";background:rgba(255,255,255,.15)";
            $spanInactive = $spanBase . ";background:rgba(255,255,255,.05)";
        @endphp

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           style="{{ request()->routeIs('admin.dashboard') ? $linkActive : $linkInactive }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span style="{{ request()->routeIs('admin.dashboard') ? $spanActive : $spanInactive }}">
                <svg style="width:18px;height:18px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </span>
            Dashboard
        </a>

        <p style="font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:rgba(255,255,255,.2);padding:18px 14px 6px">Master Data</p>

        {{-- Kelola User --}}
        <a href="{{ route('admin.users.index') }}"
           style="{{ request()->routeIs('admin.users.*') ? $linkActive : $linkInactive }}"
           class="nav-link">
            <span style="{{ request()->routeIs('admin.users.*') ? $spanActive : $spanInactive }}">
                <svg style="width:18px;height:18px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </span>
            Kelola User
        </a>

        {{-- Kelola Buku --}}
        <a href="{{ route('admin.bukus.index') }}"
           style="{{ request()->routeIs('admin.bukus.*') ? $linkActive : $linkInactive }}"
           class="nav-link">
            <span style="{{ request()->routeIs('admin.bukus.*') ? $spanActive : $spanInactive }}">
                <svg style="width:18px;height:18px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/></svg>
            </span>
            Kelola Buku
        </a>

        {{-- Kelola Kategori --}}
        <a href="{{ route('admin.kategoris.index') }}"
           style="{{ request()->routeIs('admin.kategoris.*') ? $linkActive : $linkInactive }}"
           class="nav-link">
            <span style="{{ request()->routeIs('admin.kategoris.*') ? $spanActive : $spanInactive }}">
                <svg style="width:18px;height:18px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
            </span>
            Kelola Kategori
        </a>

        <p style="font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:rgba(255,255,255,.2);padding:18px 14px 6px">Transaksi</p>

        {{-- Daftar Peminjaman dengan Badge --}}
        <a href="{{ route('admin.peminjaman.index') }}"
           style="{{ request()->routeIs('admin.peminjaman.*') ? $linkActive : $linkInactive }}; position: relative;"
           class="nav-link">
            <span style="{{ request()->routeIs('admin.peminjaman.*') ? $spanActive : $spanInactive }}">
                <svg style="width:18px;height:18px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </span>
            <span style="flex: 1;">Daftar Peminjaman</span>

            {{-- Menampilkan Badge jika ada notifikasi --}}
            @if(isset($countNotifTotal) && $countNotifTotal > 0)
                <span style="background:#ef4444; color:#fff; font-size:10px; font-weight:800; padding:2px 8px; border-radius:20px; border:2px solid #1a2035; position: absolute; right: 12px; top: 50%; transform: translateY(-50%);">
                    {{ $countNotifTotal }}
                </span>
            @endif
        </a>

        {{-- Master Denda --}}
        <a href="{{ route('admin.denda.index') }}"
           style="{{ request()->routeIs('admin.denda.*') ? $linkActive : $linkInactive }}"
           class="nav-link">
            <span style="{{ request()->routeIs('admin.denda.*') ? $spanActive : $spanInactive }}">
                <svg style="width:18px;height:18px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
            Master Denda
        </a>

    </nav>

    {{-- Bottom Section (User & Profile) --}}
    <div style="padding:14px 12px;border-top:1px solid rgba(255,255,255,.06)">
        <a href="{{ route('profile.edit') }}" 
           style="display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:12px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.06);margin-bottom:10px;text-decoration:none;transition:all .2s">
            <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#3b82f6,#6366f1);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff;flex-shrink:0">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div style="min-width:0;flex:1">
                <p style="color:#fff;font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin:0">{{ Auth::user()->name }}</p>
                <p style="color:rgba(255,255,255,.35);font-size:11px;margin:0">Lihat Profil</p>
            </div>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="width:100%;display:flex;align-items:center;justify-content:center;gap:8px;padding:10px;border-radius:10px;border:none;cursor:pointer;font-size:13px;font-weight:600;background:rgba(255,255,255,.05);color:rgba(255,255,255,.5);transition:all .2s" onmouseover="this.style.background='rgba(239,68,68,.1)';this.style.color='#ef4444'" onmouseout="this.style.background='rgba(255,255,255,.05)';this.style.color='rgba(255,255,255,.5)'">
                <svg style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

<style>
    .nav-link:not(.active):hover {
        background: rgba(255, 255, 255, 0.06) !important;
        color: rgba(255, 255, 255, 0.9) !important;
    }
    nav::-webkit-scrollbar { width: 4px; }
    nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
</style>