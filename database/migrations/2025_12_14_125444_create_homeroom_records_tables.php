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
        Schema::create('student_term_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('academic_year_id')->constrained()->onDelete('cascade');
            $table->foreignId('classroom_id')->constrained()->onDelete('cascade'); // Records which class they were in
            
            // Attendance Summary
            $table->integer('sick_count')->default(0);
            $table->integer('permission_count')->default(0);
            $table->integer('absentee_count')->default(0); // Alpha
            
            // Homeroom Teacher Notes
            $table->text('notes')->nullable(); // General attitude/motivation notes
            
            // Promotion Status (for end of year)
            // 'promoted' = Naik Kelas
            // 'retained' = Tinggal Kelas
            // 'graduated' = Lulus
            // 'continuing' = Masih berlanjut (for odd semester)
            $table->enum('promotion_status', ['promoted', 'retained', 'graduated', 'continuing'])->default('continuing');
            
            $table->timestamps();

            // Unique constraint: One record per student per academic year
            $table->unique(['student_id', 'academic_year_id']);
        });

        Schema::create('extracurricular_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_term_record_id')->constrained('student_term_records')->onDelete('cascade');
            $table->string('activity_name');
            $table->string('grade')->nullable(); // A, B, C, or score
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extracurricular_records');
        Schema::dropIfExists('student_term_records');
    }
};
