<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class PaymentStatusController extends Controller
{
    public function index()
    {
        $students = Student::with('courses')->get();
        return view('students.payment_status', compact('students'));
    }
}
