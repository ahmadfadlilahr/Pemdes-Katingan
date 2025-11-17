# Konfigurasi Environment untuk Production/Development

## 📌 Ringkasan Perubahan

Sistem API sudah dikonfigurasi agar **mudah beralih antara Development dan Production** hanya dengan mengubah file `.env`.

## ✅ Yang Sudah Dikonfigurasi

### 1. Environment Variable Baru

File: `.env`

```env
# L5 Swagger Configuration
# URL ini akan otomatis digunakan oleh Swagger Documentation
L5_SWAGGER_CONST_HOST=http://127.0.0.1:8000

# CORS Configuration
# Comma-separated list of allowed origins (domain yang diizinkan akses API)
CORS_ALLOWED_ORIGINS=http://localhost,http://127.0.0.1:8000,http://localhost:3000,http://localhost:5173
```

**Fungsi L5_SWAGGER_CONST_HOST:**
- Menentukan base URL untuk API documentation (Swagger UI)
- Digunakan sebagai "Try it out" server URL
- Mudah diganti tanpa perlu edit code

**Fungsi CORS_ALLOWED_ORIGINS:**
- Menentukan domain mana saja yang boleh akses API
- Meningkatkan keamanan API (tidak semua domain bisa akses)
- Support multiple origins (pisahkan dengan koma)
- Jika tidak diset, default mengizinkan semua domain (*)

### 2. Update Controller.php

File: `app/Http/Controllers/Api/V1/Controller.php`

**Sebelum:**
```php
* @OA\Server(
*      url="http://127.0.0.1:8000",
*      description="Development Server"
* )
* @OA\Server(
*      url="http://localhost:8000",
*      description="Local Server"
* )
```

**Sesudah:**
```php
* @OA\Server(
*      url=L5_SWAGGER_CONST_HOST,
*      description="API Server (Configurable via .env)"
* )
```

**Keuntungan:**
- ✅ Tidak ada hardcoded URL
- ✅ Server URL dibaca dari environment variable
- ✅ Satu tempat konfigurasi untuk development dan production

### 3. Konfigurasi L5-Swagger

File: `config/l5-swagger.php`

```php
'constants' => [
    'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://my-default-host.com'),
],
```

**Cara Kerja:**
1. Laravel membaca `L5_SWAGGER_CONST_HOST` dari `.env`
2. L5-Swagger menggunakan value tersebut sebagai constant
3. OpenAPI annotation `L5_SWAGGER_CONST_HOST` diganti dengan value sebenarnya
4. Swagger documentation ter-generate dengan URL yang benar

### 4. Konfigurasi CORS (Cross-Origin Resource Sharing)

File: `config/cors.php`

**Sebelum:**
```php
'allowed_origins' => ['*'], // Mengizinkan SEMUA domain (tidak aman!)
```

**Sesudah:**
```php
'allowed_origins' => env('CORS_ALLOWED_ORIGINS') 
    ? explode(',', env('CORS_ALLOWED_ORIGINS')) 
    : ['*'],
```

**Cara Kerja:**
1. Laravel membaca `CORS_ALLOWED_ORIGINS` dari `.env`
2. String dipisah dengan koma menjadi array
3. Hanya domain dalam list yang boleh akses API
4. Jika tidak diset, fallback ke `['*']` (semua domain)

**Keuntungan:**
- ✅ **Keamanan**: Hanya domain tertentu yang boleh akses API
- ✅ **Fleksibilitas**: Bisa set berbeda untuk dev dan production
- ✅ **Multiple Origins**: Support banyak domain sekaligus
- ✅ **Easy Configuration**: Tinggal edit `.env`

**Contoh CORS_ALLOWED_ORIGINS:**
```env
# Development - Multiple local ports
CORS_ALLOWED_ORIGINS=http://localhost,http://127.0.0.1:8000,http://localhost:3000,http://localhost:5173

# Production - Real domains
CORS_ALLOWED_ORIGINS=https://pmdkatingan.go.id,https://www.pmdkatingan.go.id,https://admin.pmdkatingan.go.id

# Mixed (dev + staging)
CORS_ALLOWED_ORIGINS=http://localhost:3000,https://staging.pmdkatingan.go.id
```

## 🚀 Cara Menggunakan

### Development (Localhost)

File: `.env`

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# API Documentation URL
L5_SWAGGER_CONST_HOST=http://127.0.0.1:8000

# CORS - Allow local development ports
CORS_ALLOWED_ORIGINS=http://localhost,http://127.0.0.1:8000,http://localhost:3000,http://localhost:5173
```

**Setelah edit `.env`, jalankan:**

```bash
php artisan config:clear
php artisan l5-swagger:generate
```

**Akses:**
- Swagger UI: http://127.0.0.1:8000/api/documentation
- API Base: http://127.0.0.1:8000/api/v1

### Production (Server Live)

File: `.env` (di server production)

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://pmdkatingan.go.id

# API Documentation URL
L5_SWAGGER_CONST_HOST=https://pmdkatingan.go.id

# CORS - Only allow production domains
CORS_ALLOWED_ORIGINS=https://pmdkatingan.go.id,https://www.pmdkatingan.go.id
```

**Setelah edit `.env` di production, jalankan:**

```bash
php artisan config:clear
php artisan l5-swagger:generate
```

**Akses:**
- Swagger UI: https://pmdkatingan.go.id/api/documentation
- API Base: https://pmdkatingan.go.id/api/v1

## 🔄 Skenario Penggunaan

### Skenario 1: Testing di Local (Laragon/XAMPP)

```env
L5_SWAGGER_CONST_HOST=http://127.0.0.1:8000
```

### Skenario 2: Testing di Local Network

```env
L5_SWAGGER_CONST_HOST=http://192.168.1.100:8000
```

### Skenario 3: Staging Server

```env
L5_SWAGGER_CONST_HOST=https://staging.pmdkatingan.go.id
```

### Skenario 4: Production Server

```env
L5_SWAGGER_CONST_HOST=https://pmdkatingan.go.id
```

### Skenario 5: Production dengan Custom Port

```env
L5_SWAGGER_CONST_HOST=https://api.pmdkatingan.go.id:8443
```

## ⚙️ Command Reference

### Generate Swagger Docs

```bash
# Generate dokumentasi API
php artisan l5-swagger:generate
```

### Clear Configuration Cache

```bash
# Clear cache config (wajib setelah edit .env)
php artisan config:clear
```

### Clear All Caches

```bash
# Clear semua cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### Cache Configuration (Production Only)

```bash
# Cache untuk performance (hanya di production)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**⚠️ Catatan:** Jika menggunakan `config:cache`, perubahan di `.env` tidak akan terbaca sampai clear cache atau cache ulang.

## 📁 File yang Dimodifikasi

```
pmd-profile/
├── .env                              # ✅ Added L5_SWAGGER_CONST_HOST
├── app/Http/Controllers/Api/V1/
│   └── Controller.php                # ✅ Updated @OA\Server annotation
├── config/
│   └── l5-swagger.php                # ✅ Already configured (no changes needed)
└── storage/api-docs/
    └── api-docs.json                 # ✅ Generated with correct URL
```

## ✅ Verifikasi Konfigurasi

### 1. Check Environment Variable

```bash
# Windows (CMD)
type .env | findstr L5_SWAGGER

# Windows (PowerShell)
Get-Content .env | Select-String "L5_SWAGGER"

# Linux/Mac
cat .env | grep L5_SWAGGER
```

**Expected Output:**
```
L5_SWAGGER_CONST_HOST=http://127.0.0.1:8000
```

### 2. Check Generated Swagger Docs

```bash
# Windows
type storage\api-docs\api-docs.json | findstr "url.*127"

# Linux/Mac
cat storage/api-docs/api-docs.json | grep "url"
```

**Expected Output:**
```json
"url": "http://127.0.0.1:8000",
```

### 3. Test di Browser

Buka: http://127.0.0.1:8000/api/documentation

**Cara Check:**
1. Buka Swagger UI
2. Lihat bagian "Servers" dropdown di atas
3. Pastikan URL sesuai dengan `L5_SWAGGER_CONST_HOST`
4. Klik "Try it out" pada endpoint manapun
5. Execute - request akan dikirim ke URL yang benar

## 🔒 Security Note

### Development

```env
# OK untuk development
L5_SWAGGER_CONST_HOST=http://127.0.0.1:8000
```

### Production

```env
# Wajib HTTPS di production
L5_SWAGGER_CONST_HOST=https://pmdkatingan.go.id
```

**⚠️ Jangan expose API documentation di production** jika berisi data sensitif:

Edit `config/l5-swagger.php`:

```php
'routes' => [
    'middleware' => [
        'api' => ['auth:sanctum'], // Require authentication
    ],
],
```

## 🎯 Keuntungan Sistem Ini

1. **✅ Fleksibilitas**
   - Ganti URL hanya edit `.env`
   - Tidak perlu edit code PHP
   - Tidak perlu commit perubahan URL

2. **✅ Multi-Environment Support**
   - Development: localhost
   - Staging: staging server
   - Production: live server
   - Testing: local network

3. **✅ Easy Deployment**
   - Copy `.env.example` ke `.env`
   - Set `L5_SWAGGER_CONST_HOST` sesuai environment
   - Generate swagger docs
   - Done!

4. **✅ Team Collaboration**
   - Setiap developer bisa pakai URL sendiri
   - `.env` tidak di-commit ke Git
   - Tidak ada conflict URL

5. **✅ Production Ready**
   - HTTPS support
   - Custom domain support
   - Custom port support
   - Subdomain support

## 📝 Troubleshooting

### Issue: Swagger masih pakai URL lama

**Solusi:**
```bash
php artisan config:clear
php artisan l5-swagger:generate
# Refresh browser (Ctrl+F5)
```

### Issue: "Try it out" error CORS

**Gejala:**
- Error: "Failed to fetch" di Swagger UI
- Error: "CORS policy: No 'Access-Control-Allow-Origin' header" di browser console
- API tidak bisa diakses dari frontend

**Solusi 1: Tambahkan domain frontend ke CORS**
Edit `.env`:
```env
# Tambahkan domain frontend Anda
CORS_ALLOWED_ORIGINS=http://localhost:3000,http://127.0.0.1:8000,https://yourdomain.com
```

**Solusi 2: Temporary untuk development (tidak aman untuk production!)**
Edit `.env`:
```env
# Kosongkan untuk allow all origins (*)
CORS_ALLOWED_ORIGINS=
```

**Solusi 3: Check konfigurasi**
```bash
# Clear cache
php artisan config:clear

# Test CORS config
php artisan tinker --execute="var_dump(config('cors.allowed_origins'));"
```

**Catatan Keamanan:**
- ⚠️ **JANGAN** gunakan `*` (allow all) di production!
- ✅ **WAJIB** specify domain yang valid di production
- ✅ Gunakan HTTPS di production (http:// tidak aman)

### Issue: URL tidak berubah setelah edit .env

**Solusi:**
```bash
# Clear config cache
php artisan config:clear

# Regenerate swagger
php artisan l5-swagger:generate

# Hard refresh browser
# Chrome: Ctrl+Shift+R
# Firefox: Ctrl+F5
```

### Issue: Server dropdown tidak muncul

**Solusi:**
Pastikan annotation sudah benar di `Controller.php`:
```php
* @OA\Server(
*      url=L5_SWAGGER_CONST_HOST,
*      description="API Server (Configurable via .env)"
* )
```

## 🎉 Kesimpulan

Sistem konfigurasi environment sudah siap! Anda bisa dengan mudah:

1. ✅ Switch antara development dan production
2. ✅ Test di berbagai environment (local, staging, production)
3. ✅ Deploy tanpa perlu edit code
4. ✅ Collaborate dengan tim tanpa conflict URL
5. ✅ Support HTTPS untuk production

**Untuk deploy ke production, cukup:**

1. Edit `.env` di server production
2. Set `L5_SWAGGER_CONST_HOST=https://yourdomain.com`
3. Run `php artisan config:clear && php artisan l5-swagger:generate`
4. Done! 🚀

**Dokumentasi lengkap deployment ada di:** `DEPLOYMENT_GUIDE.md`
