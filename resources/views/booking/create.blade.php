<x-layouts.app :title="'Form Pemesanan Hotel'">
    <div class="container mx-auto px-4 py-8">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm text-muted-foreground mb-6">
            <a href="{{ route('home') }}" class="hover:text-foreground">Beranda</a>
            <x-ui.icon name="chevron-right" class="w-4 h-4" />
            <a href="{{ route('hotels.show', $roomType->hotel->slug) }}" class="hover:text-foreground truncate max-w-[200px]">{{ $roomType->hotel->name }}</a>
            <x-ui.icon name="chevron-right" class="w-4 h-4" />
            <span class="text-foreground font-medium">Pemesanan</span>
        </div>

        @if(session('error'))
            <x-ui.alert variant="destructive" class="mb-6">
                {{ session('error') }}
            </x-ui.alert>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-data="bookingForm({{ $subtotal }}, {{ $tax }}, {{ $serviceFee }})">
            {{-- Form Details (Col 1 & 2) --}}
            <div class="lg:col-span-2 space-y-6">
                <form action="{{ route('booking.store') }}" method="POST" id="booking-form" class="space-y-6">
                    @csrf
                    <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">
                    <input type="hidden" name="check_in" value="{{ $checkIn }}">
                    <input type="hidden" name="check_out" value="{{ $checkOut }}">
                    <input type="hidden" name="rooms" value="{{ $rooms }}">
                    <input type="hidden" name="guests" value="{{ $guests }}">
                    <input type="hidden" name="voucher_code" :value="appliedVoucher ? appliedVoucher.code : ''">

                    {{-- Data Pemesan --}}
                    <x-ui.card>
                        <x-ui.card.header>
                            <x-ui.card.title class="text-lg flex items-center gap-2">
                                <x-ui.icon name="user" class="w-5 h-5 text-primary" />
                                Data Kontak Pemesan
                            </x-ui.card.title>
                            <x-ui.card.description>E-voucher dan konfirmasi pesanan akan dikirimkan ke kontak ini</x-ui.card.description>
                        </x-ui.card.header>
                        <x-ui.card.content class="space-y-4">
                            <div class="space-y-2">
                                <x-ui.label for="guest_name">Nama Lengkap Tamu <span class="text-destructive">*</span></x-ui.label>
                                <x-ui.input
                                    id="guest_name"
                                    name="guest_name"
                                    type="text"
                                    :value="old('guest_name', auth()->user()->name)"
                                    placeholder="Sesuai KTP / Paspor"
                                    required
                                />
                                @error('guest_name')
                                    <p class="text-xs text-destructive">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <x-ui.label for="guest_email">Alamat Email <span class="text-destructive">*</span></x-ui.label>
                                    <x-ui.input
                                        id="guest_email"
                                        name="guest_email"
                                        type="email"
                                        :value="old('guest_email', auth()->user()->email)"
                                        placeholder="nama@email.com"
                                        required
                                    />
                                    @error('guest_email')
                                        <p class="text-xs text-destructive">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <x-ui.label for="guest_phone">Nomor WhatsApp / Telepon <span class="text-destructive">*</span></x-ui.label>
                                    <x-ui.input
                                        id="guest_phone"
                                        name="guest_phone"
                                        type="tel"
                                        :value="old('guest_phone', auth()->user()->phone ?? '08123456789')"
                                        placeholder="08xxxxxxxxxx"
                                        required
                                    />
                                    @error('guest_phone')
                                        <p class="text-xs text-destructive">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-2">
                                <x-ui.label for="special_request">Permintaan Khusus <span class="text-muted-foreground font-normal">(opsional)</span></x-ui.label>
                                <x-ui.textarea
                                    id="special_request"
                                    name="special_request"
                                    rows="3"
                                    placeholder="Contoh: Bebas asap rokok, lantai atas, check-in lebih awal, ranjang dobel."
                                >{{ old('special_request') }}</x-ui.textarea>
                                <p class="text-xs text-muted-foreground">Permintaan khusus tergantung pada ketersediaan saat check-in.</p>
                            </div>
                        </x-ui.card.content>
                    </x-ui.card>

                    {{-- Metode Pembayaran --}}
                    <x-ui.card>
                        <x-ui.card.header>
                            <x-ui.card.title class="text-lg flex items-center gap-2">
                                <x-ui.icon name="credit-card" class="w-5 h-5 text-primary" />
                                Metode Pembayaran
                            </x-ui.card.title>
                            <x-ui.card.description>Pilih metode pembayaran yang Anda inginkan</x-ui.card.description>
                        </x-ui.card.header>
                        <x-ui.card.content class="space-y-3">
                            <label class="flex items-center justify-between p-3.5 rounded-lg border border-border cursor-pointer hover:bg-muted/40 transition-colors" :class="paymentMethod === 'bank_transfer' ? 'border-primary ring-1 ring-primary bg-primary/5' : ''">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="bank_transfer" x-model="paymentMethod" class="text-primary">
                                    <div>
                                        <p class="font-medium text-sm">Transfer Virtual Account (BCA / Mandiri / BRI / BNI)</p>
                                        <p class="text-xs text-muted-foreground">Verifikasi otomatis 24 jam</p>
                                    </div>
                                </div>
                                <x-ui.icon name="building-2" class="w-5 h-5 text-muted-foreground" />
                            </label>

                            <label class="flex items-center justify-between p-3.5 rounded-lg border border-border cursor-pointer hover:bg-muted/40 transition-colors" :class="paymentMethod === 'qris' ? 'border-primary ring-1 ring-primary bg-primary/5' : ''">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="qris" x-model="paymentMethod" class="text-primary">
                                    <div>
                                        <p class="font-medium text-sm">QRIS (GoPay, OVO, Dana, ShopeePay, BCA Mobile)</p>
                                        <p class="text-xs text-muted-foreground">Scan kode QR instan</p>
                                    </div>
                                </div>
                                <x-ui.icon name="qr-code" class="w-5 h-5 text-muted-foreground" />
                            </label>

                            <label class="flex items-center justify-between p-3.5 rounded-lg border border-border cursor-pointer hover:bg-muted/40 transition-colors" :class="paymentMethod === 'credit_card' ? 'border-primary ring-1 ring-primary bg-primary/5' : ''">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="credit_card" x-model="paymentMethod" class="text-primary">
                                    <div>
                                        <p class="font-medium text-sm">Kartu Kredit / Debit Online (Visa, Mastercard, JCB)</p>
                                        <p class="text-xs text-muted-foreground">Pembayaran aman dengan 3D Secure</p>
                                    </div>
                                </div>
                                <x-ui.icon name="credit-card" class="w-5 h-5 text-muted-foreground" />
                            </label>
                        </x-ui.card.content>
                    </x-ui.card>

                    <div class="pt-2">
                        <x-ui.button type="submit" class="w-full h-12 text-base font-semibold shadow-md">
                            Lanjut ke Pembayaran &rarr;
                        </x-ui.button>
                        <p class="text-xs text-center text-muted-foreground mt-2">
                            Dengan mengklik tombol ini, Anda menyetujui Kebijakan Privasi dan Syarat & Ketentuan StayHub.
                        </p>
                    </div>
                </form>
            </div>

            {{-- Booking Summary (Col 3) --}}
            <div class="space-y-6">
                {{-- Hotel Info Card --}}
                <x-ui.card class="overflow-hidden">
                    <div class="h-32 bg-muted relative">
                        <img
                            src="{{ $roomType->hotel->cover_image_url }}"
                            alt="{{ $roomType->hotel->name }}"
                            class="w-full h-full object-cover"
                            onerror="this.src='https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&auto=format&fit=crop'"
                        >
                    </div>
                    <x-ui.card.content class="p-4 space-y-4">
                        <div>
                            <h3 class="font-bold text-base text-foreground">{{ $roomType->hotel->name }}</h3>
                            <p class="text-xs text-muted-foreground mt-0.5 flex items-center gap-1">
                                <x-ui.icon name="map-pin" class="w-3.5 h-3.5 text-primary shrink-0" />
                                {{ $roomType->hotel->city->name }}
                            </p>
                        </div>

                        <div class="p-3 bg-muted/40 rounded-lg space-y-1.5 text-xs">
                            <div class="flex justify-between">
                                <span class="text-muted-foreground">Tipe Kamar:</span>
                                <span class="font-semibold text-foreground">{{ $roomType->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-muted-foreground">Check-in:</span>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($checkIn)->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-muted-foreground">Check-out:</span>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($checkOut)->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-muted-foreground">Durasi & Unit:</span>
                                <span class="font-medium">{{ $nights }} malam, {{ $rooms }} kamar ({{ $guests }} tamu)</span>
                            </div>
                        </div>

                        {{-- Voucher Code Box --}}
                        <div class="pt-2 border-t border-border">
                            <label class="block text-xs font-semibold text-muted-foreground uppercase mb-1.5">Kupon / Voucher Promo</label>
                            <div class="flex gap-2">
                                <input
                                    type="text"
                                    x-model="voucherInput"
                                    placeholder="Contoh: STAYHEMAT20"
                                    class="h-9 flex-1 px-3 rounded-md border border-input bg-background text-xs uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-ring"
                                    :disabled="appliedVoucher !== null"
                                >
                                <template x-if="!appliedVoucher">
                                    <button
                                        type="button"
                                        @click="applyVoucher()"
                                        :disabled="loadingVoucher || !voucherInput"
                                        class="h-9 px-3 bg-primary text-primary-foreground text-xs font-semibold rounded-md hover:bg-primary/90 transition-colors disabled:opacity-50"
                                    >
                                        <span x-show="!loadingVoucher">Gunakan</span>
                                        <span x-show="loadingVoucher" style="display: none;">Cek...</span>
                                    </button>
                                </template>
                                <template x-if="appliedVoucher">
                                    <button
                                        type="button"
                                        @click="removeVoucher()"
                                        class="h-9 px-3 bg-destructive text-destructive-foreground text-xs font-semibold rounded-md hover:bg-destructive/90 transition-colors"
                                    >
                                        Hapus
                                    </button>
                                </template>
                            </div>
                            <template x-if="voucherMessage">
                                <p class="text-xs mt-1.5" :class="voucherValid ? 'text-emerald-600 dark:text-emerald-400' : 'text-destructive'" x-text="voucherMessage"></p>
                            </template>
                        </div>

                        {{-- Price Breakdown --}}
                        <div class="pt-3 border-t border-border space-y-2 text-sm">
                            <div class="flex justify-between text-muted-foreground text-xs">
                                <span>Harga Kamar ({{ $nights }} malam)</span>
                                <span>{{ format_rupiah($subtotal) }}</span>
                            </div>
                            <div class="flex justify-between text-muted-foreground text-xs">
                                <span>Pajak Daerah (10%)</span>
                                <span>{{ format_rupiah($tax) }}</span>
                            </div>
                            <div class="flex justify-between text-muted-foreground text-xs">
                                <span>Biaya Layanan</span>
                                <span>{{ format_rupiah($serviceFee) }}</span>
                            </div>
                            <template x-if="discount > 0">
                                <div class="flex justify-between text-emerald-600 dark:text-emerald-400 text-xs font-medium">
                                    <span>Diskon Voucher</span>
                                    <span x-text="'- ' + formatRupiah(discount)"></span>
                                </div>
                            </template>
                            <div class="flex justify-between text-base font-bold text-foreground pt-2 border-t border-border">
                                <span>Total Pembayaran</span>
                                <span class="text-primary text-lg" x-text="formatRupiah(finalTotal)"></span>
                            </div>
                        </div>
                    </x-ui.card.content>
                </x-ui.card>
            </div>
        </div>
    </div>
</x-layouts.app>

@push('scripts')
<script>
function bookingForm(subtotal, tax, serviceFee) {
    return {
        paymentMethod: 'bank_transfer',
        voucherInput: '',
        appliedVoucher: null,
        voucherMessage: '',
        voucherValid: false,
        loadingVoucher: false,
        subtotal: subtotal,
        tax: tax,
        serviceFee: serviceFee,
        discount: 0,
        get finalTotal() {
            return Math.max(0, (this.subtotal + this.tax + this.serviceFee) - this.discount);
        },
        formatRupiah(number) {
            return 'Rp ' + Math.round(number).toLocaleString('id-ID');
        },
        async applyVoucher() {
            if (!this.voucherInput.trim()) return;
            this.loadingVoucher = true;
            this.voucherMessage = '';

            try {
                const res = await fetch('{{ route('booking.voucher.check') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        code: this.voucherInput.trim(),
                        amount: this.subtotal
                    })
                });

                const data = await res.json();
                if (res.ok && data.valid) {
                    this.appliedVoucher = data;
                    this.discount = data.discount;
                    this.voucherValid = true;
                    this.voucherMessage = 'Voucher ' + data.code + ' berhasil digunakan! Diskon ' + data.formatted_discount;
                } else {
                    this.voucherValid = false;
                    this.voucherMessage = data.message || 'Voucher tidak valid.';
                }
            } catch (err) {
                this.voucherValid = false;
                this.voucherMessage = 'Gagal memvalidasi voucher. Periksa koneksi Anda.';
            } finally {
                this.loadingVoucher = false;
            }
        },
        removeVoucher() {
            this.appliedVoucher = null;
            this.discount = 0;
            this.voucherInput = '';
            this.voucherMessage = '';
        }
    }
}
</script>
@endpush

