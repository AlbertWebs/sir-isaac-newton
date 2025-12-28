<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        $superAdmin = Role::firstOrCreate(
            ['slug' => 'super-admin'],
            [
                'name' => 'Super Admin',
                'description' => 'Full system access with all permissions including financial data and system configuration',
            ]
        );

        $admin = Role::firstOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Admin',
                'description' => 'Administrative access to manage students, teachers, classes, and academic operations',
            ]
        );

        $cashier = Role::firstOrCreate(
            ['slug' => 'cashier'],
            [
                'name' => 'Cashier',
                'description' => 'Can process payments and generate receipts without viewing base prices or discounts',
            ]
        );

        $teacher = Role::firstOrCreate(
            ['slug' => 'teacher'],
            [
                'name' => 'Teacher',
                'description' => 'Can manage classes, attendance, and results',
            ]
        );

        $parent = Role::firstOrCreate(
            ['slug' => 'parent'],
            [
                'name' => 'Parent',
                'description' => 'Can view child information and receive notifications',
            ]
        );

        $student = Role::firstOrCreate(
            ['slug' => 'student'],
            [
                'name' => 'Student',
                'description' => 'Read-only access to own information',
            ]
        );

        $transportDriver = Role::firstOrCreate(
            ['slug' => 'transport-driver'],
            [
                'name' => 'Transport Driver',
                'description' => 'Can view assigned routes and mark pickup/drop-off status',
            ]
        );

        $transportManager = Role::firstOrCreate(
            ['slug' => 'transport-manager'],
            [
                'name' => 'Transport Manager',
                'description' => 'Can manage routes, vehicles, drivers, and transport operations',
            ]
        );

        $website = Role::firstOrCreate(
            ['slug' => 'website'],
            [
                'name' => 'Website',
                'description' => 'Public API access for website content',
            ]
        );

        // Create Permissions
        $permissions = [
            // Students
            ['name' => 'View Students', 'slug' => 'students.view', 'module' => 'students', 'action' => 'view'],
            ['name' => 'Create Students', 'slug' => 'students.create', 'module' => 'students', 'action' => 'create'],
            ['name' => 'Edit Students', 'slug' => 'students.edit', 'module' => 'students', 'action' => 'edit'],
            ['name' => 'Delete Students', 'slug' => 'students.delete', 'module' => 'students', 'action' => 'delete'],
            ['name' => 'View Own Student', 'slug' => 'students.view_own', 'module' => 'students', 'action' => 'view_own'],

            // Parents
            ['name' => 'View Parents', 'slug' => 'parents.view', 'module' => 'parents', 'action' => 'view'],
            ['name' => 'Create Parents', 'slug' => 'parents.create', 'module' => 'parents', 'action' => 'create'],
            ['name' => 'Edit Parents', 'slug' => 'parents.edit', 'module' => 'parents', 'action' => 'edit'],
            ['name' => 'Delete Parents', 'slug' => 'parents.delete', 'module' => 'parents', 'action' => 'delete'],
            ['name' => 'View Own Children', 'slug' => 'parents.view_children', 'module' => 'parents', 'action' => 'view_children'],

            // Courses
            ['name' => 'View Courses', 'slug' => 'courses.view', 'module' => 'courses', 'action' => 'view'],
            ['name' => 'Create Courses', 'slug' => 'courses.create', 'module' => 'courses', 'action' => 'create'],
            ['name' => 'Edit Courses', 'slug' => 'courses.edit', 'module' => 'courses', 'action' => 'edit'],
            ['name' => 'Delete Courses', 'slug' => 'courses.delete', 'module' => 'courses', 'action' => 'delete'],
            ['name' => 'View Course Prices', 'slug' => 'courses.view_prices', 'module' => 'courses', 'action' => 'view_prices'],

            // Classes & Grades
            ['name' => 'View Classes', 'slug' => 'classes.view', 'module' => 'classes', 'action' => 'view'],
            ['name' => 'Create Classes', 'slug' => 'classes.create', 'module' => 'classes', 'action' => 'create'],
            ['name' => 'Edit Classes', 'slug' => 'classes.edit', 'module' => 'classes', 'action' => 'edit'],
            ['name' => 'Delete Classes', 'slug' => 'classes.delete', 'module' => 'classes', 'action' => 'delete'],
            ['name' => 'Manage Class Students', 'slug' => 'classes.manage_students', 'module' => 'classes', 'action' => 'manage_students'],

            // Subjects
            ['name' => 'View Subjects', 'slug' => 'subjects.view', 'module' => 'subjects', 'action' => 'view'],
            ['name' => 'Create Subjects', 'slug' => 'subjects.create', 'module' => 'subjects', 'action' => 'create'],
            ['name' => 'Edit Subjects', 'slug' => 'subjects.edit', 'module' => 'subjects', 'action' => 'edit'],
            ['name' => 'Delete Subjects', 'slug' => 'subjects.delete', 'module' => 'subjects', 'action' => 'delete'],

            // Timetables
            ['name' => 'View Timetables', 'slug' => 'timetables.view', 'module' => 'timetables', 'action' => 'view'],
            ['name' => 'Create Timetables', 'slug' => 'timetables.create', 'module' => 'timetables', 'action' => 'create'],
            ['name' => 'Edit Timetables', 'slug' => 'timetables.edit', 'module' => 'timetables', 'action' => 'edit'],
            ['name' => 'Delete Timetables', 'slug' => 'timetables.delete', 'module' => 'timetables', 'action' => 'delete'],

            // Attendance
            ['name' => 'View Attendance', 'slug' => 'attendance.view', 'module' => 'attendance', 'action' => 'view'],
            ['name' => 'Mark Attendance', 'slug' => 'attendance.mark', 'module' => 'attendance', 'action' => 'mark'],
            ['name' => 'Edit Attendance', 'slug' => 'attendance.edit', 'module' => 'attendance', 'action' => 'edit'],
            ['name' => 'View Own Attendance', 'slug' => 'attendance.view_own', 'module' => 'attendance', 'action' => 'view_own'],

            // Exams & Results
            ['name' => 'View Exams', 'slug' => 'exams.view', 'module' => 'exams', 'action' => 'view'],
            ['name' => 'Create Exams', 'slug' => 'exams.create', 'module' => 'exams', 'action' => 'create'],
            ['name' => 'Edit Exams', 'slug' => 'exams.edit', 'module' => 'exams', 'action' => 'edit'],
            ['name' => 'Delete Exams', 'slug' => 'exams.delete', 'module' => 'exams', 'action' => 'delete'],
            ['name' => 'View Results', 'slug' => 'results.view', 'module' => 'results', 'action' => 'view'],
            ['name' => 'Create Results', 'slug' => 'results.create', 'module' => 'results', 'action' => 'create'],
            ['name' => 'Edit Results', 'slug' => 'results.edit', 'module' => 'results', 'action' => 'edit'],
            ['name' => 'View Own Results', 'slug' => 'results.view_own', 'module' => 'results', 'action' => 'view_own'],

            // Teachers
            ['name' => 'View Teachers', 'slug' => 'teachers.view', 'module' => 'teachers', 'action' => 'view'],
            ['name' => 'Create Teachers', 'slug' => 'teachers.create', 'module' => 'teachers', 'action' => 'create'],
            ['name' => 'Edit Teachers', 'slug' => 'teachers.edit', 'module' => 'teachers', 'action' => 'edit'],
            ['name' => 'Delete Teachers', 'slug' => 'teachers.delete', 'module' => 'teachers', 'action' => 'delete'],

            // Transportation
            ['name' => 'View Transport', 'slug' => 'transport.view', 'module' => 'transport', 'action' => 'view'],
            ['name' => 'Create Transport', 'slug' => 'transport.create', 'module' => 'transport', 'action' => 'create'],
            ['name' => 'Edit Transport', 'slug' => 'transport.edit', 'module' => 'transport', 'action' => 'edit'],
            ['name' => 'Delete Transport', 'slug' => 'transport.delete', 'module' => 'transport', 'action' => 'delete'],
            ['name' => 'View Vehicles', 'slug' => 'vehicles.view', 'module' => 'transport', 'action' => 'view'],
            ['name' => 'Create Vehicles', 'slug' => 'vehicles.create', 'module' => 'transport', 'action' => 'create'],
            ['name' => 'Edit Vehicles', 'slug' => 'vehicles.edit', 'module' => 'transport', 'action' => 'edit'],
            ['name' => 'Delete Vehicles', 'slug' => 'vehicles.delete', 'module' => 'transport', 'action' => 'delete'],
            ['name' => 'View Drivers', 'slug' => 'drivers.view', 'module' => 'transport', 'action' => 'view'],
            ['name' => 'Create Drivers', 'slug' => 'drivers.create', 'module' => 'transport', 'action' => 'create'],
            ['name' => 'Edit Drivers', 'slug' => 'drivers.edit', 'module' => 'transport', 'action' => 'edit'],
            ['name' => 'Delete Drivers', 'slug' => 'drivers.delete', 'module' => 'transport', 'action' => 'delete'],
            ['name' => 'View Routes', 'slug' => 'routes.view', 'module' => 'transport', 'action' => 'view'],
            ['name' => 'Create Routes', 'slug' => 'routes.create', 'module' => 'transport', 'action' => 'create'],
            ['name' => 'Edit Routes', 'slug' => 'routes.edit', 'module' => 'transport', 'action' => 'edit'],
            ['name' => 'Delete Routes', 'slug' => 'routes.delete', 'module' => 'transport', 'action' => 'delete'],
            ['name' => 'Assign Students to Routes', 'slug' => 'routes.assign_students', 'module' => 'transport', 'action' => 'assign_students'],
            ['name' => 'View Assigned Route', 'slug' => 'routes.view_assigned', 'module' => 'transport', 'action' => 'view_assigned'],
            ['name' => 'Mark Pickup Status', 'slug' => 'routes.mark_pickup', 'module' => 'transport', 'action' => 'mark_pickup'],
            ['name' => 'View Transport Status', 'slug' => 'transport.view_status', 'module' => 'transport', 'action' => 'view_status'],

            // Extracurricular Activities
            ['name' => 'View Clubs', 'slug' => 'clubs.view', 'module' => 'extracurricular', 'action' => 'view'],
            ['name' => 'Create Clubs', 'slug' => 'clubs.create', 'module' => 'extracurricular', 'action' => 'create'],
            ['name' => 'Edit Clubs', 'slug' => 'clubs.edit', 'module' => 'extracurricular', 'action' => 'edit'],
            ['name' => 'Delete Clubs', 'slug' => 'clubs.delete', 'module' => 'extracurricular', 'action' => 'delete'],
            ['name' => 'Manage Club Members', 'slug' => 'clubs.manage_members', 'module' => 'extracurricular', 'action' => 'manage_members'],

            // Announcements
            ['name' => 'View Announcements', 'slug' => 'announcements.view', 'module' => 'announcements', 'action' => 'view'],
            ['name' => 'Create Announcements', 'slug' => 'announcements.create', 'module' => 'announcements', 'action' => 'create'],
            ['name' => 'Edit Announcements', 'slug' => 'announcements.edit', 'module' => 'announcements', 'action' => 'edit'],
            ['name' => 'Delete Announcements', 'slug' => 'announcements.delete', 'module' => 'announcements', 'action' => 'delete'],
            ['name' => 'Create Class Announcements', 'slug' => 'announcements.create_class', 'module' => 'announcements', 'action' => 'create_class'],

            // Notifications
            ['name' => 'View Notifications', 'slug' => 'notifications.view', 'module' => 'notifications', 'action' => 'view'],
            ['name' => 'Send Notifications', 'slug' => 'notifications.send', 'module' => 'notifications', 'action' => 'send'],

            // School Information
            ['name' => 'View School Info', 'slug' => 'school.view', 'module' => 'school', 'action' => 'view'],
            ['name' => 'Edit School Info', 'slug' => 'school.edit', 'module' => 'school', 'action' => 'edit'],
            ['name' => 'View Public School Info', 'slug' => 'school.view_public', 'module' => 'school', 'action' => 'view_public'],

            // Website Management
            ['name' => 'Manage Website', 'slug' => 'website.manage', 'module' => 'website', 'action' => 'manage'],

            // Billing
            ['name' => 'Process Payments', 'slug' => 'billing.process', 'module' => 'billing', 'action' => 'process'],
            ['name' => 'View Payments', 'slug' => 'billing.view', 'module' => 'billing', 'action' => 'view'],
            ['name' => 'View Discounts', 'slug' => 'billing.view_discounts', 'module' => 'billing', 'action' => 'view_discounts'],

            // Receipts
            ['name' => 'Generate Receipts', 'slug' => 'receipts.generate', 'module' => 'receipts', 'action' => 'generate'],
            ['name' => 'View Receipts', 'slug' => 'receipts.view', 'module' => 'receipts', 'action' => 'view'],
            ['name' => 'Print Receipts', 'slug' => 'receipts.print', 'module' => 'receipts', 'action' => 'print'],

            // Expenses
            ['name' => 'View Expenses', 'slug' => 'expenses.view', 'module' => 'expenses', 'action' => 'view'],
            ['name' => 'Create Expenses', 'slug' => 'expenses.create', 'module' => 'expenses', 'action' => 'create'],
            ['name' => 'Edit Expenses', 'slug' => 'expenses.edit', 'module' => 'expenses', 'action' => 'edit'],
            ['name' => 'Delete Expenses', 'slug' => 'expenses.delete', 'module' => 'expenses', 'action' => 'delete'],

            // Reports
            ['name' => 'View Reports', 'slug' => 'reports.view', 'module' => 'reports', 'action' => 'view'],
            ['name' => 'View Transport Reports', 'slug' => 'reports.transport', 'module' => 'reports', 'action' => 'transport'],

            // Users & Roles
            ['name' => 'View Users', 'slug' => 'users.view', 'module' => 'users', 'action' => 'view'],
            ['name' => 'Create Users', 'slug' => 'users.create', 'module' => 'users', 'action' => 'create'],
            ['name' => 'Edit Users', 'slug' => 'users.edit', 'module' => 'users', 'action' => 'edit'],
            ['name' => 'Delete Users', 'slug' => 'users.delete', 'module' => 'users', 'action' => 'delete'],
            ['name' => 'Manage Roles', 'slug' => 'roles.manage', 'module' => 'roles', 'action' => 'manage'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['slug' => $perm['slug']],
                $perm
            );
        }

        // Assign all permissions to Super Admin (ensure all permissions are synced)
        $allPermissions = Permission::all()->pluck('id');
        $superAdmin->permissions()->sync($allPermissions);
        
        // Ensure super admin role is properly set
        $this->command->info('Super Admin has been assigned ' . $allPermissions->count() . ' permissions.');

        // Assign permissions to Admin (full access except financial discounts and system settings)
        $adminPermissions = Permission::whereIn('slug', [
            // Students
            'students.view',
            'students.create',
            'students.edit',
            'students.delete',
            
            // Parents
            'parents.view',
            'parents.create',
            'parents.edit',
            'parents.delete',
            
            // Courses
            'courses.view',
            'courses.create',
            'courses.edit',
            'courses.delete',
            'courses.view_prices',
            
            // Classes & Grades
            'classes.view',
            'classes.create',
            'classes.edit',
            'classes.delete',
            'classes.manage_students',
            
            // Subjects
            'subjects.view',
            'subjects.create',
            'subjects.edit',
            'subjects.delete',
            
            // Timetables
            'timetables.view',
            'timetables.create',
            'timetables.edit',
            'timetables.delete',
            
            // Attendance
            'attendance.view',
            'attendance.mark',
            'attendance.edit',
            
            // Exams & Results
            'exams.view',
            'exams.create',
            'exams.edit',
            'exams.delete',
            'results.view',
            'results.create',
            'results.edit',
            
            // Teachers
            'teachers.view',
            'teachers.create',
            'teachers.edit',
            'teachers.delete',
            
            // Transportation
            'transport.view',
            'transport.create',
            'transport.edit',
            'transport.delete',
            'vehicles.view',
            'vehicles.create',
            'vehicles.edit',
            'vehicles.delete',
            'drivers.view',
            'drivers.create',
            'drivers.edit',
            'drivers.delete',
            'routes.view',
            'routes.create',
            'routes.edit',
            'routes.delete',
            'routes.assign_students',
            'transport.view_status',
            
            // Extracurricular
            'clubs.view',
            'clubs.create',
            'clubs.edit',
            'clubs.delete',
            'clubs.manage_members',
            
            // Announcements
            'announcements.view',
            'announcements.create',
            'announcements.edit',
            'announcements.delete',
            'announcements.create_class',
            
            // Notifications
            'notifications.view',
            'notifications.send',
            
            // School Information
            'school.view',
            
            // Website Management
            'website.manage',
            
            // Billing (without discount view)
            'billing.process',
            'billing.view',
            
            // Receipts
            'receipts.generate',
            'receipts.view',
            'receipts.print',
            
            // Expenses
            'expenses.view',
            'expenses.create',
            'expenses.edit',
            'expenses.delete',
            
            // Reports (without financial details)
            'reports.view',
            'reports.transport',
            
            // Users (view only, no role management)
            'users.view',
        ])->pluck('id');
        $admin->permissions()->sync($adminPermissions);

        // Assign permissions to Cashier (limited to billing operations)
        $cashierPermissions = Permission::whereIn('slug', [
            'students.view',
            'courses.view',
            'billing.process',
            'billing.view',
            'receipts.generate',
            'receipts.view',
            'receipts.print',
            'expenses.view',
            'expenses.create',
            'expenses.edit',
        ])->pluck('id');
        $cashier->permissions()->sync($cashierPermissions);

        // Assign permissions to Teacher
        $teacherPermissions = Permission::whereIn('slug', [
            'students.view',
            'classes.view',
            'classes.manage_students',
            'subjects.view',
            'timetables.view',
            'timetables.create',
            'timetables.edit',
            'attendance.view',
            'attendance.mark',
            'attendance.edit',
            'exams.view',
            'exams.create',
            'exams.edit',
            'results.view',
            'results.create',
            'results.edit',
            'announcements.view',
            'announcements.create',
            'announcements.create_class',
            'announcements.edit',
            'clubs.view',
            'clubs.manage_members',
        ])->pluck('id');
        $teacher->permissions()->sync($teacherPermissions);

        // Assign permissions to Parent
        $parentPermissions = Permission::whereIn('slug', [
            'parents.view_children',
            'students.view_own',
            'attendance.view_own',
            'results.view_own',
            'transport.view_status',
            'announcements.view',
            'timetables.view',
            'clubs.view',
            'notifications.view',
        ])->pluck('id');
        $parent->permissions()->sync($parentPermissions);

        // Assign permissions to Student
        $studentPermissions = Permission::whereIn('slug', [
            'students.view_own',
            'attendance.view_own',
            'results.view_own',
            'announcements.view',
            'timetables.view',
            'clubs.view',
        ])->pluck('id');
        $student->permissions()->sync($studentPermissions);

        // Assign permissions to Transport Driver
        $driverPermissions = Permission::whereIn('slug', [
            'routes.view_assigned',
            'routes.mark_pickup',
            'students.view',
        ])->pluck('id');
        $transportDriver->permissions()->sync($driverPermissions);

        // Assign permissions to Transport Manager
        $transportManagerPermissions = Permission::whereIn('slug', [
            'vehicles.view',
            'vehicles.create',
            'vehicles.edit',
            'vehicles.delete',
            'drivers.view',
            'drivers.create',
            'drivers.edit',
            'drivers.delete',
            'routes.view',
            'routes.create',
            'routes.edit',
            'routes.delete',
            'routes.assign_students',
            'transport.view_status',
            'reports.transport',
        ])->pluck('id');
        $transportManager->permissions()->sync($transportManagerPermissions);

        // Assign permissions to Website (public API)
        $websitePermissions = Permission::whereIn('slug', [
            'school.view_public',
            'announcements.view',
            'clubs.view',
        ])->pluck('id');
        $website->permissions()->sync($websitePermissions);
    }
}
