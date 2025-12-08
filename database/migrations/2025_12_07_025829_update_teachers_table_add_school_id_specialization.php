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
        Schema::table('teachers', function (Blueprint $table) {
            $table->foreignId('school_id')->after('id')->constrained('schools')->onDelete('cascade');
            $table->string('specialization')->nullable()->after('school_id');
            $table->dropColumn(['nama', 'mapel']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('nama')->nullable()->after('id');
            $table->string('mapel')->nullable()->after('nip');
            $table->dropForeign(['school_id']);
            $table->dropColumn(['school_id', 'specialization']);
        });
    }
};
