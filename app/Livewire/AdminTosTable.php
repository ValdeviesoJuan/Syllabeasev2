<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\College;
use App\Models\Tos;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AdminTosTable extends Component
{
    use WithPagination;
    public $search = '';
    public $filters = [
        'course_year_level' => null,
        'course_semester' => null,
        'tos_status' => null,
        'bg_school_year' => null,
        'department_id' => null,
        'college_id' => null,
    ];
    public function render()
    {
        $departments = Department::all();

        $colleges = College::all();

        $toss = Tos::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'tos.bg_id')
                ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
                ->join('courses', 'courses.course_id', '=', 'tos.course_id')
                ->join('departments', 'departments.department_id', '=', 'tos.department_id')
                ->join('colleges', 'colleges.college_id', '=', 'departments.college_id')
                ->select('tos.*', 'courses.*', 'bayanihan_groups.*')
                ->whereIn('tos.tos_term', ['Midterm', 'Final'])
                // ->whereRaw('tos.tos_version = (SELECT MAX(tos_version) FROM tos WHERE bg_id = bayanihan_groups.bg_id AND chair_submitted_at IS NOT NULL)')
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
                        ->orWhere('syllabi.status', 'like', '%' . $this->search . '%')
                        ->orWhere('departments.department_code', 'like', '%' . $this->search . '%')
                        ->orWhere('departments.department_name', 'like', '%' . $this->search . '%')
                        ->orWhere('colleges.college_code', 'like', '%' . $this->search . '%')
                        ->orWhere('colleges.college_description', 'like', '%' . $this->search . '%');
                })
                ->when($this->filters['course_year_level'], function ($query) {
                    $query->where('courses.course_year_level', 'like', '%' . $this->filters['course_year_level']);
                })
                ->when($this->filters['course_semester'], function ($query) {
                    $query->where('courses.course_semester', 'like', '%' . $this->filters['course_semester']);
                })
                ->when($this->filters['tos_status'], function ($query) {
                    $query->where('tos.tos_status', 'like', '%' . $this->filters['tos_status']);
                })
                ->when($this->filters['bg_school_year'], function ($query) {
                    $query->where('bayanihan_groups.bg_school_year', 'like', '%' . $this->filters['bg_school_year']);
                })
                ->when($this->filters['department_id'], function ($query) {
                    $query->where('tos.department_id', 'like', '%' . $this->filters['department_id']);
                })
                ->when($this->filters['college_id'], function ($query) {
                    $query->where('departments.college_id', 'like', '%' . $this->filters['college_id']);
                })
                ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*', 'tos.*', 'tos.chair_submitted_at as tos_chair_submitted_at')
                ->paginate(10);

        return view('livewire.admin-tos-table', ['toss' => $toss, 'filters' => $this->filters, 'departments' => $departments, 'colleges' => $colleges]);
    }
    public function applyFilters()
    {
        $this->resetPage();
    }
}
