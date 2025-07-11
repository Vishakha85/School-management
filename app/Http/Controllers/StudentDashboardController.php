<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\student;

class StudentDashboardController extends Controller
{
    public function index(Request $request)
    {
        $studentId = $request->session()->get('id');
        $students = [];
        if ($studentId) {
            $student = student::find($studentId);
            if ($student) {
                $students[] = $student;
            }
        }
        return view('students.studentdash', compact('students'));
    }
}
