<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Dean;
use App\Models\User;


use Illuminate\Http\Request;

class CollegeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colleges = College::all();

        $deans = Dean::join('colleges', 'deans.college_id', '=', 'colleges.college_id')
        ->join('users', 'deans.user_id', '=', 'users.id')
        ->select('users.*', 'deans.*', 'colleges.*')
        ->get();
        return view('admin.college.collegeList', compact('colleges', 'deans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.college.collegeCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'college_code' => 'required|string',
            'college_description' => 'required|string',
        ]);
        College::create($request->all());
        return redirect()->route('College')->with('success', 'College created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(College $college)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $college_id)
    {
        $college = College::where('college_id', $college_id)->first();

        return view('admin.college.collegeEdit', [
            'college' => College::where('college_id', $college_id)->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $college_id)
    {
        $college = College::findorFail($college_id);
        $request->validate([
            'college_code' => 'required|string',
            'college_description' => 'required|string',
        ]);
        $college->update([
            'college_code' =>  $request->input('college_code'),
            'college_description' =>  $request->input('college_description'),
        ]);
        return redirect()->route('College')
        ->with('success', 'College Information Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(College $college_id)
    {
        
        $college_id->delete();
        return redirect()->route('College')
        ->with('success', 'College deleted successfully.');
        
    }


    //Dean Controller
    public function createDean()
    {
        $users = User::all();
        $colleges = College::all();
        return view('admin.dean.deanCreate', compact('users', 'colleges'));
    }
    public function storeDean(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string',
            'college_id' => 'required|string',
            'start_validity' => 'required|string',
            'end_validity' => 'required|string',
        ]);
        Dean::create($request->all());
        return redirect()->route('College')->with('success', 'Dean assigned successfully.');
    }
    public function editDean(string $dean_id)
    {
        $users = User::all();
        $colleges = College::all();
        $dean = Dean::all();
        return view('admin.dean.deanEdit', [
            'dean' => Dean::where('dean_id', $dean_id)->first()
        ], compact('users', 'colleges'));
    }
    public function updateDean(Request $request, string $dean_id)
    {
        $dean = Dean::findorFail($dean_id);
        $request->validate([
            'user_id' => 'required|string',
            'college_id' => 'required|string',
            'start_validity' => 'required|string',
            'end_validity' => 'required|string',
        ]);
        $dean->update([
            'user_id' =>  $request->input('user_id'),
            'college_id' =>  $request->input('college_id'),
            'start_validity' =>  $request->input('start_validity'),
            'end_validity' =>  $request->input('end_validity'),
        ]);
        return redirect()->route('College')
        ->with('success', 'College Information Updated');
    }

    public function destroyDean(Dean $dean_id)
    {
        $dean_id->delete();
        return redirect()->route('College')
        ->with('success', 'Dean deleted successfully.');
    }
}
