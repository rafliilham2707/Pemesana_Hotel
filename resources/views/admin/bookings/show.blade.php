<x-layouts.admin :title="'Detail Pesanan - ' . $booking->booking_code">
    <div class="max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <span class="text-xs font-mono text-muted-foreground uppercase">{{ $booking->booking_code }}</span>
                <h1 class="text-2xl font-bold tracking-tight">Detail Pesanan Tamu</h1>
            </div>
            <a href="{{ route('admin.bookings.index') }}">
                <x-ui.button variant="ghost" size="sm">&larr; Kembali ke Daftar</x-ui.button>
            </a>
        </div>

        @if(session('status'))
            <x-ui.alert variant="success">{{ session('status') }}</x-ui.alert>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Main Column (Col 1 & 2) --}}
            <div class="md:col-span-2 space-y-6">
                {{-- Hotel & Room Info --}}
                <x-ui.card>
                    <x-ui.card.header class="pb-3">
                        <x-ui.card.title class="text-base flex items-center gap-2">
                            <x-ui.icon name="hotel" class="w-4 h-4 text-primary" />
                            Properti & Kamar
                        </x-ui.card.title>
                    </x-ui.card.header>
                    <x-ui.card.content class="space-y-3 text-xs">
                        <div>
                            <p class="font-bold text-foreground text-sm">{{ $booking->hotel->name }}</p>
                            <p class="text-muted-foreground">{{ $booking->hotel->address }}, {{ $booking->hotel->city->name }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4 p-3 bg-muted/40 rounded-lg">
                            <div>
                                <span class="text-muted-foreground block">Check-in</span>
                                <span class="font-bold text-foreground">{{ \Carbon\Carbon::parse($booking->check_in)->translatedFormat('d F Y') }}</span>
                            </div>
                            <div>
                                <span class="text-muted-foreground block">Check-out</span>
                                <span class="font-bold text-foreground">{{ \Carbon\Carbon::parse($booking->check_out)->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>
                        <div class="space-y-1.5 pt-1">
                            <div class="flex justify-between">
                                <span class="text-muted-foreground">Tipe Kamar:</span>
                                <span class="font-semibold">{{ $booking->roomType->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-muted-foreground">Jumlah Kamar & Durasi:</span>
                                <span>{{ $booking->rooms }} Kamar, {{ $booking->nights }} Malam ({{ $booking->guests }} Tamu)</span>
                            </div>
                            @if($booking->special_request)
                                <div class="flex justify-between">
                                    <span class="text-muted-foreground">Permintaan Khusus:</span>
                                    <span class="italic">"{{ $booking->special_request }}"</span>
                                </div>
                            @endif
                        </div>
                    </x-ui.card.content>
                </x-ui.card>

                {{-- Guest Details --}}
                <x-ui.card>
                    <x-ui.card.header class="pb-3">
                        <x-ui.card.title class="text-base flex items-center gap-2">
                            <x-ui.icon name="user" class="w-4 h-4 text-primary" />
                            Data Tamu & Pemesan
                        </x-ui.card.title>
                    </x-ui.card.header>
                    <x-ui.card.content class="space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-muted-foreground">Nama Tamu:</span>
                            <span class="font-semibold text-foreground">{{ $booking->guest_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-muted-foreground">Email:</span>
                            <span>{{ $booking->guest_email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-muted-foreground">Nomor Telepon:</span>
                            <span>{{ $booking->guest_phone }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-muted-foreground">Akun User:</span>
                            <span>{{ $booking->user->name }} (ID: {{ $booking->user_id }})</span>
                        </div>
                    </x-ui.card.content>
                </x-ui.card>

                {{-- Payment Details --}}
                <x-ui.card>
                    <x-ui.card.header class="pb-3">
                        <x-ui.card.title class="text-base flex items-center gap-2">
                            <x-ui.icon name="credit-card" class="w-4 h-4 text-primary" />
                            Rincian Pembayaran
                        </x-ui.card.title>
                    </x-ui.card.header>
                    <x-ui.card.content class="space-y-2 text-xs">
                        <div class="flex justify-between text-muted-foreground">
                            <span>Biaya Kamar:</span>
                            <span>{{ format_rupiah($booking->subtotal) }}</span>
                        </div>
                        <div class="flex justify-between text-muted-foreground">
                            <span>Pajak (10%):</span>
                            <span>{{ format_rupiah($booking->tax) }}</span>
                        </div>
                        <div class="flex justify-between text-muted-foreground">
                            <span>Biaya Layanan:</span>
                            <span>{{ format_rupiah($booking->service_fee) }}</span>
                        </div>
                        @if($booking->discount > 0)
                            <div class="flex justify-between text-emerald-600 font-semibold">
                                <span>Diskon Voucher ({{ $booking->voucher?->code }}):</span>
                                <span>- {{ format_rupiah($booking->discount) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between font-bold text-sm text-foreground pt-2 border-t border-border">
                            <span>Total Tagihan:</span>
                            <span class="text-primary text-base">{{ format_rupiah($booking->total) }}</span>
                        </div>
                    </x-ui.card.content>
                </x-ui.card>
            </div>

            {{-- Sidebar Column (Actions & Status) --}}
            <div class="space-y-6">
                <x-ui.card>
                    <x-ui.card.header class="pb-3">
                        <x-ui.card.title class="text-sm">Status & Otorisasi</x-ui.card.title>
                    </x-ui.card.header>
                    <x-ui.card.content class="space-y-4 text-xs">
                        <div>
                            <span class="text-muted-foreground block mb-1">Status Pesanan:</span>
                            <x-ui.badge :variant="$booking->status->value === 'paid' ? 'success' : ($booking->status->value === 'pending' ? 'warning' : 'secondary')" class="text-sm px-3 py-1">
                                {{ ucfirst($booking->status->value) }}
                            </x-ui.badge>
                        </div>

                        <div class="space-y-1 text-muted-foreground">
                            <p>Waktu Booking: {{ $booking->created_at->translatedFormat('d M Y H:i') }}</p>
                            @if($booking->isPending())
                                <p class="text-destructive font-medium">Batas Waktu: {{ $booking->expires_at->translatedFormat('d M Y H:i') }}</p>
                            @endif
                        </div>

                        <div class="pt-3 border-t border-border space-y-2">
                            @if($booking->isPending())
                                <form action="{{ route('admin.bookings.confirm-payment', $booking->booking_code) }}" method="POST">
                                    @csrf
                                    <x-ui.button type="submit" class="w-full text-xs h-9 bg-emerald-600 hover:bg-emerald-700 text-white">
                                        Konfirmasi Lunas Manual
                                    </x-ui.button>
                                </form>
                            @endif

                            @if($booking->isPaid())
                                <a href="{{ route('booking.invoice', $booking->booking_code) }}" target="_blank" class="block">
                                    <x-ui.button variant="outline" class="w-full text-xs h-9">
                                        Cetak E-Voucher
                                    </x-ui.button>
                                </a>

                                <form action="{{ route('admin.bookings.complete', $booking->booking_code) }}" method="POST">
                                    @csrf
                                    <x-ui.button type="submit" variant="secondary" class="w-full text-xs h-9">
                                        Tandai Selesai (Check-out)
                                    </x-ui.button>
                                </form>
                            @endif

                            @if(!in_array($booking->status->value, ['cancelled', 'expired']))
                                <form action="{{ route('admin.bookings.cancel', $booking->booking_code) }}" method="POST" onsubmit="return confirm('Batalkan pesanan ini dan kembalikan stok kamar?')">
                                    @csrf
                                    <x-ui.button type="submit" variant="destructive" class="w-full text-xs h-9">
                                        Batalkan Pesanan
                                    </x-ui.button>
                                </form>
                            @endif
                        </div>
                    </x-ui.card.content>
                </x-ui.card>
            </div>
        </div>
    </div>
</x-layouts.admin>

