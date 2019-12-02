<?php

namespace App\Http\Middleware;

use Closure;

class UserAgentAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (strpos($request->userAgent(), 'Laracatch/Client') !== false)
        {
            return $next($request);
        }

        abort(404);
    }
}
