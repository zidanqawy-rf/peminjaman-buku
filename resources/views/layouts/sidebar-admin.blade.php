<aside style="position:fixed;top:0;left:0;height:100vh;width:260px;background:#1a2035;display:flex;flex-direction:column;z-index:50">

    {{-- Logo --}}
    <div style="padding:24px;border-bottom:1px solid rgba(255,255,255,.06)">
        <h1 style="color:#fff;font-weight:700;font-size:17px;letter-spacing:.3px">Perpustakaan</h1>
        <p style="color:rgba(255,255,255,.35);font-size:11.5px;margin-top:3px">Sistem Peminjaman Buku</p>
    </div>

    {{-- Navigation --}}
    <nav style="flex:1;padding:16px 12px;display:flex;flex-direction:column;gap:2px;overflow-y:auto">

        @php
            $linkBase = "display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:12px;font-size:13.5px;font-weight:500;text-decoration:none;transition:all .15s";
            $linkActive = $linkBase . ";color:#fff;background:linear-gradient(135deg,#3b82f6,#2563eb);box-shadow:0 4px 14px rgba(59,130,246,.35)";
            $linkInactive = $linkBase . ";color:rgba(255,255,255,.5)";
        @endphp

        <a href="{{ route('admin.dashboard') }}"
           style="{{ request()->routeIs('admin.dashboard') ? $linkActive : $linkInactive }}"
           onmouseover="if(!this.classList.contains('is-active'))this.style.background='rgba(255,255,255,.06)';this.style.color='rgba(255,255,255,.85)'"
           onmouseout="if(!this.classList.contains('is-active'))this.style.background='transparent';this.style.color='rgba(255,255,255,.5)'"
           class="{{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
            <span style="width:32px;height:32px;border-radius:8px;background:{{ request()->routeIs('admin.dashboard') ? 'rgba(255,255,255,.2)' : 'rgba(255,255,255,.06)' }};display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </span>
            Dashboard
        </a>

        {{-- ✅ Diperbaiki: users.index → admin.users.index & routeIs users.* → admin.users.* --}}
        <a href="{{ route('admin.users.index') }}"
           style="{{ request()->routeIs('admin.users.*') ? $linkActive : $linkInactive }}"
           onmouseover="if(!this.classList.contains('is-active'))this.style.background='rgba(255,255,255,.06)';this.style.color='rgba(255,255,255,.85)'"
           onmouseout="if(!this.classList.contains('is-active'))this.style.background='transparent';this.style.color='rgba(255,255,255,.5)'"
           class="{{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}">
            <span style="width:32px;height:32px;border-radius:8px;background:{{ request()->routeIs('admin.users.*') ? 'rgba(255,255,255,.2)' : 'rgba(255,255,255,.06)' }};display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </span>
            Kelola User
        </a>

        <a href="#"
           style="{{ $linkInactive }}"
           onmouseover="this.style.background='rgba(255,255,255,.06)';this.style.color='rgba(255,255,255,.85)'"
           onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,.5)'">
            <span style="width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,.06);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
            </span>
            Kelola Buku
        </a>

        <a href="#"
           style="{{ $linkInactive }}"
           onmouseover="this.style.background='rgba(255,255,255,.06)';this.style.color='rgba(255,255,255,.85)'"
           onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,.5)'">
            <span style="width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,.06);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </span>
            Kelola Kategori
        </a>

        {{-- Divider label --}}
        <p style="font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:rgba(255,255,255,.25);padding:14px 14px 6px">
            Transaksi
        </p>

        <a href="#"
           style="{{ $linkInactive }}"
           onmouseover="this.style.background='rgba(255,255,255,.06)';this.style.color='rgba(255,255,255,.85)'"
           onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,.5)'">
            <span style="width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,.06);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </span>
            Daftar Peminjaman
        </a>

        <a href="#"
           style="{{ $linkInactive }}"
           onmouseover="this.style.background='rgba(255,255,255,.06)';this.style.color='rgba(255,255,255,.85)'"
           onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,.5)'">
            <span style="width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,.06);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </span>
            Master Denda
        </a>

    </nav>

    {{-- User + Logout --}}
    <div style="padding:14px 12px;border-top:1px solid rgba(255,255,255,.06)">
        <div style="display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:12px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.06);margin-bottom:10px">
            <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#3b82f6,#6366f1);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff;flex-shrink:0">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div style="min-width:0">
                <p style="color:#fff;font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ Auth::user()->name }}</p>
                <p style="color:rgba(255,255,255,.35);font-size:11px">Administrator</p>
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