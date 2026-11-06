<x-layouts.app :title="'Instruksi Pembayaran - ' . $booking->booking_code">
    <div class="container mx-auto px-4 py-8 max-w-4xl" x-data="paymentCountdown('{{ $booking->expires_at->toIso8601String() }}')">
        {{-- Header Status --}}
        <div class="text-center mb-8">
            <x-ui.badge variant="warning" class="text-sm px-3 py-1 mb-3">
                <x-ui.icon name="clock" class="w-4 h-4 mr-1.5 animate-spin" />
                Menunggu Pembayaran
            </x-ui.badge>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">Selesaikan Pembayaran Anda</h1>
            <p class="text-muted-foreground text-sm mt-1">
                Batas waktu pembayaran tersisa:
            </p>
            {{-- Countdown Display --}}
            <div class="flex items-center justify-center gap-2 mt-3 font-mono font-bold text-xl text-destructive bg-destructive/10 inline-flex px-4 py-2 rounded-xl">
                <span x-text="hours">00</span>:<span x-text="minutes">00</span>:<span x-text="seconds">00</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Payment Instruction (Left Col 1 & 2) --}}
            <div class="md:col-span-2 space-y-6">
                {{-- Payment Method Box --}}
                <x-ui.card>
                    <x-ui.card.header>
                        <x-ui.card.title class="text-base flex items-center gap-2">
                            <x-ui.icon name="credit-card" class="w-4 h-4 text-primary" />
                            Instruksi Pembayaran
                        </x-ui.card.title>
                    </x-ui.card.header>
                    <x-ui.card.content class="space-y-4">
                        @php
                            $method = $booking->payment->method->value ?? 'bank_transfer';
                        @endphp

                        @if($method === 'qris')
                            <div class="text-center p-6 bg-muted/40 rounded-xl space-y-3">
                                <p class="text-xs text-muted-foreground font-semibold uppercase">Scan Kode QRIS</p>
                                <div class="inline-block p-4 bg-white rounded-xl shadow-sm border border-border">
                                    {{-- Realistic SVG QR Placeholder --}}
                                    <svg class="w-48 h-48 mx-auto" viewBox="0 0 100 100" fill="currentColor">
                                        <rect width="100" height="100" fill="#fff" />
                                        <path d="M10,10 h30 v30 h-30 z M15,15 v20 h20 v-20 z M22,22 h6 v6 h-6 z" fill="#000" />
                                        <path d="M60,10 h30 v30 h-30 z M65,15 v20 h20 v-20 z M72,22 h6 v6 h-6 z" fill="#000" />
                                        <path d="M10,60 h30 v30 h-30 z M15,65 v20 h20 v-20 z M22,72 h6 v6 h-6 z" fill="#000" />
                                        <path d="M45,10 h10 v20 h-10 z M45,45 h10 v10 h-10 z M60,60 h10 v20 h-10 z M75,45 h15 v10 h-15 z M75,75 h15 v15 h-15 z" fill="#000" />
                                    </svg>
                                </div>
                                <p class="text-xs text-muted-foreground">Buka aplikasi e-wallet / mobile banking Anda dan scan QR di atas</p>
                            </div>
                        @else
                            <div class="p-4 bg-muted/40 rounded-xl space-y-3">
                                <div class="flex items-center justify-between text-xs text-muted-foreground">
                                    <span>Bank Virtual Account</span>
                                    <span class="font-semibold text-foreground">BCA / Mandiri / BRI</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-background rounded-lg border border-border">
                                    <div>
                                        <p class="text-xs text-muted-foreground">Nomor Virtual Account</p>
                                        <p class="text-lg font-mono font-bold tracking-wider text-primary">88019{{ str_pad($booking->id, 8, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                    <button
                                        onclick="navigator.clipboard.writeText('88019{{ str_pad($booking->id, 8, '0', STR_PAD_LEFT) }}').then(() => alert('Nomor VA disalin!'))"
                                        class="px-3 py-1.5 text-xs font-semibold rounded-md border border-input hover:bg-muted"
                                    >
                                        Salin
                                    </button>
                                </div>
                            </div>
                        @endif

                        <div class="p-3 bg-muted/40 rounded-lg flex items-center justify-between text-sm">
                            <span class="text-muted-foreground text-xs">Total Pembayaran:</span>
                            <span class="font-bold text-lg text-primary">{{ format_rupiah($booking->total) }}</span>
                        </div>
                    </x-ui.card.content>
                </x-ui.card>

                {{-- Action / Simulation Box --}}
                <x-ui.card class="border-primary/30 bg-primary/5">
                    <x-ui.card.content class="p-5 text-center space-y-4">
                        <div>
                            <h3 class="font-bold text-base text-foreground">Simulasi Pembayaran (Sandbox/Demo)</h3>
                            <p class="text-xs text-muted-foreground mt-1">
                                Klik tombol di bawah ini untuk mensimulasikan pembayaran lunas secara instan tanpa gateway nyata.
                            </p>
                        </div>

                        <form action="{{ route('booking.pay', $booking->booking_code) }}" method="POST">
                            @csrf
                            <input type="hidden" name="method" value="{{ $booking->payment->method->value ?? 'bank_transfer' }}">
                            <x-ui.button type="submit" class="w-full h-11 text-sm font-semibold shadow-md">
                                <x-ui.icon name="check-circle-2" class="w-4 h-4 mr-2" />
                                Bayar Sekarang (Simulasi Berhasil)
                            </x-ui.button>
                        </form>
                    </x-ui.card.content>
                </x-ui.card>
            </div>

            {{-- Summary Card (Right Col 3) --}}
            <div class="space-y-6">
                <x-ui.card>
                    <x-ui.card.header class="pb-3">
                        <x-ui.card.title class="text-sm font-semibold">Ringkasan Pesanan</x-ui.card.title>
                    </x-ui.card.header>
                    <x-ui.card.content class="space-y-3 text-xs">
                        <div class="border-b border-border pb-3">
                            <p class="font-semibold text-foreground text-sm">{{ $booking->hotel->name }}</p>
                            <p class="text-muted-foreground">{{ $booking->roomType->name }}</p>
                        </div>

                        <div class="space-y-1.5 text-muted-foreground">
                            <div class="flex justify-between">
                                <span>Kode Pesanan:</span>
                                <span class="font-mono font-medium text-foreground">{{ $booking->booking_code }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Check-in:</span>
                                <span class="font-medium text-foreground">{{ \Carbon\Carbon::parse($booking->check_in)->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Check-out:</span>
                                <span class="font-medium text-foreground">{{ \Carbon\Carbon::parse($booking->check_out)->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Durasi:</span>
                                <span class="font-medium text-foreground">{{ $booking->nights }} Malam, {{ $booking->rooms }} Kamar</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Nama Tamu:</span>
                                <span class="font-medium text-foreground">{{ $booking->guest_name }}</span>
                            </div>
                        </div>

                        <x-ui.separator class="my-2" />

                        <div class="flex justify-between text-sm font-bold text-foreground">
                            <span>Total Bayar:</span>
                            <span class="text-primary">{{ format_rupiah($booking->total) }}</span>
                        </div>
                    </x-ui.card.content>
                </x-ui.card>
            </div>
        </div>
    </div>
</x-layouts.app>

@push('scripts')
<script>
function paymentCountdown(expiryIso) {
    return {
        expiryTime: new Date(expiryIso).getTime(),
        hours: '00',
        minutes: '00',
        seconds: '00',
        init() {
            this.update();
            setInterval(() => this.update(), 1000);
        },
        update() {
            const now = new Date().getTime();
            const diff = this.expiryTime - now;

            if (diff <= 0) {
                this.hours = '00';
                this.minutes = '00';
                this.seconds = '00';
                return;
            }

            const h = Math.floor((diff / (1000 * 60 * 60)));
            const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const s = Math.floor((diff % (1000 * 60)) / 1000);

            this.hours = String(h).padStart(2, '0');
            this.minutes = String(m).padStart(2, '0');
            this.seconds = String(s).padStart(2, '0');
        }
    }
}
</script>
@endpush

