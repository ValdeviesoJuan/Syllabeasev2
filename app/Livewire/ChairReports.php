<?php

namespace App\Livewire;

use App\Models\BayanihanGroup;
use App\Models\Chairperson;
use App\Models\Tos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ChairReports extends Component
{
    use WithPagination;
    public $search = '';
    public $tos_search = '';
    public $filters = [
        'course_year_level' => null,
        'course_semester' => null,
        'tos_course_semester' => null,
        'tos_bg_school_year' => null,
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
                ->when($this->filters['status'], function ($query) {
                    $query->where('syllabi.status', 'like', '%' . $this->filters['status']);
                })
                ->when($this->filters['bg_school_year'], function ($query) {
                    $query->where('bayanihan_groups.bg_school_year', 'like', '%' . $this->filters['bg_school_year']);
                })
                ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
                ->paginate(10);

            $syllabiCount = $syllabi->count();

            // Total number of Bayanihan teams
            $distinctBayanihanTeams = $syllabi->pluck('bg_id')->unique()->count();

            $toss = Tos::join('bayanihan_groups', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
                ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
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
                ->where('syllabi.department_id', '=', $department_id)
                // ->whereNotNull('tos.chair_submitted_at')
                ->where(function ($query) {
                    $query->where('courses.course_year_level', 'like', '%' . $this->tos_search . '%')
                        ->orWhere('courses.course_semester', 'like', '%' . $this->tos_search . '%')
                        ->orWhere('bayanihan_groups.bg_school_year', 'like', '%' . $this->tos_search . '%')
                        ->orWhere('courses.course_title', 'like', '%' . $this->tos_search . '%')
                        ->orWhere('courses.course_code', 'like', '%' . $this->tos_search . '%')
                        ->orWhere('syllabi.status', 'like', '%' . $this->tos_search . '%');
                })
                ->when($this->filters['tos_course_semester'], function ($query) {
                    $query->where('courses.course_semester', 'like', '%' . $this->filters['tos_course_semester']);
                })
                ->when($this->filters['tos_bg_school_year'], function ($query) {
                    $query->where('bayanihan_groups.bg_school_year', 'like', '%' . $this->filters['tos_bg_school_year']);
                })
                ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*', 'tos.*')
                ->paginate(10);

                $midtermTosCount = $toss->where('tos_term', 'Midterm')->count();
                $finalTosCount = $toss->where('tos_term', 'Final')->count();
            } else {
            $syllabi = [];
            $toss = [];
        }
        return view('livewire.chair-reports', ['syllabi' => $syllabi, 'toss' => $toss, 'syllabiCount'=>$syllabiCount, 'distinctBayanihanTeams'=>$distinctBayanihanTeams, 'midtermTosCount'=>$midtermTosCount, 'finalTosCount'=>$finalTosCount]);
    }
    public function applyFilters()
    {
        $this->resetPage();
    }
}
