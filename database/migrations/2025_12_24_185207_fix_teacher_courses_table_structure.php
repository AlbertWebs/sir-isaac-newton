<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('teacher_courses'); // Drop table to ensure a clean state

        // Check if table exists and has no columns (except id and timestamps)
        if (!Schema::hasTable('teacher_courses')) {
            Schema::create('teacher_courses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
                $table->foreignId('course_id')->constrained()->onDelete('cascade');
                $table->string('academic_year')->nullable();
                $table->string('term')->nullable();
                $table->timestamps();

                // Add unique constraint
                $table->unique(['teacher_id', 'course_id'], 'unique_teacher_course');
            });
        } else {
            $columns = Schema::getColumnListing('teacher_courses');
            
            // Only add columns if they don't exist
            if (!in_array('teacher_id', $columns)) {
                Schema::table('teacher_courses', function (Blueprint $table) {
                    $table->foreignId('teacher_id')->after('id')->constrained()->onDelete('cascade');
                    $table->foreignId('course_id')->after('teacher_id')->constrained()->onDelete('cascade');
                    $table->string('academic_year')->nullable()->after('course_id');
                    $table->string('term')->nullable()->after('academic_year');
                    
                    // Add unique constraint
                    $table->unique(['teacher_id', 'course_id'], 'unique_teacher_course');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('teacher_courses')) {
            Schema::table('teacher_courses', function (Blueprint $table) {
                // Drop unique constraint if columns exist
                if (Schema::hasColumn('teacher_courses', 'teacher_id') && Schema::hasColumn('teacher_courses', 'course_id')) {
                    $table->dropUnique('unique_teacher_course');
                }

                // Drop foreign keys if columns exist
                if (Schema::hasColumn('teacher_courses', 'teacher_id')) {
                    $table->dropForeign(['teacher_id']);
                }
                if (Schema::hasColumn('teacher_courses', 'course_id')) {
                    $table->dropForeign(['course_id']);
                }

                // Drop columns if they exist
                $table->dropColumn(['teacher_id', 'course_id', 'academic_year', 'term']);
            });
        }
    }
};
