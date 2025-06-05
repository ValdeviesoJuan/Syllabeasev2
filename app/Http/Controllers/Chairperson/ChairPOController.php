<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\Chairperson;
use App\Models\ProgramOutcome;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChairPOController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        $department_id = Chairperson::where('chairpeople.user_id', '=', Auth::user()->id)
            ->select('chairpeople.department_id')
            ->first()
            ->department_id;
        $department_name = Chairperson::where('chairpeople.user_id', '=', Auth::user()->id)
            ->join('departments', 'chairpeople.department_id', '=', 'departments.department_id')
            ->select('department_name')
            ->first()
            ->department_name;
        $today = now()->toDateString();
        $programOutcomes = ProgramOutcome::join('departments', 'program_outcomes.department_id', '=', 'departments.department_id')
            ->join('chairpeople', 'departments.department_id', '=', 'chairpeople.department_id')
            // ->where('chairpeople.start_validity', '<=', $today)
            // ->where('chairpeople.end_validity', '>=', $today)
            ->where('chairpeople.user_id', Auth::user()->id)
            ->orderBy('program_outcomes.po_letter', 'asc')
            ->select('departments.*', 'program_outcomes.*')
            ->get();
            $user = Auth::user(); 
            $notifications = $user->notifications;
        return view('Chairperson.ProgramOutcome.poList', compact('notifications', 'programOutcomes', 'department_id', 'department_name'));
    }
    public function createPo()
    {
        $user = Auth::user(); 
        $notifications = $user->notifications;
        return view('Chairperson.ProgramOutcome.poCreate', compact('notifications'));
    }
    public function storePo(Request $request)
    {
        $department_id = Chairperson::where('chairpeople.user_id', '=', Auth::user()->id)
            ->select('chairpeople.department_id')
            ->first()
            ->department_id;

        $validatedData = $request->validate([
            'po_letter.*' => 'required',
            'po_description.*' => 'required',
        ]);
        foreach ($validatedData['po_letter'] as $key => $poLetter) {
            $outcome = new ProgramOutcome();
            $outcome->department_id = $department_id;
            $outcome->po_letter = $poLetter;
            $outcome->po_description = $validatedData['po_description'][$key];

            $outcome->save();
        }

        return redirect()->route('chairperson.programOutcome')->with('success', 'Program Outcome created successfully.');
    }
    public function editPo($po_id)
    {
        $programOutcomes = ProgramOutcome::join('departments', 'program_outcomes.department_id', '=', 'departments.department_id')
            ->join('chairpeople', 'departments.department_id', '=', 'chairpeople.department_id')
            ->where('chairpeople.user_id', '=', Auth::user()->id)
            ->select('departments.*', 'program_outcomes.*')
            ->get();
        $department_id = Chairperson::where('chairpeople.user_id', '=', Auth::user()->id)
            ->select('chairpeople.department_id')
            ->first()
            ->department_id;
            $user = Auth::user(); 
            $notifications = $user->notifications;
        return view('Chairperson.ProgramOutcome.poEdit', compact('notifications','programOutcomes', 'department_id'));
    }
    public function updatePo(Request $request, string $department_id)
    {
        $department_id = Chairperson::where('chairpeople.user_id', '=', Auth::user()->id)
            ->select('chairpeople.department_id')
            ->first()
            ->department_id;
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
        return redirect()->route('chairperson.programOutcome')->with('success', 'Program Outcome updated successfully.');
    }
    public function destroyPo($po_id)
    {
        $po = ProgramOutcome::findorfail($po_id);
        $po->delete();

        return redirect()->route('chairperson.programOutcome')->with('success', 'Program Outcome deleted successfully.');
    }
}
