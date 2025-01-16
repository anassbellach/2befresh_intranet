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
        Schema::table('klant', function (Blueprint $table) {
            $table->decimal('longitude', 11, 8)->nullable(); // Add longitude column
            $table->decimal('latitude', 10, 8)->nullable(); // Add latitude column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('klant', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
