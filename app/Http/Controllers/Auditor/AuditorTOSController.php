<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use App\Models\BayanihanGroupUsers;
use App\Models\SyllabusCourseOutcome;
use Illuminate\Http\Request;
use App\Models\TOS;
use App\Models\TosRows;

class AuditorTOSController extends Controller
{
    public function index()
    {   
        return view('auditor.TOS.tosList');
    }

    public function viewTos($tos_id)
    {   
        $tos = Tos::where('tos_id', $tos_id)
            ->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'tos.bg_id')
            ->join('courses', 'courses.course_id', '=', 'tos.course_id')
            ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
            ->select('tos.*', 'bayanihan_groups.*', 'courses.*')
            ->first(); 

        $chair = $tos->chair;
            
        $tos_rows = TosRows::where('tos_rows.tos_id', '=', $tos_id)
            ->leftJoin('tos', 'tos.tos_id', '=', 'tos_rows.tos_id')
            ->select('tos.*', 'tos_rows.*')
            ->get();

        $course_outcomes = SyllabusCourseOutcome::where('syll_id', '=', $tos->syll_id)
            ->select('syllabus_course_outcomes.*')
            ->get();
       
        $bLeaders = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_group_users.user_id')
            ->select('bayanihan_group_users.*', 'users.*')
            ->where('tos.tos_id', '=', $tos_id)
            ->where('bayanihan_group_users.bg_role', '=', 'leader')
            ->get();
        $bMembers = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_group_users.user_id')
            ->select('bayanihan_group_users.*', 'users.*')
            ->where('tos.tos_id', '=', $tos_id)
            ->where('bayanihan_group_users.bg_role', '=', 'member')
            ->get();
            
        $tosVersions = Tos::where('bg_id', $tos->bg_id)
            ->where('tos_term', $tos->tos_term)
            ->select('tos.*')
            ->orderByDesc('created_at')
            ->get();

        return view('auditor.TOS.tosView', compact('tos_rows', 'tos', 'tos_id', 'bMembers', 'bLeaders', 'tosVersions', 'course_outcomes', 'chair'));
    }
}
