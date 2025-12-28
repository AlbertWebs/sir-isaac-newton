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
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Route A - Westlands", "Route B - Karen"
            $table->string('code')->unique(); // e.g., "RT-A", "RT-B"
            $table->foreignId('vehicle_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            $table->enum('type', ['morning', 'afternoon', 'both'])->default('both');
            $table->time('morning_pickup_time')->nullable();
            $table->time('morning_dropoff_time')->nullable();
            $table->time('afternoon_pickup_time')->nullable();
            $table->time('afternoon_dropoff_time')->nullable();
            $table->decimal('estimated_distance_km', 8, 2)->nullable();
            $table->integer('estimated_duration_minutes')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};

