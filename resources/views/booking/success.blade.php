<x-layouts.app :title="'Pesanan Berhasil - ' . $booking->booking_code">
    <div class="container mx-auto px-4 py-12 max-w-2xl text-center">
        {{-- Success Icon Animation --}}
        <div class="w-20 h-20 bg-emerald-500/10 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <x-ui.icon name="check" class="w-10 h-10 stroke-[3]" />
        </div>

        <x-ui.badge variant="success" class="text-sm px-3 py-1 mb-3">Pembayaran Berhasil</x-ui.badge>
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-foreground mb-2">Terima Kasih, Pemesanan Anda Dikonfirmasi!</h1>
        <p class="text-muted-foreground text-sm max-w-md mx-auto mb-8">
            E-voucher pesanan hotel Anda telah diterbitkan. Tunjukkan e-voucher ini saat melakukan check-in di resepsionis hotel.
        </p>

        {{-- Booking Details Box --}}
        <x-ui.card class="text-left mb-8 shadow-sm">
            <x-ui.card.header class="bg-muted/30 pb-4 border-b border-border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-muted-foreground">KODE BOOKING</p>
                        <p class="text-lg font-mono font-bold text-primary">{{ $booking->booking_code }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-muted-foreground">STATUS</p>
                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                            <x-ui.icon name="check-circle" class="w-3.5 h-3.5" />
                            LUNAS
                        </span>
                    </div>
                </div>
            </x-ui.card.header>
            <x-ui.card.content class="p-5 space-y-4 text-sm">
                <div>
                    <h3 class="font-bold text-base text-foreground">{{ $booking->hotel->name }}</h3>
                    <p class="text-xs text-muted-foreground mt-0.5">{{ $booking->hotel->address }}, {{ $booking->hotel->city->name }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 py-3 border-y border-border text-xs">
                    <div>
                        <span class="text-muted-foreground block mb-0.5">Check-in</span>
                        <span class="font-semibold text-foreground text-sm">{{ \Carbon\Carbon::parse($booking->check_in)->translatedFormat('d F Y') }}</span>
                        <span class="text-muted-foreground block text-[11px]">Mulai {{ $booking->hotel->check_in_time ?? '14:00' }} WIB</span>
                    </div>
                    <div>
                        <span class="text-muted-foreground block mb-0.5">Check-out</span>
                        <span class="font-semibold text-foreground text-sm">{{ \Carbon\Carbon::parse($booking->check_out)->translatedFormat('d F Y') }}</span>
                        <span class="text-muted-foreground block text-[11px]">Sebelum {{ $booking->hotel->check_out_time ?? '12:00' }} WIB</span>
                    </div>
                </div>

                <div class="space-y-1.5 text-xs text-muted-foreground">
                    <div class="flex justify-between">
                        <span>Tipe Kamar:</span>
                        <span class="font-medium text-foreground">{{ $booking->roomType->name }} ({{ $booking->rooms }} kamar)</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Nama Tamu:</span>
                        <span class="font-medium text-foreground">{{ $booking->guest_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Total Dibayar:</span>
                        <span class="font-bold text-primary text-sm">{{ format_rupiah($booking->total) }}</span>
                    </div>
                </div>
            </x-ui.card.content>
        </x-ui.card>

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('booking.invoice', $booking->booking_code) }}" target="_blank" class="w-full sm:w-auto">
                <x-ui.button class="w-full sm:w-auto gap-2">
                    <x-ui.icon name="file-text" class="w-4 h-4" />
                    Cetak / Unduh E-Voucher
                </x-ui.button>
            </a>
            <a href="{{ route('account.bookings') }}" class="w-full sm:w-auto">
                <x-ui.button variant="outline" class="w-full sm:w-auto gap-2">
                    <x-ui.icon name="calendar" class="w-4 h-4" />
                    Lihat Pesanan Saya
                </x-ui.button>
            </a>
            <a href="{{ route('home') }}" class="w-full sm:w-auto">
                <x-ui.button variant="ghost" class="w-full sm:w-auto">
                    Kembali ke Beranda
                </x-ui.button>
            </a>
        </div>
    </div>
</x-layouts.app>

