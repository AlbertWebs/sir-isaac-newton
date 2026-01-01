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
        Schema::table('school_information', function (Blueprint $table) {
            $table->string('enroll_image_1')->nullable()->after('logo');
            $table->string('enroll_image_2')->nullable()->after('enroll_image_1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_information', function (Blueprint $table) {
            $table->dropColumn('enroll_image_1');
            $table->dropColumn('enroll_image_2');
        });
    }
};
