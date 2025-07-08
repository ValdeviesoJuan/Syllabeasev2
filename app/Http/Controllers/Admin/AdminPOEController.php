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
    public function index()
    {
        $today = now()->toDateString();

        $poes = POE::join('departments', 'poes.department_id', '=', 'departments.department_id')
            ->join('user_roles', 'departments.department_id', '=', 'user_roles.entity_id')
            ->where('user_roles.entity_type', '=', 'Department')
            ->where('user_roles.role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
            // ->where('user_roles.start_validity', '<=', $today)
            // ->where('user_roles.end_validity', '>=', $today)
            ->orderBy('poes.poe_code', 'asc')
            ->select('departments.*', 'poes.*')
            ->get();

        return view('admin.poe.poeList', compact('poes'));
    }
}
