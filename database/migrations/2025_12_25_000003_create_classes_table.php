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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Daycare A", "Playgroup B", "PP1", "Grade 1A"
            $table->string('code')->unique(); // e.g., "DC-A", "PG-B", "PP1", "G1A"
            $table->enum('level', [
                'daycare',
                'playgroup',
                'pp1',
                'pp2',
                'grade_1',
                'grade_2',
                'grade_3',
                'grade_4',
                'grade_5',
                'grade_6'
            ]);
            $table->string('academic_year'); // e.g., "2024/2025"
            $table->string('term')->nullable(); // "Term 1", "Term 2", "Term 3"
            $table->foreignId('class_teacher_id')->nullable()->constrained('teachers')->onDelete('set null');
            $table->integer('capacity')->default(30);
            $table->integer('current_enrollment')->default(0);
            $table->enum('status', ['active', 'inactive', 'completed'])->default('active');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};

