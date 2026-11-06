<x-layouts.app :title="'Cari Hotel'">
    <div class="container mx-auto px-4 py-8">
        {{-- Header & breadcrumb --}}
        <div class="flex items-center gap-2 text-sm text-muted-foreground mb-6">
            <a href="{{ route('home') }}" class="hover:text-foreground transition-colors">Beranda</a>
            <x-ui.icon name="chevron-right" class="w-4 h-4" />
            <span class="text-foreground font-medium">Cari Hotel</span>
        </div>

        {{-- Top search bar --}}
        <div class="bg-muted/50 rounded-xl p-4 mb-6">
            <form action="{{ route('search') }}" method="GET" x-data="searchForm()" class="flex flex-col md:flex-row gap-3 items-end">
                <div class="flex-1 space-y-1">
                    <label class="block text-xs font-semibold text-muted-foreground">Destinasi</label>
                    <div class="relative">
                        <x-ui.icon name="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground pointer-events-none" />
                        <input name="q" type="text" value="{{ request('q') }}" placeholder="Kota atau nama hotel..." class="w-full pl-9 h-10 rounded-lg border border-input bg-background text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-muted-foreground">Check-in</label>
                    <input name="check_in" type="date" value="{{ request('check_in') }}" min="{{ today()->format('Y-m-d') }}" class="h-10 px-3 rounded-lg border border-input bg-background text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-muted-foreground">Check-out</label>
                    <input name="check_out" type="date" value="{{ request('check_out') }}" min="{{ today()->addDay()->format('Y-m-d') }}" class="h-10 px-3 rounded-lg border border-input bg-background text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-muted-foreground">Tamu</label>
                    <input name="guests" type="number" value="{{ request('guests', 2) }}" min="1" max="20" class="h-10 w-20 px-3 rounded-lg border border-input bg-background text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                </div>
                <x-ui.button type="submit" class="h-10 shrink-0">
                    <x-ui.icon name="search" class="w-4 h-4 mr-1.5" />
                    Cari
                </x-ui.button>
            </form>
        </div>

        <div class="flex gap-6">
            {{-- ========== SIDEBAR FILTER ========== --}}
            <aside class="hidden lg:block w-64 shrink-0">
                <form action="{{ route('search') }}" method="GET" id="filter-form">
                    <input type="hidden" name="q" value="{{ request('q') }}">
                    <input type="hidden" name="check_in" value="{{ request('check_in') }}">
                    <input type="hidden" name="check_out" value="{{ request('check_out') }}">
                    <input type="hidden" name="guests" value="{{ request('guests', 2) }}">
                    <input type="hidden" name="rooms" value="{{ request('rooms', 1) }}">

                    <x-ui.card class="sticky top-24">
                        <x-ui.card.header class="pb-3">
                            <div class="flex items-center justify-between">
                                <x-ui.card.title class="text-base">Filter</x-ui.card.title>
                                @if(request()->hasAny(['star_rating', 'facilities', 'property_type', 'min_price', 'max_price']))
                                    <a href="{{ route('search', request()->only(['q', 'check_in', 'check_out', 'guests', 'rooms', 'sort'])) }}" class="text-xs text-primary hover:underline">Reset</a>
                                @endif
                            </div>
                        </x-ui.card.header>
                        <x-ui.card.content class="space-y-5">

                            {{-- Rentang Harga --}}
                            <div>
                                <h4 class="text-sm font-semibold mb-3">Rentang Harga / Malam</h4>
                                <div class="space-y-2">
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-muted-foreground">Rp</span>
                                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full pl-9 h-9 rounded-md border border-input bg-background text-sm focus:outline-none focus:ring-2 focus:ring-ring" oninput="document.getElementById('filter-form').requestSubmit()">
                                    </div>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-muted-foreground">Rp</span>
                                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Maks" class="w-full pl-9 h-9 rounded-md border border-input bg-background text-sm focus:outline-none focus:ring-2 focus:ring-ring" oninput="document.getElementById('filter-form').requestSubmit()">
                                    </div>
                                </div>
                            </div>

                            <x-ui.separator />

                            {{-- Bintang Hotel --}}
                            <div>
                                <h4 class="text-sm font-semibold mb-3">Bintang Hotel</h4>
                                <div class="space-y-2">
                                    @foreach([5, 4, 3, 2, 1] as $star)
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="star_rating[]" value="{{ $star }}" {{ in_array($star, (array) request('star_rating', [])) ? 'checked' : '' }} class="rounded border-border" onchange="document.getElementById('filter-form').requestSubmit()">
                                        <span class="text-sm flex items-center gap-1">
                                            @for($i = 0; $i < $star; $i++) ★ @endfor
                                            <span class="text-muted-foreground">{{ $star }} Bintang</span>
                                        </span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <x-ui.separator />

                            {{-- Fasilitas --}}
                            <div>
                                <h4 class="text-sm font-semibold mb-3">Fasilitas Hotel</h4>
                                <div class="space-y-2">
                                    @foreach($facilities->take(8) as $facility)
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="facilities[]" value="{{ $facility->id }}" {{ in_array($facility->id, (array) request('facilities', [])) ? 'checked' : '' }} class="rounded border-border" onchange="document.getElementById('filter-form').requestSubmit()">
                                        <span class="text-sm text-muted-foreground">{{ $facility->name }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <x-ui.separator />

                            {{-- Tipe Properti --}}
                            <div>
                                <h4 class="text-sm font-semibold mb-3">Tipe Properti</h4>
                                <div class="space-y-2">
                                    @foreach(['Hotel', 'Resort', 'Villa', 'Apartment'] as $type)
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="property_type[]" value="{{ strtolower($type) }}" {{ in_array(strtolower($type), (array) request('property_type', [])) ? 'checked' : '' }} class="rounded border-border" onchange="document.getElementById('filter-form').requestSubmit()">
                                        <span class="text-sm text-muted-foreground">{{ $type }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                        </x-ui.card.content>
                    </x-ui.card>
                </form>
            </aside>

            {{-- ========== HOTEL LIST ========== --}}
            <div class="flex-1 min-w-0">
                {{-- Results header --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                    <div>
                        <p class="text-sm text-muted-foreground">
                            Menampilkan <span class="font-semibold text-foreground">{{ $hotels->total() }}</span> hotel
                            @if(request('q'))
                                untuk "<span class="font-semibold text-foreground">{{ request('q') }}</span>"
                            @endif
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-muted-foreground shrink-0">Urutkan:</span>
                        <form action="{{ route('search') }}" method="GET" id="sort-form">
                            @foreach(request()->except('sort') as $key => $value)
                                @if(is_array($value))
                                    @foreach($value as $v)
                                        <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach
                            <select name="sort" onchange="document.getElementById('sort-form').submit()" class="h-9 px-3 rounded-md border border-input bg-background text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                                <option value="popular" {{ request('sort', 'popular') === 'popular' ? 'selected' : '' }}>Terpopuler</option>
                                <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                            </select>
                        </form>
                    </div>
                </div>

                {{-- Hotel Cards --}}
                @if($hotels->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-20 h-20 rounded-full bg-muted flex items-center justify-center mb-4">
                            <x-ui.icon name="search-x" class="w-10 h-10 text-muted-foreground" />
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Hotel tidak ditemukan</h3>
                        <p class="text-muted-foreground text-sm max-w-sm">
                            Tidak ada hotel yang sesuai dengan pencarian dan filter Anda. Coba ubah kata kunci atau filter.
                        </p>
                        <a href="{{ route('search') }}" class="mt-5">
                            <x-ui.button variant="outline">Reset Pencarian</x-ui.button>
                        </a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($hotels as $hotel)
                        <a href="{{ route('hotels.show', array_merge(['slug' => $hotel->slug], request()->only(['check_in', 'check_out', 'guests', 'rooms']))) }}" class="group block">
                            <x-ui.card class="overflow-hidden hover:shadow-md transition-all duration-200">
                                <div class="flex flex-col sm:flex-row">
                                    {{-- Image --}}
                                    <div class="sm:w-56 lg:w-64 shrink-0">
                                        <div class="relative h-48 sm:h-full overflow-hidden bg-muted">
                                            <img
                                                src="{{ $hotel->cover_image_url }}"
                                                alt="{{ $hotel->name }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                                loading="lazy"
                                                onerror="this.src='https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&auto=format&fit=crop'"
                                            >
                                        </div>
                                    </div>

                                    {{-- Content --}}
                                    <div class="flex-1 p-4 flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-start justify-between gap-3 mb-1">
                                                <div>
                                                    <h3 class="font-semibold group-hover:text-primary transition-colors line-clamp-1">{{ $hotel->name }}</h3>
                                                    <p class="text-sm text-muted-foreground flex items-center gap-1 mt-0.5">
                                                        <x-ui.icon name="map-pin" class="w-3.5 h-3.5 shrink-0" />
                                                        {{ $hotel->address }}, {{ $hotel->city->name }}
                                                    </p>
                                                </div>
                                                <div class="shrink-0 text-right">
                                                    @if($hotel->reviews_count > 0)
                                                        <div class="inline-flex items-center gap-1 bg-primary/10 text-primary text-xs font-bold px-2 py-1 rounded-lg">
                                                            <x-ui.icon name="star" class="w-3 h-3" />
                                                            {{ number_format($hotel->reviews_avg_rating, 1) }}
                                                        </div>
                                                        <p class="text-xs text-muted-foreground mt-0.5">{{ $hotel->reviews_count }} ulasan</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Stars --}}
                                            <div class="flex items-center gap-1 mt-2">
                                                @for($i = 0; $i < $hotel->star_rating; $i++)
                                                    <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                @endfor
                                                <span class="text-xs text-muted-foreground">{{ $hotel->star_rating }} Bintang · {{ ucfirst($hotel->property_type->value ?? '') }}</span>
                                            </div>
                                        </div>

                                        <div class="flex items-end justify-between mt-3 pt-3 border-t border-border">
                                            <div class="text-xs text-muted-foreground">
                                                @if($hotel->city)
                                                    <span class="inline-flex items-center gap-1">
                                                        <x-ui.icon name="building-2" class="w-3.5 h-3.5" />
                                                        {{ $hotel->city->name }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-muted-foreground">Mulai dari</p>
                                                <p class="font-bold text-lg text-primary">{{ format_rupiah($hotel->room_types_min_base_price ?? 0) }}</p>
                                                <p class="text-xs text-muted-foreground">per malam</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </x-ui.card>
                        </a>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-8">
                        {{ $hotels->links('components.ui.pagination') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>

