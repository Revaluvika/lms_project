<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\StudentTermRecord;
use App\Models\ExtracurricularRecord;
use Barryvdh\DomPDF\Facade\Pdf; // Assuming dompdf is installed, we'll check later

class HomeroomReportController extends Controller
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

        $students = Student::where('classroom_id', $classroom->id)
            ->with([
                'user',
                'studentTermRecords' => function ($q) use ($classroom) {
                    $q->where('academic_year_id', $classroom->academic_year_id);
                }
            ])
            ->get();

        return view('pages.guru.homeroom.report.index', compact('classroom', 'students'));
    }

    public function edit($id)
    {
        $classroom = $this->getPewalian();
        if (!$classroom) {
            return redirect()->route('dashboard.teacher');
        }

        $student = Student::where('classroom_id', $classroom->id)
            ->where('id', $id)
            ->with(['user'])
            ->firstOrFail();

        $termRecord = StudentTermRecord::firstOrCreate([
            'student_id' => $student->id,
            'academic_year_id' => $classroom->academic_year_id,
            'classroom_id' => $classroom->id
        ]);

        $ekskul = ExtracurricularRecord::where('student_term_record_id', $termRecord->id)->get();

        return view('pages.guru.homeroom.report.edit', compact('classroom', 'student', 'termRecord', 'ekskul'));
    }

    public function update(Request $request, $id)
    {
        $classroom = $this->getPewalian();
        if (!$classroom) {
            return redirect()->route('dashboard.teacher');
        }

        $student = Student::where('classroom_id', $classroom->id)->findOrFail($id);

        // Update Term Record (Attendance + Notes)
        $termRecord = StudentTermRecord::updateOrCreate(
            [
                'student_id' => $student->id,
                'academic_year_id' => $classroom->academic_year_id,
                'classroom_id' => $classroom->id
            ],
            [
                'sick_count' => $request->sick_count,
                'permission_count' => $request->permission_count,
                'absentee_count' => $request->absentee_count,
                'notes' => $request->notes
            ]
        );

        // Update Ekskul
        // Delete existing and re-insert (easiest for dynamic lists)
        ExtracurricularRecord::where('student_term_record_id', $termRecord->id)->delete();

        if ($request->has('ekskul_name')) {
            foreach ($request->ekskul_name as $key => $name) {
                if (!empty($name)) {
                    ExtracurricularRecord::create([
                        'student_term_record_id' => $termRecord->id,
                        'activity_name' => $name,
                        'grade' => $request->ekskul_grade[$key] ?? '-',
                        'description' => $request->ekskul_description[$key] ?? '-'
                    ]);
                }
            }
        }

        return redirect()->route('homeroom.report.index')->with('success', 'Data rapor siswa ' . $student->user->name . ' berhasil disimpan.');
    }

    public function print($id)
    {
        $classroom = $this->getPewalian();
        if (!$classroom) {
            return redirect()->route('dashboard.teacher');
        }

        $student = Student::where('classroom_id', $classroom->id)
            ->where('id', $id)
            ->with(['user'])
            ->firstOrFail();

        $termRecord = StudentTermRecord::where('student_id', $student->id)
            ->where('academic_year_id', $classroom->academic_year_id)
            ->first();

        $ekskul = [];
        if ($termRecord) {
            $ekskul = ExtracurricularRecord::where('student_term_record_id', $termRecord->id)->get();
        }

        // Get Grades
        $grades = \App\Models\ReportCard::where('academic_year_id', $classroom->academic_year_id)
            ->where('student_id', $student->id)
            ->with('subject')
            ->get();

        return view('pages.guru.homeroom.report.print', compact('classroom', 'student', 'termRecord', 'ekskul', 'grades'));
    }
}
