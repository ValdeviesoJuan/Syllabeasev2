<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has the 'auditor' role
        if (Auth::check() && Auth::user()->role === 'auditor') {
            return $next($request);
        }

        // Optionally, redirect or abort if not authorized
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
}