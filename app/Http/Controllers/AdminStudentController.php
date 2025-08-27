<?php

namespace App\Http\Controllers;

use App\Models\student;
use App\Models\FeeStructure;
use App\Models\StudentFeeStatus;
use Illuminate\Http\Request;

class AdminStudentController extends Controller
{
    public function showFeeStructure($id)
    {
        $student = student::findOrFail($id);
        $feeStructure = FeeStructure::where('course_id', $student->class)->first();
        $feeStatusRow = StudentFeeStatus::where('student_id', $student->id)->first();
        $feeStatus = $feeStatusRow ? $feeStatusRow->fee_status : 'Pending';
        return view('admin.student_fee_structure', compact('student', 'feeStructure', 'feeStatus'));
    }

    public function updateFeeStatus(Request $request, $id = null)
    {
        $studentId = $request->input('student_id', $id);
        $feeStatus = $request->input('fee_status');
        $student = student::find($studentId);
        $feeStatusRow = StudentFeeStatus::where('student_id', $studentId)->first();
        if ($feeStatusRow) {
            $feeStatusRow->fee_status = $feeStatus;
            $feeStatusRow->save();
        } else if ($student) {
            // Fetch fee structure for the student's class
            $feeStructure = FeeStructure::where('course_id', $student->class)->first();
            $annualFee = $feeStructure && isset($feeStructure->annual_fee) ? $feeStructure->annual_fee : FeeStructure::query()->value('annual_fee');
            $tuitionFee = $feeStructure && isset($feeStructure->tuition_fee) ? $feeStructure->tuition_fee : FeeStructure::query()->value('tuition_fee');
            $totalFee = $feeStructure && isset($feeStructure->total_fee) ? $feeStructure->total_fee : FeeStructure::query()->value('total_fee');
            StudentFeeStatus::create([
                'student_id' => $studentId,
                'class' => $student->class,
                'annual_fee' => $annualFee,
                'tuition_fee' => $tuitionFee,
                'total_fee' => $totalFee,
                'fee_status' => $feeStatus,
            ]);
        }
        return response()->json(['success' => true, 'fee_status' => $feeStatus]);
    }

    public function allFeeStructures()
    {
        $students = student::all();
        $feeStructures = FeeStructure::all()->keyBy('class');
        $feeStatuses = StudentFeeStatus::all()->keyBy('student_id');
        return view('admin.all_fee_structures', compact('students', 'feeStructures', 'feeStatuses'));
    }
}