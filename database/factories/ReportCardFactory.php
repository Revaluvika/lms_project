<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ReportCard;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\AcademicYear;

class ReportCardFactory extends Factory
{
    protected $model = ReportCard::class;

    public function definition(): array
    {
        $formative = $this->faker->numberBetween(60, 100);
        $midTerm = $this->faker->numberBetween(60, 100);
        $finalTerm = $this->faker->numberBetween(60, 100);

        // Simple calculation
        $finalGrade = ($formative * 0.4) + ($midTerm * 0.3) + ($finalTerm * 0.3);

        $predicate = match (true) {
            $finalGrade >= 90 => 'A',
            $finalGrade >= 80 => 'B',
            $finalGrade >= 70 => 'C',
            default => 'D',
        };

        return [
            'student_id' => Student::factory(),
            'teacher_id' => Teacher::factory(),
            'subject_id' => Subject::factory(),
            'academic_year_id' => AcademicYear::factory(),
            'formative_score' => $formative,
            'mid_term_score' => $midTerm,
            'final_term_score' => $finalTerm,
            'final_grade' => $finalGrade,
            'predicate' => $predicate,
            'comments' => $this->faker->sentence(),
        ];
    }
}
