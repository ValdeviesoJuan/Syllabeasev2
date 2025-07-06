<?php

namespace App\Livewire;

use App\Models\College;
use App\Models\Roles;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DeanDepartmentTable extends Component
{
    use WithPagination;
    public $search = '';
    public $filters = [
        'department_code' => null,
        'department_name' => null,
        'program_code' => null,
        'program_name' => null,
        'department_status' => null,
    ];
    public function render()
    {
        $user = Auth::user();
        $deanRoleId = Roles::where('role_name', 'Dean')->value('role_id'); 

        $college = UserRole::where('user_roles.entity_type', 'College')
            ->where('user_roles.role_id', $deanRoleId)
            ->where('user_roles.user_id', $user->id)
            ->firstOrFail();

        $college_id = $college->entity_id;

        if($college_id) {
            $departments = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
            ->where('colleges.college_id', $college_id)
            ->where(function ($query){
                $query->where('departments.department_code', 'like', '%' .$this->search . '%')
                ->orWhere('departments.department_name', 'like', '%' . $this->search . '%')
                ->orWhere('departments.program_code', 'like', '%' . $this->search . '%')
                ->orWhere('departments.program_name', 'like', '%' . $this->search . '%')
                ->orWhere('departments.department_status', 'like', '%' . $this->search . '%')
                ->orWhere('colleges.college_code', 'like', '%' . $this->search . '%');
            });
        } else {
            $college = [];
        }
        return view('livewire.dean-department-table');
    }
}
