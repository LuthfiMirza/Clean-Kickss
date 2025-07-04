# Sevatoo - Jasa Cuci Sepatu Laravel Application

## Deskripsi
Sevatoo adalah aplikasi web untuk jasa cuci sepatu yang dibangun menggunakan Laravel. Aplikasi ini merupakan hasil slicing dari template HTML/CSS yang telah dikonversi menjadi aplikasi Laravel yang dinamis.

## Fitur
- **Landing Page Responsif**: Tampilan yang menarik dan responsif untuk semua perangkat
- **Katalog Layanan**: Menampilkan berbagai jenis layanan cuci sepatu dengan harga
- **Keranjang Belanja**: Fitur untuk menambahkan layanan ke keranjang (JavaScript)
- **Dark/Light Theme**: Toggle tema gelap dan terang
- **Smooth Scrolling**: Navigasi yang halus antar section
- **Scroll Animations**: Animasi saat scroll menggunakan ScrollReveal
- **Mobile Navigation**: Menu hamburger untuk perangkat mobile

## Struktur Aplikasi

### Views
- `layouts/app.blade.php` - Layout utama aplikasi
- `home.blade.php` - Halaman beranda
- `about.blade.php` - Halaman tentang kami
- `partials/` - Komponen-komponen partial

### Controllers
- `HomeController.php` - Mengelola data layanan dan halaman beranda

### Assets
- `public/assets/css/styles.css` - Stylesheet utama
- `public/assets/js/main.js` - JavaScript untuk interaksi UI
- `public/assets/js/cart.js` - JavaScript untuk fitur keranjang
- `public/assets/img/` - Folder gambar dan ikon

## Layanan yang Tersedia
1. **Sepatu Sneakers** - Rp 55.000
2. **Sepatu Canvas** - Rp 60.000
3. **Sepatu Suede** - Rp 65.000
4. **Sepatu Leather** - Rp 65.000
5. **Sepatu Kets** - Rp 55.000
6. **Sepatu Bola** - Rp 50.000

## Instalasi dan Penggunaan

### Prasyarat
- PHP >= 8.0
- Composer
- Laravel 10.x

### Langkah Instalasi
1. Clone atau download project
2. Masuk ke direktori project
3. Install dependencies:
   ```bash
   composer install
   ```
4. Copy file environment:
   ```bash
   cp .env.example .env
   ```
5. Generate application key:
   ```bash
   php artisan key:generate
   ```
6. Jalankan development server:
   ```bash
   php artisan serve
   ```
7. Buka browser dan akses `http://127.0.0.1:8000`

## Routes
- `/` - Halaman beranda (HomeController@index)
- `/about` - Halaman tentang kami

## Teknologi yang Digunakan
- **Backend**: Laravel 10.x
- **Frontend**: HTML5, CSS3, JavaScript
- **Icons**: BoxIcons
- **Animations**: ScrollReveal.js
- **Fonts**: Google Fonts (Poppins)

## Fitur JavaScript
- **Mobile Menu Toggle**: Menampilkan/menyembunyikan menu di perangkat mobile
- **Smooth Scrolling**: Navigasi halus ke section tertentu
- **Active Link Highlighting**: Highlight menu aktif berdasarkan scroll position
- **Dark/Light Theme**: Toggle tema dengan penyimpanan di localStorage
- **Shopping Cart**: Sistem keranjang sederhana dengan notifikasi
- **Scroll Animations**: Animasi reveal saat scroll

## Struktur CSS
- **CSS Variables**: Menggunakan custom properties untuk konsistensi
- **Responsive Design**: Media queries untuk berbagai ukuran layar
- **Dark Theme Support**: Variabel CSS untuk tema gelap
- **Grid Layout**: CSS Grid untuk layout yang fleksibel

## Kontak
- **Alamat**: Jl. Letjen Pol. Soemarto No. 126, Purwokerto Utara, Banyumas
- **Telepon**: 085267145967
- **Email**: sevatoo@gmail.com

## Pengembangan Selanjutnya
- Integrasi dengan database untuk manajemen layanan
- Sistem autentikasi pengguna
- Sistem pemesanan online
- Payment gateway integration
- Admin panel untuk manajemen konten
- API untuk mobile application

---
*Dikembangkan dengan ❤️ menggunakan Laravel*