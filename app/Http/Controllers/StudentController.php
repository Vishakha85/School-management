<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }
  
   
    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
       
        $request->validate([
            'name' => 'required|string|max:255',
            'class' => 'required|string|max:50',
            'number' => 'required|string|max:15',
            'age' => 'required|integer|min:1',
             'password' => 'required|string|min:4',
        ]);

        Student::create([
            'name' => $request->name,
            'class' => $request->class,
            'number' => $request->number,
            'age' => $request->age,
             'password' => $request->password,
        ]);

        session()->flash('success', 'Data submitted successfully!');

        return redirect()->route('students.create');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'class' => 'required|string|max:50',
            'number' => 'required|string|max:15',
            'age' => 'required|integer|min:1',
            'password' => 'required|string|min:4',
        ]);

        $student = Student::findOrFail($id);
        $student->name = $request->name;
        $student->class = $request->class;
        $student->number = $request->number;
        $student->age = $request->age;
        $student->password = $request->password;
        $student->save();

        return redirect('/students/studentdash')->with('success', 'Student updated successfully!');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->back()->with('success', 'Student deleted successfully!');
    }
}
