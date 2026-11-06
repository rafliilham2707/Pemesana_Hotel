<x-layouts.app :title="'Pesanan Saya'">
    <div class="container mx-auto px-4 py-8 max-w-5xl">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">Pesanan Saya</h1>
                <p class="text-sm text-muted-foreground">Kelola seluruh riwayat pemesanan hotel Anda</p>
            </div>
            <a href="{{ route('search') }}">
                <x-ui.button size="sm" class="gap-1.5">
                    <x-ui.icon name="plus" class="w-4 h-4" />
                    Pesan Hotel Baru
                </x-ui.button>
            </a>
        </div>

        @if(session('status'))
            <x-ui.alert variant="success" class="mb-6">{{ session('status') }}</x-ui.alert>
        @endif
        @if(session('error'))
            <x-ui.alert variant="destructive" class="mb-6">{{ session('error') }}</x-ui.alert>
        @endif

        {{-- Status Filter Tabs --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-2 mb-6 border-b border-border">
            @php
                $currentStatus = request('status');
                $tabs = [
                    '' => 'Semua Pesanan',
                    'pending' => 'Menunggu Bayar',
                    'paid' => 'Terkonfirmasi (Lunas)',
                    'completed' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                ];
            @endphp
            @foreach($tabs as $key => $label)
                <a
                    href="{{ $key === '' ? route('account.bookings') : route('account.bookings', ['status' => $key]) }}"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap transition-colors {{ $currentStatus === $key || ($key === '' && !$currentStatus) ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-muted hover:text-foreground' }}"
                >
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Bookings List --}}
        @if($bookings->isEmpty())
            <x-ui.card class="text-center py-16">
                <div class="w-16 h-16 bg-muted rounded-full flex items-center justify-center mx-auto mb-4 text-muted-foreground">
                    <x-ui.icon name="calendar-x" class="w-8 h-8" />
                </div>
                <h3 class="text-lg font-semibold mb-1">Belum Ada Pesanan</h3>
                <p class="text-sm text-muted-foreground max-w-sm mx-auto mb-6">
                    Anda belum memiliki riwayat pesanan dengan status ini. Temukan hotel impian Anda sekarang!
                </p>
                <a href="{{ route('search') }}">
                    <x-ui.button>Cari & Pesan Hotel</x-ui.button>
                </a>
            </x-ui.card>
        @else
            <div class="space-y-4">
                @foreach($bookings as $booking)
                    <x-ui.card class="overflow-hidden hover:border-primary/50 transition-colors">
                        <div class="flex flex-col sm:flex-row">
                            {{-- Image --}}
                            <div class="sm:w-52 h-44 sm:h-auto bg-muted shrink-0 relative overflow-hidden">
                                <img
                                    src="{{ $booking->hotel->cover_image_url }}"
                                    alt="{{ $booking->hotel->name }}"
                                    class="w-full h-full object-cover"
                                    onerror="this.src='https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&auto=format&fit=crop'"
                                >
                            </div>

                            {{-- Details --}}
                            <div class="flex-1 p-5 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-start justify-between gap-3 mb-2">
                                        <div>
                                            <p class="text-xs font-mono text-muted-foreground uppercase">{{ $booking->booking_code }}</p>
                                            <h3 class="font-bold text-base text-foreground mt-0.5">{{ $booking->hotel->name }}</h3>
                                            <p class="text-xs text-muted-foreground">{{ $booking->hotel->city->name }}</p>
                                        </div>
                                        <div>
                                            @php
                                                $badgeVariant = match($booking->status->value) {
                                                    'paid' => 'success',
                                                    'pending' => 'warning',
                                                    'cancelled', 'expired' => 'destructive',
                                                    'completed' => 'info',
                                                    default => 'secondary'
                                                };
                                                $badgeText = match($booking->status->value) {
                                                    'paid' => 'Lunas',
                                                    'pending' => 'Menunggu Bayar',
                                                    'cancelled' => 'Dibatalkan',
                                                    'expired' => 'Kedaluwarsa',
                                                    'completed' => 'Selesai',
                                                    default => ucfirst($booking->status->value)
                                                };
                                            @endphp
                                            <x-ui.badge :variant="$badgeVariant">
                                                {{ $badgeText }}
                                            </x-ui.badge>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 py-2.5 my-2 border-y border-border text-xs text-muted-foreground">
                                        <div>
                                            <span class="block text-[11px]">Tipe Kamar</span>
                                            <span class="font-medium text-foreground">{{ $booking->roomType->name }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-[11px]">Jadwal Menginap</span>
                                            <span class="font-medium text-foreground">{{ \Carbon\Carbon::parse($booking->check_in)->format('d M') }} - {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-[11px]">Kamar & Malam</span>
                                            <span class="font-medium text-foreground">{{ $booking->rooms }} Kamar ({{ $booking->nights }} Malam)</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-2">
                                    <div>
                                        <p class="text-[11px] text-muted-foreground">Total Pembayaran</p>
                                        <p class="text-base font-bold text-primary">{{ format_rupiah($booking->total) }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if($booking->isPending())
                                            <a href="{{ route('booking.payment', $booking->booking_code) }}">
                                                <x-ui.button size="sm" class="gap-1">
                                                    <x-ui.icon name="credit-card" class="w-3.5 h-3.5" />
                                                    Bayar
                                                </x-ui.button>
                                            </a>
                                        @elseif($booking->isPaid())
                                            <a href="{{ route('booking.invoice', $booking->booking_code) }}" target="_blank">
                                                <x-ui.button variant="outline" size="sm" class="gap-1">
                                                    <x-ui.icon name="file-text" class="w-3.5 h-3.5" />
                                                    E-Voucher
                                                </x-ui.button>
                                            </a>
                                        @endif

                                        <a href="{{ route('account.bookings.show', $booking->booking_code) }}">
                                            <x-ui.button variant="ghost" size="sm">
                                                Detail
                                            </x-ui.button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-ui.card>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $bookings->links('components.ui.pagination') }}
            </div>
        @endif
    </div>
</x-layouts.app>

