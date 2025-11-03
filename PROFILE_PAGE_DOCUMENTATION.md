# 📄 Profile Page Documentation

## Overview
Halaman profile admin yang telah didesain ulang dengan tampilan **minimalist**, **modern**, dan **profesional** menggunakan sistem component-based architecture untuk clean code dan maintainability.

---

## 🎨 Design Principles

### 1. **Minimalist Design**
- Clean white cards dengan subtle shadows
- Spacing yang konsisten dan tidak berlebihan
- Typography yang jelas dan mudah dibaca
- Fokus pada konten, bukan dekorasi

### 2. **Modern UI/UX**
- Gradient backgrounds pada card headers
- Smooth transitions dan hover effects
- Icon-based visual hierarchy
- Responsive di semua perangkat (mobile, tablet, desktop)

### 3. **Professional Look**
- Color scheme yang konsisten dengan tema admin panel
- Proper use of blue untuk primary actions
- Red untuk danger actions (delete account)
- Amber/Yellow untuk warnings

### 4. **Clean Code Architecture**
- Component-based structure
- Reusable components
- Separation of concerns
- Easy to maintain dan extend

---

## 📂 File Structure

```
resources/views/
├── profile/
│   └── edit.blade.php                    # Main profile page
└── components/
    └── admin/
        └── profile/
            ├── information-card.blade.php     # Profile info section
            ├── password-card.blade.php        # Change password section
            └── delete-account-card.blade.php  # Delete account section
```

---

## 🧩 Components

### 1. **Information Card** (`information-card.blade.php`)

**Purpose:** Mengelola informasi profile user (name & email)

**Features:**
- ✅ Update nama dan email
- ✅ Email verification alert (jika belum terverifikasi)
- ✅ Form validation dengan error messages
- ✅ Success notification setelah update
- ✅ Icon di setiap input field
- ✅ Responsive layout

**Props:**
```blade
@props(['user'])
```

**Usage:**
```blade
<x-admin.profile.information-card :user="$user" />
```

**Visual Elements:**
- Blue gradient header dengan user icon
- Input fields dengan left-side icons (user, email)
- Border yang berubah red saat ada error
- Success message dengan green color dan checkmark icon
- "Save Changes" button dengan blue background

---

### 2. **Password Card** (`password-card.blade.php`)

**Purpose:** Mengubah password akun

**Features:**
- ✅ Current password field
- ✅ New password field
- ✅ Confirm password field
- ✅ Show/hide password toggle untuk semua fields
- ✅ Password strength hint (min 8 characters)
- ✅ Form validation
- ✅ Success notification
- ✅ Separate error bag (`updatePassword`)

**Props:** None (stateless component)

**Usage:**
```blade
<x-admin.profile.password-card />
```

**Visual Elements:**
- Blue gradient header dengan lock icon
- Password fields dengan toggle visibility button
- Eye/Eye-off icons untuk show/hide
- Info hint dengan small info icon
- Success message dengan green color

**Security:**
- Password disembunyikan secara default
- Toggle visibility per-field (independent)
- Autocomplete attributes untuk password managers
- CSRF protection

---

### 3. **Delete Account Card** (`delete-account-card.blade.php`)

**Purpose:** Menghapus akun user secara permanen

**Features:**
- ✅ Warning notice dengan red color scheme
- ✅ Confirmation modal
- ✅ Password confirmation sebelum delete
- ✅ Show/hide password di modal
- ✅ Cancel dan Delete buttons
- ✅ Separate error bag (`userDeletion`)

**Props:** None (stateless component)

**Usage:**
```blade
<x-admin.profile.delete-account-card />
```

**Visual Elements:**
- **Card Header:** Red gradient dengan warning icon
- **Warning Box:** Red background dengan alert message
- **Delete Button:** Red button dengan trash icon
- **Modal:**
  - Warning icon di header
  - Red background alert box
  - Password field dengan toggle
  - Cancel (gray) dan Delete (red) buttons

**Safety Features:**
- Requires password confirmation
- Clear warning messages
- Two-step process (button → modal → confirm)
- Cannot be undone warning

---

## 🎯 Main Page (`edit.blade.php`)

**Layout:**
```blade
@extends('layouts.admin.app')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">
        <x-admin.profile.information-card :user="$user" />
        <x-admin.profile.password-card />
        <x-admin.profile.delete-account-card />
    </div>
@endsection
```

**Features:**
- Max-width container (5xl) untuk optimal reading width
- Vertical spacing (space-y-6) antar cards
- Centered layout dengan mx-auto
- Clean section header dengan title dan description

---

## 🎨 UI/UX Details

### Color Scheme
| Element | Color | Usage |
|---------|-------|-------|
| Primary Action | Blue (600/700) | Save buttons, links |
| Danger Action | Red (600/700) | Delete account |
| Warning | Amber (600/700) | Email verification alert |
| Success | Green (600) | Success messages |
| Neutral | Gray (300/600/900) | Text, borders, backgrounds |

### Typography
- **Headers (h2/h3):** font-semibold, text-lg to 2xl
- **Body Text:** text-sm to base, text-gray-600
- **Labels:** text-sm, font-medium, text-gray-700
- **Errors:** text-sm, text-red-600
- **Success:** text-sm, text-green-600

### Spacing
- **Card Padding:** px-6 py-5/6
- **Form Fields:** space-y-6
- **Input Padding:** py-3 px-3
- **Button Padding:** px-6 py-3
- **Container Gap:** space-y-6

### Shadows & Borders
- **Card Shadow:** shadow-sm
- **Card Border:** border border-gray-100
- **Rounded Corners:** rounded-xl (cards), rounded-lg (inputs/buttons)

### Icons
- **Size:** w-4 h-4 (inline), w-5 h-5 (input icons), w-6 h-6 (card headers)
- **Source:** Heroicons (outline style)
- **Placement:** Left side for inputs, left side for buttons

### Transitions
- **Duration:** duration-200
- **Properties:** colors, transform
- **Hover Effects:** scale-[1.02] for buttons

---

## 📱 Responsive Design

### Breakpoints
- **Mobile (default):** Full width, stacked layout
- **Tablet (sm):** Increased padding
- **Desktop (lg+):** Max-width container centered

### Responsive Features
- Input fields: Full width di semua breakpoints
- Cards: Full width dengan max-width container
- Buttons: Full width di mobile (jika diperlukan)
- Modal: Responsive padding dan width

---

## 🔒 Security Features

1. **CSRF Protection:** Semua forms menggunakan @csrf
2. **Method Spoofing:** @method('patch'), @method('put'), @method('delete')
3. **Password Confirmation:** Required untuk delete account
4. **Separate Error Bags:**
   - `updatePassword` untuk password updates
   - `userDeletion` untuk account deletion
5. **Autocomplete Attributes:** Proper autocomplete untuk password fields

---

## ✅ Form Validation

### Profile Information
- **Name:** Required
- **Email:** Required, valid email format
- Tampilan error: Red border + error message di bawah field

### Update Password
- **Current Password:** Required untuk verifikasi
- **New Password:** Required, minimum 8 characters
- **Confirm Password:** Required, must match new password
- Error bag: `updatePassword`

### Delete Account
- **Password:** Required untuk konfirmasi
- Error bag: `userDeletion`

---

## 🎭 Interactive Features

### 1. **Password Toggle**
```blade
<div x-data="{ showPassword: false }">
    <input :type="showPassword ? 'text' : 'password'">
    <button @click="showPassword = !showPassword">
        <svg x-show="!showPassword">Eye Icon</svg>
        <svg x-show="showPassword">Eye-off Icon</svg>
    </button>
</div>
```

### 2. **Auto-hide Success Messages**
```blade
<p x-data="{ show: true }"
   x-show="show"
   x-transition
   x-init="setTimeout(() => show = false, 3000)">
   Success message
</p>
```

### 3. **Modal System**
```blade
<button x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
    Delete Account
</button>

<x-modal name="confirm-user-deletion">
    <!-- Modal content -->
</x-modal>
```

---

## 🚀 Best Practices Implemented

### 1. **Component-Based Architecture**
- Reusable components
- Single responsibility principle
- Easy to test dan maintain

### 2. **Consistent Styling**
- Shared color scheme
- Consistent spacing
- Uniform border radius dan shadows

### 3. **Accessibility**
- Proper labels untuk screen readers
- Keyboard navigation support
- Focus states untuk interactive elements
- Aria labels untuk dynamic content

### 4. **User Experience**
- Clear visual feedback (errors, success)
- Loading states (jika diperlukan)
- Confirmation dialogs untuk destructive actions
- Helpful hints dan descriptions

### 5. **Performance**
- Minimal JavaScript (hanya Alpine.js untuk interactivity)
- CSS transitions (hardware accelerated)
- No unnecessary re-renders

---

## 🔄 Routes

```php
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware('auth')
    ->name('verification.send');

Route::put('/password', [PasswordController::class, 'update'])
    ->middleware('auth')
    ->name('password.update');
```

---

## 📊 Session Messages

### Profile Updated
```php
session('status') === 'profile-updated'
```

### Password Updated
```php
session('status') === 'password-updated'
```

### Verification Link Sent
```php
session('status') === 'verification-link-sent'
```

---

## 🎓 Usage Examples

### 1. Accessing Profile Page
```
URL: /profile
Route Name: profile.edit
Middleware: auth
```

### 2. Updating Profile
```http
PATCH /profile
Data: { name, email }
Redirect: back dengan success message
```

### 3. Changing Password
```http
PUT /password
Data: { current_password, password, password_confirmation }
Error Bag: updatePassword
Redirect: back dengan success message
```

### 4. Deleting Account
```http
DELETE /profile
Data: { password }
Error Bag: userDeletion
Redirect: / (homepage atau login)
```

---

## 🛠️ Maintenance & Customization

### Menambah Field Baru di Profile Info
1. Tambahkan input field di `information-card.blade.php`
2. Update validation di `ProfileController`
3. Update database migration jika perlu

### Mengubah Color Scheme
Cari dan replace warna di components:
- Blue → Your primary color
- Red → Your danger color
- Gray → Your neutral color

### Menambah Section Baru
1. Buat component baru di `components/admin/profile/`
2. Include di `edit.blade.php`
3. Update routes dan controller jika perlu

---

## ✨ Future Enhancements

Potential improvements:
- [ ] Profile photo upload
- [ ] Two-factor authentication
- [ ] Activity log
- [ ] Account preferences/settings
- [ ] Dark mode toggle
- [ ] Language preferences
- [ ] Timezone settings

---

## 📝 Notes

- Semua components menggunakan Alpine.js untuk interactivity
- TailwindCSS untuk styling (no custom CSS)
- Laravel Breeze sebagai base authentication
- Compatible dengan Laravel 11.x
- Responsive dan mobile-friendly
- Accessible (WCAG compliant)

---

**Last Updated:** November 3, 2025
**Version:** 1.0.0
**Author:** Admin Panel Development Team
