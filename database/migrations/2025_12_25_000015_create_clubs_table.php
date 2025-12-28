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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Football Club", "Chess Club", "Drama Club"
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->enum('type', ['sports', 'academic', 'arts', 'cultural', 'other'])->default('other');
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->onDelete('set null'); // Club coordinator
            $table->integer('max_members')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};

