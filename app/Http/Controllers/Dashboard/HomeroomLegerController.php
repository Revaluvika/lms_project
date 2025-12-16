<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Subject;
use App\Models\ReportCard;

class HomeroomLegerController extends Controller
{
    private function getPewalian()
    {
        $teacher = Auth::user()->teacher;
        if (!$teacher)
            return null;

        $activeYear = \App\Models\AcademicYear::where('is_active', true)->first();
        if (!$activeYear)
            return null;

        return Classroom::where('teacher_id', $teacher->id)
            ->where('academic_year_id', $activeYear->id)
            ->first();
    }

    public function index()
    {
        $classroom = $this->getPewalian();
        if (!$classroom) {
            return redirect()->route('dashboard.teacher');
        }

        // 1. Get all students in class
        $students = Student::where('classroom_id', $classroom->id)
            ->orderBy('user_id')
            ->with('user')
            ->get();

        // 2. Get all subjects for this school (or specific to grade level if we had that mapping, assuming all subjects for now)
        // Ideally we should get subjects that are actually taught in this class?
        // We can find subjects via `courses` where `classroom_id` matches.
        $subjects = Subject::whereIn('id', function ($query) use ($classroom) {
            $query->select('subject_id')
                ->from('courses')
                ->where('classroom_id', $classroom->id);
        })->get();

        // 3. Get all report cards for these students in this academic year
        $reportCards = ReportCard::where('academic_year_id', $classroom->academic_year_id)
            ->whereIn('student_id', $students->pluck('id'))
            ->get();

        // 4. Map grades for view: [student_id][subject_id] => grade
        $grades = [];
        foreach ($reportCards as $rc) {
            $grades[$rc->student_id][$rc->subject_id] = [
                'final_grade' => $rc->final_grade,
                'predicate' => $rc->predicate
            ];
        }

        return view('pages.guru.homeroom.leger.index', compact('classroom', 'students', 'subjects', 'grades'));
    }
}
