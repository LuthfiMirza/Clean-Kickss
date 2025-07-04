# Instruksi Setup Sistem Booking Cuci Sepatu

## Langkah-langkah Setup:

### 1. Persiapan Database
1. Buka XAMPP Control Panel
2. Start Apache dan MySQL
3. Buka phpMyAdmin (http://localhost/phpmyadmin)
4. Buat database baru dengan nama: `laravel_booking`

### 2. Konfigurasi Environment
1. Pastikan file `.env` sudah ada di root project
2. Update konfigurasi database di `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_booking
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Install Dependencies
Buka Command Prompt/Terminal di folder project dan jalankan:
```bash
composer install
```

### 4. Setup Database & Data
Jalankan perintah berikut satu per satu:
```bash
# Generate application key
php artisan key:generate

# Jalankan migration untuk membuat tabel
php artisan migrate

# Seed data layanan default
php artisan db:seed --class=ServiceSeeder

# Buat user admin untuk login
php artisan make:filament-user
```

Saat membuat user admin, masukkan:
- Name: Admin
- Email: admin@example.com
- Password: password (atau password pilihan Anda)

### 5. Akses Aplikasi
1. Pastikan XAMPP Apache masih berjalan
2. Buka browser dan akses: `http://localhost/fadil/laravel-project/public/admin`
3. Login dengan email dan password admin yang telah dibuat

## Fitur yang Tersedia:

### Dashboard
- Statistik booking, pelanggan, layanan
- Grafik booking per bulan
- Overview pendapatan

### Menu Pelanggan
- Tambah, edit, hapus data pelanggan
- Lihat riwayat booking

### Menu Layanan
- Kelola jenis layanan cuci sepatu
- Set harga dan durasi
- Aktifkan/nonaktifkan layanan

### Menu Booking
- Buat booking baru
- Pilih pelanggan dan layanan
- Atur jadwal pickup/delivery
- Tracking status booking
- Manajemen pembayaran

## Troubleshooting:

### Jika ada error "Class not found":
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### Jika migration error:
- Pastikan database `laravel_booking` sudah dibuat
- Cek koneksi database di `.env`

### Jika tidak bisa akses admin panel:
- Pastikan Apache XAMPP berjalan
- Cek URL: `http://localhost/fadil/laravel-project/public/admin`

## Data Default:
Sistem akan otomatis membuat 5 layanan default:
1. Cuci Sepatu Basic - Rp 25.000
2. Cuci Sepatu Premium - Rp 45.000  
3. Deep Cleaning - Rp 60.000
4. Repaint & Restore - Rp 100.000
5. Waterproof Treatment - Rp 35.000

Anda bisa menambah, edit, atau hapus layanan sesuai kebutuhan.