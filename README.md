# Website Dinas PMD Kabupaten Katingan

Website resmi Dinas Pemberdayaan Masyarakat dan Desa (PMD) Kabupaten Katingan yang dirancang untuk menyediakan informasi publik, layanan digital, dan meningkatkan transparansi pemerintahan daerah.

## 🚀 Tech Stack

- **Framework:** Laravel 11.x
- **Frontend:** Blade Templates + TailwindCSS
- **Database:** MySQL
- **Server:** PHP 8.3+
- **Architecture:** Component-Based Design

## ✨ Fitur Utama

### � RESTful API
- **L5-Swagger Documentation** - OpenAPI 3.0 interactive documentation
- **Versioned API** - `/api/v1/...` untuk future compatibility
- **Rate Limiting** - 60 requests/minute protection
- **Endpoints Available:**
  - **News API** - List, detail, categories (search & filter support)
  - **Agenda API** - List, detail (date range & upcoming filters)
  - **Gallery API** - List, detail (searchable)
  - **Documents API** - List, detail, categories, download tracking
  - **Organization API** - Hierarchical structure, member details
  - **Information API** - Contact, vision-mission, welcome message
  - **Statistics API** - Overall stats, news stats, document stats
- **Response Format** - Consistent JSON (success, message, data, meta)
- **Pagination** - Max 50 items/page with meta & links
- **Documentation:** `/api/documentation` - Full Swagger UI interface

### �📰 Manajemen Konten
- **Berita & Artikel** - Publikasi berita terkini dengan sistem draft dan publish
- **Agenda Kegiatan** - Kalender acara dan kegiatan dinas
- **Galeri Foto** - Dokumentasi visual kegiatan dinas
- **Dokumen Publik** - Download peraturan, formulir, dan dokumen resmi

### 🏛️ Profil Organisasi
- **Visi & Misi** - Single entry dengan rich text editor
- **Struktur Organisasi** - Portrait Card Hierarchical System
  - **Portrait Design:** Card vertikal elegant dengan aspect ratio 3:4 (max 320px)
  - **Photo Dominance:** Foto prominent dengan gradient overlay (~75% area)
  - **Compact Info:** Info section clean dengan padding optimal (p-5)
  - **Duplicate Orders Allowed:** Urutan sama = bersanding horizontal sejajar ✅
  - **Flexible Hierarchy:** Input angka urutan yang sama untuk jabatan setara
  - **Dynamic Grid:** 1-4 columns responsive (sm:2 / lg:3 / xl:4)
  - **Connecting Lines:** Visual indicator alur komando antar level
  - **Consistent Styling:** Blue gradient badges untuk semua posisi
  - **Smart Responsive:** Grid max-width optimization dengan place-items-center
- **NIP Masking** - Display foto, NIP (masked 8 digit pertama), jabatan, dan detail pegawai
- **Kata Sambutan** - Pesan kepala dinas dengan foto dan status toggle

### 📞 Informasi & Kontak
- **Kontak Dinamis** - Email, telepon, WhatsApp (clickable links)
- **Sosial Media** - Integrasi Facebook, Instagram, Twitter, YouTube
- **Google Maps** - Embed maps dengan smart parsing (iframe/URL support)
- **Jam Operasional** - Informasi waktu layanan

### 📄 Manajemen Dokumen
- **Upload Multi-Format** - Support PDF, DOC, XLS, PPT, TXT, ZIP, RAR (max 10MB)
- **Smart Category System** - Hybrid dropdown + text input untuk kategori
- **Autocomplete** - Suggestions kategori yang sudah ada
- **Drag & Drop Upload** - Modern file upload interface
- **Download Tracking** - Counter otomatis untuk setiap download
- **Bulk Actions** - Aktivasi, non-aktivasi, dan hapus massal

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

# Generate API documentation
php artisan l5-swagger:generate

# Compile assets
npm run build

# Create storage link
php artisan storage:link

# Start development server
php artisan serve
```

**Access Points:**
- Website: `http://localhost:8000`
- Admin Panel: `http://localhost:8000/admin`
- API Documentation: `http://localhost:8000/api/documentation`

## 📁 Project Structure

```
app/
├── Http/Controllers/
│   ├── Admin/              # Admin panel controllers
│   │   ├── AdminContactController.php
│   │   ├── NewsController.php
│   │   ├── AgendaController.php
│   │   └── ...
│   ├── Api/V1/             # API V1 controllers
│   │   ├── Controller.php  # Base with OpenAPI annotations
│   │   ├── NewsController.php
│   │   ├── AgendaController.php
│   │   ├── GalleryController.php
│   │   ├── DocumentController.php
│   │   ├── OrganizationController.php
│   │   ├── InfoController.php
│   │   └── StatsController.php
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

routes/
├── web.php                 # Web routes
├── api.php                 # API routes (v1 with rate limiting)
└── auth.php                # Authentication routes

database/
├── migrations/             # Database schemas
└── seeders/               # Sample data

config/
└── l5-swagger.php         # Swagger/OpenAPI configuration

storage/api-docs/
└── api-docs.json          # Generated Swagger documentation

docs/
├── API_DOCUMENTATION.md    # Complete API guide
└── ...                     # Other documentation
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

### Document Category Enhancement
- **Hybrid Input** - Dropdown untuk kategori existing + text input untuk kategori baru
- **HTML5 Datalist** - Native autocomplete tanpa JavaScript library
- **Smart Suggestions** - Display available categories di help text
- **Data Consistency** - Mengurangi kategori duplikat akibat typo
- **Responsive** - Works seamlessly di mobile/tablet/desktop

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

# Regenerate API documentation
php artisan l5-swagger:generate

# Clear specific cache key
php artisan tinker
>>> Cache::forget('footer_contact')
```

## 🔌 API Usage

### Quick Start

```bash
# Get all news
curl "http://localhost:8000/api/v1/news?per_page=10"

# Get news by category
curl "http://localhost:8000/api/v1/news?category=Pengumuman"

# Get upcoming events
curl "http://localhost:8000/api/v1/agenda?upcoming=true"

# Get statistics
curl "http://localhost:8000/api/v1/stats"

# Get organization structure
curl "http://localhost:8000/api/v1/organization"
```

### Interactive Documentation
Access Swagger UI for interactive API testing:
```
http://localhost:8000/api/documentation
```

**Features:**
- ✅ Try out all endpoints directly from browser
- ✅ View request/response schemas
- ✅ See example values
- ✅ Test filters and pagination
- ✅ Download OpenAPI JSON spec

### Complete API Guide
See full documentation: [`docs/API_DOCUMENTATION.md`](docs/API_DOCUMENTATION.md)

**Topics covered:**
- All available endpoints
- Request/response formats
- Query parameters
- Error handling
- Rate limiting
- Best practices
- Code examples (cURL, JavaScript, etc.)

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
