<?php

namespace App\Livewire;

use App\Models\BayanihanGroup;
use App\Models\BayanihanGroupUsers;
use App\Models\Syllabus;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BLCreateTos extends Component
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
        $myDepartment = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
            ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
            ->join('departments', 'departments.department_id', '=', 'curricula.department_id')
            ->where('bayanihan_group_users.user_id', '=', Auth::user()->id)
            ->where('bayanihan_group_users.bg_role', '=', 'leader')
            ->select('departments.department_id')
            ->first();

        if ($myDepartment) {
            $syllabi = BayanihanGroup::join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
                ->join('bayanihan_group_users', 'bayanihan_group_users.bg_id', '=', 'bayanihan_groups.bg_id')
                ->join('courses', 'courses.course_id', '=', 'syllabi.course_id')
                ->where('syllabi.department_id', '=', $myDepartment->department_id)
                ->where('bayanihan_group_users.bg_role', '=', 'leader')
                ->whereNotNull('dean_approved_at') 
                ->where('status', '=', 'Approved by Dean')
                ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
                ->distinct()
                ->get();
        } else {
            $syllabi = [];
        }
        return view('livewire.b-l-create-tos',['syllabi' => $syllabi]);
    }
}
