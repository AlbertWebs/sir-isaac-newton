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
        Schema::create('club_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('academic_year');
            $table->date('join_date')->default(now());
            $table->enum('role', ['member', 'leader', 'assistant_leader'])->default('member');
            $table->enum('status', ['active', 'inactive', 'graduated'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['club_id', 'student_id', 'academic_year'], 'unique_club_student_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_memberships');
    }
};

