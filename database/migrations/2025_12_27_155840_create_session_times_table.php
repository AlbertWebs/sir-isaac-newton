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
        Schema::create('session_times', function (Blueprint $table) {
            $table->id();
            $table->string('background_image')->nullable();
            $table->string('title')->nullable();
            $table->string('icon')->nullable();
            $table->text('paragraph')->nullable();
            $table->string('label'); // e.g., "Early Drop Off"
            $table->string('time_range'); // e.g., "8.00am – 10.00am"
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
        Schema::dropIfExists('session_times');
    }
};
