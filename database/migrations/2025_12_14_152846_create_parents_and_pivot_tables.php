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
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nik', 16)->nullable();
            $table->string('kk_number', 16)->nullable();
            $table->string('occupation')->nullable();
            $table->string('monthly_income')->nullable(); // Cast to Enum in model
            $table->string('education_level')->nullable();
            $table->string('phone_alternate')->nullable();
            $table->text('address_domicile')->nullable();
            $table->timestamps();
        });

        Schema::create('parent_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('parents')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('relation_type')->nullable(); // Ayah, Ibu, Wali
            $table->boolean('is_guardian')->default(false);
            $table->timestamps();

            // Prevent duplicate linking of same parent-student pair
            $table->unique(['parent_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_student');
        Schema::dropIfExists('parents');
    }
};
