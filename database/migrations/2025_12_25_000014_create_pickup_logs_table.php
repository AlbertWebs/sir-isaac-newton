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
        Schema::create('pickup_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_session_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('route_stop_id')->nullable()->constrained('route_stops')->onDelete('set null');
            $table->enum('action_type', ['pickup', 'dropoff']);
            $table->enum('status', ['pending', 'picked', 'dropped', 'missed', 'cancelled'])->default('pending');
            $table->timestamp('scheduled_time')->nullable();
            $table->timestamp('actual_time')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('notification_sent')->default(false);
            $table->timestamp('notification_sent_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['trip_session_id', 'student_id', 'action_type']);
            $table->index(['student_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pickup_logs');
    }
};

