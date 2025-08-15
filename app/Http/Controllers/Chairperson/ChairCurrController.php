<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\UserRole;
use App\Models\Roles;
use App\Models\Chairperson;
use App\Models\Curriculum;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChairCurrController extends Controller
{
    public function index()
    {
        $chairperson = UserRole::where('user_id', Auth::id())
            ->where('entity_type', '=', 'Department')
            ->where('role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
            ->whereNotNull('entity_id')
            ->orderByDesc('updated_at')
            ->firstOrFail();

        $department_id = $chairperson->entity_id;

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
        $chairperson = UserRole::where('user_id', Auth::id())
            ->where('entity_type', '=', 'Department')
            ->where('role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
            ->whereNotNull('entity_id')
            ->orderByDesc('updated_at')
            ->firstOrFail();
        $department_id = $chairperson->entity_id ?? '';

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
