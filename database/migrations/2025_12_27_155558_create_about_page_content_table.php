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
        Schema::create('about_page_content', function (Blueprint $table) {
            $table->id();
            $table->string('section_type'); // about_school, clubs
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->text('paragraph')->nullable();
            $table->string('name')->nullable(); // For clubs
            $table->text('description')->nullable(); // For clubs
            $table->integer('order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_page_content');
    }
};
