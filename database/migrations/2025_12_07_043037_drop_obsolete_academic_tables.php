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
        Schema::dropIfExists('absensis');
        Schema::dropIfExists('tugas_pengumpulan');
        Schema::dropIfExists('tugas');
    }

    public function down(): void
    {
        // Recreate with minimal schema for rollback
        Schema::create('absensis', function (Blueprint $table) { $table->id(); $table->timestamps(); });
        Schema::create('tugas', function (Blueprint $table) { $table->id(); $table->timestamps(); });
        Schema::create('tugas_pengumpulan', function (Blueprint $table) { $table->id(); $table->timestamps(); });
    }
};
