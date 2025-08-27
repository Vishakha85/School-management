<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\FeeStructure;
use App\Models\StudentFeeStatus;

class FeeStructureController extends Controller
{
    public function allFeeStructures()
    {
        $students = \App\Models\Student::all();
        $classIds = $students->pluck('class')->unique()->toArray();
        $classNames = \DB::table('classes')->whereIn('id', $classIds)->pluck('class', 'id')->toArray();
        $feeStructures = \App\Models\FeeStructure::whereIn('course_id', $classIds)->get()->keyBy('course_id');
        $feeStatuses = \App\Models\StudentFeeStatus::whereIn('student_id', $students->pluck('id'))->get()->keyBy('student_id');
        return view('admin.all_fee_structures', compact('students', 'classNames', 'feeStructures', 'feeStatuses'));
    }

    public function updateStatus(Request $request)
    {
        if (!session('is_admin') || !session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_status' => 'required|in:Pending,Success',
        ]);
        $feeStatus = StudentFeeStatus::where('student_id', $request->student_id)->first();
        if ($feeStatus) {
            $feeStatus->fee_status = $request->fee_status;
            $feeStatus->save();
        } else {
            $student = Student::find($request->student_id);
            $feeStructure = FeeStructure::where('course_id', $student->class)->first();
            StudentFeeStatus::create([
                'student_id' => $student->id,
                'class' => $student->class,
                'annual_fee' => $feeStructure->annual_fee ?? 0,
                'tuition_fee' => $feeStructure->tuition_fee ?? 0,
                'total_fee' => $feeStructure->total_fee ?? 0,
                'fee_status' => $request->fee_status,
            ]);
        }
        return response()->json(['success' => true]);
    }
}
