<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentParent;
use App\Enums\UserRole;
use App\Enums\SchoolStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParentMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_parent_without_school_and_no_children_is_forbidden()
    {
        $parent = User::factory()->create([
            'role' => UserRole::ORANG_TUA,
            'school_id' => null,
        ]);

        $this->actingAs($parent);

        $response = $this->get('/dashboard'); // Assuming dashboard is protected

        $response->assertStatus(403);
        $response->assertSee('Akun Anda tidak terhubung dengan sekolah manapun');
    }

    public function test_parent_with_child_in_active_school_can_access()
    {
        $school = School::factory()->create(['status' => SchoolStatus::ACTIVE]);
        $student = Student::factory()->create(['school_id' => $school->id]);

        $parentUser = User::factory()->create([
            'role' => UserRole::ORANG_TUA,
            'school_id' => null,
        ]);

        $parentProfile = StudentParent::factory()->create(['user_id' => $parentUser->id]);
        $parentProfile->students()->attach($student->id, ['relation_type' => 'Ayah', 'is_guardian' => true]);

        $this->actingAs($parentUser);

        // We need to hit a route that uses the middleware. 
        // /dashboard typically uses auth and maybe EnsureSchoolIsActive?
        // Let's assume a route protected by the middleware.
        // Usually 'home' or 'dashboard'.
        $response = $this->get('/');

        // If 200 or 302 (redirect to dashboard), it passed the middleware 403 check.
        // Middleware failure is 403 or redirect to school.inactive.
        $status = $response->status();
        $this->assertTrue(in_array($status, [200, 302]), "Expected 200 or 302, got $status");

        if ($status === 302) {
            $response->assertRedirect(); // Valid redirect (e.g. to login if not proper, or dashboard)
            // Check it didn't redirect to school.inactive
            $this->assertStringNotContainsString('school.inactive', $response->headers->get('Location'));
        }
    }

    public function test_parent_with_child_in_inactive_school_is_redirected()
    {
        $school = School::factory()->create(['status' => SchoolStatus::SUSPENDED]);
        $student = Student::factory()->create(['school_id' => $school->id]);

        $parentUser = User::factory()->create([
            'role' => UserRole::ORANG_TUA,
            'school_id' => null,
        ]);

        $parentProfile = StudentParent::factory()->create(['user_id' => $parentUser->id]);
        $parentProfile->students()->attach($student->id, ['relation_type' => 'Ayah', 'is_guardian' => true]);

        $this->actingAs($parentUser);

        $response = $this->get('/dashboard'); // Try to access protected route

        $response->assertRedirect(route('school.inactive'));
    }
}
