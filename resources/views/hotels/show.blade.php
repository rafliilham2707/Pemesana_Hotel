<x-layouts.app :title="$hotel->name">
    <div class="container mx-auto px-4 py-8">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm text-muted-foreground mb-6">
            <a href="{{ route('home') }}" class="hover:text-foreground transition-colors">Beranda</a>
            <x-ui.icon name="chevron-right" class="w-4 h-4" />
            <a href="{{ route('search', ['city' => $hotel->city->slug]) }}" class="hover:text-foreground transition-colors">Hotel di {{ $hotel->city->name }}</a>
            <x-ui.icon name="chevron-right" class="w-4 h-4" />
            <span class="text-foreground font-medium truncate max-w-xs sm:max-w-md">{{ $hotel->name }}</span>
        </div>

        {{-- Hotel Header --}}
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-6">
            <div>
                <div class="flex flex-wrap items-center gap-2 mb-2">
                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-foreground">{{ $hotel->name }}</h1>
                    <div class="flex items-center text-amber-400">
                        @for($i = 0; $i < $hotel->star_rating; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <x-ui.badge variant="secondary" class="capitalize">
                        {{ $hotel->property_type->value ?? 'Hotel' }}
                    </x-ui.badge>
                </div>
                <p class="text-sm text-muted-foreground flex items-center gap-1.5">
                    <x-ui.icon name="map-pin" class="w-4 h-4 text-primary shrink-0" />
                    {{ $hotel->address }}, {{ $hotel->city->name }}
                </p>
            </div>

            <div class="flex items-center gap-3 self-start md:self-auto">
                <form action="{{ route('account.wishlist.toggle', $hotel->id) }}" method="POST">
                    @csrf
                    <x-ui.button type="submit" variant="outline" size="sm" class="gap-1.5">
                        <x-ui.icon name="heart" class="w-4 h-4 {{ $isWishlisted ? 'text-destructive fill-destructive' : 'text-muted-foreground' }}" />
                        <span>{{ $isWishlisted ? 'Tersimpan' : 'Simpan' }}</span>
                    </x-ui.button>
                </form>

                <div class="text-right">
                    <p class="text-xs text-muted-foreground">Mulai dari</p>
                    <p class="text-2xl font-bold text-primary">{{ format_rupiah($hotel->roomTypes->min('base_price') ?? 0) }}</p>
                    <p class="text-xs text-muted-foreground">/ malam</p>
                </div>
            </div>
        </div>

        {{-- Photo Gallery --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-2 rounded-2xl overflow-hidden mb-10 h-[380px] sm:h-[440px]">
            <div class="md:col-span-2 md:row-span-2 h-full bg-muted relative overflow-hidden group">
                <img
                    src="{{ $hotel->cover_image_url }}"
                    alt="{{ $hotel->name }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    onerror="this.src='https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1000&auto=format&fit=crop'"
                >
            </div>
            @php
                $extraImages = $hotel->images->where('path', '!=', $hotel->cover_image_url)->take(3);
                $fillerCount = 3 - $extraImages->count();
            @endphp
            @foreach($extraImages as $img)
                <div class="hidden md:block h-full bg-muted relative overflow-hidden group">
                    <img
                        src="{{ $img->path }}"
                        alt="{{ $hotel->name }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        onerror="this.src='https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800&auto=format&fit=crop'"
                    >
                </div>
            @endforeach
            @for($i = 0; $i < $fillerCount; $i++)
                <div class="hidden md:block h-full bg-muted relative overflow-hidden group">
                    <img
                        src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800&auto=format&fit=crop"
                        alt="Kamar Hotel"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    >
                </div>
            @endfor
        </div>

        {{-- Date & Guest Filter Box for Room Selection --}}
        <div class="bg-card border border-border rounded-xl p-4 shadow-sm mb-10">
            <form action="{{ route('hotels.show', $hotel->slug) }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 items-end">
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-muted-foreground uppercase">Check-in</label>
                    <input
                        type="date"
                        name="check_in"
                        value="{{ $checkIn }}"
                        min="{{ today()->format('Y-m-d') }}"
                        class="w-full h-10 px-3 rounded-md border border-input bg-background text-sm focus:outline-none focus:ring-2 focus:ring-ring"
                    >
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-muted-foreground uppercase">Check-out</label>
                    <input
                        type="date"
                        name="check_out"
                        value="{{ $checkOut }}"
                        min="{{ \Carbon\Carbon::parse($checkIn)->addDay()->format('Y-m-d') }}"
                        class="w-full h-10 px-3 rounded-md border border-input bg-background text-sm focus:outline-none focus:ring-2 focus:ring-ring"
                    >
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-muted-foreground uppercase">Tamu</label>
                    <input
                        type="number"
                        name="guests"
                        value="{{ $guests }}"
                        min="1"
                        max="20"
                        class="w-full h-10 px-3 rounded-md border border-input bg-background text-sm focus:outline-none focus:ring-2 focus:ring-ring"
                    >
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-muted-foreground uppercase">Kamar</label>
                    <input
                        type="number"
                        name="rooms"
                        value="{{ $rooms }}"
                        min="1"
                        max="10"
                        class="w-full h-10 px-3 rounded-md border border-input bg-background text-sm focus:outline-none focus:ring-2 focus:ring-ring"
                    >
                </div>
                <div>
                    <x-ui.button type="submit" class="w-full h-10 gap-1.5">
                        <x-ui.icon name="refresh-cw" class="w-4 h-4" />
                        Cek Ketersediaan
                    </x-ui.button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Column (Room Types, Facilities, Reviews) --}}
            <div class="lg:col-span-2 space-y-10">
                {{-- Room Types Section --}}
                <section id="rooms">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold tracking-tight">Pilih Tipe Kamar</h2>
                        <span class="text-xs text-muted-foreground">
                            {{ \Carbon\Carbon::parse($checkIn)->diffInDays(\Carbon\Carbon::parse($checkOut)) }} malam
                        </span>
                    </div>

                    <div class="space-y-4">
                        @forelse($hotel->roomTypes as $room)
                            @php
                                $isAvailable = $room->checkAvailability($checkIn, $checkOut, $rooms);
                                $availableCount = $room->getMinAvailableRooms($checkIn, $checkOut);
                                $totalPrice = $room->calculateTotalPrice($checkIn, $checkOut, $rooms);
                                $nights = max(1, \Carbon\Carbon::parse($checkIn)->diffInDays(\Carbon\Carbon::parse($checkOut)));
                            @endphp
                            <x-ui.card class="overflow-hidden border-border {{ !$isAvailable ? 'opacity-60 bg-muted/30' : '' }}">
                                <div class="flex flex-col sm:flex-row">
                                    <div class="sm:w-52 h-44 sm:h-auto bg-muted shrink-0 relative overflow-hidden">
                                        <img
                                            src="{{ $room->image ?? 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=600&auto=format&fit=crop' }}"
                                            alt="{{ $room->name }}"
                                            class="w-full h-full object-cover"
                                            onerror="this.src='https://images.unsplash.com/photo-1590490360182-c33d57733427?w=600&auto=format&fit=crop'"
                                        >
                                    </div>
                                    <div class="flex-1 p-5 flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-start justify-between gap-2 mb-2">
                                                <div>
                                                    <h3 class="font-bold text-base text-foreground">{{ $room->name }}</h3>
                                                    <p class="text-xs text-muted-foreground line-clamp-2 mt-1">{{ $room->description }}</p>
                                                </div>
                                            </div>

                                            <div class="flex flex-wrap items-center gap-3 text-xs text-muted-foreground my-3">
                                                <span class="flex items-center gap-1">
                                                    <x-ui.icon name="users" class="w-3.5 h-3.5 text-primary" />
                                                    Maks {{ $room->max_guests }} tamu
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <x-ui.icon name="bed" class="w-3.5 h-3.5 text-primary" />
                                                    {{ $room->bed_type }}
                                                </span>
                                                @if($room->size_m2)
                                                    <span class="flex items-center gap-1">
                                                        <x-ui.icon name="maximize" class="w-3.5 h-3.5 text-primary" />
                                                        {{ $room->size_m2 }} m²
                                                    </span>
                                                @endif
                                            </div>

                                            @if($room->facilities->isNotEmpty())
                                                <div class="flex flex-wrap gap-1.5 mb-3">
                                                    @foreach($room->facilities->take(4) as $facility)
                                                        <x-ui.badge variant="outline" class="text-[11px] py-0 px-2 font-normal">
                                                            {{ $facility->name }}
                                                        </x-ui.badge>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex items-end justify-between pt-3 border-t border-border mt-3">
                                            <div>
                                                @if($isAvailable)
                                                    <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                                                        <x-ui.icon name="check-circle" class="w-3.5 h-3.5" />
                                                        Tersedia (Sisa {{ $availableCount }} kamar)
                                                    </span>
                                                @else
                                                    <span class="text-xs font-medium text-destructive flex items-center gap-1">
                                                        <x-ui.icon name="alert-circle" class="w-3.5 h-3.5" />
                                                        Kamar Habis untuk tanggal ini
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="text-right">
                                                <p class="text-xs text-muted-foreground">{{ $nights }} malam, {{ $rooms }} kamar</p>
                                                <p class="text-lg font-bold text-primary">{{ format_rupiah($totalPrice) }}</p>
                                                
                                                @if($isAvailable)
                                                    <a href="{{ route('booking.create', [
                                                        'room_type_id' => $room->id,
                                                        'check_in' => $checkIn,
                                                        'check_out' => $checkOut,
                                                        'rooms' => $rooms,
                                                        'guests' => $guests,
                                                    ]) }}" class="inline-block mt-2">
                                                        <x-ui.button size="sm" class="font-semibold">
                                                            Pesan Sekarang
                                                        </x-ui.button>
                                                    </a>
                                                @else
                                                    <x-ui.button size="sm" disabled class="mt-2 opacity-50 cursor-not-allowed">
                                                        Habis
                                                    </x-ui.button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </x-ui.card>
                        @empty
                            <p class="text-sm text-muted-foreground">Belum ada data tipe kamar untuk hotel ini.</p>
                        @endforelse
                    </div>
                </section>

                {{-- Description & Facilities --}}
                <section class="space-y-6 pt-6 border-t border-border">
                    <div>
                        <h2 class="text-xl font-bold tracking-tight mb-3">Tentang Hotel</h2>
                        <div class="text-sm text-muted-foreground leading-relaxed whitespace-pre-line">
                            {{ $hotel->description }}
                        </div>
                    </div>

                    @if($hotel->facilities->isNotEmpty())
                        <div>
                            <h2 class="text-xl font-bold tracking-tight mb-3">Fasilitas Hotel</h2>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach($hotel->facilities as $facility)
                                    <div class="flex items-center gap-2.5 p-2.5 rounded-lg border border-border bg-card/50 text-sm">
                                        <x-ui.icon name="{{ $facility->icon ?? 'check' }}" class="w-4 h-4 text-primary shrink-0" />
                                        <span>{{ $facility->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </section>

                {{-- Reviews Section --}}
                <section class="space-y-6 pt-6 border-t border-border" id="reviews">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold tracking-tight">Ulasan Tamu</h2>
                            <p class="text-sm text-muted-foreground">Pengalaman asli dari tamu yang pernah menginap</p>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-amber-500 flex items-center gap-1 justify-end">
                                <span>★</span>
                                <span>{{ number_format($avgRating, 1) }}</span>
                                <span class="text-xs text-muted-foreground font-normal">/ 5.0</span>
                            </div>
                            <p class="text-xs text-muted-foreground">dari {{ $reviewCount }} ulasan</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @forelse($reviews as $review)
                            <x-ui.card class="p-4">
                                <div class="flex items-start justify-between gap-3 mb-2">
                                    <div class="flex items-center gap-2.5">
                                        <x-ui.avatar :name="$review->user->name" size="sm" />
                                        <div>
                                            <p class="text-sm font-semibold text-foreground">{{ $review->user->name }}</p>
                                            <p class="text-xs text-muted-foreground">{{ $review->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center text-amber-400 text-xs">
                                        @for($i = 0; $i < $review->rating; $i++)
                                            ★
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-sm text-muted-foreground mt-2">{{ $review->comment }}</p>
                            </x-ui.card>
                        @empty
                            <div class="text-center py-8 text-muted-foreground text-sm">
                                Belum ada ulasan untuk hotel ini.
                            </div>
                        @endforelse
                    </div>

                    @if($reviews->hasPages())
                        <div class="pt-4">
                            {{ $reviews->links('components.ui.pagination') }}
                        </div>
                    @endif
                </section>
            </div>

            {{-- Sidebar Column (Policies, Check-in rules, Map) --}}
            <div class="space-y-6">
                {{-- Policy Card --}}
                <x-ui.card>
                    <x-ui.card.header>
                        <x-ui.card.title class="text-base flex items-center gap-2">
                            <x-ui.icon name="clock" class="w-4 h-4 text-primary" />
                            Waktu Check-in & Check-out
                        </x-ui.card.title>
                    </x-ui.card.header>
                    <x-ui.card.content class="space-y-3 text-sm">
                        <div class="flex justify-between py-1.5 border-b border-border">
                            <span class="text-muted-foreground">Check-in mulai:</span>
                            <span class="font-semibold">{{ $hotel->check_in_time ?? '14:00' }} WIB</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-border">
                            <span class="text-muted-foreground">Check-out sebelum:</span>
                            <span class="font-semibold">{{ $hotel->check_out_time ?? '12:00' }} WIB</span>
                        </div>

                        @if($hotel->policy)
                            <div class="pt-2">
                                <p class="font-semibold text-xs uppercase text-muted-foreground mb-1">Kebijakan Properti</p>
                                <p class="text-xs text-muted-foreground leading-relaxed">{{ $hotel->policy }}</p>
                            </div>
                        @endif
                    </x-ui.card.content>
                </x-ui.card>

                {{-- Location Card --}}
                <x-ui.card>
                    <x-ui.card.header>
                        <x-ui.card.title class="text-base flex items-center gap-2">
                            <x-ui.icon name="map-pin" class="w-4 h-4 text-primary" />
                            Lokasi
                        </x-ui.card.title>
                    </x-ui.card.header>
                    <x-ui.card.content class="space-y-3 text-sm">
                        <p class="text-muted-foreground">{{ $hotel->address }}</p>
                        <p class="font-medium text-foreground">{{ $hotel->city->name }}, Indonesia</p>

                        <div class="w-full h-40 bg-muted rounded-lg flex items-center justify-center border border-border text-xs text-muted-foreground">
                            <div class="text-center p-4">
                                <x-ui.icon name="map" class="w-6 h-6 mx-auto mb-1 text-primary" />
                                <span>Koordinat: {{ $hotel->latitude }}, {{ $hotel->longitude }}</span>
                            </div>
                        </div>
                    </x-ui.card.content>
                </x-ui.card>
            </div>
        </div>
    </div>
</x-layouts.app>

