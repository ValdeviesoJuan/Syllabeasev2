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
        $deanRoleId = Roles::where('role_name', 'Dean')->value('role_id'); 
        $college_id = UserRole::where('user_id', Auth::id())
            ->where('entity_type', '=', 'College')
            ->where('role_id', '=', $deanRoleId)
            ->select('user_roles.entity_id')
            ->first();

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
            $departments = [];
        }

        return view('livewire.dean-department-table', ['departments' => $departments, 'filters' => $this->filters,]);
    }
    public function applyFilters()
    {
        $this->resetPage();
    }
}
