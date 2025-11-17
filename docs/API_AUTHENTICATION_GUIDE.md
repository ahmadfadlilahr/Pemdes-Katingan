# API Authentication & Admin Guide

## 🔐 Authentication

API ini menggunakan **Laravel Sanctum** dengan Bearer Token authentication untuk routes yang dilindungi.

### Flow Authentication

```
1. Login → Dapatkan Bearer Token
2. Simpan Token 
3. Include Token di Header untuk setiap request ke protected routes
4. Logout → Revoke Token
```

---

## 📝 **Authentication Endpoints**

### 1. Login

Authenticate user dan dapatkan API token.

**Endpoint:** `POST /api/v1/auth/login`

**Request Body:**
```json
{
  "email": "admin@pmdkatingan.go.id",
  "password": "your-password",
  "device_name": "Swagger UI" // optional
}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "token": "1|abcdefghijklmnopqrstuvwxyz123456789",
    "token_type": "Bearer",
    "user": {
      "id": 1,
      "name": "Administrator",
      "email": "admin@pmdkatingan.go.id",
      "role": "super-admin",
      "is_active": true
    }
  }
}
```

**Error Responses:**
- `401` - Invalid credentials
- `403` - Account inactive
- `422` - Validation error

**cURL Example:**
```bash
curl -X POST "http://localhost:8000/api/v1/auth/login" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@pmdkatingan.go.id",
    "password": "password"
  }'
```

---

### 2. Logout

Revoke current API token.

**Endpoint:** `POST /api/v1/auth/logout`

**Headers Required:**
```
Authorization: Bearer YOUR_TOKEN_HERE
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Logout successful",
  "data": null
}
```

**cURL Example:**
```bash
curl -X POST "http://localhost:8000/api/v1/auth/logout" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

### 3. Logout All Devices

Revoke all API tokens for current user.

**Endpoint:** `POST /api/v1/auth/logout-all`

**Headers Required:**
```
Authorization: Bearer YOUR_TOKEN_HERE
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Logged out from all devices",
  "data": null
}
```

---

### 4. Get Current User

Get authenticated user information.

**Endpoint:** `GET /api/v1/auth/me`

**Headers Required:**
```
Authorization: Bearer YOUR_TOKEN_HERE
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "User retrieved successfully",
  "data": {
    "id": 1,
    "name": "Administrator",
    "email": "admin@pmdkatingan.go.id",
    "role": "super-admin",
    "is_active": true,
    "created_at": "2025-01-01T00:00:00+07:00"
  }
}
```

---

### 5. Update Profile

Update current user name and email.

**Endpoint:** `PUT /api/v1/auth/update-profile`

**Headers Required:**
```
Authorization: Bearer YOUR_TOKEN_HERE
Content-Type: application/json
```

**Request Body:**
```json
{
  "name": "Updated Name",
  "email": "newemail@pmdkatingan.go.id"
}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Profile updated successfully",
  "data": {
    "id": 1,
    "name": "Updated Name",
    "email": "newemail@pmdkatingan.go.id",
    "role": "super-admin",
    "is_active": true
  }
}
```

---

### 6. Change Password

Change password for current authenticated user.

**Endpoint:** `PUT /api/v1/auth/change-password`

**Headers Required:**
```
Authorization: Bearer YOUR_TOKEN_HERE
Content-Type: application/json
```

**Request Body:**
```json
{
  "current_password": "old-password",
  "password": "new-password",
  "password_confirmation": "new-password"
}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Password changed successfully. Please login again on other devices.",
  "data": null
}
```

**Note:** Akan revoke semua token kecuali yang sedang digunakan.

---

## 👥 **User Management Endpoints**

**Base Path:** `/api/v1/admin/users`

**Authentication Required:** Yes (Bearer Token)

**Authorization:** Super Admin only (akan ditambahkan middleware)

---

### 1. Get All Users

**Endpoint:** `GET /api/v1/admin/users`

**Query Parameters:**
- `per_page` (optional, default: 15, max: 50) - Items per page
- `page` (optional, default: 1) - Page number
- `search` (optional) - Search in name and email
- `role` (optional) - Filter by role: `super-admin` or `admin`
- `is_active` (optional) - Filter by status: `true` or `false`

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/admin/users?per_page=10&role=admin&is_active=true" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Users retrieved successfully",
  "data": [
    {
      "id": 1,
      "name": "Administrator",
      "email": "admin@pmdkatingan.go.id",
      "role": "super-admin",
      "is_active": true,
      "created_at": "2025-01-01T00:00:00+07:00",
      "updated_at": "2025-01-01T00:00:00+07:00"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 1,
    "per_page": 15,
    "total": 1
  },
  "links": { ... }
}
```

---

### 2. Get User Detail

**Endpoint:** `GET /api/v1/admin/users/{id}`

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/admin/users/1" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "User retrieved successfully",
  "data": {
    "id": 1,
    "name": "Administrator",
    "email": "admin@pmdkatingan.go.id",
    "role": "super-admin",
    "is_active": true,
    "created_at": "2025-01-01T00:00:00+07:00",
    "updated_at": "2025-01-01T00:00:00+07:00"
  }
}
```

---

### 3. Create User

**Endpoint:** `POST /api/v1/admin/users`

**Request Body:**
```json
{
  "name": "New Admin",
  "email": "newadmin@pmdkatingan.go.id",
  "password": "SecurePassword123!",
  "password_confirmation": "SecurePassword123!",
  "role": "admin",
  "is_active": true
}
```

**Validation Rules:**
- `name`: required, string, max 255 characters
- `email`: required, valid email, unique, max 255 characters
- `password`: required, confirmed, min 8 characters (Laravel password rules)
- `role`: required, enum: `super-admin` or `admin`
- `is_active`: optional, boolean, default: true

**Success Response (201):**
```json
{
  "success": true,
  "message": "User created successfully",
  "data": {
    "id": 2,
    "name": "New Admin",
    "email": "newadmin@pmdkatingan.go.id",
    "role": "admin",
    "is_active": true,
    "created_at": "2025-01-13T10:00:00+07:00"
  }
}
```

---

### 4. Update User

**Endpoint:** `PUT /api/v1/admin/users/{id}`

**Request Body (all fields optional):**
```json
{
  "name": "Updated Name",
  "email": "updated@pmdkatingan.go.id",
  "role": "admin",
  "is_active": false
}
```

**Business Rules:**
- Cannot change own role
- Cannot deactivate own account

**Success Response (200):**
```json
{
  "success": true,
  "message": "User updated successfully",
  "data": {
    "id": 2,
    "name": "Updated Name",
    "email": "updated@pmdkatingan.go.id",
    "role": "admin",
    "is_active": false,
    "updated_at": "2025-01-13T10:30:00+07:00"
  }
}
```

---

### 5. Delete User

**Endpoint:** `DELETE /api/v1/admin/users/{id}`

**Business Rules:**
- Cannot delete own account
- Will revoke all tokens before deletion

**Success Response (200):**
```json
{
  "success": true,
  "message": "User deleted successfully",
  "data": null
}
```

**cURL Example:**
```bash
curl -X DELETE "http://localhost:8000/api/v1/admin/users/2" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

### 6. Reset User Password

**Endpoint:** `PUT /api/v1/admin/users/{id}/reset-password`

**Request Body:**
```json
{
  "password": "NewSecurePassword123!",
  "password_confirmation": "NewSecurePassword123!"
}
```

**Note:** Will revoke all tokens for that user (force re-login).

**Success Response (200):**
```json
{
  "success": true,
  "message": "Password reset successfully. User must login again.",
  "data": null
}
```

---

### 7. Toggle User Status

**Endpoint:** `POST /api/v1/admin/users/{id}/toggle-status`

**Description:** Activate or deactivate user account.

**Business Rules:**
- Cannot toggle own status
- Will revoke all tokens if deactivated

**Success Response (200):**
```json
{
  "success": true,
  "message": "User activated successfully",
  "data": {
    "id": 2,
    "name": "Admin User",
    "is_active": true
  }
}
```

---

## 🔒 **How to Use Bearer Token in Swagger UI**

### Step 1: Login
1. Expand `POST /api/v1/auth/login` endpoint
2. Click **"Try it out"**
3. Enter email dan password
4. Click **"Execute"**
5. Copy `token` value dari response

### Step 2: Authorize
1. Click tombol **"Authorize"** 🔓 di bagian atas Swagger UI
2. Paste token yang di-copy tadi
3. Click **"Authorize"**
4. Click **"Close"**

### Step 3: Access Protected Routes
Sekarang semua protected routes bisa diakses dengan token tersebut.

---

## 🧪 **Testing with cURL**

### Full Flow Example

```bash
# 1. Login dan simpan token
TOKEN=$(curl -s -X POST "http://localhost:8000/api/v1/auth/login" \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@pmdkatingan.go.id","password":"password"}' \
  | jq -r '.data.token')

echo "Token: $TOKEN"

# 2. Get current user
curl -X GET "http://localhost:8000/api/v1/auth/me" \
  -H "Authorization: Bearer $TOKEN"

# 3. Get all users
curl -X GET "http://localhost:8000/api/v1/admin/users" \
  -H "Authorization: Bearer $TOKEN"

# 4. Create new user
curl -X POST "http://localhost:8000/api/v1/admin/users" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test Admin",
    "email": "test@pmdkatingan.go.id",
    "password": "Password123!",
    "password_confirmation": "Password123!",
    "role": "admin"
  }'

# 5. Logout
curl -X POST "http://localhost:8000/api/v1/auth/logout" \
  -H "Authorization: Bearer $TOKEN"
```

---

## ⚠️ **Error Responses**

### 401 Unauthorized
```json
{
  "message": "Unauthenticated."
}
```

**Causes:**
- No token provided
- Invalid token
- Expired token
- Token revoked

**Solution:** Login again to get new token.

---

### 403 Forbidden
```json
{
  "success": false,
  "message": "You cannot change your own role"
}
```

**Causes:**
- Insufficient permissions
- Business rule violation (e.g., self-edit restriction)

---

### 422 Validation Error
```json
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "email": ["The email has already been taken."],
    "password": ["The password must be at least 8 characters."]
  }
}
```

---

## 🔐 **Security Best Practices**

### Token Management
- ✅ Store token securely (never in localStorage for sensitive apps)
- ✅ Use HTTPS in production
- ✅ Set appropriate token expiration
- ✅ Revoke tokens on logout
- ✅ Implement token refresh if needed

### Password Policy
Current Laravel password rules:
- Minimum 8 characters
- Can be customized in `config/auth.php`

### Rate Limiting
- API protected dengan rate limit: **60 requests/minute**
- Berlaku untuk semua endpoints

---

## 📋 **Role-Based Access**

### Roles Available:
1. **super-admin** - Full access to all features
2. **admin** - Limited access (cannot manage users)

### Future Enhancement:
Add middleware untuk check permissions per endpoint:
```php
Route::middleware(['auth:sanctum', 'super-admin'])->group(function () {
    // Super Admin only routes
});
```

---

## 🎯 **Next Steps (TODO)**

Tambahkan CRUD API untuk:
- [ ] News Management (create, update, delete)
- [ ] Agenda Management (create, update, delete)
- [ ] Gallery Management (create, update, delete)
- [ ] Documents Management (create, update, delete)
- [ ] Organization Management (create, update, delete)
- [ ] Contact Management (update)
- [ ] Vision-Mission Management (update)
- [ ] Welcome Message Management (update)

---

## 📞 **Support**

For authentication issues:
- Check token validity
- Verify user is active
- Check role permissions
- Review Laravel logs: `storage/logs/laravel.log`
