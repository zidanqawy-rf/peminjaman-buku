<section>
    <header>
        <h2 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">
            {{ __('Informasi Profil') }}
        </h2>
        <p style="font-size: 13px; color: #64748b; margin-top: 4px; margin-bottom: 20px;">
            {{ __("Perbarui informasi profil akun dan alamat email Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" style="display: flex; flex-direction: column; gap: 16px;">
        @csrf
        @method('patch')

        {{-- Nama --}}
        <div>
            <label for="name" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #64748b; margin-bottom: 7px;">
                {{ __('Nama Lengkap') }}
            </label>
            <input id="name" name="name" type="text"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 10px 14px; font-size: 13.5px; color: #1e293b; background: #f8fafc; outline: none; box-sizing: border-box;"
                onfocus="this.style.borderColor='#3b82f6'; this.style.background='#fff';"
                onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
            @if($errors->get('name'))
                <p style="color: #dc2626; font-size: 12px; margin-top: 4px;">{{ $errors->first('name') }}</p>
            @endif
        </div>

        {{-- Email --}}
        <div>
            <label for="email" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #64748b; margin-bottom: 7px;">
                {{ __('Alamat Email') }}
            </label>
            <input id="email" name="email" type="email"
                value="{{ old('email', $user->email) }}" required autocomplete="username"
                style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 10px 14px; font-size: 13.5px; color: #1e293b; background: #f8fafc; outline: none; box-sizing: border-box;"
                onfocus="this.style.borderColor='#3b82f6'; this.style.background='#fff';"
                onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
            @if($errors->get('email'))
                <p style="color: #dc2626; font-size: 12px; margin-top: 4px;">{{ $errors->first('email') }}</p>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top: 8px;">
                    <p style="font-size: 13px; color: #1e293b;">
                        {{ __('Email Anda belum diverifikasi.') }}
                        <button form="send-verification" style="background: none; border: none; color: #3b82f6; text-decoration: underline; cursor: pointer; font-size: 13px; padding: 0;">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p style="margin-top: 8px; font-weight: 600; font-size: 12px; color: #15803d;">
                            {{ __('Link verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Divider Data Siswa --}}
        <div style="display: flex; align-items: center; gap: .75rem; margin: 4px 0;">
            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #94a3b8; white-space: nowrap;">Data Siswa</span>
            <div style="flex: 1; height: 1px; background: #e2e8f0;"></div>
        </div>

        {{-- NISN --}}
        <div>
            <label for="nisn" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #64748b; margin-bottom: 7px;">
                {{ __('NISN') }}
            </label>
            <input id="nisn" name="nisn" type="text"
                value="{{ old('nisn', $user->nisn) }}" required maxlength="10"
                placeholder="10 digit angka"
                style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 10px 14px; font-size: 13.5px; color: #1e293b; background: #f8fafc; outline: none; box-sizing: border-box;"
                onfocus="this.style.borderColor='#3b82f6'; this.style.background='#fff';"
                onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
            @if($errors->get('nisn'))
                <p style="color: #dc2626; font-size: 12px; margin-top: 4px;">{{ $errors->first('nisn') }}</p>
            @endif
        </div>

        {{-- Kelas & Jurusan --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <div>
                <label for="kelas" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #64748b; margin-bottom: 7px;">
                    {{ __('Kelas') }}
                </label>
                <input id="kelas" name="kelas" type="text"
                    value="{{ old('kelas', $user->kelas) }}" required
                    placeholder="Contoh: X, XI, XII"
                    style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 10px 14px; font-size: 13.5px; color: #1e293b; background: #f8fafc; outline: none; box-sizing: border-box;"
                    onfocus="this.style.borderColor='#3b82f6'; this.style.background='#fff';"
                    onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                @if($errors->get('kelas'))
                    <p style="color: #dc2626; font-size: 12px; margin-top: 4px;">{{ $errors->first('kelas') }}</p>
                @endif
            </div>

            <div>
                <label for="jurusan" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #64748b; margin-bottom: 7px;">
                    {{ __('Jurusan') }}
                </label>
                <input id="jurusan" name="jurusan" type="text"
                    value="{{ old('jurusan', $user->jurusan) }}" required
                    placeholder="Contoh: RPL, TKJ"
                    style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 10px 14px; font-size: 13.5px; color: #1e293b; background: #f8fafc; outline: none; box-sizing: border-box;"
                    onfocus="this.style.borderColor='#3b82f6'; this.style.background='#fff';"
                    onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                @if($errors->get('jurusan'))
                    <p style="color: #dc2626; font-size: 12px; margin-top: 4px;">{{ $errors->first('jurusan') }}</p>
                @endif
            </div>
        </div>

        {{-- Tombol Simpan --}}
        <div style="display: flex; align-items: center; gap: 12px; margin-top: 8px;">
            <button type="submit"
                style="padding: 10px 24px; border-radius: 10px; border: none; color: #fff; font-size: 13px; font-weight: 700; cursor: pointer; background: linear-gradient(135deg, #3b82f6, #2563eb); box-shadow: 0 2px 8px rgba(59, 130, 246, .3);"
                onmouseover="this.style.transform='translateY(-1px)'"
                onmouseout="this.style.transform='none'">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   style="font-size: 13px; color: #64748b; margin: 0;">
                    {{ __('Berhasil disimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>