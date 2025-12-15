<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StudentTermRecord;
use App\Models\Student;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Enums\PromotionStatus;

class StudentTermRecordFactory extends Factory
{
    protected $model = StudentTermRecord::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'academic_year_id' => AcademicYear::factory(),
            'classroom_id' => Classroom::factory(),
            'sick_count' => $this->faker->numberBetween(0, 5),
            'permission_count' => $this->faker->numberBetween(0, 5),
            'absentee_count' => $this->faker->numberBetween(0, 3),
            'notes' => $this->faker->sentence(),
            'promotion_status' => PromotionStatus::CONTINUING,
        ];
    }
}
