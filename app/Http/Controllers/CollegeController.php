<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\College;
use App\Models\student;

class CollegeController extends Controller
{
    public function showForStudent($id)
    {
        $student = student::findOrFail($id);
        $colleges = $student->colleges;
        return view('colleges.show', compact('student', 'colleges'));
    }
    public function edit($id)
    {
        $college = College::with('student')->findOrFail($id);
        // If the student relationship is missing, try to fetch manually
        if (!$college->student && $college->std_id) {
            $college->student = \App\Models\Student::find($college->std_id);
        }
        return view('colleges.edit', compact('college'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'branch' => 'required|string',
            'passoutyear' => 'required|digits:4|integer',
        ]);
        $college = College::findOrFail($id);
        $original = $college->getOriginal();
        $college->update($validated);

        // Prepare changes array
        $changes = [];
        foreach(['name','branch','passoutyear'] as $field) {
            if ($original[$field] != $college->$field) {
                $changes[$field] = ['old' => $original[$field], 'new' => $college->$field];
            }
        }

        // Send mail only to vishakha78v@gmail.com and log email
        if (!empty($changes)) {
            $studentEmail = 'vishakha78v@gmail.com';
            $studentName = 'N/A';
            $studentId = null;
            if ($college->student) {
                $studentName = $college->student->name ?? 'N/A';
                $studentId = $college->student->id ?? null;
            }
            $collegeName = $college->name;
            $editTime = now()->toDateTimeString();
            $editedFields = array_keys($changes);
            \Mail::to($studentEmail)->send(new \App\Mail\CollegeEditedNotification($studentName, $studentId, $collegeName, $editTime, $editedFields));
            $changesSummary = collect($changes)->map(function($c, $field) {
                return ucfirst($field) . ': ' . $c['old'] . ' → ' . $c['new'];
            })->implode(', ');
            \App\Models\Email::create([
                'subject' => 'College Information Edited',
                // 'body' => view('emails.college_edited', ['studentName' => $studentName, 'studentId' => $studentId, 'collegeName' => $collegeName, 'editTime' => $editTime, 'editedFields' => $editedFields])->render(),
                'recipient' => $studentEmail,
                'student_name' => $studentName,
                'changes_summary' => $changesSummary,
                'student_id' => $studentId
            ]);
        }

        return redirect('/students/studentdash')->with('success', 'College information updated successfully!');
    }

    public function create(Request $request)
    {
        $std_id = $request->std_id;
        $student = null;
        if ($std_id) {
            $student = student::find($std_id);
        }
        return view('colleges.create', compact('student', 'std_id'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'std_id' => 'required|exists:students,id',
            'name' => 'required|string',
            'branch' => 'required|string',
            'passoutyear' => 'required|digits:4|integer',
            // 'feestatus' => 'required|string',
        ]);

        College::create($validated);
        return redirect()->route('student.studentdash')->with('success', 'College information saved successfully!');
    }
}
