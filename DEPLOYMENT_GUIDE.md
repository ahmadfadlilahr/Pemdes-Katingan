# Panduan Deployment Production

Panduan ini berisi langkah-langkah untuk deploy API PMD Katingan dari development ke production.

## 📋 Persiapan Deployment

### 1. Konfigurasi Environment Production

Edit file `.env` di server production:

```env
# Application Settings
APP_NAME="Dinas PMD Katingan API"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://pmdkatingan.go.id

# API Documentation Base URL
# ⚠️ PENTING: Ganti dengan URL production Anda
L5_SWAGGER_CONST_HOST=https://pmdkatingan.go.id

# Database Production
DB_CONNECTION=mysql
DB_HOST=your-production-db-host
DB_PORT=3306
DB_DATABASE=your_production_database
DB_USERNAME=your_production_user
DB_PASSWORD=your_secure_password

# CORS (Sesuaikan dengan frontend domain)
CORS_ALLOWED_ORIGINS=https://pmdkatingan.go.id,https://www.pmdkatingan.go.id

# Session & Cache
SESSION_DRIVER=database
CACHE_DRIVER=file
QUEUE_CONNECTION=database

# Mail Configuration (opsional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@pmdkatingan.go.id
MAIL_FROM_NAME="${APP_NAME}"
```

### 2. Langkah Deployment Step-by-Step

#### A. Upload Files ke Server

```bash
# Compress project (exclude node_modules, vendor, storage)
zip -r pmd-api.zip . -x "node_modules/*" "vendor/*" "storage/*" ".git/*"

# Upload ke server menggunakan FTP/SFTP atau Git
# Atau jika menggunakan Git:
git push production main
```

#### B. Install Dependencies di Server

```bash
# SSH ke server production
ssh user@your-server.com

# Masuk ke directory aplikasi
cd /path/to/pmd-api

# Install Composer dependencies (production only)
composer install --no-dev --optimize-autoloader

# Install Node dependencies (jika ada)
npm install --production
npm run build
```

#### C. Setup Permission & Ownership

```bash
# Set ownership (sesuaikan dengan web server user)
sudo chown -R www-data:www-data /path/to/pmd-api

# Set permission untuk storage dan bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Set permission untuk direktori upload
sudo chmod -R 775 public/storage
```

#### D. Generate Application Key

```bash
# Generate key baru untuk production
php artisan key:generate

# ⚠️ PENTING: Jangan pernah share APP_KEY production!
```

#### E. Setup Database

```bash
# Jalankan migrations
php artisan migrate --force

# Seed data awal (jika diperlukan)
php artisan db:seed --force

# Atau import dump dari development
mysql -u username -p production_db < database_dump.sql
```

#### F. Create Storage Symlink

```bash
# Link storage ke public
php artisan storage:link
```

#### G. Cache Optimization

```bash
# Clear semua cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Generate cache untuk production (opsional, untuk performance)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### H. Generate Swagger Documentation

```bash
# Generate dokumentasi API dengan URL production
php artisan l5-swagger:generate

# Dokumentasi akan tersedia di:
# https://pmdkatingan.go.id/api/documentation
```

### 3. Konfigurasi Web Server

#### Nginx Configuration

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name pmdkatingan.go.id www.pmdkatingan.go.id;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name pmdkatingan.go.id www.pmdkatingan.go.id;

    # SSL Certificate
    ssl_certificate /etc/ssl/certs/pmdkatingan.crt;
    ssl_certificate_key /etc/ssl/private/pmdkatingan.key;

    root /path/to/pmd-api/public;
    index index.php index.html;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;

    # Increase upload size limit
    client_max_body_size 20M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Cache static assets
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

#### Apache Configuration (.htaccess sudah ada di Laravel)

Jika menggunakan Apache, pastikan mod_rewrite enabled:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 4. Setup SSL Certificate

#### Menggunakan Let's Encrypt (Gratis)

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx

# Generate certificate
sudo certbot --nginx -d pmdkatingan.go.id -d www.pmdkatingan.go.id

# Auto-renewal sudah dihandle oleh certbot
```

### 5. Testing di Production

#### A. Test Basic Endpoints

```bash
# Test health check
curl https://pmdkatingan.go.id/api/v1/info

# Test public news
curl https://pmdkatingan.go.id/api/v1/news

# Test Swagger UI
# Buka di browser: https://pmdkatingan.go.id/api/documentation
```

#### B. Test Authentication

```bash
# Login
curl -X POST https://pmdkatingan.go.id/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@pmdkatingan.go.id","password":"your-password"}'

# Gunakan token untuk test admin endpoint
curl https://pmdkatingan.go.id/api/v1/admin/news \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 6. Monitoring & Maintenance

#### Setup Log Monitoring

```bash
# Check error logs
tail -f storage/logs/laravel.log

# Check Nginx access logs
sudo tail -f /var/log/nginx/access.log

# Check Nginx error logs
sudo tail -f /var/log/nginx/error.log
```

#### Setup Cron Job untuk Queue (jika menggunakan queue)

```bash
# Edit crontab
crontab -e

# Tambahkan:
* * * * * cd /path/to/pmd-api && php artisan schedule:run >> /dev/null 2>&1
```

#### Backup Database Otomatis

```bash
# Buat script backup
#!/bin/bash
mysqldump -u username -p'password' production_db > /backups/db_$(date +%Y%m%d_%H%M%S).sql

# Simpan 7 hari terakhir
find /backups -name "db_*.sql" -mtime +7 -delete

# Tambahkan ke crontab (backup setiap hari jam 2 pagi)
0 2 * * * /path/to/backup-script.sh
```

## 🔄 Update Production (Deployment Berikutnya)

Ketika ada perubahan code:

```bash
# 1. Backup database
mysqldump -u username -p database_name > backup_before_update.sql

# 2. Enable maintenance mode
php artisan down

# 3. Pull changes
git pull origin main

# 4. Update dependencies
composer install --no-dev --optimize-autoloader

# 5. Run migrations (jika ada)
php artisan migrate --force

# 6. Clear dan rebuild cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Regenerate Swagger docs
php artisan l5-swagger:generate

# 8. Disable maintenance mode
php artisan up
```

## 🚨 Troubleshooting

### Issue: 500 Internal Server Error

**Solusi:**

```bash
# Check logs
tail -f storage/logs/laravel.log

# Check permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Clear cache
php artisan config:clear
php artisan cache:clear
```

### Issue: Database Connection Error

**Solusi:**

```bash
# Test database connection
mysql -u username -p -h hostname database_name

# Pastikan .env DB settings benar
# Pastikan DB host accessible dari server
```

### Issue: File Upload Error

**Solusi:**

```bash
# Check storage permissions
sudo chmod -R 775 storage/app/public
sudo chown -R www-data:www-data storage

# Recreate symlink
rm public/storage
php artisan storage:link

# Check upload limits di php.ini
upload_max_filesize = 20M
post_max_size = 20M
```

### Issue: Swagger UI Not Loading

**Solusi:**

```bash
# Regenerate docs
php artisan l5-swagger:generate

# Check L5_SWAGGER_CONST_HOST di .env
# Pastikan menggunakan https:// untuk production

# Clear cache
php artisan config:clear
```

### Issue: CORS Error

**Solusi:**

Edit `config/cors.php`:

```php
'allowed_origins' => [
    'https://pmdkatingan.go.id',
    'https://www.pmdkatingan.go.id',
],
```

```bash
# Clear config cache
php artisan config:clear
```

## 📊 Performance Optimization

### 1. Enable OPcache

Edit `/etc/php/8.3/fpm/php.ini`:

```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=10000
opcache.revalidate_freq=2
```

### 2. Enable Redis Cache (opsional)

```bash
# Install Redis
sudo apt install redis-server

# Install PHP Redis extension
sudo apt install php8.3-redis

# Update .env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### 3. Database Optimization

```sql
-- Add indexes untuk kolom yang sering dicari
ALTER TABLE news ADD INDEX idx_is_published (is_published);
ALTER TABLE news ADD INDEX idx_published_at (published_at);
ALTER TABLE agendas ADD INDEX idx_start_date (start_date);
```

## ✅ Production Deployment Checklist

Sebelum go-live, pastikan semua checklist ini sudah ✅:

### Pre-Deployment

- [ ] Backup database development
- [ ] Test semua fitur di local
- [ ] Update dokumentasi jika ada perubahan
- [ ] Siapkan credentials production (DB, email, dll)
- [ ] Request SSL certificate atau setup Let's Encrypt
- [ ] Setup DNS record (A record untuk domain)

### Deployment

- [ ] Upload files ke server
- [ ] Install composer dependencies
- [ ] Set permissions (755 untuk directory, 644 untuk file)
- [ ] Configure .env dengan settings production
- [ ] Generate APP_KEY baru
- [ ] Jalankan migrations
- [ ] Create storage symlink
- [ ] Generate Swagger documentation
- [ ] Configure web server (Nginx/Apache)
- [ ] Setup SSL certificate
- [ ] Test semua endpoint

### Post-Deployment

- [ ] Test Swagger UI di https://yourdomain.com/api/documentation
- [ ] Test login dan authentication
- [ ] Test CRUD operations (create, update, delete)
- [ ] Test file upload
- [ ] Test responsive UI di berbagai device
- [ ] Monitor error logs selama 24 jam pertama
- [ ] Setup backup otomatis
- [ ] Setup monitoring (optional: UptimeRobot, New Relic)
- [ ] Update DNS TTL kembali ke normal (3600)

### Security Checklist

- [ ] APP_DEBUG=false
- [ ] APP_ENV=production
- [ ] Strong passwords untuk DB user
- [ ] Firewall configured (hanya port 80, 443, 22)
- [ ] SSH key-based authentication
- [ ] Disable root SSH login
- [ ] Keep server packages updated
- [ ] Regular security audits

## 📞 Support

Jika ada masalah saat deployment:

1. Check error logs: `storage/logs/laravel.log`
2. Check web server logs: `/var/log/nginx/error.log`
3. Test database connection
4. Verify file permissions
5. Clear all caches dan regenerate

## 🎉 Selesai!

Setelah semua langkah di atas selesai, API Anda sudah siap production di:

- **API Documentation:** https://yourdomain.com/api/documentation
- **Base API URL:** https://yourdomain.com/api/v1

Untuk mengubah URL production, cukup edit `L5_SWAGGER_CONST_HOST` di `.env` dan regenerate swagger:

```bash
# Edit .env
L5_SWAGGER_CONST_HOST=https://new-domain.com

# Regenerate
php artisan config:clear
php artisan l5-swagger:generate
```

**Selamat! API Anda sudah live! 🚀**
