<x-layouts.app title="Katalog Komponen UI shadcn - StayHub">
    {{-- Header / Navigation Bar --}}
    <header class="sticky top-0 z-40 w-full border-b bg-background/95 backdrop-blur-md">
        <div class="container mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6">
            <div class="flex items-center gap-6">
                <a href="{{ url('/') }}" class="flex items-center gap-2 font-bold text-xl text-primary tracking-tight">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary text-primary-foreground shadow-sm">
                        <x-ui.icon name="hotel" class="w-5 h-5" />
                    </div>
                    <span>StayHub</span>
                </a>
                <span class="hidden md:inline-flex items-center rounded-md bg-primary/10 px-2 py-1 text-xs font-medium text-primary">
                    Shadcn Blade UI Showcase
                </span>
            </div>

            <div class="flex items-center gap-3">
                {{-- Dark Mode Toggle --}}
                <x-ui.button
                    variant="ghost"
                    size="icon"
                    @click="darkMode = !darkMode"
                    title="Ganti Tema"
                >
                    <x-ui.icon name="sun" class="w-5 h-5" x-show="darkMode" />
                    <x-ui.icon name="moon" class="w-5 h-5" x-show="!darkMode" />
                </x-ui.button>

                {{-- User Dropdown Demo --}}
                <x-ui.dropdown-menu align="right">
                    <x-slot:trigger>
                        <div class="flex items-center gap-2 rounded-full p-1 hover:bg-accent transition-colors">
                            <x-ui.avatar src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop" alt="Rafli Ilham" fallback="RI" size="sm" />
                            <span class="hidden sm:inline-block text-sm font-medium text-foreground">Akun Saya</span>
                            <x-ui.icon name="chevron-down" class="w-3.5 h-3.5 text-muted-foreground" />
                        </div>
                    </x-slot:trigger>

                    <div class="px-2 py-1.5 text-xs font-semibold text-muted-foreground">Halo, Rafli Ilham</div>
                    <x-ui.separator class="my-1" />
                    <x-ui.dropdown.item href="#">
                        <x-ui.icon name="user" class="w-4 h-4 mr-2" /> Profil Pengguna
                    </x-ui.dropdown.item>
                    <x-ui.dropdown.item href="#">
                        <x-ui.icon name="receipt" class="w-4 h-4 mr-2" /> Pesanan Saya
                    </x-ui.dropdown.item>
                    <x-ui.dropdown.item href="#">
                        <x-ui.icon name="heart" class="w-4 h-4 mr-2" /> Wishlist Hotel
                    </x-ui.dropdown.item>
                    <x-ui.separator class="my-1" />
                    <x-ui.dropdown.item destructive href="#">
                        <x-ui.icon name="log-out" class="w-4 h-4 mr-2" /> Keluar
                    </x-ui.dropdown.item>
                </x-ui.dropdown-menu>

                {{-- Mobile Sheet Trigger --}}
                <div class="md:hidden">
                    <x-ui.sheet side="left" title="Menu Navigasi" description="Akses cepat ke semua fitur StayHub">
                        <x-slot:trigger>
                            <x-ui.button variant="outline" size="icon">
                                <x-ui.icon name="menu" class="w-5 h-5" />
                            </x-ui.button>
                        </x-slot:trigger>

                        <div class="space-y-4 py-4">
                            <div class="space-y-1">
                                <a href="#buttons" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium hover:bg-accent">
                                    <x-ui.icon name="sparkles" class="w-4 h-4 text-primary" /> Tombol (Button)
                                </a>
                                <a href="#forms" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium hover:bg-accent">
                                    <x-ui.icon name="edit" class="w-4 h-4 text-primary" /> Form & Input
                                </a>
                                <a href="#datepicker" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium hover:bg-accent">
                                    <x-ui.icon name="calendar" class="w-4 h-4 text-primary" /> Date Picker
                                </a>
                                <a href="#dialog" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium hover:bg-accent">
                                    <x-ui.icon name="external-link" class="w-4 h-4 text-primary" /> Modal Dialog
                                </a>
                                <a href="#cards" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium hover:bg-accent">
                                    <x-ui.icon name="hotel" class="w-4 h-4 text-primary" /> Hotel Card
                                </a>
                            </div>
                        </div>

                        <x-slot:footer>
                            <x-ui.button class="w-full" size="sm">Hubungi Bantuan</x-ui.button>
                        </x-slot:footer>
                    </x-ui.sheet>
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content Container --}}
    <main class="container mx-auto max-w-7xl flex-1 px-4 py-8 sm:px-6 space-y-12">
        {{-- Hero Introduction --}}
        <div class="flex flex-col gap-4 border-b pb-8">
            <div class="flex flex-wrap items-center gap-2">
                <x-ui.badge variant="default">Tahap 1 Selesai</x-ui.badge>
                <x-ui.badge variant="success">Tailwind CSS v4</x-ui.badge>
                <x-ui.badge variant="info">Alpine.js</x-ui.badge>
                <x-ui.badge variant="outline">shadcn/ui Pattern</x-ui.badge>
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                Katalog Komponen UI Hotel Booking
            </h1>
            <p class="text-base text-muted-foreground max-w-3xl leading-relaxed">
                Kumpulan 21 komponen Blade bergaya shadcn/ui dengan token tema CSS variables, interaktivitas Alpine.js, dan ikon Lucide SVG. Seluruh komponen siap digunakan untuk modul customer dan panel admin.
            </p>
        </div>

        {{-- 1. BUTTONS & BADGES --}}
        <section id="buttons" class="space-y-6">
            <div class="space-y-1">
                <h2 class="text-2xl font-bold tracking-tight">1. Tombol (Button) & Lencana (Badge)</h2>
                <p class="text-sm text-muted-foreground">Beragam varian tombol dan badge dengan styling konsisten.</p>
            </div>

            <x-ui.card>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-xs font-semibold text-muted-foreground uppercase tracking-wider mb-3">Varian Tombol</h4>
                        <div class="flex flex-wrap items-center gap-3">
                            <x-ui.button variant="default">
                                <x-ui.icon name="hotel" class="w-4 h-4 mr-2" /> Default (Primary)
                            </x-ui.button>
                            <x-ui.button variant="secondary">
                                Secondary
                            </x-ui.button>
                            <x-ui.button variant="outline">
                                <x-ui.icon name="filter" class="w-4 h-4 mr-2" /> Outline
                            </x-ui.button>
                            <x-ui.button variant="ghost">
                                Ghost
                            </x-ui.button>
                            <x-ui.button variant="destructive">
                                <x-ui.icon name="trash-2" class="w-4 h-4 mr-2" /> Destructive
                            </x-ui.button>
                            <x-ui.button variant="link">
                                Link Button
                            </x-ui.button>
                            <x-ui.button disabled>
                                Disabled
                            </x-ui.button>
                        </div>
                    </div>

                    <x-ui.separator />

                    <div>
                        <h4 class="text-xs font-semibold text-muted-foreground uppercase tracking-wider mb-3">Ukuran Tombol</h4>
                        <div class="flex flex-wrap items-center gap-3">
                            <x-ui.button size="sm">Small (sm)</x-ui.button>
                            <x-ui.button size="default">Default</x-ui.button>
                            <x-ui.button size="lg">Large (lg)</x-ui.button>
                            <x-ui.button size="icon" variant="outline">
                                <x-ui.icon name="heart" class="w-4 h-4 text-rose-500" />
                            </x-ui.button>
                            <x-ui.button size="icon" variant="default">
                                <x-ui.icon name="search" class="w-4 h-4" />
                            </x-ui.button>
                        </div>
                    </div>

                    <x-ui.separator />

                    <div>
                        <h4 class="text-xs font-semibold text-muted-foreground uppercase tracking-wider mb-3">Varian Badge</h4>
                        <div class="flex flex-wrap items-center gap-2">
                            <x-ui.badge variant="default">Default</x-ui.badge>
                            <x-ui.badge variant="secondary">Secondary</x-ui.badge>
                            <x-ui.badge variant="outline">Bintang 5</x-ui.badge>
                            <x-ui.badge variant="success">Terkonfirmasi</x-ui.badge>
                            <x-ui.badge variant="warning">Menunggu Pembayaran</x-ui.badge>
                            <x-ui.badge variant="destructive">Dibatalkan</x-ui.badge>
                            <x-ui.badge variant="info">Promo Spesial 25%</x-ui.badge>
                        </div>
                    </div>
                </div>
            </x-ui.card>
        </section>

        {{-- 2. FORM CONTROLS --}}
        <section id="forms" class="space-y-6">
            <div class="space-y-1">
                <h2 class="text-2xl font-bold tracking-tight">2. Kontrol Formulir (Forms)</h2>
                <p class="text-sm text-muted-foreground">Label, input teks, seleksi, area teks, dan kotak centang.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-ui.card title="Input & Seleksi" description="Formulir data pemesanan">
                    <div class="space-y-4">
                        <div class="space-y-1.5">
                            <x-ui.label for="demo-name" required>Nama Lengkap Pemesan</x-ui.label>
                            <x-ui.input id="demo-name" placeholder="cth: Ahmad Dahlan" value="Ahmad Dahlan" />
                        </div>

                        <div class="space-y-1.5">
                            <x-ui.label for="demo-email" required>Alamat Email</x-ui.label>
                            <x-ui.input id="demo-email" type="email" placeholder="nama@email.com" />
                            <p class="text-xs text-muted-foreground">E-voucher akan dikirimkan ke email ini.</p>
                        </div>

                        <div class="space-y-1.5">
                            <x-ui.label for="demo-city">Kota Destinasi</x-ui.label>
                            <x-ui.select id="demo-city">
                                <option value="jakarta">Jakarta (240 hotel)</option>
                                <option value="bali" selected>Bali (580 hotel)</option>
                                <option value="bandung">Bandung (190 hotel)</option>
                                <option value="yogyakarta">Yogyakarta (175 hotel)</option>
                                <option value="surabaya">Surabaya (130 hotel)</option>
                            </x-ui.select>
                        </div>

                        <div class="space-y-1.5">
                            <x-ui.label for="demo-error">Contoh Status Validasi Error</x-ui.label>
                            <x-ui.input id="demo-error" value="08123" :error="true" />
                            <p class="text-xs text-destructive">Nomor telepon minimal 10 digit.</p>
                        </div>
                    </div>
                </x-ui.card>

                <x-ui.card title="Textarea & Checkbox" description="Permintaan khusus dan opsi tambahan">
                    <div class="space-y-4">
                        <div class="space-y-1.5">
                            <x-ui.label for="demo-requests">Permintaan Khusus (Opsional)</x-ui.label>
                            <x-ui.textarea id="demo-requests" placeholder="Contoh: Kamar bebas asap rokok, lantai atas, check-in lebih awal..." rows="3"></x-ui.textarea>
                        </div>

                        <div class="space-y-3 pt-2">
                            <x-ui.checkbox
                                name="non_smoking"
                                label="Kamar Bebas Rokok (Non-Smoking Room)"
                                description="Prioritaskan kamar yang tidak mengizinkan merokok"
                                :checked="true"
                            />

                            <x-ui.checkbox
                                name="high_floor"
                                label="Lantai Atas (High Floor)"
                                description="Nikmati pemandangan kota dari lantai yang lebih tinggi"
                            />

                            <x-ui.checkbox
                                name="terms"
                                label="Saya menyetujui Syarat dan Kebijakan Pembatalan"
                                description="Pesanan tunduk pada kebijakan hotel yang berlaku"
                            />
                        </div>
                    </div>
                </x-ui.card>
            </div>
        </section>

        {{-- 3. DATE PICKER & POPOVER (TRAVELOKA SEARCH BAR CORE) --}}
        <section id="datepicker" class="space-y-6">
            <div class="space-y-1">
                <h2 class="text-2xl font-bold tracking-tight">3. Date Picker & Popover (Komponen Utama Pencarian)</h2>
                <p class="text-sm text-muted-foreground">Interaktif kalender tanggal check-in/check-out dan popover pemilih tamu/kamar seperti di Traveloka.</p>
            </div>

            <x-ui.card class="bg-gradient-to-br from-primary/5 via-background to-background border-primary/20">
                <div class="p-2 space-y-4">
                    <div class="flex items-center gap-2">
                        <div class="p-2 rounded-md bg-primary text-primary-foreground">
                            <x-ui.icon name="search" class="w-4 h-4" />
                        </div>
                        <div>
                            <h3 class="font-semibold text-base">Simulasi Bar Pencarian Hotel</h3>
                            <p class="text-xs text-muted-foreground">Coba pilih tanggal check-in dan konfigurasi tamu</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 pt-2">
                        {{-- Destinasi --}}
                        <div class="space-y-1.5">
                            <x-ui.label>Kota / Nama Hotel</x-ui.label>
                            <div class="relative">
                                <x-ui.input placeholder="Mau menginap di mana?" value="Bali, Indonesia" />
                                <x-ui.icon name="map-pin" class="w-4 h-4 text-muted-foreground absolute right-3 top-2.5" />
                            </div>
                        </div>

                        {{-- Check-in --}}
                        <div class="space-y-1.5">
                            <x-ui.label>Check-in</x-ui.label>
                            <x-ui.date-picker name="check_in" :value="date('Y-m-d')" :minDate="date('Y-m-d')" placeholder="Pilih tanggal check-in" />
                        </div>

                        {{-- Check-out --}}
                        <div class="space-y-1.5">
                            <x-ui.label>Check-out</x-ui.label>
                            <x-ui.date-picker name="check_out" :value="date('Y-m-d', strtotime('+1 day'))" :minDate="date('Y-m-d', strtotime('+1 day'))" placeholder="Pilih tanggal check-out" />
                        </div>

                        {{-- Popover Tamu & Kamar --}}
                        <div class="space-y-1.5" x-data="{ guests: 2, rooms: 1 }">
                            <x-ui.label>Tamu & Kamar</x-ui.label>
                            <x-ui.popover width="w-80" align="right">
                                <x-slot:trigger>
                                    <button type="button" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-accent/40 text-left">
                                        <span class="flex items-center gap-2">
                                            <x-ui.icon name="users" class="w-4 h-4 text-primary" />
                                            <span class="font-medium" x-text="`${guests} Dewasa, ${rooms} Kamar`"></span>
                                        </span>
                                        <x-ui.icon name="chevron-down" class="w-4 h-4 text-muted-foreground" />
                                    </button>
                                </x-slot:trigger>

                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-sm font-semibold">Tamu Dewasa</div>
                                            <div class="text-xs text-muted-foreground">Usia 18+ tahun</div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <button
                                                type="button"
                                                @click="if (guests > 1) guests--"
                                                class="h-8 w-8 rounded-md border flex items-center justify-center hover:bg-accent text-sm font-medium"
                                                :disabled="guests <= 1"
                                            >-</button>
                                            <span class="w-6 text-center font-semibold text-sm" x-text="guests"></span>
                                            <button
                                                type="button"
                                                @click="guests++"
                                                class="h-8 w-8 rounded-md border flex items-center justify-center hover:bg-accent text-sm font-medium"
                                            >+</button>
                                        </div>
                                    </div>

                                    <x-ui.separator />

                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-sm font-semibold">Jumlah Kamar</div>
                                            <div class="text-xs text-muted-foreground">Maks 8 kamar</div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <button
                                                type="button"
                                                @click="if (rooms > 1) rooms--"
                                                class="h-8 w-8 rounded-md border flex items-center justify-center hover:bg-accent text-sm font-medium"
                                                :disabled="rooms <= 1"
                                            >-</button>
                                            <span class="w-6 text-center font-semibold text-sm" x-text="rooms"></span>
                                            <button
                                                type="button"
                                                @click="if (rooms < 8) rooms++"
                                                class="h-8 w-8 rounded-md border flex items-center justify-center hover:bg-accent text-sm font-medium"
                                            >+</button>
                                        </div>
                                    </div>
                                </div>
                            </x-ui.popover>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <x-ui.button class="w-full sm:w-auto px-8" size="lg">
                            <x-ui.icon name="search" class="w-4 h-4 mr-2" /> Cari Hotel
                        </x-ui.button>
                    </div>
                </div>
            </x-ui.card>
        </section>

        {{-- 4. DIALOG & SHEET --}}
        <section id="dialog" class="space-y-6">
            <div class="space-y-1">
                <h2 class="text-2xl font-bold tracking-tight">4. Dialog (Modal) & Sheet (Drawer Samping)</h2>
                <p class="text-sm text-muted-foreground">Modal konfirmasi dan panel geser untuk filter mobile atau menu.</p>
            </div>

            <x-ui.card>
                <div class="flex flex-wrap items-center gap-4">
                    {{-- Dialog Modal Demo --}}
                    <x-ui.dialog
                        id="demo-modal"
                        title="Konfirmasi Pembatalan Pesanan"
                        description="Apakah Anda yakin ingin membatalkan pesanan kamar ini? Proses ini tidak dapat dibatalkan."
                    >
                        <x-slot:trigger>
                            <x-ui.button variant="destructive">
                                <x-ui.icon name="alert-circle" class="w-4 h-4 mr-2" /> Buka Modal Dialog
                            </x-ui.button>
                        </x-slot:trigger>

                        <div class="rounded-md bg-muted/60 p-3 text-sm space-y-1 text-muted-foreground">
                            <div><strong>Kode Booking:</strong> BK-20261106-9X7AZ</div>
                            <div><strong>Hotel:</strong> Grand Mercure Resort Bali</div>
                            <div><strong>Tanggal:</strong> 12 - 14 Nov 2026 (2 Malam)</div>
                            <div><strong>Pengembalian Dana:</strong> Sesuai kebijakan hotel (100% sebelum H-3)</div>
                        </div>

                        <x-slot:footer>
                            <x-ui.button variant="outline" @click="open = false">Kembali</x-ui.button>
                            <x-ui.button variant="destructive" @click="open = false; $dispatch('toast', { title: 'Dibatalkan', description: 'Pesanan BK-20261106-9X7AZ telah dibatalkan.', variant: 'destructive' })">
                                Ya, Batalkan Pesanan
                            </x-ui.button>
                        </x-slot:footer>
                    </x-ui.dialog>

                    {{-- Sheet Drawer Demo (Right) --}}
                    <x-ui.sheet
                        id="demo-sheet"
                        side="right"
                        title="Filter Pencarian Hotel"
                        description="Sesuaikan kriteria pencarian hotel impian Anda."
                    >
                        <x-slot:trigger>
                            <x-ui.button variant="outline">
                                <x-ui.icon name="sliders-horizontal" class="w-4 h-4 mr-2" /> Buka Filter Sheet (Kanan)
                            </x-ui.button>
                        </x-slot:trigger>

                        <div class="space-y-6 py-2">
                            <div>
                                <h4 class="text-sm font-semibold mb-3">Rentang Harga per Malam</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <x-ui.label class="text-xs mb-1">Minimum</x-ui.label>
                                        <x-ui.input placeholder="Rp 0" value="Rp 250.000" />
                                    </div>
                                    <div>
                                        <x-ui.label class="text-xs mb-1">Maksimum</x-ui.label>
                                        <x-ui.input placeholder="Rp 5.000.000" value="Rp 2.000.000" />
                                    </div>
                                </div>
                            </div>

                            <x-ui.separator />

                            <div>
                                <h4 class="text-sm font-semibold mb-3">Bintang Hotel</h4>
                                <div class="space-y-2">
                                    <x-ui.checkbox label="⭐⭐⭐⭐⭐ Bintang 5" :checked="true" />
                                    <x-ui.checkbox label="⭐⭐⭐⭐ Bintang 4" :checked="true" />
                                    <x-ui.checkbox label="⭐⭐⭐ Bintang 3" />
                                </div>
                            </div>

                            <x-ui.separator />

                            <div>
                                <h4 class="text-sm font-semibold mb-3">Fasilitas Populer</h4>
                                <div class="space-y-2">
                                    <x-ui.checkbox label="Kolam Renang" :checked="true" />
                                    <x-ui.checkbox label="WiFi Gratis" :checked="true" />
                                    <x-ui.checkbox label="Sarapan Gratis" />
                                    <x-ui.checkbox label="Pusat Kebugaran (Gym)" />
                                    <x-ui.checkbox label="Tempat Parkir" :checked="true" />
                                </div>
                            </div>
                        </div>

                        <x-slot:footer>
                            <x-ui.button variant="outline" size="sm" @click="open = false">Reset</x-ui.button>
                            <x-ui.button size="sm" @click="open = false; $dispatch('toast', { title: 'Filter Diterapkan', description: 'Menampilkan 42 hotel sesuai filter.', variant: 'success' })">Terapkan Filter</x-ui.button>
                        </x-slot:footer>
                    </x-ui.sheet>
                </div>
            </x-ui.card>
        </section>

        {{-- 5. TABS, TABLE & CARD PREVIEW --}}
        <section id="cards" class="space-y-6">
            <div class="space-y-1">
                <h2 class="text-2xl font-bold tracking-tight">5. Tabs, Tabel Data & Kartu Hotel</h2>
                <p class="text-sm text-muted-foreground">Komponen tab interaktif dan visualisasi card hotel lengkap dengan helper rupiah.</p>
            </div>

            <x-ui.tabs default="rincian">
                <x-ui.tabs.list class="grid w-full grid-cols-3 max-w-md">
                    <x-ui.tabs.trigger value="rincian">Contoh Kartu Hotel</x-ui.tabs.trigger>
                    <x-ui.tabs.trigger value="tabel">Tabel Ketersediaan</x-ui.tabs.trigger>
                    <x-ui.tabs.trigger value="skeleton">Loading Skeleton</x-ui.tabs.trigger>
                </x-ui.tabs.list>

                {{-- Tab 1: Hotel Card Preview --}}
                <x-ui.tabs.content value="rincian" class="pt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Card 1 --}}
                        <x-ui.card class="overflow-hidden hover:shadow-lg transition-all border-border">
                            <div class="relative h-48 w-full overflow-hidden bg-muted">
                                <img
                                    src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&auto=format&fit=crop"
                                    alt="The Mulia Resort Bali"
                                    class="h-full w-full object-cover hover:scale-105 transition-transform duration-300"
                                />
                                <div class="absolute top-3 left-3 flex gap-2">
                                    <x-ui.badge variant="default" class="bg-primary/95 text-xs font-semibold shadow-sm">
                                        Rekomendasi
                                    </x-ui.badge>
                                    <x-ui.badge variant="success" class="shadow-sm">
                                        Diskon 20%
                                    </x-ui.badge>
                                </div>
                                <button class="absolute top-3 right-3 h-8 w-8 rounded-full bg-background/80 backdrop-blur-xs flex items-center justify-center text-rose-500 hover:bg-background transition-colors">
                                    <x-ui.icon name="heart" class="w-4 h-4" />
                                </button>
                            </div>

                            <div class="p-5 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1 text-amber-500">
                                        @for($i = 0; $i < 5; $i++)
                                            <x-ui.icon name="star-fill" class="w-4 h-4 fill-amber-400 text-amber-400" />
                                        @endfor
                                        <span class="text-xs font-semibold text-muted-foreground ml-1">Resort Mewah</span>
                                    </div>
                                    <div class="flex items-center gap-1 rounded-md bg-primary/10 px-2 py-0.5 text-xs font-bold text-primary">
                                        <x-ui.icon name="star-fill" class="w-3.5 h-3.5 text-primary" />
                                        <span>4.8 / 5.0</span>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="font-bold text-lg leading-tight text-foreground">The Mulia Resort & Villas Bali</h3>
                                    <p class="text-xs text-muted-foreground flex items-center gap-1 mt-1">
                                        <x-ui.icon name="map-pin" class="w-3.5 h-3.5 text-primary shrink-0" />
                                        <span>Nusa Dua, Bali - 500m dari Pantai Mengiat</span>
                                    </p>
                                </div>

                                <div class="flex flex-wrap gap-1.5 pt-1">
                                    <span class="inline-flex items-center gap-1 rounded bg-secondary px-2 py-0.5 text-[11px] text-secondary-foreground">
                                        <x-ui.icon name="wifi" class="w-3 h-3" /> WiFi Cepat
                                    </span>
                                    <span class="inline-flex items-center gap-1 rounded bg-secondary px-2 py-0.5 text-[11px] text-secondary-foreground">
                                        <x-ui.icon name="waves" class="w-3 h-3" /> Kolam Infinity
                                    </span>
                                    <span class="inline-flex items-center gap-1 rounded bg-secondary px-2 py-0.5 text-[11px] text-secondary-foreground">
                                        <x-ui.icon name="utensils" class="w-3 h-3" /> Restoran
                                    </span>
                                </div>

                                <x-ui.separator class="my-3" />

                                <div class="flex items-end justify-between">
                                    <div>
                                        <span class="text-xs text-muted-foreground line-through">{{ format_rupiah(2400000) }}</span>
                                        <div class="text-lg font-extrabold text-primary">{{ format_rupiah(1920000) }}</div>
                                        <span class="text-[11px] text-muted-foreground">per kamar / malam (termasuk pajak)</span>
                                    </div>
                                    <x-ui.button size="sm">
                                        Lihat Kamar
                                        <x-ui.icon name="arrow-right" class="w-3.5 h-3.5 ml-1.5" />
                                    </x-ui.button>
                                </div>
                            </div>
                        </x-ui.card>

                        {{-- Card 2 --}}
                        <x-ui.card class="overflow-hidden hover:shadow-lg transition-all border-border">
                            <div class="relative h-48 w-full overflow-hidden bg-muted">
                                <img
                                    src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800&auto=format&fit=crop"
                                    alt="Padma Hotel Bandung"
                                    class="h-full w-full object-cover hover:scale-105 transition-transform duration-300"
                                />
                                <div class="absolute top-3 left-3 flex gap-2">
                                    <x-ui.badge variant="secondary" class="bg-background/90 backdrop-blur-xs text-xs font-semibold">
                                        Hotel Bintang 5
                                    </x-ui.badge>
                                </div>
                            </div>

                            <div class="p-5 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1 text-amber-500">
                                        @for($i = 0; $i < 5; $i++)
                                            <x-ui.icon name="star-fill" class="w-4 h-4 fill-amber-400 text-amber-400" />
                                        @endfor
                                        <span class="text-xs font-semibold text-muted-foreground ml-1">Pemandangan Bukit</span>
                                    </div>
                                    <div class="flex items-center gap-1 rounded-md bg-primary/10 px-2 py-0.5 text-xs font-bold text-primary">
                                        <x-ui.icon name="star-fill" class="w-3.5 h-3.5 text-primary" />
                                        <span>4.9 / 5.0</span>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="font-bold text-lg leading-tight text-foreground">Padma Hotel Bandung</h3>
                                    <p class="text-xs text-muted-foreground flex items-center gap-1 mt-1">
                                        <x-ui.icon name="map-pin" class="w-3.5 h-3.5 text-primary shrink-0" />
                                        <span>Ciumbuleuit, Bandung - Area Sejuk & Alami</span>
                                    </p>
                                </div>

                                <div class="flex flex-wrap gap-1.5 pt-1">
                                    <span class="inline-flex items-center gap-1 rounded bg-secondary px-2 py-0.5 text-[11px] text-secondary-foreground">
                                        <x-ui.icon name="coffee" class="w-3 h-3" /> Sarapan Gratis
                                    </span>
                                    <span class="inline-flex items-center gap-1 rounded bg-secondary px-2 py-0.5 text-[11px] text-secondary-foreground">
                                        <x-ui.icon name="waves" class="w-3 h-3" /> Kolam Air Hangat
                                    </span>
                                </div>

                                <x-ui.separator class="my-3" />

                                <div class="flex items-end justify-between">
                                    <div>
                                        <div class="text-lg font-extrabold text-primary">{{ format_rupiah(1450000) }}</div>
                                        <span class="text-[11px] text-muted-foreground">per kamar / malam (termasuk pajak)</span>
                                    </div>
                                    <x-ui.button size="sm">
                                        Lihat Kamar
                                        <x-ui.icon name="arrow-right" class="w-3.5 h-3.5 ml-1.5" />
                                    </x-ui.button>
                                </div>
                            </div>
                        </x-ui.card>
                    </div>
                </x-ui.tabs.content>

                {{-- Tab 2: Table Preview --}}
                <x-ui.tabs.content value="tabel" class="pt-4">
                    <x-ui.table>
                        <x-ui.table.header>
                            <x-ui.table.row>
                                <x-ui.table.head>Tipe Kamar</x-ui.table.head>
                                <x-ui.table.head>Kapasitas</x-ui.table.head>
                                <x-ui.table.head>Harga / Malam</x-ui.table.head>
                                <x-ui.table.head>Sisa Kamar</x-ui.table.head>
                                <x-ui.table.head>Status</x-ui.table.head>
                                <x-ui.table.head class="text-right">Aksi</x-ui.table.head>
                            </x-ui.table.row>
                        </x-ui.table.header>
                        <x-ui.table.body>
                            <x-ui.table.row>
                                <x-ui.table.cell class="font-medium">
                                    <div class="font-semibold text-foreground">Deluxe King Pool View</div>
                                    <div class="text-xs text-muted-foreground">1 Ranjang King • 35 m²</div>
                                </x-ui.table.cell>
                                <x-ui.table.cell>
                                    <span class="inline-flex items-center gap-1 text-xs">
                                        <x-ui.icon name="users" class="w-3.5 h-3.5 text-muted-foreground" /> 2 Dewasa
                                    </span>
                                </x-ui.table.cell>
                                <x-ui.table.cell class="font-bold text-primary">{{ format_rupiah(1250000) }}</x-ui.table.cell>
                                <x-ui.table.cell>
                                    <span class="font-semibold text-emerald-600">8 kamar</span>
                                </x-ui.table.cell>
                                <x-ui.table.cell>
                                    <x-ui.badge variant="success">Tersedia</x-ui.badge>
                                </x-ui.table.cell>
                                <x-ui.table.cell class="text-right">
                                    <x-ui.button size="sm">Pilih Kamar</x-ui.button>
                                </x-ui.table.cell>
                            </x-ui.table.row>

                            <x-ui.table.row>
                                <x-ui.table.cell class="font-medium">
                                    <div class="font-semibold text-foreground">Premier Suite with Bathtub</div>
                                    <div class="text-xs text-muted-foreground">1 Ranjang Super King • 52 m²</div>
                                </x-ui.table.cell>
                                <x-ui.table.cell>
                                    <span class="inline-flex items-center gap-1 text-xs">
                                        <x-ui.icon name="users" class="w-3.5 h-3.5 text-muted-foreground" /> 2 Dewasa, 1 Anak
                                    </span>
                                </x-ui.table.cell>
                                <x-ui.table.cell class="font-bold text-primary">{{ format_rupiah(2100000) }}</x-ui.table.cell>
                                <x-ui.table.cell>
                                    <span class="font-semibold text-amber-600">Sisa 2 kamar!</span>
                                </x-ui.table.cell>
                                <x-ui.table.cell>
                                    <x-ui.badge variant="warning">Hampir Habis</x-ui.badge>
                                </x-ui.table.cell>
                                <x-ui.table.cell class="text-right">
                                    <x-ui.button size="sm">Pilih Kamar</x-ui.button>
                                </x-ui.table.cell>
                            </x-ui.table.row>

                            <x-ui.table.row>
                                <x-ui.table.cell class="font-medium">
                                    <div class="font-semibold text-foreground">Presidential Villa Private Pool</div>
                                    <div class="text-xs text-muted-foreground">2 Ranjang King • 120 m²</div>
                                </x-ui.table.cell>
                                <x-ui.table.cell>
                                    <span class="inline-flex items-center gap-1 text-xs">
                                        <x-ui.icon name="users" class="w-3.5 h-3.5 text-muted-foreground" /> 4 Dewasa
                                    </span>
                                </x-ui.table.cell>
                                <x-ui.table.cell class="font-bold text-muted-foreground line-through">{{ format_rupiah(5800000) }}</x-ui.table.cell>
                                <x-ui.table.cell>
                                    <span class="font-semibold text-destructive">0 kamar</span>
                                </x-ui.table.cell>
                                <x-ui.table.cell>
                                    <x-ui.badge variant="destructive">Habis</x-ui.badge>
                                </x-ui.table.cell>
                                <x-ui.table.cell class="text-right">
                                    <x-ui.button size="sm" variant="outline" disabled>Kamar Penuh</x-ui.button>
                                </x-ui.table.cell>
                            </x-ui.table.row>
                        </x-ui.table.body>
                    </x-ui.table>
                </x-ui.tabs.content>

                {{-- Tab 3: Skeleton Preview --}}
                <x-ui.tabs.content value="skeleton" class="pt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-ui.card class="space-y-4 p-6">
                            <x-ui.skeleton class="h-44 w-full rounded-lg" />
                            <div class="space-y-2">
                                <x-ui.skeleton class="h-5 w-3/4" />
                                <x-ui.skeleton class="h-4 w-1/2" />
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <x-ui.skeleton class="h-6 w-28" />
                                <x-ui.skeleton class="h-9 w-24 rounded-md" />
                            </div>
                        </x-ui.card>

                        <x-ui.card class="space-y-4 p-6">
                            <x-ui.skeleton class="h-44 w-full rounded-lg" />
                            <div class="space-y-2">
                                <x-ui.skeleton class="h-5 w-3/4" />
                                <x-ui.skeleton class="h-4 w-1/2" />
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <x-ui.skeleton class="h-6 w-28" />
                                <x-ui.skeleton class="h-9 w-24 rounded-md" />
                            </div>
                        </x-ui.card>
                    </div>
                </x-ui.tabs.content>
            </x-ui.tabs>
        </section>

        {{-- 6. ALERTS & TOASTS --}}
        <section id="alerts" class="space-y-6">
            <div class="space-y-1">
                <h2 class="text-2xl font-bold tracking-tight">6. Peringatan (Alert) & Notifikasi (Toast)</h2>
                <p class="text-sm text-muted-foreground">Banner pesan informatif dan notifikasi mengambang (toast).</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-ui.alert variant="info" title="Informasi Protokol Check-in">
                    Check-in dibuka mulai pukul 14:00 WIB. Harap siapkan kartu identitas resmi (KTP/Paspor) saat kedatangan di resepsionis.
                </x-ui.alert>

                <x-ui.alert variant="success" title="Pembayaran Terverifikasi">
                    E-voucher untuk pesanan Anda telah diterbitkan. Silakan unduh bukti pemesanan di menu pesanan saya.
                </x-ui.alert>

                <x-ui.alert variant="warning" title="Batas Waktu Pembayaran">
                    Selesaikan pembayaran Anda dalam 15 menit agar kamar yang Anda pilih tidak dilepas ke pengguna lain.
                </x-ui.alert>

                <x-ui.alert variant="destructive" title="Metode Pembayaran Kedaluwarsa">
                    Batas waktu pembayaran telah habis. Kamar telah dikembalikan ke inventori sistem.
                </x-ui.alert>
            </div>

            <x-ui.card title="Uji Coba Toast Notification">
                <div class="flex flex-wrap items-center gap-3">
                    <x-ui.button
                        variant="default"
                        @click="$dispatch('toast', { title: 'Pemberitahuan Sukses', description: 'Voucher DISKONHOTEL20 berhasil diterapkan!', variant: 'success' })"
                    >
                        <x-ui.icon name="check-circle-2" class="w-4 h-4 mr-2" /> Toast Sukses
                    </x-ui.button>

                    <x-ui.button
                        variant="destructive"
                        @click="$dispatch('toast', { title: 'Gagal Memproses', description: 'Koneksi ke sistem payment gateway terputus.', variant: 'destructive' })"
                    >
                        <x-ui.icon name="alert-circle" class="w-4 h-4 mr-2" /> Toast Error
                    </x-ui.button>

                    <x-ui.button
                        variant="outline"
                        @click="$dispatch('toast', { title: 'Hotel Ditambahkan', description: 'The Mulia Resort Bali ditambahkan ke wishlist.', variant: 'default' })"
                    >
                        <x-ui.icon name="heart" class="w-4 h-4 mr-2" /> Toast Wishlist
                    </x-ui.button>
                </div>
            </x-ui.card>
        </section>

        {{-- 7. AVATAR & SEPARATOR --}}
        <section id="avatars" class="space-y-6">
            <div class="space-y-1">
                <h2 class="text-2xl font-bold tracking-tight">7. Avatar & Pemisah (Separator)</h2>
                <p class="text-sm text-muted-foreground">Profil pengguna, inisial fallback, dan garis batas.</p>
            </div>

            <x-ui.card>
                <div class="flex items-center gap-4 flex-wrap">
                    <div class="flex items-center gap-3">
                        <x-ui.avatar src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop" alt="Sarah Connor" size="xl" />
                        <x-ui.avatar src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop" alt="Budi Santoso" size="lg" />
                        <x-ui.avatar src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&auto=format&fit=crop" alt="Dewi Lestari" size="default" />
                        <x-ui.avatar alt="Citra Kirana" fallback="CK" size="sm" />
                    </div>

                    <x-ui.separator orientation="vertical" class="h-14 hidden sm:block" />

                    <div class="text-sm">
                        <div class="font-semibold">Reviewer Terverifikasi</div>
                        <div class="text-xs text-muted-foreground">Avatar otomatis menampilkan inisial jika foto tidak ada atau gagal dimuat.</div>
                    </div>
                </div>
            </x-ui.card>
        </section>
    </main>

    {{-- Footer --}}
    <footer class="border-t bg-muted/30 py-8 mt-12">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-muted-foreground">
            <div class="flex items-center gap-2">
                <span class="font-bold text-foreground">StayHub Indonesia</span>
                <span>•</span>
                <span>Traveloka Hotel-Only Web App</span>
            </div>
            <div>
                Dibuat dengan Laravel 13, Tailwind CSS v4, Alpine.js, dan Blade shadcn UI.
            </div>
        </div>
    </footer>
</x-layouts.app>

