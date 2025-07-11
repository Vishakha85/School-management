<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
       
        if (session()->has('username') && session('username') === 'admin') {
            return $next($request); 
        }

        
        abort(403, 'Access denied. Admins only.');
    }
}
