<?php

namespace App\Livewire;

use App\Models\UserRole;
use App\Models\Roles;
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
        $chairperson = UserRole::where('user_id', Auth::id())
            ->where('entity_type', '=', 'Department')
            ->where('role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
            ->whereNotNull('entity_id')
            ->orderByDesc('updated_at')
            ->firstOrFail();

        if ($chairperson) {
            $department_id = $chairperson->entity_id;
            
            $toss = BayanihanGroup::join('tos', function ($join) {
                    $join->on('tos.bg_id', '=', 'bayanihan_groups.bg_id')
                        ->whereRaw("
                            tos.tos_version = (
                                SELECT MAX(t2.tos_version)
                                FROM tos t2
                                WHERE t2.syll_id = tos.syll_id
                                AND t2.tos_term = tos.tos_term
                                AND t2.chair_submitted_at IS NOT NULL
                            )
                        ");
                })
                ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
                ->join('courses', 'courses.course_id', '=', 'tos.course_id')
                ->where('tos.department_id', '=', $department_id)
                ->whereIn('tos.tos_term', ['Midterm', 'Final'])
                ->where(function ($query) {
                    $query->where('courses.course_year_level', 'like', '%' . $this->search . '%')
                        ->orWhere('courses.course_semester', 'like', '%' . $this->search . '%')
                        ->orWhere('bayanihan_groups.bg_school_year', 'like', '%' . $this->search . '%')
                        ->orWhere('courses.course_title', 'like', '%' . $this->search . '%')
                        ->orWhere('courses.course_code', 'like', '%' . $this->search . '%')
                        ->orWhere('tos.tos_status', 'like', '%' . $this->search . '%');
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
            $toss = collect();
        }

        return view('livewire.chair-tos', ['toss' => $toss, 'filters' => $this->filters]);
    }
    public function applyFilters()  
    {
        $this->resetPage();
    }
}
