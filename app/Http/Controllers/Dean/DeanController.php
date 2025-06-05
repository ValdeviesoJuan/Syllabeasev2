<?php

namespace App\Http\Controllers\Dean;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DepartmentController;
use App\Models\User;
use App\Models\College;
use App\Models\Dean;
use App\Models\Department;
use App\Models\Chairperson;
use App\Models\BayanihanMember;
use App\Models\BayanihanLeader;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DeanController extends Controller
{
    public function index()
    {
        $college = College::join('deans', 'colleges.college_id', '=', 'deans.college_id')
        ->where('deans.user_id', '=', Auth::user()->id)
        ->first();

        $departments = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
        ->where('colleges.college_id', $college->college_id)
        ->paginate(10);

       
        $chairs = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
        ->join('chairpeople', 'chairpeople.department_id', '=', 'departments.department_id')
        ->join('users', 'users.id', '=', 'chairpeople.user_id')
        ->select('departments.*', 'chairpeople.*', 'users.*')
        ->paginate(10);

        $user = Auth::user(); 
        $notifications = $user->notifications;
         return view('Dean.home',compact('notifications', 'college', 'departments', 'chairs'));
    }
    public function departments()
    {
        $college = College::join('deans', 'colleges.college_id', '=', 'deans.college_id')
        ->where('deans.user_id', '=', Auth::user()->id)
        ->first();

        $departments = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
        ->where('colleges.college_id', $college->college_id)
        ->paginate(10);

        $chairs = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
        ->join('chairpeople', 'chairpeople.department_id', '=', 'departments.department_id')
        ->join('users', 'users.id', '=', 'chairpeople.user_id')
        ->select('departments.*', 'chairpeople.*', 'users.*')
        ->paginate(10);
        $user = Auth::user(); 
        $notifications = $user->notifications;
         return view('Dean.Departments.departmentHome',compact('notifications','college', 'departments', 'chairs'));
    }
    public function chairperson()
    {
        $college = College::join('deans', 'colleges.college_id', '=', 'deans.college_id')
        ->where('deans.user_id', '=', Auth::user()->id)
        ->first();

        $departments = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
        ->where('colleges.college_id', $college->college_id)
        ->paginate(10);

        $chairs = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
        ->join('chairpeople', 'chairpeople.department_id', '=', 'departments.department_id')
        ->join('users', 'users.id', '=', 'chairpeople.user_id')
        ->where('colleges.college_id', $college->college_id)
        ->select('departments.*', 'chairpeople.*', 'users.*')
        ->paginate(10);
        $user = Auth::user(); 
        $notifications = $user->notifications;
         return view('Dean.Chairs.chairperson',compact('notifications','college', 'departments', 'chairs'));
    }
    public function destroyDepartment(Department $department_id)
    {
        $department_id->delete();
        return redirect()->route('dean.departments')
            ->with('success', 'Department deleted successfully.');
    }
    public function createDepartment()
    {
        $college = Dean::where('user_id', '=', Auth::user()->id)->first();
        $departments = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
        ->join('chairpeople', 'chairpeople.department_id', '=', 'departments.department_id')
        ->where('colleges.college_id', $college->college_id)
        ->get();
        $users = User::all();
        $user = Auth::user(); 
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
        $department = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
        ->where('departments.department_id', '=', $department_id)
        ->get();
        $user = Auth::user(); 
        $notifications = $user->notifications;
        return view('Dean.Departments.departmentEdit', [
            'department' => Department::where('department_id', $department_id)->first()
        ],  compact('notifications', 'department'));
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
        return redirect()->route('dean.departments')
        ->with('success', 'Department Information Updated');
    }
    public function createChair()
    {
        $users = User::all();
        $college = College::join('deans', 'colleges.college_id', '=', 'deans.college_id')
        ->where('deans.user_id', '=', Auth::user()->id)
        ->first();

        $departments = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
        ->where('colleges.college_id', $college->college_id)
        ->paginate(10);
        $user = Auth::user(); 
        $notifications = $user->notifications;
        return view('Dean.Chairs.chairCreate', compact('notifications', 'users', 'departments'));
    }
    public function storeChair(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'department_id' => 'required',
            'start_validity' => 'required|date',
            'end_validity' => 'required|date|after:start_validity',
        ]);

        UserRole::firstOrCreate([
            'role_id' => 3,
            'user_id' => $request->user_id,
        ]);

        Chairperson::create($request->all());
        return redirect()->route('dean.chairs')->with('success', 'Chair created successfully.');
    }
    public function editChair(string $chairman_id)
    {
        $chairpeople = Chairperson::all();
        $departments = Department::all();
        $colleges = College::all();
        $users = User::all();
        $user_chair = Chairperson::join('users', 'chairpeople.chairman_id', '=', 'users.id')
        ->select('chairpeople.*', 'users.*')->get();

        $chair = Chairperson::join('departments', 'chairpeople.department_id', '=', 'departments.department_id')
        ->join('users', 'chairpeople.user_id', '=','users.id')
        ->where('chairpeople.chairman_id', '=', $chairman_id)
        ->select('chairpeople.*', 'departments.*', 'users.*')
        ->get();
        $user = Auth::user(); 
        $notifications = $user->notifications;
        return view('Dean.Chairs.chairEdit', [
            'chair' => Chairperson::where('chairman_id', $chairman_id)->first()
        ], compact('notifications', 'users', 'chair', 'user_chair', 'departments', 'colleges', 'chairpeople', 'chairman_id'));
    }
    public function updateChair(Request $request, string $chairman_id){
        $chair = Chairperson::findorFail($chairman_id);
        $request->validate([
            'user_id' => 'required',
            'department_id' => 'required',
            'start_validity' => 'required|date',
            'end_validity' => 'required|date|after:start_validity',
        ]);
        $chair->update([
            'user_id'=> $request->input('user_id'),
            'department_id'=> $request->input('department_id'),
            'start_validity' => $request->input('start_validity'),
            'end_validity' => $request->input('end_validity'),
        ]);

        UserRole::firstOrCreate([
            'role_id' => 3,
            'user_id' => $request->user_id,
        ]);
        
        return redirect()->route('dean.chairs')
        ->with('success', 'Chair Information Updated');
    }
    public function destroyChair(Chairperson $chairman_id)
    {
        $chairman_id->delete();
        return redirect()->route('dean.chairs')
            ->with('success', 'Chair deleted successfully.');
    }
   
    }
    
    