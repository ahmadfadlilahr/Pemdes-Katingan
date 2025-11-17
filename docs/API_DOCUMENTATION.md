# API Documentation - Dinas PMD Katingan

## 📚 Gambaran Umum

API RESTful ini menyediakan akses terhadap data Dinas Pemberdayaan Masyarakat dan Desa (PMD) Kabupaten Katingan untuk developer eksternal dan integrasi aplikasi.

### Base URL
```
http://your-domain.com/api/v1
```

### Format Response
Semua endpoint mengembalikan response dalam format JSON dengan struktur:

**Success Response:**
```json
{
  "success": true,
  "message": "Success message",
  "data": { ... }
}
```

**Error Response:**
```json
{
  "success": false,
  "message": "Error message",
  "errors": { ... }
}
```

**Paginated Response:**
```json
{
  "success": true,
  "message": "Success message",
  "data": [ ... ],
  "meta": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 15,
    "total": 75
  },
  "links": {
    "first": "...",
    "last": "...",
    "prev": null,
    "next": "..."
  }
}
```

---

## 📰 News Endpoints

### 1. Get All News
Mendapatkan daftar berita dengan pagination dan filter.

**Endpoint:** `GET /api/v1/news`

**Query Parameters:**
- `per_page` (optional, default: 15, max: 50) - Jumlah item per halaman
- `page` (optional, default: 1) - Nomor halaman
- `search` (optional) - Pencarian di title dan content
- `category` (optional) - Filter berdasarkan kategori

**Example Request:**
```bash
curl "http://localhost:8000/api/v1/news?per_page=10&category=Pengumuman&search=desa"
```

**Example Response:**
```json
{
  "success": true,
  "message": "News retrieved successfully",
  "data": [
    {
      "id": 1,
      "title": "Judul Berita",
      "slug": "judul-berita",
      "content": "Konten berita...",
      "category": "Pengumuman",
      "featured_image": "http://localhost/storage/news/image.jpg",
      "author": {
        "id": 1,
        "name": "Admin"
      },
      "views": 150,
      "published_at": "2025-01-15T10:30:00+07:00"
    }
  ],
  "meta": { ... },
  "links": { ... }
}
```

### 2. Get News Detail
Mendapatkan detail berita berdasarkan slug.

**Endpoint:** `GET /api/v1/news/{slug}`

**Example Request:**
```bash
curl "http://localhost:8000/api/v1/news/pembangunan-jalan-desa"
```

### 3. Get News Categories
Mendapatkan daftar kategori berita yang tersedia.

**Endpoint:** `GET /api/v1/news/categories`

**Example Response:**
```json
{
  "success": true,
  "message": "Categories retrieved successfully",
  "data": [
    "Berita",
    "Pengumuman",
    "Kegiatan",
    "Program"
  ]
}
```

---

## 📅 Agenda Endpoints

### 1. Get All Agenda
Mendapatkan daftar agenda/event dengan filter.

**Endpoint:** `GET /api/v1/agenda`

**Query Parameters:**
- `per_page` (optional, default: 15, max: 50)
- `page` (optional, default: 1)
- `from_date` (optional, format: YYYY-MM-DD) - Filter dari tanggal
- `to_date` (optional, format: YYYY-MM-DD) - Filter sampai tanggal
- `upcoming` (optional, boolean) - Hanya agenda mendatang

**Example Request:**
```bash
curl "http://localhost:8000/api/v1/agenda?upcoming=true&per_page=5"
```

**Example Response:**
```json
{
  "success": true,
  "message": "Agenda retrieved successfully",
  "data": [
    {
      "id": 1,
      "title": "Rapat Koordinasi",
      "description": "Rapat koordinasi pembangunan desa",
      "location": "Kantor PMD",
      "start_date": "2025-01-20",
      "start_time": "09:00:00",
      "end_date": "2025-01-20",
      "end_time": "12:00:00",
      "is_full_day": false
    }
  ],
  "meta": { ... }
}
```

### 2. Get Agenda Detail
**Endpoint:** `GET /api/v1/agenda/{id}`

---

## 🖼️ Gallery Endpoints

### 1. Get All Gallery
Mendapatkan daftar foto galeri.

**Endpoint:** `GET /api/v1/gallery`

**Query Parameters:**
- `per_page` (optional)
- `page` (optional)
- `search` (optional) - Pencarian di title dan description

**Example Response:**
```json
{
  "success": true,
  "message": "Gallery retrieved successfully",
  "data": [
    {
      "id": 1,
      "title": "Kegiatan Pembangunan",
      "description": "Dokumentasi kegiatan...",
      "image_url": "http://localhost/storage/gallery/photo.jpg",
      "created_at": "2025-01-10T14:20:00+07:00"
    }
  ]
}
```

### 2. Get Gallery Detail
**Endpoint:** `GET /api/v1/gallery/{id}`

---

## 📄 Documents Endpoints

### 1. Get All Documents
Mendapatkan daftar dokumen publik.

**Endpoint:** `GET /api/v1/documents`

**Query Parameters:**
- `per_page` (optional)
- `page` (optional)
- `search` (optional)
- `category` (optional) - Filter berdasarkan kategori

**Example Response:**
```json
{
  "success": true,
  "message": "Documents retrieved successfully",
  "data": [
    {
      "id": 1,
      "title": "Peraturan Desa 2024",
      "description": "Peraturan desa...",
      "category": "Peraturan",
      "file_name": "perdes-2024.pdf",
      "file_size": 2048576,
      "file_type": "application/pdf",
      "file_url": "http://localhost/storage/documents/perdes-2024.pdf",
      "download_count": 45,
      "uploaded_at": "2025-01-05T08:30:00+07:00"
    }
  ]
}
```

### 2. Get Document Detail
**Endpoint:** `GET /api/v1/documents/{id}`

### 3. Get Document Categories
**Endpoint:** `GET /api/v1/documents/categories`

### 4. Track Document Download
Increment download counter ketika dokumen diunduh.

**Endpoint:** `POST /api/v1/documents/{id}/download`

**Example Request:**
```bash
curl -X POST "http://localhost:8000/api/v1/documents/1/download"
```

**Example Response:**
```json
{
  "success": true,
  "message": "Download tracked successfully",
  "data": {
    "download_count": 46
  }
}
```

---

## 🏢 Organization Structure Endpoints

### 1. Get Organization Structure
Mendapatkan struktur organisasi yang dikelompokkan berdasarkan level hierarki.

**Endpoint:** `GET /api/v1/organization`

**Example Response:**
```json
{
  "success": true,
  "message": "Organization structure retrieved successfully",
  "data": {
    "levels": [
      {
        "level": 1,
        "members": [
          {
            "id": 1,
            "name": "Nama Kepala Dinas",
            "nip": "1234****5678",
            "position": "Kepala Dinas",
            "photo": "http://localhost/storage/structures/photo.jpg",
            "order": 1
          }
        ]
      },
      {
        "level": 2,
        "members": [ ... ]
      }
    ],
    "total_members": 25
  }
}
```

### 2. Get Organization Member Detail
**Endpoint:** `GET /api/v1/organization/{id}`

**Example Response:**
```json
{
  "success": true,
  "message": "Member detail retrieved successfully",
  "data": {
    "id": 1,
    "name": "Nama Lengkap",
    "nip": "1234****5678",
    "position": "Kepala Dinas",
    "photo": "http://localhost/storage/structures/photo.jpg",
    "order": 1,
    "level_info": {
      "level": 1,
      "total_members_at_level": 1
    }
  }
}
```

---

## ℹ️ Information Endpoints

### 1. Get Contact Information
**Endpoint:** `GET /api/v1/contact`

**Example Response:**
```json
{
  "success": true,
  "message": "Contact information retrieved successfully",
  "data": {
    "address": "Jl. Contoh No. 123, Kasongan",
    "phone": "0123-456789",
    "email": "pmd@katingankab.go.id",
    "whatsapp": "08123456789",
    "office_hours": "Senin - Jumat, 08:00 - 16:00 WIB",
    "social_media": {
      "facebook": "https://facebook.com/...",
      "instagram": "https://instagram.com/...",
      "twitter": null,
      "youtube": null
    },
    "map": {
      "embed_url": "https://www.google.com/maps/embed...",
      "latitude": "-2.123456",
      "longitude": "113.123456"
    }
  }
}
```

### 2. Get Vision & Mission
**Endpoint:** `GET /api/v1/vision-mission`

**Example Response:**
```json
{
  "success": true,
  "message": "Vision & Mission retrieved successfully",
  "data": {
    "vision": "Visi organisasi...",
    "mission": "1. Misi pertama\n2. Misi kedua...",
    "updated_at": "2025-01-01T00:00:00+07:00"
  }
}
```

### 3. Get Welcome Message
**Endpoint:** `GET /api/v1/welcome-message`

**Example Response:**
```json
{
  "success": true,
  "message": "Welcome message retrieved successfully",
  "data": {
    "name": "Dr. Nama Kepala Dinas",
    "position": "Kepala Dinas PMD Kabupaten Katingan",
    "message": "Selamat datang...",
    "photo": "http://localhost/storage/welcome/photo.jpg",
    "updated_at": "2025-01-01T00:00:00+07:00"
  }
}
```

---

## 📊 Statistics Endpoints

### 1. Get Overall Statistics
**Endpoint:** `GET /api/v1/stats`

**Example Response:**
```json
{
  "success": true,
  "message": "Statistics retrieved successfully",
  "data": {
    "news_count": 45,
    "agenda_count": 12,
    "upcoming_events": 5,
    "gallery_count": 150,
    "document_count": 78,
    "organization_members": 25,
    "total_news_views": 15420,
    "total_downloads": 3250
  }
}
```

### 2. Get News Statistics
**Endpoint:** `GET /api/v1/stats/news`

**Example Response:**
```json
{
  "success": true,
  "message": "News statistics retrieved successfully",
  "data": {
    "total_news": 45,
    "total_views": 15420,
    "by_category": [
      {
        "category": "Berita",
        "count": 20,
        "total_views": 8500
      },
      {
        "category": "Pengumuman",
        "count": 15,
        "total_views": 5200
      }
    ],
    "top_viewed": [
      {
        "id": 5,
        "title": "Berita Populer",
        "slug": "berita-populer",
        "views": 1250,
        "published_at": "2025-01-10T10:00:00+07:00"
      }
    ]
  }
}
```

### 3. Get Document Statistics
**Endpoint:** `GET /api/v1/stats/documents`

**Example Response:**
```json
{
  "success": true,
  "message": "Document statistics retrieved successfully",
  "data": {
    "total_documents": 78,
    "total_downloads": 3250,
    "by_category": [
      {
        "category": "Peraturan",
        "count": 30,
        "total_downloads": 1500
      }
    ],
    "most_downloaded": [ ... ]
  }
}
```

---

## 🔒 Rate Limiting

API ini dilindungi dengan rate limiting:
- **60 requests per minute** untuk semua endpoint

Jika limit terlampaui, server akan mengembalikan:
```json
{
  "message": "Too Many Requests",
  "status": 429
}
```

**Headers Response:**
- `X-RateLimit-Limit`: Total requests yang diperbolehkan
- `X-RateLimit-Remaining`: Sisa requests yang tersedia
- `Retry-After`: Detik sampai reset (jika limit tercapai)

---

## 🧪 Testing API

### Via Swagger UI
Akses dokumentasi interaktif di:
```
http://your-domain.com/api/documentation
```

Swagger UI menyediakan:
- ✅ Daftar lengkap semua endpoint
- ✅ Try it out feature untuk testing langsung
- ✅ Request/Response schemas
- ✅ Example values

### Via cURL
```bash
# Get news list
curl "http://localhost:8000/api/v1/news?per_page=5"

# Get news detail
curl "http://localhost:8000/api/v1/news/judul-berita"

# Get upcoming agenda
curl "http://localhost:8000/api/v1/agenda?upcoming=true"

# Get statistics
curl "http://localhost:8000/api/v1/stats"

# Track document download
curl -X POST "http://localhost:8000/api/v1/documents/1/download"
```

### Via Postman
1. Import endpoints dari Swagger JSON: `http://localhost:8000/api-docs/api-docs.json`
2. Atau buat collection manual dengan base URL: `http://localhost:8000/api/v1`

---

## 📝 Error Handling

### Common Error Codes

| Status Code | Meaning |
|------------|---------|
| 200 | Success |
| 400 | Bad Request - Parameter tidak valid |
| 404 | Not Found - Resource tidak ditemukan |
| 422 | Unprocessable Entity - Validation error |
| 429 | Too Many Requests - Rate limit exceeded |
| 500 | Internal Server Error - Server error |

### Example Error Response
```json
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "per_page": ["The per_page must not be greater than 50."]
  }
}
```

---

## 🚀 Best Practices

### 1. Pagination
Selalu gunakan pagination untuk endpoint yang mengembalikan banyak data:
```bash
# Baik ✅
GET /api/v1/news?per_page=20&page=1

# Hindari mengambil semua data sekaligus ❌
GET /api/v1/news?per_page=10000
```

### 2. Filter & Search
Kombinasikan filter untuk hasil yang lebih spesifik:
```bash
GET /api/v1/news?category=Pengumuman&search=desa&per_page=10
```

### 3. Handle Rate Limiting
Implementasikan retry logic dengan exponential backoff:
```javascript
async function apiRequest(url, retries = 3) {
  try {
    const response = await fetch(url);
    if (response.status === 429) {
      const retryAfter = response.headers.get('Retry-After');
      await sleep(retryAfter * 1000);
      return apiRequest(url, retries - 1);
    }
    return response.json();
  } catch (error) {
    if (retries > 0) return apiRequest(url, retries - 1);
    throw error;
  }
}
```

### 4. Cache Responses
Cache data yang jarang berubah (contact, vision-mission):
```javascript
// Cache selama 1 jam
const CACHE_TTL = 3600;
const cachedContact = await cache.remember('api:contact', CACHE_TTL, async () => {
  return await fetch('/api/v1/contact').then(r => r.json());
});
```

---

## 🔧 Development

### Generate Swagger Documentation
Setelah menambahkan/mengubah OpenAPI annotations di controller:
```bash
php artisan l5-swagger:generate
```

### Clear API Cache
```bash
php artisan route:clear
php artisan cache:clear
```

---

## 📞 Support

Untuk pertanyaan atau bantuan tentang API:
- **Email:** pmd@katingankab.go.id
- **Developer:** [GitHub Issues](https://github.com/your-repo/issues)

---

## 📋 Changelog

### Version 1.0.0 (2025-01-13)
- ✅ Initial API release
- ✅ News, Agenda, Gallery, Documents endpoints
- ✅ Organization structure endpoints
- ✅ Information endpoints (Contact, Vision-Mission, Welcome Message)
- ✅ Statistics endpoints
- ✅ Swagger UI documentation
- ✅ Rate limiting (60 req/min)
- ✅ Response pagination & filtering

---

## ⚖️ License

API ini disediakan untuk keperluan integrasi dengan sistem Dinas PMD Kabupaten Katingan.
Penggunaan harus sesuai dengan peraturan dan kebijakan yang berlaku.
