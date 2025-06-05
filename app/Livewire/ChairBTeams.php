<?php

namespace App\Livewire;

use App\Models\Chairperson;
use App\Models\BayanihanGroup;
use App\Models\BayanihanLeader;
use App\Models\bayanihanMember;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;


class ChairBTeams extends Component
{
    use WithPagination;
    public $search = '';

    public $selectedOption;

    public $filters = [
        'bg_school_year' => null,
        'course_semester' => null,
        'course_code' => null,
        'leader_user_id' =>null,
        'member_user_id' =>null,
    ];
    public function render()
    {
        $chairperson = Chairperson::where('user_id', Auth::user()->id)->firstOrFail();
        $department_id = $chairperson->department_id;

        $users = User::all();
        $bgroups = BayanihanGroup::with('BayanihanLeaders.User', 'BayanihanMembers.User')
            ->join('courses', 'bayanihan_groups.course_id', '=', 'courses.course_id')
            ->select('courses.*', 'bayanihan_groups.*')
            ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
            ->where('curricula.department_id', '=', $department_id)
            ->where(function ($query) {
                $query->where('courses.course_semester', 'like', '%' . $this->search . '%')
                    ->orWhere('bayanihan_groups.bg_school_year', 'like', '%' . $this->search . '%')
                    ->orWhere('courses.course_title', 'like', '%' . $this->search . '%')
                    ->orWhere('courses.course_code', 'like', '%' . $this->search . '%')
                    ->orWhereHas('BayanihanMembers.User', function ($subquery) {
                        $subquery->where('lastname', 'like', '%' . $this->search . '%')
                            ->orWhere('firstname', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('BayanihanLeaders.User', function ($subquery) {
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
                $query->join('bayanihan_leaders', 'bayanihan_groups.bg_id', '=', 'bayanihan_leaders.bg_id')
                      ->where('bayanihan_leaders.bg_user_id', 'like', '%' . $this->filters['leader_user_id']);
            })
            ->when($this->filters['member_user_id'], function ($query) {
                $query->join('bayanihan_members', 'bayanihan_groups.bg_id', '=', 'bayanihan_members.bg_id')
                      ->where('bayanihan_members.bm_user_id', 'like', '%' . $this->filters['member_user_id']);
            })
            ->paginate(10);

        $bmembers = bayanihanMember::join('users', 'bayanihan_members.bm_user_id', '=', 'users.id')
            ->select('users.*', 'bayanihan_members.*')
            ->get()
            ->groupBy('bg_id');
        $bleaders = BayanihanLeader::join('users', 'bayanihan_leaders.bg_user_id', '=', 'users.id')
            ->select('users.*', 'bayanihan_leaders.*')
            ->get()
            ->groupBy('bg_id');
        $courses = Course::join('curricula', 'courses.curr_id', '=', 'curricula.curr_id')
            ->join('departments', 'curricula.department_id', '=', 'departments.department_id')
            ->join('colleges', 'departments.college_id', '=', 'colleges.college_id')
            ->select('colleges.*', 'departments.*', 'colleges.*', 'courses.*', 'curricula.*')
            ->where('departments.department_id', '=', $department_id)
            ->paginate(10);
        return view('livewire.chair-b-teams', ['bgroups' => $bgroups, 'bleaders' => $bleaders, 'bmembers' => $bmembers, 'courses' => $courses, 'users'=>$users]);
    }
    public function applyFilters()
    {
        $this->resetPage();
    }
}
