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
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('jadwal');
        Schema::dropIfExists('jadwals');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate tables with minimal schema for rollback purposes
        Schema::create('schedules', function (Blueprint $table) {
             $table->id();
             $table->timestamps();
        });
        Schema::create('jadwal', function (Blueprint $table) {
             $table->id();
             $table->timestamps();
        });
        Schema::create('jadwals', function (Blueprint $table) {
             $table->id();
             $table->timestamps();
        });
    }
};
