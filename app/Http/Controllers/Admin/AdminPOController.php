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
    public function viewPo(string $department_id)
    {
        $department = Department::where('departments.department_id', '=', $department_id)
            ->select('departments.*')
            ->first();

        $programOutcomes = ProgramOutcome::join('departments', 'program_outcomes.department_id', '=', 'departments.department_id')
            ->where('program_outcomes.department_id', '=', $department_id)
            ->orderBy('program_outcomes.po_letter', 'asc')
            ->select('departments.*', 'program_outcomes.*')
            ->get();
        
        return view('admin.po.polist', compact( 'programOutcomes',  'department'));
    }
    public function createPo(string $department_id)
    {
        $department = Department::where('department_id', '=', $department_id)
            ->select('departments.*')
            ->first();

        return view('admin.po.pocreate', compact('department'));
    }
    public function storePo(Request $request, string $department_id)
    {
        // Validate the array inputs properly
        $validatedData = $request->validate([
            'po_letter' => 'required|array',
            'po_letter.*' => 'required|string',
            'po_description' => 'required|array',
            'po_description.*' => 'required|string',
        ]);

        // Check for matching counts
        if (count($validatedData['po_letter']) !== count($validatedData['po_description'])) {
            return back()->withErrors('Mismatch between PO letters and descriptions.');
        }

        foreach ($validatedData['po_letter'] as $index => $poLetter) {
            ProgramOutcome::create([
                'department_id'   => $department_id,
                'po_letter'       => $poLetter,
                'po_description'  => $validatedData['po_description'][$index],
            ]);
        }

        return redirect()->route('admin.viewPo', $department_id)->with('success', 'Program Outcomes created successfully.');
    }
    public function editPo(string $department_id)
    {
        $department = Department::where('department_id', '=', $department_id)
            ->select('departments.*')
            ->first();

        $programOutcomes = ProgramOutcome::join('departments', 'program_outcomes.department_id', '=', 'departments.department_id')
            ->where('program_outcomes.department_id', '=', $department_id)
            ->orderBy('program_outcomes.po_letter', 'asc')
            ->select('departments.*', 'program_outcomes.*')
            ->get();

        return view('admin.po.poedit', compact('programOutcomes', 'department'));
    }
    public function updatePo(Request $request, string $department_id)
    {
        $validatedData = $request->validate([
            'po_letter' => 'required|array',
            'po_letter.*' => 'required|string',
            'po_description' => 'required|array',
            'po_description.*' => 'required|string',
        ]);

        ProgramOutcome::where('department_id', $department_id)->delete();

        foreach ($validatedData['po_letter'] as $index => $poLetter) {
            ProgramOutcome::create([
                'department_id'   => $department_id,
                'po_letter'       => $poLetter,
                'po_description'  => $validatedData['po_description'][$index],
            ]);
        }

        return redirect()->route('admin.viewPo', $department_id)->with('success', 'Program Outcome updated successfully.');
    }
    public function destroyPo(string $po_id)
    {
        $po = ProgramOutcome::findorfail($po_id);
        $po->delete();

        return back()->with('success', 'Program Outcome deleted successfully.');
    }
}
