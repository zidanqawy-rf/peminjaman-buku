{{-- resources/views/auth/register.blade.php --}}

<x-guest-layout>
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { background: #f1f5f9; font-family: 'Figtree', sans-serif; }

    .auth-wrap {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2.5rem 1rem;
        background: #f1f5f9;
    }
    .auth-card {
        width: 100%;
        max-width: 480px;
        background: white;
        border-radius: 1.25rem;
        box-shadow: 0 10px 40px rgba(0,0,0,.1);
        padding: 2.5rem;
    }
    .auth-logo {
        text-align: center;
        margin-bottom: .75rem;
    }
    .auth-logo .icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 3.5rem; height: 3.5rem;
        background: linear-gradient(135deg, #16a34a, #14532d);
        border-radius: 1rem;
        font-size: 1.6rem;
        margin-bottom: .75rem;
    }
    .auth-title {
        text-align: center;
        font-size: 1.75rem;
        font-weight: 800;
        color: #14532d;
        margin-bottom: .25rem;
    }
    .auth-sub {
        text-align: center;
        color: #64748b;
        font-size: .9rem;
        margin-bottom: 1.75rem;
    }
    .error-box {
        background: #fef2f2;
        border: 1px solid #fca5a5;
        color: #b91c1c;
        padding: .75rem 1rem;
        border-radius: .75rem;
        margin-bottom: 1.25rem;
        font-size: .85rem;
    }
    .form-group { margin-bottom: 1.1rem; }
    .form-label {
        display: block;
        font-size: .85rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: .45rem;
    }
    .form-input {
        width: 100%;
        border: 1.5px solid #d1d5db;
        border-radius: .75rem;
        padding: .75rem 1rem;
        font-size: .95rem;
        color: #111827;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        background: white;
    }
    .form-input:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22,163,74,.15);
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .85rem;
    }
    .divider {
        display: flex;
        align-items: center;
        gap: .75rem;
        margin: 1.25rem 0 1.1rem;
        color: #94a3b8;
        font-size: .8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .05em;
    }
    .divider::before, .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }
    .btn-submit {
        width: 100%;
        padding: .85rem;
        background: linear-gradient(135deg, #16a34a, #14532d);
        color: white;
        font-size: 1rem;
        font-weight: 700;
        border: none;
        border-radius: .75rem;
        cursor: pointer;
        margin-top: .5rem;
        box-shadow: 0 4px 14px rgba(22,163,74,.35);
        transition: opacity .2s, transform .2s;
    }
    .btn-submit:hover { opacity: .92; transform: translateY(-1px); }
    .auth-footer {
        text-align: center;
        margin-top: 1.25rem;
        font-size: .875rem;
        color: #64748b;
    }
    .auth-footer a { color: #16a34a; font-weight: 700; text-decoration: none; }
    .auth-footer a:hover { text-decoration: underline; }
</style>

<div class="auth-wrap">
    <div class="auth-card">

        <div class="auth-logo">
            <div class="icon">📖</div>
        </div>
        <h1 class="auth-title">Daftar Akun</h1>
        <p class="auth-sub">Buat akun siswa perpustakaan</p>

        @if ($errors->any())
            <div class="error-box">
                <ul style="list-style: disc; padding-left: 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- ── Data Akun ── --}}
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="form-input" placeholder="Masukkan nama lengkap">
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="form-input" placeholder="contoh@email.com">
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" required
                    class="form-input" placeholder="Minimal 8 karakter">
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                    class="form-input" placeholder="Ulangi password">
            </div>

            {{-- ── Data Siswa ── --}}
            <div class="divider">Data Siswa</div>

            <div class="form-group">
                <label class="form-label">NISN</label>
                <input type="text" name="nisn" value="{{ old('nisn') }}" required
                    class="form-input" placeholder="Nomor Induk Siswa Nasional"
                    maxlength="10" pattern="\d{10}"
                    title="NISN harus terdiri dari 10 digit angka">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Kelas</label>
                    <input type="text" name="kelas" value="{{ old('kelas') }}" required
                        class="form-input" placeholder="Contoh: X, XI, XII">
                </div>

                <div class="form-group">
                    <label class="form-label">Jurusan</label>
                    <input type="text" name="jurusan" value="{{ old('jurusan') }}" required
                        class="form-input" placeholder="Contoh: RPL, TKJ">
                </div>
            </div>

            <button type="submit" class="btn-submit">✨ Daftar Sekarang</button>
        </form>

        <p class="auth-footer">
            Sudah punya akun?
            <a href="{{ route('login') }}">Masuk di sini</a>
        </p>
    </div>
</div>
</x-guest-layout>