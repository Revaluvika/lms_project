<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ClassScheduleController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\DinasAdminController;
use App\Http\Controllers\Dashboard\DinasController;
use App\Http\Controllers\Dashboard\DinasReportController;
use App\Http\Controllers\Dashboard\DinasSchoolController;
use App\Http\Controllers\Dashboard\HeadmasterController;
use App\Http\Controllers\Dashboard\SchoolAdminController;
use App\Http\Controllers\Dashboard\StudentController as DashboardStudentController;
use App\Http\Controllers\Dashboard\StudentExamController as DashboardStudentExamController;
use App\Http\Controllers\Dashboard\TeacherController as DashboardTeacherController;
use App\Http\Controllers\Dashboard\TeacherExamController as DashboardTeacherExamController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\RaporPdfController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SchoolEventController;
use App\Http\Controllers\SchoolRegistrationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * ==================================================================================
 * PUBLIC ROUTES
 * Routes accessible without authentication.
 * ==================================================================================
 */
Route::get('/', [HomeController::class, 'index'])->name('home');

// School Registration (New School)
Route::get('/register-school', [SchoolRegistrationController::class, 'index'])->name('school.register');
Route::post('/register-school', [SchoolRegistrationController::class, 'store'])->name('school.register.store');

/**
 * ==================================================================================
 * AUTHENTICATION ROUTES
 * Login, Register, Logout, and Email Verification.
 * ==================================================================================
 */
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Email Verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard')->with('success', 'Email berhasil diverifikasi!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi telah dikirim ulang!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


/**
 * ==================================================================================
 * DASHBOARD GATEWAY
 * Redirects user to their specific dashboard based on role.
 * ==================================================================================
 */
Route::middleware(['auth', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');


/**
 * ==================================================================================
 * DINAS EDUCATION (Dinas & Admin Dinas)
 * ==================================================================================
 */
Route::middleware(['auth', 'verified', 'role:dinas'])->group(function () {
    Route::get('/dashboard/dinas', [DinasController::class, 'index'])->name('dashboard.dinas');
    Route::get('/dashboard/dinas/student-chart', [DinasController::class, 'getStudentGrowthData'])->name('dinas.student.chart');

    // School Reports Management
    Route::get('/dinas/reports', [DinasReportController::class, 'incoming'])->name('dinas.reports.incoming');
    Route::get('/dinas/reports/archive', [DinasReportController::class, 'archive'])->name('dinas.reports.archive');
    Route::get('/dinas/reports/{id}', [DinasReportController::class, 'show'])->name('dinas.reports.show');
    Route::post('/dinas/reports/{id}/review', [DinasReportController::class, 'review'])->name('dinas.reports.review');
});

Route::middleware(['auth', 'verified', 'role:admin_dinas'])->group(function () {
    Route::get('/dashboard/dinas-admin', [DinasAdminController::class, 'index'])->name('dashboard.dinas.admin');

    // School Management
    Route::get('/dinas/schools/pending', [DinasSchoolController::class, 'pending'])->name('dinas.schools.pending');
    Route::post('/dinas/schools/{id}/approve', [DinasSchoolController::class, 'approve'])->name('dinas.schools.approve');
    Route::post('/dinas/schools/{id}/reject', [DinasSchoolController::class, 'reject'])->name('dinas.schools.reject');
    Route::get('/dinas/schools/active', [DinasSchoolController::class, 'active'])->name('dinas.schools.active');
    Route::post('/dinas/schools/{id}/suspend', [DinasSchoolController::class, 'suspend'])->name('dinas.schools.suspend');
    Route::post('/dinas/schools/{id}/activate', [DinasSchoolController::class, 'activate'])->name('dinas.schools.activate');
    Route::post('/dinas/schools/{id}/reset-password', [DinasSchoolController::class, 'resetPassword'])->name('dinas.schools.reset-password');
});


/**
 * ==================================================================================
 * SCHOOL MANAGEMENT (Kepala Sekolah & Admin Sekolah)
 * ==================================================================================
 */
Route::middleware(['auth', 'verified', 'role:kepala_sekolah'])->group(function () {
    Route::get('/dashboard/headmaster', [HeadmasterController::class, 'index'])->name('dashboard.headmaster');
    Route::resource('school-reports', \App\Http\Controllers\Headmaster\SchoolReportController::class);

    // Jadwal Management (Kepala Sekolah Access)
    Route::post('/jadwal', [ScheduleController::class, 'store'])->name('jadwal.store');
    Route::post('/jadwal/{id}', [ScheduleController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/{id}', [ScheduleController::class, 'destroy'])->name('jadwal.delete');
});

Route::middleware(['auth', 'verified', 'role:admin_sekolah'])->group(function () {
    Route::get('/dashboard/school-admin', [SchoolAdminController::class, 'index'])->name('dashboard.school.admin');
    Route::post('/jadwal', [ScheduleController::class, 'store'])->name('jadwal.store'); // Shared with Headmaster
});

// Admin Sekolah Master Data
Route::middleware(['auth', 'verified', 'role:admin_sekolah'])->prefix('master')->name('master.')->group(function () {
    // Academic Data
    Route::resource('academic-years', AcademicYearController::class);
    Route::post('academic-years/{id}/toggle', [AcademicYearController::class, 'toggleActive'])->name('academic-years.toggle');
    Route::resource('subjects', SubjectController::class);
    Route::resource('classrooms', ClassroomController::class);
    Route::resource('courses', CourseController::class);

    // User Data Management
    Route::get('students/template', [StudentController::class, 'downloadTemplate'])->name('students.template');
    Route::post('students/import', [StudentController::class, 'import'])->name('students.import');
    Route::post('students/{id}/reset-password', [StudentController::class, 'resetPassword'])->name('students.reset-password');
    Route::post('students/{id}/mutation', [StudentController::class, 'mutation'])->name('students.mutation');
    Route::resource('students', StudentController::class);

    Route::get('teachers/template', [TeacherController::class, 'downloadTemplate'])->name('teachers.template');
    Route::post('teachers/import', [TeacherController::class, 'import'])->name('teachers.import');
    Route::post('teachers/{id}/reset-password', [TeacherController::class, 'resetPassword'])->name('teachers.reset-password');
    Route::resource('teachers', TeacherController::class);
});

// Admin School Configuration
Route::middleware(['auth', 'verified', 'role:admin_sekolah'])->prefix('school')->name('school.')->group(function () {
    Route::get('/grade-weights', [\App\Http\Controllers\Dashboard\School\GradeWeightController::class, 'index'])->name('grade-weights.index');
    Route::post('/grade-weights', [\App\Http\Controllers\Dashboard\School\GradeWeightController::class, 'store'])->name('grade-weights.store');
});


/**
 * ==================================================================================
 * TEACHER PORTAL
 * ==================================================================================
 */
Route::middleware(['auth', 'verified', 'role:guru'])->group(function () {
    Route::get('/dashboard/teacher', [DashboardTeacherController::class, 'index'])->name('dashboard.teacher');

    // Course Management
    Route::get('/teacher/courses', [DashboardTeacherController::class, 'myCourses'])->name('teacher.courses.index');
    Route::get('/teacher/courses/{id}', [DashboardTeacherController::class, 'show'])->name('teacher.courses.show');

    // Course Content (Materials, Assignments, Attendance)
    Route::post('/teacher/courses/{id}/materials', [DashboardTeacherController::class, 'storeMaterial'])->name('teacher.courses.materials.store');
    Route::put('/teacher/materials/{id}', [DashboardTeacherController::class, 'updateMaterial'])->name('teacher.materials.update');
    Route::delete('/teacher/materials/{id}', [DashboardTeacherController::class, 'destroyMaterial'])->name('teacher.materials.destroy');

    Route::post('/teacher/courses/{id}/assignments', [DashboardTeacherController::class, 'storeAssignment'])->name('teacher.courses.assignments.store');
    Route::put('/teacher/assignments/{id}', [DashboardTeacherController::class, 'updateAssignment'])->name('teacher.assignments.update');
    Route::get('/teacher/assignments/{id}', [DashboardTeacherController::class, 'showAssignment'])->name('teacher.assignments.show');
    Route::post('/teacher/assignments/{id}/grade', [DashboardTeacherController::class, 'gradeSubmission'])->name('teacher.assignments.grade');

    Route::post('/teacher/courses/{id}/attendance', [DashboardTeacherController::class, 'storeAttendance'])->name('teacher.courses.attendance.store');
    Route::get('/teacher/courses/{id}/attendance/{date}', [DashboardTeacherController::class, 'getAttendanceByDate'])->name('teacher.courses.attendance.show');

    // Exam Management
    Route::get('/teacher/courses/{courseId}/exams', [DashboardTeacherExamController::class, 'index'])->name('teacher.exams.index');
    Route::get('/teacher/courses/{courseId}/exams/create', [DashboardTeacherExamController::class, 'create'])->name('teacher.exams.create');
    Route::post('/teacher/courses/{courseId}/exams', [DashboardTeacherExamController::class, 'store'])->name('teacher.exams.store');
    Route::get('/teacher/exams/{id}/edit', [DashboardTeacherExamController::class, 'edit'])->name('teacher.exams.edit');
    Route::put('/teacher/exams/{id}', [DashboardTeacherExamController::class, 'update'])->name('teacher.exams.update');
    Route::delete('/teacher/exams/{id}', [DashboardTeacherExamController::class, 'destroy'])->name('teacher.exams.destroy');

    // Exam Questions
    Route::get('/teacher/exams/{id}/questions', [DashboardTeacherExamController::class, 'questions'])->name('teacher.exams.questions');
    Route::post('/teacher/exams/{id}/questions', [DashboardTeacherExamController::class, 'storeQuestion'])->name('teacher.exams.questions.store');
    Route::delete('/teacher/questions/{id}', [DashboardTeacherExamController::class, 'destroyQuestion'])->name('teacher.exams.questions.destroy');

    // Exam Grading
    Route::get('/teacher/exams/{id}/results', [DashboardTeacherExamController::class, 'examResults'])->name('teacher.exams.results');
    Route::get('/teacher/exams/{id}/review/{attemptId}', [DashboardTeacherExamController::class, 'reviewAttempt'])->name('teacher.exams.review');
    Route::post('/teacher/exams/{id}/grade/{attemptId}', [DashboardTeacherExamController::class, 'storeGrade'])->name('teacher.exams.grade');

    // Gradebook
    Route::get('/teacher/courses/{courseId}/gradebook', [\App\Http\Controllers\Dashboard\GradebookController::class, 'index'])->name('teacher.gradebook.index');
    Route::post('/teacher/courses/{courseId}/gradebook', [\App\Http\Controllers\Dashboard\GradebookController::class, 'store'])->name('teacher.gradebook.store');

    // Nilai (Legacy/Direct Input)
    Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
    Route::post('/nilai', [NilaiController::class, 'store'])->name('nilai.store');
});

// Homeroom Teacher (Wali Kelas) Routes
Route::middleware(['auth', 'verified', 'role:guru'])->prefix('homeroom')->name('homeroom.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Dashboard\HomeroomController::class, 'index'])->name('dashboard');
    Route::get('/students', [\App\Http\Controllers\Dashboard\HomeroomController::class, 'students'])->name('students.index');
    Route::get('/students/{id}', [\App\Http\Controllers\Dashboard\HomeroomController::class, 'showStudent'])->name('students.show');
    Route::get('/promotion', [\App\Http\Controllers\Dashboard\HomeroomController::class, 'promotion'])->name('promotion.index');
    Route::post('/promotion', [\App\Http\Controllers\Dashboard\HomeroomController::class, 'storePromotion'])->name('promotion.store');

    // Leger & Reports
    Route::get('/leger', [\App\Http\Controllers\Dashboard\HomeroomLegerController::class, 'index'])->name('leger.index');
    Route::get('/report', [\App\Http\Controllers\Dashboard\HomeroomReportController::class, 'index'])->name('report.index');
    Route::get('/report/{id}/edit', [\App\Http\Controllers\Dashboard\HomeroomReportController::class, 'edit'])->name('report.edit');
    Route::put('/report/{id}', [\App\Http\Controllers\Dashboard\HomeroomReportController::class, 'update'])->name('report.update');
    Route::get('/report/{id}/print', [\App\Http\Controllers\Dashboard\HomeroomReportController::class, 'print'])->name('report.print');
});


/**
 * ==================================================================================
 * STUDENT PORTAL
 * ==================================================================================
 */
Route::middleware(['auth', 'verified', 'role:siswa'])->group(function () {
    Route::get('/dashboard/student', [DashboardStudentController::class, 'index'])->name('dashboard.student');

    // Academic
    Route::get('/student/courses', [DashboardStudentController::class, 'courses'])->name('student.courses.index');
    Route::get('/student/courses/{id}', [DashboardStudentController::class, 'show'])->name('student.courses.show');
    Route::post('/student/materials/{id}/complete', [DashboardStudentController::class, 'markMaterialComplete'])->name('student.materials.complete');
    Route::get('/student/schedule', [DashboardStudentController::class, 'schedule'])->name('student.schedule.index');

    // Assignments
    Route::get('/student/assignments', [DashboardStudentController::class, 'assignments'])->name('student.assignments.index');
    Route::get('/student/assignments/{id}', [DashboardStudentController::class, 'showAssignment'])->name('student.assignments.show');
    Route::post('/student/assignments/{id}/submit', [DashboardStudentController::class, 'submitAssignment'])->name('student.assignments.submit');

    // Exams
    Route::get('/student/exams', [DashboardStudentExamController::class, 'index'])->name('student.exams.index');
    Route::get('/student/exams/{id}', [DashboardStudentExamController::class, 'show'])->name('student.exams.show');
    Route::post('/student/exams/{id}/start', [DashboardStudentExamController::class, 'start'])->name('student.exams.start');
    Route::get('/student/exams/{id}/take', [DashboardStudentExamController::class, 'take'])->name('student.exams.take');
    Route::post('/student/exams/{id}/submit', [DashboardStudentExamController::class, 'submit'])->name('student.exams.submit');
    Route::get('/student/exams/{id}/result', [DashboardStudentExamController::class, 'result'])->name('student.exams.result');

    // Profile & Grades
    Route::get('/student/profile', [DashboardStudentController::class, 'profile'])->name('student.profile.index');
    Route::get('/nilai-saya', [NilaiController::class, 'siswaNilai'])->name('nilai.siswa');
});


/**
 * ==================================================================================
 * PARENT PORTAL
 * ==================================================================================
 */
Route::middleware(['auth', 'verified', 'role:orang_tua'])->group(function () {
    Route::get('/dashboard/parent', [ParentController::class, 'index'])->name('dashboard.parent');
    Route::post('/parent/switch-child/{id}', [ParentController::class, 'switchChild'])->name('parent.switch-child');

    Route::get('/parent/attendance', [ParentController::class, 'attendance'])->name('parent.attendance');
    Route::get('/parent/grades', [ParentController::class, 'grades'])->name('parent.grades');
    Route::get('/parent/schedule', [ParentController::class, 'schedule'])->name('parent.schedule');
});


/**
 * ==================================================================================
 * SHARED FEATURES (Academic, Communication, Settings)
 * ==================================================================================
 */

// 1. Academic Calendar & Schedule Data (Shared across roles)
Route::middleware(['auth', 'verified'])->group(function () {
    // Academic Calendar
    Route::get('/academic/calendar', [SchoolEventController::class, 'index'])->name('academic.calendar.index');
    Route::get('/academic/calendar/events', [SchoolEventController::class, 'getEvents'])->name('academic.calendar.events');
    Route::resource('academic/events', SchoolEventController::class)->except(['create', 'edit', 'index', 'show']);

    // Schedule Data API
    Route::get('/academic/schedule', [ClassScheduleController::class, 'index'])->name('academic.schedule.index');
    Route::get('/academic/schedule/data', [ClassScheduleController::class, 'getSchedule'])->name('academic.schedule.data');
    Route::resource('academic/schedules', ClassScheduleController::class)->except(['create', 'edit', 'index', 'show']);

    // Time Settings
    Route::get('/academic/time-settings', [\App\Http\Controllers\SchoolTimeSettingController::class, 'index'])->name('academic.time-settings.index');
    Route::post('/academic/time-settings', [\App\Http\Controllers\SchoolTimeSettingController::class, 'store'])->name('academic.time-settings.store');
    Route::get('/academic/time-settings/data', [\App\Http\Controllers\SchoolTimeSettingController::class, 'getSettings'])->name('academic.time-settings.data');

    // Jadwal Umum (List)
    Route::get('/jadwal', [ScheduleController::class, 'index'])->name('jadwal.index');
});

// 2. Announcements & Forum
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');

    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
    Route::post('/forum/store', [ForumController::class, 'store'])->name('forum.store');
});

// 3. Chat System
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/chat', [ChatController::class, 'contacts'])->name('chat.index');
    Route::get('/chat/{id}', [ChatController::class, 'chat'])->name('chat.room');
    Route::post('/chat/{id}', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat-count', function () {
        $count = \App\Models\Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();
        return response()->json(['count' => $count]);
    })->name('chat.count');
});

// 4. Notifications
Route::middleware('auth')->get('/notifikasi', function () {
    return view('notifikasi.index'); // Placeholder view if not exists
})->name('notif.index');

Route::get('/notif/count', function () {
    return response()->json([
        'count' => \App\Models\Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count()
    ]);
})->name('notif.count');


// 5. Settings
Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.updateProfile');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.updatePassword');
});

// 6. Reports (PDF)
Route::middleware(['auth'])->group(function () {
    Route::get('/rapor', [\App\Http\Controllers\Dashboard\ReportCardController::class, 'index'])->name('rapor.index');
    Route::get('/rapor/pdf/{id}', [RaporPdfController::class, 'generate'])->name('rapor.pdf');
});

// 7. Superadmin (Removed)
