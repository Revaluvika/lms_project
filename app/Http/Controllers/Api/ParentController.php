<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\Attendance;
use App\Models\ClassSchedule;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{
    /**
     * Get list of children linked to the parent.
     */
    public function children(Request $request)
    {
        $user = $request->user();
        $parent = $user->studentParent;

        if (!$parent) {
            return response()->json(['data' => []]);
        }

        // Eager load user data for children
        $children = $parent->students()->with('user')->get();

        return response()->json([
            'data' => $children
        ]);
    }

    /**
     * Get attendance for a specific child.
     */
    public function attendance(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id'
        ]);

        $attendances = Attendance::with(['course.subject', 'course.classroom'])
            ->where('student_id', $request->student_id)
            ->orderBy('date', 'desc')
            ->paginate(20);

        return response()->json($attendances);
    }

    /**
     * Get schedule for a specific child.
     */
    public function schedule(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id'
        ]);

        $student = Student::find($request->student_id);

        if (!$student->classroom_id) {
            return response()->json(['message' => 'Student not assigned to a class'], 404);
        }

        $schedules = ClassSchedule::with(['course.subject', 'course.teacher.user', 'course.classroom'])
            ->whereHas('course', function ($q) use ($student) {
                $q->where('classroom_id', $student->classroom_id);
            })
            ->orderBy('day_of_week') // 1=Monday
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week');

        return response()->json([
            'data' => $schedules
        ]);
    }

    /**
     * Get grades for a specific child.
     */
    public function grades(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id'
        ]);

        // Belum ada model 'Grade' yang fix di summary, kita asumsikan pakai model 'Score' atau 'AssignmentSubmission' yang dinilai
        // Untuk MVP kita return data dummy atau kosong dulu sampai skema nilai fix
        // Atau check model ExamResult / AssignmentSubmission

        // Placeholder implementation
        return response()->json([
            'message' => 'Feature coming soon',
            'data' => []
        ]);
    }
}
