<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AddstdController;
use App\Http\Controllers\StudentDashboardController;
// use App\Http\Middleware\AdminMiddleware;


Route::get('/', [AuthController::class, 'redirectToLogin']);
Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/dashboard', [AuthController::class, 'dashboard']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('students/create', [StudentController::class, 'create'])->name('students.create');
Route::post('students', [StudentController::class, 'store']);
Route::get('/students/studentdash', [StudentDashboardController::class, 'index'])->name('student.dashboard');
Route::get('/logoutstd', [AuthController::class, 'logoutstd']);
Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');


Route::get('/students/addstudent', function () {
    if (!Session::get('is_admin')) {
        return redirect('/login')->with('error', 'You cannot add a student directly. Please login as admin.');
    }
    return view('students.addstudent');
});
Route::get('/addstudent', [AddstdController::class, 'create'])->name('student.create');
Route::post('/students/addstudent', [AddstdController::class, 'add'])->name('student.add');





// Route::middleware(['admin'])->group(function () {
//     Route::get('/students/addstudent', [AddstdController::class, 'create']);
//     Route::get('/addstudent', [AddstdController::class, 'create'])->name('student.create');
//     Route::post('/students/addstudent', [AddstdController::class, 'add'])->name('student.add');
// });
