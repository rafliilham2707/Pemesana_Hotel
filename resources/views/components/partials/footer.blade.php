<footer class="border-t border-border bg-muted/40 mt-auto">
    <div class="container mx-auto px-4 py-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            {{-- Brand --}}
            <div class="md:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-xl text-primary mb-3">
                    <x-ui.icon name="hotel" class="w-6 h-6" />
                    StayHub
                </a>
                <p class="text-sm text-muted-foreground leading-relaxed">
                    Platform pemesanan hotel terpercaya di Indonesia. Temukan penginapan terbaik dengan harga terbaik.
                </p>
            </div>

            {{-- Links --}}
            <div>
                <h4 class="font-semibold text-sm mb-3">Destinasi Populer</h4>
                <ul class="space-y-2 text-sm text-muted-foreground">
                    <li><a href="{{ route('search', ['q' => 'Bali']) }}" class="hover:text-foreground transition-colors">Hotel di Bali</a></li>
                    <li><a href="{{ route('search', ['q' => 'Jakarta']) }}" class="hover:text-foreground transition-colors">Hotel di Jakarta</a></li>
                    <li><a href="{{ route('search', ['q' => 'Bandung']) }}" class="hover:text-foreground transition-colors">Hotel di Bandung</a></li>
                    <li><a href="{{ route('search', ['q' => 'Yogyakarta']) }}" class="hover:text-foreground transition-colors">Hotel di Yogyakarta</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-sm mb-3">Akun</h4>
                <ul class="space-y-2 text-sm text-muted-foreground">
                    @auth
                        <li><a href="{{ route('account.bookings') }}" class="hover:text-foreground transition-colors">Pesanan Saya</a></li>
                        <li><a href="{{ route('account.wishlist') }}" class="hover:text-foreground transition-colors">Wishlist</a></li>
                        <li><a href="{{ route('account.profile') }}" class="hover:text-foreground transition-colors">Profil Saya</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="hover:text-foreground transition-colors">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-foreground transition-colors">Daftar</a></li>
                    @endauth
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-sm mb-3">Hubungi Kami</h4>
                <ul class="space-y-2 text-sm text-muted-foreground">
                    <li class="flex items-center gap-2">
                        <x-ui.icon name="mail" class="w-4 h-4 shrink-0" />
                        support@stayhub.id
                    </li>
                    <li class="flex items-center gap-2">
                        <x-ui.icon name="phone" class="w-4 h-4 shrink-0" />
                        0800-1234-5678
                    </li>
                </ul>
            </div>
        </div>

        <x-ui.separator class="my-6" />

        <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-muted-foreground">
            <p>&copy; {{ date('Y') }} StayHub. Semua hak dilindungi.</p>
            <p>Dibuat dengan ❤️ di Indonesia</p>
        </div>
    </div>
</footer>

