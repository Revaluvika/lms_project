<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Student;
use App\Models\StudentParent; // 'parents' table model
use App\Models\ClassSchedule;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Attendance;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class ParentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_parent_can_get_children_list()
    {
        $parentUser = User::factory()->create(['role' => 'orang_tua']);
        $parentProfile = StudentParent::factory()->create(['user_id' => $parentUser->id]);

        $studentUser = User::factory()->create(['role' => 'siswa']);
        $student = Student::factory()->create(['user_id' => $studentUser->id]);

        // Attach via pivot 'parent_student'
        $parentProfile->students()->attach($student->id, ['relation_type' => 'Ayah', 'is_guardian' => true]);

        $token = $parentUser->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/parent/children');

        $response->assertStatus(200);
        // Assert user structure is loaded (child name is in user table)
        $response->assertJsonFragment(['name' => $studentUser->name]);
    }

    public function test_parent_can_get_child_attendance()
    {
        $parentUser = User::factory()->create(['role' => 'orang_tua']);
        // Create profile usually required for logic, though not strict for this endpoint if passing student_id
        // But let's be consistent
        $parentProfile = StudentParent::factory()->create(['user_id' => $parentUser->id]);

        $studentUser = User::factory()->create(['role' => 'siswa']);
        $student = Student::factory()->create(['user_id' => $studentUser->id]);

        // Link them
        $parentProfile->students()->attach($student->id);

        $course = Course::factory()->create();

        $attendance = Attendance::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'date' => now()->toDateString(),
            'status' => 'present'
        ]);

        $token = $parentUser->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/parent/attendance?student_id=' . $student->id);

        $response->assertStatus(200)
            ->assertJsonFragment(['status' => 'present']);
    }

    public function test_parent_can_get_child_schedule()
    {
        $parentUser = User::factory()->create(['role' => 'orang_tua']);
        $parentProfile = StudentParent::factory()->create(['user_id' => $parentUser->id]);

        $studentUser = User::factory()->create(['role' => 'siswa']);
        $classroom = Classroom::factory()->create();
        $student = Student::factory()->create([
            'user_id' => $studentUser->id,
            'classroom_id' => $classroom->id
        ]);

        $parentProfile->students()->attach($student->id);

        $subject = Subject::factory()->create(['name' => 'Math']);
        $teacher = Teacher::factory()->create();

        $course = Course::factory()->create([
            'classroom_id' => $classroom->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id
        ]);

        $schedule = ClassSchedule::factory()->create([
            'course_id' => $course->id,
            'day_of_week' => 'monday'
        ]);

        $token = $parentUser->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/parent/schedule?student_id=' . $student->id);

        $response->assertStatus(200)
            ->assertJsonPath('data.monday.0.id', $schedule->id);
    }
}
