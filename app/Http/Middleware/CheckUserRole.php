<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\role_user;
class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        
        $user = Auth::user();
        if ($user){
            $role_user = role_user::join('users', 'role_user.user_id', '=', 'users.id')
            ->where('role_user.user_id', '=', $user->id)
            ->select('role_user.role_id')
            ->get('role_user.role_id');

            $roleIds = $role_user->pluck('role_id')->toArray(); 

            if (in_array(1, $roleIds)) { 
                return redirect()->route('admin.home');
            } elseif(in_array(2, $roleIds)){
                return redirect()->route('dean.home');
            } elseif(in_array(5, $roleIds)){
                return redirect()->route('bt.home');
            }else {
                return redirect('/home');
            }
            } else {
                return redirect('/login')->with('message', 'Login');
            }
        return $next($request);
    }
}
