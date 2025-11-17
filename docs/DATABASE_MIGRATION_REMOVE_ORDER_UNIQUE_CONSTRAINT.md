# Database Migration - Remove Unique Constraint from Order Column

## 📋 Problem
**Error:** `SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '2' for key 'organization_structures.organization_structures_order_unique'`

**Root Cause:** Database table `organization_structures` memiliki UNIQUE constraint pada kolom `order`, yang mencegah duplicate order numbers.

**Impact:** Admin tidak bisa membuat hierarki horizontal (pegawai dengan order yang sama).

## 🔧 Solution

### Migration Created
File: `2025_11_13_022452_remove_unique_constraint_from_organization_structures_order.php`

```php
public function up(): void
{
    Schema::table('organization_structures', function (Blueprint $table) {
        // Drop the unique index on 'order' column
        $table->dropUnique('organization_structures_order_unique');
    });
}
```

### What It Does
- ✅ Removes UNIQUE constraint from `order` column
- ✅ Allows multiple records with the same order number
- ✅ Enables horizontal hierarchy (urutan sama = sejajar)

### Before Migration
```sql
CREATE TABLE `organization_structures` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `position` varchar(255) NOT NULL,
  `order` int NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `organization_structures_nip_unique` (`nip`),
  UNIQUE KEY `organization_structures_order_unique` (`order`)  ← This prevents duplicates!
);
```

### After Migration
```sql
CREATE TABLE `organization_structures` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `position` varchar(255) NOT NULL,
  `order` int NOT NULL,                                       ← No unique constraint!
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `organization_structures_nip_unique` (`nip`)     ← NIP still unique (correct)
);
```

## ✅ Verification

### Test Insert with Duplicate Order
```sql
-- This now works! ✅
INSERT INTO organization_structures (name, nip, position, `order`, is_active) 
VALUES 
  ('Kabid A', '123456789', 'Kepala Bidang A', 3, 1),
  ('Kabid B', '987654321', 'Kepala Bidang B', 3, 1),  ← Same order (3)
  ('Kabid C', '111222333', 'Kepala Bidang C', 3, 1);  ← Same order (3)
```

### Before: Error
```
ERROR 1062 (23000): Duplicate entry '3' for key 'organization_structures_order_unique'
```

### After: Success
```
Query OK, 3 rows affected
```

## 🎯 Impact

### Database Level
- ✅ Order column no longer has unique constraint
- ✅ Multiple records can have same order value
- ✅ NIP still has unique constraint (correct - each person unique)

### Application Level
- ✅ Admin can input same order numbers
- ✅ No more "Integrity constraint violation" error
- ✅ Horizontal hierarchy working correctly

### Frontend Display
- ✅ Records with same order displayed horizontally
- ✅ Hierarchical structure properly rendered
- ✅ Connecting lines between different levels

## 🚀 Deployment Commands

```bash
# Run migration
php artisan migrate

# Verify migration status
php artisan migrate:status

# Check database structure
php artisan tinker
>>> Schema::getColumnListing('organization_structures')
>>> DB::select('SHOW INDEX FROM organization_structures')

# Clear caches
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

## 🔄 Rollback (If Needed)

If you need to restore unique constraint (not recommended):

```bash
php artisan migrate:rollback --step=1
```

This will re-add the unique constraint, but you'll lose the ability to have duplicate orders.

## 📊 Testing Checklist

### Database
- [x] Migration ran successfully
- [x] Unique constraint removed from `order` column
- [x] NIP unique constraint still exists
- [x] Can insert multiple records with same order

### Admin Panel
- [x] Can save record with duplicate order
- [x] No "Integrity constraint violation" error
- [x] Form validation working correctly
- [x] Success message displayed

### Frontend
- [x] Records with same order displayed horizontally
- [x] Different orders create new rows
- [x] Connecting lines between levels
- [x] Responsive grid working

## 📚 Related Files

### Modified Files
1. **Migration:** `database/migrations/2025_11_13_022452_remove_unique_constraint_from_organization_structures_order.php`
2. **Model:** `app/Models/OrganizationStructure.php` (already allows duplicates in code)
3. **Controller:** `app/Http/Controllers/Admin/OrganizationStructureController.php` (no adjustment logic)

### Original Migration
- **File:** `database/migrations/2025_10_08_074630_create_organization_structures_table.php`
- **Line 16:** `$table->integer('order')->unique();` ← This was the problem

### Documentation
- [ORGANIZATION_HIERARCHY_DUPLICATE_ORDER_FIX.md](./ORGANIZATION_HIERARCHY_DUPLICATE_ORDER_FIX.md)
- [README.md](../README.md)

---

**Date Created:** November 13, 2025  
**Migration Ran:** November 13, 2025 02:24:52  
**Status:** ✅ Successful  
**Impact:** Critical Fix - Enables core feature (horizontal hierarchy)
