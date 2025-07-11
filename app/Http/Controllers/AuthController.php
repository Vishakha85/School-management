<?php

namespace App\Http\Controllers;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    
    public function redirectToLogin()
    {
        return redirect('/login');
    }


    public function showLoginForm()
    {
        return view('login'); 
    }

    // public function login(Request $request)
    // {
      
    //     $defaultUsername = 'admin';
    //     $defaultPassword = 'password123';

    //     $request->validate([
    //         'username' => 'required',
    //         'password' => 'required',
    //     ]);

    //     if ($request->username === $defaultUsername && $request->password === $defaultPassword) {
    //         Session::put('admin_logged_in', true);
    //         Session::put('username', $request->username);

    //       return redirect('/dashboard'); 
    //     }

    //     return redirect('/login')
    //         ->withErrors(['login_error' => 'Invalid username or password.'])
    //         ->withInput();
    // }

   public function login(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
        'role' => 'required|in:admin,student',
    ]);

    $role = $request->input('role');
    $username = $request->input('username'); 
    $password = $request->input('password');

    // Prevent admin and student from logging in at the same time in the same browser
    if (Session::get('admin_logged_in') && $role === 'student') {
        return redirect('/login')->with('error', 'Please logout as admin before logging in as student.');
    }
    if (Session::get('student_logged_in') && $role === 'admin') {
        return redirect('/login')->with('error', 'Please logout as student before logging in as admin.');
    }

    // Admin login
    if ($role === 'admin') {
        $defaultUsername = 'admin';
        $defaultPassword = 'password123';

        if ($username === $defaultUsername && $password === $defaultPassword) {
            Session::put('admin_logged_in', true);
            Session::put('username', $username);
            Session::put('role', 'admin');
            Session::put('is_admin', true); // Set is_admin for blade and middleware

            return redirect('/dashboard');
        } else {
            return redirect('/login')
                ->withErrors(['login_error' => 'Invalid admin credentials.'])
                ->withInput();
        }
    }

    if ($role === 'student') {
        $student = Student::where('name', $username)->where('password', $password)->first();

        if ($student) {
              $student->status = 'Active';
               $student->save();
            Session::put('student_logged_in', true);
            Session::put('name', $student->name);
            Session::put('id', $student->id);
            Session::put('role', 'student');

            return redirect('/students/studentdash');
        } else {
            return redirect('/login')
                ->withErrors(['login_error' => 'Invalid student credentials.'])
                ->withInput();
        }
    }

    return redirect('/login')
        ->withErrors(['login_error' => 'Invalid role selection.'])
        ->withInput();
}
    public function dashboard()
    {
        if (!Session::get('admin_logged_in')) {
            return redirect('/login')->withErrors(['login_error' => 'You need to log in first.']);
        }
        
       $students = Student::paginate(5); 
        return view('dashboard', compact('students'));
    }

    public function logout()
    {
       
        Session::flush(); 

        return redirect('/login');
    }
     public function logoutstd()
    {
       
       if (Session::get('role') === 'student') {
        $studentId = Session::get('id');

        if ($studentId) {
            $student = Student::find($studentId);

            if ($student) {
                $student->status = 'Inactive';
                $student->save();           
            }

             
        }
    }
return redirect('/login');
}
}
