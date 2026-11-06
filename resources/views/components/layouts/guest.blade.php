<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Masuk' }} - {{ config('app.name', 'StayHub') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>body { font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif; }</style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-background text-foreground antialiased">
    <x-ui.toast />

    <div class="flex min-h-screen">
        {{-- Left decorative panel --}}
        <div class="hidden lg:flex lg:w-1/2 relative bg-primary overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-primary via-primary/90 to-primary/70"></div>
            <div class="absolute inset-0 opacity-10" style="background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200&auto=format&fit=crop'); background-size: cover; background-position: center;"></div>
            <div class="relative z-10 flex flex-col justify-between p-12 text-primary-foreground">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-bold">
                    <x-ui.icon name="hotel" class="w-8 h-8" />
                    StayHub
                </a>
                <div>
                    <blockquote class="text-3xl font-semibold leading-snug mb-4">
                        "Pesan hotel terbaik dengan harga terbaik, kapan saja dan di mana saja."
                    </blockquote>
                    <p class="text-primary-foreground/70">Lebih dari 30 hotel pilihan di seluruh Indonesia.</p>
                </div>
                <p class="text-primary-foreground/50 text-sm">&copy; {{ date('Y') }} StayHub. All rights reserved.</p>
            </div>
        </div>

        {{-- Right auth panel --}}
        <div class="flex flex-1 items-center justify-center p-6 lg:p-12">
            <div class="w-full max-w-md">
                <div class="lg:hidden mb-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-bold text-primary">
                        <x-ui.icon name="hotel" class="w-7 h-7" />
                        StayHub
                    </a>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>

