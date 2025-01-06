<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateBroadcasts
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}

