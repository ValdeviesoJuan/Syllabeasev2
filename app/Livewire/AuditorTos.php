<?php

namespace App\Livewire;

use App\Models\Department;
use Livewire\Component;
use App\Models\Tos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class AuditorTos extends Component
{
    use WithPagination;
    public $search = '';
    public $filters = [
        'course_year_level' => null,
        'course_semester' => null, 
        'bg_school_year' => null,
        'department_code' => null
    ];
    public function render()
    {
        $toss = Tos::join('bayanihan_groups', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
            ->join('courses', 'courses.course_id', '=', 'tos.course_id')
            ->join('departments', 'departments.department_id', '=', 'tos.department_id')
            ->select('tos.*', 'courses.*', 'bayanihan_groups.*')
            ->whereNotNull('tos.chair_approved_at')
            ->whereIn('tos.tos_term', ['Midterm', 'Final'])
            ->whereIn('tos.tos_version', function ($query) {
                $query->select(DB::raw('MAX(tos_version)'))
                    ->from('tos')
                    ->groupBy('syll_id', 'tos_term');
            })
            ->where(function ($query) {
                $query->where('courses.course_year_level', 'like', '%' . $this->search . '%')
                    ->orWhere('courses.course_semester', 'like', '%' . $this->search . '%')
                    ->orWhere('bayanihan_groups.bg_school_year', 'like', '%' . $this->search . '%')
                    ->orWhere('courses.course_title', 'like', '%' . $this->search . '%')
                    ->orWhere('courses.course_code', 'like', '%' . $this->search . '%')
                    ->orWhere('departments.department_code', 'like', '%' . $this->search . '%');
            })
            ->when($this->filters['course_year_level'], function ($query) {
                $query->where('courses.course_year_level', 'like', '%' . $this->filters['course_year_level']);
            })
            ->when($this->filters['course_semester'], function ($query) {
                $query->where('courses.course_semester', 'like', '%' . $this->filters['course_semester']);
            }) 
            ->when($this->filters['bg_school_year'], function ($query) {
                $query->where('bayanihan_groups.bg_school_year', 'like', '%' . $this->filters['bg_school_year']);
            })
            ->when($this->filters['department_code'], function ($query) {
                $query->where('departments.department_code', 'like', '%' . $this->filters['department_code']);
            })
            ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*', 'tos.*', 'tos.chair_approved_at as tos_chair_approved_at')
            ->paginate(10);
        
        $departments = Department::all();

        return view('livewire.auditor-tos', ['toss' => $toss, 'departments' => $departments, 'filters' => $this->filters]);
    }
    public function applyFilters()
    {
        $this->resetPage();
    }
}
