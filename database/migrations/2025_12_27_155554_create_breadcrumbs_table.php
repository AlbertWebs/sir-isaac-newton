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
        Schema::create('breadcrumbs', function (Blueprint $table) {
            $table->id();
            $table->string('page_key')->unique(); // e.g., 'about', 'classes', 'gallery', 'contact'
            $table->string('background_image')->nullable();
            $table->string('title');
            $table->text('paragraph')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breadcrumbs');
    }
};
