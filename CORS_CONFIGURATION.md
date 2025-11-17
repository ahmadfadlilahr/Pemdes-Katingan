# 🔐 CORS Configuration Guide

## Apa itu CORS?

**CORS (Cross-Origin Resource Sharing)** adalah mekanisme keamanan browser yang mengontrol domain mana saja yang boleh mengakses API Anda.

### Contoh Sederhana:

```
Frontend Website    : https://website.com
Backend API         : https://api.pmdkatingan.go.id

Tanpa CORS Config   : ❌ Browser block request (security error)
Dengan CORS Config  : ✅ Request diizinkan
```

## 🎯 Kenapa CORS Penting?

### Tanpa CORS (Allow All - `*`):
```
❌ Semua domain bisa akses API Anda
❌ Website jahat bisa akses data
❌ API key/token bisa dicuri
❌ TIDAK AMAN untuk production!
```

### Dengan CORS yang Benar:
```
✅ Hanya domain terpercaya yang bisa akses
✅ Website lain di-block oleh browser
✅ Data Anda aman
✅ AMAN untuk production!
```

## 📋 Konfigurasi CORS di Project Ini

### 1. Environment Variable

File: `.env`

```env
# CORS Configuration
# Comma-separated list of allowed origins
CORS_ALLOWED_ORIGINS=http://localhost,http://127.0.0.1:8000,http://localhost:3000
```

**Format:**
- Multiple domains: pisahkan dengan **koma** (tanpa spasi)
- Sertakan protocol: `http://` atau `https://`
- Sertakan port jika ada: `:8000`, `:3000`, dll
- Case-sensitive: `http://localhost` ≠ `http://Localhost`

### 2. Config File

File: `config/cors.php`

```php
'allowed_origins' => env('CORS_ALLOWED_ORIGINS') 
    ? explode(',', env('CORS_ALLOWED_ORIGINS')) 
    : ['*'],
```

**Cara Kerja:**
1. Jika `CORS_ALLOWED_ORIGINS` ada di `.env` → gunakan value tersebut
2. String di-split dengan koma → jadi array
3. Jika tidak ada di `.env` → fallback ke `['*']` (allow all)

## 🚀 Setup untuk Berbagai Environment

### Development (Local)

```env
# .env
CORS_ALLOWED_ORIGINS=http://localhost,http://127.0.0.1:8000,http://localhost:3000,http://localhost:5173
```

**Penjelasan:**
- `http://localhost` - Backend Laravel
- `http://127.0.0.1:8000` - Backend dengan IP
- `http://localhost:3000` - Frontend React/Next.js (default port)
- `http://localhost:5173` - Frontend Vite (default port)

### Staging Environment

```env
# .env (staging server)
CORS_ALLOWED_ORIGINS=https://staging.pmdkatingan.go.id,https://staging-admin.pmdkatingan.go.id,http://localhost:3000
```

**Penjelasan:**
- Staging domain untuk testing
- Admin panel domain
- Local development jika developer konek ke staging API

### Production

```env
# .env (production server)
CORS_ALLOWED_ORIGINS=https://pmdkatingan.go.id,https://www.pmdkatingan.go.id,https://admin.pmdkatingan.go.id
```

**Penjelasan:**
- Main website
- WWW variant
- Admin panel
- **WAJIB HTTPS** untuk production!

### Production dengan Mobile App

```env
# .env
CORS_ALLOWED_ORIGINS=https://pmdkatingan.go.id,https://www.pmdkatingan.go.id,capacitor://localhost,ionic://localhost
```

**Penjelasan:**
- Web domains
- Capacitor/Ionic app domains (untuk hybrid mobile app)

## 🧪 Testing CORS Configuration

### 1. Check Config dari Terminal

```bash
# Clear cache
php artisan config:clear

# Test CORS config
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

### 2. Test dari Browser Console

Buka browser console (F12) dan test:

```javascript
// Test fetch API
fetch('http://127.0.0.1:8000/api/v1/news')
  .then(res => res.json())
  .then(data => console.log('✅ CORS OK:', data))
  .catch(err => console.error('❌ CORS Error:', err));
```

**Jika berhasil:**
```
✅ CORS OK: {success: true, message: "News retrieved successfully", data: [...]}
```

**Jika gagal:**
```
❌ CORS Error: Failed to fetch
❌ Console Error: "Access to fetch at '...' from origin '...' has been blocked by CORS policy"
```

### 3. Test dari cURL (Terminal)

```bash
# Request dengan Origin header
curl -H "Origin: http://localhost:3000" \
     -H "Access-Control-Request-Method: GET" \
     -H "Access-Control-Request-Headers: Content-Type" \
     -X OPTIONS \
     http://127.0.0.1:8000/api/v1/news -v
```

**Expected Response Headers:**
```
Access-Control-Allow-Origin: http://localhost:3000
Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS
Access-Control-Allow-Headers: Content-Type, Authorization
```

## 🐛 Troubleshooting CORS Issues

### Issue 1: CORS Error di Browser Console

**Gejala:**
```
Access to fetch at 'http://127.0.0.1:8000/api/v1/news' from origin 'http://localhost:3000' 
has been blocked by CORS policy: No 'Access-Control-Allow-Origin' header is present
```

**Penyebab:**
- Domain frontend tidak ada di `CORS_ALLOWED_ORIGINS`
- Salah ketik domain (typo)
- Cache belum di-clear

**Solusi:**
```bash
# 1. Check .env
cat .env | grep CORS

# 2. Tambahkan domain yang benar
# Edit .env:
CORS_ALLOWED_ORIGINS=http://localhost:3000,http://127.0.0.1:8000

# 3. Clear cache
php artisan config:clear

# 4. Test lagi dari browser
```

### Issue 2: Preflight Request Failed

**Gejala:**
```
Access to XMLHttpRequest has been blocked by CORS policy: 
Response to preflight request doesn't pass access control check
```

**Penyebab:**
- OPTIONS method tidak di-handle
- Headers tidak diizinkan
- Credentials issue

**Solusi:**

Edit `config/cors.php`:
```php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    
    'allowed_methods' => ['*'], // Allow all methods
    
    'allowed_origins' => env('CORS_ALLOWED_ORIGINS') 
        ? explode(',', env('CORS_ALLOWED_ORIGINS')) 
        : ['*'],
    
    'allowed_headers' => ['*'], // Allow all headers
    
    'exposed_headers' => [],
    
    'max_age' => 0,
    
    'supports_credentials' => true, // Important for auth!
];
```

Clear cache:
```bash
php artisan config:clear
```

### Issue 3: Authentication + CORS Error

**Gejala:**
```
CORS error ketika kirim request dengan Bearer token
Cookie tidak terkirim ke backend
```

**Penyebab:**
- `supports_credentials` = false
- Frontend tidak kirim credentials
- Domain tidak exact match

**Solusi Backend:**

`config/cors.php`:
```php
'supports_credentials' => true, // Wajib true untuk auth!
```

**Solusi Frontend (Fetch API):**
```javascript
fetch('http://127.0.0.1:8000/api/v1/admin/news', {
    method: 'GET',
    headers: {
        'Authorization': 'Bearer ' + token,
        'Content-Type': 'application/json'
    },
    credentials: 'include' // PENTING untuk auth!
})
```

**Solusi Frontend (Axios):**
```javascript
axios.defaults.withCredentials = true;

axios.get('http://127.0.0.1:8000/api/v1/admin/news', {
    headers: {
        'Authorization': 'Bearer ' + token
    }
})
```

### Issue 4: Wildcard + Credentials Error

**Gejala:**
```
The value of the 'Access-Control-Allow-Origin' header must not be the wildcard '*' 
when the request's credentials mode is 'include'
```

**Penyebab:**
- `allowed_origins` = `['*']` (wildcard)
- `supports_credentials` = true
- Browser tidak allow kombinasi ini (security!)

**Solusi:**
```env
# JANGAN pakai wildcard jika supports_credentials = true
# WAJIB specify domain exact

# ❌ SALAH:
CORS_ALLOWED_ORIGINS=*

# ✅ BENAR:
CORS_ALLOWED_ORIGINS=http://localhost:3000,http://127.0.0.1:8000
```

### Issue 5: Works in Postman, Error in Browser

**Penyebab:**
- Postman tidak enforce CORS (development tool)
- Browser enforce CORS (security)
- Beda behavior antara tool dan real browser

**Solusi:**
- Setup CORS yang benar seperti di atas
- Test di real browser, bukan hanya Postman
- Use browser dev tools untuk debugging

## 🔒 Security Best Practices

### ✅ DO (Lakukan):

```env
# 1. Specify exact domains
CORS_ALLOWED_ORIGINS=https://yourdomain.com,https://www.yourdomain.com

# 2. Use HTTPS in production
CORS_ALLOWED_ORIGINS=https://pmdkatingan.go.id

# 3. Separate config for dev and prod
# Dev: http://localhost:3000
# Prod: https://pmdkatingan.go.id

# 4. Minimal origins (only what you need)
CORS_ALLOWED_ORIGINS=https://pmdkatingan.go.id
```

### ❌ DON'T (Jangan):

```env
# 1. Wildcard in production
CORS_ALLOWED_ORIGINS=* # ❌ DANGER!

# 2. HTTP in production
CORS_ALLOWED_ORIGINS=http://pmdkatingan.go.id # ❌ Not secure!

# 3. Too many origins
CORS_ALLOWED_ORIGINS=http://a.com,http://b.com,http://c.com,... # ❌ Reduce attack surface

# 4. Development domains in production
CORS_ALLOWED_ORIGINS=https://pmdkatingan.go.id,http://localhost:3000 # ❌ Remove localhost!
```

## 📝 CORS Configuration Checklist

### Development Setup
- [ ] Add `CORS_ALLOWED_ORIGINS` to `.env`
- [ ] Include all local development ports
- [ ] Clear config cache: `php artisan config:clear`
- [ ] Test from browser console
- [ ] Test from frontend app
- [ ] Verify in browser network tab

### Production Setup
- [ ] Change to production domains only
- [ ] Use HTTPS (wajib!)
- [ ] Remove localhost entries
- [ ] Remove development domains
- [ ] Test from production frontend
- [ ] Monitor error logs for CORS issues
- [ ] Document allowed domains

### Security Checklist
- [ ] No wildcard (`*`) in production
- [ ] All domains use HTTPS
- [ ] Minimal domains (only necessary ones)
- [ ] `supports_credentials = true` for auth
- [ ] Test authentication flow
- [ ] Review CORS policy quarterly

## 🎯 Common Scenarios

### Scenario 1: Single Page App (React/Vue/Angular)

**Setup:**
```env
# Development
CORS_ALLOWED_ORIGINS=http://localhost:3000

# Production
CORS_ALLOWED_ORIGINS=https://pmdkatingan.go.id
```

### Scenario 2: Multiple Frontends

**Setup:**
```env
# Public website + Admin panel
CORS_ALLOWED_ORIGINS=https://pmdkatingan.go.id,https://admin.pmdkatingan.go.id
```

### Scenario 3: Mobile App + Web

**Setup:**
```env
# Web + Capacitor/Ionic app
CORS_ALLOWED_ORIGINS=https://pmdkatingan.go.id,capacitor://localhost
```

### Scenario 4: Microservices

**Setup:**
```env
# Multiple internal services
CORS_ALLOWED_ORIGINS=https://api1.pmdkatingan.go.id,https://api2.pmdkatingan.go.id,https://web.pmdkatingan.go.id
```

### Scenario 5: Third-party Integration

**Setup:**
```env
# Your domain + Partner domain (be careful!)
CORS_ALLOWED_ORIGINS=https://pmdkatingan.go.id,https://trusted-partner.com
```

## 📚 Resources

### Official Documentation
- [MDN CORS Guide](https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS)
- [Laravel CORS Package](https://github.com/fruitcake/laravel-cors)

### Testing Tools
- Browser DevTools (F12 → Network/Console)
- [CORS Test](https://www.test-cors.org/)
- cURL with Origin header

### Debugging
```bash
# Check current CORS config
php artisan tinker --execute="print_r(config('cors'));"

# Test specific origin
curl -H "Origin: http://localhost:3000" http://127.0.0.1:8000/api/v1/news -v

# Check response headers
curl -I http://127.0.0.1:8000/api/v1/news
```

## 🆘 Need Help?

Jika masih ada issue CORS:

1. **Clear all caches:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   ```

2. **Verify config:**
   ```bash
   php artisan tinker --execute="var_dump(config('cors.allowed_origins'));"
   ```

3. **Check browser console** (F12)
   - Lihat error message exact
   - Check Network tab → Headers
   - Look for `Access-Control-*` headers

4. **Test with cURL:**
   ```bash
   curl -H "Origin: YOUR_FRONTEND_URL" \
        -H "Access-Control-Request-Method: GET" \
        -X OPTIONS \
        YOUR_API_URL -v
   ```

5. **Check Laravel logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

---

## ✅ Summary

**Key Points:**
1. ✅ CORS configuration ada di `.env` → `CORS_ALLOWED_ORIGINS`
2. ✅ Sama seperti `L5_SWAGGER_CONST_HOST` → fleksibel per environment
3. ✅ Pisahkan multiple domains dengan **koma**
4. ✅ **Development:** allow localhost ports
5. ✅ **Production:** only HTTPS production domains
6. ✅ Clear cache setelah edit `.env`
7. ✅ Test dari browser (bukan cuma Postman!)

**Security:**
- ⚠️ **NEVER** use wildcard `*` in production
- ⚠️ **ALWAYS** use HTTPS in production
- ⚠️ **MINIMAL** domains (only what's needed)

Sekarang API Anda aman dan CORS sudah ter-konfigurasi dengan benar! 🔐🚀
