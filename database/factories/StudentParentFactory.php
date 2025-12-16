<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StudentParent;
use App\Models\User;
use App\Enums\MonthlyIncome;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentParent>
 */
class StudentParentFactory extends Factory
{
    protected $model = StudentParent::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Will be overridden usually
            'nik' => $this->faker->numerify('################'),
            'kk_number' => $this->faker->numerify('################'),
            'occupation' => $this->faker->jobTitle(),
            'monthly_income' => $this->faker->randomElement(MonthlyIncome::cases()),
            'education_level' => $this->faker->randomElement(['SD', 'SMP', 'SMA', 'S1', 'S2', 'S3']),
            'phone_alternate' => $this->faker->phoneNumber(),
            'address_domicile' => $this->faker->address(),
        ];
    }
}
