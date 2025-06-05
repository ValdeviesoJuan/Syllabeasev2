<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\BayanihanLeader;
use App\Models\bayanihanMember;
use App\Models\Syllabus;
use App\Models\SyllabusCotCoM;
use App\Models\SyllabusCourseOutcome;
use App\Models\SyllabusCourseOutlineMidterm;
use App\Models\Tos;
use App\Models\TosRows;
use App\Models\User;
use App\Notifications\BL_TOSChairApproved;
use App\Notifications\BL_TOSChairReturned;
use App\Notifications\BT_TOSChairApproved;
use App\Notifications\BT_TOSChairReturned;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChairTOSController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications;
        return view('Chairperson.Tos.tosList', compact('notifications'));
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
        $user = Auth::user();
        $notifications = $user->notifications;
        return view('Chairperson.Tos.tosView', compact('notifications', 'chair', 'tos_rows', 'tos', 'tos_id', 'bMembers', 'bLeaders', 'tosVersions', 'course_outcomes'));
    }
    public function approveTos($tos_id)
    {
        $tos = Tos::find($tos_id);

        if (!$tos) {
            return redirect()->route('bayanihanleader.tos')->with('error', 'Tos not found.');
        }
        $tos->chair_approved_at = Carbon::now();
        $tos->tos_status = 'Approved by Chair';
        $tos->save();

        $submitted_tos = Tos::where('tos_id', $tos_id)
            ->join('bayanihan_groups', 'bayanihan_groups.bg_id', 'tos.bg_id')
            ->join('courses', 'courses.course_id', 'bayanihan_groups.course_id')
            ->select('bayanihan_groups.bg_school_year', 'courses.course_code', 'tos.bg_id')
            ->first();

        $course_code = $submitted_tos->course_code;
        $bg_school_year = $submitted_tos->bg_school_year;

        // Notification for Bayanihan Members 
        $bayanihan_leaders = BayanihanLeader::where('bg_id', $submitted_tos->bg_id)->get();
        $bayanihan_members = BayanihanMember::where('bg_id', $submitted_tos->bg_id)->get();
        foreach ($bayanihan_leaders as $leader) {
            $user = User::find($leader->bg_user_id);
            if ($user) {
                $user->notify(new BL_TOSChairApproved($course_code, $bg_school_year, $tos_id));
            }
        }
        foreach ($bayanihan_members as $member) {
            $user = User::find($member->bm_user_id);
            if ($user) {
                $user->notify(new BT_TOSChairApproved($course_code, $bg_school_year, $tos_id));
            }
        }

        return redirect()->route('chairperson.tos')->with('success', 'TOS approval successful.');
    }
    public function returnTos($tos_id)
    {
        $tos = Tos::find($tos_id);

        if (!$tos) {
            return redirect()->route('bayanihanleader.tos')->with('error', 'Tos not found.');
        }
        $tos->chair_returned_at = Carbon::now();
        $tos->tos_status = 'Returned by Chair';
        $tos->save();

        $submitted_tos = Tos::where('tos_id', $tos_id)
            ->join('bayanihan_groups', 'bayanihan_groups.bg_id', 'tos.bg_id')
            ->join('courses', 'courses.course_id', 'bayanihan_groups.course_id')
            ->select('bayanihan_groups.bg_school_year', 'courses.course_code', 'tos.bg_id')
            ->first();

        $course_code = $submitted_tos->course_code;
        $bg_school_year = $submitted_tos->bg_school_year;

        // Notification for Bayanihan Members 
        $bayanihan_leaders = BayanihanLeader::where('bg_id', $submitted_tos->bg_id)->get();
        $bayanihan_members = BayanihanMember::where('bg_id', $submitted_tos->bg_id)->get();
        foreach ($bayanihan_leaders as $leader) {
            $user = User::find($leader->bg_user_id);
            if ($user) {
                $user->notify(new BL_TOSChairReturned($course_code, $bg_school_year, $tos_id));
            }
        }
        foreach ($bayanihan_members as $member) {
            $user = User::find($member->bm_user_id);
            if ($user) {
                $user->notify(new BT_TOSChairReturned($course_code, $bg_school_year, $tos_id));
            }
        }


        return redirect()->route('chairperson.commentTos', $tos_id)->with('success', 'TOS approval successful.');
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
        $user = Auth::user();
        $notifications = $user->notifications;
        return view('Chairperson.Tos.tosComment', compact('notifications', 'tos_rows', 'tos', 'tos_id', 'bMembers', 'bLeaders', 'tosVersions', 'course_outcomes'));
    }
}
