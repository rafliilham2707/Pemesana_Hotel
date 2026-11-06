<nav x-data="{ mobileOpen: false }" class="sticky top-0 z-50 w-full border-b border-border bg-background/80 backdrop-blur-md supports-[backdrop-filter]:bg-background/60">
    <div class="container mx-auto px-4">
        <div class="flex h-16 items-center justify-between">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-xl text-primary shrink-0">
                <x-ui.icon name="hotel" class="w-6 h-6" />
                <span>StayHub</span>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium rounded-md text-muted-foreground hover:text-foreground hover:bg-muted transition-colors {{ request()->routeIs('home') ? 'text-foreground bg-muted' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('search') }}" class="px-3 py-2 text-sm font-medium rounded-md text-muted-foreground hover:text-foreground hover:bg-muted transition-colors {{ request()->routeIs('search') ? 'text-foreground bg-muted' : '' }}">
                    Cari Hotel
                </a>
            </div>

            {{-- Desktop Right side --}}
            <div class="hidden md:flex items-center gap-2">
                {{-- Dark mode toggle --}}
                <button @click="darkMode = !darkMode" class="inline-flex items-center justify-center w-9 h-9 rounded-md border border-border bg-background text-muted-foreground hover:text-foreground hover:bg-muted transition-colors" :title="darkMode ? 'Mode terang' : 'Mode gelap'">
                    <x-ui.icon name="sun" class="w-4 h-4 block dark:hidden" />
                    <x-ui.icon name="moon" class="w-4 h-4 hidden dark:block" />
                </button>

                @auth
                    {{-- User dropdown --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-muted transition-colors text-sm font-medium">
                            <x-ui.avatar :name="auth()->user()->name" size="sm" />
                            <span class="max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                            <x-ui.icon name="chevron-down" class="w-4 h-4 text-muted-foreground" />
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-1 w-52 origin-top-right rounded-lg border border-border bg-popover shadow-lg p-1 z-50" style="display: none;">
                            <div class="px-2 py-1.5 mb-1">
                                <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-muted-foreground truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <x-ui.separator class="my-1" />
                            <a href="{{ route('account.bookings') }}" class="flex items-center gap-2 px-2 py-1.5 text-sm rounded-md hover:bg-muted transition-colors">
                                <x-ui.icon name="calendar" class="w-4 h-4 text-muted-foreground" />
                                Pesanan Saya
                            </a>
                            <a href="{{ route('account.wishlist') }}" class="flex items-center gap-2 px-2 py-1.5 text-sm rounded-md hover:bg-muted transition-colors">
                                <x-ui.icon name="heart" class="w-4 h-4 text-muted-foreground" />
                                Wishlist
                            </a>
                            <a href="{{ route('account.profile') }}" class="flex items-center gap-2 px-2 py-1.5 text-sm rounded-md hover:bg-muted transition-colors">
                                <x-ui.icon name="user" class="w-4 h-4 text-muted-foreground" />
                                Profil Saya
                            </a>
                            @if(auth()->user()->isAdmin())
                                <x-ui.separator class="my-1" />
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-2 py-1.5 text-sm rounded-md hover:bg-muted transition-colors text-primary">
                                    <x-ui.icon name="layout-dashboard" class="w-4 h-4" />
                                    Panel Admin
                                </a>
                            @endif
                            <x-ui.separator class="my-1" />
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-2 px-2 py-1.5 text-sm rounded-md hover:bg-muted transition-colors text-destructive">
                                    <x-ui.icon name="log-out" class="w-4 h-4" />
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}">
                        <x-ui.button variant="outline" size="sm">Masuk</x-ui.button>
                    </a>
                    <a href="{{ route('register') }}">
                        <x-ui.button size="sm">Daftar</x-ui.button>
                    </a>
                @endauth
            </div>

            {{-- Mobile menu button --}}
            <button @click="mobileOpen = !mobileOpen" class="md:hidden inline-flex items-center justify-center w-9 h-9 rounded-md border border-border text-muted-foreground hover:text-foreground hover:bg-muted transition-colors">
                <x-ui.icon name="menu" class="w-5 h-5" x-show="!mobileOpen" />
                <x-ui.icon name="x" class="w-5 h-5" x-show="mobileOpen" style="display: none;" />
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden border-t border-border bg-background" style="display: none;">
        <div class="container mx-auto px-4 py-4 space-y-1">
            <a href="{{ route('home') }}" class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-md hover:bg-muted transition-colors">
                <x-ui.icon name="home" class="w-4 h-4" /> Beranda
            </a>
            <a href="{{ route('search') }}" class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-md hover:bg-muted transition-colors">
                <x-ui.icon name="search" class="w-4 h-4" /> Cari Hotel
            </a>

            @auth
                <x-ui.separator class="my-2" />
                <a href="{{ route('account.bookings') }}" class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-md hover:bg-muted transition-colors">
                    <x-ui.icon name="calendar" class="w-4 h-4" /> Pesanan Saya
                </a>
                <a href="{{ route('account.wishlist') }}" class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-md hover:bg-muted transition-colors">
                    <x-ui.icon name="heart" class="w-4 h-4" /> Wishlist
                </a>
                <a href="{{ route('account.profile') }}" class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-md hover:bg-muted transition-colors">
                    <x-ui.icon name="user" class="w-4 h-4" /> Profil Saya
                </a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-md hover:bg-muted transition-colors text-primary">
                        <x-ui.icon name="layout-dashboard" class="w-4 h-4" /> Panel Admin
                    </a>
                @endif
                <x-ui.separator class="my-2" />
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-2 px-3 py-2 text-sm font-medium rounded-md hover:bg-muted transition-colors text-destructive">
                        <x-ui.icon name="log-out" class="w-4 h-4" /> Keluar
                    </button>
                </form>
            @else
                <x-ui.separator class="my-2" />
                <div class="flex gap-2 px-3 py-2">
                    <a href="{{ route('login') }}" class="flex-1">
                        <x-ui.button variant="outline" class="w-full">Masuk</x-ui.button>
                    </a>
                    <a href="{{ route('register') }}" class="flex-1">
                        <x-ui.button class="w-full">Daftar</x-ui.button>
                    </a>
                </div>
            @endauth

            <div class="px-3 py-2 flex items-center gap-2">
                <button @click="darkMode = !darkMode" class="text-sm text-muted-foreground flex items-center gap-1.5 hover:text-foreground transition-colors">
                    <x-ui.icon name="sun" class="w-4 h-4 block dark:hidden" />
                    <x-ui.icon name="moon" class="w-4 h-4 hidden dark:block" />
                    <span x-text="darkMode ? 'Mode Terang' : 'Mode Gelap'">Mode Gelap</span>
                </button>
            </div>
        </div>
    </div>
</nav>

