<x-layouts.guest :title="'Masuk'">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-foreground mb-1">Selamat datang kembali</h1>
        <p class="text-muted-foreground mb-6">Masuk ke akun StayHub Anda</p>

        @if (session('status'))
            <x-ui.alert variant="success" class="mb-4">{{ session('status') }}</x-ui.alert>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div class="space-y-2">
                <x-ui.label for="email">Email</x-ui.label>
                <x-ui.input
                    id="email"
                    name="email"
                    type="email"
                    :value="old('email')"
                    placeholder="nama@email.com"
                    autofocus
                    autocomplete="email"
                />
                @error('email')
                    <p class="text-sm text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <x-ui.label for="password">Kata Sandi</x-ui.label>
                    {{-- <a href="#" class="text-sm text-primary hover:underline">Lupa kata sandi?</a> --}}
                </div>
                <x-ui.input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="••••••••"
                    autocomplete="current-password"
                />
                @error('password')
                    <p class="text-sm text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-2">
                <x-ui.checkbox id="remember" name="remember" />
                <x-ui.label for="remember" class="font-normal cursor-pointer">Ingat saya</x-ui.label>
            </div>

            <x-ui.button type="submit" class="w-full">
                Masuk
            </x-ui.button>
        </form>

        <p class="mt-6 text-center text-sm text-muted-foreground">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-primary font-medium hover:underline">Daftar sekarang</a>
        </p>
    </div>
</x-layouts.guest>

