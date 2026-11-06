<x-layouts.app :title="'Wishlist Hotel Saya'">
    <div class="container mx-auto px-4 py-8 max-w-5xl">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">Wishlist Hotel</h1>
                <p class="text-sm text-muted-foreground">Hotel favorit yang Anda simpan untuk liburan mendatang</p>
            </div>
            <a href="{{ route('search') }}">
                <x-ui.button size="sm" variant="outline">
                    Jelajahi Hotel
                </x-ui.button>
            </a>
        </div>

        @if(session('status'))
            <x-ui.alert variant="success" class="mb-6">{{ session('status') }}</x-ui.alert>
        @endif

        @if($wishlists->isEmpty())
            <x-ui.card class="text-center py-16">
                <div class="w-16 h-16 bg-muted rounded-full flex items-center justify-center mx-auto mb-4 text-muted-foreground">
                    <x-ui.icon name="heart" class="w-8 h-8" />
                </div>
                <h3 class="text-lg font-semibold mb-1">Wishlist Masih Kosong</h3>
                <p class="text-sm text-muted-foreground max-w-sm mx-auto mb-6">
                    Simpan hotel impian Anda dengan menekan ikon hati di halaman hotel agar mudah ditemukan nanti.
                </p>
                <a href="{{ route('search') }}">
                    <x-ui.button>Cari Hotel Sekarang</x-ui.button>
                </a>
            </x-ui.card>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($wishlists as $w)
                    @php $hotel = $w->hotel; @endphp
                    <x-ui.card class="overflow-hidden flex flex-col justify-between group hover:shadow-md transition-shadow">
                        <div class="relative h-44 bg-muted overflow-hidden">
                            <img
                                src="{{ $hotel->cover_image_url }}"
                                alt="{{ $hotel->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                onerror="this.src='https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&auto=format&fit=crop'"
                            >
                            {{-- Remove button --}}
                            <form action="{{ route('account.wishlist.toggle', $hotel->id) }}" method="POST" class="absolute top-2.5 right-2.5">
                                @csrf
                                <button type="submit" class="w-8 h-8 rounded-full bg-background/80 backdrop-blur-sm text-destructive hover:bg-background flex items-center justify-center transition-colors shadow-sm" title="Hapus dari wishlist">
                                    <x-ui.icon name="trash-2" class="w-4 h-4" />
                                </button>
                            </form>
                        </div>

                        <x-ui.card.content class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-sm text-foreground group-hover:text-primary transition-colors line-clamp-1">{{ $hotel->name }}</h3>
                                <p class="text-xs text-muted-foreground mt-0.5 flex items-center gap-1">
                                    <x-ui.icon name="map-pin" class="w-3.5 h-3.5 text-primary shrink-0" />
                                    {{ $hotel->city->name }}
                                </p>
                            </div>

                            <div class="pt-3 mt-3 border-t border-border flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-muted-foreground block">Mulai dari</span>
                                    <span class="font-bold text-sm text-primary">{{ format_rupiah($hotel->roomTypes->min('base_price') ?? 0) }}</span>
                                </div>
                                <a href="{{ route('hotels.show', $hotel->slug) }}">
                                    <x-ui.button size="sm">Lihat Hotel</x-ui.button>
                                </a>
                            </div>
                        </x-ui.card.content>
                    </x-ui.card>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $wishlists->links('components.ui.pagination') }}
            </div>
        @endif
    </div>
</x-layouts.app>

