<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeeStructure;
use App\Models\Student;
use App\Models\Course;

class CourseController extends Controller
{

    public function approve(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        if ($request->action === 'approve') {
            $course->approved = 'Yes';
            // Update student_fee_statuses table using student's class id
            $student = \App\Models\Student::find($course->student_id);
            if ($student) {
                \App\Models\StudentFeeStatus::where('student_id', $course->student_id)
                    ->update(['fee_status' => 'Success']);
            }
        } elseif ($request->action === 'reject') {
            $course->approved = 'Rejected';
        }
        $course->save();
        return redirect()->back()->with('success', 'Course approval updated.');
    }

    public function create(Request $request)
    {
        // Fetch all classes (id and name) for dropdowns if needed
        $classes = \DB::table('classes')->select('id', 'class')->get();
        $college_id = $request->query('college_id');
        $student = null;
        $student_id = null;
        if ($college_id) {
            $college = \App\Models\College::find($college_id);
            if ($college) {
                $student = $college->student;
                $student_id = $student ? $student->id : null;
            }
        } else {
            $student_id = $request->query('student_id');
            if ($student_id) {
                $student = Student::find($student_id);
            }
        }
        return view('courses.create', compact('classes', 'student_id', 'student'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'class' => 'required|integer|exists:classes,id',
            'core_subject' => 'required|string',
            'duration' => 'required|string',
        ]);

        // Update student's class if changed
        $student = Student::find($request->student_id);
        if ($student && $student->class != $request->class) {
            $student->class = $request->class;
            $student->save();
        }

        // Only create a course if Pay button is clicked
        $successMessage = null;
        if ($request->has('want_to_enroll')) {
            $existingCourse = Course::where('student_id', $request->student_id)
                ->orderByDesc('id')->first();
            if (!$existingCourse || $existingCourse->payment !== 'Success') {
                $courseData = [
                    'student_id' => $request->student_id,
                    // 'class' => $request->class, // class column removed from courses
                    'core_subject' => $request->core_subject,
                    'duration' => $request->duration,
                    'approved' => 'Pending',
                    'payment' => 'Success',
                ];
                $course = Course::create($courseData);

                // Send mail to admin
                $student = \App\Models\Student::find($request->student_id);
                \Mail::to('vishakha78v@gmail.com')->send(new \App\Mail\CoursePaymentMail($student, $course));
            }
            $successMessage = 'Payment successful!';
        }

        // Always pass student_id and classes to the view
        $student_id = $request->student_id;
        if (!isset($classes)) {
            $classes = \DB::table('classes')->select('id', 'class')->get();
        }
        return view('courses.create', compact('classes', 'student_id', 'student', 'successMessage'));
    }

    public function fetchDetails(Request $request)
    {
        $classId = $request->input('class');
        $className = $classId ? \DB::table('classes')->where('id', $classId)->value('class') : null;
        $details = $className ? FeeStructure::where('course_id', $student->class)->first() : null;
        return response()->json($details);
    }
}
