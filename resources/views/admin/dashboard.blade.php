<x-layouts.admin :title="'Dashboard Admin'">
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Dashboard Ringkasan</h1>
                <p class="text-xs text-muted-foreground">Gambaran umum metrik performa operasional StayHub</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.hotels.create') }}">
                    <x-ui.button size="sm" class="gap-1.5">
                        <x-ui.icon name="plus" class="w-4 h-4" />
                        Tambah Hotel Baru
                    </x-ui.button>
                </a>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Hotels --}}
            <x-ui.card>
                <x-ui.card.content class="p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Total Hotel</p>
                        <p class="text-2xl font-bold mt-1">{{ number_format($totalHotels) }}</p>
                        <a href="{{ route('admin.hotels.index') }}" class="text-[11px] text-primary hover:underline mt-1 inline-block">Kelola hotel &rarr;</a>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                        <x-ui.icon name="hotel" class="w-6 h-6" />
                    </div>
                </x-ui.card.content>
            </x-ui.card>

            {{-- Bookings --}}
            <x-ui.card>
                <x-ui.card.content class="p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Total Pesanan</p>
                        <p class="text-2xl font-bold mt-1">{{ number_format($totalBookings) }}</p>
                        <a href="{{ route('admin.bookings.index') }}" class="text-[11px] text-blue-500 hover:underline mt-1 inline-block">Lihat transaksi &rarr;</a>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-500 flex items-center justify-center">
                        <x-ui.icon name="calendar-check" class="w-6 h-6" />
                    </div>
                </x-ui.card.content>
            </x-ui.card>

            {{-- Revenue --}}
            <x-ui.card>
                <x-ui.card.content class="p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Total Pendapatan</p>
                        <p class="text-2xl font-bold mt-1 text-emerald-600 dark:text-emerald-400">{{ format_rupiah($totalRevenue) }}</p>
                        <span class="text-[11px] text-emerald-600">Pesanan terkonfirmasi</span>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center">
                        <x-ui.icon name="dollar-sign" class="w-6 h-6" />
                    </div>
                </x-ui.card.content>
            </x-ui.card>

            {{-- Users --}}
            <x-ui.card>
                <x-ui.card.content class="p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Total Pengguna</p>
                        <p class="text-2xl font-bold mt-1">{{ number_format($totalUsers) }}</p>
                        <a href="{{ route('admin.users.index') }}" class="text-[11px] text-purple-500 hover:underline mt-1 inline-block">Kelola user &rarr;</a>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-purple-500/10 text-purple-500 flex items-center justify-center">
                        <x-ui.icon name="users" class="w-6 h-6" />
                    </div>
                </x-ui.card.content>
            </x-ui.card>
        </div>

        {{-- Recent Bookings Table --}}
        <x-ui.card>
            <x-ui.card.header class="flex flex-row items-center justify-between pb-3">
                <div>
                    <x-ui.card.title class="text-base">Pesanan Hotel Terkini</x-ui.card.title>
                    <x-ui.card.description>5 transaksi terbaru yang masuk ke sistem</x-ui.card.description>
                </div>
                <a href="{{ route('admin.bookings.index') }}">
                    <x-ui.button variant="outline" size="sm">Lihat Semua</x-ui.button>
                </a>
            </x-ui.card.header>
            <x-ui.card.content>
                @if($recentBookings->isEmpty())
                    <p class="text-xs text-muted-foreground text-center py-6">Belum ada transaksi pesanan.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left">
                            <thead class="text-muted-foreground uppercase border-b border-border bg-muted/20">
                                <tr>
                                    <th class="py-2.5 px-3">Kode Booking</th>
                                    <th class="py-2.5 px-3">Nama Tamu</th>
                                    <th class="py-2.5 px-3">Hotel & Kamar</th>
                                    <th class="py-2.5 px-3">Total Bayar</th>
                                    <th class="py-2.5 px-3">Status</th>
                                    <th class="py-2.5 px-3">Waktu</th>
                                    <th class="py-2.5 px-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border">
                                @foreach($recentBookings as $b)
                                    <tr class="hover:bg-muted/40 transition-colors">
                                        <td class="py-3 px-3 font-mono font-bold text-primary">{{ $b->booking_code }}</td>
                                        <td class="py-3 px-3">
                                            <p class="font-medium text-foreground">{{ $b->guest_name }}</p>
                                            <p class="text-muted-foreground text-[11px]">{{ $b->guest_email }}</p>
                                        </td>
                                        <td class="py-3 px-3">
                                            <p class="font-medium text-foreground">{{ $b->hotel->name }}</p>
                                            <p class="text-muted-foreground text-[11px]">{{ $b->roomType->name }}</p>
                                        </td>
                                        <td class="py-3 px-3 font-semibold">{{ format_rupiah($b->total) }}</td>
                                        <td class="py-3 px-3">
                                            <x-ui.badge :variant="$b->status->value === 'paid' ? 'success' : ($b->status->value === 'pending' ? 'warning' : 'secondary')">
                                                {{ ucfirst($b->status->value) }}
                                            </x-ui.badge>
                                        </td>
                                        <td class="py-3 px-3 text-muted-foreground">{{ $b->created_at->diffForHumans() }}</td>
                                        <td class="py-3 px-3 text-right">
                                            <a href="{{ route('admin.bookings.show', $b->booking_code) }}" class="text-primary hover:underline font-medium">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </x-ui.card.content>
        </x-ui.card>
    </div>
</x-layouts.admin>
