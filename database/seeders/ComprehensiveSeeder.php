<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\AcademicYear;
use App\Models\SchoolTimeSetting;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Course;
use App\Models\ClassSchedule;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamAttempt;
use App\Models\ExamAnswer;
use App\Models\CourseMaterial;
use App\Models\CourseMaterialCompletion;
use App\Models\Attendance;
use App\Enums\UserRole;
use App\Enums\SchoolStatus;
use Illuminate\Support\Facades\Hash;

class ComprehensiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create School
        $school = School::factory()->create([
            'name' => 'SMA Negeri 1 Digital (Seeded)',
            'status' => SchoolStatus::ACTIVE,
        ]);

        $this->command->info('School created: ' . $school->name);

        // 2. Create School Time Settings
        // Standard Monday-Friday schedule
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        foreach ($days as $day) {
            SchoolTimeSetting::factory()->count(4)->sequence(
                ['period_number' => 1, 'start_time' => '07:00:00', 'end_time' => '07:45:00'],
                ['period_number' => 2, 'start_time' => '07:45:00', 'end_time' => '08:30:00'],
                // Break
                ['period_number' => null, 'label' => 'Istirahat', 'start_time' => '08:30:00', 'end_time' => '08:45:00'],
                ['period_number' => 3, 'start_time' => '08:45:00', 'end_time' => '09:30:00'],
            )->create([
                        'school_id' => $school->id,
                        'day_of_week' => $day,
                    ]);
        }

        // 3. Create Academic Year
        $academicYear = AcademicYear::factory()->create([
            'school_id' => $school->id,
            'is_active' => true,
        ]);

        // 3.1 Create Grade Weights
        \App\Models\GradeWeights::create(['school_id' => $school->id, 'category' => 'daily', 'weight' => 2]);
        \App\Models\GradeWeights::create(['school_id' => $school->id, 'category' => 'mid_term', 'weight' => 1]);
        \App\Models\GradeWeights::create(['school_id' => $school->id, 'category' => 'final_term', 'weight' => 1]);

        // 3.2 Create School Events
        \App\Models\SchoolEvent::factory()->count(3)->create(['school_id' => $school->id]);

        // 4. Create Users (Kepsek, Admin Sekolah, Dinas, Admin Dinas)

        // Kepsek
        User::factory()->create([
            'name' => 'Kepala Sekolah Seed',
            'email' => 'kepsek@seed.test',
            'password' => Hash::make('password'),
            'role' => UserRole::KEPALA_SEKOLAH,
            'school_id' => $school->id,
        ]);

        // Admin Sekolah
        User::factory()->create([
            'name' => 'Admin Sekolah Seed',
            'email' => 'admin.sekolah@seed.test',
            'password' => Hash::make('password'),
            'role' => UserRole::ADMIN_SEKOLAH,
            'school_id' => $school->id,
        ]);

        // Dinas
        User::factory()->create([
            'name' => 'Dinas Pendidikan',
            'email' => 'dinas@seed.test',
            'password' => Hash::make('password'),
            'role' => UserRole::DINAS,
            'school_id' => null, // Dinas is usually global or regional, not bound to one school
        ]);

        // Admin Dinas
        User::factory()->create([
            'name' => 'Admin Dinas',
            'email' => 'admin.dinas@seed.test',
            'password' => Hash::make('password'),
            'role' => UserRole::ADMIN_DINAS,
            'school_id' => null,
        ]);

        // 5. Create Teachers & Subjects
        $subjects = Subject::factory()->count(5)->create(['school_id' => $school->id]);

        $teachers = collect();
        foreach ($subjects as $subject) {
            $teacherUser = User::factory()->create([
                'name' => 'Guru ' . $subject->name,
                'email' => 'guru.' . strtolower(str_replace(' ', '', $subject->name)) . '@seed.test',
                'password' => Hash::make('password'),
                'role' => UserRole::GURU,
                'school_id' => $school->id,
            ]);

            $teacher = Teacher::factory()->create([
                'user_id' => $teacherUser->id,
                'school_id' => $school->id,
                'specialization' => $subject->name,
            ]);
            $teachers->push($teacher);
        }

        // 6. Create Classrooms & Students
        $classrooms = Classroom::factory()->count(3)->create([
            'school_id' => $school->id,
            'academic_year_id' => $academicYear->id,
        ]);

        foreach ($classrooms as $classroom) {
            // Create 10 students per class
            $studentUsers = User::factory()->count(10)->create([
                'password' => Hash::make('password'),
                'role' => UserRole::SISWA,
                'school_id' => $school->id,
            ]);

            foreach ($studentUsers as $key => $sUser) {
                // Update email to be predictable for testing
                $sUser->update(['email' => "siswa{$classroom->id}.{$key}@seed.test"]);

                $student = Student::factory()->create([
                    'user_id' => $sUser->id,
                    'school_id' => $school->id,
                    'classroom_id' => $classroom->id,
                ]);

                // Create Term Record
                \App\Models\StudentTermRecord::create([
                    'student_id' => $student->id,
                    'academic_year_id' => $academicYear->id,
                    'classroom_id' => $classroom->id,
                    'promotion_status' => 'continuing',
                ]);
            }
        }

        // 7. Create Courses & Schedules & Activities
        foreach ($classrooms as $classroom) {
            foreach ($subjects as $index => $subject) {
                $teacher = $teachers[$index] ?? $teachers->first();

                $course = Course::factory()->create([
                    'school_id' => $school->id,
                    'academic_year_id' => $academicYear->id,
                    'classroom_id' => $classroom->id,
                    'subject_id' => $subject->id,
                    'teacher_id' => $teacher->id,
                ]);

                // Schedules
                ClassSchedule::factory()->count(2)->create([
                    'school_id' => $school->id,
                    'course_id' => $course->id,
                ]);

                // Materials
                $materials = CourseMaterial::factory()->count(3)->create([
                    'course_id' => $course->id,
                ]);

                // Assignments
                $assignments = Assignment::factory()->count(2)->create([
                    'course_id' => $course->id,
                ]);

                // Exams
                $exams = Exam::factory()->count(1)->create([
                    'course_id' => $course->id,
                ]);

                foreach ($exams as $exam) {
                    ExamQuestion::factory()->count(5)->create([
                        'exam_id' => $exam->id,
                    ]);

                    // Create Exam Attempts
                    $randomStudents = Student::where('classroom_id', $classroom->id)->inRandomOrder()->take(5)->get();
                    foreach ($randomStudents as $rs) {
                        $attempt = ExamAttempt::factory()->create([
                            'exam_id' => $exam->id,
                            'student_id' => $rs->id,
                        ]);

                        // Answers
                        foreach ($exam->questions as $question) {
                            ExamAnswer::factory()->create([
                                'exam_attempt_id' => $attempt->id,
                                'exam_question_id' => $question->id,
                            ]);
                        }
                    }
                }

                // Create Submissions
                foreach ($assignments as $assignment) {
                    $randomStudents = Student::where('classroom_id', $classroom->id)->inRandomOrder()->take(5)->get();
                    foreach ($randomStudents as $rs) {
                        AssignmentSubmission::factory()->create([
                            'assignment_id' => $assignment->id,
                            'student_id' => $rs->id,
                        ]);
                    }
                }

                // Create Attendance
                $randomStudents = Student::where('classroom_id', $classroom->id)->get();
                foreach ($randomStudents as $rs) {
                    Attendance::factory()->count(2)->create([
                        'course_id' => $course->id,
                        'student_id' => $rs->id,
                    ]);

                    // Material Completion
                    foreach ($materials as $material) {
                        // 70% chance completion
                        if (rand(0, 10) > 3) {
                            CourseMaterialCompletion::factory()->create([
                                'student_id' => $rs->id,
                                'course_material_id' => $material->id,
                            ]);
                        }
                    }
                }
            }

            // Generate Report Cards for this classroom's students
            $students = Student::where('classroom_id', $classroom->id)->get();
            foreach ($students as $student) {
                // For each subject, create a report card
                foreach ($subjects as $subject) {
                    // Find teacher for this subject in this class (via Course)
                    $course = Course::where('classroom_id', $classroom->id)
                        ->where('subject_id', $subject->id)
                        ->first();

                    if ($course) {
                        \App\Models\ReportCard::factory()->create([
                            'student_id' => $student->id,
                            'teacher_id' => $course->teacher_id,
                            'subject_id' => $subject->id,
                            'academic_year_id' => $academicYear->id,
                        ]);
                    }
                }

                // Add Extracurriculars to the Term Record (which was created earlier)
                $termRecord = \App\Models\StudentTermRecord::where('student_id', $student->id)
                    ->where('academic_year_id', $academicYear->id)
                    ->first();
                if ($termRecord) {
                    \App\Models\ExtracurricularRecord::factory()->count(rand(0, 2))->create([
                        'student_term_record_id' => $termRecord->id
                    ]);
                }
            }
        }

        // Create School Reports
        \App\Models\SchoolReport::factory()->count(5)->create([
            'school_id' => $school->id,
            'academic_year_id' => $academicYear->id,
            'uploaded_by' => $school->users()->where('role', UserRole::ADMIN_SEKOLAH)->first()->id,
        ]);

        $this->command->info('Comprehensive Seeding Completed!');

        // 8. Create Parents
        $this->call(ParentSeeder::class);
    }
}
