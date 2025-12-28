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
        Schema::table('payments', function (Blueprint $table) {
            // Remove month and year columns
            $table->dropColumn(['month', 'year']);
            
            // Add term column for term-based billing
            $table->string('term')->nullable()->after('academic_year'); // e.g., "Term 1", "Term 2", "Term 3"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('term');
            $table->string('month')->nullable()->after('academic_year');
            $table->integer('year')->nullable()->after('month');
        });
    }
};
