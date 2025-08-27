<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\AddStudent;
class AddstdController  extends Controller
{
    
    public function create()
    {
        return view('students.addstudent');
    }
    public function add(Request $request)
    {
        // Admin access is handled by middleware
        $data = $request->validate([
            'name' => 'required|string',
            'class' => 'required|integer',
            'number' => 'required|string',
            'email' => 'required|email',
            'age' => 'required|integer',
            'password' => 'required|string',
        ]);
        $data['password'] = bcrypt($data['password']);
        $student = AddStudent::create($data);

        // Also create a user in the users table
        \App\Models\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        // Redirect back to the form with a success message (refreshes form)
        return redirect()->back()->with('success', 'Student added successfully!');
    }

    public function addCollege(Request $request)
    {
        $data = $request->validate([
            'std_id' => 'required|exists:students,id',
            'name' => 'required|string',
            'branch' => 'required|string',
            'passoutyear' => 'required|digits:4|integer',
            // 'feestatus' => 'required|string',
        ]);
        \App\Models\College::create($data);
        return redirect('/courses/create')->with('success', 'Student and college information added successfully!');
    }
}

?>