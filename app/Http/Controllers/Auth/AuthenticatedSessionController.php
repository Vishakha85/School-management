<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
  
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $name = $request->input('name');
        $password = $request->input('password');
        $user = \App\Models\User::where('name', $name)->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($password, $user->password)) {
            // Check role
            if ($user->hasRole('admin')) {
                Auth::login($user);
                $token = $user->createToken('auth_token')->plainTextToken;
                if ($request->expectsJson()) {
                    return response()->json([
                        'user' => $user,
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                        'role' => 'admin',
                    ]);
                } else {
                    return redirect()->intended(route('dashboard', absolute: false));
                }
            }
            if ($user->hasRole('student')) {
                Auth::login($user);
                session(['student_id' => $user->student_id]);
                $token = $user->createToken('auth_token')->plainTextToken;
                if ($request->expectsJson()) {
                    return response()->json([
                        'user' => $user,
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                        'role' => 'student',
                    ]);
                } else {
                    return redirect()->intended(route('student.studentdash'));
                }
            }
            if ($user->hasRole('teacher')) {
                Auth::login($user);
                session(['teacher_id' => $user->teacher_id]);
                $token = $user->createToken('auth_token')->plainTextToken;
                if ($request->expectsJson()) {
                    return response()->json([
                        'user' => $user,
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                        'role' => 'teacher',
                    ]);
                } else {
                    return redirect()->intended(route('teachers.panel'));
                }
            }
        }

        if ($request->expectsJson()) {
            return response()->json(['error' => 'Invalid name or password.'], 401);
        } else {
            return redirect()->route('login')->withErrors(['name' => 'Invalid name or password.']);
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
