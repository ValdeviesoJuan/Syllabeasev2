<?php

namespace App\Livewire;

use App\Models\BayanihanGroup;
use App\Models\Department;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class AuditorSyllabusTable extends Component
{
    use WithPagination;
    public $search = '';
    public $filters = [
        'course_year_level' => null,
        'course_semester' => null,
        'bg_school_year' => null,
        'department_code' => null,
    ];
    public function render()
    {
        $syllabi = BayanihanGroup::join('syllabi', function ($join) {
                $join->on('syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
                ->join('departments', 'departments.department_id', '=', 'syllabi.department_id')
                ->where('syllabi.version', '=', DB::raw('(SELECT MAX(version) FROM syllabi WHERE bg_id = bayanihan_groups.bg_id)'));
            })
            ->whereNotNull('syllabi.dean_approved_at')
            ->leftJoin('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
            ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
            ->where(function ($query){
                $query->where('courses.course_year_level', 'like', '%' .$this->search . '%')
                ->orWhere('courses.course_semester', 'like', '%' . $this->search . '%')
                ->orWhere('bayanihan_groups.bg_school_year', 'like', '%' . $this->search . '%')
                ->orWhere('courses.course_title', 'like', '%' . $this->search . '%')
                ->orWhere('courses.course_code', 'like', '%' . $this->search . '%')
                ->orWhere('departments.department_code', 'like', '%' . $this->search . '%');
            })
            ->when($this->filters['course_year_level'], function ($query) {
                $query->where('courses.course_year_level', 'like', '%' .$this->filters['course_year_level']);
            })
            ->when($this->filters['course_semester'], function ($query) {
                $query->where('courses.course_semester', 'like', '%' .$this->filters['course_semester']);
            })
            ->when($this->filters['bg_school_year'], function ($query) {
                $query->where('bayanihan_groups.bg_school_year', 'like', '%' .$this->filters['bg_school_year']);
            })
            ->when($this->filters['department_code'], function ($query) {
                $query->where('departments.department_code', 'like', '%' . $this->filters['department_code']);
            })
            ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
            ->paginate(10);

            
        $departments = Department::all();
        return view('livewire.auditor-syllabus-table', ['syllabi' => $syllabi, 'departments' => $departments, 'filters' => $this->filters]);
    }
    public function applyFilters()
    {
        $this->resetPage();
    }
}
