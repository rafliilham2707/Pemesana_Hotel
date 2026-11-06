<x-layouts.admin :title="'Kelola Hotel'">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Kelola Hotel</h1>
                <p class="text-xs text-muted-foreground">Daftar seluruh properti hotel yang terdaftar di sistem</p>
            </div>
            <a href="{{ route('admin.hotels.create') }}">
                <x-ui.button size="sm" class="gap-1.5">
                    <x-ui.icon name="plus" class="w-4 h-4" />
                    Tambah Hotel Baru
                </x-ui.button>
            </a>
        </div>

        @if(session('status'))
            <x-ui.alert variant="success">{{ session('status') }}</x-ui.alert>
        @endif

        {{-- Filter & Search Box --}}
        <x-ui.card>
            <x-ui.card.content class="p-4">
                <form action="{{ route('admin.hotels.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <x-ui.icon name="search" class="w-4 h-4 text-muted-foreground absolute left-3 top-1/2 -translate-y-1/2" />
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama hotel atau alamat..." class="w-full pl-9 h-9 text-xs rounded-md border border-input bg-background focus:outline-none focus:ring-1 focus:ring-ring">
                    </div>
                    <div class="w-full sm:w-48">
                        <select name="city_id" class="w-full h-9 text-xs rounded-md border border-input bg-background focus:outline-none focus:ring-1 focus:ring-ring" onchange="this.form.submit()">
                            <option value="">Semua Kota</option>
                            @foreach($cities as $c)
                                <option value="{{ $c->id }}" {{ request('city_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-ui.button type="submit" size="sm" variant="secondary">Cari</x-ui.button>
                </form>
            </x-ui.card.content>
        </x-ui.card>

        {{-- Hotels Table --}}
        <x-ui.card>
            <x-ui.card.content class="p-0">
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead class="text-muted-foreground uppercase border-b border-border bg-muted/20">
                            <tr>
                                <th class="py-3 px-4">Hotel</th>
                                <th class="py-3 px-4">Kota</th>
                                <th class="py-3 px-4">Bintang</th>
                                <th class="py-3 px-4">Tipe Kamar</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($hotels as $h)
                                <tr class="hover:bg-muted/40 transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-muted overflow-hidden shrink-0">
                                                <img src="{{ $h->cover_image_url }}" alt="" class="w-full h-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1566073771259-6a8506099945?w=200'">
                                            </div>
                                            <div>
                                                <p class="font-bold text-foreground text-sm line-clamp-1">{{ $h->name }}</p>
                                                <p class="text-muted-foreground text-[11px] line-clamp-1">{{ $h->address }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 font-medium">{{ $h->city->name }}</td>
                                    <td class="py-3 px-4 text-amber-500 font-semibold">
                                        ★ {{ $h->star_rating }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('admin.hotels.rooms.index', $h->id) }}" class="inline-flex items-center gap-1 font-semibold text-primary hover:underline">
                                            <x-ui.icon name="bed" class="w-3.5 h-3.5" />
                                            {{ $h->room_types_count }} Kamar
                                        </a>
                                    </td>
                                    <td class="py-3 px-4">
                                        <form action="{{ route('admin.hotels.toggle-status', $h->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $h->is_active ? 'bg-emerald-500/10 text-emerald-600' : 'bg-muted text-muted-foreground' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $h->is_active ? 'bg-emerald-500' : 'bg-muted-foreground' }}"></span>
                                                {{ $h->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('hotels.show', $h->slug) }}" target="_blank" class="p-1 text-muted-foreground hover:text-foreground" title="Lihat di web">
                                                <x-ui.icon name="external-link" class="w-4 h-4" />
                                            </a>
                                            <a href="{{ route('admin.hotels.edit', $h->id) }}" class="p-1 text-primary hover:text-primary/80" title="Edit Hotel">
                                                <x-ui.icon name="edit" class="w-4 h-4" />
                                            </a>
                                            <form action="{{ route('admin.hotels.destroy', $h->id) }}" method="POST" onsubmit="return confirm('Hapus hotel ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 text-destructive hover:text-destructive/80" title="Hapus Hotel">
                                                    <x-ui.icon name="trash-2" class="w-4 h-4" />
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-muted-foreground">Tidak ada hotel ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-border">
                    {{ $hotels->links('components.ui.pagination') }}
                </div>
            </x-ui.card.content>
        </x-ui.card>
    </div>
</x-layouts.admin>

