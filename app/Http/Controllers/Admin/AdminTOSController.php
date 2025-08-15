<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BayanihanGroupUsers;
use Illuminate\Http\Request;

use App\Models\Roles;
use App\Models\TOS;
use App\Models\Syllabus;
use App\Models\SyllabusCourseOutcome;
use App\Models\TosRows;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminTOSController extends Controller
{
    public function index()
    {
        $toss = Tos::join('bayanihan_groups', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
            ->join('courses', 'courses.course_id', '=', 'tos.course_id')
            ->select('tos.*', 'courses.*', 'bayanihan_groups.*')
            ->whereRaw('tos.tos_version = (SELECT MAX(tos_version) FROM tos WHERE bg_id = bayanihan_groups.bg_id)')
            ->whereIn('tos.tos_term', ['Midterm', 'Final'])
            ->whereIn('tos.tos_version', function ($query) {
                $query->select(DB::raw('MAX(tos_version)'))
                    ->from('tos')
                    ->groupBy('syll_id', 'tos_term');
            })
            ->get();

        return view('admin.tos.tosList', compact( 'toss'));
    }
    public function viewTos($tos_id)
    {
        // $toss = Tos::leftJoin('syllabus_course_outcomes', 'tos.syll_id', '=', 'syllabus_course_outcomes.syll_id')
        // ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
        // ->join('courses', 'courses.course_id', '=', 'syllabi.course_id')
        // ->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
        // ->select('tos.*', 'syllabus_course_outcomes.*', 'courses.*', 'bayanihan_groups.*')
        // ->get();
        $tos = Tos::where('tos_id', $tos_id)->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'tos.bg_id')
            ->join('courses', 'courses.course_id', '=', 'tos.course_id')
            ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
            ->select('tos.*', 'bayanihan_groups.*', 'courses.*')->first();

        $chair = $tos->chair;

        $course_outcomes = SyllabusCourseOutcome::where('syll_id', '=', $tos->syll_id)->select('syllabus_course_outcomes.*')->get();
        
        $tos_rows = TosRows::where('tos_rows.tos_id', '=', $tos_id)
            ->leftJoin('tos', 'tos.tos_id', '=', 'tos_rows.tos_id')
            ->select('tos.*', 'tos_rows.*')
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
            
        $tosVersions = Tos::where('tos.bg_id', $tos->bg_id)
            ->select('tos.*')
            ->get(); 

        return view('admin.tos.tosView', compact('tos_rows', 'tos', 'tos_id', 'bMembers', 'bLeaders', 'tosVersions', 'course_outcomes', 'chair'));
    }
    public function commentTos($tos_id)
    {
        $tos = Tos::where('tos_id', $tos_id)->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'tos.bg_id')
            ->join('courses', 'courses.course_id', '=', 'tos.course_id')
            ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
            ->select('tos.*', 'bayanihan_groups.*', 'courses.*')->first();
            
        $chair = $tos->chair;

        $course_outcomes = SyllabusCourseOutcome::where('syll_id', '=', $tos->syll_id)->select('syllabus_course_outcomes.*')->get();

        $tos_rows = TosRows::where('tos_rows.tos_id', '=', $tos_id)
            ->leftJoin('tos', 'tos.tos_id', '=', 'tos_rows.tos_id')
            ->select('tos.*', 'tos_rows.*')
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

        $tosVersions = Tos::where('tos.bg_id', $tos->bg_id)
            ->select('tos.*')
            ->get();

        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');
        $chair = Syllabus::join('tos', 'tos.syll_id', '=', 'syllabi.syll_id')
            ->join('user_roles', 'syllabi.department_id', '=', 'user_roles.entity_id')
            ->join('users', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.entity_type', 'Department')
            ->where('user_roles.role_id', $chairRoleId)
            ->first();
            
        return view('admin.tos.tosComment', compact('chair', 'tos_rows', 'tos', 'tos_id', 'bMembers', 'bLeaders', 'tosVersions', 'course_outcomes'));
    }
    public function destroyTos(Tos $tos_id)
    {
        $tos_id->delete();
        return redirect()->route('admin.tos')->with('success', 'Tos deleted successfully.');
    }
}
