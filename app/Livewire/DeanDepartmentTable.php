<?php

namespace App\Livewire;

use App\Models\College;
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
        $college = College::join('deans', 'colleges.college_id', '=', 'deans.college_id')
        ->where('deans.user_id', '=', Auth::user()->id)
        ->first();

        if($college->college_id){
            $departments = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
            ->where('colleges.college_id', $college->college_id)
            ->where(function ($query){
                $query->where('departments.department_code', 'like', '%' .$this->search . '%')
                ->orWhere('departments.department_name', 'like', '%' . $this->search . '%')
                ->orWhere('departments.program_code', 'like', '%' . $this->search . '%')
                ->orWhere('departments.program_name', 'like', '%' . $this->search . '%')
                ->orWhere('departments.department_status', 'like', '%' . $this->search . '%')
                ->orWhere('colleges.college_code', 'like', '%' . $this->search . '%');
            });
        }else{
            $college = [];
        }
        return view('livewire.dean-department-table');
    }
}
