<?php

namespace App\Livewire;

use App\Models\Chairperson;
use App\Models\Department;
use App\Models\College;
use App\Models\User;
use App\Models\Roles;
use Livewire\Component;
use Livewire\WithPagination;

class AdminChairpersonTable extends Component
{
    use WithPagination;
    public $search = '';
    
    public function render()
    {
        $users = User::all();
        $colleges = College::all();
        $departments = Department::all();

        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');

        $chairs = Department::query()
            ->join('user_roles', function ($join) use ($chairRoleId) {
                $join->on('user_roles.entity_id', '=', 'departments.department_id')
                    ->where('user_roles.entity_type', 'Department')
                    ->where('user_roles.role_id',  $chairRoleId);
            })
            ->join('users', 'users.id', '=', 'user_roles.user_id')
            ->leftJoin('colleges', 'colleges.college_id', '=', 'departments.college_id')
            ->select('departments.*', 'user_roles.*', 'users.*')
            ->when($this->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('departments.department_code', 'like', "%{$search}%")
                    ->orWhere('departments.department_name', 'like', "%{$search}%")
                    ->orWhere('users.lastname', 'like', "%{$search}%")
                    ->orWhere('users.firstname', 'like', "%{$search}%");
                });
            })
            ->paginate(10);

        return view('livewire.admin-chairperson-table', compact('departments', 'chairs', 'users'));
    }
}
