<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Support\Facades\Auth;

// class ImpersonateMiddleware
// {
//     public function handle($request, Closure $next)
//     {
//         $user = Auth::user();

//         if ($user && ($user->hasRole('student') ||   $user->hasRole('teacher') ||  ($user->hasRole('admin') && session()->has('impersonated_by')))) {
//             return $next($request);
//         }

//         return redirect()->route('login')->withErrors(['error' => 'Access denied. Please login as student.']);
//     }
// }
// <?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ImpersonateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Allows access if:
     * - User has 'student' or 'teacher' role, OR
     * - User is an admin impersonating another user, OR
     * - User is admin (normal login)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Please login first.']);
        }

        // Roles allowed to access directly
        $allowedRoles = ['student', 'teacher'];

        // Check if user has any allowed role
        if ($user->hasAnyRole($allowedRoles)) {
            return $next($request);
        }

        // If user is admin and currently impersonating another user
        if ($user->hasRole('admin') && session()->has('impersonated_by')) {
            return $next($request);
        }

        // If user is admin normal login (not impersonating)
        if ($user->hasRole('admin') && !session()->has('impersonated_by')) {
            return $next($request);
        }

        return redirect()->route('login')->withErrors(['error' => 'Access denied.']);
    }
}
