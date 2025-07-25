<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Course;
use App\Models\User;
use App\Models\Roles;
use App\Models\Curriculum;
use App\Models\Department;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\ChairAssigned;


use Illuminate\Http\Request;

class AdminDepartmentController extends Controller
{
    public function index()
    {
        $departments = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
            ->select('departments.*', 'colleges.college_description')
            ->paginate(10, ['*'], 'departments_page');

        $colleges = College::all();

        $chairRoleId = Roles::where('role_name', 'chairperson')->value('role_id');
    
        $chairs = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
            ->join('user_roles', function ($join) use ($chairRoleId) {
                $join->on('user_roles.entity_id', '=', 'departments.department_id')
                    ->where('user_roles.entity_type', 'Department')
                    ->where('user_roles.role_id', $chairRoleId);
            })
            ->join('users', 'users.id', '=', 'user_roles.user_id')
            ->select('departments.*', 'user_roles.*', 'users.*')
            ->paginate(10, ['*'], 'chairs_page');

        return view('Admin.Department.departmentList', compact('colleges', 'departments', 'chairs'));
    }
    public function createDepartment()
    {
        $colleges = College::all();
        $users = User::all();

        return view('Admin.Department.departmentCreate', compact('colleges', 'users'));
    }
    public function storeDepartment(Request $request)
    {
        $request->validate([
            'college_id' => 'required|exists:colleges,college_id',
            'department_code' => 'required|string',
            'department_status' => 'required|string',
            'department_name' => 'required|string',
            'program_code' => 'required|string',
            'program_name' => 'required|string',
        ]);
        Department::create($request->all());

        return redirect()->route('admin.department')->with('success', 'Department created successfully.');
    }
    public function editDepartment(string $department_id)
    {
        $department = Department::with('college')
            ->where('department_id', $department_id)
            ->firstOrFail();

        $colleges = College::all();

        return view('Admin.Department.departmentEdit', compact('department', 'colleges'));
    }
    public function updateDepartment(Request $request, string $department_id)
    {
        $department = Department::findorFail($department_id);

        $request->validate([
            'college_id' => 'required|exists:colleges,college_id',
            'department_code' => 'required|string',
            'department_status' => 'required|string',
            'program_code' => 'required|string',
            'program_name' => 'required|string',
            'department_name' => 'required|string',
        ]);

        $department->update([
            'college_id' => $request->input('college_id'),
            'department_code' =>  $request->input('department_code'),
            'department_status' =>  $request->input('department_status'),
            'department_name' =>  $request->input('department_name'),
            'program_code' =>  $request->input('program_code'),
            'program_name' =>  $request->input('program_name'),
        ]);

        return redirect()->route('admin.department')->with('success', 'Department Information Updated');
    }
    public function destroyDepartment(Department $department_id)
    {
        $department_id->delete();
        return redirect()->route('admin.department')->with('success', 'Department deleted successfully.');
    }
    public function createChair()
    {
        $users = User::all();

        $departments = Department::all();

        return view('Admin.Department.chairCreate', compact('departments', 'users'));
    }
    public function storeChair(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'department_id' => 'required',
            'start_validity' => 'required|date',
            'end_validity'  => 'nullable|date|after:start_validity',
        ]);

        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');

        // ⚠️ 1. Check if the user already holds a chairperson role in any department
        $userHasChairRole = UserRole::where('role_id', $chairRoleId)
            ->where('entity_type', 'Department')
            ->where('user_id', $request->user_id)
            ->where(function ($q) use ($request) {
                $q->whereNull('end_validity')
                ->orWhere('end_validity', '>', $request->start_validity);
            })
            ->whereNotNull('entity_id')
            ->exists();

        if ($userHasChairRole) {
            return back()->with('error', 'This user is already assigned as chair in another department.');
        }
        
        DB::transaction(function () use ($request, $chairRoleId) {
            // End any currently active Chairperson assignment on this department
            UserRole::where('role_id',  $chairRoleId)
                    ->where('entity_type', 'Department')
                    ->where('entity_id',   $request->department_id)
                    ->where(function ($q) use ($request) {
                        $q->whereNull('end_validity')
                        ->orWhere('end_validity', '>', $request->start_validity);
                    })
                    ->update(['end_validity' => $request->start_validity]);

            // Check if there's a record with null entity_id (unassigned chairperson)
            $existingUnassignedRole = UserRole::where('user_id', $request->user_id)
                ->where('role_id', $chairRoleId)
                ->where('entity_type', 'Department')
                ->whereNull('entity_id')
                ->first();

            if ($existingUnassignedRole) {
                // Update the existing unassigned record
                $existingUnassignedRole->update([
                    'entity_id'      => $request->department_id,
                    'start_validity' => $request->start_validity,
                    'end_validity'   => $request->end_validity,
                ]);
            } else {
                // Otherwise, create a new assignment
                UserRole::create([
                    'user_id'        => $request->user_id,
                    'role_id'        => $chairRoleId,
                    'entity_type'    => 'Department',
                    'entity_id'      => $request->department_id,
                    'start_validity' => $request->start_validity,
                    'end_validity'   => $request->end_validity,
                ]);
            }
        });

        // Send email to assigned user
        // $user = User::find($request->user_id);
        // if ($user && $user->email) {
        //     Mail::to($user->email)->send(new ChairAssigned($user));
        // }

        return redirect()->route('admin.department')->with('success', 'Chair created successfully.');
    }
    public function editChair(string $ur_id)
    {   
        $departments = Department::all();
        $colleges = College::all(); 
        $users = User::all();   

        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');

        $userRole = UserRole::where('ur_id', $ur_id)
            ->where('role_id', $chairRoleId)
            ->where('entity_type', 'Department')
            ->firstOrFail();

        return view('Admin.Department.chairEdit', compact(
        'userRole',     
        'departments',
        'colleges',
        'users',
        'ur_id'
    ));
    }
    public function updateChair(Request $request, string $ur_id)
    {
        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');
        
        $request->validate([
            'user_id'       => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,department_id',
            'start_validity'=> 'required|date',
            'end_validity'  => 'nullable|date|after:start_validity',
        ]);

        // 🔒 Check if the user already holds a chairperson role in another department
        $userHasAnotherChair = UserRole::where('role_id', $chairRoleId)
            ->where('entity_type', 'Department')
            ->where('user_id', $request->user_id)
            ->where('ur_id', '!=', $ur_id) // exclude the current record
            ->where(function ($q) use ($request) {
                $q->whereNull('end_validity')
                ->orWhere('end_validity', '>', $request->start_validity);
            })
            ->whereNotNull('entity_id')
            ->exists();

        if ($userHasAnotherChair) {
            return back()->with('error', 'This user is already assigned as chair in another department.');
        }

        DB::transaction(function () use ($request, $chairRoleId, $ur_id) {
            $chair = UserRole::where('ur_id', $ur_id)
                ->where('role_id', $chairRoleId)
                ->where('entity_type', 'Department')
                ->firstOrFail();

            /* ─── Close any overlapping chair assignment for this department ─── */
            UserRole::where('role_id',     $chairRoleId)
                ->where('entity_type', 'Department')
                ->where('entity_id',   $request->department_id)
                ->where('ur_id', '!=', $ur_id) // don’t overwrite the record we’re updating
                ->where(function ($q) use ($request) {
                    $q->whereNull('end_validity')
                    ->orWhere('end_validity', '>', $request->start_validity);
                })  
                ->update(['end_validity' => $request->start_validity]);

            $chair->update([
                'user_id'        => $request->user_id,
                'entity_id'      => $request->department_id,
                'start_validity' => $request->start_validity,
                'end_validity'   => $request->end_validity,
            ]);
        });

        return redirect()->route('admin.department')->with('success', 'Chair Information Updated');
    }
    public function destroyChair(string $ur_id)
    {
        $chair = UserRole::where('ur_id', $ur_id)
            ->where('role_id', Roles::where('role_name', 'Chairperson')->value('role_id'))
            ->where('entity_type', 'Department')
            ->firstOrFail();

        $chair->delete();

        return redirect()->route('admin.department')->with('success', 'Chair deleted successfully.');
    }
}
