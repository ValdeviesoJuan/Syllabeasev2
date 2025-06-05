<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class Chairperson extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::join('role_user', 'users.id', '=', 'role_user.user_id')
        ->where('role_user.role_id', '=', '5')
        ->join('roles', 'roles.role_id', '=', 'role_user.role_id')
        ->get(['users.*', 'role_user.*', 'roles.*']);

        return view('Chairperson.home',compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
