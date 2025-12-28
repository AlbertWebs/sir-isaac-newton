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
        Schema::create('route_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('pickup_stop_id')->nullable()->constrained('route_stops')->onDelete('set null');
            $table->foreignId('dropoff_stop_id')->nullable()->constrained('route_stops')->onDelete('set null');
            $table->enum('service_type', ['morning', 'afternoon', 'both'])->default('both');
            $table->date('start_date')->default(now());
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'suspended', 'cancelled'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // A student can only have one active route assignment at a time
            $table->unique(['student_id', 'status'], 'unique_active_student_route');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_assignments');
    }
};

