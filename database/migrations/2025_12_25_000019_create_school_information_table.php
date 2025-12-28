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
        Schema::create('school_information', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('motto')->default('Creating World Changers.');
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('about')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_secondary')->nullable();
            $table->text('address')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->json('facilities')->nullable(); // Array of facilities
            $table->json('programs')->nullable(); // Array of programs offered
            $table->json('social_media')->nullable(); // Facebook, Twitter, Instagram links
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_information');
    }
};

