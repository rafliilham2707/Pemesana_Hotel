<x-layouts.guest :title="'Daftar'">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-foreground mb-1">Buat akun baru</h1>
        <p class="text-muted-foreground mb-6">Daftar dan nikmati kemudahan booking hotel</p>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div class="space-y-2">
                <x-ui.label for="name">Nama Lengkap</x-ui.label>
                <x-ui.input
                    id="name"
                    name="name"
                    type="text"
                    :value="old('name')"
                    placeholder="Nama lengkap Anda"
                    autofocus
                    autocomplete="name"
                />
                @error('name')
                    <p class="text-sm text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <x-ui.label for="email">Email</x-ui.label>
                <x-ui.input
                    id="email"
                    name="email"
                    type="email"
                    :value="old('email')"
                    placeholder="nama@email.com"
                    autocomplete="email"
                />
                @error('email')
                    <p class="text-sm text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <x-ui.label for="phone">Nomor Telepon <span class="text-muted-foreground font-normal">(opsional)</span></x-ui.label>
                <x-ui.input
                    id="phone"
                    name="phone"
                    type="tel"
                    :value="old('phone')"
                    placeholder="08xxxxxxxxxx"
                    autocomplete="tel"
                />
                @error('phone')
                    <p class="text-sm text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <x-ui.label for="password">Kata Sandi</x-ui.label>
                <x-ui.input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Minimal 8 karakter"
                    autocomplete="new-password"
                />
                @error('password')
                    <p class="text-sm text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <x-ui.label for="password_confirmation">Konfirmasi Kata Sandi</x-ui.label>
                <x-ui.input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    placeholder="Ulangi kata sandi"
                    autocomplete="new-password"
                />
            </div>

            <x-ui.button type="submit" class="w-full">
                Buat Akun
            </x-ui.button>
        </form>

        <p class="mt-6 text-center text-sm text-muted-foreground">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-primary font-medium hover:underline">Masuk sekarang</a>
        </p>
    </div>
</x-layouts.guest>

