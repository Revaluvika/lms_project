<?php

namespace App\Http\Controllers;

use App\Models\ClassSchedule;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Enums\UserRole;

class ClassScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('academic.schedule');
    }

    /**
     * Get Schedule Data (JSON)
     */
    public function getSchedule(Request $request)
    {
        $user = Auth::user();
        $schoolId = $user->school_id ?? $user->teacher?->school_id ?? $user->student?->school_id;

        if (!$schoolId) {
            return response()->json([]);
        }

        $query = ClassSchedule::with(['course.subject', 'course.classroom', 'course.teacher'])
            ->where('school_id', $schoolId);

        // Filter Logic
        $teacherId = $request->input('teacher_id');
        $academicYearId = $request->input('academic_year_id');
        $classroomId = $request->input('classroom_id');

        // Force filters for specific roles
        if ($user->role === UserRole::GURU && $user->teacher) {
            $teacherId = $user->teacher->id;
        }
        if ($user->role === UserRole::SISWA && $user->student) {
             // Students usually see their class schedule for the active year
             // Assuming we want to show them the current active year's schedule for their class
             // For now, let's respect the filters if passed, or default to their current class
             $classroomId = $user->student->classroom_id; 
             // Ideally we should also set academicYearId to current active one if not provided
        }

        // Logic Implementation
        if ($teacherId) {
            // If Teacher is selected (or is a Teacher), filter by Teacher
            // Optional: Also filter by Academic Year if provided
            $query->whereHas('course', function($q) use ($teacherId, $academicYearId) {
                $q->where('teacher_id', $teacherId);
                if ($academicYearId) {
                    $q->where('academic_year_id', $academicYearId);
                }
            });
        } elseif ($academicYearId && $classroomId) {
            // If No Teacher, MUST have BOTH Academic Year AND Classroom
            $query->whereHas('course', function($q) use ($academicYearId, $classroomId) {
                $q->where('academic_year_id', $academicYearId)
                  ->where('classroom_id', $classroomId);
            });
        } else {
            // Invalid Filter Combination -> Return Empty
            return response()->json([]);
        }

        $schedules = $query->get()->map(function ($schedule) {
            $daysMap = [
                'sunday' => 0,
                'monday' => 1,
                'tuesday' => 2,
                'wednesday' => 3,
                'thursday' => 4,
                'friday' => 5,
                'saturday' => 6,
            ];

            return [
                'id' => $schedule->id,
                'course_id' => $schedule->course_id,
                'title' => $schedule->course->subject->name . ' - ' . $schedule->course->classroom->name,
                'teacher' => $schedule->course->teacher->user->name ?? 'Unknown',
                // FullCalendar Recurring Events Format
                'daysOfWeek' => [$daysMap[$schedule->day_of_week] ?? null], 
                'startTime' => $schedule->start_time->format('H:i'),
                'endTime' => $schedule->end_time->format('H:i'),
                // Extra props
                'extendedProps' => [
                    'classroom' => $schedule->course->classroom->name,
                    'course_id' => $schedule->course_id
                ]
            ];
        });

        return response()->json($schedules);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $course = Course::findOrFail($request->course_id);
        $schoolId = $course->school_id;

        // Check Conflicts
        $conflict = ClassSchedule::checkConflict(
            $schoolId,
            $request->day_of_week,
            $request->start_time,
            $request->end_time,
            $course->teacher_id,
            $course->classroom_id
        );

        if ($conflict['conflict']) {
            return response()->json(['message' => $conflict['message']], 422);
        }

        $schedule = ClassSchedule::create([
            'school_id' => $schoolId,
            'course_id' => $request->course_id,
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return response()->json(['message' => 'Schedule created successfully', 'schedule' => $schedule]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassSchedule $classSchedule)
    {
        // Simple auth check
        if ($classSchedule->school_id !== Auth::user()->school_id) {
             abort(403);
        }

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $course = Course::findOrFail($request->course_id);

        // Check Conflicts (Ignoring current schedule)
        $conflict = ClassSchedule::checkConflict(
            $classSchedule->school_id,
            $request->day_of_week,
            $request->start_time,
            $request->end_time,
            $course->teacher_id,
            $course->classroom_id,
            $classSchedule->id
        );

        if ($conflict['conflict']) {
            return response()->json(['message' => $conflict['message']], 422);
        }

        $classSchedule->update([
            'course_id' => $request->course_id,
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return response()->json(['message' => 'Schedule updated successfully', 'schedule' => $classSchedule]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassSchedule $classSchedule)
    {
         if ($classSchedule->school_id !== Auth::user()->school_id) {
             abort(403);
         }
         
         $classSchedule->delete();
         return response()->json(['message' => 'Schedule deleted successfully']);
    }
}
