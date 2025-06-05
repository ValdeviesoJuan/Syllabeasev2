<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\Chairperson;
use App\Models\Curriculum;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChairCurrController extends Controller
{
    public function index()
    {
        $department_id = Chairperson::where('chairpeople.user_id', '=', Auth::user()->id)
            ->select('chairpeople.department_id')
            ->first()
            ->department_id;

        $curricula = Curriculum::join('departments', 'curricula.department_id', '=', 'departments.department_id')
            ->select('departments.*', 'curricula.*')
            ->where('departments.department_id', '=', $department_id)
            ->paginate(10);
            $user = Auth::user(); 
            $notifications = $user->notifications;
        return view('Chairperson.Curricula.currList', compact('notifications', 'curricula', 'department_id'));
    }
    public function createCurr()
    {
        $department_id = Chairperson::where('chairpeople.user_id', '=', Auth::user()->id)
            ->select('chairpeople.department_id')
            ->first()
            ->department_id;

        $departments = Department::all();
        $user = Auth::user(); 
        $notifications = $user->notifications;
        return view('Chairperson.Curricula.currCreate', compact('notifications','departments', 'department_id'));
    }
    public function storeCurr(Request $request)
    {
        $request->validate([
            'curr_code' => 'required|string',
            'department_id' => 'required|integer',
            'effectivity' => 'required|string',
        ]);
        Curriculum::create($request->all());
        return redirect()->route('chairperson.curr')->with('success', 'Curriculum created successfully.');
    }
    public function editCurr(string $curr_id)
    {
        $curriculum = Curriculum::join('departments', 'curricula.department_id', '=', 'departments.department_id')
            ->select('departments.*', 'curricula.*')
            ->where('curr_id', '=', $curr_id)
            ->get();
        $departments = Department::all();
        $user = Auth::user(); 
        $notifications = $user->notifications;
        return view('Chairperson.Curricula.currEdit', [
            'curriculum' => Curriculum::where('curr_id', $curr_id)->first()
        ], compact('notifications','curriculum', 'departments'));
    }
    public function updateCurr(Request $request, string $curr_id)
    {
        $curriculum = Curriculum::findorFail($curr_id);
        $request->validate([
            'curr_code' => 'required|string',
            'effectivity' => 'required|string',
        ]);
        $curriculum->update([
            'curr_code' =>  $request->input('curr_code'),
            'effectivity' =>  $request->input('effectivity'),
        ]);
        return redirect()->route('chairperson.curr')
            ->with('success', 'Curriculum Information Updated');
    }
    public function destroyCurr(Curriculum $curr_id)
    {
        $curr_id->delete();
        return redirect()->route('chairperson.curr')
            ->with('success', 'Curriculum deleted successfully.');
    }
}
