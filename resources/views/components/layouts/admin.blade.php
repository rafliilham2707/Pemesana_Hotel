<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('theme') === 'dark', sidebarOpen: false }" :class="{ 'dark': darkMode }" x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin' }} - StayHub Panel Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>body { font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif; }</style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-background text-foreground antialiased selection:bg-primary/20 selection:text-primary">
    <x-ui.toast />

    <div class="flex min-h-screen">
        {{-- Sidebar Desktop & Mobile --}}
        <aside
            class="fixed inset-y-0 left-0 z-50 w-64 border-r border-border bg-card transition-transform duration-200 lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        >
            <div class="flex h-16 items-center justify-between px-6 border-b border-border">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-bold text-lg text-primary">
                    <x-ui.icon name="hotel" class="w-6 h-6" />
                    <span>StayHub Admin</span>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-muted-foreground hover:text-foreground">
                    <x-ui.icon name="x" class="w-5 h-5" />
                </button>
            </div>

            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-muted hover:text-foreground' }}">
                    <x-ui.icon name="layout-dashboard" class="w-4 h-4" />
                    Dashboard
                </a>
                <a href="{{ route('admin.hotels.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.hotels.*') ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-muted hover:text-foreground' }}">
                    <x-ui.icon name="hotel" class="w-4 h-4" />
                    Kelola Hotel
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.bookings.*') ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-muted hover:text-foreground' }}">
                    <x-ui.icon name="calendar-check" class="w-4 h-4" />
                    Pesanan Hotel
                </a>
                <a href="{{ route('admin.vouchers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.vouchers.*') ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-muted hover:text-foreground' }}">
                    <x-ui.icon name="tag" class="w-4 h-4" />
                    Kupon & Voucher
                </a>
                <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.reviews.*') ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-muted hover:text-foreground' }}">
                    <x-ui.icon name="star" class="w-4 h-4" />
                    Ulasan Tamu
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-muted hover:text-foreground' }}">
                    <x-ui.icon name="users" class="w-4 h-4" />
                    Pengguna
                </a>

                <x-ui.separator class="my-4" />

                <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium text-muted-foreground hover:bg-muted hover:text-foreground transition-colors">
                    <x-ui.icon name="arrow-left" class="w-4 h-4" />
                    Kembali ke Web
                </a>
            </nav>
        </aside>

        {{-- Backdrop for mobile --}}
        <div
            x-show="sidebarOpen"
            @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black/50 lg:hidden backdrop-blur-xs"
            style="display: none;"
        ></div>

        {{-- Main Area --}}
        <div class="flex-1 flex flex-col lg:pl-64">
            {{-- Top Header --}}
            <header class="sticky top-0 z-30 h-16 border-b border-border bg-background/80 backdrop-blur-md px-6 flex items-center justify-between">
                <button @click="sidebarOpen = true" class="lg:hidden text-muted-foreground hover:text-foreground">
                    <x-ui.icon name="menu" class="w-6 h-6" />
                </button>

                <div class="hidden lg:block text-xs text-muted-foreground">
                    Panel Manajemen Sistem StayHub
                </div>

                <div class="flex items-center gap-3 ml-auto">
                    {{-- Dark mode --}}
                    <button @click="darkMode = !darkMode" class="w-9 h-9 rounded-md border border-border flex items-center justify-center text-muted-foreground hover:text-foreground hover:bg-muted transition-colors">
                        <x-ui.icon name="sun" class="w-4 h-4 block dark:hidden" />
                        <x-ui.icon name="moon" class="w-4 h-4 hidden dark:block" />
                    </button>

                    <div class="flex items-center gap-2 pl-2 border-l border-border">
                        <x-ui.avatar :name="auth()->user()->name" size="sm" />
                        <span class="text-xs font-medium hidden sm:inline">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>

