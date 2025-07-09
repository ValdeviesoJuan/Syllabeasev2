<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserRole;
use App\Models\Roles;
use App\Models\ProgramOutcome;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPOController extends Controller
{
    public function index()
    {
        $departments = Department::all();

        $department_name = UserRole::where('user_roles.user_id', '=', Auth::id())
            ->join('departments', 'user_roles.entity_id', '=', 'departments.department_id')
            ->where('entity_type', '=', 'Department')
            ->where('role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
            ->select('departments.department_name')
            ->first()
            ->department_name;

        $today = now()->toDateString();

        $programOutcomes = ProgramOutcome::join('departments', 'program_outcomes.department_id', '=', 'departments.department_id')
            ->join('user_roles', 'departments.department_id', '=', 'user_roles.entity_id')
            ->where('user_roles.entity_type', '=', 'Department')
            ->where('user_roles.role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
            // ->where('user_roles.start_validity', '<=', $today)
            // ->where('user_roles.end_validity', '>=', $today)
            ->orderBy('program_outcomes.po_letter', 'asc')
            ->select('departments.*', 'program_outcomes.*')
            ->get();
        
        return view('admin.po.polist', compact( 'programOutcomes',  'department_name'));
    }
    public function createPo()
    {
        $departments = Department::where('department_status', '=', 'Active')->get();

        return view('admin.po.pocreate', compact('departments'));
    }
    public function storePo(Request $request)
    {

        $validatedData = $request->validate([
            'department_id' => 'required|exists:departments,department_id',
            'po_letter.*' => 'required|string',
            'po_description.*' => 'required|string',
        ]);

        foreach ($validatedData['po_letter'] as $key => $poLetter) {
            ProgramOutcome::create([
                'department_id'   => $validatedData['department_id'],
                'po_letter'       => $poLetter,
                'po_description'  => $validatedData['po_description'][$key],
            ]);
        }

        return redirect()->route('admin.programOutcome')->with('success', 'Program Outcome created successfully.');
    }
    public function editPo($po_id)
    {
        $programOutcomes = ProgramOutcome::join('departments', 'program_outcomes.department_id', '=', 'departments.department_id')
            ->join('user_roles', 'departments.department_id', '=', 'user_roles.entity_id')
            ->where('user_roles.user_id', '=', Auth::user()->id)
            ->where('user_roles.entity_type', '=', 'Chairperson')
            ->where('user_roles.role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
            ->select('departments.*', 'program_outcomes.*')
            ->get();
            
        $chairperson = UserRole::where('user_id', Auth::id())
            ->where('entity_type', '=', 'Department')
            ->where('role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
            ->firstOrFail();

        $department_id = $chairperson->entity_id;

        return view('admin.po.poedit', compact('programOutcomes', 'department_id'));
    }
    public function updatePo(Request $request, string $department_id)
    {
        $chairperson = UserRole::where('user_id', Auth::id())
            ->where('entity_type', '=', 'Department')
            ->where('role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
            ->firstOrFail();

        $department_id = $chairperson->entity_id;

        $request->validate([
            'po_letter.*' => 'required|string',
            'po_description.*' => 'required|string',
        ]);

        $validatedData = $request->validate([
            'po_letter.*' => 'required',
            'po_description.*' => 'required',
        ]);

        ProgramOutcome::where('department_id', $department_id)->delete();
        foreach ($validatedData['po_letter'] as $key => $poLetter) {
            $outcome = new ProgramOutcome();
            $outcome->department_id = $department_id;
            $outcome->po_letter = $poLetter;
            $outcome->po_description = $validatedData['po_description'][$key];

            $outcome->save();
        }
        return redirect()->route('admin.programOutcome')->with('success', 'Program Outcome updated successfully.');
    }
    public function destroyPo($po_id)
    {
        $po = ProgramOutcome::findorfail($po_id);
        $po->delete();

        return redirect()->route('admin.programOutcome')->with('success', 'Program Outcome deleted successfully.');
    }
}
