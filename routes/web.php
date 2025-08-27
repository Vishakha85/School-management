<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomPasswordResetController;
use App\Http\Controllers\Auth\EmailVerificationResetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentStatusController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AddstdController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherAssignmentController;
use App\Http\Controllers\CourseController;
use App\Models\Email;
use App\Models\StudentAssignment;
use App\Models\Student;
use App\Models\FeeStructure;
use App\Models\StudentFeeStatus;
use App\Http\Middleware\ImpersonateMiddleware;
use Illuminate\Support\Facades\DB;

Route::get('/choose-user', function () { return view('choose_user');})->name('choose_user');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/', [AuthController::class, 'redirectToLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logoutstd', [AuthController::class, 'logout']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/logoutteacher', [AuthController::class, 'logout']);

//students 
Route::middleware(['auth', 'impersonate'])->group(function () {
    Route::get('/students/studentdash', [StudentDashboardController::class, 'index'])->name('student.studentdash');
    Route::get('/students/{id}/fee-structure', [StudentDashboardController::class, 'showFeeStructure']);
    Route::get('/students/{id}/assignments', function ($id) {
        $student = \App\Models\Student::find($id);
        $courseId = $student ? $student->class : null;
        $assignments = collect();
        $uploadedAssignmentsArr = [];
        if ($courseId) {
            $assignments = DB::table('assignments')->where('course_id', $courseId)->get();
            $assignmentIds = $assignments->pluck('id')->toArray();
            $uploadedAssignments = \App\Models\StudentAssignment::where('std_id', $id)
                ->whereIn('assignment_id', $assignmentIds)
                ->pluck('assignment_id')
                ->toArray();
                $uploadedAssignmentsArr = array_fill_keys($uploadedAssignments, true);
        }
        return view('students.assignments', compact('student', 'courseId', 'assignments', 'uploadedAssignmentsArr'));
    })->name('students.assignments');
    Route::post('/students/{id}/assignments/upload', [AssignmentController::class, 'upload'])->name('assignments.upload');
    Route::get('/students/{studentId}/assignments/{assignmentId}/edit', [AssignmentController::class, 'editAssignment'])->name('students.assignments_edit');
    Route::post('/students/{studentId}/assignments/{assignmentId}/update', [AssignmentController::class, 'updateAssignment'])->name('students.assignments_update');

    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/login-as-teacher/{id}', [AuthController::class, 'loginAsTeacher'])->name('admin.loginAsTeacher');
    Route::get('/login-as-student/{id}', [AuthController::class, 'loginAsStudent'])->name('admin.loginAsStudent');
    Route::get('/admin/teachers', [TeacherController::class, 'index'])->name('admin.teachers.index');
    Route::get('/admin/teachers/{id}/assign-students', [TeacherController::class, 'assignStudents'])->name('admin.teachers.assignStudents');
    Route::get('/admin/emails', function () {
        $emails = Email::orderBy('created_at')->get();
        return view('admin.emails', compact('emails'));
    })->name('admin.emails');
    Route::get('/admin/students/{id}/fee-structure', function($id) {
        $student = Student::findOrFail($id);
        $feeStructure = FeeStructure::where('course_id', $student->class)->first();
        $feeStatus = StudentFeeStatus::where('student_id', $student->id)->value('fee_status') ?? 'Pending';
        $className = DB::table('classes')->where('id', $student->class)->value('class');
        return view('admin.student_fee_structure', compact('student', 'feeStructure', 'feeStatus', 'className'));
    });
    Route::get('/admin/assignments-classes', function() {
        return view('admin.assignments-classes');
    })->name('admin.assignments.classes');
    Route::get('/admin/assignments/btech', [AssignmentController::class, 'selectBtech'])->name('admin.assignments.btech');
    Route::get('/admin/assignments/add/{course_id}', [AssignmentController::class, 'addAssignmentPage'])->name('admin.assignments.add');
    Route::post('/admin/assignments/add/{course_id}', [AssignmentController::class, 'storeAssignment'])->name('admin.assignments.store');
    Route::get('/admin/assignments/mtech', [AssignmentController::class, 'selectMtech'])->name('admin.assignments.mtech');
    Route::get('/admin/assignments/mca', [AssignmentController::class, 'selectMca'])->name('admin.assignments.mca');
    Route::get('/admin/assignments/bca', [AssignmentController::class, 'selectBca'])->name('admin.assignments.bca');
    Route::get('/admin/assignments/bcom', [AssignmentController::class, 'selectBcom'])->name('admin.assignments.bcom');
    Route::get('/admin/assignments/phd', [AssignmentController::class, 'selectPhd'])->name('admin.assignments.phd');
    Route::get('/admin/view-assignments', function() {
        $studentAssignments = StudentAssignment::all();
        return view('admin.view-assignments', compact('studentAssignments'));
    })->name('admin.view.assignments');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/students/payment-status', [PaymentStatusController::class, 'index']); 
    Route::get('/admin/view-teachers', function () {
        $teachers = \App\Models\Teacher::all();
        $classNames = DB::table('classes')->pluck('class', 'id');
        foreach ($teachers as $teacher) {
            $teacher->department_name = $classNames[$teacher->department] ?? $teacher->department;
        }
        return view('admin.view_teachers', compact('teachers'));
    })->name('admin.view.teachers');
    Route::get('/admin/teachers/{id}/assign-students', function ($id) {
        $teacher = \App\Models\Teacher::findOrFail($id);
        $students = \App\Models\AddStudent::where('class', $teacher->department)->get();
        $classNames = DB::table('classes')->pluck('class', 'id');
        foreach ($students as $student) {
            $student->class_name = $classNames[$student->class] ?? '';
        }
        $assigned = $teacher->students()->pluck('students.id')->toArray();
        return view('admin.assign_students', compact('teacher', 'students', 'assigned'));
    });
    Route::post('/admin/teachers/{id}/assign-students', function ($id) {
        $teacher = \App\Models\Teacher::findOrFail($id);
        $studentIds = request('students', []);
        $teacher->students()->sync($studentIds);
        $students = \App\Models\AddStudent::where('class', $teacher->department)->get();
        $classNames = DB::table('classes')->pluck('class', 'id');
        foreach ($students as $student) {
            $student->class_name = $classNames[$student->class] ?? '';
        }
        $assigned = $teacher->students()->pluck('students.id')->toArray();
        return view('admin.assign_students', [
            'teacher' => $teacher,
            'students' => $students,
            'assigned' => $assigned,
            'success' => 'Students assigned successfully!'
        ]);
    });
    Route::get('/students/addstudent', [AddstdController::class, 'create'])->name('student.create');
    Route::get('/admin/addstudent-college', function () {
        return view('students.addstudent_college');
    });
    Route::post('/admin/addstudent-college', [AddstdController::class, 'addCollege'])->name('admin.addstudent.college');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::get('/students/{id}/about', [StudentController::class, 'about'])->name('students.about');
    Route::get('admin/login-as-student/{id}', [AuthController::class, 'loginAsStudent'])->name('admin.login-as-student');
    Route::post('admin/login-as-student/{id}', [AuthController::class, 'loginAsStudent'])->name('admin.loginAsStudent');
});


// Teacher routes
Route::middleware(['auth', 'impersonate'])->group(function () {
    Route::get('/teacher/{id}/panel', [TeacherController::class, 'panel'])->name('teacher.panel');
    Route::get('/teacher/panel/{id}', [App\Http\Controllers\TeacherController::class, 'panel'])->name('teacher.panel');
    Route::get('/teacher/{id}/assigned-students', function ($id) {
        $teacher = \App\Models\Teacher::findOrFail($id);
        $students = $teacher->students;
        return view('teacher.assigned_students', compact('teacher', 'students'));
    })->name('teacher.assigned.students');
    Route::get('/teacher/{teacher}/assigned-student-assignments', [TeacherAssignmentController::class, 'showAssignedStudentAssignments'])->name('teacher.assignedStudentAssignments');
    Route::get('/teacher/assignment/{id}/view', [App\Http\Controllers\TeacherAssignmentController::class, 'viewAssignment'])->name('teacher.assignment.view');
    Route::post('/teacher/assignment/{id}/check', [App\Http\Controllers\TeacherAssignmentController::class, 'checkAssignment'])->name('teacher.assignment.check');
    Route::get('/teacher/{teacherId}/assigned-student-assignments', [App\Http\Controllers\TeacherAssignmentController::class, 'showAssignedStudentAssignments'])->name('teacher.assigned_student_assignments');
});

    // Public route
    Route::post('students', [StudentController::class, 'store']);
    Route::get('students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students/addstudent', [AddstdController::class, 'add'])->name('student.add');
    Route::get('/colleges/{id}/edit', [App\Http\Controllers\CollegeController::class, 'edit'])->name('colleges.edit');
    Route::put('/colleges/{id}', [App\Http\Controllers\CollegeController::class, 'update'])->name('colleges.update');
    Route::post('/colleges', [App\Http\Controllers\CollegeController::class, 'store'])->name('colleges.store');
    Route::get('/colleges/create', [App\Http\Controllers\CollegeController::class, 'create'])->name('colleges.create');
    Route::post('courses/store', [CourseController::class, 'store'])->name('courses.store');
    Route::get('courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('courses/fetch-details', [CourseController::class, 'fetchDetails'])->name('courses.fetchDetails');
    Route::post('/courses/{id}/approve', [App\Http\Controllers\CourseController::class, 'approve'])->name('courses.approve');
    Route::get('/password/request', [EmailVerificationResetController::class, 'showRequestForm'])->name('password.request');
    Route::post('/password/request', [EmailVerificationResetController::class, 'sendVerificationEmail'])->name('password.request.verify');
    Route::get('/password/reset', function(\Illuminate\Http\Request $request) {
        $token = $request->query('token');
        $email = $request->query('email');
        if (!$token || !$email) {
            return redirect()->route('password.request')->with('error', 'Invalid password reset link.');
        }
        return view('password_reset', compact('token', 'email'));
    })->name('password.reset');
    Route::post('/password/reset', [CustomPasswordResetController::class, 'update'])->name('password.update.custom');
    
    Route::get('/dispatch-assignment-job', [AuthController::class, 'dispatchAssignmentJob']);
    Route::post('/admin/teachers/{id}/shift-to-student', [TeacherController::class, 'shiftToStudent']);
    Route::post('/revert-login', [AuthController::class, 'revertLogin'])->name('revert.login');
    
    // Teacher routes   
    Route::get('/teachers/signup', [TeacherController::class, 'showSignupForm'])->name('teachers.signup');
    Route::post('/teachers/signup', [TeacherController::class, 'store'])->name('teachers.store');
    Route::get('/teacher/panel/{id}', [App\Http\Controllers\TeacherController::class, 'panel'])->name('teacher.panel');

    
    Route::get('/password/verify/{token}', function($token, \Illuminate\Http\Request $request) {
        $email = $request->query('email');
        if (!$email) {
            return redirect()->route('password.request')->with('error', 'Invalid password reset link.');
        }
        return redirect()->route('password.reset', ['token' => $token, 'email' => $email]);
    })->name('password.verify');