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
        Schema::create('enrollment_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('child_name');
            $table->date('child_dob');
            $table->string('parent_name');
            $table->string('parent_email');
            $table->string('phone');
            $table->foreignId('class_id')->nullable()->constrained('classes')->onDelete('set null');
            $table->text('additional_info')->nullable();
            $table->boolean('notify_progress')->default(false);
            $table->string('status')->default('pending'); // pending, reviewed, accepted, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment_submissions');
    }
};
