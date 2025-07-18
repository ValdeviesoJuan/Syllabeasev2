<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserRole;
use App\Models\Roles;
use App\Models\ProgramOutcome;
use App\Models\Department;
use App\Models\POE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPOEController extends Controller
{
    public function viewPoe(string $department_id)
    {
        $department = Department::where('departments.department_id', '=', $department_id)
            ->select('departments.*')
            ->first();

        $poes = POE::join('departments', 'poes.department_id', '=', 'departments.department_id')
            ->where('poes.department_id', '=', $department_id)
            ->select('departments.*', 'poes.*')
            ->get();

        return view('admin.poe.poeList', compact('poes', 'department'));
    }
    public function createPoe(string $department_id)
    {
        $department = Department::where('department_id', '=', $department_id)
            ->select('departments.*')
            ->first();

        return view('admin.poe.poeCreate', compact('department'));
    }
    public function storePoe(Request $request, string $department_id)
    {
        $validatedData = $request->validate([
            'poe_code' => 'required|array',
            'poe_code.*' => 'required|string',
            'poe_description' => 'required|array',
            'poe_description.*' => 'required|string',
        ]);

        // Check for matching counts
        if (count($validatedData['poe_code']) !== count($validatedData['poe_description'])) {
            return back()->withErrors('Mismatch between POE codes and descriptions.');
        }

        foreach ($validatedData['poe_code'] as $index => $poe_code) {
            POE::create([
                'department_id'   => $department_id,
                'poe_code'       => $poe_code,
                'poe_description'  => $validatedData['poe_description'][$index],
            ]);
        }

        return redirect()->route('admin.viewPoe', $department_id)->with('success', 'POE created successfully.');
    }

    public function editPoe(string $department_id)
    {
        $department = Department::where('department_id', '=', $department_id)
            ->select('departments.*')
            ->first();
            
        $poes = POE::join('departments', 'poes.department_id', '=', 'departments.department_id')
            ->where('poes.department_id', '=', $department_id)
            ->select('departments.*', 'poes.*')
            ->get();

        return view('admin.poe.poeEdit', compact( 'poes', 'department'));
    }
    public function updatePoe(Request $request, string $department_id)
    {
        $validatedData = $request->validate([
            'poe_code' => 'required|array',
            'poe_code.*' => 'required|string',
            'poe_description' => 'required|array',
            'poe_description.*' => 'required|string',
        ]);

        POE::where('department_id', $department_id)->delete();

        foreach ($validatedData['poe_code'] as $index => $poe_code) {
            POE::create([
                'department_id'   => $department_id,
                'poe_code'       => $poe_code,
                'poe_description'  => $validatedData['poe_description'][$index],
            ]);
        }

        return redirect()->route('admin.viewPoe', $department_id)->with('success', 'POE updated successfully.');
    }
    public function destroyPoe(string $poe_id)
    {
        $poe = POE::findorfail($poe_id);
        $poe->delete();

        return back()->with('success', 'POE deleted successfully.');
    }
}
