<x-layouts.admin :title="'Edit Hotel - ' . $hotel->name">
    <div class="max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Edit Hotel</h1>
                <p class="text-xs text-muted-foreground">Perbarui informasi properti hotel: {{ $hotel->name }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.hotels.rooms.index', $hotel->id) }}">
                    <x-ui.button variant="outline" size="sm" class="gap-1">
                        <x-ui.icon name="bed" class="w-4 h-4" />
                        Kelola Kamar
                    </x-ui.button>
                </a>
                <a href="{{ route('admin.hotels.index') }}">
                    <x-ui.button variant="ghost" size="sm">&larr; Kembali</x-ui.button>
                </a>
            </div>
        </div>

        @if($errors->any())
            <x-ui.alert variant="destructive">
                Terdapat kesalahan pada input formulir. Mohon periksa kembali.
            </x-ui.alert>
        @endif

        <form action="{{ route('admin.hotels.update', $hotel->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-ui.card class="space-y-5 p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5 sm:col-span-2">
                        <x-ui.label for="name">Nama Hotel <span class="text-destructive">*</span></x-ui.label>
                        <x-ui.input id="name" name="name" type="text" :value="old('name', $hotel->name)" required />
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="city_id">Kota / Destinasi <span class="text-destructive">*</span></x-ui.label>
                        <select name="city_id" id="city_id" class="w-full h-10 px-3 rounded-md border border-input bg-background text-sm focus:outline-none focus:ring-1 focus:ring-ring" required>
                            @foreach($cities as $c)
                                <option value="{{ $c->id }}" {{ old('city_id', $hotel->city_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="property_type">Tipe Properti <span class="text-destructive">*</span></x-ui.label>
                        <select name="property_type" id="property_type" class="w-full h-10 px-3 rounded-md border border-input bg-background text-sm focus:outline-none focus:ring-1 focus:ring-ring" required>
                            @php $pType = old('property_type', $hotel->property_type->value ?? 'hotel'); @endphp
                            <option value="hotel" {{ $pType === 'hotel' ? 'selected' : '' }}>Hotel</option>
                            <option value="resort" {{ $pType === 'resort' ? 'selected' : '' }}>Resort</option>
                            <option value="villa" {{ $pType === 'villa' ? 'selected' : '' }}>Villa</option>
                            <option value="apartment" {{ $pType === 'apartment' ? 'selected' : '' }}>Apartment</option>
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="star_rating">Bintang Hotel <span class="text-destructive">*</span></x-ui.label>
                        <select name="star_rating" id="star_rating" class="w-full h-10 px-3 rounded-md border border-input bg-background text-sm focus:outline-none focus:ring-1 focus:ring-ring" required>
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ old('star_rating', $hotel->star_rating) == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
                            @endfor
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="cover_image_url">URL Foto Cover Hotel</x-ui.label>
                        <x-ui.input id="cover_image_url" name="cover_image_url" type="url" :value="old('cover_image_url', $hotel->cover_image_url)" />
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="check_in_time">Waktu Check-in</x-ui.label>
                        <x-ui.input id="check_in_time" name="check_in_time" type="text" :value="old('check_in_time', $hotel->check_in_time ?? '14:00')" required />
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="check_out_time">Waktu Check-out</x-ui.label>
                        <x-ui.input id="check_out_time" name="check_out_time" type="text" :value="old('check_out_time', $hotel->check_out_time ?? '12:00')" required />
                    </div>

                    <div class="space-y-1.5 sm:col-span-2">
                        <x-ui.label for="address">Alamat Lengkap <span class="text-destructive">*</span></x-ui.label>
                        <x-ui.input id="address" name="address" type="text" :value="old('address', $hotel->address)" required />
                    </div>

                    <div class="space-y-1.5 sm:col-span-2">
                        <x-ui.label for="description">Deskripsi Hotel <span class="text-destructive">*</span></x-ui.label>
                        <x-ui.textarea id="description" name="description" rows="4" required>{{ old('description', $hotel->description) }}</x-ui.textarea>
                    </div>

                    <div class="space-y-1.5 sm:col-span-2">
                        <x-ui.label for="policy">Kebijakan Properti</x-ui.label>
                        <x-ui.textarea id="policy" name="policy" rows="2">{{ old('policy', $hotel->policy) }}</x-ui.textarea>
                    </div>

                    {{-- Fasilitas Hotel --}}
                    @php $hotelFacIds = $hotel->facilities->pluck('id')->toArray(); @endphp
                    <div class="sm:col-span-2 pt-2 border-t border-border">
                        <x-ui.label class="mb-3 block">Fasilitas Hotel</x-ui.label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                            @foreach($facilities as $f)
                                <label class="flex items-center gap-2 p-2 rounded border border-border bg-card hover:bg-muted/30 cursor-pointer text-xs">
                                    <input type="checkbox" name="facilities[]" value="{{ $f->id }}" {{ in_array($f->id, (array) old('facilities', $hotelFacIds)) ? 'checked' : '' }} class="rounded border-border text-primary">
                                    <span>{{ $f->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="sm:col-span-2 pt-2 flex items-center gap-2">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $hotel->is_active) ? 'checked' : '' }} class="rounded border-border text-primary">
                        <x-ui.label for="is_active" class="cursor-pointer font-normal">Hotel Aktif (tampilkan di website)</x-ui.label>
                    </div>
                </div>

                <div class="pt-4 border-t border-border flex justify-end gap-2">
                    <a href="{{ route('admin.hotels.index') }}">
                        <x-ui.button type="button" variant="outline">Batal</x-ui.button>
                    </a>
                    <x-ui.button type="submit">Simpan Perubahan</x-ui.button>
                </div>
            </x-ui.card>
        </form>
    </div>
</x-layouts.admin>

