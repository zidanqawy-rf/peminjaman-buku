<section>
    <header>
        <h2 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">
            {{ __('Perbarui Kata Sandi') }}
        </h2>

        <p style="font-size: 13px; color: #64748b; margin-top: 4px; margin-bottom: 20px;">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" style="display: flex; flex-direction: column; gap: 16px;">
        @csrf
        @method('put')

        {{-- Password Saat Ini --}}
        <div>
            <label for="update_password_current_password" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #64748b; margin-bottom: 7px;">
                {{ __('Kata Sandi Saat Ini') }}
            </label>
            <input id="update_password_current_password" name="current_password" type="password" 
                autocomplete="current-password"
                style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 10px 14px; font-size: 13.5px; color: #1e293b; background: #f8fafc; outline: none; box-sizing: border-box;"
                onfocus="this.style.borderColor='#3b82f6'; this.style.background='#fff';"
                onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
            @if($errors->updatePassword->get('current_password'))
                <p style="color: #dc2626; font-size: 12px; margin-top: 4px;">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        {{-- Password Baru --}}
        <div>
            <label for="update_password_password" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #64748b; margin-bottom: 7px;">
                {{ __('Kata Sandi Baru') }}
            </label>
            <input id="update_password_password" name="password" type="password" 
                autocomplete="new-password"
                style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 10px 14px; font-size: 13.5px; color: #1e293b; background: #f8fafc; outline: none; box-sizing: border-box;"
                onfocus="this.style.borderColor='#3b82f6'; this.style.background='#fff';"
                onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
            @if($errors->updatePassword->get('password'))
                <p style="color: #dc2626; font-size: 12px; margin-top: 4px;">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <label for="update_password_password_confirmation" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #64748b; margin-bottom: 7px;">
                {{ __('Konfirmasi Kata Sandi') }}
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                autocomplete="new-password"
                style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 10px 14px; font-size: 13.5px; color: #1e293b; background: #f8fafc; outline: none; box-sizing: border-box;"
                onfocus="this.style.borderColor='#3b82f6'; this.style.background='#fff';"
                onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
            @if($errors->updatePassword->get('password_confirmation'))
                <p style="color: #dc2626; font-size: 12px; margin-top: 4px;">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        {{-- Tombol Save --}}
        <div style="display: flex; align-items: center; gap: 12px; margin-top: 8px;">
            <button type="submit" 
                style="padding: 10px 24px; border-radius: 10px; border: none; color: #fff; font-size: 13px; font-weight: 700; cursor: pointer; background: linear-gradient(135deg, #3b82f6, #2563eb); box-shadow: 0 2px 8px rgba(59, 130, 246, .3);"
                onmouseover="this.style.transform='translateY(-1px)'" 
                onmouseout="this.style.transform='none'">
                {{ __('Perbarui Sandi') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   style="font-size: 13px; color: #64748b; margin: 0;">
                    {{ __('Berhasil diperbarui.') }}
                </p>
            @endif
        </div>
    </form>
</section>