{{-- resources/views/layouts/navigation.blade.php --}}

<aside style="width: 288px; position: fixed; top: 0; left: 0; height: 100vh; background: linear-gradient(to bottom, #166534, #16a34a); display: flex; flex-direction: column;"
    class="text-white shadow-2xl z-50">

    <!-- Logo -->
    <div style="padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.2); flex-shrink: 0;">
        <h1 style="font-size: 1.25rem; font-weight: 700; letter-spacing: 0.05em;">📖 Perpustakaan</h1>
        <p style="font-size: 0.75rem; color: #bbf7d0; margin-top: 0.25rem;">Sistem Peminjaman Buku</p>
    </div>

    <!-- Menu -->
    <nav style="margin-top: 1rem; padding: 0 0.75rem; flex: 1; overflow-y: auto;">

        <a href="{{ route('dashboard') }}"
           style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 0.75rem; font-weight: 600; margin-bottom: 0.25rem; text-decoration: none; transition: background 0.2s;
           {{ request()->routeIs('dashboard') ? 'background: white; color: #166534;' : 'color: white;' }}"
           onmouseover="{{ request()->routeIs('dashboard') ? '' : "this.style.background='rgba(255,255,255,0.2)'" }}"
           onmouseout="{{ request()->routeIs('dashboard') ? '' : "this.style.background='transparent'" }}">
            <span>🏠</span><span>Dashboard</span>
        </a>

        <a href="#"
           style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 0.75rem; font-weight: 500; margin-bottom: 0.25rem; text-decoration: none; color: white; transition: background 0.2s;"
           onmouseover="this.style.background='rgba(255,255,255,0.2)'"
           onmouseout="this.style.background='transparent'">
            <span>📚</span><span>Tambah Peminjaman</span>
        </a>

        <a href="#"
           style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 0.75rem; font-weight: 500; margin-bottom: 0.25rem; text-decoration: none; color: white; transition: background 0.2s;"
           onmouseover="this.style.background='rgba(255,255,255,0.2)'"
           onmouseout="this.style.background='transparent'">
            <span>📋</span><span>Riwayat Peminjaman</span>
        </a>

        <a href="{{ route('profile.edit') }}"
           style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 0.75rem; font-weight: 500; margin-bottom: 0.25rem; text-decoration: none; transition: background 0.2s;
           {{ request()->routeIs('profile.*') ? 'background: white; color: #166534;' : 'color: white;' }}"
           onmouseover="{{ request()->routeIs('profile.*') ? '' : "this.style.background='rgba(255,255,255,0.2)'" }}"
           onmouseout="{{ request()->routeIs('profile.*') ? '' : "this.style.background='transparent'" }}">
            <span>👤</span><span>Profile</span>
        </a>

    </nav>

    <!-- Footer User -->
    <div style="padding: 1rem; border-top: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.15); flex-shrink: 0;">

        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
            <div style="width: 2.5rem; height: 2.5rem; border-radius: 9999px; background: #bbf7d0; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #166534; flex-shrink: 0; font-size: 1rem;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div style="overflow: hidden;">
                <p style="font-weight: 600; font-size: 0.875rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ Auth::user()->name }}
                </p>
                <p style="font-size: 0.75rem; color: #bbf7d0; text-transform: capitalize;">
                    {{ Auth::user()->role }}
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                style="width: 100%; background: white; color: #166534; font-weight: 600; padding: 0.625rem; border-radius: 0.75rem; border: none; cursor: pointer; font-size: 0.875rem; transition: background 0.2s;"
                onmouseover="this.style.background='#f3f4f6'"
                onmouseout="this.style.background='white'">
                Logout
            </button>
        </form>

    </div>

</aside>