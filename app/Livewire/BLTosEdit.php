<?php

namespace App\Livewire;

use App\Models\SyllabusCourseOutcome;
use App\Models\Tos;
use App\Models\TosRows;
use Livewire\Component;

class BLTosEdit extends Component
{
    public $tos_id;
    public function render()
    {
        $tos = Tos::where('tos_id', $this->tos_id)->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'tos.bg_id')
            ->join('courses', 'courses.course_id', '=', 'tos.course_id')
            ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
            ->select('tos.*', 'bayanihan_groups.*', 'courses.*')->first();
        $course_outcomes = SyllabusCourseOutcome::where('syll_id', '=', $tos->syll_id)->select('syllabus_course_outcomes.*')->get();
        $tos_rows = TosRows::where('tos_rows.tos_id', '=', $this->tos_id)
            ->leftJoin('tos', 'tos.tos_id', '=', 'tos_rows.tos_id')
            ->select('tos.*', 'tos_rows.*')
            ->get();
        
        return view('livewire.b-l-tos-edit', ['tos' => $tos, 'tos_rows' => $tos_rows]);
    }

}
