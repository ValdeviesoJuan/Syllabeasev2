<?php

namespace App\Livewire;

use App\Models\BayanihanGroup;
use App\Models\BayanihanGroupUsers; 
use App\Models\Chairperson;
use App\Models\Tos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class BLTos extends Component
{
    use WithPagination;
    public $search = '';
    public $filters = [
        'course_year_level' => null,
        'course_semester' => null,
        'tos_status' => null,
        'bg_school_year' => null,
        'tos_term' => null,
    ];
    public function render()
    {
        $myGroup = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->where('bayanihan_group_users.user_id', '=', Auth::user()->id)
            ->where('bayanihan_group_users.bg_role', '=', 'leader')
            ->select('bayanihan_groups.bg_id')
            ->get();
        if ($myGroup) {
            $myGroupBgIds = $myGroup->pluck('bg_id')->toArray();
            $toss = Tos::join('bayanihan_groups', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
                ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
                ->join('courses', 'courses.course_id', '=', 'tos.course_id')
                ->select('tos.*', 'courses.*', 'bayanihan_groups.*')
                ->whereRaw('tos.tos_version = (SELECT MAX(tos_version) FROM tos WHERE bg_id = bayanihan_groups.bg_id)')
                ->whereIn('tos.tos_term', ['Midterm', 'Final'])
                ->whereIn('tos.bg_id', $myGroupBgIds)
                ->whereIn('tos.tos_version', function ($query) {
                    $query->select(DB::raw('MAX(tos_version)'))
                        ->from('tos')
                        ->groupBy('syll_id', 'tos_term');
                })
                // ->where('tos.bg_id', $myGroup->bg_id)
                ->whereIn('tos.bg_id', $myGroupBgIds)
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
                ->when($this->filters['tos_term'], function ($query) {
                    $query->where('tos.tos_term', 'like', '%' . $this->filters['tos_term']);
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

        return view('livewire.b-l-tos', ['toss' => $toss, 'filters' => $this->filters]);
    }
    public function applyFilters()
    {
        $this->resetPage();
    }
}
