<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\ParentStudent;
use App\Models\School;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Enums\UserRole;
use App\Enums\SchoolStatus;
use Illuminate\Support\Facades\Hash;
use App\Models\StudentParent;

class ParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding Parents...');

        // IMPORTANT: We need an active school to link the "Same School" scenario.
        // We try to find the one seeded by ComprehensiveSeeder, or create one.
        $school = School::first();
        if (!$school) {
            $school = School::factory()->create([
                'name' => 'SMA Negeri 1 Digital (Seeded)',
                'status' => SchoolStatus::ACTIVE,
            ]);
        }

        // Scenario A: Parent with 2 kids in the SAME school
        // Pick 2 random students from the school
        $siblingsSameSchool = Student::where('school_id', $school->id)->inRandomOrder()->take(2)->get();

        if ($siblingsSameSchool->count() >= 2) {
            // Check if user exists to avoid unique error on re-run
            $emailA = 'ortu.satu@seed.test';
            $parentUserA = User::where('email', $emailA)->first();

            if (!$parentUserA) {
                $parentUserA = User::factory()->create([
                    'name' => 'Orang Tua Satu Sekolah',
                    'email' => $emailA,
                    'password' => Hash::make('password'),
                    'role' => UserRole::ORANG_TUA,
                    'parent_id' => null,
                ]);

                $parentProfileA = StudentParent::factory()->create([
                    'user_id' => $parentUserA->id,
                ]);

                foreach ($siblingsSameSchool as $student) {
                    $parentProfileA->students()->attach($student->id, [
                        'relation_type' => 'Ayah',
                        'is_guardian' => true
                    ]);
                }
                $this->command->info('Created Parent (Same School): ' . $emailA);
            } else {
                $this->command->warn('Parent ' . $emailA . ' already exists. Skipping.');
            }
        }

        // Scenario B: Parent with kids in DIFFERENT schools (SMA + SD)
        $emailB = 'ortu.beda@seed.test';
        $parentUserB = User::where('email', $emailB)->first();

        if (!$parentUserB) {
            // 1. Create a dummy SD School (if not exists)
            $schoolSD = School::where('name', 'SD Harapan Bangsa (Seeded)')->first();
            if (!$schoolSD) {
                $schoolSD = School::factory()->create([
                    'name' => 'SD Harapan Bangsa (Seeded)',
                    'education_level' => 'SD',
                    'status' => SchoolStatus::ACTIVE,
                ]);
            }

            // 2. Ensure Academic Year
            $aySD = AcademicYear::firstOrCreate(
                ['school_id' => $schoolSD->id, 'is_active' => true],
                ['name' => '2024/2025', 'semester' => 'ganjil']
            );

            // 3. Ensure Class
            $classSD = Classroom::firstOrCreate(
                ['school_id' => $schoolSD->id, 'name' => 'Kelas 6A'],
                ['academic_year_id' => $aySD->id, 'grade_level' => 6, 'teacher_id' => 1] // Teacher ID might need valid ID, usually factories handle this but firstOrCreate is simpler
            );

            // If class was just created, it might fail foreign key on teacher_id if 1 doesn't exist.
            // Safer: Use factories for the child parts if they don't exist.
            if ($classSD->wasRecentlyCreated && !$classSD->teacher_id) {
                // Creating classroom via factory usually handles teacher creation. 
                // Let's rely on factory if we need to create deep structure.
            }
            // Simplify: Just rely on factories for new structures

            $userSD = User::factory()->create([
                'name' => 'Anak SD',
                'email' => 'anak.sd@seed.test',
                'password' => Hash::make('password'),
                'role' => UserRole::SISWA,
                'school_id' => $schoolSD->id
            ]);

            // Need a valid classroom for student.
            // Let's fetch any classroom from SD or create one properly.
            $validClassSD = Classroom::where('school_id', $schoolSD->id)->first();
            if (!$validClassSD) {
                $validClassSD = Classroom::factory()->create(['school_id' => $schoolSD->id]);
            }

            $studentSD = Student::factory()->create([
                'user_id' => $userSD->id,
                'school_id' => $schoolSD->id,
                'classroom_id' => $validClassSD->id,
                'nama' => 'Budi SD'
            ]);

            // 4. Create Parent User
            $parentUserB = User::factory()->create([
                'name' => 'Orang Tua Beda Sekolah',
                'email' => $emailB,
                'password' => Hash::make('password'),
                'role' => UserRole::ORANG_TUA,
            ]);

            $parentProfileB = StudentParent::factory()->create([
                'user_id' => $parentUserB->id,
            ]);

            // 5. Attach One SMA Student and One SD Student
            $studentSMA = Student::where('school_id', $school->id)->first();

            if ($studentSMA) {
                $parentProfileB->students()->attach($studentSMA->id, ['relation_type' => 'Ibu', 'is_guardian' => true]);
            }
            $parentProfileB->students()->attach($studentSD->id, ['relation_type' => 'Ibu', 'is_guardian' => true]);



            $this->command->info('Created Parent (Diff School): ' . $emailB);
        } else {
            $this->command->warn('Parent ' . $emailB . ' already exists. Skipping.');
        }

        // Scenario C: Create Parents for ALL remaining students
        $studentsWithoutParents = Student::doesntHave('parents')->get();
        $this->command->info('Seeding parents for remaining ' . $studentsWithoutParents->count() . ' students...');

        foreach ($studentsWithoutParents as $index => $student) {
            $email = 'ortu.siswa.' . $student->id . '@seed.test';

            // Create Parent User
            $parentUser = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => 'Orang Tua ' . $student->nama,
                    'password' => Hash::make('password'),
                    'role' => UserRole::ORANG_TUA,
                    'phone_number' => '081' . str_pad($index, 9, '0', STR_PAD_LEFT), // Dummy phone
                ]
            );

            // Create Parent Profile
            $parentProfile = StudentParent::firstOrCreate(
                ['user_id' => $parentUser->id],
                [
                    'phone_alternate' => '082' . str_pad($index, 9, '0', STR_PAD_LEFT), // Dummy alt phone
                    'occupation' => fake()->jobTitle(),
                ]
            );

            // Attach
            $relation = fake()->randomElement(['Ayah', 'Ibu']);
            $parentProfile->students()->attach($student->id, [
                'relation_type' => $relation,
                'is_guardian' => true
            ]);
        }

        $this->command->info('All students now have parents.');
    }
}
