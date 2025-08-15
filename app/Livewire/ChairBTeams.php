<?php

namespace App\Livewire;

use App\Models\BayanihanGroup;
use App\Models\BayanihanGroupUsers; 
use App\Models\Course;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ChairBTeams extends Component
{
    use WithPagination;
    public $search = '';
    public $filters = [
        'bg_school_year' => null,
        'course_semester' => null,
        'course_code' => null,
        'leader_user_id' =>null,
        'member_user_id' =>null,
    ];
    public function render()
    {
        $users = User::all();
        $chairperson = UserRole::where('user_id', Auth::id())
            ->where('entity_type', '=', 'Department')
            ->where('role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
            ->whereNotNull('entity_id')
            ->orderByDesc('updated_at')
            ->firstorfail();

        if ($chairperson) { 
            $department_id = $chairperson->entity_id;
            $bgroups = BayanihanGroup::with('leaders.user', 'members.user')
                ->join('courses', 'bayanihan_groups.course_id', '=', 'courses.course_id')
                ->select('courses.*', 'bayanihan_groups.*')
                ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
                ->where('curricula.department_id', '=', $department_id)
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
                ->when($this->filters['leader_user_id'], function ($query) {
                    $query->join('bayanihan_group_users', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
                        ->where('bayanihan_group_users.bg_role', '=', 'leader')
                        ->where('bayanihan_group_users.user_id', 'like', '%' . $this->filters['leader_user_id']);
                })
                ->when($this->filters['member_user_id'], function ($query) {
                    $query->join('bayanihan_group_users', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
                        ->where('bayanihan_group_users.bg_role', '=', 'member')
                        ->where('bayanihan_group_users.user_id', 'like', '%' . $this->filters['member_user_id']);
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

            $courses = Course::join('curricula', 'courses.curr_id', '=', 'curricula.curr_id')
                ->join('departments', 'curricula.department_id', '=', 'departments.department_id')
                ->join('colleges', 'departments.college_id', '=', 'colleges.college_id')
                ->select('colleges.*', 'departments.*', 'colleges.*', 'courses.*', 'curricula.*')
                ->where('departments.department_id', '=', $department_id)
                ->paginate(10);
                
            } else {
                $bgroups = [];
                $bleaders = [];
                $bmembers = [];
                $courses = [];
            }
            
        return view('livewire.chair-b-teams', ['bgroups' => $bgroups, 'bleaders' => $bleaders, 'bmembers' => $bmembers, 'courses' => $courses, 'users' => $users]);
    }
    public function applyFilters()
    {
        $this->resetPage();
    }
}
