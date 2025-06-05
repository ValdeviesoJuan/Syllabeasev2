<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\College;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
        return view('dean.home', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $college = College::where('dean_id', '=', Auth::user()->id)->first();
        $departments = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
        ->join('users', 'departments.chair_id', '=', 'users.id')
        ->get();
        $users = User::all();

        return view('dean.departmentCreate', compact('departments', 'users', 'college'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'college_id' => 'required|exists:colleges,college_id',
            'chair_id' => 'required|exists:users,id',
            'department_description' => 'required|string',
        ]);
        Department::create([
            'college_id' => 1,
            // 'college_id' => $request->input('college_id'),
            'chair_id' => $request->input('chair_id'),
            'description' => $request->input('description'),
        ]);
        return redirect()->route('dean.home')->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        $department = Department::find($department_id);

        if (!$department) {
            return abort(404);
        }

        return view('dean.departmentEdit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'department_id' => 'required|unique:departments,department_id,' . $department_id,
            'college_id' => 'required|exists:colleges,college_id',
            'chair_id' => 'required|exists:users,id',
            'description' => 'required|string',
        ]);

        $department = Department::find($department_id);

        if (!$department) {
            return abort(404);
        }

        $department->update($request->all());

        return redirect()->route('Dean.home')->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department_id)
    {
        $department_id->delete();
        return redirect()->route('dean.home')
            ->with('success', 'Department deleted successfully.');
    }
}
