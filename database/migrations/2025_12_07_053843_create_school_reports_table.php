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
        Schema::create('school_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('academic_year_id')->nullable()->constrained('academic_years')->onDelete('set null');
            $table->foreignId('uploaded_by')->constrained('users'); // Kepala sekolah
            $table->foreignId('reviewed_by')->nullable()->constrained('users'); // Admin Dinas
            
            $table->string('title');
            $table->enum('report_type', ['Bulanan', 'Semester', 'Tahunan', 'Keuangan', 'Insidental']);
            $table->date('report_period')->nullable(); // Tanggal periode, e.g., '2024-08-01'
            
            $table->string('file_path');
            $table->text('description')->nullable();
            
            $table->enum('status', ['submitted', 'reviewed', 'accepted', 'rejected', 'revision_needed'])->default('submitted');
            $table->text('dinas_feedback')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_reports');
    }
};
