<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // SQLite doesn't support ALTER TABLE MODIFY ENUM directly
        // We need to recreate the column with the new enum values
        if (DB::getDriverName() === 'sqlite') {
            DB::statement("PRAGMA foreign_keys=off;");
            
            // Drop temp table if it exists from previous failed migration
            DB::statement("DROP TABLE IF EXISTS announcements_new");
            
            // Create new table with updated enum and all columns
            DB::statement("
                CREATE TABLE announcements_new (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    title VARCHAR(255) NOT NULL,
                    message TEXT NOT NULL,
                    attachment_path VARCHAR(255),
                    attachment_name VARCHAR(255),
                    attachment_type VARCHAR(255),
                    target_audience VARCHAR(20) DEFAULT 'all' CHECK(target_audience IN ('all', 'students', 'parents', 'teachers', 'admin')),
                    target_courses TEXT,
                    target_student_groups TEXT,
                    target_classes TEXT,
                    target_students TEXT,
                    priority VARCHAR(20) DEFAULT 'medium' CHECK(priority IN ('low', 'medium', 'high')),
                    status VARCHAR(20) DEFAULT 'active' CHECK(status IN ('draft', 'active', 'archived')),
                    posted_by INTEGER,
                    published_at TIMESTAMP NULL,
                    created_at TIMESTAMP NULL,
                    updated_at TIMESTAMP NULL,
                    FOREIGN KEY (posted_by) REFERENCES users(id) ON DELETE SET NULL
                )
            ");
            
            // Copy data
            DB::statement("
                INSERT INTO announcements_new 
                (id, title, message, attachment_path, attachment_name, attachment_type, 
                 target_audience, target_courses, target_student_groups, target_classes, target_students,
                 priority, status, posted_by, published_at, created_at, updated_at)
                SELECT 
                    id, title, message, attachment_path, attachment_name, attachment_type,
                    target_audience, target_courses, target_student_groups, target_classes, target_students,
                    priority, status, posted_by, published_at, created_at, updated_at
                FROM announcements
            ");
            
            // Drop old table
            DB::statement("DROP TABLE announcements");
            
            // Rename new table
            DB::statement("ALTER TABLE announcements_new RENAME TO announcements");
            
            DB::statement("PRAGMA foreign_keys=on;");
        } else {
            // For MySQL/PostgreSQL
            DB::statement("ALTER TABLE announcements MODIFY COLUMN target_audience ENUM('all', 'students', 'parents', 'teachers', 'admin') DEFAULT 'all'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            DB::statement("PRAGMA foreign_keys=off;");
            
            DB::statement("
                CREATE TABLE announcements_old (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    title VARCHAR(255) NOT NULL,
                    message TEXT NOT NULL,
                    attachment_path VARCHAR(255),
                    attachment_name VARCHAR(255),
                    attachment_type VARCHAR(255),
                    target_audience VARCHAR(20) DEFAULT 'all' CHECK(target_audience IN ('all', 'students', 'parents', 'teachers')),
                    target_courses TEXT,
                    target_student_groups TEXT,
                    target_classes TEXT,
                    target_students TEXT,
                    priority VARCHAR(20) DEFAULT 'medium' CHECK(priority IN ('low', 'medium', 'high')),
                    status VARCHAR(20) DEFAULT 'active' CHECK(status IN ('draft', 'active', 'archived')),
                    posted_by INTEGER,
                    published_at TIMESTAMP NULL,
                    created_at TIMESTAMP NULL,
                    updated_at TIMESTAMP NULL,
                    FOREIGN KEY (posted_by) REFERENCES users(id) ON DELETE SET NULL
                )
            ");
            
            DB::statement("
                INSERT INTO announcements_old 
                (id, title, message, attachment_path, attachment_name, attachment_type, 
                 target_audience, target_courses, target_student_groups, target_classes, target_students,
                 priority, status, posted_by, published_at, created_at, updated_at)
                SELECT 
                    id, title, message, attachment_path, attachment_name, attachment_type,
                    target_audience, target_courses, target_student_groups, target_classes, target_students,
                    priority, status, posted_by, published_at, created_at, updated_at
                FROM announcements WHERE target_audience != 'admin'
            ");
            
            DB::statement("DROP TABLE announcements");
            DB::statement("ALTER TABLE announcements_old RENAME TO announcements");
            
            DB::statement("PRAGMA foreign_keys=on;");
        } else {
            DB::statement("ALTER TABLE announcements MODIFY COLUMN target_audience ENUM('all', 'students', 'parents', 'teachers') DEFAULT 'all'");
        }
    }
};
