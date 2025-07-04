# Sistem Booking Cuci Sepatu

Sistem manajemen booking untuk jasa cuci sepatu menggunakan Laravel dan Filament Admin Panel.

## Fitur Utama

### 1. Manajemen Pelanggan
- Tambah, edit, hapus data pelanggan
- Informasi lengkap: nama, telepon, email, alamat
- Riwayat booking pelanggan

### 2. Manajemen Layanan
- Berbagai jenis layanan cuci sepatu
- Pengaturan harga dan durasi
- Status aktif/non-aktif layanan
- Layanan default yang tersedia:
  - Cuci Sepatu Basic (Rp 25.000)
  - Cuci Sepatu Premium (Rp 45.000)
  - Deep Cleaning (Rp 60.000)
  - Repaint & Restore (Rp 100.000)
  - Waterproof Treatment (Rp 35.000)

### 3. Sistem Booking
- Booking dengan informasi lengkap
- Tracking status booking:
  - Menunggu Konfirmasi
  - Dikonfirmasi
  - Sudah Diambil
  - Sedang Dikerjakan
  - Siap Diantar
  - Sudah Diantar
  - Dibatalkan
- Manajemen pembayaran:
  - Status: Belum Bayar, Sudah Bayar, Dikembalikan
  - Metode: Tunai, Transfer, E-Wallet, Kartu Kredit
- Penjadwalan pickup dan delivery
- Catatan khusus untuk setiap booking

### 4. Dashboard & Statistik
- Widget statistik:
  - Total booking
  - Booking pending
  - Booking selesai
  - Total pelanggan
  - Layanan aktif
  - Total pendapatan
- Grafik booking per bulan
- Overview bisnis secara real-time

## Instalasi & Setup

### 1. Persiapan
Pastikan XAMPP sudah terinstall dan berjalan (Apache + MySQL).

### 2. Setup Database
1. Buka phpMyAdmin
2. Buat database baru dengan nama `laravel_booking`
3. Update file `.env` dengan konfigurasi database:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_booking
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Instalasi Dependencies
```bash
composer install
npm install
```

### 4. Setup Aplikasi
Jalankan file `setup-booking-system.bat` atau jalankan perintah berikut secara manual:

```bash
# Jalankan migration
php artisan migrate

# Seed data layanan
php artisan db:seed --class=ServiceSeeder

# Buat user admin
php artisan make:filament-user
```

### 5. Akses Aplikasi
- Admin Panel: `http://localhost/fadil/laravel-project/public/admin`
- Login dengan user admin yang telah dibuat

## Struktur Database

### Tabel Customers
- id, name, phone, email, address, timestamps

### Tabel Services
- id, name, description, price, duration_minutes, is_active, timestamps

### Tabel Bookings
- id, customer_id, service_id, booking_date, pickup_time, delivery_time
- status, notes, total_price, payment_status, payment_method, timestamps

## Penggunaan

### 1. Mengelola Pelanggan
- Masuk ke menu "Pelanggan"
- Tambah pelanggan baru atau edit yang sudah ada
- Lihat riwayat booking setiap pelanggan

### 2. Mengelola Layanan
- Masuk ke menu "Layanan"
- Tambah layanan baru dengan harga dan durasi
- Aktifkan/nonaktifkan layanan sesuai kebutuhan

### 3. Membuat Booking
- Masuk ke menu "Booking"
- Klik "Tambah Booking"
- Pilih pelanggan (atau buat baru)
- Pilih layanan (harga otomatis terisi)
- Atur jadwal pickup dan delivery
- Set status dan metode pembayaran
- Tambah catatan jika diperlukan

### 4. Tracking Booking
- Update status booking sesuai progress
- Ubah status pembayaran saat pelanggan bayar
- Filter booking berdasarkan status atau tanggal

## Customization

### Menambah Status Booking Baru
Edit file `app/Models/Booking.php` dan tambahkan konstanta status baru, kemudian update di `BookingResource.php`.

### Menambah Metode Pembayaran
Update array options di `BookingResource.php` pada bagian payment_method.

### Menambah Widget Dashboard
Buat widget baru di `app/Filament/Widgets/` dan daftarkan di `AdminPanelProvider.php`.

## Troubleshooting

### Error Migration
- Pastikan database sudah dibuat
- Cek konfigurasi `.env`
- Jalankan `php artisan config:clear`

### Error Filament
- Pastikan semua dependencies terinstall
- Jalankan `php artisan filament:install --panels`

### Error Permission
- Set permission folder storage dan bootstrap/cache
- Jalankan `php artisan storage:link`

## Support

Untuk bantuan lebih lanjut, silakan hubungi developer atau buat issue di repository ini.