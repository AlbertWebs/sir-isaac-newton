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
        Schema::create('homepage_features', function (Blueprint $table) {
            $table->id();
            $table->string('section_title')->nullable();
            $table->string('section_heading')->nullable();
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->string('title');
            $table->text('paragraph')->nullable();
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
        Schema::dropIfExists('homepage_features');
    }
};
