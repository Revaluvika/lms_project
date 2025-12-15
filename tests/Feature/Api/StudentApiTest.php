<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Student;
use App\Models\ClassSchedule;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_get_schedule()
    {
        $user = User::factory()->create(['role' => 'siswa']);
        $classroom = Classroom::factory()->create();
        $student = Student::factory()->create([
            'user_id' => $user->id,
            'classroom_id' => $classroom->id
        ]);

        $course = Course::factory()->create([
            'classroom_id' => $classroom->id
        ]);

        $schedule = ClassSchedule::factory()->create([
            'course_id' => $course->id,
            'day_of_week' => 'monday' // Ensure string matches enum if applicable or int
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/student/schedule');

        $response->assertStatus(200)
            ->assertJsonPath('data.monday.0.id', $schedule->id);
    }

    public function test_student_can_get_assignments()
    {
        $user = User::factory()->create(['role' => 'siswa']);
        $classroom = Classroom::factory()->create();
        $student = Student::factory()->create([
            'user_id' => $user->id,
            'classroom_id' => $classroom->id
        ]);

        $course = Course::factory()->create([
            'classroom_id' => $classroom->id
        ]);

        $assignment = Assignment::factory()->create([
            'course_id' => $course->id,
            'title' => 'Test Homework'
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/student/assignments');

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Test Homework']);
    }
}
