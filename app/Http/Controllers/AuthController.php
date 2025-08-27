<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Teacher;

use App\Jobs\DeliverAssignmentsToStudents;

class AuthController extends Controller
{
    public function redirectToLogin()
{
    return redirect()->route('login');
}
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'name' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($request->expectsJson()) {
                $token = $user->createToken('auth_token', ['*'], now()->addDays(7))->plainTextToken;

                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user,
                    'role' => $user->getRoleNames()->first(),
                ]);
            }

            if ($user->hasRole('admin')) {
                return redirect('/dashboard');
            } elseif ($user->hasRole('student')) {
                return redirect()->route('student.studentdash');
            } elseif ($user->hasRole('teacher')) {
                return redirect()->route('teacher.panel', ['id' => $user->id]);
            }

            Auth::logout();
            return redirect('/login')->withErrors(['error' => 'Unauthorized role.']);
        }

        return back()->withErrors([
            'username' => 'Invalid credentials.',
        ]);
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
        return redirect('/login');
    }

 
   public function loginAsStudent($id)
{
    if (!Auth::check() || !Auth::user()->hasRole('admin')) {
        abort(403, 'Unauthorized');
    }
    $user = \App\Models\User::findOrFail($id);

    if (!$user->hasRole('student')) {
        return redirect()->back()->withErrors(['error' => 'User is not a student.']);
    }
    $student = \App\Models\Student::where('email', $user->email)->first();

    if (!$student) {
        return redirect()->back()->withErrors(['error' => 'Student record not found for this user.']);
    }
    session(['impersonated_by' => Auth::id()]);
    Auth::login($user);
    $student->status = 'Active';
    $student->save();

    return redirect()->route('student.studentdash')->with('success', 'Now logged in as student.');
}

public function revertLogin()
{
    $adminId = session('impersonated_by');

    if (!$adminId) {
        return redirect('/login')->withErrors(['error' => 'No impersonation session found.']);
    }
    $admin = \App\Models\User::find($adminId);

    if (!$admin || !$admin->hasRole('admin')) {
        return redirect('/login')->withErrors(['error' => 'Original admin user not found or no longer has admin privileges.']);
    }

    Auth::logout();

    session()->forget('impersonated_by');
    Auth::login($admin);
    $admin->load('roles', 'permissions');

    return redirect('/dashboard')->with('success', 'Returned to admin account.');
}


    public function loginAsTeacher($id)
{
 
    if (!Auth::check() || !Auth::user()->hasRole('admin')) {
        abort(403, 'Unauthorized');
    }
    $teacher = \App\Models\Teacher::findOrFail($id);
    $user = \App\Models\User::where('email', $teacher->email)->first();
    if (!$user) {
        return back()->with('error', 'No user account found for this teacher.');
    }
  session(['impersonated_by' => Auth::id()]);
    Auth::login($user);
return redirect()->route('teacher.panel', ['id' => $teacher->id]);
}

// public function returnLogin()
// {
//     $adminId = session('impersonated_by');
//     if (!$adminId) {
//         return redirect()->route('login')->with('error', 'No admin session found.');
//     }
//     $admin = \App\Models\User::find($adminId);
//     if (!$admin || !$admin->hasRole('admin')) {
//         session()->forget('impersonated_by');
//         return redirect()->route('login')->with('error', 'Admin user not found or no longer has admin privileges.');
//     }
//     session()->forget('impersonated_by');
//     Auth::login($admin);
//     return redirect('/dashboard')->with('success', 'Successfully returned to admin dashboard.');
// }


    public function dispatchAssignmentJob(Request $request)
    {
        DeliverAssignmentsToStudents::dispatch();

        return response()->json([
            'message' => "Assignment delivery job has been dispatched."
        ]);
    }

}
