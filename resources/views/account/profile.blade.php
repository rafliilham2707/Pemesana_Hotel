<x-layouts.app :title="'Profil Saya'">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">Profil Pengguna</h1>
            <p class="text-sm text-muted-foreground">Kelola informasi data pribadi dan keamanan akun StayHub Anda</p>
        </div>

        @if(session('status'))
            <x-ui.alert variant="success" class="mb-6">{{ session('status') }}</x-ui.alert>
        @endif
        @if($errors->any())
            <x-ui.alert variant="destructive" class="mb-6">
                Mohon periksa kembali formulir di bawah ini.
            </x-ui.alert>
        @endif

        <div class="space-y-6">
            {{-- Edit Profile Form --}}
            <x-ui.card>
                <x-ui.card.header>
                    <x-ui.card.title class="text-base flex items-center gap-2">
                        <x-ui.icon name="user" class="w-4 h-4 text-primary" />
                        Informasi Pribadi
                    </x-ui.card.title>
                    <x-ui.card.description>Perbarui nama, email, dan nomor telepon akun Anda</x-ui.card.description>
                </x-ui.card.header>
                <x-ui.card.content>
                    <form action="{{ route('account.profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="space-y-2">
                            <x-ui.label for="name">Nama Lengkap</x-ui.label>
                            <x-ui.input id="name" name="name" type="text" :value="old('name', $user->name)" required />
                            @error('name')
                                <p class="text-xs text-destructive">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <x-ui.label for="email">Alamat Email</x-ui.label>
                            <x-ui.input id="email" name="email" type="email" :value="old('email', $user->email)" required />
                            @error('email')
                                <p class="text-xs text-destructive">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <x-ui.label for="phone">Nomor Telepon / WhatsApp</x-ui.label>
                            <x-ui.input id="phone" name="phone" type="tel" :value="old('phone', $user->phone)" placeholder="08xxxxxxxxxx" />
                            @error('phone')
                                <p class="text-xs text-destructive">{{ $message }}</p>
                            @enderror
                        </div>

                        <x-ui.button type="submit" size="sm">
                            Simpan Perubahan
                        </x-ui.button>
                    </form>
                </x-ui.card.content>
            </x-ui.card>

            {{-- Update Password Form --}}
            <x-ui.card>
                <x-ui.card.header>
                    <x-ui.card.title class="text-base flex items-center gap-2">
                        <x-ui.icon name="lock" class="w-4 h-4 text-primary" />
                        Ganti Kata Sandi
                    </x-ui.card.title>
                    <x-ui.card.description>Pastikan akun Anda menggunakan kata sandi yang kuat dan aman</x-ui.card.description>
                </x-ui.card.header>
                <x-ui.card.content>
                    <form action="{{ route('account.password.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="space-y-2">
                            <x-ui.label for="current_password">Kata Sandi Saat Ini</x-ui.label>
                            <x-ui.input id="current_password" name="current_password" type="password" required />
                            @error('current_password')
                                <p class="text-xs text-destructive">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <x-ui.label for="password">Kata Sandi Baru</x-ui.label>
                            <x-ui.input id="password" name="password" type="password" placeholder="Minimal 8 karakter" required />
                            @error('password')
                                <p class="text-xs text-destructive">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <x-ui.label for="password_confirmation">Konfirmasi Kata Sandi Baru</x-ui.label>
                            <x-ui.input id="password_confirmation" name="password_confirmation" type="password" required />
                        </div>

                        <x-ui.button type="submit" size="sm" variant="secondary">
                            Perbarui Kata Sandi
                        </x-ui.button>
                    </form>
                </x-ui.card.content>
            </x-ui.card>
        </div>
    </div>
</x-layouts.app>

