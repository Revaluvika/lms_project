<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Assignment;
use App\Models\Exam;
use App\Models\StudentParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ParentController extends Controller
{
    /**
     * Display the parent dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $parentProfile = $user->studentParent;

        if (!$parentProfile) {
            // Should theoretically be handled by middleware or registration
            return redirect()->route('home')->with('error', 'Profil Orang Tua tidak ditemukan.');
        }

        // Get all children linked to this parent
        $children = $parentProfile->students;

        if ($children->isEmpty()) {
            return view('pages.parent.dashboard_empty'); // Create a simple view for "No Children Linked"
        }

        // Determine Active Child
        $activeChildId = Session::get('parent_active_child_id');

        // Validation: Verify the session ID actually belongs to this parent
        $activeChild = $children->find($activeChildId);

        if (!$activeChild) {
            // Default to the first child if session is empty or invalid
            $activeChild = $children->first();
            Session::put('parent_active_child_id', $activeChild->id);
        }

        // Fetch Data for the Active Child
        $data = $this->getChildStats($activeChild);

        return view('pages.parent.dashboard', array_merge([
            'children' => $children,
            'activeChild' => $activeChild
        ], $data));
    }

    /**
     * Switch the active child context.
     */
    public function switchChild(Request $request, $id)
    {
        $user = Auth::user();
        $parentProfile = $user->studentParent;

        // Verify ownership
        $child = $parentProfile->students()->where('students.id', $id)->first();

        if ($child) {
            Session::put('parent_active_child_id', $child->id);
            return redirect()->back()->with('success', 'Berhasil beralih ke profil ' . $child->nama);
        }

        return redirect()->back()->with('error', 'Siswa tidak ditemukan dalam daftar anak Anda.');
    }

    /**
     * Helper to get stats for a specific child.
     */
    private function getChildStats(Student $student)
    {
        // 1. Today's Attendance
        $attendanceToday = Attendance::where('student_id', $student->id)
            ->where('date', now()->toDateString())
            ->first();

        // 2. Pending Assignments (Due date >= now, and no submission)
        // Note: Logic simplified. Ideally check `AssignmentSubmission`.
        $pendingAssignments = Assignment::whereHas('course', function ($q) use ($student) {
            $q->where('classroom_id', $student->classroom_id);
        })
            ->where('due_date', '>=', now())
            ->whereDoesntHave('submissions', function ($q) use ($student) {
                $q->where('student_id', $student->id);
            })
            ->orderBy('due_date', 'asc')
            ->take(5)
            ->get();

        // 3. Underlying Count of Assignments
        $pendingAssignmentsCount = Assignment::whereHas('course', function ($q) use ($student) {
            $q->where('classroom_id', $student->classroom_id);
        })
            ->where('due_date', '>=', now())
            ->whereDoesntHave('submissions', function ($q) use ($student) {
                $q->where('student_id', $student->id);
            })
            ->count();

        // 4. Next Exam
        $nextExam = Exam::whereHas('course', function ($q) use ($student) {
            $q->where('classroom_id', $student->classroom_id);
        })
            ->where('start_time', '>=', now())
            ->orderBy('start_time', 'asc')
            ->first();

        return compact('attendanceToday', 'pendingAssignments', 'pendingAssignmentsCount', 'nextExam');
    }

    // Redirect the old index method to dashboard for backward compatibility or route fix
    public function index()
    {
        return $this->dashboard();
    }

    /**
     * Show detailed attendance history.
     */
    public function attendance()
    {
        $data = $this->getCommonData();
        if (!$data)
            return redirect()->route('parent.dashboard');

        $activeChild = $data['activeChild'];

        // Fetch attendance grouped by month/date or just paginated
        $attendances = Attendance::where('student_id', $activeChild->id)
            ->with(['course.subject']) // Assuming attendance is linked to course
            ->orderBy('date', 'desc')
            ->paginate(20);

        // Stats Summary
        $stats = [
            'present' => Attendance::where('student_id', $activeChild->id)->where('status', 'present')->count(),
            'sick' => Attendance::where('student_id', $activeChild->id)->where('status', 'sick')->count(),
            'permission' => Attendance::where('student_id', $activeChild->id)->where('status', 'permission')->count(),
            'absent' => Attendance::where('student_id', $activeChild->id)->where('status', 'absent')->count(),
        ];

        return view('pages.parent.attendance', array_merge($data, compact('attendances', 'stats')));
    }

    /**
     * Show grade report (assignments, exams, report cards).
     */
    public function grades()
    {
        $data = $this->getCommonData();
        if (!$data)
            return redirect()->route('parent.dashboard');

        $activeChild = $data['activeChild'];

        // 1. Term/Report Cards
        // Assuming ReportCard model exists and linked
        $reportCards = \App\Models\ReportCard::where('student_id', $activeChild->id)
            ->with(['academicYear'])
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Recent Exam Results
        // Assuming ExamAttempt links to student
        $examResults = \App\Models\ExamAttempt::where('student_id', $activeChild->id)
            ->with(['exam.course.subject'])
            ->orderBy('finished_at', 'desc')
            ->limit(10)
            ->get();

        return view('pages.parent.grades', array_merge($data, compact('reportCards', 'examResults')));
    }

    /**
     * Show class schedule.
     */
    public function schedule()
    {
        $data = $this->getCommonData();
        if (!$data)
            return redirect()->route('parent.dashboard');

        $activeChild = $data['activeChild'];

        // Fetch Weekly Schedule
        // Assuming ClassSchedule model exists
        // Need to join with courses -> classrooms to filter by student's classroom
        $schedules = \App\Models\ClassSchedule::whereHas('course', function ($q) use ($activeChild) {
            $q->where('classroom_id', $activeChild->classroom_id);
        })
            ->with(['course.subject', 'course.teacher'])
            ->orderBy('day_of_week') // Enum order might need custom sort
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week'); // Group by day (mon, tue, etc.)schedules);

        return view('pages.parent.schedule', array_merge($data, compact('schedules')));
    }

    /**
     * Helper to get common data (user, children, active child).
     * Refactored from dashboard() to avoid code duplication.
     */
    private function getCommonData()
    {
        $user = Auth::user();
        $parentProfile = $user->studentParent;

        if (!$parentProfile)
            return null;

        $children = $parentProfile->students;
        if ($children->isEmpty())
            return null;

        $activeChildId = Session::get('parent_active_child_id');
        $activeChild = $children->find($activeChildId);

        if (!$activeChild) {
            $activeChild = $children->first();
            Session::put('parent_active_child_id', $activeChild->id);
        }

        return compact('children', 'activeChild');
    }
}
