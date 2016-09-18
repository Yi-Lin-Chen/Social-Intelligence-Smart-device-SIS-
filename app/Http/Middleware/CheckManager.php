<?php

namespace App\Http\Middleware;

use Closure;

class CheckManager
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
        if( !$request->user()->isManager() ) {
            // Normal User, Redirect to Dashboard
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
