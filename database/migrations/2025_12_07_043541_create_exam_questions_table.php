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
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
            $table->enum('question_type', ['multiple_choice', 'essay', 'true_false']);
            $table->text('question_text');
            $table->integer('points')->default(1);
            $table->json('options')->nullable(); // For multiple choice
            $table->text('correct_answer')->nullable(); // 'A', 'B', 'True', etc
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
    }
};
