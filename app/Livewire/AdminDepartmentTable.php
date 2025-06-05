<?php

namespace App\Livewire;

use App\Models\College;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;

class AdminDepartmentTable extends Component
{

    use WithPagination;
    public $search = '';

    public function render()
    {
        $colleges = College::all();
        $departments = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
            ->select('departments.*')
            ->where(function ($query) {
            $query->where('departments.department_code', 'like', '%' . $this->search . '%')
                ->orWhere('departments.department_name', 'like', '%' . $this->search . '%')
                ->orWhere('departments.program_code', 'like', '%' . $this->search . '%')
                ->orWhere('departments.program_name', 'like', '%' . $this->search . '%');
        })
        ->paginate(10);
        return view('livewire.admin-department-table', compact('colleges', 'departments'));
    }
    public function applyFilters()
    {
        $this->resetPage();
    }
}
