# Roles and Permissions Guide

## Roles Overview

The system has three main administrative roles:

### 1. Super Admin 👑
**Slug:** `super-admin`  
**Email:** `superadmin@sirisaacnewton.edu`  
**Password:** `password` (change immediately!)

**Permissions:**
- ✅ **ALL PERMISSIONS** - Full system access
- Can view financial discounts and base prices
- Can manage users and roles
- Can edit school information
- Can access all reports and analytics
- Can configure system settings

**Use Case:** System owner, IT administrator, or principal with full oversight

---

### 2. Admin 👨‍💼
**Slug:** `admin`  
**Email:** `admin@sirisaacnewton.edu`  
**Password:** `password` (change immediately!)

**Permissions:**
- ✅ Student management (create, edit, delete)
- ✅ Parent management
- ✅ Teacher management
- ✅ Class & subject management
- ✅ Timetable management
- ✅ Attendance management
- ✅ Exams & results management
- ✅ Transportation management
- ✅ Extracurricular activities
- ✅ Announcements
- ✅ Notifications
- ✅ School information (view only)
- ✅ Billing operations (process payments, view payments)
- ✅ Receipts (generate, view, print)
- ✅ Expenses management
- ✅ Reports (view, transport reports)
- ✅ Users (view only)
- ❌ **CANNOT** view financial discounts
- ❌ **CANNOT** manage roles
- ❌ **CANNOT** edit school information
- ❌ **CANNOT** access financial analytics

**Use Case:** School administrator, academic coordinator, or operations manager

---

### 3. Cashier 💰
**Slug:** `cashier`  
**Email:** `cashier@sirisaacnewton.edu`  
**Password:** `password` (change immediately!)

**Permissions:**
- ✅ View students
- ✅ View courses
- ✅ Process payments
- ✅ View payments
- ✅ Generate receipts
- ✅ View receipts
- ✅ Print receipts
- ✅ View expenses
- ✅ Create expenses
- ✅ Edit expenses
- ❌ **CANNOT** view course base prices
- ❌ **CANNOT** view discounts
- ❌ **CANNOT** view financial reports
- ❌ **CANNOT** manage students
- ❌ **CANNOT** access academic features

**Use Case:** Front desk staff, billing clerk, or payment processor

---

## Permission Structure

### Module-Based Permissions

Permissions are organized by modules:

1. **Students** - `students.*`
2. **Parents** - `parents.*`
3. **Courses** - `courses.*`
4. **Classes** - `classes.*`
5. **Subjects** - `subjects.*`
6. **Timetables** - `timetables.*`
7. **Attendance** - `attendance.*`
8. **Exams & Results** - `exams.*`, `results.*`
9. **Teachers** - `teachers.*`
10. **Transportation** - `vehicles.*`, `drivers.*`, `routes.*`, `transport.*`
11. **Extracurricular** - `clubs.*`
12. **Announcements** - `announcements.*`
13. **Notifications** - `notifications.*`
14. **School Information** - `school.*`
15. **Billing** - `billing.*`
16. **Receipts** - `receipts.*`
17. **Expenses** - `expenses.*`
18. **Reports** - `reports.*`
19. **Users & Roles** - `users.*`, `roles.*`

### Permission Actions

Each permission follows the pattern: `module.action`

Common actions:
- `view` - Read-only access
- `create` - Create new records
- `edit` - Modify existing records
- `delete` - Remove records
- `manage` - Full management access

---

## Running the Seeder

To create roles and assign permissions:

```bash
php artisan db:seed --class=RolePermissionSeeder
```

Or run all seeders:

```bash
php artisan db:seed
```

---

## Default Users Created

After seeding, you can login with:

| Role | Email | Password | Access Level |
|------|-------|----------|-------------|
| Super Admin | `superadmin@sirisaacnewton.edu` | `password` | Full Access |
| Admin | `admin@sirisaacnewton.edu` | `password` | Administrative |
| Cashier | `cashier@sirisaacnewton.edu` | `password` | Billing Only |

**⚠️ IMPORTANT:** Change all default passwords immediately in production!

---

## Permission Checking

### In Controllers

```php
// Check if user has permission
if ($request->user()->hasPermission('students.create')) {
    // Allow student creation
}

// Check if user has role
if ($request->user()->hasRole('admin')) {
    // Admin-specific logic
}
```

### In Blade Templates

```blade
@if(auth()->user()->hasPermission('students.create'))
    <a href="{{ route('students.create') }}">Add Student</a>
@endif
```

### In Middleware

```php
Route::middleware('permission:students.create')->group(function () {
    Route::post('/students', [StudentController::class, 'store']);
});
```

---

## Adding New Permissions

To add a new permission:

1. Add it to the `$permissions` array in `RolePermissionSeeder.php`
2. Assign it to appropriate roles
3. Run the seeder: `php artisan db:seed --class=RolePermissionSeeder`

Example:
```php
['name' => 'Export Data', 'slug' => 'data.export', 'module' => 'data', 'action' => 'export'],
```

---

## Role Hierarchy

```
Super Admin (All Permissions)
    ↓
Admin (Most Permissions, No Financial Discounts)
    ↓
Cashier (Billing Only)
```

---

## Security Notes

1. **Super Admin** should be limited to 1-2 trusted users
2. **Admin** role is suitable for day-to-day operations
3. **Cashier** role ensures financial data privacy
4. Always use permission checks, not just role checks
5. Audit logs track all permission-based actions

---

## Customizing Permissions

You can customize permissions for each role by editing `RolePermissionSeeder.php`:

```php
// Add permission to Admin role
$adminPermissions = Permission::whereIn('slug', [
    // ... existing permissions
    'new.permission', // Add new permission
])->pluck('id');
```

Then run the seeder again to update permissions.

---

**Last Updated:** Role and permission system configured for Sir Isaac Newton School

