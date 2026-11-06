<x-layouts.admin :title="'Tambah Hotel Baru'">
    <div class="max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Tambah Hotel Baru</h1>
                <p class="text-xs text-muted-foreground">Lengkapi informasi properti hotel di bawah ini</p>
            </div>
            <a href="{{ route('admin.hotels.index') }}">
                <x-ui.button variant="ghost" size="sm">&larr; Kembali</x-ui.button>
            </a>
        </div>

        @if($errors->any())
            <x-ui.alert variant="destructive">
                Terdapat kesalahan pada input formulir. Mohon periksa kembali.
            </x-ui.alert>
        @endif

        <form action="{{ route('admin.hotels.store') }}" method="POST">
            @csrf

            <x-ui.card class="space-y-5 p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5 sm:col-span-2">
                        <x-ui.label for="name">Nama Hotel <span class="text-destructive">*</span></x-ui.label>
                        <x-ui.input id="name" name="name" type="text" :value="old('name')" placeholder="Contoh: Grand Hyatt Bali" required />
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="city_id">Kota / Destinasi <span class="text-destructive">*</span></x-ui.label>
                        <select name="city_id" id="city_id" class="w-full h-10 px-3 rounded-md border border-input bg-background text-sm focus:outline-none focus:ring-1 focus:ring-ring" required>
                            <option value="">Pilih Kota</option>
                            @foreach($cities as $c)
                                <option value="{{ $c->id }}" {{ old('city_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="property_type">Tipe Properti <span class="text-destructive">*</span></x-ui.label>
                        <select name="property_type" id="property_type" class="w-full h-10 px-3 rounded-md border border-input bg-background text-sm focus:outline-none focus:ring-1 focus:ring-ring" required>
                            <option value="hotel" {{ old('property_type') === 'hotel' ? 'selected' : '' }}>Hotel</option>
                            <option value="resort" {{ old('property_type') === 'resort' ? 'selected' : '' }}>Resort</option>
                            <option value="villa" {{ old('property_type') === 'villa' ? 'selected' : '' }}>Villa</option>
                            <option value="apartment" {{ old('property_type') === 'apartment' ? 'selected' : '' }}>Apartment</option>
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="star_rating">Bintang Hotel <span class="text-destructive">*</span></x-ui.label>
                        <select name="star_rating" id="star_rating" class="w-full h-10 px-3 rounded-md border border-input bg-background text-sm focus:outline-none focus:ring-1 focus:ring-ring" required>
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ old('star_rating', 4) == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
                            @endfor
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="cover_image_url">URL Foto Cover Hotel</x-ui.label>
                        <x-ui.input id="cover_image_url" name="cover_image_url" type="url" :value="old('cover_image_url')" placeholder="https://images.unsplash.com/photo-..." />
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="check_in_time">Waktu Check-in</x-ui.label>
                        <x-ui.input id="check_in_time" name="check_in_time" type="text" :value="old('check_in_time', '14:00')" placeholder="14:00" required />
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="check_out_time">Waktu Check-out</x-ui.label>
                        <x-ui.input id="check_out_time" name="check_out_time" type="text" :value="old('check_out_time', '12:00')" placeholder="12:00" required />
                    </div>

                    <div class="space-y-1.5 sm:col-span-2">
                        <x-ui.label for="address">Alamat Lengkap <span class="text-destructive">*</span></x-ui.label>
                        <x-ui.input id="address" name="address" type="text" :value="old('address')" placeholder="Jl. Raya No. XX, Kawasan..." required />
                    </div>

                    <div class="space-y-1.5 sm:col-span-2">
                        <x-ui.label for="description">Deskripsi Hotel <span class="text-destructive">*</span></x-ui.label>
                        <x-ui.textarea id="description" name="description" rows="4" placeholder="Jelaskan daya tarik, keunggulan, dan suasana hotel..." required>{{ old('description') }}</x-ui.textarea>
                    </div>

                    <div class="space-y-1.5 sm:col-span-2">
                        <x-ui.label for="policy">Kebijakan Properti</x-ui.label>
                        <x-ui.textarea id="policy" name="policy" rows="2" placeholder="Ketentuan deposit, aturan merokok, hewan peliharaan...">{{ old('policy') }}</x-ui.textarea>
                    </div>

                    {{-- Fasilitas Hotel --}}
                    <div class="sm:col-span-2 pt-2 border-t border-border">
                        <x-ui.label class="mb-3 block">Fasilitas Hotel</x-ui.label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                            @foreach($facilities as $f)
                                <label class="flex items-center gap-2 p-2 rounded border border-border bg-card hover:bg-muted/30 cursor-pointer text-xs">
                                    <input type="checkbox" name="facilities[]" value="{{ $f->id }}" {{ in_array($f->id, (array) old('facilities', [])) ? 'checked' : '' }} class="rounded border-border text-primary">
                                    <span>{{ $f->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="sm:col-span-2 pt-2 flex items-center gap-2">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-border text-primary">
                        <x-ui.label for="is_active" class="cursor-pointer font-normal">Aktifkan hotel ini (tampilkan di pencarian pelanggan)</x-ui.label>
                    </div>
                </div>

                <div class="pt-4 border-t border-border flex justify-end gap-2">
                    <a href="{{ route('admin.hotels.index') }}">
                        <x-ui.button type="button" variant="outline">Batal</x-ui.button>
                    </a>
                    <x-ui.button type="submit">Simpan Hotel</x-ui.button>
                </div>
            </x-ui.card>
        </form>
    </div>
</x-layouts.admin>

