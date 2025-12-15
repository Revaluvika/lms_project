<?php

namespace Tests\Feature;

use App\Enums\SchoolStatus;
use App\Enums\UserRole;
use App\Models\Classroom;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminParentTest extends TestCase
{
    use RefreshDatabase;

    protected $school;
    protected $adminUser;
    protected $classroom;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup School & Admin
        $this->school = School::factory()->create(['status' => SchoolStatus::ACTIVE]);
        $this->adminUser = User::factory()->create([
            'role' => UserRole::ADMIN_SEKOLAH,
            'school_id' => $this->school->id,
            'email_verified_at' => now(),
        ]);
        $this->classroom = Classroom::factory()->create(['school_id' => $this->school->id]);
    }

    public function test_admin_can_link_existing_parent_by_nik()
    {
        // 1. Create Existing Parent
        $parentUser = User::factory()->create(['role' => UserRole::ORANG_TUA]);
        $parentProfile = StudentParent::create([
            'user_id' => $parentUser->id,
            'nik' => '999988887777', // Unique NIK
            'phone_alternate' => '08123456789'
        ]);

        // 2. Submit New Student with this NIK
        $response = $this->actingAs($this->adminUser)->post(route('master.students.store'), [
            'nama' => 'Anak Baru NIK',
            'email' => 'anak.nik@test.com',
            'nis' => '1001',
            'classroom_id' => $this->classroom->id,
            'parent_nik' => '999988887777', // Match!
            'parent_email' => 'ignored@test.com', // Should prioritize NIK
            'relation_type' => 'Ayah', // Test Value
        ]);

        $response->assertSessionHas('success');

        // 3. Verify Link
        $student = Student::where('nis', '1001')->first();
        $this->assertNotNull($student);
        $this->assertTrue($student->parents->contains('id', $parentProfile->id));
        $this->assertEquals('Ayah', $student->parents->first()->pivot->relation_type);
    }

    public function test_admin_can_link_existing_parent_by_email()
    {
        // 1. Create Existing Parent User (No StudentParent profile yet)
        $parentUser = User::factory()->create([
            'role' => UserRole::ORANG_TUA,
            'email' => 'parent.existing@test.com'
        ]);

        // 2. Submit New Student with this Email
        $response = $this->actingAs($this->adminUser)->post(route('master.students.store'), [
            'nama' => 'Anak Baru Email',
            'email' => 'anak.email@test.com',
            'nis' => '1002',
            'classroom_id' => $this->classroom->id,
            'parent_email' => 'parent.existing@test.com', // Match!
            'parent_nik' => '123123123', // New NIK will be assigned
        ]);

        $response->assertSessionHas('success');

        // 3. Verify Created Profile and Link
        $student = Student::where('nis', '1002')->first();
        $this->assertTrue($student->parents->first()->user_id == $parentUser->id);
        $this->assertEquals('123123123', $student->parents->first()->nik);
    }

    public function test_admin_creates_new_parent_if_not_found()
    {
        // 1. Submit New Student with details
        $response = $this->actingAs($this->adminUser)->post(route('master.students.store'), [
            'nama' => 'Anak Baru Full',
            'email' => 'anak.full@test.com',
            'nis' => '1003',
            'classroom_id' => $this->classroom->id,
            'parent_name' => 'Bapak Baru',
            'parent_email' => 'bapak.baru@test.com',
            'parent_nik' => '555566667777',
            'parent_phone' => '089999999',
            'relation_type' => 'Ibu'
        ]);

        $response->assertSessionHas('success');

        // 2. Verify New Parent Created
        $parentUser = User::where('email', 'bapak.baru@test.com')->first();
        $this->assertNotNull($parentUser);
        $this->assertEquals('Bapak Baru', $parentUser->name);

        $student = Student::where('nis', '1003')->first();
        $this->assertTrue($student->parents->contains('user_id', $parentUser->id));
        $this->assertEquals('Ibu', $student->parents->first()->pivot->relation_type);
    }
}
