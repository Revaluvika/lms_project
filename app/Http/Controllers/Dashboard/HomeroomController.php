<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Classroom;
use App\Models\Student;

class HomeroomController extends Controller
{
    /**
     * Check if the authenticated teacher is a Homeroom Teacher.
     */
    private function getPewalian()
    {
        $teacher = Auth::user()->teacher;
        if (!$teacher) {
            return null;
        }

        // Find active academic year
        $activeYear = \App\Models\AcademicYear::where('is_active', true)->first();
        if (!$activeYear) {
            return null;
        }

        return Classroom::where('teacher_id', $teacher->id)
            ->where('academic_year_id', $activeYear->id)
            ->first();
    }

    public function index()
    {
        $classroom = $this->getPewalian();

        if (!$classroom) {
            return redirect()->route('dashboard.teacher')->with('error', 'Anda bukan Wali Kelas di tahun ajaran aktif ini.');
        }

        // Redirect to main teacher dashboard which now includes homeroom stats
        return redirect()->route('dashboard.teacher');
        // return view('pages.guru.homeroom.dashboard', compact('classroom'));
    }

    public function students()
    {
        $classroom = $this->getPewalian();
        if (!$classroom) {
            return redirect()->route('dashboard.teacher');
        }

        $students = Student::where('classroom_id', $classroom->id)
            ->with(['user', 'parents.user'])
            ->get();

        return view('pages.guru.homeroom.students.index', compact('classroom', 'students'));
    }

    public function showStudent($id)
    {
        $classroom = $this->getPewalian();
        if (!$classroom) {
            return redirect()->route('dashboard.teacher');
        }

        $student = Student::where('classroom_id', $classroom->id)
            ->where('id', $id)
            ->where('id', $id)
            ->with(['user', 'parents.user', 'attendances', 'reportCards'])
            ->firstOrFail();

        return view('pages.guru.homeroom.students.show', compact('classroom', 'student'));
    }

    public function promotion()
    {
        $classroom = $this->getPewalian();
        if (!$classroom) {
            return redirect()->route('dashboard.teacher');
        }

        $students = Student::where('classroom_id', $classroom->id)
            ->with(['user'])
            ->orderBy('id') // Consistent ordering
            ->get();

        // Get available classes for next grade level (optional, or just status)
        // Usually promotion is just setting status "Naik Kelas" or "Tinggal Kelas"
        // And then a separate admin process moves them, OR we move them immediately to a new class?
        // User request says: "memindahkan siswa ke tingkat berikutnya secara massal"

        // For simplicity: We will just set the status in student_term_records first?
        // OR directly change classroom_id?
        // Direct classroom_id change might be messy if the target class doesn't exist yet for next year.
        // Usually this is done at End of Year.

        // Let's implement a status update first: Naik / Tinggal / Lulus.
        // And optionally select a target class if available.

        // For now, let's look for classes in the SAME academic year? No, promotion is for NEXT academic year.
        // But usually we don't have next academic year active yet.

        // Let's just update `student_term_records.promotion_status` for the CURRENT academic year.
        // Then an Admin tool can process the actual movement.
        // OR the user wants to move them.

        // Let's check the request again: "memindahkan siswa ke tingkat berikutnya secara massal".
        // This implies action.

        // But without next academic year classes, where do they go?
        // Safe bet: Update `promotion_status` in `student_term_records`.

        // Let's fetch the term record for each student.
        $academicYearId = $classroom->academic_year_id;

        foreach ($students as $student) {
            $record = \App\Models\StudentTermRecord::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'academic_year_id' => $academicYearId,
                    'classroom_id' => $classroom->id
                ]
            );
            $student->promotion_status = $record->promotion_status ?? 'continuing';
        }

        return view('pages.guru.homeroom.students.promotion', compact('classroom', 'students'));
    }

    public function storePromotion(Request $request)
    {
        $request->validate([
            'promotions' => 'required|array',
            'promotions.*' => 'required|in:promoted,retained,graduated' // retained = tinggal kelas
        ]);

        $classroom = $this->getPewalian();
        if (!$classroom) {
            return back()->with('error', 'Akses ditolak.');
        }

        foreach ($request->promotions as $studentId => $status) {
            // Validate student belongs to this class
            $student = Student::where('id', $studentId)->where('classroom_id', $classroom->id)->first();
            if ($student) {
                \App\Models\StudentTermRecord::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'academic_year_id' => $classroom->academic_year_id,
                        'classroom_id' => $classroom->id
                    ],
                    [
                        'promotion_status' => $status
                    ]
                );
            }
        }

        return back()->with('success', 'Status kenaikan kelas berhasil disimpan.');
    }
}
