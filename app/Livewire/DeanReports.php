<?php

namespace App\Livewire;

use App\Models\BayanihanGroup;
use App\Models\Dean;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DeanReports extends Component
{
    use WithPagination;
    public $search = '';
    public $filters = [
        'course_year_level' => null,
        'course_semester' => null,
        'status' => null,
        'bg_school_year' => null,
        'department_code' => null,

    ];
    public function render()
    {
        $dean = Dean::where('user_id', Auth::user()->id)->firstOrFail();
        $college_id = $dean->college_id;
        $departments = Department::where('departments.college_id', $college_id)
            ->select('departments.*')
            ->get();
        if ($college_id) {
            $syllabi = BayanihanGroup::join('syllabi', function ($join) {
                $join->on('syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
                    ->where('syllabi.version', '=', DB::raw('(SELECT MAX(version) FROM syllabi WHERE bg_id = bayanihan_groups.bg_id AND dean_submitted_at IS NOT NULL)'));
            })
                ->where('syllabi.college_id', '=', $college_id)
                ->whereNotNull('syllabi.dean_submitted_at')
                ->leftJoin('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
                ->join('departments', 'departments.department_id', 'syllabi.department_id')
                ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
                ->where(function ($query) {
                    $query->where('courses.course_year_level', 'like', '%' . $this->search . '%')
                        ->orWhere('courses.course_semester', 'like', '%' . $this->search . '%')
                        ->orWhere('bayanihan_groups.bg_school_year', 'like', '%' . $this->search . '%')
                        ->orWhere('courses.course_title', 'like', '%' . $this->search . '%')
                        ->orWhere('courses.course_code', 'like', '%' . $this->search . '%')
                        ->orWhere('departments.department_code', 'like', '%' . $this->search . '%')
                        ->orWhere('departments.department_name', 'like', '%' . $this->search . '%')
                        ->orWhere('syllabi.status', 'like', '%' . $this->search . '%');
                })
                ->when($this->filters['course_year_level'], function ($query) {
                    $query->where('courses.course_year_level', 'like', '%' . $this->filters['course_year_level']);
                })
                ->when($this->filters['course_semester'], function ($query) {
                    $query->where('courses.course_semester', 'like', '%' . $this->filters['course_semester']);
                })
                ->when($this->filters['status'], function ($query) {
                    $query->where('syllabi.status', 'like', '%' . $this->filters['status']);
                })
                ->when($this->filters['bg_school_year'], function ($query) {
                    $query->where('bayanihan_groups.bg_school_year', 'like', '%' . $this->filters['bg_school_year']);
                })
                ->when($this->filters['department_code'], function ($query) {
                    $query->where('departments.department_code', 'like', '%' . $this->filters['department_code']);
                })
                ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*', 'departments.*')
                ->paginate(10);

            $syllabiCount = $syllabi->count();

            // Total number of Bayanihan teams
            $distinctBayanihanTeams = $syllabi->pluck('bg_id')->unique()->count();
        } else {
            $syllabi = [];
        }
        return view('livewire.dean-reports', ['syllabi' => $syllabi, 'filters' => $this->filters, 'departments' => $departments, 'syllabiCount' => $syllabiCount, 'distinctBayanihanTeams' => $distinctBayanihanTeams]);
    }
    public function applyFilters()
    {
        $this->resetPage();
    }
}
