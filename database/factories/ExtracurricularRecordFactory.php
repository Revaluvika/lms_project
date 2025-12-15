<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ExtracurricularRecord;
use App\Models\StudentTermRecord;

class ExtracurricularRecordFactory extends Factory
{
    protected $model = ExtracurricularRecord::class;

    public function definition(): array
    {
        return [
            'student_term_record_id' => StudentTermRecord::factory(),
            'activity_name' => $this->faker->randomElement(['Pramuka', 'Basket', 'Futsal', 'PMR', 'Rohis', 'Paduan Suara']),
            'grade' => $this->faker->randomElement(['A', 'B', 'C']),
            'description' => $this->faker->sentence(),
        ];
    }
}
