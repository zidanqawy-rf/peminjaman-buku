<section style="display: flex; flex-direction: column; gap: 16px;">
    <header>
        <h2 style="font-size: 16px; font-weight: 800; color: #dc2626; margin: 0;">
            {{ __('Hapus Akun') }}
        </h2>

        <p style="font-size: 13px; color: #64748b; margin-top: 4px;">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun, silakan unduh data atau informasi apa pun yang ingin Anda simpan.') }}
        </p>
    </header>

    {{-- Tombol Pemicu Modal --}}
    <button 
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        style="width: fit-content; padding: 10px 20px; border-radius: 10px; border: none; background: #dc2626; color: #fff; font-size: 13px; font-weight: 700; cursor: pointer; transition: background 0.2s;"
        onmouseover="this.style.background='#b91c1c'"
        onmouseout="this.style.background='#dc2626'">
        {{ __('Hapus Akun') }}
    </button>

    {{-- Modal Konfirmasi --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" style="padding: 24px;">
            @csrf
            @method('delete')

            <h2 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0;">
                {{ __('Apakah Anda yakin ingin menghapus akun?') }}
            </h2>

            <p style="font-size: 13.5px; color: #64748b; margin-top: 8px; line-height: 1.5;">
                {{ __('Setelah akun dihapus, semua data akan hilang selamanya. Silakan masukkan kata sandi Anda untuk mengonfirmasi penghapusan permanen.') }}
            </p>

            <div style="margin-top: 20px;">
                <label for="password" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748b; margin-bottom: 7px;">
                    {{ __('Kata Sandi Konfirmasi') }}
                </label>

                <input 
                    id="password"
                    name="password"
                    type="password"
                    placeholder="{{ __('Masukkan Kata Sandi') }}"
                    style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 10px 14px; font-size: 13.5px; background: #f8fafc; outline: none;"
                    onfocus="this.style.borderColor='#dc2626'; this.style.background='#fff';"
                    onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';"
                />

                @if($errors->userDeletion->get('password'))
                    <p style="color: #dc2626; font-size: 12px; margin-top: 4px;">{{ $errors->userDeletion->first('password') }}</p>
                @endif
            </div>

            <div style="margin-top: 24px; display: flex; justify-content: flex-end; gap: 12px;">
                {{-- Tombol Batal --}}
                <button type="button" x-on:click="$dispatch('close')"
                    style="padding: 10px 18px; border-radius: 10px; border: 1.5px solid #e2e8f0; background: #fff; color: #64748b; font-size: 13px; font-weight: 600; cursor: pointer;">
                    {{ __('Batal') }}
                </button>

                {{-- Tombol Hapus Final --}}
                <button type="submit"
                    style="padding: 10px 18px; border-radius: 10px; border: none; background: #dc2626; color: #fff; font-size: 13px; font-weight: 700; cursor: pointer;">
                    {{ __('Hapus Akun Sekarang') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>