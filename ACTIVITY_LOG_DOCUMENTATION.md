# Log Activity System - Dokumentasi

## 📋 Fitur Utama

### 1. **Auto-Logging CRUD Operations**
   - Otomatis mencatat setiap operasi Create, Update, Delete pada model
   - Menggunakan Trait `LogsActivity` yang reusable
   - Menyimpan data before/after untuk tracking perubahan
   - Mencatat IP address dan User Agent

### 2. **Auto-Delete Log Lama (30 Hari)**
   - Scheduler berjalan otomatis setiap hari pukul 01:00 WIB
   - Menghapus log yang lebih dari 30 hari
   - Dapat dijalankan manual via command: `php artisan activity-log:clean`
   - Konfigurasi hari dapat disesuaikan: `php artisan activity-log:clean --days=60`

### 3. **Timezone WIB (Asia/Jakarta)**
   - Seluruh aplikasi menggunakan timezone WIB
   - Format waktu: `d M Y, H:i WIB`
   - Update di `config/app.php`: `'timezone' => 'Asia/Jakarta'`

### 4. **Dashboard Widget**
   - Menampilkan 5 aktivitas terbaru
   - Tombol "Lihat Semua" ke halaman detail
   - Statistik: Total aktivitas & Aktivitas hari ini
   - Design minimalis dan profesional
   - Responsive di semua device

### 5. **Halaman Activity Log Lengkap**
   - **Filter & Search**: Cari berdasarkan user, aksi, model, tanggal, deskripsi
   - **Bulk Delete**: Pilih multiple log untuk dihapus sekaligus
   - **Manual Delete**: Hapus log individual
   - **Clean Old Logs**: Tombol untuk menghapus semua log > 30 hari
   - **Pagination**: 20 item per halaman
   - **Responsive Design**: Desktop, Tablet, Mobile

---

## 🚀 Cara Menggunakan

### A. Otomatis (Auto-Logging)

Model yang sudah menggunakan `LogsActivity` trait akan otomatis mencatat aktivitas:

**Models yang sudah di-apply:**
- `News`
- `Agenda`
- `Hero`
- `Gallery`
- `Document`
- `VisionMission`
- `OrganizationStructure`
- `User`

**Contoh:**
```php
// Saat membuat berita baru
$news = News::create([
    'title' => 'Judul Berita',
    'content' => 'Isi berita...',
]);
// ✅ Otomatis tercatat: "Admin membuat berita 'Judul Berita'"

// Saat mengupdate berita
$news->update(['title' => 'Judul Baru']);
// ✅ Otomatis tercatat: "Admin mengupdate berita 'Judul Baru'"

// Saat menghapus berita
$news->delete();
// ✅ Otomatis tercatat: "Admin menghapus berita 'Judul Baru'"
```

### B. Manual Logging

Untuk aktivitas custom (login, logout, dll):

```php
use App\Models\ActivityLog;

// Simple log
ActivityLog::create([
    'user_id' => auth()->id(),
    'action' => 'login',
    'description' => 'login ke sistem',
    'ip_address' => request()->ip(),
    'user_agent' => request()->userAgent(),
]);

// Log dengan properties (data tambahan)
ActivityLog::create([
    'user_id' => auth()->id(),
    'action' => 'export',
    'description' => 'mengexport data berita ke Excel',
    'properties' => [
        'format' => 'xlsx',
        'total_rows' => 150,
    ],
    'ip_address' => request()->ip(),
    'user_agent' => request()->userAgent(),
]);
```

### C. Menambahkan Model Baru

Untuk menambahkan auto-logging ke model lain:

```php
namespace App\Models;

use App\Traits\LogsActivity; // Import trait
use Illuminate\Database\Eloquent\Model;

class YourModel extends Model
{
    use LogsActivity; // Tambahkan trait
    
    // ... model code ...
}
```

**Optional: Custom Description**
```php
public function getLogDescription(): string
{
    return "custom model \"{$this->name}\"";
}
```

---

## 📊 Akses Halaman

### Dashboard Widget
- **URL**: `/dashboard` (sudah terintegrasi)
- **Tampilan**: 5 aktivitas terbaru
- **Link**: "Lihat Semua" → Halaman lengkap

### Halaman Activity Log Lengkap
- **URL**: `/admin/activity-logs`
- **Route Name**: `admin.activity-logs.index`
- **Middleware**: `auth`, `active-user`

### API Statistics (Optional)
- **URL**: `/admin/activity-logs-stats`
- **Route Name**: `admin.activity-logs.statistics`
- **Response**: JSON dengan statistik aktivitas

---

## ⚙️ Scheduled Tasks

### Setup Scheduler (Production)

**1. Tambahkan ke Cron (Linux/Mac):**
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

**2. Windows Task Scheduler:**
- Buka Task Scheduler
- Create Task: Run every 1 minute
- Action: `php artisan schedule:run`

**3. Test Manual:**
```bash
# Jalankan scheduler sekali
php artisan schedule:run

# Jalankan command langsung
php artisan activity-log:clean

# Custom retention (60 hari)
php artisan activity-log:clean --days=60
```

### Scheduled Jobs Yang Berjalan

| Command | Waktu | Deskripsi |
|---------|-------|-----------|
| `activity-log:clean` | 01:00 WIB (Daily) | Hapus log > 30 hari |

---

## 🎨 Kustomisasi

### 1. Mengubah Retention Period

**Di Command:**
```bash
php artisan activity-log:clean --days=90  # 90 hari
```

**Di Controller (Clean Button):**
```php
// app/Http/Controllers/Admin/ActivityLogController.php
public function clean()
{
    $count = ActivityLog::deleteOlderThan(90); // Ubah dari 30 ke 90
    return redirect()->route('admin.activity-logs.index')
        ->with('success', "{$count} log aktivitas lama berhasil dihapus.");
}
```

**Di Scheduler:**
```php
// routes/console.php
Schedule::command('activity-log:clean --days=90')->dailyAt('01:00');
```

### 2. Mengubah Action Names

Edit di `app/Models/ActivityLog.php`:

```php
public function getActionNameAttribute(): string
{
    return match($this->action) {
        'created' => 'Membuat',
        'updated' => 'Mengupdate',
        'deleted' => 'Menghapus',
        'custom_action' => 'Aksi Custom', // Tambahkan custom
        default => ucfirst($this->action),
    };
}
```

### 3. Mengubah Model Names (Indonesian)

Edit di `app/Models/ActivityLog.php`:

```php
public function getModelNameAttribute(): string
{
    $modelName = class_basename($this->model_type);
    
    return match($modelName) {
        'News' => 'Berita',
        'YourModel' => 'Model Kamu', // Tambahkan custom
        default => $modelName,
    };
}
```

### 4. Mengubah Jumlah Widget Items

```blade
<!-- resources/views/dashboard.blade.php -->
<x-activity-log-widget :limit="10" />  <!-- Dari 5 ke 10 -->
```

### 5. Mengubah Pagination

```php
// app/Http/Controllers/Admin/ActivityLogController.php
$logs = $query->paginate(50); // Dari 20 ke 50
```

---

## 🔧 Troubleshooting

### Log tidak tercatat saat CRUD

**Cek:**
1. Apakah model sudah pakai `use LogsActivity;`?
2. Apakah migration sudah dijalankan?
3. Apakah user sudah login (auth)?

**Test:**
```php
// Di tinker
php artisan tinker
$news = App\Models\News::first();
$news->update(['title' => 'Test']);
// Cek: App\Models\ActivityLog::latest()->first();
```

### Scheduler tidak berjalan

**Cek:**
1. Apakah cron job sudah disetup?
2. Test manual: `php artisan schedule:run`
3. Cek log: `storage/logs/laravel.log`

### Waktu tidak sesuai WIB

**Cek:**
1. `config/app.php`: `'timezone' => 'Asia/Jakarta'`
2. Clear config: `php artisan config:clear`
3. Restart server

### Widget tidak muncul di dashboard

**Cek:**
1. Apakah file `resources/views/components/activity-log-widget.blade.php` ada?
2. Apakah `dashboard.blade.php` sudah di-update?
3. Clear view cache: `php artisan view:clear`

---

## 📱 Responsive Design

### Breakpoints

| Device | Width | Layout |
|--------|-------|--------|
| Mobile | < 640px | Single column, compact table |
| Tablet | 640px - 1024px | 2 columns, hide some columns |
| Desktop | > 1024px | Full layout, all columns visible |

### Hidden Columns on Mobile

- **Mobile**: Hide Model, Waktu columns
- **Tablet**: Show Waktu, hide Model
- **Desktop**: Show all columns

---

## 🔒 Security

### Middleware Protection

- **Auth**: Harus login
- **Active User**: User harus aktif
- **Admin**: Hanya admin yang bisa akses

### CSRF Protection

- Semua form menggunakan `@csrf`
- Delete actions require confirmation

### Input Validation

- Filter inputs di-validate
- Bulk actions require array validation
- XSS protection via Laravel escaping

---

## 📝 Database Schema

```sql
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `model_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `properties` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `activity_logs_model_type_model_id_index` (`model_type`,`model_id`),
  KEY `activity_logs_action_index` (`action`),
  KEY `activity_logs_created_at_index` (`created_at`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
);
```

---

## ✅ Checklist Testing

- [ ] Login dan cek dashboard → Widget muncul
- [ ] Buat berita baru → Log tercatat
- [ ] Update berita → Log tercatat dengan before/after
- [ ] Hapus berita → Log tercatat
- [ ] Akses `/admin/activity-logs` → Halaman terbuka
- [ ] Test filter (user, action, date) → Filter berfungsi
- [ ] Test search → Search berfungsi
- [ ] Test bulk delete → Multiple delete berhasil
- [ ] Test single delete → Single delete berhasil
- [ ] Test "Clean Old Logs" → Logs > 30 hari terhapus
- [ ] Test responsive (mobile/tablet/desktop) → Layout responsive
- [ ] Test scheduler: `php artisan schedule:run` → Berjalan tanpa error
- [ ] Cek timezone di log → Waktu dalam WIB

---

## 📈 Performance Tips

### Indexing (Sudah diterapkan)

- `user_id`, `created_at` (composite)
- `model_type`, `model_id` (polymorphic)
- `action` (filtering)
- `created_at` (sorting)

### Optimize Queries

```php
// Eager load relationships
ActivityLog::with('user')->latest()->get();

// Limit results
ActivityLog::latest()->limit(100)->get();

// Use cursors untuk large dataset
ActivityLog::cursor()->each(function ($log) {
    // Process...
});
```

### Caching (Optional)

```php
// Cache statistics
$stats = Cache::remember('activity_log_stats', 3600, function () {
    return [
        'total' => ActivityLog::count(),
        'today' => ActivityLog::whereDate('created_at', today())->count(),
    ];
});
```

---

## 🎯 Best Practices

1. **DRY Principle**: Gunakan trait untuk reusable code
2. **Clean Code**: Pisahkan logic di Model, Controller, View
3. **Meaningful Names**: Gunakan nama yang jelas dan deskriptif
4. **Responsive Design**: Test di berbagai device
5. **Security First**: Selalu validate input dan protect routes
6. **Performance**: Index database columns yang sering di-query
7. **Documentation**: Comment code yang complex
8. **Testing**: Test setiap fitur setelah development

---

## 🆘 Support

Jika ada masalah atau pertanyaan:

1. Cek dokumentasi ini terlebih dahulu
2. Cek error di `storage/logs/laravel.log`
3. Test di tinker: `php artisan tinker`
4. Clear cache: `php artisan cache:clear`, `php artisan config:clear`, `php artisan view:clear`

---

**Status**: ✅ Production Ready  
**Version**: 1.0.0  
**Last Updated**: {{ now()->format('d M Y, H:i') }} WIB
