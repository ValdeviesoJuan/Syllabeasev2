<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $myRoles = UserRole::join('users', 'users.id', '=', 'user_roles.user_id')
        ->join('roles', 'roles.role_id', '=', 'user_roles.role_id')
        ->where('users.id', '=', Auth::user()->id)
        ->select('roles.*')
        ->get();
        return view('home', compact('myRoles'));
    }
}
