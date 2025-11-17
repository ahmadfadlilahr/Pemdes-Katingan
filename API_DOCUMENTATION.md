# Dinas PMD Katingan - REST API Documentation

## 📋 Overview

API RESTful lengkap dengan autentikasi untuk sistem informasi Dinas Pemberdayaan Masyarakat dan Desa (PMD) Katingan.

**Base URL:** `http://127.0.0.1:8000/api/v1`  
**Documentation:** `http://127.0.0.1:8000/api/documentation`

---

## 🚀 Features

✅ **Full CRUD Operations** - Create, Read, Update, Delete untuk semua resources  
✅ **Authentication & Authorization** - Laravel Sanctum dengan Bearer Token  
✅ **User Management** - Kelola akun admin dengan role-based access  
✅ **File Upload** - Image upload untuk News, Agenda, Gallery  
✅ **Document Management** - Upload PDF, DOC, XLS, dan file lainnya  
✅ **Search & Filter** - Pencarian dan filter data  
✅ **Pagination** - Response data dengan pagination  
✅ **Responsive Swagger UI** - Dokumentasi interaktif yang mobile-friendly  
✅ **Rate Limiting** - 60 requests per minute  
✅ **Clean Code Architecture** - Request validation, Resources, Traits  

---

## 🔐 Authentication

API menggunakan **Laravel Sanctum** untuk autentikasi berbasis token.

### Login

```bash
POST /api/v1/auth/login
Content-Type: application/json

{
    "email": "admin@pmdkatingan.go.id",
    "password": "password"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "Super Admin",
            "email": "admin@pmdkatingan.go.id",
            "role": "super_admin"
        },
        "token": "1|abc123def456...",
        "token_type": "Bearer"
    }
}
```

### Menggunakan Token

Setelah login, gunakan token pada setiap request ke endpoint yang protected:

```bash
Authorization: Bearer YOUR_TOKEN_HERE
```

### Logout

```bash
POST /api/v1/auth/logout
Authorization: Bearer YOUR_TOKEN_HERE
```

---

## 📚 API Endpoints

### Public Endpoints (No Authentication)

#### News
- `GET /api/v1/news` - List berita terbaru (published)
- `GET /api/v1/news/{slug}` - Detail berita

#### Agenda
- `GET /api/v1/agenda` - List agenda/kegiatan
- `GET /api/v1/agenda/{id}` - Detail agenda

#### Gallery
- `GET /api/v1/gallery` - List galeri foto
- `GET /api/v1/gallery/{id}` - Detail galeri

#### Documents
- `GET /api/v1/documents` - List dokumen
- `GET /api/v1/documents/categories` - Kategori dokumen
- `GET /api/v1/documents/{id}` - Detail dokumen
- `POST /api/v1/documents/{id}/download` - Download dokumen

#### Organization
- `GET /api/v1/organization` - Struktur organisasi

#### Information
- `GET /api/v1/contact` - Info kontak
- `GET /api/v1/vision-mission` - Visi & Misi
- `GET /api/v1/welcome-message` - Sambutan Kepala Dinas

#### Statistics
- `GET /api/v1/stats` - Statistik umum
- `GET /api/v1/stats/news` - Statistik berita
- `GET /api/v1/stats/documents` - Statistik dokumen

---

### Protected Endpoints (Require Authentication)

#### User Management (Admin)
- `GET /api/v1/admin/users` - List users
- `GET /api/v1/admin/users/{id}` - Detail user
- `POST /api/v1/admin/users` - Create user
- `PUT /api/v1/admin/users/{id}` - Update user
- `DELETE /api/v1/admin/users/{id}` - Delete user
- `PUT /api/v1/admin/users/{id}/reset-password` - Reset password
- `POST /api/v1/admin/users/{id}/toggle-status` - Aktifkan/Nonaktifkan user

#### News Management (Admin)
- `GET /api/v1/admin/news` - List semua berita
- `GET /api/v1/admin/news/{id}` - Detail berita
- `POST /api/v1/admin/news` - Create berita (with image)
- `POST /api/v1/admin/news/{id}` - Update berita (multipart)
- `DELETE /api/v1/admin/news/{id}` - Delete berita
- `POST /api/v1/admin/news/{id}/toggle-publish` - Publish/Unpublish
- `DELETE /api/v1/admin/news/bulk-delete` - Bulk delete

#### Agenda Management (Admin)
- `GET /api/v1/admin/agenda` - List semua agenda
- `GET /api/v1/admin/agenda/{id}` - Detail agenda
- `POST /api/v1/admin/agenda` - Create agenda
- `POST /api/v1/admin/agenda/{id}` - Update agenda
- `DELETE /api/v1/admin/agenda/{id}` - Delete agenda
- `DELETE /api/v1/admin/agenda/bulk-delete` - Bulk delete

#### Gallery Management (Admin)
- `GET /api/v1/admin/gallery` - List semua gallery
- `GET /api/v1/admin/gallery/{id}` - Detail gallery
- `POST /api/v1/admin/gallery` - Create gallery
- `POST /api/v1/admin/gallery/{id}` - Update gallery
- `DELETE /api/v1/admin/gallery/{id}` - Delete gallery
- `DELETE /api/v1/admin/gallery/bulk-delete` - Bulk delete

#### Documents Management (Admin)
- `GET /api/v1/admin/documents` - List semua dokumen
- `GET /api/v1/admin/documents/{id}` - Detail dokumen
- `GET /api/v1/admin/documents/categories` - List kategori
- `POST /api/v1/admin/documents` - Create dokumen
- `POST /api/v1/admin/documents/{id}` - Update dokumen
- `DELETE /api/v1/admin/documents/{id}` - Delete dokumen
- `DELETE /api/v1/admin/documents/bulk-delete` - Bulk delete

---

## 💡 Examples

### Create News with Image

```bash
POST /api/v1/admin/news
Authorization: Bearer YOUR_TOKEN_HERE
Content-Type: multipart/form-data

title: Berita Terbaru
content: Konten berita lengkap...
excerpt: Ringkasan berita...
image: [FILE]
is_published: true
```

### Update News

```bash
POST /api/v1/admin/news/1
Authorization: Bearer YOUR_TOKEN_HERE
Content-Type: multipart/form-data

title: Judul Updated
content: Konten updated...
image: [FILE] (optional)
```

### Search News

```bash
GET /api/v1/news?search=pembangunan&page=1&per_page=10
```

### Bulk Delete

```bash
DELETE /api/v1/admin/news/bulk-delete
Authorization: Bearer YOUR_TOKEN_HERE
Content-Type: application/json

{
    "ids": [1, 2, 3, 4]
}
```

---

## 📝 Response Format

### Success Response

```json
{
    "success": true,
    "message": "Operation successful",
    "data": { ... }
}
```

### Paginated Response

```json
{
    "success": true,
    "message": "Data retrieved successfully",
    "data": [ ... ],
    "meta": {
        "current_page": 1,
        "per_page": 15,
        "total": 100,
        "last_page": 7
    }
}
```

### Error Response

```json
{
    "success": false,
    "message": "Error message",
    "errors": {
        "field": ["Validation error message"]
    }
}
```

---

## 🗂️ File Upload Guidelines

### Images (News, Agenda, Gallery)
- **Format:** JPG, JPEG, PNG
- **Max Size:** 
  - News: 2MB
  - Agenda: 2MB
  - Gallery: 5MB

### Documents
- **Format:** PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, RAR
- **Max Size:** 10MB

---

## 🏗️ Code Architecture

Proyek menggunakan clean code architecture dengan komponen terpisah:

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/V1/
│   │       ├── Controller.php (Base)
│   │       ├── NewsController.php
│   │       ├── AgendaController.php
│   │       └── Admin/
│   │           ├── NewsManagementController.php
│   │           ├── AgendaManagementController.php
│   │           ├── GalleryManagementController.php
│   │           └── DocumentManagementController.php
│   ├── Requests/Api/
│   │   ├── StoreNewsRequest.php
│   │   ├── UpdateNewsRequest.php
│   │   └── StoreAgendaRequest.php
│   └── Resources/
│       ├── NewsResource.php
│       ├── AgendaResource.php
│       ├── GalleryResource.php
│       └── DocumentResource.php
├── Models/
│   ├── News.php
│   ├── Agenda.php
│   ├── Gallery.php
│   └── Document.php
└── Traits/
    └── HandlesFileUpload.php
```

---

## 🔧 Rate Limiting

- **Public Endpoints:** 60 requests/minute
- **Protected Endpoints:** 60 requests/minute

Jika melebihi limit, response 429 Too Many Requests.

---

## 🌐 CORS Configuration

CORS sudah dikonfigurasi untuk allow:
- All origins (*)
- All methods (GET, POST, PUT, DELETE, etc.)
- All headers
- Credentials support

---

## 📱 Responsive Design

Swagger UI documentation sudah responsive dan mobile-friendly:
- ✅ Desktop (1920px+)
- ✅ Laptop (1024px - 1920px)
- ✅ Tablet (768px - 1024px)
- ✅ Mobile Landscape (480px - 768px)
- ✅ Mobile Portrait (< 480px)

---

## 🐛 Error Codes

| Code | Description |
|------|-------------|
| 200 | Success |
| 201 | Created |
| 400 | Bad Request |
| 401 | Unauthorized |
| 403 | Forbidden |
| 404 | Not Found |
| 422 | Validation Error |
| 429 | Too Many Requests |
| 500 | Internal Server Error |

---

## 🧪 Testing

### Using Swagger UI
1. Buka `http://127.0.0.1:8000/api/documentation`
2. Login untuk mendapatkan token
3. Klik tombol "Authorize" (🔓)
4. Masukkan: `Bearer YOUR_TOKEN_HERE`
5. Test endpoints langsung dari browser

### Using cURL

```bash
# Login
curl -X POST http://127.0.0.1:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@pmdkatingan.go.id","password":"password"}'

# Create News
curl -X POST http://127.0.0.1:8000/api/v1/admin/news \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "title=Test News" \
  -F "content=Content here..." \
  -F "image=@/path/to/image.jpg"
```

### Using Postman
Import Swagger JSON dari: `http://127.0.0.1:8000/api-docs/api-docs.json`

---

## 📞 Support

Untuk pertanyaan atau issue, hubungi tim development.

---

## 📄 License

Copyright © 2025 Dinas PMD Katingan. All rights reserved.
