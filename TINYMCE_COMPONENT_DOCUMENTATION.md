# TinyMCE Editor Component - Dokumentasi

## 📋 Overview
Komponen Blade untuk TinyMCE Editor dengan konfigurasi lengkap, styling modern, dan fitur mirip Microsoft Office.

## 🎯 Fitur Utama

### 1. **Rich Text Editing**
- Bold, Italic, Underline, Strikethrough
- Text alignment (left, center, right, justify)
- Text & background colors
- Font formatting

### 2. **Content Formatting**
- Headings (H1-H6)
- Paragraphs
- Lists (ordered & unordered)
- Blockquotes
- Code blocks
- Tables

### 3. **Media Management**
- Image upload & embedding
- Link management
- Media embedding
- File picker

### 4. **Advanced Features**
- Full-screen mode
- Search & replace
- Word count
- Visual blocks
- Character map
- Preview mode
- Print support

### 5. **Bahasa Indonesia**
- Interface dalam Bahasa Indonesia
- Menu dan toolbar dalam bahasa lokal

## 📦 Struktur File

```
resources/
└── views/
    └── components/
        └── admin/
            └── tinymce-editor.blade.php    # Komponen utama
```

## 🔧 Cara Menggunakan

### Basic Usage

```blade
<x-admin.tinymce-editor
    id="content"
    name="content"
    label="Isi Berita"
    :required="true"
/>
```

### Advanced Usage dengan Semua Parameter

```blade
<x-admin.tinymce-editor
    id="article_content"
    name="content"
    label="Konten Artikel"
    :value="old('content', $article->content ?? '')"
    :required="true"
    :height="600"
    placeholder="Mulai menulis artikel Anda..."
/>
```

## 🎨 Parameters

| Parameter | Type | Default | Required | Description |
|-----------|------|---------|----------|-------------|
| `id` | string | 'editor' | No | ID unik untuk textarea |
| `name` | string | 'content' | No | Nama field form |
| `label` | string | 'Konten' | No | Label yang ditampilkan |
| `value` | string | '' | No | Nilai awal editor |
| `required` | boolean | false | No | Apakah field wajib diisi |
| `error` | string | null | No | Pesan error manual |
| `height` | integer | 500 | No | Tinggi editor dalam pixel |
| `placeholder` | string | 'Tulis konten...' | No | Placeholder text |

## 💡 Contoh Implementasi

### 1. Form Create Berita

```blade
<form action="{{ route('admin.news.store') }}" method="POST">
    @csrf
    
    <!-- Judul -->
    <div>
        <label>Judul Berita *</label>
        <input type="text" name="title" required>
    </div>
    
    <!-- Konten dengan TinyMCE -->
    <x-admin.tinymce-editor
        id="content"
        name="content"
        label="Isi Berita"
        :required="true"
        :height="500"
    />
    
    <button type="submit">Simpan</button>
</form>
```

### 2. Form Edit Berita

```blade
<form action="{{ route('admin.news.update', $news) }}" method="POST">
    @csrf
    @method('PUT')
    
    <!-- Konten dengan TinyMCE -->
    <x-admin.tinymce-editor
        id="content"
        name="content"
        label="Isi Berita"
        :value="old('content', $news->content)"
        :required="true"
    />
    
    <button type="submit">Update</button>
</form>
```

### 3. Multiple Editors dalam Satu Halaman

```blade
<!-- Editor untuk Konten Utama -->
<x-admin.tinymce-editor
    id="main_content"
    name="content"
    label="Konten Utama"
    :height="600"
/>

<!-- Editor untuk Sidebar -->
<x-admin.tinymce-editor
    id="sidebar_content"
    name="sidebar"
    label="Konten Sidebar"
    :height="300"
/>
```

## ⚙️ Konfigurasi

### Toolbar Configuration
Editor dilengkapi dengan toolbar lengkap:
- Undo/Redo
- Format Selector
- Text Formatting (Bold, Italic, Underline, Strikethrough)
- Colors (Foreground & Background)
- Text Alignment
- Lists & Indentation
- Insert (Link, Image, Media)
- Tables
- Remove Format
- Help

### Menu Bar
Menu bar tersedia dengan kategori:
- **File**: New document, Preview, Print
- **Edit**: Undo, Redo, Cut, Copy, Paste, Search & Replace
- **View**: Code view, Visual aids, Fullscreen
- **Insert**: Image, Link, Media, Table, Special characters
- **Format**: Text formatting, Fonts, Colors
- **Tools**: Spell checker, Word count
- **Table**: Table operations
- **Help**: Documentation

### Plugins yang Diaktifkan
```javascript
plugins: [
    'advlist',        // Advanced list options
    'autolink',       // Auto-detect URLs
    'lists',          // List formatting
    'link',           // Link management
    'image',          // Image handling
    'charmap',        // Special characters
    'preview',        // Preview mode
    'anchor',         // Anchor links
    'searchreplace',  // Search & replace
    'visualblocks',   // Visual blocks
    'code',           // HTML code view
    'fullscreen',     // Fullscreen mode
    'insertdatetime', // Date/time insertion
    'media',          // Media embedding
    'table',          // Table creation
    'help',           // Help documentation
    'wordcount'       // Word counter
]
```

## 🎨 Styling

### Custom CSS
Komponen sudah dilengkapi dengan styling custom yang konsisten dengan design system aplikasi:

```css
.tox-tinymce {
    border-radius: 0.375rem;
    border-color: #d1d5db;
}

.tox-toolbar {
    background: #f9fafb;
}
```

### Content Style
Editor menggunakan styling yang clean dan modern untuk konten:
- Typography yang konsisten
- Heading hierarchy yang jelas
- Link styling dengan warna blue
- Table styling dengan border
- Code block dengan syntax highlighting
- Responsive images

## 🖼️ Image Upload

### Default Behavior
Secara default, gambar dikonversi ke base64 dan disimpan inline dalam konten.

### Custom Upload Handler (Optional)
Untuk menyimpan gambar ke server, Anda bisa memodifikasi `images_upload_handler`:

```javascript
images_upload_handler: function (blobInfo, success, failure) {
    const formData = new FormData();
    formData.append('image', blobInfo.blob(), blobInfo.filename());
    
    fetch('/api/upload-image', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        success(data.location); // URL gambar yang di-upload
    })
    .catch(error => {
        failure('Image upload failed: ' + error.message);
    });
}
```

## ⌨️ Keyboard Shortcuts

- **Ctrl+Enter**: Submit form
- **Ctrl+Z**: Undo
- **Ctrl+Y**: Redo
- **Ctrl+B**: Bold
- **Ctrl+I**: Italic
- **Ctrl+U**: Underline
- **F11**: Fullscreen

## 🌍 Internationalization

Editor menggunakan Bahasa Indonesia:
```javascript
language: 'id_ID',
language_url: 'https://cdn.jsdelivr.net/npm/tinymce-lang/langs/id_ID.js'
```

## 📱 Responsive Design

Editor otomatis menyesuaikan dengan ukuran layar:
```javascript
mobile: {
    menubar: true,
    toolbar_mode: 'sliding'
}
```

## 🔒 Security

### XSS Protection
Pastikan untuk sanitize output dari editor:

```php
// Di Controller
use Illuminate\Support\Str;

$validated = $request->validate([
    'content' => 'required|string'
]);

// Simpan dengan strip_tags jika perlu keamanan ekstra
$content = strip_tags($validated['content'], '<p><br><strong><em><ul><ol><li><a><img><h1><h2><h3><h4><h5><h6>');
```

### CSRF Protection
Form harus menyertakan CSRF token:
```blade
<form method="POST">
    @csrf
    <!-- ... -->
</form>
```

## 🐛 Troubleshooting

### Editor tidak muncul
1. Pastikan ada koneksi internet (CDN)
2. Clear browser cache
3. Clear Laravel view cache: `php artisan view:clear`
4. Check browser console untuk error

### Content tidak tersimpan
1. Pastikan form memiliki `@csrf`
2. Check validation rules
3. Pastikan field name sesuai dengan database column

### Styling tidak sesuai
1. Clear cache: `php artisan optimize:clear`
2. Hard refresh browser: Ctrl+Shift+R
3. Check z-index conflicts dengan CSS lain

## 📚 Resources

- **TinyMCE Documentation**: https://www.tiny.cloud/docs/
- **TinyMCE CDN**: https://cdn.tiny.cloud/
- **Language Packs**: https://www.tiny.cloud/get-tiny/language-packages/

## 🎯 Best Practices

1. **Single Responsibility**: Gunakan komponen ini hanya untuk rich text editing
2. **Consistent Naming**: Gunakan naming convention yang konsisten untuk ID
3. **Validation**: Selalu validasi input di backend
4. **Security**: Sanitize HTML output sebelum menampilkan ke user
5. **Performance**: Gunakan lazy loading jika ada banyak editor dalam satu halaman
6. **Accessibility**: Label yang jelas untuk screen readers

## 📝 Changelog

### Version 1.0.0 (2025-11-03)
- Initial release
- TinyMCE 6 integration
- Bahasa Indonesia support
- Full plugin support
- Mobile responsive
- Clean code architecture

---

**Dibuat dengan ❤️ untuk PMD Profile**
**Last Updated**: 2025-11-03
