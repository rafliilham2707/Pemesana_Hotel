<x-layouts.admin :title="'Tipe Kamar - ' . $hotel->name">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-muted-foreground mb-1">
                    <a href="{{ route('admin.hotels.index') }}" class="hover:text-foreground">Kelola Hotel</a>
                    <span>/</span>
                    <span>{{ $hotel->name }}</span>
                </div>
                <h1 class="text-2xl font-bold tracking-tight">Tipe Kamar Hotel</h1>
                <p class="text-xs text-muted-foreground">Kelola kapasitas, harga dasar, dan inventori untuk properti ini</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.hotels.rooms.create', $hotel->id) }}">
                    <x-ui.button size="sm" class="gap-1.5">
                        <x-ui.icon name="plus" class="w-4 h-4" />
                        Tambah Tipe Kamar
                    </x-ui.button>
                </a>
            </div>
        </div>

        @if(session('status'))
            <x-ui.alert variant="success">{{ session('status') }}</x-ui.alert>
        @endif

        <x-ui.card>
            <x-ui.card.content class="p-0">
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead class="text-muted-foreground uppercase border-b border-border bg-muted/20">
                            <tr>
                                <th class="py-3 px-4">Tipe Kamar</th>
                                <th class="py-3 px-4">Kapasitas</th>
                                <th class="py-3 px-4">Tipe Ranjang</th>
                                <th class="py-3 px-4">Total Unit</th>
                                <th class="py-3 px-4">Harga Dasar</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($rooms as $r)
                                <tr class="hover:bg-muted/40 transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-muted overflow-hidden shrink-0">
                                                <img src="{{ $r->image }}" alt="" class="w-full h-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1590490360182-c33d57733427?w=200'">
                                            </div>
                                            <div>
                                                <p class="font-bold text-foreground text-sm">{{ $r->name }}</p>
                                                <p class="text-muted-foreground text-[11px]">{{ $r->size_m2 ? $r->size_m2 . ' m²' : '' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 font-medium">{{ $r->max_guests }} Tamu</td>
                                    <td class="py-3 px-4">{{ $r->bed_type }}</td>
                                    <td class="py-3 px-4 font-semibold">{{ $r->total_rooms }} Kamar</td>
                                    <td class="py-3 px-4 font-bold text-primary">{{ format_rupiah($r->base_price) }}</td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.hotels.rooms.inventories', [$hotel->id, $r->id]) }}">
                                                <x-ui.button variant="outline" size="sm" class="h-7 text-[11px] gap-1 px-2">
                                                    <x-ui.icon name="calendar" class="w-3 h-3" />
                                                    Harga & Stok Harian
                                                </x-ui.button>
                                            </a>
                                            <a href="{{ route('admin.hotels.rooms.edit', [$hotel->id, $r->id]) }}" class="p-1 text-primary hover:text-primary/80" title="Edit">
                                                <x-ui.icon name="edit" class="w-4 h-4" />
                                            </a>
                                            <form action="{{ route('admin.hotels.rooms.destroy', [$hotel->id, $r->id]) }}" method="POST" onsubmit="return confirm('Hapus tipe kamar ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 text-destructive hover:text-destructive/80" title="Hapus">
                                                    <x-ui.icon name="trash-2" class="w-4 h-4" />
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-muted-foreground">Belum ada tipe kamar untuk hotel ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-ui.card.content>
        </x-ui.card>
    </div>
</x-layouts.admin>

