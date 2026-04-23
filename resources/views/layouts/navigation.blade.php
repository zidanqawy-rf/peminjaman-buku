{{-- resources/views/layouts/navigation.blade.php --}}

<aside style="position:fixed;top:0;left:0;height:100vh;width:260px;background:#064e3b;display:flex;flex-direction:column;z-index:50;box-shadow: 4px 0 24px rgba(0,0,0,0.15)">

    {{-- Logo --}}
    <div style="padding:24px;border-bottom:1px solid rgba(255,255,255,.06)">
        <h1 style="color:#fff;font-weight:700;font-size:17px;letter-spacing:.3px">📖 Perpustakaan</h1>
        <p style="color:rgba(255,255,255,.35);font-size:11.5px;margin-top:3px">Sistem Peminjaman Buku</p>
    </div>

    {{-- Navigation --}}
    <nav style="flex:1;padding:16px 12px;display:flex;flex-direction:column;gap:2px;overflow-y:auto">

        @php
            $linkBase = "display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:12px;font-size:13.5px;font-weight:500;text-decoration:none;transition:all .15s";
            // Gradient Hijau untuk User
            $linkActive = $linkBase . ";color:#fff;background:linear-gradient(135deg,#10b981,#059669);box-shadow:0 4px 14px rgba(16,185,129,.35)";
            $linkInactive = $linkBase . ";color:rgba(255,255,255,.5)";
            
            $spanBase = "width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0";
            $spanActive = $spanBase . ";background:rgba(255,255,255,.2)";
            $spanInactive = $spanBase . ";background:rgba(255,255,255,.06)";
        @endphp

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="{{ request()->routeIs('dashboard') ? 'is-active' : '' }}"
           style="{{ request()->routeIs('dashboard') ? $linkActive : $linkInactive }}"
           onmouseover="if(!this.classList.contains('is-active')){this.style.background='rgba(255,255,255,.06)';this.style.color='rgba(255,255,255,.85)'}"
           onmouseout="if(!this.classList.contains('is-active')){this.style.background='transparent';this.style.color='rgba(255,255,255,.5)'}">
            <span style="{{ request()->routeIs('dashboard') ? $spanActive : $spanInactive }}">
                <svg style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </span>
            Dashboard
        </a>

        {{-- Tambah Peminjaman --}}
        <a href="{{ route('peminjaman.tambah') }}"
           class="{{ request()->routeIs('peminjaman.tambah') ? 'is-active' : '' }}"
           style="{{ request()->routeIs('peminjaman.tambah') ? $linkActive : $linkInactive }}"
           onmouseover="if(!this.classList.contains('is-active')){this.style.background='rgba(255,255,255,.06)';this.style.color='rgba(255,255,255,.85)'}"
           onmouseout="if(!this.classList.contains('is-active')){this.style.background='transparent';this.style.color='rgba(255,255,255,.5)'}">
            <span style="{{ request()->routeIs('peminjaman.tambah') ? $spanActive : $spanInactive }}">
                <svg style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
            </span>
            Tambah Peminjaman
        </a>

        {{-- Riwayat Peminjaman --}}
        <a href="{{ route('peminjaman.riwayat') }}"
           class="{{ request()->routeIs('peminjaman.riwayat') ? 'is-active' : '' }}"
           style="{{ request()->routeIs('peminjaman.riwayat') ? $linkActive : $linkInactive }}"
           onmouseover="if(!this.classList.contains('is-active')){this.style.background='rgba(255,255,255,.06)';this.style.color='rgba(255,255,255,.85)'}"
           onmouseout="if(!this.classList.contains('is-active')){this.style.background='transparent';this.style.color='rgba(255,255,255,.5)'}">
            <span style="{{ request()->routeIs('peminjaman.riwayat') ? $spanActive : $spanInactive }}">
                <svg style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </span>
            Riwayat Peminjaman
        </a>

        <p style="font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:rgba(255,255,255,.25);padding:14px 14px 6px">
            Akun Saya
        </p>

        {{-- Profile --}}
        <a href="{{ route('profile.edit') }}"
           class="{{ request()->routeIs('profile.*') ? 'is-active' : '' }}"
           style="{{ request()->routeIs('profile.*') ? $linkActive : $linkInactive }}"
           onmouseover="if(!this.classList.contains('is-active')){this.style.background='rgba(255,255,255,.06)';this.style.color='rgba(255,255,255,.85)'}"
           onmouseout="if(!this.classList.contains('is-active')){this.style.background='transparent';this.style.color='rgba(255,255,255,.5)'}">
            <span style="{{ request()->routeIs('profile.*') ? $spanActive : $spanInactive }}">
                <svg style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </span>
            Profile Pengguna
        </a>

    </nav>

    {{-- User + Logout --}}
    <div style="padding:14px 12px;border-top:1px solid rgba(255,255,255,.06)">
        <div style="display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:12px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.06);margin-bottom:10px">
            <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff;flex-shrink:0">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div style="min-width:0">
                <p style="color:#fff;font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ Auth::user()->name }}</p>
                <p style="color:rgba(255,255,255,.35);font-size:11px">{{ ucfirst(Auth::user()->role) }}</p>
            </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                style="width:100%;display:flex;align-items:center;justify-content:center;gap:8px;padding:10px;border-radius:10px;border:none;cursor:pointer;font-size:13px;font-weight:600;background:rgba(255,255,255,.07);color:rgba(255,255,255,.6);transition:all .15s"
                onmouseover="this.style.background='rgba(255,255,255,.12)';this.style.color='rgba(255,255,255,.9)'"
                onmouseout="this.style.background='rgba(255,255,255,.07)';this.style.color='rgba(255,255,255,.6)'">
                <svg style="width:15px;height:15px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>