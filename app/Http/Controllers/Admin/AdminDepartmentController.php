<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chairperson;
use App\Models\College;
use App\Models\Dean;
use App\Models\Course;
use App\Models\User;
use App\Models\Curriculum;
use App\Models\Department;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class AdminDepartmentController extends Controller
{
    public function index()
    {
        $departments = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
            ->paginate(10);

        $colleges = College::all();

        $chairs = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
            ->join('chairpeople', 'chairpeople.department_id', '=', 'departments.department_id')
            ->join('users', 'users.id', '=', 'chairpeople.user_id')
            ->select('departments.*', 'chairpeople.*', 'users.*')
            ->paginate(10);

        return view('Admin.Department.departmentList', compact('colleges', 'departments', 'chairs'));
    }
    public function createDepartment()
    {
        $colleges = College::all();

        $college = Dean::where('user_id', '=', Auth::user()->id)->first();
        $departments = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
            ->join('chairpeople', 'chairpeople.department_id', '=', 'departments.department_id')
            ->get();
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
        $department = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
            ->where('departments.department_id', '=', $department_id)
            ->get();
        $colleges = College::all();

        return view('Admin.Department.departmentEdit', [
            'department' => Department::where('department_id', $department_id)->first()
        ],  compact('department', 'colleges'));
    }
    public function updateDepartment(Request $request, string $department_id)
    {
        $department = Department::findorFail($department_id);
        $request->validate([
            'department_code' => 'required|string',
            'department_status' => 'required|string',
            'program_code' => 'required|string',
            'program_name' => 'required|string',
            'department_name' => 'required|string',
        ]);
        $department->update([
            'department_code' =>  $request->input('department_code'),
            'department_status' =>  $request->input('department_status'),
            'department_name' =>  $request->input('department_name'),
            'program_code' =>  $request->input('program_code'),
            'program_name' =>  $request->input('program_name'),
        ]);
        return redirect()->route('admin.department')
            ->with('success', 'Department Information Updated');
    }
    public function destroyDepartment(Department $department_id)
    {
        $department_id->delete();
        return redirect()->route('admin.department')
            ->with('success', 'Department deleted successfully.');
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
            'end_validity' => 'required|date|after:start_validity',
        ]);

        UserRole::firstOrCreate([
            'role_id' => 3,
            'user_id' => $request->user_id,
        ]);

        Chairperson::create($request->all());
        return redirect()->route('admin.department')->with('success', 'Chair created successfully.');
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
            ->join('users', 'chairpeople.user_id', '=', 'users.id')
            ->where('chairpeople.chairman_id', '=', $chairman_id)
            ->select('chairpeople.*', 'departments.*', 'users.*')
            ->get();

        return view('Admin.Department.chairEdit', [
            'chair' => Chairperson::where('chairman_id', $chairman_id)->first()
        ], compact('users', 'chair', 'user_chair', 'departments', 'colleges', 'chairpeople', 'chairman_id'));
    }
    public function updateChair(Request $request, string $chairman_id)
    {
        $chair = Chairperson::findorFail($chairman_id);
        $request->validate([
            'user_id' => 'required',
            'department_id' => 'required',
            'start_validity' => 'required|date',
            'end_validity' => 'required|date|after:start_validity',
        ]);
        $chair->update([
            'user_id' => $request->input('user_id'),
            'department_id' => $request->input('department_id'),
            'start_validity' => $request->input('start_validity'),
            'end_validity' => $request->input('end_validity'),
        ]);

        UserRole::firstOrCreate([
            'role_id' => 3,
            'user_id' => $request->user_id,
        ]);
        return redirect()->route('admin.department')
            ->with('success', 'Chair Information Updated');
    }
    public function destroyChair(Chairperson $chairman_id)
    {
        $chairman_id->delete();
        return redirect()->route('admin.department')
            ->with('success', 'Chair deleted successfully.');
    }
}
