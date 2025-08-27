<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentAssignment;
use App\Models\StudentTeacher;
use App\Models\student;


class TeacherAssignmentController extends Controller
{
    public function showAssignedStudentAssignments($teacherId)
    {
        // Get student IDs assigned to this teacher
        $studentIds = StudentTeacher::where('teacher_id', $teacherId)->pluck('student_id');
        // Get assignments for these students
        $assignments = StudentAssignment::whereIn('std_id', $studentIds)->get();
        // Get student names
        $students = student::whereIn('id', $studentIds)->get()->keyBy('id');
        // Get assignment topics from assignments table
        $assignmentIds = $assignments->pluck('assignment_id')->unique()->toArray();
        $assignmentTopics = [];
        if (!empty($assignmentIds)) {
            $topics = \DB::table('assignments')->whereIn('id', $assignmentIds)->pluck('assignment_topic', 'id');
            $assignmentTopics = $topics->toArray();
        }
        // Pass teacherId to view for correct back button
        return view('teachers.assigned_student_assignments', compact('assignments', 'students', 'assignmentTopics', 'teacherId'));
    }
    public function viewAssignment(Request $request, $id)
    {
        $assignment = \App\Models\StudentAssignment::findOrFail($id);
        $student = \App\Models\student::find($assignment->std_id);
        $assignmentTopic = $request->query('topic');
        if (!$assignmentTopic && $assignment->assignment_id) {
            $assignmentTopic = \DB::table('assignments')->where('id', $assignment->assignment_id)->value('assignment_topic') ?? 'N/A';
        }
        // Get teacher id from teachers table using assignment's teacher_id
        $studentTeacher = \App\Models\StudentTeacher::where('student_id', $assignment->std_id)->first();
        $teacherId = $studentTeacher ? $studentTeacher->teacher_id : null;
        return view('teachers.view_assignment', compact('assignment', 'student', 'assignmentTopic', 'teacherId'));
    }
    
    public function checkAssignment(Request $request, $id)
    {
        $assignment = \App\Models\StudentAssignment::findOrFail($id);
        // Find student_teacher_id
        $teacherId = auth()->user()->id;
        $studentTeacher = \App\Models\StudentTeacher::where('student_id', $assignment->std_id)
            ->where('teacher_id', $teacherId)
            ->first();

        if (!$studentTeacher) {
            // Try to find any teacher-student relation if teacher_id is not set correctly
            $studentTeacher = \App\Models\StudentTeacher::where('student_id', $assignment->std_id)->first();
        }

        if ($studentTeacher) {
            $assignmentId = $assignment->assignment_id ?? $assignment->id;
            if (!$assignmentId) {
                \Log::error('Assignment ID missing for review save');
                return back()->with('error', 'Assignment ID missing, review not saved.');
            }
            // Always provide assignment_id to avoid nulls
            $review = \App\Models\AssignmentReview::firstOrNew([
                'student_teacher_id' => $studentTeacher->id,
                'assignment_id' => $assignmentId
            ]);
            $review->assignment_id = $assignmentId;
            $review->marks = $request->input('marks');
            $review->summary = $request->input('summary');
            $review->save();
        } else {
            // Log or show error
            \Log::warning('No matching student_teacher_id found for student_id: ' . $assignment->std_id . ', teacher_id: ' . $teacherId);
        }

        return redirect()->route('teacher.assignment.view', ['id' => $id])->with('success', 'Assignment checked and review saved.');
}
}