<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\ClassSchedule;
use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Get logged-in student's schedule.
     */
    public function schedule(Request $request)
    {
        $user = $request->user();
        $student = $user->student;

        if (!$student || !$student->classroom_id) {
            return response()->json(['message' => 'Student data not found or class not assigned'], 404);
        }

        $schedules = ClassSchedule::with(['course.subject', 'course.teacher.user', 'course.classroom'])
            ->whereHas('course', function ($q) use ($student) {
                $q->where('classroom_id', $student->classroom_id);
            })
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week');

        return response()->json([
            'data' => $schedules
        ]);
    }

    /**
     * Get logged-in student's assignments.
     */
    public function assignments(Request $request)
    {
        $user = $request->user();
        $student = $user->student;

        if (!$student || !$student->classroom_id) {
            return response()->json(['message' => 'Student data not found'], 404);
        }

        // Get assignments for the student's class
        // Assuming assignments are linked to a course, and courses are linked to a class? 
        // Or directly assignments linked to classroom.
        // Let's assume Assignment belongsTo Course, and Course belongsTo Classroom/Subject.
        // Simplified: Assignment linked to Course, Filter courses by student's classroom.

        // Alternative: assignment linked directly to classroom_id (common pattern)
        // Let's check the schema if needed. for now assuming assignments table has course_id

        $assignments = Assignment::with('course.subject', 'course.teacher.user')
            ->whereHas('course', function ($q) use ($student) {
                $q->where('classroom_id', $student->classroom_id);
            })
            ->orderBy('due_date', 'desc')
            ->paginate(15);

        return response()->json($assignments);
    }
}
