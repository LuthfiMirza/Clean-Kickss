# 👟 Sevato - Jasa Cuci Sepatu Laravel

Sistem manajemen booking jasa cuci sepatu berbasis web menggunakan Laravel dengan fitur lengkap untuk pelanggan dan admin.

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Teknologi](#-teknologi)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Penggunaan](#-penggunaan)
- [Struktur Database](#-struktur-database)
- [API Endpoints](#-api-endpoints)
- [Admin Panel](#-admin-panel)
- [User Dashboard](#-user-dashboard)
- [Troubleshooting](#-troubleshooting)
- [Kontribusi](#-kontribusi)

## 🚀 Fitur Utama

### Untuk Pelanggan:
- ✅ **Booking Online** - Pesan layanan cuci sepatu dengan mudah
- ✅ **Tracking Real-time** - Lacak status booking tanpa login
- ✅ **User Dashboard** - Dashboard pribadi untuk member terdaftar
- ✅ **Riwayat Booking** - Lihat semua booking yang pernah dibuat
- ✅ **Multiple Payment Methods** - Tunai, Transfer, E-Wallet, Kartu Kredit
- ✅ **Responsive Design** - Akses dari desktop dan mobile

### Untuk Admin:
- ✅ **Admin Panel** - Interface admin dengan Filament
- ✅ **Manajemen Booking** - CRUD lengkap untuk booking
- ✅ **Quick Status Update** - Tombol cepat update status
- ✅ **Bulk Operations** - Update multiple booking sekaligus
- ✅ **Manajemen Customer** - Kelola data pelanggan
- ✅ **Manajemen Service** - Kelola layanan dan harga

### Fitur Sistem:
- ✅ **Authentication** - Login/Register untuk pelanggan
- ✅ **Authorization** - Role-based access control
- ✅ **Email Notifications** - Notifikasi otomatis
- ✅ **Search & Filter** - Pencarian dan filter data
- ✅ **Dark/Light Theme** - Mode gelap dan terang
- ✅ **Multi-language Ready** - Siap untuk multi bahasa

## 🛠 Teknologi

### Backend:
- **Laravel 11** - PHP Framework
- **MySQL** - Database
- **Filament 3** - Admin Panel
- **Laravel Sanctum** - API Authentication

### Frontend:
- **Blade Templates** - Server-side rendering
- **Custom CSS** - Styling kustom dengan CSS Variables
- **JavaScript** - Interaktivitas dan AJAX
- **BoxIcons** - Icon library
- **Responsive Design** - Mobile-first approach

### Tools & Libraries:
- **Composer** - PHP Package Manager
- **NPM** - Node Package Manager
- **Vite** - Asset bundling
- **Carbon** - Date manipulation

## 📦 Instalasi

### Prasyarat:
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/MariaDB
- Web Server (Apache/Nginx)

### Langkah Instalasi:

1. **Clone Repository**
```bash
git clone https://github.com/username/sevato-laravel.git
cd sevato-laravel
```

2. **Install Dependencies**
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

3. **Environment Setup**
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

4. **Database Setup**
```bash
# Create database
mysql -u root -p
CREATE DATABASE sevato_db;

# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed
```

5. **Build Assets**
```bash
# Development
npm run dev

# Production
npm run build
```

6. **Start Server**
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## ⚙️ Konfigurasi

### Database Configuration (.env):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sevato_db
DB_USERNAME=root
DB_PASSWORD=
```

### Mail Configuration (.env):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Sevato"
```

### Admin User:
Buat admin user pertama:
```bash
php artisan make:filament-user
```

## 📱 Penggunaan

### Untuk Pelanggan:

#### 1. Booking Tanpa Registrasi:
- Kunjungi halaman booking: `/booking/create`
- Isi form booking dengan data lengkap
- Pilih layanan dan jadwal
- Submit booking
- Dapatkan ID booking untuk tracking

#### 2. Tracking Booking:
- Kunjungi halaman tracking: `/booking/track`
- Masukkan nomor telepon
- Masukkan ID booking (opsional)
- Lihat status dan progress booking

#### 3. Registrasi & Login:
- Daftar akun: `/register`
- Login: `/login`
- Akses dashboard: `/dashboard`

#### 4. Dashboard Member:
- Lihat statistik booking
- Riwayat booking lengkap
- Update profil
- Hubungkan booking lama

### Untuk Admin:

#### 1. Akses Admin Panel:
- Login admin: `/admin`
- Dashboard admin dengan statistik
- Manajemen data lengkap

#### 2. Manajemen Booking:
- Lihat semua booking: `/admin/bookings`
- Update status dengan tombol cepat
- Bulk operations untuk multiple booking
- Filter dan search booking

#### 3. Manajemen Data:
- Customer: `/admin/customers`
- Services: `/admin/services`
- Reports dan analytics

## 🗄️ Struktur Database

### Tabel Utama:

#### `users` - Data User/Member
```sql
- id (Primary Key)
- name (VARCHAR)
- email (VARCHAR, Unique)
- phone (VARCHAR, Nullable)
- password (VARCHAR)
- email_verified_at (TIMESTAMP)
- created_at, updated_at
```

#### `customers` - Data Pelanggan
```sql
- id (Primary Key)
- name (VARCHAR)
- phone (VARCHAR)
- email (VARCHAR, Nullable)
- address (TEXT)
- created_at, updated_at
```

#### `services` - Layanan Cuci Sepatu
```sql
- id (Primary Key)
- name (VARCHAR)
- description (TEXT)
- price (DECIMAL)
- duration_minutes (INTEGER)
- is_active (BOOLEAN)
- created_at, updated_at
```

#### `bookings` - Data Booking
```sql
- id (Primary Key)
- customer_id (Foreign Key)
- service_id (Foreign Key)
- booking_date (DATE)
- pickup_time (DATETIME)
- delivery_time (DATETIME, Nullable)
- status (ENUM)
- notes (TEXT, Nullable)
- total_price (DECIMAL)
- payment_status (ENUM)
- payment_method (ENUM)
- created_at, updated_at
```

### Status Enums:

#### Booking Status:
- `pending` - Menunggu Konfirmasi
- `confirmed` - Dikonfirmasi
- `picked_up` - Sudah Diambil
- `in_progress` - Sedang Dikerjakan
- `ready` - Siap Diantar
- `delivered` - Sudah Diantar
- `cancelled` - Dibatalkan

#### Payment Status:
- `pending` - Belum Bayar
- `paid` - Sudah Bayar
- `refunded` - Dikembalikan

## 🔗 API Endpoints

### Public Routes:
```
GET  /                     - Homepage
GET  /about               - About page
GET  /booking             - Service list
GET  /booking/create      - Booking form
POST /booking             - Submit booking
GET  /booking/track       - Tracking form
POST /booking/track       - Track booking
GET  /booking/{id}        - Booking detail
```

### Authentication Routes:
```
GET  /login               - Login form
POST /login               - Login process
GET  /register            - Register form
POST /register            - Register process
POST /logout              - Logout
```

### Protected Routes (Auth Required):
```
GET  /dashboard           - User dashboard
GET  /dashboard/profile   - User profile
PUT  /dashboard/profile   - Update profile
GET  /dashboard/bookings  - User bookings
POST /dashboard/search-bookings - Search bookings
POST /dashboard/update-phone    - Update phone
```

### Admin Routes:
```
GET  /admin               - Admin dashboard
GET  /admin/bookings      - Booking management
GET  /admin/customers     - Customer management
GET  /admin/services      - Service management
```

## 👨‍💼 Admin Panel

### Fitur Admin Panel:

#### 1. Dashboard:
- Statistik booking harian/bulanan
- Grafik pendapatan
- Status booking overview
- Quick actions

#### 2. Booking Management:
- **List View**: Tabel booking dengan filter dan search
- **Quick Actions**: Tombol status update per booking
- **Bulk Actions**: Update multiple booking sekaligus
- **Detail View**: Informasi lengkap booking
- **Edit Form**: Update data booking

#### 3. Status Update Buttons:
```
Menunggu Konfirmasi → [Konfirmasi] → Dikonfirmasi
Dikonfirmasi → [Diambil] → Sudah Diambil
Sudah Diambil → [Proses] → Sedang Dikerjakan
Sedang Dikerjakan → [Siap] → Siap Diantar
Siap Diantar → [Antar] → Sudah Diantar
[Batal] - Available at any stage
```

#### 4. Customer Management:
- CRUD customer data
- Booking history per customer
- Customer statistics

#### 5. Service Management:
- CRUD service data
- Pricing management
- Service analytics

## 👤 User Dashboard

### Fitur User Dashboard:

#### 1. Overview:
- **Statistics Cards**:
  - Total Booking
  - Menunggu Konfirmasi
  - Sedang Proses
  - Selesai

#### 2. Recent Bookings:
- 5 booking terbaru
- Status dan progress
- Quick access ke detail

#### 3. Quick Actions:
- Booking Baru
- Lihat Semua Booking
- Manage Profile

#### 4. Booking Search:
- Cari booking lama berdasarkan nomor telepon
- Hubungkan booking ke akun
- Auto-update profile

#### 5. Profile Management:
- Update data personal
- Statistik booking
- Account information

## 🎨 Styling & Theming

### CSS Architecture:
- **CSS Variables** untuk theming
- **Mobile-first** responsive design
- **Component-based** styling
- **Dark/Light theme** support

### Color Scheme:
```css
:root {
  --first-color: #0098ff;
  --first-color-alt: #0086df;
  --title-color: #393939;
  --text-color: #707070;
  --text-color-light: #a6a6a6;
  --body-color: #fbfefd;
  --container-color: #ffffff;
}
```

### Responsive Breakpoints:
- Mobile: < 768px
- Tablet: 768px - 960px
- Desktop: > 960px

## 🔧 Troubleshooting

### Common Issues:

#### 1. Database Connection Error:
```bash
# Check database credentials in .env
# Ensure MySQL service is running
# Test connection:
php artisan tinker
DB::connection()->getPdo();
```

#### 2. Permission Issues:
```bash
# Set proper permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### 3. Asset Not Loading:
```bash
# Rebuild assets
npm run build
php artisan config:clear
php artisan cache:clear
```

#### 4. Admin Panel Not Accessible:
```bash
# Create admin user
php artisan make:filament-user
```

#### 5. Booking Not Showing in Dashboard:
- Check if user phone number matches customer phone
- Use search feature to find and connect bookings
- Verify booking status values in database

### Debug Mode:
Enable debug mode in `.env`:
```env
APP_DEBUG=true
```

## 📊 Performance Optimization

### Database Optimization:
- Proper indexing on foreign keys
- Eager loading relationships
- Query optimization
- Database connection pooling

### Caching:
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache
```

### Asset Optimization:
```bash
# Minify assets for production
npm run build
```

## 🔒 Security

### Security Features:
- **CSRF Protection** - All forms protected
- **SQL Injection Prevention** - Eloquent ORM
- **XSS Protection** - Blade templating
- **Authentication** - Laravel Sanctum
- **Authorization** - Role-based access
- **Input Validation** - Form requests
- **Password Hashing** - Bcrypt

### Security Best Practices:
- Regular security updates
- Environment variable protection
- HTTPS in production
- Rate limiting
- Input sanitization

## 🚀 Deployment

### Production Deployment:

#### 1. Server Requirements:
- PHP 8.2+
- MySQL 8.0+
- Nginx/Apache
- SSL Certificate
- Composer
- Node.js

#### 2. Deployment Steps:
```bash
# Clone repository
git clone https://github.com/username/sevato-laravel.git

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Environment setup
cp .env.example .env
# Configure production environment

# Database setup
php artisan migrate --force

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
chmod -R 755 storage bootstrap/cache
```

#### 3. Web Server Configuration:

**Nginx Configuration:**
```nginx
server {
    listen 80;
    server_name sevato.com;
    root /var/www/sevato/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## 📈 Monitoring & Analytics

### Logging:
- Application logs in `storage/logs/`
- Error tracking
- Performance monitoring
- User activity logs

### Analytics:
- Booking statistics
- Revenue tracking
- Customer analytics
- Service performance

## 🤝 Kontribusi

### Development Workflow:

1. **Fork Repository**
2. **Create Feature Branch**
```bash
git checkout -b feature/new-feature
```

3. **Make Changes**
4. **Run Tests**
```bash
php artisan test
```

5. **Submit Pull Request**

### Coding Standards:
- PSR-12 coding standard
- Laravel best practices
- Proper documentation
- Unit testing

### Commit Message Format:
```
type(scope): description

feat(booking): add status update buttons
fix(auth): resolve login redirect issue
docs(readme): update installation guide
```

## 📞 Support

### Getting Help:
- **Documentation**: Check this README
- **Issues**: GitHub Issues
- **Email**: support@sevato.com
- **Discord**: Sevato Community

### Bug Reports:
Include:
- Laravel version
- PHP version
- Error message
- Steps to reproduce
- Expected behavior

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Laravel Framework
- Filament Admin Panel
- BoxIcons
- Community contributors

---

## 📝 Changelog

### v1.0.0 (2024-01-01)
- Initial release
- Basic booking system
- Admin panel
- User authentication

### v1.1.0 (2024-01-15)
- User dashboard
- Booking tracking
- Status update buttons
- Mobile responsive design

### v1.2.0 (2024-02-01)
- Bulk operations
- Advanced search
- Email notifications
- Performance improvements

---

**Dibuat dengan ❤️ untuk industri jasa cuci sepatu Indonesia**

## 🔗 Links

- **Live Demo**: [https://sevato-demo.com](https://sevato-demo.com)
- **Documentation**: [https://docs.sevato.com](https://docs.sevato.com)
- **GitHub**: [https://github.com/username/sevato-laravel](https://github.com/username/sevato-laravel)
- **Website**: [https://sevato.com](https://sevato.com)