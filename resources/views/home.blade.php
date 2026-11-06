<x-layouts.app :title="'Beranda'">
    {{-- ===================== HERO SECTION ===================== --}}
    <section class="relative min-h-[560px] flex items-center justify-center overflow-hidden bg-gradient-to-br from-primary/90 via-primary to-primary/80">
        {{-- Background pattern --}}
        <div class="absolute inset-0 opacity-10" style="background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1600&auto=format&fit=crop'); background-size: cover; background-position: center;"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-background/20 to-transparent"></div>

        <div class="relative z-10 container mx-auto px-4 py-16 text-center">
            <x-ui.badge variant="secondary" class="mb-4 text-sm px-4 py-1.5">
                <x-ui.icon name="sparkles" class="w-3.5 h-3.5 mr-1.5" />
                Lebih dari 30 hotel pilihan terbaik
            </x-ui.badge>

            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-primary-foreground mb-4 leading-tight">
                Temukan Hotel <br class="hidden sm:block"> Impian Anda
            </h1>
            <p class="text-primary-foreground/80 text-lg mb-10 max-w-xl mx-auto">
                Pesan hotel terbaik di seluruh Indonesia dengan harga terbaik, mudah dan terpercaya.
            </p>

            {{-- Search Bar Card --}}
            <div class="bg-background rounded-2xl shadow-2xl p-4 md:p-6 max-w-5xl mx-auto">
                <form action="{{ route('search') }}" method="GET" x-data="heroSearch()" class="grid grid-cols-1 md:grid-cols-5 gap-3">
                    {{-- Destinasi --}}
                    <div class="md:col-span-2 space-y-1">
                        <label class="block text-xs font-semibold text-muted-foreground uppercase tracking-wide text-left">Destinasi / Hotel</label>
                        <div class="relative">
                            <x-ui.icon name="map-pin" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground pointer-events-none" />
                            <input
                                name="q"
                                type="text"
                                :value="destination"
                                x-model="destination"
                                placeholder="Cari kota atau nama hotel..."
                                class="w-full pl-9 pr-3 h-11 rounded-lg border border-input bg-background text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                                autocomplete="off"
                            >
                        </div>
                    </div>

                    {{-- Check-in --}}
                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-muted-foreground uppercase tracking-wide text-left">Check-in</label>
                        <input
                            name="check_in"
                            type="date"
                            x-model="checkIn"
                            :min="today"
                            @change="if(checkOut <= checkIn) checkOut = ''"
                            class="w-full h-11 px-3 rounded-lg border border-input bg-background text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                        >
                    </div>

                    {{-- Check-out --}}
                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-muted-foreground uppercase tracking-wide text-left">Check-out</label>
                        <input
                            name="check_out"
                            type="date"
                            x-model="checkOut"
                            :min="checkIn || today"
                            class="w-full h-11 px-3 rounded-lg border border-input bg-background text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                        >
                    </div>

                    {{-- Tamu & Tombol --}}
                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-muted-foreground uppercase tracking-wide text-left">Tamu & Kamar</label>
                        <div class="flex gap-2">
                            <div x-data="{ open: false }" class="relative flex-1">
                                <button type="button" @click="open = !open" @click.away="open = false"
                                    class="w-full h-11 px-3 rounded-lg border border-input bg-background text-sm text-left flex items-center justify-between gap-1 focus:outline-none focus:ring-2 focus:ring-ring">
                                    <span class="flex items-center gap-1.5">
                                        <x-ui.icon name="users" class="w-4 h-4 text-muted-foreground" />
                                        <span x-text="guests + ' tamu'"></span>
                                    </span>
                                    <x-ui.icon name="chevron-down" class="w-3.5 h-3.5 text-muted-foreground" />
                                </button>
                                <input type="hidden" name="guests" :value="guests">
                                <input type="hidden" name="rooms" :value="rooms">
                                <div x-show="open" x-transition class="absolute top-full left-0 mt-1 w-56 bg-popover border border-border rounded-lg shadow-lg p-4 z-50 space-y-3" style="display: none;">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium">Tamu</span>
                                        <div class="flex items-center gap-2">
                                            <button type="button" @click="guests = Math.max(1, guests - 1)" class="w-7 h-7 rounded-full border border-border flex items-center justify-center hover:bg-muted text-sm font-bold">-</button>
                                            <span x-text="guests" class="w-6 text-center text-sm font-medium"></span>
                                            <button type="button" @click="guests = Math.min(20, guests + 1)" class="w-7 h-7 rounded-full border border-border flex items-center justify-center hover:bg-muted text-sm font-bold">+</button>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium">Kamar</span>
                                        <div class="flex items-center gap-2">
                                            <button type="button" @click="rooms = Math.max(1, rooms - 1)" class="w-7 h-7 rounded-full border border-border flex items-center justify-center hover:bg-muted text-sm font-bold">-</button>
                                            <span x-text="rooms" class="w-6 text-center text-sm font-medium"></span>
                                            <button type="button" @click="rooms = Math.min(10, rooms + 1)" class="w-7 h-7 rounded-full border border-border flex items-center justify-center hover:bg-muted text-sm font-bold">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="h-11 px-4 bg-primary text-primary-foreground rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-1.5 text-sm font-semibold shrink-0">
                                <x-ui.icon name="search" class="w-4 h-4" />
                                <span class="hidden sm:inline">Cari</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- ===================== POPULAR CITIES ===================== --}}
    @if($popularCities->isNotEmpty())
    <section class="py-14 container mx-auto px-4">
        <div class="flex items-end justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold tracking-tight">Destinasi Populer</h2>
                <p class="text-muted-foreground mt-1">Jelajahi kota-kota favorit wisatawan Indonesia</p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
            @foreach($popularCities as $city)
            <a href="{{ route('search', ['q' => $city->name]) }}" class="group relative rounded-xl overflow-hidden aspect-square bg-muted hover:shadow-lg transition-all duration-300">
                @if($city->image)
                    <img src="{{ $city->image }}" alt="{{ $city->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-primary/20 to-primary/40 flex items-center justify-center">
                        <x-ui.icon name="map-pin" class="w-8 h-8 text-primary/60" />
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-2.5 text-white">
                    <p class="font-semibold text-sm leading-tight">{{ $city->name }}</p>
                    <p class="text-xs text-white/70">{{ $city->active_hotels_count }} hotel</p>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ===================== FEATURED HOTELS ===================== --}}
    @if($featuredHotels->isNotEmpty())
    <section class="py-14 bg-muted/30">
        <div class="container mx-auto px-4">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Hotel Rekomendasi</h2>
                    <p class="text-muted-foreground mt-1">Hotel terbaik pilihan pelanggan kami</p>
                </div>
                <a href="{{ route('search') }}" class="text-sm text-primary font-medium hover:underline flex items-center gap-1 shrink-0">
                    Lihat semua <x-ui.icon name="arrow-right" class="w-4 h-4" />
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($featuredHotels as $hotel)
                <a href="{{ route('hotels.show', $hotel->slug) }}" class="group block">
                    <x-ui.card class="overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1 h-full flex flex-col">
                        {{-- Image --}}
                        <div class="relative aspect-[4/3] overflow-hidden bg-muted">
                            <img
                                src="{{ $hotel->cover_image_url }}"
                                alt="{{ $hotel->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy"
                                onerror="this.src='https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&auto=format&fit=crop'"
                            >
                            {{-- Star badge --}}
                            <div class="absolute top-2.5 left-2.5">
                                <x-ui.badge variant="secondary" class="bg-background/90 backdrop-blur-sm text-xs">
                                    @for($i = 0; $i < $hotel->star_rating; $i++)
                                        ★
                                    @endfor
                                    {{ $hotel->star_rating }} Bintang
                                </x-ui.badge>
                            </div>
                        </div>

                        <x-ui.card.content class="flex-1 flex flex-col p-4">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <h3 class="font-semibold text-sm leading-snug line-clamp-2 group-hover:text-primary transition-colors">{{ $hotel->name }}</h3>
                            </div>
                            <p class="text-xs text-muted-foreground flex items-center gap-1 mb-3">
                                <x-ui.icon name="map-pin" class="w-3 h-3 shrink-0" />
                                {{ $hotel->city->name }}
                            </p>

                            @if($hotel->reviews_count > 0)
                            <div class="flex items-center gap-1.5 text-xs text-muted-foreground mb-3">
                                <span class="text-amber-500 font-semibold text-sm">{{ number_format($hotel->reviews_avg_rating, 1) }}</span>
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3 h-3 {{ $i <= round($hotel->reviews_avg_rating) ? 'text-amber-400' : 'text-muted-foreground/30' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                <span>({{ $hotel->reviews_count }})</span>
                            </div>
                            @endif

                            <div class="mt-auto pt-2 border-t border-border">
                                <p class="text-xs text-muted-foreground">Mulai dari</p>
                                <p class="font-bold text-primary">
                                    {{ format_rupiah($hotel->roomTypes->min('base_price') ?? 0) }}
                                    <span class="text-xs font-normal text-muted-foreground">/ malam</span>
                                </p>
                            </div>
                        </x-ui.card.content>
                    </x-ui.card>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===================== VOUCHER / PROMO ===================== --}}
    @if($activeVouchers->isNotEmpty())
    <section class="py-14 container mx-auto px-4">
        <div class="mb-8">
            <h2 class="text-2xl font-bold tracking-tight">Promo & Voucher</h2>
            <p class="text-muted-foreground mt-1">Hemat lebih banyak dengan voucher eksklusif kami</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach($activeVouchers as $voucher)
            <div class="relative rounded-2xl overflow-hidden border border-border bg-gradient-to-br from-primary/5 to-primary/10 p-6 group hover:shadow-lg transition-all duration-300">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -translate-y-8 translate-x-8"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-primary/5 rounded-full translate-y-6 -translate-x-6"></div>

                <div class="relative">
                    <div class="flex items-center justify-between mb-3">
                        <x-ui.badge variant="secondary">
                            {{ $voucher->type === 'percent' ? 'Diskon ' . (int)$voucher->value . '%' : 'Hemat ' . format_rupiah($voucher->value) }}
                        </x-ui.badge>
                        <x-ui.icon name="tag" class="w-5 h-5 text-primary/40" />
                    </div>

                    <div class="mb-4">
                        <p class="text-xs text-muted-foreground mb-1">Kode Voucher</p>
                        <div class="flex items-center gap-2">
                            <code class="text-xl font-bold tracking-widest text-primary">{{ $voucher->code }}</code>
                            <button onclick="navigator.clipboard.writeText('{{ $voucher->code }}').then(() => window.$store?.toasts?.add({type:'success', message:'Kode disalin!'}))" class="text-muted-foreground hover:text-foreground transition-colors p-1">
                                <x-ui.icon name="copy" class="w-4 h-4" />
                            </button>
                        </div>
                    </div>

                    <div class="text-xs text-muted-foreground space-y-1">
                        @if($voucher->min_spend)
                            <p>Min. transaksi: {{ format_rupiah($voucher->min_spend) }}</p>
                        @endif
                        @if($voucher->max_discount && $voucher->type === 'percent')
                            <p>Maks. diskon: {{ format_rupiah($voucher->max_discount) }}</p>
                        @endif
                        <p>Berlaku s.d.: {{ \Carbon\Carbon::parse($voucher->valid_until)->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ===================== WHY US ===================== --}}
    <section class="py-14 bg-muted/30">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-2xl font-bold tracking-tight">Mengapa Pilih StayHub?</h2>
                <p class="text-muted-foreground mt-2">Kami berkomitmen untuk memberikan pengalaman terbaik</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach([
                    ['icon' => 'shield-check', 'title' => 'Terpercaya & Aman', 'desc' => 'Transaksi aman dengan enkripsi SSL'],
                    ['icon' => 'badge-percent', 'title' => 'Harga Terbaik', 'desc' => 'Garansi harga terbaik untuk setiap pemesanan'],
                    ['icon' => 'headset', 'title' => 'Dukungan 24/7', 'desc' => 'Tim kami siap membantu kapan saja'],
                    ['icon' => 'zap', 'title' => 'Konfirmasi Instan', 'desc' => 'Booking terkonfirmasi dalam hitungan detik'],
                ] as $feature)
                <div class="text-center p-6">
                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-primary/10 text-primary mb-4">
                        <x-ui.icon :name="$feature['icon']" class="w-7 h-7" />
                    </div>
                    <h3 class="font-semibold text-sm mb-1">{{ $feature['title'] }}</h3>
                    <p class="text-xs text-muted-foreground">{{ $feature['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>

@push('scripts')
<script>
function heroSearch() {
    return {
        destination: '{{ request('q') }}',
        checkIn: '{{ request('check_in', now()->addDay()->format('Y-m-d')) }}',
        checkOut: '{{ request('check_out', now()->addDays(2)->format('Y-m-d')) }}',
        guests: {{ request('guests', 2) }},
        rooms: {{ request('rooms', 1) }},
        get today() { return new Date().toISOString().split('T')[0]; },
    }
}
</script>
@endpush

