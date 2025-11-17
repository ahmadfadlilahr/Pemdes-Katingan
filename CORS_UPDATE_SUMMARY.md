# ✅ CORS Configuration - Update Summary

## 📌 Apa yang Sudah Dikonfigurasi?

Sama seperti `L5_SWAGGER_CONST_HOST`, sekarang **CORS (Cross-Origin Resource Sharing)** juga bisa dikonfigurasi via environment variable di `.env`.

## 🎯 Kenapa CORS Perlu Dikonfigurasi?

**CORS** mengontrol domain mana saja yang **boleh mengakses API** Anda.

### Sebelum (Tidak Aman):
```php
'allowed_origins' => ['*'], // ❌ SEMUA domain bisa akses (bahaya!)
```

### Sesudah (Aman & Fleksibel):
```env
# .env
CORS_ALLOWED_ORIGINS=http://localhost:3000,https://pmdkatingan.go.id
```

## 📝 File yang Dimodifikasi

### 1. `.env` - Tambah Environment Variable

```env
# L5 Swagger Configuration
L5_SWAGGER_CONST_HOST=http://127.0.0.1:8000

# CORS Configuration (BARU!)
# Comma-separated list of allowed origins
CORS_ALLOWED_ORIGINS=http://localhost,http://127.0.0.1:8000,http://localhost:3000,http://localhost:5173
```

**Penjelasan:**
- `http://localhost` - Backend Laravel
- `http://127.0.0.1:8000` - Backend dengan IP
- `http://localhost:3000` - Frontend React/Next.js (default port)
- `http://localhost:5173` - Frontend Vite (default port)

### 2. `config/cors.php` - Update Configuration

**Sebelum:**
```php
'allowed_origins' => ['*'],
```

**Sesudah:**
```php
'allowed_origins' => env('CORS_ALLOWED_ORIGINS') 
    ? explode(',', env('CORS_ALLOWED_ORIGINS')) 
    : ['*'],
```

**Cara Kerja:**
1. Baca `CORS_ALLOWED_ORIGINS` dari `.env`
2. Split string dengan koma (`,`) menjadi array
3. Jika tidak diset → fallback ke `['*']` (allow all)

## 🚀 Cara Menggunakan

### Development (Sekarang)

```env
# .env
CORS_ALLOWED_ORIGINS=http://localhost,http://127.0.0.1:8000,http://localhost:3000,http://localhost:5173
```

**Clear cache:**
```bash
php artisan config:clear
```

**Test configuration:**
```bash
php artisan tinker --execute="var_dump(config('cors.allowed_origins'));"
```

**Expected Output:**
```php
array(4) {
  [0]=> string(16) "http://localhost"
  [1]=> string(21) "http://127.0.0.1:8000"
  [2]=> string(21) "http://localhost:3000"
  [3]=> string(21) "http://localhost:5173"
}
```

### Production (Nanti)

```env
# .env (production server)
L5_SWAGGER_CONST_HOST=https://pmdkatingan.go.id
CORS_ALLOWED_ORIGINS=https://pmdkatingan.go.id,https://www.pmdkatingan.go.id
```

**Setelah edit `.env` di production:**
```bash
php artisan config:clear
```

## ✅ Testing CORS

### Test 1: Check Config

```bash
php artisan tinker --execute="var_dump(config('cors.allowed_origins'));"
```

### Test 2: Test dari Browser Console

Buka browser (F12 → Console):

```javascript
// Test fetch API
fetch('http://127.0.0.1:8000/api/v1/news')
  .then(res => res.json())
  .then(data => console.log('✅ CORS OK:', data))
  .catch(err => console.error('❌ CORS Error:', err));
```

**Jika berhasil:**
```
✅ CORS OK: {success: true, message: "...", data: [...]}
```

**Jika gagal:**
```
❌ CORS Error: Failed to fetch
Console Error: "blocked by CORS policy"
```

### Test 3: Test dari Frontend App

**React/Next.js Example:**
```javascript
// src/services/api.js
const API_BASE_URL = 'http://127.0.0.1:8000/api/v1';

export const getNews = async () => {
  const response = await fetch(`${API_BASE_URL}/news`);
  
  if (!response.ok) {
    throw new Error('CORS or Network error');
  }
  
  return response.json();
};
```

**Axios Example:**
```javascript
import axios from 'axios';

axios.defaults.baseURL = 'http://127.0.0.1:8000/api/v1';
axios.defaults.withCredentials = true; // Important for auth!

export const getNews = () => {
  return axios.get('/news');
};
```

## 🔐 Security Best Practices

### ✅ Development (OK)

```env
# Allow multiple local ports
CORS_ALLOWED_ORIGINS=http://localhost,http://127.0.0.1:8000,http://localhost:3000,http://localhost:5173
```

### ✅ Production (Secure)

```env
# Only HTTPS production domains
CORS_ALLOWED_ORIGINS=https://pmdkatingan.go.id,https://www.pmdkatingan.go.id
```

### ❌ Production (Tidak Aman - JANGAN!)

```env
# ❌ Wildcard - allow all domains
CORS_ALLOWED_ORIGINS=*

# ❌ HTTP in production
CORS_ALLOWED_ORIGINS=http://pmdkatingan.go.id

# ❌ Development domains in production
CORS_ALLOWED_ORIGINS=https://pmdkatingan.go.id,http://localhost:3000
```

## 🐛 Troubleshooting

### Issue: CORS Error di Browser

**Gejala:**
```
Access to fetch at '...' from origin '...' has been blocked by CORS policy
```

**Solusi:**
```bash
# 1. Check .env
type .env | findstr CORS

# 2. Pastikan domain frontend ada di list
# Edit .env:
CORS_ALLOWED_ORIGINS=http://localhost:3000,http://127.0.0.1:8000

# 3. Clear cache
php artisan config:clear

# 4. Test config
php artisan tinker --execute="var_dump(config('cors.allowed_origins'));"

# 5. Reload browser (Ctrl + F5)
```

### Issue: Works in Postman, Error in Browser

**Penyebab:**
- Postman tidak enforce CORS (development tool)
- Browser enforce CORS (security)

**Solusi:**
- Setup CORS dengan benar seperti di atas
- Test di real browser, bukan hanya Postman

### Issue: Authentication + CORS Error

**Pastikan:**
```php
// config/cors.php
'supports_credentials' => true, // WAJIB untuk auth!
```

**Frontend (Fetch):**
```javascript
fetch(url, {
    credentials: 'include', // Important!
    headers: {
        'Authorization': 'Bearer ' + token
    }
})
```

**Frontend (Axios):**
```javascript
axios.defaults.withCredentials = true; // Important!
```

## 📚 Dokumentasi Lengkap

Untuk panduan lengkap tentang CORS, baca:
- **CORS_CONFIGURATION.md** - Panduan lengkap CORS setup, troubleshooting, dan security
- **ENVIRONMENT_CONFIGURATION.md** - Konfigurasi environment untuk dev/production
- **DEPLOYMENT_GUIDE.md** - Panduan deployment ke production

## 🎉 Kesimpulan

### Sekarang Anda Punya:

1. ✅ **L5_SWAGGER_CONST_HOST** - URL untuk Swagger documentation
2. ✅ **CORS_ALLOWED_ORIGINS** - Domain yang boleh akses API

### Keuntungan:

- ✅ **Fleksibel** - Ganti di `.env` aja, tidak perlu edit code
- ✅ **Aman** - Kontrol domain mana yang boleh akses
- ✅ **Multi-Environment** - Beda setting untuk dev dan production
- ✅ **Easy Deployment** - Tinggal update `.env` di server

### Quick Reference:

```env
# Development
L5_SWAGGER_CONST_HOST=http://127.0.0.1:8000
CORS_ALLOWED_ORIGINS=http://localhost,http://127.0.0.1:8000,http://localhost:3000

# Production
L5_SWAGGER_CONST_HOST=https://pmdkatingan.go.id
CORS_ALLOWED_ORIGINS=https://pmdkatingan.go.id,https://www.pmdkatingan.go.id
```

### Commands:

```bash
# Clear cache setelah edit .env
php artisan config:clear

# Test CORS config
php artisan tinker --execute="var_dump(config('cors.allowed_origins'));"

# Test Swagger config
php artisan tinker --execute="echo config('l5-swagger.defaults.constants.L5_SWAGGER_CONST_HOST');"
```

---

**Ready untuk Production! 🚀**

Sekarang API Anda:
- ✅ Punya Swagger documentation yang configurable
- ✅ Punya CORS yang secure dan configurable
- ✅ Mudah deploy ke berbagai environment
- ✅ Aman dari akses domain yang tidak diinginkan
