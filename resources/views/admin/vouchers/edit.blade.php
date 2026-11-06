<x-layouts.admin :title="'Edit Voucher - ' . $voucher->code">
    <div class="max-w-3xl space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Edit Voucher Promo</h1>
                <p class="text-xs text-muted-foreground">Ubah ketentuan kupon: {{ $voucher->code }}</p>
            </div>
            <a href="{{ route('admin.vouchers.index') }}">
                <x-ui.button variant="ghost" size="sm">&larr; Kembali</x-ui.button>
            </a>
        </div>

        @if($errors->any())
            <x-ui.alert variant="destructive">
                Terdapat kesalahan formulir. Mohon periksa kembali input Anda.
            </x-ui.alert>
        @endif

        <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-ui.card class="space-y-4 p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <x-ui.label for="code">Kode Voucher <span class="text-destructive">*</span></x-ui.label>
                        <x-ui.input id="code" name="code" type="text" :value="old('code', $voucher->code)" class="uppercase tracking-wider font-mono" required />
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="type">Tipe Diskon <span class="text-destructive">*</span></x-ui.label>
                        <select name="type" id="type" class="w-full h-10 px-3 rounded-md border border-input bg-background text-sm focus:outline-none focus:ring-1 focus:ring-ring" required>
                            <option value="percent" {{ old('type', $voucher->type->value) === 'percent' ? 'selected' : '' }}>Persentase (%)</option>
                            <option value="fixed" {{ old('type', $voucher->type->value) === 'fixed' ? 'selected' : '' }}>Potongan Tetap (Nominal Rp)</option>
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="value">Nilai Diskon <span class="text-destructive">*</span></x-ui.label>
                        <x-ui.input id="value" name="value" type="number" :value="old('value', $voucher->value)" min="1" required />
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="min_spend">Minimal Transaksi (Rp)</x-ui.label>
                        <x-ui.input id="min_spend" name="min_spend" type="number" :value="old('min_spend', $voucher->min_spend)" min="0" step="10000" />
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="max_discount">Maksimal Diskon (Rp, Khusus Persentase)</x-ui.label>
                        <x-ui.input id="max_discount" name="max_discount" type="number" :value="old('max_discount', $voucher->max_discount)" min="0" step="10000" />
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="quota">Kuota Pemakaian (Sisa)</x-ui.label>
                        <x-ui.input id="quota" name="quota" type="number" :value="old('quota', $voucher->quota)" min="0" />
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="valid_from">Berlaku Dari Tanggal <span class="text-destructive">*</span></x-ui.label>
                        <x-ui.input id="valid_from" name="valid_from" type="date" :value="old('valid_from', \Carbon\Carbon::parse($voucher->valid_from)->format('Y-m-d'))" required />
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="valid_until">Berlaku Sampai Tanggal <span class="text-destructive">*</span></x-ui.label>
                        <x-ui.input id="valid_until" name="valid_until" type="date" :value="old('valid_until', \Carbon\Carbon::parse($voucher->valid_until)->format('Y-m-d'))" required />
                    </div>
                </div>

                <div class="pt-2 flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $voucher->is_active) ? 'checked' : '' }} class="rounded border-border text-primary">
                    <x-ui.label for="is_active" class="cursor-pointer font-normal">Voucher Aktif</x-ui.label>
                </div>

                <div class="pt-4 border-t border-border flex justify-end gap-2">
                    <a href="{{ route('admin.vouchers.index') }}">
                        <x-ui.button type="button" variant="outline">Batal</x-ui.button>
                    </a>
                    <x-ui.button type="submit">Simpan Perubahan</x-ui.button>
                </div>
            </x-ui.card>
        </form>
    </div>
</x-layouts.admin>

