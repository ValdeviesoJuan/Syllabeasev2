<?php

namespace App\Http\Controllers\BayanihanTeacher;

use App\Http\Controllers\Controller;
use App\Models\BayanihanLeader;
use App\Models\BayanihanMember;
use App\Models\Syllabus;
use App\Models\SyllabusCotCoM;
use App\Models\SyllabusCourseOutcome;
use App\Models\SyllabusCourseOutlineMidterm;
use App\Models\Tos;
use App\Models\TosRows;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BayanihanTeacherTOSController extends Controller
{
    public function index()
    {
        $myDepartment = BayanihanMember::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_members.bg_id')
            ->join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
            ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
            ->join('departments', 'departments.department_id', '=', 'curricula.department_id')
            ->where('bayanihan_members.bm_user_id', '=', Auth::user()->id)
            ->select('departments.department_id')
            ->first();
        if ($myDepartment) {
            $toss = Tos::join('bayanihan_groups', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
                ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
                ->join('courses', 'courses.course_id', '=', 'tos.course_id')
                ->select('tos.*', 'courses.*', 'bayanihan_groups.*')
                ->whereRaw('tos.tos_version = (SELECT MAX(tos_version) FROM tos WHERE bg_id = bayanihan_groups.bg_id)')
                ->get();
        } else {
            $toss = [];
        }
        $user = Auth::user(); 
        $notifications = $user->notifications;
        return view('BayanihanTeacher.Tos.tosList', compact('notifications', 'toss'));
    }
    public function commentTos($tos_id)
    {
        $tos = Tos::where('tos_id', $tos_id)->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'tos.bg_id')
            ->join('courses', 'courses.course_id', '=', 'tos.course_id')
            ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
            ->select('tos.*', 'bayanihan_groups.*', 'courses.*')->first();

        $course_outcomes = SyllabusCourseOutcome::where('syll_id', '=', $tos->syll_id)->select('syllabus_course_outcomes.*')->get();

        $tos_rows = TosRows::where('tos_rows.tos_id', '=', $tos_id)
            ->leftJoin('tos', 'tos.tos_id', '=', 'tos_rows.tos_id')
            ->select('tos.*', 'tos_rows.*')
            ->get();
        $bLeaders = BayanihanLeader::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_leaders.bg_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_leaders.bg_user_id')
            ->select('bayanihan_leaders.*', 'users.*')
            ->where('tos.tos_id', '=', $tos_id)
            ->get();

        $bMembers = bayanihanMember::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_members.bg_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_members.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_members.bm_user_id')
            ->select('bayanihan_members.*', 'users.*')
            ->where('tos.tos_id', '=', $tos_id)
            ->get();
        $tosVersions = Tos::where('tos.bg_id', $tos->bg_id)
            ->select('tos.*')
            ->get();
            $chair = Syllabus::join('tos', 'tos.syll_id', '=', 'syllabi.syll_id')
        ->join('chairpeople', 'syllabi.department_id', '=', 'chairpeople.department_id')
        ->join('users', 'users.id', '=', 'chairpeople.user_id')
        ->first();
        return view('BayanihanTeacher.Tos.tosComment', compact('chair','tos_rows', 'tos', 'tos_id', 'bMembers', 'bLeaders', 'tosVersions', 'course_outcomes'));
    }
}
