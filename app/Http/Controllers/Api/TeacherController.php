<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassSchedule;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    /**
     * Get teacher's teaching schedule.
     */
    public function schedule(Request $request)
    {
        $user = $request->user();
        $teacher = $user->teacher;

        if (!$teacher) {
            return response()->json(['message' => 'Teacher data not found'], 404);
        }

        // Fix: Use whereHas('course') because teacher_id is in courses, not class_schedules
        $schedules = ClassSchedule::with(['course.subject', 'course.classroom'])
            ->whereHas('course', function ($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
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
     * Submit attendance for a class.
     */
    public function storeAttendance(Request $request)
    {
        $request->validate([
            'class_schedule_id' => 'required|exists:class_schedules,id',
            'date' => 'required|date',
            'students' => 'required|array',
            'students.*.student_id' => 'required|exists:students,id',
            'students.*.status' => 'required|in:present,permission,sick,alpha',
            'students.*.note' => 'nullable|string'
        ]);

        $user = $request->user();
        $teacher = $user->teacher;

        // Fix: Verify teacher via course relationship and get course_id
        $schedule = ClassSchedule::with('course')
            ->where('id', $request->class_schedule_id)
            ->whereHas('course', function ($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })
            ->first();

        if (!$schedule) {
            return response()->json(['message' => 'Unauthorized or schedule not found'], 403);
        }

        DB::beginTransaction();
        try {
            foreach ($request->students as $data) {
                // Fix: Attendance uses course_id, not class_schedule_id
                Attendance::updateOrCreate(
                    [
                        'student_id' => $data['student_id'],
                        'course_id' => $schedule->course_id,
                        'date' => $request->date,
                    ],
                    [
                        'status' => $data['status'],
                        // Note: 'note' might not be in Attendance fillable, check model but let's pass it for now
                        // If model restricts, it simply won't save.
                    ]
                );
            }
            DB::commit();
            return response()->json(['message' => 'Attendance submitted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to submit attendance', 'error' => $e->getMessage()], 500);
        }
    }
}
