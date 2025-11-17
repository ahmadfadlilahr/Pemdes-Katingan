# Quick API Test Script

## Prerequisites
Pastikan Laravel development server berjalan:
```bash
php artisan serve
```

## Test Endpoints

### 1. Test News API
```bash
# Get all news (paginated)
curl http://localhost:8000/api/v1/news

# Get news with pagination
curl "http://localhost:8000/api/v1/news?per_page=5&page=1"

# Search news
curl "http://localhost:8000/api/v1/news?search=desa"

# Get news categories
curl http://localhost:8000/api/v1/news/categories
```

### 2. Test Agenda API
```bash
# Get all agenda
curl http://localhost:8000/api/v1/agenda

# Get upcoming agenda only
curl "http://localhost:8000/api/v1/agenda?upcoming=true"

# Get agenda with date range
curl "http://localhost:8000/api/v1/agenda?from_date=2025-01-01&to_date=2025-12-31"
```

### 3. Test Gallery API
```bash
# Get all gallery
curl http://localhost:8000/api/v1/gallery

# Search gallery
curl "http://localhost:8000/api/v1/gallery?search=kegiatan"
```

### 4. Test Documents API
```bash
# Get all documents
curl http://localhost:8000/api/v1/documents

# Filter by category
curl "http://localhost:8000/api/v1/documents?category=Peraturan"

# Get document categories
curl http://localhost:8000/api/v1/documents/categories

# Track document download (replace {id} with actual document ID)
curl -X POST http://localhost:8000/api/v1/documents/1/download
```

### 5. Test Organization API
```bash
# Get organization structure (hierarchical)
curl http://localhost:8000/api/v1/organization

# Get member detail (replace {id} with actual member ID)
curl http://localhost:8000/api/v1/organization/1
```

### 6. Test Information API
```bash
# Get contact information
curl http://localhost:8000/api/v1/contact

# Get vision & mission
curl http://localhost:8000/api/v1/vision-mission

# Get welcome message
curl http://localhost:8000/api/v1/welcome-message
```

### 7. Test Statistics API
```bash
# Get overall statistics
curl http://localhost:8000/api/v1/stats

# Get news statistics
curl http://localhost:8000/api/v1/stats/news

# Get document statistics
curl http://localhost:8000/api/v1/stats/documents
```

## Test Rate Limiting

Test apakah rate limiting (60 req/min) berfungsi:

```bash
# Windows PowerShell
for ($i=1; $i -le 65; $i++) {
    Write-Host "Request $i"
    curl http://localhost:8000/api/v1/stats
    Start-Sleep -Milliseconds 500
}

# Linux/Mac
for i in {1..65}; do 
    echo "Request $i"
    curl http://localhost:8000/api/v1/stats
    sleep 0.5
done
```

Harapan: Request ke-61 akan mendapat response `429 Too Many Requests`

## Verify Swagger UI

Access interactive documentation:
```
http://localhost:8000/api/documentation
```

Pastikan:
- ✅ Semua 19 endpoints terdaftar
- ✅ Bisa "Try it out" langsung dari UI
- ✅ Request/Response schemas tampil dengan benar
- ✅ Example values tersedia
- ✅ Tags (News, Agenda, Gallery, etc.) terorganisir dengan baik

## Expected Response Format

### Success Response
```json
{
  "success": true,
  "message": "Data retrieved successfully",
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
    "last_page": 5,
    "per_page": 15,
    "total": 75
  },
  "links": {
    "first": "http://localhost:8000/api/v1/news?page=1",
    "last": "http://localhost:8000/api/v1/news?page=5",
    "prev": null,
    "next": "http://localhost:8000/api/v1/news?page=2"
  }
}
```

### Error Response (404)
```json
{
  "success": false,
  "message": "Resource not found"
}
```

### Rate Limit Response (429)
```json
{
  "message": "Too Many Requests"
}
```

## Troubleshooting

### API routes tidak muncul
```bash
# Clear route cache
php artisan route:clear

# Verify API routes registered
php artisan route:list --path=api
```

### Swagger UI tidak menampilkan endpoints
```bash
# Regenerate Swagger docs
php artisan l5-swagger:generate

# Clear config cache
php artisan config:clear

# Clear view cache
php artisan view:clear
```

### Error 500 Internal Server Error
```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Check error details
APP_DEBUG=true di .env (development only!)
```

### CORS errors (jika akses dari domain berbeda)
Add CORS middleware di `routes/api.php`:
```php
Route::middleware('cors')->prefix('v1')->group(function () {
    // ... routes
});
```

## Production Checklist

Before deploying to production:

- [ ] Set `APP_DEBUG=false` di .env
- [ ] Set `APP_ENV=production` di .env
- [ ] Update `APP_URL` dengan domain production
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Regenerate Swagger: `php artisan l5-swagger:generate`
- [ ] Test all endpoints di production environment
- [ ] Setup monitoring untuk API usage
- [ ] Consider adding API authentication (Laravel Sanctum)
- [ ] Setup HTTPS/SSL certificate
- [ ] Configure proper CORS if needed

## Notes

- Rate limit: **60 requests per minute**
- Max pagination: **50 items per page**
- All responses in **JSON format**
- Date format: **ISO 8601** (2025-01-15T10:30:00+07:00)
- File URLs: **Absolute paths** with asset()
- NIP masking: **First 8 digits masked** in Organization API

## Resources

- **Swagger UI:** http://localhost:8000/api/documentation
- **API Documentation:** docs/API_DOCUMENTATION.md
- **Implementation Summary:** docs/API_IMPLEMENTATION_SUMMARY.md
- **OpenAPI JSON:** http://localhost:8000/api-docs/api-docs.json
