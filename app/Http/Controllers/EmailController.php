<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email;
use App\Models\student;

class EmailController extends Controller
{
    public function index()
    {
        $emails = Email::with('student')->orderBy('created_at')->get();
        return view('admin.emails', compact('emails'));
    }
}
