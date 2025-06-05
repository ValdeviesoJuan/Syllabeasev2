<?php

namespace App\Livewire;

use App\Models\BayanihanGroup;
use App\Models\BayanihanLeader;
use App\Models\Chairperson;
use App\Models\Syllabus;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ChairSyllabusTable extends Component
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
        
        $chairperson = Chairperson::where('user_id', Auth::user()->id)->firstOrFail();
        $department_id = $chairperson->department_id;

            // $syllabi = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            // ->leftJoin('courses', 'courses.course_id', '=',  'bayanihan_groups.course_id')
            // ->where('syllabi.department_id', '=', $department_id)
            // ->whereNotNull('syllabi.chair_submitted_at')
            if ($department_id) {
                $syllabi = BayanihanGroup::join('syllabi', function ($join) {
                        $join->on('syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
                        ->where('syllabi.version', '=', DB::raw('(SELECT MAX(version) FROM syllabi WHERE bg_id = bayanihan_groups.bg_id AND chair_submitted_at IS NOT NULL)'));
                    })
                    // ->where('syllabi.status', 'Pending')
                    ->where('syllabi.department_id', '=', $department_id)
                    // ->whereNotNull('syllabi.chair_submitted_at')
                    ->leftJoin('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
                    ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
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
                    ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
                    ->paginate(10);
            } else {
                $syllabi = [];
            }

        return view('livewire.chair-syllabus-table', ['syllabi' => $syllabi, 'filters' => $this->filters]);
    }
    public function applyFilters()
    {
        $this->resetPage();
    }
}
