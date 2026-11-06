<x-layouts.app :title="'Detail Pesanan - ' . $booking->booking_code">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm text-muted-foreground mb-6">
            <a href="{{ route('home') }}" class="hover:text-foreground">Beranda</a>
            <x-ui.icon name="chevron-right" class="w-4 h-4" />
            <a href="{{ route('account.bookings') }}" class="hover:text-foreground">Pesanan Saya</a>
            <x-ui.icon name="chevron-right" class="w-4 h-4" />
            <span class="text-foreground font-mono font-medium">{{ $booking->booking_code }}</span>
        </div>

        @if(session('status'))
            <x-ui.alert variant="success" class="mb-6">{{ session('status') }}</x-ui.alert>
        @endif
        @if(session('error'))
            <x-ui.alert variant="destructive" class="mb-6">{{ session('error') }}</x-ui.alert>
        @endif

        <div class="space-y-6">
            {{-- Header Card --}}
            <x-ui.card>
                <x-ui.card.content class="p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <span class="text-xs font-mono text-muted-foreground uppercase">KODE PESANAN: {{ $booking->booking_code }}</span>
                            <h1 class="text-xl sm:text-2xl font-bold tracking-tight mt-1">{{ $booking->hotel->name }}</h1>
                            <p class="text-xs text-muted-foreground mt-0.5">{{ $booking->hotel->address }}, {{ $booking->hotel->city->name }}</p>
                        </div>
                        <div class="flex flex-col sm:items-end gap-2">
                            @php
                                $badgeVariant = match($booking->status->value) {
                                    'paid' => 'success',
                                    'pending' => 'warning',
                                    'cancelled', 'expired' => 'destructive',
                                    'completed' => 'info',
                                    default => 'secondary'
                                };
                                $badgeText = match($booking->status->value) {
                                    'paid' => 'Lunas & Terkonfirmasi',
                                    'pending' => 'Menunggu Pembayaran',
                                    'cancelled' => 'Dibatalkan',
                                    'expired' => 'Kedaluwarsa',
                                    'completed' => 'Selesai',
                                    default => ucfirst($booking->status->value)
                                };
                            @endphp
                            <x-ui.badge :variant="$badgeVariant" class="text-sm px-3 py-1">
                                {{ $badgeText }}
                            </x-ui.badge>
                            <span class="text-xs text-muted-foreground">
                                Dipesan pada {{ $booking->created_at->translatedFormat('d F Y H:i') }} WIB
                            </span>
                        </div>
                    </div>
                </x-ui.card.content>
            </x-ui.card>

            {{-- Room & Stay Details --}}
            <x-ui.card>
                <x-ui.card.header>
                    <x-ui.card.title class="text-base flex items-center gap-2">
                        <x-ui.icon name="calendar" class="w-4 h-4 text-primary" />
                        Jadwal & Detail Kamar
                    </x-ui.card.title>
                </x-ui.card.header>
                <x-ui.card.content class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-muted/30 rounded-xl text-xs">
                        <div>
                            <span class="text-muted-foreground block mb-1">Check-in</span>
                            <span class="font-bold text-foreground text-sm">{{ \Carbon\Carbon::parse($booking->check_in)->translatedFormat('l, d F Y') }}</span>
                            <span class="text-muted-foreground block">Mulai {{ $booking->hotel->check_in_time ?? '14:00' }} WIB</span>
                        </div>
                        <div>
                            <span class="text-muted-foreground block mb-1">Check-out</span>
                            <span class="font-bold text-foreground text-sm">{{ \Carbon\Carbon::parse($booking->check_out)->translatedFormat('l, d F Y') }}</span>
                            <span class="text-muted-foreground block">Sebelum {{ $booking->hotel->check_out_time ?? '12:00' }} WIB</span>
                        </div>
                    </div>

                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between py-1 border-b border-border">
                            <span class="text-muted-foreground">Tipe Kamar:</span>
                            <span class="font-semibold text-foreground">{{ $booking->roomType->name }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-border">
                            <span class="text-muted-foreground">Jumlah Kamar:</span>
                            <span class="font-semibold text-foreground">{{ $booking->rooms }} Kamar</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-border">
                            <span class="text-muted-foreground">Jumlah Tamu:</span>
                            <span class="font-semibold text-foreground">{{ $booking->guests }} Orang</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-border">
                            <span class="text-muted-foreground">Nama Tamu Utama:</span>
                            <span class="font-semibold text-foreground">{{ $booking->guest_name }} ({{ $booking->guest_phone }})</span>
                        </div>
                        @if($booking->special_request)
                            <div class="flex justify-between py-1 border-b border-border">
                                <span class="text-muted-foreground">Permintaan Khusus:</span>
                                <span class="font-medium text-foreground italic">"{{ $booking->special_request }}"</span>
                            </div>
                        @endif
                    </div>
                </x-ui.card.content>
            </x-ui.card>

            {{-- Payment Breakdown Card --}}
            <x-ui.card>
                <x-ui.card.header>
                    <x-ui.card.title class="text-base flex items-center gap-2">
                        <x-ui.icon name="credit-card" class="w-4 h-4 text-primary" />
                        Rincian Biaya
                    </x-ui.card.title>
                </x-ui.card.header>
                <x-ui.card.content class="space-y-2 text-xs">
                    <div class="flex justify-between text-muted-foreground">
                        <span>Biaya Kamar ({{ $booking->nights }} malam x {{ $booking->rooms }} kamar)</span>
                        <span>{{ format_rupiah($booking->subtotal) }}</span>
                    </div>
                    <div class="flex justify-between text-muted-foreground">
                        <span>Pajak Daerah (10%)</span>
                        <span>{{ format_rupiah($booking->tax) }}</span>
                    </div>
                    <div class="flex justify-between text-muted-foreground">
                        <span>Biaya Layanan</span>
                        <span>{{ format_rupiah($booking->service_fee) }}</span>
                    </div>
                    @if($booking->discount > 0)
                        <div class="flex justify-between text-emerald-600 dark:text-emerald-400 font-semibold">
                            <span>Diskon Voucher ({{ $booking->voucher?->code }})</span>
                            <span>- {{ format_rupiah($booking->discount) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-base font-bold text-foreground pt-3 border-t border-border">
                        <span>Total Pembayaran</span>
                        <span class="text-primary text-lg">{{ format_rupiah($booking->total) }}</span>
                    </div>
                </x-ui.card.content>
            </x-ui.card>

            {{-- Actions / Buttons --}}
            <div class="flex flex-wrap items-center justify-between gap-4 pt-2">
                <div class="flex flex-wrap items-center gap-2">
                    @if($booking->isPaid())
                        <a href="{{ route('booking.invoice', $booking->booking_code) }}" target="_blank">
                            <x-ui.button class="gap-1.5">
                                <x-ui.icon name="file-text" class="w-4 h-4" />
                                Cetak E-Voucher (PDF)
                            </x-ui.button>
                        </a>
                    @elseif($booking->isPending())
                        <a href="{{ route('booking.payment', $booking->booking_code) }}">
                            <x-ui.button class="gap-1.5">
                                <x-ui.icon name="credit-card" class="w-4 h-4" />
                                Bayar Sekarang
                            </x-ui.button>
                        </a>
                    @endif

                    @if($booking->canBeCancelled())
                        <form action="{{ route('account.bookings.cancel', $booking->booking_code) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                            @csrf
                            <x-ui.button type="submit" variant="destructive" size="default" class="gap-1.5">
                                <x-ui.icon name="x-circle" class="w-4 h-4" />
                                Batalkan Pesanan
                            </x-ui.button>
                        </form>
                    @endif
                </div>

                <a href="{{ route('account.bookings') }}">
                    <x-ui.button variant="ghost">
                        &larr; Kembali ke Daftar
                    </x-ui.button>
                </a>
            </div>

            {{-- Write Review Section (If Paid & Not yet reviewed) --}}
            @if($booking->isPaid())
                @php
                    $existingReview = \App\Models\Review::where('booking_id', $booking->id)->first();
                @endphp

                <x-ui.card class="border-primary/30 mt-8">
                    <x-ui.card.header>
                        <x-ui.card.title class="text-base flex items-center gap-2">
                            <x-ui.icon name="star" class="w-4 h-4 text-amber-500" />
                            Ulasan Anda untuk Hotel Ini
                        </x-ui.card.title>
                    </x-ui.card.header>
                    <x-ui.card.content>
                        @if($existingReview)
                            <div class="p-4 bg-muted/40 rounded-xl space-y-2">
                                <div class="flex items-center text-amber-400 text-sm">
                                    @for($i = 0; $i < $existingReview->rating; $i++) ★ @endfor
                                    <span class="text-xs text-muted-foreground ml-2">Rating {{ $existingReview->rating }}/5</span>
                                </div>
                                <p class="text-sm text-foreground">"{{ $existingReview->comment }}"</p>
                                <p class="text-xs text-muted-foreground">Ditulis pada {{ $existingReview->created_at->translatedFormat('d M Y') }}</p>
                            </div>
                        @else
                            <form action="{{ route('hotels.reviews.store', $booking->hotel_id) }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                                <div class="space-y-1.5">
                                    <x-ui.label for="rating">Rating Bintang (1 - 5)</x-ui.label>
                                    <select name="rating" id="rating" class="h-10 px-3 rounded-lg border border-input bg-background text-sm focus:outline-none focus:ring-2 focus:ring-ring" required>
                                        <option value="5">⭐⭐⭐⭐⭐ 5 Bintang (Luar Biasa)</option>
                                        <option value="4">⭐⭐⭐⭐ 4 Bintang (Sangat Bagus)</option>
                                        <option value="3">⭐⭐⭐ 3 Bintang (Cukup)</option>
                                        <option value="2">⭐⭐ 2 Bintang (Kurang Memuaskan)</option>
                                        <option value="1">⭐ 1 Bintang (Buruk)</option>
                                    </select>
                                </div>

                                <div class="space-y-1.5">
                                    <x-ui.label for="comment">Pengalaman Menginap Anda</x-ui.label>
                                    <x-ui.textarea name="comment" id="comment" rows="3" placeholder="Ceritakan kebersihan kamar, pelayanan staf, fasilitas, dan kenyamanan lokasi..." required minlength="10" maxlength="1000"></x-ui.textarea>
                                </div>

                                <x-ui.button type="submit" size="sm" class="gap-1.5">
                                    <x-ui.icon name="send" class="w-4 h-4" />
                                    Kirim Ulasan
                                </x-ui.button>
                            </form>
                        @endif
                    </x-ui.card.content>
                </x-ui.card>
            @endif
        </div>
    </div>
</x-layouts.app>

