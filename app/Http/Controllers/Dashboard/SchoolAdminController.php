<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchoolAdminController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $schoolId = $user->school_id;

        $totalStudents = \App\Models\Student::where('school_id', $schoolId)->count();
        $totalTeachers = \App\Models\Teacher::where('school_id', $schoolId)->count();
        $totalClasses = \App\Models\Classroom::where('school_id', $schoolId)->count();
        $activeAcademicYear = \App\Models\AcademicYear::where('school_id', $schoolId)
                                ->where('is_active', true)
                                ->first();

        // Calculate completeness (Example logic)
        $studentDataProgress = $totalStudents > 0 ? 80 : 0; // Placeholder logic
        $scheduleCreated = false; // Placeholder as Schedule model relation is unclear

        return view('dashboard.school.admin', compact(
            'totalStudents', 
            'totalTeachers', 
            'totalClasses', 
            'activeAcademicYear',
            'studentDataProgress'
        ));
    }
}
