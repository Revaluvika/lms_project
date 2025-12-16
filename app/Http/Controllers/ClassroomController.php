<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\AcademicYear;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    public function index()
    {
        $schoolId = Auth::user()->school_id;
        
        $classrooms = Classroom::with(['academicYear', 'teacher', 'teacher.user'])
                        ->where('school_id', $schoolId)
                        ->orderBy('created_at', 'desc')
                        ->get();

        $academicYears = AcademicYear::where('school_id', $schoolId)
                            ->orderBy('created_at', 'desc')
                            ->get();

        $teachers = Teacher::with('user')
                        ->where('school_id', $schoolId)
                        ->get();

        return view('pages.school.admin.classrooms.index', compact('classrooms', 'academicYears', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'grade_level' => 'required|integer',
            'academic_year_id' => 'required|exists:academic_years,id',
            'teacher_id' => 'nullable|exists:teachers,id',
        ]);

        // Check if teacher is already a homeroom teacher in this academic year
        if ($request->teacher_id) {
            $existingAssignment = Classroom::where('school_id', Auth::user()->school_id)
                ->where('academic_year_id', $request->academic_year_id)
                ->where('teacher_id', $request->teacher_id)
                ->exists();

            if ($existingAssignment) {
                return redirect()->back()->withErrors(['teacher_id' => 'Guru ini sudah menjadi wali kelas di kelas lain pada tahun ajaran ini.'])->withInput();
            }
        }

        Classroom::create([
            'school_id' => Auth::user()->school_id,
            'academic_year_id' => $request->academic_year_id,
            'name' => $request->name,
            'grade_level' => $request->grade_level,
            'teacher_id' => $request->teacher_id,
        ]);

        return redirect()->back()->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'grade_level' => 'required|integer',
            'academic_year_id' => 'required|exists:academic_years,id',
            'teacher_id' => 'nullable|exists:teachers,id',
        ]);

        $classroom = Classroom::where('school_id', Auth::user()->school_id)->findOrFail($id);
        // Check for duplicate homeroom assignment, excluding current classroom
        if ($request->teacher_id) {
            $existingAssignment = Classroom::where('school_id', Auth::user()->school_id)
                ->where('academic_year_id', $request->academic_year_id)
                ->where('teacher_id', $request->teacher_id)
                ->where('id', '!=', $id)
                ->exists();

            if ($existingAssignment) {
                return redirect()->back()->withErrors(['teacher_id' => 'Guru ini sudah menjadi wali kelas di kelas lain pada tahun ajaran ini.'])->withInput();
            }
        }

        $classroom->update([
            'academic_year_id' => $request->academic_year_id,
            'name' => $request->name,
            'grade_level' => $request->grade_level,
            'teacher_id' => $request->teacher_id,
        ]);

        return redirect()->back()->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $classroom = Classroom::where('school_id', Auth::user()->school_id)->findOrFail($id);
        
        // Optional: Data integrity checks could be added here
        
        $classroom->delete();
        return redirect()->back()->with('success', 'Kelas berhasil dihapus.');
    }
}
