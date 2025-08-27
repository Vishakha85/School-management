<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Student;
use App\Models\FeeStructure;
use App\Models\StudentFeeStatus;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentEditedNotification;
use App\Models\Email;

class StudentController extends Controller
{
    public function assignStudentRoleToAllUsers()
    {
        if (!Role::where('name', 'student')->exists()) {
            Role::create(['name' => 'student']);
        }

        foreach (User::all() as $user) {
            if (!$user->hasRole('student')) {
                $user->assignRole('student');
            }
        }

        return 'Student role assigned to all users.';
    }

    public function create()
    {
        // $user = User::all();
        // echo "<pre>";print_r($user); echo "</pre>";
        // die();
        $classes = DB::table('classes')->select('id', 'class')->get();
        return view('students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'class' => 'required|integer|exists:classes,id',
            'number' => 'required|string|max:255',
            'age' => 'required|integer',
            'password' => 'required|string|min:6',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role_id' => 'required|integer|exists:roles,id',
         
        ]);   
        // dd($request->all());

        $imagePath = $request->file('image')->store('student_images', 'public');

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
             'role_id' => $request->role_id,
            
        ]);

        if (!Role::where('name', 'student')->exists()) {
            Role::create(['name' => 'student']);
        }
        $user->assignRole('student');

        // Create associated student profile
        Student::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'class' => $request->class,
            'number' => $request->number,
            'age' => $request->age,
            'password' => $user->password,
            'image' => $imagePath,
           
        ]);

        // Fetch fee structure
        $feeStructure = FeeStructure::where('course_id', $request->class)->first();
        $annualFee = $feeStructure->annual_fee ?? 0;
        $tuitionFee = $feeStructure->tuition_fee ?? 0;
        $totalFee = $feeStructure->total_fee ?? 0;

        StudentFeeStatus::create([
            'student_id' => $user->id,
            'class' => $request->class,
            'annual_fee' => $annualFee,
            'tuition_fee' => $tuitionFee,
            'total_fee' => $totalFee,
            'fee_status' => 'Pending',
        ]);

        return redirect()->route('login')->with('success', 'Signup successful! Please login.');
    }

    public function studentdash()
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('student')) {
            return redirect('/login')->withErrors(['error' => 'Access denied. Please login as student.']);
        }

        // Fetch student profile
        $student = Student::where('email', $user->email)->first();
        if (!$student) {
            return redirect('/login')->withErrors(['error' => 'Student profile not found.']);
        }

        $className = DB::table('classes')->where('id', $student->class)->value('class');

        return view('students.studentdash', compact('student', 'className'));
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $className = DB::table('classes')->where('id', $student->class)->value('class');
        return view('students.edit', compact('student', 'className'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $original = $student->getOriginal();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'number' => 'required|string|max:15',
            'age' => 'required|integer|min:1',
        ]);

        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'age' => $request->age,
        ]);

        // Sync user table
        $user = User::where('email', $original['email'])->first();
        if ($user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if (!Role::where('name', 'student')->exists()) {
                Role::create(['name' => 'student']);
            }

            if (!$user->hasRole('student')) {
                $user->assignRole('student');
            }
        }

        // Change tracking and email
        $changes = [];
        foreach (['name', 'email', 'class', 'number', 'age'] as $field) {
            if ($original[$field] != $student->$field) {
                $changes[$field] = ['old' => $original[$field], 'new' => $student->$field];
            }
        }

        if ($changes) {
            $adminEmail = 'vishakha78v@gmail.com';
            $editTime = now()->toDateTimeString();

            Mail::to($adminEmail)->send(new StudentEditedNotification($student->name, $editTime, array_keys($changes)));

            $summary = collect($changes)->map(fn($c, $f) => ucfirst($f) . ': ' . $c['old'] . ' → ' . $c['new'])->implode(', ');

            Email::create([
                'subject' => 'Student Information Updated',
                'recipient' => $adminEmail,
                'student_name' => $student->name,
                'changes_summary' => $summary,
                'student_id' => $student->id,
            ]);
        }

        return redirect('/students/studentdash')->with('success', 'Student updated successfully!');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $user = User::where('email', $student->email)->first();

        $student->delete();
        if ($user) $user->delete();

        return back()->with('success', 'Student and user account deleted.');
    }

    public function about($id)
    {
        $student = Student::findOrFail($id);
        return view('students.about', compact('student'));
    }

    public function showFeeStructure($studentId)
    {
        $student = Student::findOrFail($studentId);
        $className = DB::table('classes')->where('id', $student->class)->value('class');
        $feeStructure = FeeStructure::where('course_id', $student->class)->first();

        return view('students.fee_structure', compact('student', 'className', 'feeStructure'));
    }
}
