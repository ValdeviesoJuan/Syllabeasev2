<?php

namespace App\Livewire;

use App\Models\BayanihanGroup;
use Illuminate\Support\Facades\DB;
use App\Models\BayanihanLeader;
use App\Models\Syllabus;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BlCreateSyllabus extends Component
{
    public $isOpen = false;
    public function openComments()
    {
        $this->isOpen = true;
    }
    public function closeComments()
    {
        $this->isOpen = false;
    }
    public function render()
    {
        /*
        |--------------------------------------------------------------
        | 1.  Find every Bayanihan Group the leader belongs to
        |     …but keep ONLY the ones that do not yet have a syllabus.
        |     For each such group we need:   bg_id ▸ course_id ▸ department_id
        |--------------------------------------------------------------
        */
        $groupsNeedingSyllabusQB = BayanihanGroup::query()
            ->join('bayanihan_leaders',  'bayanihan_leaders.bg_id',     '=', 'bayanihan_groups.bg_id')
            ->leftJoin('syllabi as existing', 'existing.bg_id',         '=', 'bayanihan_groups.bg_id')
            ->join('courses',            'courses.course_id',           '=', 'bayanihan_groups.course_id')
            ->join('curricula',          'curricula.curr_id',           '=', 'courses.curr_id')
            ->join('departments',        'departments.department_id',   '=', 'curricula.department_id')
            ->where('bayanihan_leaders.bg_user_id', Auth::user()->id)
            ->whereNull('existing.syll_id')                // group has **no** syllabus yet
            ->select(
                'bayanihan_groups.bg_id        as target_bg_id',
                'bayanihan_groups.course_id    as target_course_id',
                'departments.department_id     as target_department_id'
            );
            
        $groupsCollection = (clone $groupsNeedingSyllabusQB)->get();

        $courseIds = $groupsCollection->pluck('target_course_id')->unique()->toArray();
        $deptIds   = $groupsCollection->pluck('target_department_id')->unique()->toArray();
        
        if (empty($courseIds)) {
            return view('livewire.bl-create-syllabus', ['syllabi' => collect()]);
        }

        $syllabi = Syllabus::query()
            ->join('courses',     'courses.course_id',         '=', 'syllabi.course_id')
            ->join('curricula',   'curricula.curr_id',         '=', 'courses.curr_id')
            ->join('departments', 'departments.department_id', '=', 'curricula.department_id')
            ->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            ->whereIn('syllabi.course_id',         $courseIds)
            ->whereIn('departments.department_id', $deptIds)
            ->whereNotNull('syllabi.dean_approved_at')
            ->where('syllabi.status', 'Approved by Dean')
            ->joinSub($groupsNeedingSyllabusQB, 'target_groups', function ($join) {
                $join->on('target_groups.target_course_id',     '=', 'syllabi.course_id')
                    ->on('target_groups.target_department_id', '=', 'departments.department_id');
            })
            ->select(
                'syllabi.*',
                DB::raw('target_groups.target_bg_id'),
                'courses.*',
                'bayanihan_groups.*'
            )
            ->distinct()
            ->get();

        /*
        |--------------------------------------------------------------
        | 5.  Return view
        |--------------------------------------------------------------
        */
        return view('livewire.bl-create-syllabus', ['syllabi' => $syllabi]);

        // $myDepartment = BayanihanLeader::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_leaders.bg_id')
        // ->join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
        // ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
        // ->join('departments', 'departments.department_id', '=', 'curricula.department_id')
        // ->where('bayanihan_leaders.bg_user_id', '=', Auth::user()->id)
        // ->select('departments.department_id')
        // ->first();

        // if ($myDepartment) {
        //     $syllabi = BayanihanGroup::join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
        //         ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
        //         ->join('courses', 'courses.course_id', '=', 'syllabi.course_id')
        //         ->where('syllabi.department_id', '=', $myDepartment->department_id)
        //         ->whereNotNull('dean_approved_at') 
        //         ->where('status', '=', 'Approved by Dean')
        //         ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
        //         ->distinct()
        //         ->get();
        // } else {
        //     $syllabi = [];
        // }
        //     return view('livewire.bl-create-syllabus',['syllabi' => $syllabi]);
    }
}
