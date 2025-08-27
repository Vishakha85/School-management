<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\College;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');
    $validSorts = ['name', 'class', 'number', 'about'];
    $sortColumn = in_array($request->get('sort'), $validSorts) ? $request->get('sort') : 'id';
    $sortDirection = $request->get('direction') === 'desc' ? 'desc' : 'asc';

    $studentsQuery = Student::query();
    $matchedStudentIds = [];

    // 🔍 Search logic
    if ($search) {
        $searchLower = strtolower($search);

        if ($searchLower === 'active' || $searchLower === 'inactive') {
            $studentsQuery->where('status', $searchLower);
        } else {
            $studentsQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('number', 'like', "%$search%")
                  ->orWhere('age', 'like', "%$search%")
                  ->orWhere('id', 'like', "%$search%")
                  ->orWhere('status', 'like', "%$search%")
                  ->orWhere('password', 'like', "%$search%");
            });

            // Match from colleges
            $matchedStudentIds = College::where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('branch', 'like', "%$search%")
                  ->orWhere('passoutyear', 'like', "%$search%")
                  ->orWhere('id', 'like', "%$search%");
            })->pluck('std_id')->unique()->toArray();

            if (!empty($matchedStudentIds)) {
                $studentsQuery->orWhereIn('id', $matchedStudentIds);
            }
        }
    }

    //  Apply sorting
    $studentsQuery->orderBy($sortColumn, $sortDirection);

    // Paginate and preserve search/sort params
    $students = $studentsQuery->paginate(5)->appends($request->except('page'));

    // Matching colleges and students (for display only)
    $collegesResults = collect();
    $collegeStudents = collect();
    if ($search) {
        $collegesResults = College::where(function($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('branch', 'like', "%$search%")
              ->orWhere('passoutyear', 'like', "%$search%")
              ->orWhere('id', 'like', "%$search%");
        })->get();

        $collegeStudents = Student::whereIn('id', $collegesResults->pluck('std_id')->unique())->get();
    }

    return view('dashboard', compact('students', 'search', 'collegesResults', 'collegeStudents'));
}

}
