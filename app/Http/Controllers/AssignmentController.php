<?php
namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\student;
use App\Models\FeeStructure;
use App\Models\StudentAssignment;

use Carbon\Carbon;

class AssignmentController extends Controller
{
   
    public function upload(Request $request, $id)
    {
        $request->validate([
            'assignment_file' => 'required|file|mimes:pdf,txt|max:2048',
        ]);

        $student = student::findOrFail($id);
        $classId = $student->class;
        $className = $classId ? \DB::table('classes')->where('id', $classId)->value('class') : null;

        $file = $request->file('assignment_file');
        $fileName = 'assignment_' . $student->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('assignments', $fileName, 'public');

        $assignment = new StudentAssignment();
        $assignment->std_id = $student->id;
        $assignment->assignment_id = $request->input('assignment_id');
        $assignment->assignment = $filePath;
        $assignment->save();

        return back()->with('success', 'Assignment uploaded successfully!');
    }


    public function editAssignment($studentId, $assignmentId)
{
    $assignment = StudentAssignment::where('std_id', $studentId)
        ->where('assignment_id', $assignmentId)
        ->firstOrFail();

    $assignmentMeta = DB::table('assignments')->where('id', $assignmentId)->first();
    return view('students.assignments.edit', compact('assignment', 'assignmentMeta'));
}

public function updateAssignment(Request $request, $studentId, $assignmentId)
{
    $request->validate([
        'assignment' => 'required|file|mimes:pdf,txt|max:2048',
    ]);

    $student = student::findOrFail($studentId);
    $assignment = StudentAssignment::where('std_id', $studentId)
        ->where('assignment_id', $assignmentId)
        ->firstOrFail();

    if ($assignment->assignment && Storage::disk('public')->exists($assignment->assignment)) {
        Storage::disk('public')->delete($assignment->assignment);
    }
    $file = $request->file('assignment');
    $fileName = 'Updatedassignment_' . $student->id . '_' . time() . '.' . $file->getClientOriginalExtension();
    $filePath = $file->storeAs('assignments', $fileName, 'public');
    $assignment->assignment = $filePath;
    $assignment->save();

    return redirect()->route('students.assignments', ['id' => $studentId])
        ->with('success', 'Assignment updated successfully!');
}
    public function selectBtech()
    {
        $classId = \DB::table('classes')->where('class', 'B.Tech')->value('id');
        $course = FeeStructure::where('course_id', $classId)->first();
        if ($course) {
            return redirect()->route('admin.assignments.add', ['course_id' => $course->course_id]);
        }
        return redirect()->back()->with('error', 'B.Tech course not found.');
    }
    public function selectMtech()
    {
        $classId = \DB::table('classes')->whereRaw('LOWER(class) = ?', ['m.tech'])->value('id');
        $course = FeeStructure::where('course_id', $classId)->first();
        if ($course) {
            return redirect()->route('admin.assignments.add', ['course_id' => $course->course_id]);
        }
        return redirect()->back()->with('error', 'M.Tech course not found.');
    }
    public function selectMca()
    {
        $classId = \DB::table('classes')->where('class', 'MCA')->value('id');
        $course = FeeStructure::where('course_id', $classId)->first();
        if ($course) {
            return redirect()->route('admin.assignments.add', ['course_id' => $course->course_id]);
        }
        return redirect()->back()->with('error', 'MCA course not found.');
    }
    public function selectBca()
    {
        $classId = \DB::table('classes')->where('class', 'BCA')->value('id');
        $course = FeeStructure::where('course_id', $classId)->first();
        if ($course) {
            return redirect()->route('admin.assignments.add', ['course_id' => $course->course_id]);
        }
        return redirect()->back()->with('error', 'BCA course not found.');
    }
    public function selectBcom()
    {
        $classId = \DB::table('classes')->where('class', 'BCOM')->value('id');
        $course = FeeStructure::where('course_id', $classId)->first();
        if ($course) {
            return redirect()->route('admin.assignments.add', ['course_id' => $course->course_id]);
        }
        return redirect()->back()->with('error', 'BCOM course not found.');
    }
    public function selectPhd()
    {
        $classId = \DB::table('classes')->where('class', 'PHD')->value('id');
        $course = FeeStructure::where('course_id', $classId)->first();
        if ($course) {
            return redirect()->route('admin.assignments.add', ['course_id' => $course->course_id]);
        }
        return redirect()->back()->with('error', 'PHD course not found.');
    }
    public function addAssignmentPage($course_id)
    {
        $course = FeeStructure::where('course_id', $course_id)->first();
        $assignments = \DB::table('assignments')->where('course_id', $course_id)->get();
        $className = \DB::table('classes')->where('id', $course_id)->value('class');
        return view('admin.add-assignment', compact('course', 'assignments', 'className', 'course_id'));
    }
   public function storeAssignment(Request $request, $course_id)
{
    $request->validate([
        'assignment_topic' => 'required|string|max:255',
        'assignment_question' => 'required|string',
        'assignment_description' => 'required|string',
    ]);

    $now = Carbon::now();

    if ($now->isSaturday() || $now->isSunday()) {
        $releaseTime = $now->setTime(17, 0);
    } else {
        $nextSaturday = $now->copy()->next(Carbon::SATURDAY)->setTime(17, 0);
        $nextSunday = $now->copy()->next(Carbon::SUNDAY)->setTime(17, 0);
        $releaseTime = $nextSaturday->lessThan($nextSunday) ? $nextSaturday : $nextSunday;
    }
    DB::table('assignments')->insert([
        'course_id' => $course_id,
        'assignment_topic' => $request->assignment_topic,
        'assignment_question' => $request->assignment_question,
        'assignment_description' => $request->assignment_description,
        'release_time' => $releaseTime, 
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('admin.assignments.add', ['course_id' => $course_id])
        ->with('success', 'Assignment added successfully!');
}
}
