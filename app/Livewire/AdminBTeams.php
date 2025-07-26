<?php

namespace App\Livewire;

use App\Models\BayanihanGroup;
use App\Models\BayanihanGroupUsers; 
use App\Models\Course;
use App\Models\Department;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination; 

class AdminBTeams extends Component
{
    use WithPagination;
    public $search = '';
    public $filters = [
        'course_code' => null,
        'department_id' => null,
        'bg_school_year' => null,
        'course_semester' => null
    ];
    public function render()
    {
        $users = User::all();

        $bgroups = BayanihanGroup::with('leaders.user', 'members.user')
            ->join('courses', 'bayanihan_groups.course_id', '=', 'courses.course_id')
            ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
            ->join('departments', 'departments.department_id', '=', 'curricula.department_id')
            ->select('courses.*', 'bayanihan_groups.*')
            ->where(function ($query) {
                $query->where('courses.course_semester', 'like', '%' . $this->search . '%')
                    ->orWhere('bayanihan_groups.bg_school_year', 'like', '%' . $this->search . '%')
                    ->orWhere('courses.course_title', 'like', '%' . $this->search . '%')
                    ->orWhere('courses.course_code', 'like', '%' . $this->search . '%')
                    ->orWhereHas('members.User', function ($subquery) {
                        $subquery->where('lastname', 'like', '%' . $this->search . '%')
                            ->orWhere('firstname', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('leaders.User', function ($subquery) {
                        $subquery->where('firstname', 'like', '%' . $this->search . '%')
                            ->orWhere('lastname', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->filters['course_semester'], function ($query) {
                $query->where('courses.course_semester', 'like', '%' .$this->filters['course_semester']);
            })
            ->when($this->filters['bg_school_year'], function ($query) {
                $query->where('bayanihan_groups.bg_school_year', 'like', '%' .$this->filters['bg_school_year']);
            })
            ->when($this->filters['course_code'], function ($query) {
                $query->where('courses.course_code', 'like', '%' .$this->filters['course_code']);
            })
            ->when($this->filters['department_id'], function ($query) {
                $query->where('departments.department_id', 'like', '%' .$this->filters['department_id']);
            })
            ->paginate(10);

        $bmembers = BayanihanGroupUsers::join('users', 'bayanihan_group_users.user_id', '=', 'users.id')
            ->select('users.*', 'bayanihan_group_users.*')
            ->where('bayanihan_group_users.bg_role', '=', 'member')
            ->get()
            ->groupBy('bg_id');
        $bleaders = BayanihanGroupUsers::join('users', 'bayanihan_group_users.user_id', '=', 'users.id')
            ->select('users.*', 'bayanihan_group_users.*')
            ->where('bayanihan_group_users.bg_role', '=', 'leader')
            ->get()
            ->groupBy('bg_id');

        $courses = Course::all();

        $departments = Department::all();
            
        return view('livewire.admin-b-teams', ['bgroups' => $bgroups, 'bleaders' => $bleaders, 'bmembers' => $bmembers, 'courses' => $courses, 'users' => $users, 'departments' => $departments]);
    }
    public function applyFilters()
    {
        $this->resetPage();
    }
}
