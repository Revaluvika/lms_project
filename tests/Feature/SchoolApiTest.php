<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Student;

class SchoolApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test getting schools with counts.
     *
     * @return void
     */
    public function test_can_get_schools_with_counts()
    {
        // Create a school
        $school = School::factory()->create();

        // Create teachers and students for the school
        Teacher::factory()->count(3)->create(['school_id' => $school->id]);
        Student::factory()->count(5)->create(['school_id' => $school->id]);

        // Call the API
        $response = $this->getJson('/api/schools');

        // Assert response status
        $response->assertStatus(200);

        // Assert JSON structure and data
        $response->assertJsonStructure([
            'status',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'teachers_count',
                    'students_count',
                ]
            ]
        ]);

        // Assert specific values for the created school
        $response->assertJsonFragment([
            'id' => $school->id,
            'teachers_count' => 3,
            'students_count' => 5,
        ]);
    }
}
