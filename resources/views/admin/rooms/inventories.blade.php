<x-layouts.admin :title="'Kelola Inventori & Harga - ' . $room->name">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-muted-foreground mb-1">
                    <a href="{{ route('admin.hotels.index') }}" class="hover:text-foreground">Hotel</a>
                    <span>/</span>
                    <a href="{{ route('admin.hotels.rooms.index', $hotel->id) }}" class="hover:text-foreground">{{ $hotel->name }}</a>
                    <span>/</span>
                    <span>{{ $room->name }}</span>
                </div>
                <h1 class="text-2xl font-bold tracking-tight">Ketersediaan & Harga Harian</h1>
                <p class="text-xs text-muted-foreground">Sesuaikan sisa kamar tersedia dan harga dinamis untuk 30 hari ke depan</p>
            </div>
            <a href="{{ route('admin.hotels.rooms.index', $hotel->id) }}">
                <x-ui.button variant="ghost" size="sm">&larr; Kembali</x-ui.button>
            </a>
        </div>

        @if(session('status'))
            <x-ui.alert variant="success">{{ session('status') }}</x-ui.alert>
        @endif

        {{-- Bulk Update Box --}}
        <x-ui.card class="border-primary/40 bg-primary/5">
            <x-ui.card.header class="pb-3">
                <x-ui.card.title class="text-base flex items-center gap-2">
                    <x-ui.icon name="edit-3" class="w-4 h-4 text-primary" />
                    Perbarui Cepat per Rentang Tanggal
                </x-ui.card.title>
                <x-ui.card.description>Terapkan perubahan harga atau ketersediaan stok sekaligus untuk beberapa hari</x-ui.card.description>
            </x-ui.card.header>
            <x-ui.card.content>
                <form action="{{ route('admin.hotels.rooms.inventories.update', [$hotel->id, $room->id]) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 items-end">
                    @csrf
                    <div class="space-y-1">
                        <x-ui.label for="start_date" class="text-xs">Dari Tanggal</x-ui.label>
                        <x-ui.input id="start_date" name="start_date" type="date" :value="today()->format('Y-m-d')" min="{{ today()->format('Y-m-d') }}" required class="h-9 text-xs" />
                    </div>
                    <div class="space-y-1">
                        <x-ui.label for="end_date" class="text-xs">Sampai Tanggal</x-ui.label>
                        <x-ui.input id="end_date" name="end_date" type="date" :value="today()->addDays(7)->format('Y-m-d')" min="{{ today()->format('Y-m-d') }}" required class="h-9 text-xs" />
                    </div>
                    <div class="space-y-1">
                        <x-ui.label for="available_rooms" class="text-xs">Sisa Kamar (Maks {{ $room->total_rooms }})</x-ui.label>
                        <x-ui.input id="available_rooms" name="available_rooms" type="number" :value="$room->total_rooms" min="0" max="{{ $room->total_rooms }}" required class="h-9 text-xs" />
                    </div>
                    <div class="space-y-1">
                        <x-ui.label for="price" class="text-xs">Harga per Malam (Rp)</x-ui.label>
                        <x-ui.input id="price" name="price" type="number" :value="$room->base_price" min="0" step="10000" required class="h-9 text-xs" />
                    </div>
                    <div>
                        <x-ui.button type="submit" size="sm" class="w-full h-9">
                            Terapkan
                        </x-ui.button>
                    </div>
                </form>
            </x-ui.card.content>
        </x-ui.card>

        {{-- 30 Days Inventory Grid / Table --}}
        <x-ui.card>
            <x-ui.card.header>
                <x-ui.card.title class="text-base">Daftar Inventori 30 Hari ke Depan</x-ui.card.title>
            </x-ui.card.header>
            <x-ui.card.content class="p-0">
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead class="text-muted-foreground uppercase border-b border-border bg-muted/20">
                            <tr>
                                <th class="py-2.5 px-4">Tanggal</th>
                                <th class="py-2.5 px-4">Hari</th>
                                <th class="py-2.5 px-4">Kamar Tersedia</th>
                                <th class="py-2.5 px-4">Harga / Malam</th>
                                <th class="py-2.5 px-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($inventories as $inv)
                                @php
                                    $carbonDate = \Carbon\Carbon::parse($inv->date);
                                    $isWeekend = $carbonDate->isWeekend();
                                @endphp
                                <tr class="hover:bg-muted/40 transition-colors {{ $isWeekend ? 'bg-muted/10' : '' }}">
                                    <td class="py-2.5 px-4 font-mono font-medium">{{ $carbonDate->translatedFormat('d F Y') }}</td>
                                    <td class="py-2.5 px-4">
                                        <span class="{{ $isWeekend ? 'text-primary font-semibold' : 'text-muted-foreground' }}">
                                            {{ $carbonDate->translatedFormat('l') }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-4 font-bold {{ $inv->available_rooms === 0 ? 'text-destructive' : 'text-foreground' }}">
                                        {{ $inv->available_rooms }} / {{ $room->total_rooms }} kamar
                                    </td>
                                    <td class="py-2.5 px-4 font-bold text-primary">
                                        {{ format_rupiah($inv->price) }}
                                    </td>
                                    <td class="py-2.5 px-4">
                                        @if($inv->available_rooms > 0)
                                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                                <x-ui.icon name="check-circle" class="w-3.5 h-3.5" />
                                                Tersedia
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-destructive">
                                                <x-ui.icon name="alert-circle" class="w-3.5 h-3.5" />
                                                Penuh / Habis
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-muted-foreground">Belum ada catatan inventori untuk 30 hari ke depan. Gunakan form di atas untuk men-generate inventori.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-ui.card.content>
        </x-ui.card>
    </div>
</x-layouts.admin>

