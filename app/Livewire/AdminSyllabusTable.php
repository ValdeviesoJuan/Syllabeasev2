<?php

namespace App\Livewire;

use App\Models\BayanihanGroup;
use App\Models\College;
use App\Models\Department;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class AdminSyllabusTable extends Component
{
    use WithPagination;
    public $search = '';
    public $filters = [
        'course_year_level' => null,
        'course_semester' => null,
        'status' => null,
        'bg_school_year' => null,
        'department_id' => null,
        'college_id' => null,
    ];
    public function render()
    {
        $colleges = College::all();

        $departments = Department::all();

        $syllabi = BayanihanGroup::join('syllabi', function ($join) {
                        $join->on('syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
                        ->where('syllabi.version', '=', DB::raw('(SELECT MAX(version) FROM syllabi WHERE bg_id = bayanihan_groups.bg_id AND chair_submitted_at IS NOT NULL)'));
                    })
                    ->leftJoin('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
                    ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
                    ->where(function ($query){
                        $query->where('courses.course_year_level', 'like', '%' .$this->search . '%')
                        ->orWhere('courses.course_semester', 'like', '%' . $this->search . '%')
                        ->orWhere('bayanihan_groups.bg_school_year', 'like', '%' . $this->search . '%')
                        ->orWhere('courses.course_title', 'like', '%' . $this->search . '%')
                        ->orWhere('courses.course_code', 'like', '%' . $this->search . '%')
                        ->orWhere('syllabi.status', 'like', '%' . $this->search . '%')
                        ->orWhere('syllabi.department_id', 'like', '%' . $this->search . '%')
                        ->orWhere('syllabi.college_id', 'like', '%' . $this->search . '%');
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
                    ->when($this->filters['department_id'], function ($query) {
                        $query->where('syllabi.department_id', 'like', '%' .$this->filters['department_id']);
                    })
                    ->when($this->filters['college_id'], function ($query) {
                        $query->where('syllabi.college_id', 'like', '%' .$this->filters['college_id']);
                    })
                    ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
                    ->paginate(10);

        return view('livewire.admin-syllabus-table', ['syllabi' => $syllabi, 'filters' => $this->filters, 'departments' => $departments, 'colleges' => $colleges]);
    }
    public function applyFilters()
    {
        $this->resetPage();
    }
}
