# Website Dinas PMD Kabupaten Katingan

Website resmi Dinas Pemberdayaan Masyarakat dan Desa (PMD) Kabupaten Katingan yang dirancang untuk menyediakan informasi publik, layanan digital, dan meningkatkan transparansi pemerintahan daerah.

## 🚀 Tech Stack

- **Framework:** Laravel 11.x
- **Frontend:** Blade Templates + TailwindCSS
- **Database:** MySQL
- **Server:** PHP 8.3+
- **Architecture:** Component-Based Design

## ✨ Fitur Utama

### 📰 Manajemen Konten
- **Berita & Artikel** - Publikasi berita terkini dengan sistem draft dan publish
- **Agenda Kegiatan** - Kalender acara dan kegiatan dinas
- **Galeri Foto** - Dokumentasi visual kegiatan dinas
- **Dokumen Publik** - Download peraturan, formulir, dan dokumen resmi

### 🏛️ Profil Organisasi
- **Visi & Misi** - Single entry dengan rich text editor
- **Struktur Organisasi** - Display foto, NIP (masked), jabatan, dan detail pegawai
- **Kata Sambutan** - Pesan kepala dinas dengan foto dan status toggle

### 📞 Informasi & Kontak
- **Kontak Dinamis** - Email, telepon, WhatsApp (clickable links)
- **Sosial Media** - Integrasi Facebook, Instagram, Twitter, YouTube
- **Google Maps** - Embed maps dengan smart parsing (iframe/URL support)
- **Jam Operasional** - Informasi waktu layanan

### 🎨 UI/UX Features
- **Responsive Design** - Optimal di mobile, tablet, dan desktop
- **Hero Slider** - Banner dinamis dengan call-to-action
- **Component-Based** - Reusable components untuk maintainability
- **Caching System** - Redis/file cache untuk performa optimal
- **Dark Footer** - Footer dinamis dengan data tersinkronisasi

## 📋 Requirement

- PHP >= 8.3
- Composer
- MySQL/MariaDB
- Node.js & NPM (untuk asset compilation)

## 🛠️ Installation

```bash
# Clone repository
git clone https://github.com/ahmadfadlilahr/Pemdes-Katingan.git
cd Pemdes-Katingan

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed

# Compile assets
npm run build

# Create storage link
php artisan storage:link

# Start development server
php artisan serve
```

## 📁 Project Structure

```
app/
├── Http/Controllers/
│   ├── Admin/              # Admin panel controllers
│   │   ├── AdminContactController.php
│   │   ├── NewsController.php
│   │   ├── AgendaController.php
│   │   └── ...
│   └── PublicController.php
├── Models/
│   ├── Contact.php
│   ├── News.php
│   ├── Agenda.php
│   ├── Gallery.php
│   └── ...
└── View/Components/        # Blade components

resources/views/
├── admin/                  # Admin panel views
├── public/                 # Public website views
├── components/
│   ├── admin/              # Admin components
│   └── public/             # Public components
└── layouts/

database/
├── migrations/             # Database schemas
└── seeders/               # Sample data
```

## 🎯 Key Features Implementation

### Privacy Protection
- **NIP Masking** - Sensor 8 digit pertama NIP (tanggal lahir) untuk privasi pegawai
- **Component:** `masked-nip.blade.php`

### Single Entry Enforcement
- **Visi & Misi** - Hanya 1 entry aktif
- **Kata Sambutan** - Hanya 1 entry aktif
- **Kontak Informasi** - Hanya 1 entry aktif

### Dynamic Content
- **Contact Info** - Sidebar beranda, footer, dan halaman kontak menggunakan data yang sama
- **Social Media** - Footer icons dinamis dari database
- **Caching:** 1-hour cache dengan auto-invalidation saat data diupdate

### Google Maps Integration
- **Smart Parsing** - Support iframe HTML atau direct URL
- **Responsive** - 16:9 aspect ratio maintained
- **Lazy Loading** - Performance optimization

## 📚 Documentation

Dokumentasi lengkap tersedia untuk setiap fitur:

- [`ORGANIZATION_STRUCTURE_DOCUMENTATION.md`](ORGANIZATION_STRUCTURE_DOCUMENTATION.md) - NIP masking & struktur organisasi
- [`CONTACT_MANAGEMENT_DOCUMENTATION.md`](CONTACT_MANAGEMENT_DOCUMENTATION.md) - Kelola kontak & single entry
- [`WELCOME_MESSAGE_DOCUMENTATION.md`](WELCOME_MESSAGE_DOCUMENTATION.md) - Kata sambutan & card redesign
- [`GOOGLE_MAPS_DOCUMENTATION.md`](GOOGLE_MAPS_DOCUMENTATION.md) - Maps embed fix & smart parsing
- [`HOME_CONTACT_INFO_DOCUMENTATION.md`](HOME_CONTACT_INFO_DOCUMENTATION.md) - Beranda sidebar informasi cepat
- [`FOOTER_DYNAMIC_DOCUMENTATION.md`](FOOTER_DYNAMIC_DOCUMENTATION.md) - Footer kontak & sosial media dinamis


## 🚀 Deployment

### Production Setup

```bash
# Optimize application
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Setup queue worker (optional)
php artisan queue:work --daemon
```

### Environment Variables

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://pmdkatingan.go.id

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

## 🧪 Testing

```bash
# Run tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
```

## 🔄 Cache Management

```bash
# Clear all cache
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

# Clear specific cache key
php artisan tinker
>>> Cache::forget('footer_contact')
```

## 📊 Performance Optimization

- ✅ **Caching Strategy** - 1-hour cache untuk static content
- ✅ **Lazy Loading** - Images dan embeds
- ✅ **Asset Optimization** - Minified CSS/JS dengan Vite
- ✅ **Query Optimization** - Eager loading untuk relationships
- ✅ **CDN Ready** - Asset structure support untuk CDN

## 🛡️ Security Features

- ✅ **CSRF Protection** - Semua forms protected
- ✅ **XSS Prevention** - Blade auto-escaping
- ✅ **SQL Injection** - Eloquent ORM prepared statements
- ✅ **Password Hashing** - Bcrypt algorithm
- ✅ **Input Validation** - Server-side validation
- ✅ **External Links** - `rel="noopener noreferrer"` untuk security

## 🤝 Contributing

Untuk berkontribusi pada project ini:

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📝 License

Project ini adalah milik **Dinas PMD Kabupaten Katingan**.

Dibangun dengan ❤️ menggunakan [Laravel Framework](https://laravel.com) - Licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

**Dinas Pemberdayaan Masyarakat dan Desa**  
Kabupaten Katingan, Kalimantan Tengah  
© 2025 - All Rights Reserved
