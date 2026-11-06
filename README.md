# StayHub - Aplikasi Web Pemesanan Kamar Hotel (Traveloka Style)

StayHub adalah aplikasi web pemesanan kamar hotel (hotel-only online booking) modern yang dibangun menggunakan **Laravel 13**, **MySQL**, **Tailwind CSS v4**, **Alpine.js**, dan komponen Blade bergaya **shadcn/ui**.

---

## 🌟 Fitur Utama

### 1. Sisi Pengguna (Customer)
- **Beranda (Homepage):**
  - Hero search bar interaktif: input kota/hotel, tanggal check-in & check-out, jumlah tamu dan kamar (Alpine.js popover counter).
  - Destinasi kota terpopuler di Indonesia beserta jumlah hotel aktif.
  - Rekomendasi hotel berbintang dengan rating rata-rata ulasan.
  - Kupon dan voucher diskon promo yang dapat langsung disalin kodenya.
- **Pencarian & Filter Cerdas (`/search`):**
  - Filter rentang harga (minimum & maksimum per malam).
  - Filter bintang hotel (1 sampai 5 bintang).
  - Filter fasilitas hotel (Kolam Renang, WiFi, Gym, Spa, Restoran, dsb).
  - Filter tipe properti (Hotel, Resort, Villa, Apartment).
  - Sorting: Terpopuler, Rating Tertinggi, Harga Terendah, Harga Tertinggi.
  - Pagination dinamis bergaya shadcn/ui dan state saat hotel tidak ditemukan.
- **Detail Hotel (`/hotels/{slug}`):**
  - Galeri foto cover dan kamar.
  - Pemilih tanggal dan jumlah kamar dengan pengecekan ketersediaan harian secara real-time.
  - Daftar tipe kamar beserta sisa ketersediaan unit untuk tanggal yang dipilih.
  - Fasilitas properti, kebijakan jam check-in/check-out, serta ulasan dan rating dari tamu asli.
  - Fitur simpan ke **Wishlist**.
- **Alur Booking & Pembayaran:**
  - Form data kontak pemesan dan tamu utama + permintaan khusus (special requests).
  - Validasi kode kupon promo/voucher dinamis secara AJAX.
  - Perhitungan rincian biaya: harga kamar x malam x kamar, Pajak Daerah (10%), Biaya Layanan platform (Rp 25.000), dan diskon voucher.
  - Pencegahan overbooking dengan `DB::transaction` dan `lockForUpdate` pada baris ketersediaan kamar `room_inventories`.
  - Halaman pembayaran lengkap dengan countdown timer 60 menit dan simulasi pembayaran instan (Bank Virtual Account, QRIS, Kartu Kredit).
  - Penerbitan **E-Voucher resmi** yang siap dicetak langsung atau disimpan ke format PDF (`window.print()`).
- **Akun Pengguna (`/account`):**
  - **Pesanan Saya:** Riwayat pemesanan dengan filter status (*Menunggu Bayar, Lunas, Selesai, Dibatalkan*).
  - **Detail Pesanan:** Informasi reservasi, status, tombol cetak e-voucher, serta pembatalan pesanan (stok kamar otomatis dikembalikan).
  - **Tulis Ulasan:** Formulir pemberian rating bintang (1-5) dan review pengalaman menginap setelah pesanan lunas.
  - **Wishlist:** Daftar hotel favorit yang tersimpan.
  - **Profil Saya:** Update nama, email, no telepon, dan ganti kata sandi.

---

### 2. Sisi Panel Admin (`/admin`)
- **Dashboard Ringkasan:** Statistik Total Hotel, Total Transaksi Pesanan, Total Pendapatan, Total Pengguna, dan tabel transaksi terkini.
- **Kelola Hotel (`/admin/hotels`):**
  - CRUD hotel lengkap (nama, alamat, kota, koordinat, bintang, deskripsi, kebijakan, fasilitas, dan foto cover).
  - Tombol toggle status aktif/nonaktif hotel instan.
- **Kelola Tipe Kamar & Inventori Harian (`/admin/hotels/{hotel}/rooms`):**
  - CRUD tipe kamar (nama, kapasitas tamu, tipe tempat tidur, luas m², total unit fisik, fasilitas kamar).
  - **Kalender / Tabel Inventori 30 Hari:** Menampilkan ketersediaan kamar harian dan harga dinamis.
  - **Bulk Update Inventori:** Pengubahan massal jumlah ketersediaan kamar dan harga untuk rentang tanggal tertentu (*date-range*).
- **Kelola Pesanan (`/admin/bookings`):**
  - Monitoring seluruh transaksi pesanan hotel dengan pencarian & filter status.
  - Konfirmasi pembayaran manual (*Admin Override*).
  - Pembatalan pesanan (mengembalikan ketersediaan kamar otomatis).
  - Penandaan pesanan selesai setelah tamu check-out.
- **Kelola Kupon Voucher (`/admin/vouchers`):**
  - CRUD voucher diskon (tipe persen atau potongan tetap rupiah, minimum transaksi, batas diskon maksimal, kuota penggunaan, dan masa berlaku).
- **Moderasi Ulasan (`/admin/reviews`):**
  - Menampilkan seluruh ulasan pelanggan dan fitur hapus ulasan jika tidak pantas/spam.
- **Kelola Pengguna (`/admin/users`):**
  - Daftar seluruh akun terdaftar beserta total pesanan hotel yang dilakukan.
  - Pengubahan role pengguna (Customer <-> Admin).

---

## 🔐 Akun Login Bawaan

| Role | Email | Password | Keterangan |
|------|-------|----------|------------|
| **Admin** | `admin@example.com` | `password` | Memiliki akses penuh ke panel admin di `/admin` |
| **User** | `user@example.com` | `password` | Akun pengguna biasa untuk memesan hotel |

---

## 🛠️ Panduan Instalasi & Menjalankan

### Persyaratan Sistem
- PHP 8.2 atau lebih baru (disarankan PHP 8.4 / 8.5)
- Composer
- Node.js (v20 atau v22)
- MySQL / MariaDB

### Langkah Instalasi
1. **Clone atau buka direktori proyek:**
   ```bash
   cd c:\laragon\www\dadan
   ```

2. **Install Dependensi PHP & JavaScript:**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment (`.env`):**
   Pastikan pengaturan koneksi database MySQL sudah sesuai:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=tugasbooking
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Jalankan Migrasi & Seeder Database:**
   ```bash
   php artisan migrate:fresh --seed
   ```
   *Seeder mencakup 8 kota populer, 30 hotel pilihan, 90 tipe kamar dengan inventori 90 hari ke depan, 4 voucher diskon aktif, 15 fasilitas hotel & kamar, akun admin, serta pelanggan.*

5. **Build Aset Frontend (Tailwind CSS v4 & Alpine.js):**
   ```bash
   npm run build
   # Atau untuk mode pengembangan (hot-reload):
   npm run dev
   ```

6. **Menjalankan Scheduler Otomatis (Pembatalan Pesanan Kedaluwarsa):**
   Pesanan yang berstatus pending dan melebihi batas waktu (60 menit) akan otomatis dibatalkan dan stok kamar dikembalikan:
   ```bash
   # Jalankan secara manual / cron:
   php artisan bookings:expire

   # Atau jalankan Laravel scheduler worker:
   php artisan schedule:work
   ```

7. **Menjalankan Queue Worker (Opsional):**
   ```bash
   php artisan queue:work
   ```

---

## 🧪 Menjalankan Pengujian Otomatis (Pest Tests)

Seluruh logika bisnis penting, mulai dari pencarian, alur booking dengan database lock, kupon promo, hingga panel admin telah dicakup oleh pengujian otomatis:

```bash
php vendor/pestphp/pest/bin/pest
```
**Hasil:**
- 33 Tests Passed (123 Assertions)
