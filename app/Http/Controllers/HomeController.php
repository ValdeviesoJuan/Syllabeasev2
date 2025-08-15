<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $latestRoles = UserRole::where('user_id', Auth::id())
            ->orderByDesc('updated_at')
            ->get()
            ->unique('role_id') // keep only one entry per role_id
            ->values();         // reset keys after unique()

        $myRoles = DB::table('roles')
            ->whereIn('role_id', $latestRoles->pluck('role_id'))
            ->get();

        return view('home', compact('myRoles'));
    }
}
