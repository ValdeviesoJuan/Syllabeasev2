<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\College;
use App\Models\Dean;
use App\Models\User;
use App\Models\Curriculum;
use App\Models\Department;
use Illuminate\Http\Request;

class AdminCurrController extends Controller
{
    public function index(){
        $curricula = Curriculum::join('departments', 'curricula.department_id', '=', 'departments.department_id')
        ->select('departments.*', 'curricula.*')
        ->paginate(10);
        
        return view('Admin.Curriculum.currList', compact('curricula'));
    }
    public function createCurr()
    {
        $departments = Department::all();
        return view('Admin.Curriculum.currCreate', compact('departments'));
    }
    public function storeCurr(Request $request)
    {
        $request->validate([
            'curr_code' => 'required|string',
            'department_id' => 'required|integer',
            'effectivity' => 'required|string',
        ]);
        Curriculum::create($request->all());
        return redirect()->route('admin.curr')->with('success', 'Curriculum created successfully.');
    }
    public function editCurr(string $curr_id)
    {
        $curriculum = Curriculum::join('departments', 'curricula.department_id', '=', 'departments.department_id')
        ->select('departments.*', 'curricula.*')
        ->where('curr_id', '=', $curr_id)
        ->get();
        $departments = Department::all();
        return view('Admin.Curriculum.currEdit', [
            'curriculum' => Curriculum::where('curr_id', $curr_id)->first()
        ], compact('curriculum', 'departments'));
    }
    public function updateCurr(Request $request, string $curr_id)
    {
        $curriculum = Curriculum::findorFail($curr_id);
        $request->validate([
            'curr_code' => 'required|string',
            'department_id' => 'required|integer',
            'effectivity' => 'required|string',
        ]);
        $curriculum->update([
            'curr_code' =>  $request->input('curr_code'),
            'department_id' =>  $request->input('department_id'),
            'effectivity' =>  $request->input('effectivity'),
        ]);
        return redirect()->route('admin.curr')
        ->with('success', 'Curriculum Information Updated');
    }
    public function destroyCurr(Curriculum $curr_id)
    {
        $curr_id->delete();
        return redirect()->route('admin.curr')
        ->with('success', 'Curriculum deleted successfully.');
    }
}