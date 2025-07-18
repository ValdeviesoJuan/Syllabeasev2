<?php

namespace App\Livewire;

use App\Models\BayanihanGroup;
use App\Models\BayanihanGroupUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class BTSyllabusTable extends Component
{
    use WithPagination;
    public $search = '';
    public $filters = [
        'course_year_level' => null,
        'course_semester' => null,
        'status' => null,
        'bg_school_year' => null,
    ];
    public function render()
    {
        $myDepartment = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
                ->join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
                ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
                ->join('departments', 'departments.department_id', '=', 'curricula.department_id')
                ->where('bayanihan_group_users.user_id', '=', Auth::user()->id)
                ->where('bayanihan_group_users.bg_role', '=', 'member')
                ->select('departments.department_id')
                ->first();
        $myGroup = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->where('bayanihan_group_users.user_id', '=', Auth::user()->id)
            ->where('bayanihan_group_users.bg_role', '=', 'member')
            ->select('bayanihan_groups.bg_id')
            ->get();
            if ($myGroup) {
                $myGroupBgIds = $myGroup->pluck('bg_id')->toArray();
                $syllabi = BayanihanGroup::join('syllabi', function ($join) {
                        $join->on('syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
                        ->where('syllabi.version', '=', DB::raw('(SELECT MAX(version) FROM syllabi WHERE bg_id = bayanihan_groups.bg_id)'));
                    })
                    ->whereIn('syllabi.bg_id', $myGroupBgIds)
                    // ->where('syllabi.status', 'Pending')
                    // ->where('syllabi.department_id', '=', $myDepartment->department_id)
                    // ->whereNotNull('syllabi.chair_submitted_at')
                    ->leftJoin('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
                    ->leftJoin('deadlines', function ($join) {
                        $join->on('deadlines.dl_semester', '=', 'courses.course_semester')
                            ->on('deadlines.dl_school_year', '=', 'bayanihan_groups.bg_school_year')
                            ->on('deadlines.college_id', '=', 'syllabi.college_id');
                    })
                    ->where(function ($query){
                        $query->where('courses.course_year_level', 'like', '%' .$this->search . '%')
                        ->orWhere('courses.course_semester', 'like', '%' . $this->search . '%')
                        ->orWhere('bayanihan_groups.bg_school_year', 'like', '%' . $this->search . '%')
                        ->orWhere('courses.course_title', 'like', '%' . $this->search . '%')
                        ->orWhere('courses.course_code', 'like', '%' . $this->search . '%')
                        ->orWhere('syllabi.status', 'like', '%' . $this->search . '%');
                    })
                    ->when($this->filters['course_year_level'], function ($query) {
                        $query->where('courses.course_year_level', 'like', '%' .$this->filters['course_year_level']);
                    })
                    ->when($this->filters['course_semester'], function ($query) {
                        $query->where('courses.course_semester', 'like', '%' .$this->filters['course_semester']);
                    })
                    ->when($this->filters['status'], function ($query) {
                        $query->where('syllabi.status', 'like', '%' .$this->filters['status']);
                    })
                    ->when($this->filters['bg_school_year'], function ($query) {
                        $query->where('bayanihan_groups.bg_school_year', 'like', '%' .$this->filters['bg_school_year']);
                    })
                    ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*', 'deadlines.*')
                    ->paginate(10);
            } else {
                $syllabi = collect([]);
            }
        return view('livewire.b-t-syllabus-table', ['syllabi' => $syllabi, 'filters' => $this->filters]);
    }
    public function applyFilters()
    {
        $this->resetPage();
    }
}
