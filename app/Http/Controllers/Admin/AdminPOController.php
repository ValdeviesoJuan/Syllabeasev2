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
        
        return view('admin.po.poList', compact( 'programOutcomes',  'department_name'));
    }
}
