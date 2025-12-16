<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Teacher;
use App\Models\ClassSchedule;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_can_get_schedule()
    {
        $user = User::factory()->create(['role' => 'guru']);
        $teacher = Teacher::factory()->create(['user_id' => $user->id]);

        $course = Course::factory()->create([
            'teacher_id' => $teacher->id
        ]);

        $schedule = ClassSchedule::factory()->create([
            'course_id' => $course->id,
            'day_of_week' => 'monday'
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/teacher/schedule');

        $response->assertStatus(200)
            ->assertJsonPath('data.monday.0.id', $schedule->id);
    }

    public function test_teacher_can_submit_attendance()
    {
        $user = User::factory()->create(['role' => 'guru']);
        $teacher = Teacher::factory()->create(['user_id' => $user->id]);
        $classroom = Classroom::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $teacher->id,
            'classroom_id' => $classroom->id
        ]);

        $schedule = ClassSchedule::factory()->create([
            'course_id' => $course->id,
        ]);

        $student = Student::factory()->create(['classroom_id' => $classroom->id]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $payload = [
            'class_schedule_id' => $schedule->id,
            'date' => now()->toDateString(),
            'students' => [
                [
                    'student_id' => $student->id,
                    'status' => 'present',
                    'note' => 'On time'
                ]
            ]
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/teacher/attendance', $payload);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Attendance submitted successfully']);

        $this->assertDatabaseHas('attendances', [
            'student_id' => $student->id,
            'status' => 'present',
        ]);
    }
}
