<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\College;
use App\Models\Dean;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

class AdminCollegeController extends Controller
{
    public function index(){
        $colleges = College::paginate(10);

        $deans = Dean::join('colleges', 'deans.college_id', '=', 'colleges.college_id')
        ->join('users', 'deans.user_id', '=', 'users.id')
        ->select('users.*', 'deans.*', 'colleges.*')
        ->paginate(10);
        return view('Admin.College.collegeList', compact('colleges', 'deans'));
    }
    public function createCollege()
    {
        return view('Admin.College.collegeCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeCollege(Request $request)
    {
        $request->validate([
            'college_code' => 'required|string',
            'college_description' => 'required|string',
        ]);
        College::create($request->all());
        return redirect()->route('admin.college')->with('success', 'College created successfully.');
    }


    public function editCollege(string $college_id)
    {
        $college = College::where('college_id', $college_id)->first();

        return view('Admin.College.collegeEdit', [
            'college' => College::where('college_id', $college_id)->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCollege(Request $request, string $college_id)
    {
        $college = College::findorFail($college_id);
        $request->validate([
            'college_code' => 'required|string',
            'college_description' => 'required|string',
            'college_status' => 'required|string',
        ]);
        $college->update([
            'college_code' =>  $request->input('college_code'),
            'college_description' =>  $request->input('college_description'),
            'college_status' =>  $request->input('college_status'),

        ]);
        return redirect()->route('admin.college')
        ->with('success', 'College Information Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyCollege(College $college_id)
    {
        
        $college_id->delete();
        return redirect()->route('admin.college')
        ->with('success', 'College deleted successfully.');
    }
    //Dean Controller
    public function createDean()
    {
        $users = User::all();
        $colleges = College::all();
        return view('Admin.Dean.deanCreate', compact('users', 'colleges'));
    }
    public function storeDean(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string',
            'college_id' => 'required|string',
            'start_validity' => 'required|date',
            'end_validity' => 'required|date|after:start_validity',
        ]);
        Dean::create($request->all());

        UserRole::firstOrCreate([
            'role_id' => 2,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('admin.college')->with('success', 'Dean assigned successfully.');
    }
    public function editDean(string $dean_id)
    {
        $users = User::all();
        $colleges = College::all();
        $dean = Dean::all();
        return view('Admin.Dean.deanEdit', [
            'dean' => Dean::where('dean_id', $dean_id)->first()
        ], compact('users', 'colleges'));
    }
    public function updateDean(Request $request, string $dean_id)
    {
        $dean = Dean::findorFail($dean_id);
        $request->validate([
            'user_id' => 'required|string',
            'college_id' => 'required|string',
            'start_validity' => 'required|date',
            'end_validity' => 'required|date|after:start_validity',
        ]);
        $dean->update([
            'user_id' =>  $request->input('user_id'),
            'college_id' =>  $request->input('college_id'),
            'start_validity' =>  $request->input('start_validity'),
            'end_validity' =>  $request->input('end_validity'),
        ]);

        UserRole::firstOrCreate([
            'role_id' => 2,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('admin.college')
        ->with('success', 'College Information Updated');
    }

    public function destroyDean(Dean $dean_id)
    {
        $dean_id->delete();
        return redirect()->route('admin.college')
        ->with('success', 'Dean deleted successfully.');
    }
}