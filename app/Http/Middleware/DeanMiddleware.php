<?php

namespace App\Http\Middleware;

use App\Models\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DeanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user){
            $user_role = UserRole::join('users', 'user_roles.user_id', '=', 'users.id')
            ->where('user_roles.user_id', '=', $user->id)
            ->select('user_roles.role_id')
            ->get('user_roles.role_id');

            $roleIds = $user_role->pluck('role_id')->toArray(); 
            if (in_array(2, $roleIds)) { 
                return $next($request);
            } else {
                return redirect('/home')->with('message', 'Access Denied');
            }
            } else {
                return redirect('/login')->with('message', 'Login');
            }
      }
}
