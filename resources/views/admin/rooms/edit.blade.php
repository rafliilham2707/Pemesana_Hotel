<x-layouts.admin :title="'Edit Tipe Kamar - ' . $room->name">
    <div class="max-w-3xl space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Edit Tipe Kamar</h1>
                <p class="text-xs text-muted-foreground">{{ $hotel->name }} &bull; {{ $room->name }}</p>
            </div>
            <a href="{{ route('admin.hotels.rooms.index', $hotel->id) }}">
                <x-ui.button variant="ghost" size="sm">&larr; Kembali</x-ui.button>
            </a>
        </div>

        @if($errors->any())
            <x-ui.alert variant="destructive">
                Terdapat kesalahan formulir. Mohon periksa input Anda.
            </x-ui.alert>
        @endif

        <form action="{{ route('admin.hotels.rooms.update', [$hotel->id, $room->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <x-ui.card class="space-y-4 p-6">
                <div class="space-y-1.5">
                    <x-ui.label for="name">Nama Tipe Kamar <span class="text-destructive">*</span></x-ui.label>
                    <x-ui.input id="name" name="name" type="text" :value="old('name', $room->name)" required />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <x-ui.label for="base_price">Harga Dasar per Malam (Rp) <span class="text-destructive">*</span></x-ui.label>
                        <x-ui.input id="base_price" name="base_price" type="number" :value="old('base_price', $room->base_price)" min="50000" step="10000" required />
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="total_rooms">Total Jumlah Kamar Fisik <span class="text-destructive">*</span></x-ui.label>
                        <x-ui.input id="total_rooms" name="total_rooms" type="number" :value="old('total_rooms', $room->total_rooms)" min="1" max="100" required />
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="max_guests">Kapasitas Maksimal Tamu <span class="text-destructive">*</span></x-ui.label>
                        <x-ui.input id="max_guests" name="max_guests" type="number" :value="old('max_guests', $room->max_guests)" min="1" max="10" required />
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="bed_type">Tipe Ranjang <span class="text-destructive">*</span></x-ui.label>
                        <x-ui.input id="bed_type" name="bed_type" type="text" :value="old('bed_type', $room->bed_type)" required />
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="size_m2">Ukuran Kamar (m²)</x-ui.label>
                        <x-ui.input id="size_m2" name="size_m2" type="number" :value="old('size_m2', $room->size_m2)" min="5" max="500" />
                    </div>

                    <div class="space-y-1.5">
                        <x-ui.label for="image">URL Foto Kamar</x-ui.label>
                        <x-ui.input id="image" name="image" type="url" :value="old('image', $room->image)" />
                    </div>
                </div>

                <div class="space-y-1.5">
                    <x-ui.label for="description">Deskripsi Kamar</x-ui.label>
                    <x-ui.textarea id="description" name="description" rows="3">{{ old('description', $room->description) }}</x-ui.textarea>
                </div>

                {{-- Fasilitas Kamar --}}
                @php $roomFacIds = $room->facilities->pluck('id')->toArray(); @endphp
                <div class="pt-2 border-t border-border">
                    <x-ui.label class="mb-3 block">Fasilitas Kamar</x-ui.label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                        @foreach($facilities as $f)
                            <label class="flex items-center gap-2 p-2 rounded border border-border bg-card hover:bg-muted/30 cursor-pointer text-xs">
                                <input type="checkbox" name="facilities[]" value="{{ $f->id }}" {{ in_array($f->id, (array) old('facilities', $roomFacIds)) ? 'checked' : '' }} class="rounded border-border text-primary">
                                <span>{{ $f->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-4 border-t border-border flex justify-end gap-2">
                    <a href="{{ route('admin.hotels.rooms.index', $hotel->id) }}">
                        <x-ui.button type="button" variant="outline">Batal</x-ui.button>
                    </a>
                    <x-ui.button type="submit">Simpan Perubahan</x-ui.button>
                </div>
            </x-ui.card>
        </form>
    </div>
</x-layouts.admin>

