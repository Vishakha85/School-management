<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomPasswordResetController extends Controller
{
   public function update(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string|min:6|confirmed',
        'token' => 'required'
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $tokenData = DB::table('password_verification_tokens')
        ->where('email', $request->email)
        ->where('token', $request->token)
        ->first();

    if (!$tokenData) {
        return redirect()->back()->with('error', 'Invalid or expired token.');
    }

    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return redirect()->back()->with('error', 'Enter valid user.');
    }

    $hashedPassword = Hash::make($request->password);
    $user->password = $hashedPassword;
    $user->save();

    // Update password in students table if user is a student
    if (method_exists($user, 'hasRole') && $user->hasRole('student')) {
        $student = \App\Models\student::where('id', $user->id)->first();
        if ($student) {
            $student->password = $hashedPassword;
            $student->save();
        }
    }

    // Update password in teachers table if user is a teacher
    if (method_exists($user, 'hasRole') && $user->hasRole('teacher')) {
        $teacher = \App\Models\Teacher::where('id', $user->id)->first();
        if ($teacher) {
            $teacher->password = $hashedPassword;
            $teacher->save();
        }
    }

    // Delete the token after use
    DB::table('password_verification_tokens')->where('email', $request->email)->delete();

    return redirect()->route('login')->with('success', 'Password updated successfully.');
}

}
