<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Assignment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{

    public function panel()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $teacher = Teacher::where('name', $user->name)->first();
        return view('teachers.panel', compact('teacher'));
    }

    public function showSignupForm()
    {
        $classes = \DB::table('classes')->select('id', 'class')->get();
        return view('teachers.signup', compact('classes'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'experience' => 'required|string|max:255',
            'department' => 'required|integer|exists:classes,id',
            'password' => 'required|string|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role_id' => 'required|integer|exists:roles,id',
        ]);

        $data = $request->only(['name', 'email', 'experience', 'department']);
        $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('teacher_images', 'public');
            $data['image'] = $imagePath;
        }

        $teacher = Teacher::create($data);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role_id' => $request->role_id,
        ];
        $user = \App\Models\User::create($userData);
        if (method_exists($user, 'assignRole')) {
            $user->assignRole('teacher');
        }

        return redirect('/login')->with('success', 'Teacher registered successfully! Please login.');
    }

    public function index()
    {
        $teachers = Teacher::all();
        return view('admin.teachers.index', compact('teachers'));
    }

public function shiftToStudent($id)
{
    $teacher = Teacher::findOrFail($id);
    $user = User::where('email', $teacher->email)->first();
    Student::create([
        'name' => $teacher->name,
        'email' => $teacher->email,
        'class' => $teacher->department_name ?? $teacher->department,
        'number' => '000000000',
        'password' => $teacher->password,
        'image' => $teacher->image,
        'age' => '00',
    ]);
    if ($user) {
        $user->role_id = 2; 
        $user->save();
         $user->syncRoles([]); 
        $user->assignRole('student');
    }
    $teacher->delete();
    return redirect()->back()->with('success', 'Teacher shifted to student successfully.');
}

}
