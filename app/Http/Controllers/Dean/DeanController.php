<?php

namespace App\Http\Controllers\Dean;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DepartmentController;
use App\Models\User;
use App\Models\College;
use App\Models\Department;
use App\Models\Chairperson; 
use App\Models\Roles;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DeanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $deanRoleId = Roles::where('role_name', 'Dean')->value('role_id'); 

        $college = College::join('user_roles', function ($join) use ($deanRoleId, $user) {
                $join->on('user_roles.entity_id', '=', 'colleges.college_id')
                    ->where('user_roles.entity_type', 'College')
                    ->where('user_roles.role_id', $deanRoleId)
                    ->where('user_roles.user_id', $user->id);
            })
            ->select('colleges.*')
            ->firstOrFail();
            
        $departments = Department::where('college_id', $college->college_id)
            ->paginate(10);
        
        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');

        $chairs = Department::join('user_roles', function ($join) use ($chairRoleId) {  
                $join->on('user_roles.entity_id', '=', 'departments.department_id')
                    ->where('user_roles.entity_type', 'Department')
                    ->where('user_roles.role_id', $chairRoleId);
            })
            ->join('users', 'users.id', '=', 'user_roles.user_id')
            ->join('colleges', 'colleges.college_id', '=', 'departments.college_id')
            ->where('colleges.college_id', $college->college_id)
            ->select('departments.*', 'user_roles.*', 'users.*')
            ->paginate(10);

        $notifications = $user->notifications;

        return view('Dean.home',compact('notifications', 'college', 'departments', 'chairs'));
    }
    public function departments()
    {
        $user = Auth::user();
        $deanRoleId = Roles::where('role_name', 'Dean')->value('role_id'); 

        $college = College::join('user_roles', function ($join) use ($deanRoleId, $user) {
                $join->on('user_roles.entity_id', '=', 'colleges.college_id')
                    ->where('user_roles.entity_type', 'College')
                    ->where('user_roles.role_id', $deanRoleId)
                    ->where('user_roles.user_id', $user->id);
            })
            ->select('colleges.*')
            ->firstOrFail();
            
        $departments = Department::where('college_id', $college->college_id)
            ->paginate(10);
        
        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');

        $chairs = Department::join('user_roles', function ($join) use ($chairRoleId) {  
                $join->on('user_roles.entity_id', '=', 'departments.department_id')
                    ->where('user_roles.entity_type', 'Department')
                    ->where('user_roles.role_id', $chairRoleId);
            })
            ->join('users', 'users.id', '=', 'user_roles.user_id')
            ->join('colleges', 'colleges.college_id', '=', 'departments.college_id')
            ->where('colleges.college_id', $college->college_id)
            ->select('departments.*', 'user_roles.*', 'users.*')
            ->paginate(10);

        $notifications = $user->notifications;
        
        return view('Dean.Departments.departmentHome',compact('notifications','college', 'departments', 'chairs'));
    }
    public function chairperson()
    {
        $user = Auth::user(); 
        $deanRoleId = Roles::where('role_name', 'Dean')->value('role_id'); 

        $college = College::join('user_roles', function ($join) use ($deanRoleId, $user) {
                $join->on('user_roles.entity_id', '=', 'colleges.college_id')
                    ->where('user_roles.entity_type', 'College')
                    ->where('user_roles.role_id', $deanRoleId)
                    ->where('user_roles.user_id', $user->id);
            })
            ->select('colleges.*')
            ->firstOrFail();

        $departments = Department::where('college_id', $college->college_id)
            ->paginate(10);
        
        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');

        $chairs = Department::join('user_roles', function ($join) use ($chairRoleId) {  
                $join->on('user_roles.entity_id', '=', 'departments.department_id')
                    ->where('user_roles.entity_type', 'Department')
                    ->where('user_roles.role_id', $chairRoleId);
            })
            ->join('users', 'users.id', '=', 'user_roles.user_id')
            ->join('colleges', 'colleges.college_id', '=', 'departments.college_id')
            ->where('colleges.college_id', $college->college_id)
            ->select('departments.*', 'user_roles.*', 'users.*')
            ->paginate(10);

        $notifications = $user->notifications;

        return view('Dean.Chairs.chairperson',compact('notifications','college', 'departments', 'chairs'));
    }
    public function destroyDepartment(Department $department_id)
    {
        $department_id->delete();
        return redirect()->route('dean.departments')->with('success', 'Department deleted successfully.');
    }
    public function createDepartment()
    {
        $user = Auth::user(); 
        $deanRoleId = Roles::where('role_name', 'Dean')->value('role_id'); 

        $college = College::join('user_roles', function ($join) use ($deanRoleId, $user) {
                $join->on('user_roles.entity_id', '=', 'colleges.college_id')
                    ->where('user_roles.entity_type', 'College')
                    ->where('user_roles.role_id', $deanRoleId)
                    ->where('user_roles.user_id', $user->id);
            })
            ->select('colleges.*')
            ->firstOrFail();

        $departments = Department::where('college_id', $college->college_id)
            ->paginate(10);
            
        $users = User::all();
        
        $notifications = $user->notifications;

        return view('Dean.Departments.departmentCreate', compact('notifications','college', 'users'));
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
        
        return redirect()->route('dean.departments')->with('success', 'Department created successfully.');
    }
    public function editDepartment(string $department_id)
    {
        $user = Auth::user(); 
        $notifications = $user->notifications;

        $department = Department::where('department_id', $department_id)->firstOrFail();

        return view('Dean.Departments.departmentEdit', compact('department', 'notifications'));
    }
    public function updateDepartment(Request $request, string $department_id){

        $department = Department::findorFail($department_id);

        $request->validate([
            'department_code' => 'required|string',
            'department_status' => 'required|string',
            'department_name' => 'required|string',
            'program_code' => 'required|string',
            'program_name' => 'required|string',
        ]);

        $department->update([
            'department_code' =>  $request->input('department_code'),
            'department_status' =>  $request->input('department_status'),
            'department_name' =>  $request->input('department_name'),
            'program_code' =>  $request->input('program_code'),
            'program_name' =>  $request->input('program_name'),
        ]);

        return redirect()->route('dean.departments')->with('success', 'Department Information Updated');
    }
    public function createChair()
    {
        $user = Auth::user(); 

        $deanRoleId = Roles::where('role_name', 'Dean')->value('role_id'); 

        $college = College::join('user_roles', function ($join) use ($deanRoleId, $user) {
                $join->on('user_roles.entity_id', '=', 'colleges.college_id')
                    ->where('user_roles.entity_type', 'College')
                    ->where('user_roles.role_id', $deanRoleId)
                    ->where('user_roles.user_id', $user->id);
            })
            ->select('colleges.*')
            ->firstOrFail();

        $departments = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
            ->where('colleges.college_id', $college->college_id)
            ->paginate(10);
            
        $users = User::all();

        $notifications = $user->notifications;
        return view('Dean.Chairs.chairCreate', compact('notifications', 'users', 'departments'));
    }
    public function storeChair(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'department_id' => 'required',
            'start_validity' => 'required|date',
            'end_validity' => 'nullable|date|after:start_validity',
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
            ->exists();

        if ($userHasChairRole) {
            return back()->with('error', 'This user is already assigned as chair in another department.');
        }

        DB::transaction(function () use ($request, $chairRoleId) {

            /* ------------------------------------------------------------
            | Close any CURRENT chair assignment on this department
            |-------------------------------------------------------------*/
            UserRole::where('role_id',  $chairRoleId)
                    ->where('entity_type', 'Department')
                    ->where('entity_id',   $request->department_id)
                    ->where(function ($q) use ($request) {
                        $q->whereNull('end_validity')
                        ->orWhere('end_validity', '>', $request->start_validity);
                    })
                    ->update(['end_validity' => $request->start_validity]);

            /* ------------------------------------------------------------
            | Create new chair assignment (Saves past Chair assignment for historical tracking)
            |-------------------------------------------------------------*/
            UserRole::create([
                'role_id'        => $chairRoleId,
                'entity_type'    => 'Department',
                'entity_id'      => $request->department_id,
                'user_id'        => $request->user_id,
                'start_validity' => $request->start_validity,
                'end_validity'   => $request->end_validity,
            ]);
        });

        return redirect()->route('dean.chairs')->with('success', 'Chair created successfully.');
    }
    public function editChair(string $ur_id)
    {
        $user = Auth::user(); 
        $notifications = $user->notifications;

        $departments = Department::all();
        $colleges = College::all();
        $users = User::all();

        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');

        $userRole = UserRole::where('ur_id', $ur_id)
            ->where('role_id', $chairRoleId)
            ->where('entity_type', 'Department')
            ->firstOrFail();

        $allChairs = UserRole::with(['user', 'entity'])
            ->where('role_id',     $chairRoleId)
            ->where('entity_type', 'Department')
            ->get();

        return view(
            'Dean.Chairs.chairEdit',
            compact('notifications', 'chair', 'users', 'departments', 'colleges', 'allChairs', 'ur_id')
        );
    }
    public function updateChair(Request $request, string $ur_id)
    {   
        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');

        $request->validate([
            'user_id' => 'required',
            'department_id' => 'required',
            'start_validity' => 'required|date',
            'end_validity' => 'required|date|after:start_validity',
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
                ->where('ur_id', '!=', $ur_id)
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

        return redirect()->route('dean.chairs')->with('success', 'Chair Information Updated');
    }
    public function destroyChair(string $ur_id)
    {
        $chair = UserRole::where('ur_id', $ur_id)
            ->where('role_id', Roles::where('role_name', 'Chairperson')->value('role_id'))
            ->where('entity_type', 'Department')
            ->firstOrFail();

        $chair->delete();

        return redirect()->route('dean.chairs')->with('success', 'Chair deleted successfully.');
    }
   
}
    
    