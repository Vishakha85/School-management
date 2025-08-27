<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\PasswordResetVerificationMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailVerificationResetController extends Controller
{
    public function showRequestForm()
    {
        return view('auth.request-reset');
    }

    public function sendVerificationEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('status', 'If the email exists, a reset link has been sent.');
        }

        $token = Str::random(20);

        DB::table('password_verification_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => now()]
        );

        $link = route('password.verify', ['token' => $token, 'email' => $user->email]);

       Mail::to($user->email)->send(new PasswordResetVerificationMail($user->email, $token));
        // Log::info('Password reset verification email sent to: ' . $user->email);
        return back()->with('status', 'Verification email sent. Check your inbox.');
    }

    // Standard Laravel: Accept token and email as query parameters
    public function showResetForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        if (!$token || !$email) {
            return redirect()->route('password.request')->with('error', 'Invalid password reset link.');
        }

        // Optionally, you can add logic to check if the token is valid for the email using the password_resets table

        return view('auth.reset-password', [
            'email' => $email,
            'token' => $token
        ]);
    }
}

