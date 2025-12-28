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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g., "ENG", "KIS", "MAT", "FRE", "GER", "COD", "ROB"
            $table->string('name'); // e.g., "English", "Kiswahili", "Mathematics", "French", "German", "Coding", "Robotics"
            $table->text('description')->nullable();
            $table->enum('type', [
                'core',
                'language',
                'special_program',
                'extracurricular'
            ])->default('core');
            $table->json('applicable_levels')->nullable(); // Which levels can take this subject
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};

