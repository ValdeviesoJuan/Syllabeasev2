<?php

namespace App\Http\Controllers;

use App\Models\Dean;
use Illuminate\Http\Request;

class DeanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $colleges = College::all();
        return view('admin.dean.deanCreate', compact('users', 'colleges'));
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
    public function show(Dean $dean)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dean $dean)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dean $dean)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dean $dean)
    {
        //
    }
}
