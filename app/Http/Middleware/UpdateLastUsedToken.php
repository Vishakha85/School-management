<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UpdateLastUsedToken
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->forceFill([
                'last_used_at' => now(),
            ])->save();
        }

        return $next($request);
    }
}

