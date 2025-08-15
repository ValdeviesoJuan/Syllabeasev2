<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\UserRole;
use App\Models\Roles;
use App\Models\ProgramOutcome;
use App\Models\Department;
use App\Models\POE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChairPOEController extends Controller
{
    public function index()
    {
        $chairperson = UserRole::where('user_id', Auth::id())
            ->where('entity_type', '=', 'Department')
            ->where('role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
            ->whereNotNull('entity_id')
            ->orderByDesc('updated_at')
            ->firstOrFail();
        
        if ($chairperson) {
            $department_id = $chairperson->entity_id;

            $today = now()->toDateString();

            $poes = POE::join('departments', 'poes.department_id', '=', 'departments.department_id')
                ->join('user_roles', 'departments.department_id', '=', 'user_roles.entity_id')
                ->where('user_roles.entity_type', '=', 'Department')
                ->where('user_roles.entity_id', $department_id)
                ->where('user_roles.role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
                // ->where('user_roles.start_validity', '<=', $today)
                // ->where('user_roles.end_validity', '>=', $today)
                ->orderBy('poes.poe_code', 'asc')
                ->select('departments.*', 'poes.*')
                ->get();
        } else {
            $department_id = '';
            $poes = [];
        }

        $user = Auth::user();
        $notifications = $user->notifications;

        return view('Chairperson.POE.poeList', compact('notifications', 'poes', 'department_id'));
    }
    public function createPoe()
    {
        $user = Auth::user();
        $notifications = $user->notifications;
        
        return view('Chairperson.POE.poeCreate', compact('notifications'));
    }
    public function storePoe(Request $request)
    {
        $chairperson = UserRole::where('user_id', Auth::id())
            ->where('entity_type', '=', 'Department')
            ->where('role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
            ->whereNotNull('entity_id')
            ->orderByDesc('updated_at')
            ->firstOrFail();

        $validatedData = $request->validate([
            'poe_code.*' => 'required',
            'poe_description.*' => 'required',
        ]);

        if ($chairperson) {
            $department_id = $chairperson->entity_id;

            foreach ($validatedData['poe_code'] as $key => $poe_code) {
                $poe = new POE();
                $poe->department_id = $department_id;
                $poe->poe_code = $poe_code;
                $poe->poe_description = $validatedData['poe_description'][$key];
                $poe->save();
            }
            
            return redirect()->route('chairperson.poe')->with('success', 'POE created successfully.');

        } else {
            return redirect()->back()->with('error', 'Something went wrong when retrieving Chairperson Details');
        }

    }
    public function editPoe($poe_id)
    {
        $chairperson = UserRole::where('user_id', Auth::id())
            ->where('entity_type', '=', 'Department')
            ->where('role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
            ->whereNotNull('entity_id')
            ->orderByDesc('updated_at')
            ->firstOrFail();

        if ($chairperson) { 
            $department_id = $chairperson->entity_id;
            $poes = POE::join('departments', 'poes.department_id', '=', 'departments.department_id')
                ->join('user_roles', 'departments.department_id', '=', 'user_roles.entity_id')
                ->where('user_roles.user_id', '=', Auth::id())
                ->where('user_roles.entity_type', '=', 'Department')
                ->where('user_roles.entity_id', '=', $department_id)
                ->where('user_roles.role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
                ->select('departments.*', 'poes.*')
                ->get();

        } else {
            $poes = [];
            $department_id = "";
        }

        $user = Auth::user();
        $notifications = $user->notifications;

        return view('Chairperson.POE.poeEdit', compact('notifications', 'poes', 'department_id'));
    }
    public function updatePoe(Request $request, string $department_id)
    {
        $chairperson = UserRole::where('user_id', Auth::id())
            ->where('entity_type', '=', 'Department')
            ->where('role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
            ->whereNotNull('entity_id')
            ->orderByDesc('updated_at')
            ->firstOrFail();

        $validatedData = $request->validate([
            'poe_code.*' => 'required',
            'poe_description.*' => 'required',
        ]);

        if ($chairperson) {
            $department_id = $chairperson->entity_id;
            
            POE::where('department_id', $department_id)->delete();

            foreach ($validatedData['poe_code'] as $key => $poe_code) {
                $poe = new POE();
                $poe->department_id = $department_id;
                $poe->poe_code = $poe_code;
                $poe->poe_description = $validatedData['poe_description'][$key];
                $poe->save();
            }
            
            return redirect()->route('chairperson.poe')->with('success', 'POE updated successfully.');

        } else {
            return redirect()->back()->with('error', 'Something went wrong when retrieving Chairperson Details');
        }
    }
    public function destroyPoe($poe_id)
    {
        $poe = POE::findorfail($poe_id);
        $poe->delete();

        return back()->with('success', 'POE deleted successfully.');
    }
}
