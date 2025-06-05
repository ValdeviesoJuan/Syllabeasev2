<?php

namespace App\Livewire;

use App\Models\BayanihanGroup;
use App\Models\Chairperson;
use App\Models\Tos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ChairTos extends Component
{
    use WithPagination;
    public $search = '';
    public $filters = [
        'course_year_level' => null,
        'course_semester' => null,
        'tos_status' => null,
        'bg_school_year' => null,
    ];
    public function render()
    {
        $chairperson = Chairperson::where('user_id', Auth::user()->id)->firstOrFail();
        $department_id = $chairperson->department_id;
        if ($department_id) {
            $toss = Tos::join('bayanihan_groups', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
                ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
                ->where('tos.department_id', '=', $department_id)
                ->join('courses', 'courses.course_id', '=', 'tos.course_id')
                ->select('tos.*', 'courses.*', 'bayanihan_groups.*')
                ->whereNotNull('tos.chair_submitted_at')
                ->whereIn('tos.tos_term', ['Midterm', 'Final'])
                // ->whereRaw('tos.tos_version = (SELECT MAX(tos_version) FROM tos WHERE bg_id = bayanihan_groups.bg_id AND chair_submitted_at IS NOT NULL)')
                ->whereIn('tos.tos_version', function ($query) {
                    $query->select(DB::raw('MAX(tos_version)'))
                        ->from('tos')
                        ->groupBy('syll_id', 'tos_term');
                })
                // ->whereNotNull('tos.chair_submitted_at')
                ->where(function ($query) {
                    $query->where('courses.course_year_level', 'like', '%' . $this->search . '%')
                        ->orWhere('courses.course_semester', 'like', '%' . $this->search . '%')
                        ->orWhere('bayanihan_groups.bg_school_year', 'like', '%' . $this->search . '%')
                        ->orWhere('courses.course_title', 'like', '%' . $this->search . '%')
                        ->orWhere('courses.course_code', 'like', '%' . $this->search . '%')
                        ->orWhere('syllabi.status', 'like', '%' . $this->search . '%');
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
                ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*', 'tos.*', 'tos.chair_submitted_at as tos_chair_submitted_at')
                ->paginate(10);
        } else {
            $toss = [];
        }

        return view('livewire.chair-tos', ['toss' => $toss, 'filters' => $this->filters]);
    }
    public function applyFilters()
    {
        $this->resetPage();
    }
}
