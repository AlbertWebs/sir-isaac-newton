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
        Schema::create('class_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('academic_year'); // e.g., "2024/2025"
            $table->date('enrollment_date')->default(now());
            $table->enum('status', ['active', 'transferred', 'graduated', 'withdrawn'])->default('active');
            $table->timestamps();
            
            // A student can only be in one active class per academic year
            $table->unique(['student_id', 'academic_year', 'status'], 'unique_student_class_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_student');
    }
};

