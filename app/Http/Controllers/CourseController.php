<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with(['academicYear', 'classroom', 'subject', 'teacher.user'])
            ->where('school_id', Auth::user()->school_id)
            ->latest()
            ->paginate(10);

        return view('master.courses.index', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        // Optional: Check if same subject is already assigned to same class in same year?
        // For now, allow multiple (e.g. Maths A and Maths B) but maybe redundant. 
        // Let's stick to basic creation for now.

        Course::create([
            'school_id' => Auth::user()->school_id,
            'academic_year_id' => $request->academic_year_id,
            'classroom_id' => $request->classroom_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
        ]);

        return redirect()->route('master.courses.index')->with('success', 'Pengajaran berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        if ($course->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        $course->update([
            'academic_year_id' => $request->academic_year_id,
            'classroom_id' => $request->classroom_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
        ]);

        return redirect()->route('master.courses.index')->with('success', 'Pengajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        if ($course->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $course->delete();

        return redirect()->route('master.courses.index')->with('success', 'Pengajaran berhasil dihapus.');
    }
}
