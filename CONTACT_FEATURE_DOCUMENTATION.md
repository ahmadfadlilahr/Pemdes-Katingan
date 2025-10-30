# Fitur Kelola Kontak - Dokumentasi

## Overview
Fitur Kelola Kontak memungkinkan admin untuk mengelola informasi kontak kantor dan menerima pesan dari pengunjung website.

## Fitur Utama

### 1. Panel Admin - Kelola Kontak
**Route:** `/admin/contacts`

**Fitur:**
- ✅ CRUD informasi kontak kantor
- ✅ Kelola email, telepon, WhatsApp
- ✅ Kelola media sosial (Facebook, Instagram, Twitter, YouTube)
- ✅ Kelola alamat, jam kerja, dan Google Maps embed
- ✅ Design responsive dan clean code

**Akses:**
- Sidebar Admin > Kelola Kontak > Informasi Kontak

### 2. Panel Admin - Kelola Pesan
**Route:** `/admin/messages`

**Fitur:**
- ✅ Melihat daftar pesan masuk
- ✅ Membaca detail pesan
- ✅ Menandai pesan sebagai dibaca/belum dibaca
- ✅ Menghapus pesan
- ✅ Tombol balas via email (membuka email client)
- ✅ Counter pesan belum dibaca di sidebar
- ✅ Design responsive dengan table view

**Akses:**
- Sidebar Admin > Kelola Kontak > Pesan Masuk

### 3. Halaman Kontak Publik
**Route:** `/kontak`

**Fitur:**
- ✅ Form kirim pesan dengan validasi lengkap
- ✅ Captcha matematika sederhana (anti-spam)
- ✅ Menampilkan informasi kontak dari database
- ✅ Menampilkan media sosial dengan icon
- ✅ Google Maps embed (jika tersedia)
- ✅ Responsive design untuk semua device
- ✅ UI/UX konsisten dengan halaman lainnya

## Database Structure

### Table: contacts
```sql
- id (primary key)
- email (required)
- phone (nullable)
- whatsapp (nullable)
- facebook (nullable)
- instagram (nullable)
- twitter (nullable)
- youtube (nullable)
- address (required)
- google_maps_embed (nullable)
- office_hours_open (required)
- office_hours_close (required)
- office_days (default: 'Senin - Jumat')
- created_at
- updated_at
```

### Table: messages
```sql
- id (primary key)
- name (required)
- email (required)
- subject (required)
- message (required)
- is_read (boolean, default: false)
- created_at
- updated_at
```

## Controllers

### AdminContactController
- `index()` - Menampilkan daftar kontak
- `create()` - Form tambah kontak
- `store()` - Menyimpan kontak baru
- `edit()` - Form edit kontak
- `update()` - Update kontak
- `destroy()` - Hapus kontak

### AdminMessageController
- `index()` - Menampilkan daftar pesan
- `show()` - Menampilkan detail pesan (auto mark as read)
- `destroy()` - Hapus pesan
- `toggleRead()` - Toggle status baca pesan

### ContactController (Public)
- `index()` - Menampilkan halaman kontak + generate captcha
- `store()` - Menyimpan pesan baru (dengan validasi captcha)

## Security Features

### Anti-Spam
1. **Captcha Matematika Sederhana**
   - Generate 2 angka random (1-10)
   - User harus menjawab penjumlahan
   - Jawaban disimpan di session
   - Validasi di server-side

### Validasi Form
- Semua field required divalidasi
- Email validation
- URL validation untuk social media
- Captcha validation
- Error messages yang jelas

## UI/UX Features

### Responsive Design
- ✅ Mobile-first approach
- ✅ Grid layout yang responsive
- ✅ Table responsive untuk daftar pesan
- ✅ Sidebar collapsible di mobile

### User Experience
- ✅ Loading states
- ✅ Success/error notifications
- ✅ Confirmation dialogs untuk delete
- ✅ Icon yang intuitif
- ✅ Color coding (unread messages)
- ✅ Breadcrumb navigation

### Clean Code
- ✅ Component-based structure
- ✅ Reusable blade components
- ✅ Consistent naming convention
- ✅ Proper code organization
- ✅ Comments untuk clarity

## Installation & Setup

1. **Run Migration:**
```bash
php artisan migrate
```

2. **Seed Default Contact:**
```bash
php artisan db:seed --class=ContactSeeder
```

3. **Access Admin Panel:**
- Login ke admin panel
- Navigasi ke "Kelola Kontak" di sidebar
- Edit informasi kontak sesuai kebutuhan

4. **Test Public Contact Page:**
- Buka `/kontak` di browser
- Test form kirim pesan
- Verifikasi captcha berfungsi

## Usage Examples

### Menambah Kontak Baru (Admin)
1. Login sebagai admin
2. Klik "Kelola Kontak" > "Informasi Kontak"
3. Klik "Tambah Kontak"
4. Isi form (minimal email, alamat, jam kerja)
5. Klik "Simpan Kontak"

### Melihat Pesan Masuk (Admin)
1. Login sebagai admin
2. Klik "Kelola Kontak" > "Pesan Masuk"
3. Lihat daftar pesan (yang belum dibaca ditandai)
4. Klik "Lihat" untuk detail
5. Pesan otomatis ditandai sudah dibaca
6. Klik "Balas via Email" untuk membalas

### Mengirim Pesan (Public)
1. Buka `/kontak`
2. Isi form kontak
3. Selesaikan captcha matematika
4. Klik "Kirim Pesan"
5. Pesan akan masuk ke admin panel

## Tips & Best Practices

1. **Google Maps Embed:**
   - Buka Google Maps
   - Cari lokasi kantor
   - Klik "Share" > "Embed a map"
   - Copy URL iframe src
   - Paste ke field Google Maps Embed

2. **Format WhatsApp:**
   - Gunakan format: 62xxxxxxxxxxx
   - Contoh: 6281234567890
   - Jangan gunakan tanda +, -, atau spasi

3. **Media Sosial:**
   - Gunakan URL lengkap (https://)
   - Verifikasi URL valid sebelum save

4. **Maintenance:**
   - Cek pesan masuk secara berkala
   - Hapus spam jika ada
   - Update informasi kontak saat berubah

## Troubleshooting

### Captcha tidak berfungsi
- Clear session: `php artisan cache:clear`
- Pastikan session driver configured

### Pesan tidak masuk
- Cek validasi form
- Cek database connection
- Cek error logs

### Google Maps tidak tampil
- Pastikan URL embed valid
- Cek iframe sandbox policy
- Verifikasi embed code

## Future Enhancements (Optional)
- Email notification saat pesan baru
- Export messages to CSV/Excel
- Advanced spam filtering
- Message categories
- Auto-reply templates
- Google reCAPTCHA integration

---

**Developed by:** Ahmad Fadlilah R
**Date:** October 30, 2025
**Version:** 1.0.0
