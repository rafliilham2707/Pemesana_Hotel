<x-layouts.admin :title="'Kelola Pesanan'">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Kelola Pesanan</h1>
                <p class="text-xs text-muted-foreground">Monitor seluruh transaksi dan status reservasi tamu</p>
            </div>
        </div>

        @if(session('status'))
            <x-ui.alert variant="success">{{ session('status') }}</x-ui.alert>
        @endif

        {{-- Filter & Search Box --}}
        <x-ui.card>
            <x-ui.card.content class="p-4">
                <form action="{{ route('admin.bookings.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <x-ui.icon name="search" class="w-4 h-4 text-muted-foreground absolute left-3 top-1/2 -translate-y-1/2" />
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kode booking, nama tamu, email, hotel..." class="w-full pl-9 h-9 text-xs rounded-md border border-input bg-background focus:outline-none focus:ring-1 focus:ring-ring">
                    </div>
                    <div class="w-full sm:w-48">
                        <select name="status" class="w-full h-9 text-xs rounded-md border border-input bg-background focus:outline-none focus:ring-1 focus:ring-ring" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Bayar</option>
                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Lunas</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Kedaluwarsa</option>
                        </select>
                    </div>
                    <x-ui.button type="submit" size="sm" variant="secondary">Filter</x-ui.button>
                </form>
            </x-ui.card.content>
        </x-ui.card>

        {{-- Bookings Table --}}
        <x-ui.card>
            <x-ui.card.content class="p-0">
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead class="text-muted-foreground uppercase border-b border-border bg-muted/20">
                            <tr>
                                <th class="py-3 px-4">Kode Booking</th>
                                <th class="py-3 px-4">Tamu</th>
                                <th class="py-3 px-4">Hotel & Kamar</th>
                                <th class="py-3 px-4">Check-in / Out</th>
                                <th class="py-3 px-4">Total</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($bookings as $b)
                                <tr class="hover:bg-muted/40 transition-colors">
                                    <td class="py-3 px-4 font-mono font-bold text-primary">{{ $b->booking_code }}</td>
                                    <td class="py-3 px-4">
                                        <p class="font-medium text-foreground">{{ $b->guest_name }}</p>
                                        <p class="text-muted-foreground text-[11px]">{{ $b->guest_phone }}</p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="font-medium text-foreground">{{ $b->hotel->name }}</p>
                                        <p class="text-muted-foreground text-[11px]">{{ $b->roomType->name }} ({{ $b->rooms }} kamar)</p>
                                    </td>
                                    <td class="py-3 px-4 text-muted-foreground">
                                        {{ \Carbon\Carbon::parse($b->check_in)->format('d M') }} - {{ \Carbon\Carbon::parse($b->check_out)->format('d M Y') }}
                                    </td>
                                    <td class="py-3 px-4 font-bold">{{ format_rupiah($b->total) }}</td>
                                    <td class="py-3 px-4">
                                        <x-ui.badge :variant="$b->status->value === 'paid' ? 'success' : ($b->status->value === 'pending' ? 'warning' : ($b->status->value === 'completed' ? 'info' : 'destructive'))">
                                            {{ ucfirst($b->status->value) }}
                                        </x-ui.badge>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('admin.bookings.show', $b->booking_code) }}">
                                                <x-ui.button variant="outline" size="sm" class="h-7 text-[11px] px-2">Detail</x-ui.button>
                                            </a>
                                            @if($b->isPending())
                                                <form action="{{ route('admin.bookings.confirm-payment', $b->booking_code) }}" method="POST">
                                                    @csrf
                                                    <x-ui.button type="submit" size="sm" class="h-7 text-[11px] px-2 bg-emerald-600 hover:bg-emerald-700 text-white">Konfirmasi Bayar</x-ui.button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-8 text-muted-foreground">Tidak ada pesanan ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-border">
                    {{ $bookings->links('components.ui.pagination') }}
                </div>
            </x-ui.card.content>
        </x-ui.card>
    </div>
</x-layouts.admin>

