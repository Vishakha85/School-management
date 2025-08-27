<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\student;
use App\Models\FeeStructure;
use App\Models\StudentFeeStatus;
use Illuminate\Support\Facades\DB;


class StudentDashboardController extends Controller
{
    public function index(Request $request)
    {
        $students = [];
        $colleges = [];
        $feeStatus = 'Pending';
        $user = Auth::user();
        if ($user && $user->hasRole('student')) {
            $student = null;
            if (isset($user->student_id)) {
                $student = \App\Models\student::where('id', $user->student_id)->with('colleges')->first();
            }
            if (!$student) {
                $student = \App\Models\student::where('name', $user->name)->with('colleges')->first();
            }
            if ($student) {
                $students[] = $student;
                $colleges = $student->colleges;
                // Get fee status for this student
                $feeStatusRow = \App\Models\StudentFeeStatus::where('student_id', $student->id)->first();
                $feeStatus = $feeStatusRow ? $feeStatusRow->fee_status : 'Pending';
            }
        }

        return view('students.studentdash', compact('students', 'colleges', 'feeStatus'));
    }

    public function showFeeStructure($id)
    {
        $student = student::findOrFail($id);
        $feeStructure = FeeStructure::where('course_id', $student->class)->first();
        $feeStatusRow = StudentFeeStatus::where('student_id', $student->id)->first();
        $feeStatus = $feeStatusRow ? $feeStatusRow->fee_status : 'Pending';
        $className = DB::table('classes')->where('id', $student->class)->value('class');
        return view('students.fee_structure', compact('student', 'feeStructure', 'feeStatus', 'className'));
    }
}
