<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\addstudent;
class AddstdController  extends Controller
{
    
    public function create()
    {
        if (!\Session::get('is_admin') || !\Session::get('admin_logged_in')) {
            // If accessed directly or session expired, redirect to login
            return redirect('/login')->with('error', 'You cannot add a student directly. Please login as admin.');
        }
        return view('students.addstudent');
    }
    public function add(Request $request)
    {
        if (!\Session::get('is_admin') || !\Session::get('admin_logged_in')) {
            return redirect('/login')->with('error', 'You cannot add a student directly. Please login as admin.');
        }
        $data = $request->validate([
            'name' => 'required|string',
            'class' => 'required|string',
            'number' => 'required|string',
            'age' => 'required|integer',
            'password' => 'required|string',
        ]);
        addStudent::create($data);
        return redirect('/dashboard')->with('success', 'Student added successfully!');
    }
}

?>