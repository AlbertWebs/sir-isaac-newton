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
        Schema::table('students', function (Blueprint $table) {
            $table->boolean('uses_transport')->default(false)->after('status');
            $table->text('medical_info')->nullable()->after('uses_transport');
            $table->text('allergies')->nullable()->after('medical_info');
            $table->text('emergency_medical_contact')->nullable()->after('allergies');
            $table->json('authorized_pickup_persons')->nullable()->after('emergency_medical_contact');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'uses_transport',
                'medical_info',
                'allergies',
                'emergency_medical_contact',
                'authorized_pickup_persons'
            ]);
        });
    }
};

