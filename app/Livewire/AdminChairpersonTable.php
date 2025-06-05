<?php

namespace App\Livewire;

use App\Models\Chairperson;
use App\Models\Department;
use App\Models\College;
use App\Models\User;
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

        $chairs = College::join('departments', 'colleges.college_id', '=', 'departments.college_id')
            ->join('chairpeople', 'chairpeople.department_id', '=', 'departments.department_id')
            ->join('users', 'users.id', '=', 'chairpeople.user_id')
            ->select('departments.*', 'chairpeople.*', 'users.*')
            ->where(function ($query) {
            $query->where('departments.department_code', 'like', '%' . $this->search . '%')
                ->orWhere('departments.department_name', 'like', '%' . $this->search . '%')
                ->orWhere('users.lastname', 'like', '%' . $this->search . '%')
                ->orWhere('users.firstname', 'like', '%' . $this->search . '%');
    })
        ->paginate(10);
        return view('livewire.admin-chairperson-table', compact('departments', 'chairs', 'users'));
    }
}
