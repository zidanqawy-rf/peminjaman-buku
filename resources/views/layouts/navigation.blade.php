{{-- resources/views/layouts/navigation.blade.php --}}

{{-- ═══════════════════════════════════════════════
     DESKTOP SIDEBAR  (hidden on mobile via CSS)
════════════════════════════════════════════════ --}}
<aside id="desktop-sidebar">

    {{-- Logo --}}
    <div class="sidebar-logo">
        <h1>📖 Perpustakaan</h1>
        <p>Sistem Peminjaman Buku</p>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">

        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </span>
            Dashboard
        </a>

        <a href="{{ route('peminjaman.tambah') }}"
           class="nav-link {{ request()->routeIs('peminjaman.tambah') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
            </span>
            Tambah Peminjaman
        </a>

        <a href="{{ route('peminjaman.riwayat') }}"
           class="nav-link {{ request()->routeIs('peminjaman.riwayat') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </span>
            Riwayat Peminjaman
        </a>

        <p class="nav-section-label">Akun Saya</p>

        <a href="{{ route('profile.edit') }}"
           class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </span>
            Profile Pengguna
        </a>

    </nav>

    {{-- User + Logout --}}
    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="user-info">
                <p class="user-name">{{ Auth::user()->name }}</p>
                <p class="user-role">{{ ucfirst(Auth::user()->role) }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>


{{-- ═══════════════════════════════════════════════
     MOBILE TOP BAR  (hidden on desktop via CSS)
════════════════════════════════════════════════ --}}
<header id="mobile-topbar">
    <div class="topbar-left">
        <span class="topbar-logo">📖</span>
        <div>
            <p class="topbar-title">Perpustakaan</p>
            <p class="topbar-sub">Sistem Peminjaman Buku</p>
        </div>
    </div>
    <div class="topbar-avatar">
        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
    </div>
</header>


{{-- ═══════════════════════════════════════════════
     MOBILE BOTTOM NAV  (hidden on desktop via CSS)
════════════════════════════════════════════════ --}}
<nav id="mobile-bottomnav">

    <a href="{{ route('dashboard') }}"
       class="tab-item {{ request()->routeIs('dashboard') ? 'tab-active' : '' }}">
        <span class="tab-icon">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </span>
        <span class="tab-label">Beranda</span>
    </a>

    <a href="{{ route('peminjaman.tambah') }}"
       class="tab-item {{ request()->routeIs('peminjaman.tambah') ? 'tab-active' : '' }}">
        {{-- FAB-style center button --}}
        <span class="tab-fab">
            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
        </span>
        <span class="tab-label">Pinjam</span>
    </a>

    <a href="{{ route('peminjaman.riwayat') }}"
       class="tab-item {{ request()->routeIs('peminjaman.riwayat') ? 'tab-active' : '' }}">
        <span class="tab-icon">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </span>
        <span class="tab-label">Riwayat</span>
    </a>

    <a href="{{ route('profile.edit') }}"
       class="tab-item {{ request()->routeIs('profile.*') ? 'tab-active' : '' }}">
        <span class="tab-icon">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </span>
        <span class="tab-label">Profil</span>
    </a>

    <form method="POST" action="{{ route('logout') }}" style="display:contents">
        @csrf
        <button type="submit" class="tab-item tab-btn">
            <span class="tab-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </span>
            <span class="tab-label">Keluar</span>
        </button>
    </form>

</nav>


<style>
/* ═══ CSS VARIABLES ═══ */
:root {
    --green-dark:   #064e3b;
    --green-mid:    #059669;
    --green-light:  #10b981;
    --green-bright: #34d399;
    --nav-width:    260px;
}

/* ═══════════════════════════════════════════════
   DESKTOP SIDEBAR
════════════════════════════════════════════════ */
#desktop-sidebar {
    position: fixed;
    top: 0; left: 0;
    height: 100vh;
    width: var(--nav-width);
    background: var(--green-dark);
    display: flex;
    flex-direction: column;
    z-index: 50;
    box-shadow: 4px 0 24px rgba(0,0,0,.15);
}

.sidebar-logo {
    padding: 24px;
    border-bottom: 1px solid rgba(255,255,255,.06);
}
.sidebar-logo h1 {
    color: #fff;
    font-weight: 700;
    font-size: 17px;
    letter-spacing: .3px;
    margin: 0;
}
.sidebar-logo p {
    color: rgba(255,255,255,.35);
    font-size: 11.5px;
    margin-top: 3px;
    margin-bottom: 0;
}

.sidebar-nav {
    flex: 1;
    padding: 16px 12px;
    display: flex;
    flex-direction: column;
    gap: 2px;
    overflow-y: auto;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 12px;
    font-size: 13.5px;
    font-weight: 500;
    text-decoration: none;
    color: rgba(255,255,255,.5);
    transition: all .15s;
}
.nav-link:hover {
    background: rgba(255,255,255,.06);
    color: rgba(255,255,255,.85);
}
.nav-link.active {
    color: #fff;
    background: linear-gradient(135deg, var(--green-light), var(--green-mid));
    box-shadow: 0 4px 14px rgba(16,185,129,.35);
}

.nav-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    background: rgba(255,255,255,.06);
}
.nav-link.active .nav-icon {
    background: rgba(255,255,255,.2);
}
.nav-icon svg { width: 16px; height: 16px; }

.nav-section-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: rgba(255,255,255,.25);
    padding: 14px 14px 6px;
    margin: 0;
}

.sidebar-footer {
    padding: 14px 12px;
    border-top: 1px solid rgba(255,255,255,.06);
}

.user-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px;
    border-radius: 12px;
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.06);
    margin-bottom: 10px;
}
.user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--green-light), var(--green-bright));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
}
.user-info { min-width: 0; }
.user-name {
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.user-role {
    color: rgba(255,255,255,.35);
    font-size: 11px;
    margin: 0;
}

.logout-btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
    background: rgba(255,255,255,.07);
    color: rgba(255,255,255,.6);
    transition: all .15s;
}
.logout-btn:hover {
    background: rgba(255,255,255,.12);
    color: rgba(255,255,255,.9);
}
.logout-btn svg { width: 15px; height: 15px; }


/* ═══════════════════════════════════════════════
   MOBILE TOP BAR
════════════════════════════════════════════════ */
#mobile-topbar {
    display: none; /* shown via media query */
    position: fixed;
    top: 0; left: 0; right: 0;
    height: 60px;
    background: var(--green-dark);
    align-items: center;
    justify-content: space-between;
    padding: 0 16px;
    z-index: 50;
    box-shadow: 0 2px 12px rgba(0,0,0,.15);
}
.topbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
}
.topbar-logo { font-size: 22px; }
.topbar-title {
    color: #fff;
    font-size: 15px;
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
}
.topbar-sub {
    color: rgba(255,255,255,.4);
    font-size: 10.5px;
    margin: 0;
}
.topbar-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--green-light), var(--green-bright));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
}


/* ═══════════════════════════════════════════════
   MOBILE BOTTOM NAV
════════════════════════════════════════════════ */
#mobile-bottomnav {
    display: none; /* shown via media query */
    position: fixed;
    bottom: 0; left: 0; right: 0;
    height: 64px;
    background: #fff;
    border-top: 1px solid #e2e8f0;
    align-items: center;
    justify-content: space-around;
    z-index: 50;
    box-shadow: 0 -4px 20px rgba(0,0,0,.08);
    padding: 0 4px;
}

/* shared for <a> and <button> tab items */
.tab-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 3px;
    flex: 1;
    padding: 8px 4px;
    text-decoration: none;
    color: #94a3b8;
    transition: color .15s;
    position: relative;
    /* reset button defaults */
    background: none;
    border: none;
    cursor: pointer;
    font-family: inherit;
}
.tab-item:hover { color: var(--green-mid); }
.tab-item.tab-active { color: var(--green-mid); }
.tab-item.tab-active .tab-icon::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: var(--green-mid);
}

.tab-icon {
    position: relative;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.tab-icon svg {
    width: 22px;
    height: 22px;
    transition: transform .15s;
}
.tab-item:active .tab-icon svg { transform: scale(.88); }

.tab-label {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: .2px;
}

/* Centre FAB button for "Pinjam" */
.tab-fab {
    width: 48px;
    height: 48px;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--green-light), var(--green-mid));
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 14px rgba(16,185,129,.4);
    margin-top: -20px;
    transition: transform .15s, box-shadow .15s;
}
.tab-fab svg { width: 22px; height: 22px; color: #fff; }
.tab-item:hover .tab-fab {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16,185,129,.5);
}
.tab-item.tab-active .tab-fab {
    background: linear-gradient(135deg, var(--green-mid), #047857);
}
/* When Pinjam is active, label colour */
.tab-item.tab-active .tab-label { color: var(--green-mid); }

/* Active indicator dot on non-FAB items */
.tab-item.tab-active:not(:has(.tab-fab)) .tab-icon {
    color: var(--green-mid);
}
.tab-item.tab-active:not(:has(.tab-fab))::after {
    content: '';
    position: absolute;
    bottom: 6px;
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: var(--green-mid);
}


/* ═══════════════════════════════════════════════
   RESPONSIVE BREAKPOINTS
════════════════════════════════════════════════ */
@media (max-width: 767px) {
    #desktop-sidebar  { display: none !important; }
    #mobile-topbar    { display: flex !important; }
    #mobile-bottomnav { display: flex !important; }
}

@media (min-width: 768px) {
    #desktop-sidebar  { display: flex !important; }
    #mobile-topbar    { display: none !important; }
    #mobile-bottomnav { display: none !important; }
}
</style>