<?php

use App\Enums\SchoolStatus;
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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('npsn')->unique();
            $table->string('name');
            $table->string('education_level');
            $table->string('ownership_status');
            $table->string('address');
            $table->string('district');
            $table->string('village');
            $table->string('verification_doc');
            $table->string('logo');
            $table->enum('status', SchoolStatus::cases())->default(SchoolStatus::PENDING);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
