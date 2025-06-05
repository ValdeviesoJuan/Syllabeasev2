<?php

namespace App\Http\Controllers\Dean;

use App\Http\Controllers\Controller;
use App\Mail\BLeader;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BayanihanGroup;
use App\Models\BayanihanLeader;
use App\Models\BayanihanMember;
use App\Models\Chairperson;
use App\Models\Course;
use Illuminate\Support\Facades\Mail;
use App\Mail\BTeam;
use App\Models\College;
use App\Models\Dean;
use App\Models\Department;
use App\Models\POE;
use App\Models\ProgramOutcome;
use App\Models\SrfChecklist;
use App\Models\Syllabus;
use App\Models\SyllabusDeanFeedback;
use App\Models\SyllabusCoPo;
use App\Models\SyllabusCotCoF;
use App\Models\SyllabusCotCoM;
use App\Models\SyllabusCourseOutcome;
use App\Models\SyllabusCourseOutlineMidterm;
use App\Models\SyllabusCourseOutlinesFinal;
use App\Models\SyllabusInstructor;
use App\Models\SyllabusReviewForm;
use App\Notifications\BL_SyllabusDeanApproved;
use App\Notifications\BL_SyllabusDeanReturned;
use App\Notifications\BT_SyllabusDeanApproved;
use App\Notifications\BT_SyllabusDeanReturned;
use App\Notifications\Chair_SyllabusDeanApproved;
use App\Notifications\Chair_SyllabusDeanReturned;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeanSyllabusController extends Controller
{
    public function index()
    {
        $dean = Dean::where('user_id', Auth::user()->id)->firstOrFail();
        $college_id = $dean->college_id;

        $syllabi = Syllabus::join('syllabus_instructors', 'syllabi.syll_id', '=', 'syllabus_instructors.syll_id')
            ->select('syllabus_instructors.*', 'syllabi.*')
            ->get();

        // $syllabus = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
        //     ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
        //     ->where('bayanihan_leaders.bg_user_id', '=', Auth::user()->id)
        //     ->leftJoin('courses', 'courses.course_id', '=',  'bayanihan_groups.course_id')
        //     ->where('syllabi.department_id', '=', $department_id)
        //     ->where('syllabi.status', '=', 'Pending')
        //     ->whereNotNull('syllabi.chair_submitted_at')
        //     ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
        //     ->get();
        if ($college_id) {
            $syllabus = BayanihanGroup::join('syllabi', function ($join) {
                $join->on('syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
                    ->where('syllabi.version', '=', DB::raw('(SELECT MAX(version) FROM syllabi WHERE bg_id = bayanihan_groups.bg_id)'));
            })
                ->where('syllabi.department_id', '=', $college_id)
                ->whereNotNull('syllabi.chair_submitted_at')
                ->leftJoin('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
                ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
                ->get();
        } else {
            $syllabus = [];
        }

        $ApprovedSyllabus = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
            ->where('bayanihan_leaders.bg_user_id', '=', Auth::user()->id)
            ->leftJoin('courses', 'courses.course_id', '=',  'bayanihan_groups.course_id')
            ->where('syllabi.department_id', '=', $college_id)
            ->where('syllabi.status', '=', 'Chair Approved')
            ->whereNotNull('syllabi.dean_submitted_at')
            ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
            ->get();

        $RejectedSyllabus = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
            ->where('bayanihan_leaders.bg_user_id', '=', Auth::user()->id)
            ->leftJoin('courses', 'courses.course_id', '=',  'bayanihan_groups.course_id')
            ->where('syllabi.department_id', '=', $college_id)
            ->where('syllabi.status', '=', 'Chair Rejected')
            ->whereNotNull('syllabi.chair_rejected_at')
            ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
            ->get();

        $instructors = SyllabusInstructor::join('users', 'syllabus_instructors.syll_ins_user_id', '=', 'users.id')
            ->select('users.*', 'syllabus_instructors.*')
            ->get()
            ->groupBy('syll_id');

        $user = Auth::user();
        $notifications = $user->notifications;
        return view('Dean.Syllabus.syllList', compact('notifications', 'syllabus', 'instructors', 'ApprovedSyllabus', 'RejectedSyllabus'));
    }
    public function viewSyllabus($syll_id)
    {
        $syll = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            ->join('colleges', 'colleges.college_id', '=', 'syllabi.college_id')
            ->join('departments', 'departments.department_id', '=', 'syllabi.department_id') // Corrected
            ->join('curricula', 'curricula.curr_id', '=', 'syllabi.curr_id')
            ->join('courses', 'courses.course_id', '=', 'syllabi.course_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('courses.*', 'bayanihan_groups.*', 'syllabi.*', 'departments.*', 'curricula.*', 'colleges.college_description', 'colleges.college_code')
            ->first();

        $programOutcomes = ProgramOutcome::join('departments', 'departments.department_id', '=', 'program_outcomes.department_id')
            ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('program_outcomes.*')
            ->get();
        $courseOutcomes = SyllabusCourseOutcome::where('syll_id', '=', $syll_id)
            ->get();

        $copos = SyllabusCoPo::where('syll_id', '=', $syll_id)
            ->get();

        // foreach ($courseOutcomes as $courseOutcome) {
        //     $copos = SyllabusCoPO::where('syll_co_id', '=', $courseOutcome->syll_co_id)
        //         ->get();
        // }

        $instructors = SyllabusInstructor::join('users', 'syllabus_instructors.syll_ins_user_id', '=', 'users.id')
            ->select('users.*', 'syllabus_instructors.*')
            ->get()
            ->groupBy('syll_id');

        $courseOutlines = SyllabusCourseOutlineMidterm::where('syll_id', '=', $syll_id)
            ->with('courseOutcomes')
            ->get();

        $courseOutlinesFinals = SyllabusCourseOutlinesFinal::where('syll_id', '=', $syll_id)
            ->with('courseOutcomes')
            ->get();

        $cotCos = SyllabusCotCoM::join('syllabus_course_outcomes', 'syllabus_cot_cos_midterms.syll_co_id', '=', 'syllabus_course_outcomes.syll_co_id')
            ->select('syllabus_course_outcomes.*', 'syllabus_cot_cos_midterms.*')
            ->get()
            ->groupBy('syll_co_out_id');

        $cotCosF = SyllabusCotCoF::join('syllabus_course_outcomes', 'syllabus_cot_cos_finals.syll_co_id', '=', 'syllabus_course_outcomes.syll_co_id')
            ->select('syllabus_course_outcomes.*', 'syllabus_cot_cos_finals.*')
            ->get()
            ->groupBy('syll_co_out_id');

        $bLeaders = BayanihanLeader::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_leaders.bg_id')
            ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_leaders.bg_user_id')
            ->select('bayanihan_leaders.*', 'users.*')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->get();

        $bMembers = bayanihanMember::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_members.bg_id')
            ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_members.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_members.bm_user_id')
            ->select('bayanihan_members.*', 'users.*')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->get();
        $poes = POE::join('departments', 'departments.department_id', '=', 'poes.department_id')
            ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('poes.*')
            ->get();
        $feedback = SyllabusDeanFeedback::where('syll_id', $syll_id)->first();
        $user = Auth::user();
        $notifications = $user->notifications;
        return view('Dean.Syllabus.syllView', compact(
            'notifications',
            'syll',
            'instructors',
            'syll_id',
            'instructors',
            'courseOutcomes',
            'programOutcomes',
            'copos',
            'courseOutlines',
            'cotCos',
            'courseOutlinesFinals',
            'cotCosF',
            'bLeaders',
            'bMembers',
            'poes',
            'feedback'

        ));
    }
    public function returnSyllabus(Request $request, $syll_id)
    {
        $request->validate([
            'syll_dean_feedback_text' => 'required',
        ]);

        SyllabusDeanFeedback::create([
            'syll_id' => $syll_id,
            'user_id' => Auth::user()->id,
            'syll_dean_feedback_text' => $request->input('syll_dean_feedback_text'),
        ]);

        $syllabus = Syllabus::find($syll_id);

        if (!$syllabus) {
            return redirect()->route('dean.syllabus')->with('error', 'Syllabus not found.');
        }
        $syllabus->dean_rejected_at = Carbon::now();
        $syllabus->status = 'Returned by Dean';
        $syllabus->save();

        $submitted_syllabus = Syllabus::where('syll_id', $syll_id)
            ->join('bayanihan_groups', 'bayanihan_groups.bg_id', 'syllabi.bg_id')
            ->join('courses', 'courses.course_id', 'bayanihan_groups.course_id')
            ->select('bayanihan_groups.bg_school_year', 'courses.course_code', 'syllabi.bg_id')
            ->first();

        $course_code = $submitted_syllabus->course_code;
        $bg_school_year = $submitted_syllabus->bg_school_year;

        // Notification for the Chair 
        $chair = User::join('chairpeople', 'chairpeople.user_id', '=', 'users.id')
        ->join('departments', 'departments.department_id', '=', 'chairpeople.department_id')
        ->where('departments.department_id', '=', $syllabus->department_id)
        ->select('users.*', 'departments.*')
        ->first();

        $chair->notify(new Chair_SyllabusDeanReturned($course_code, $bg_school_year, $syll_id));

        // Notification for Bayanihan Members 
        $bayanihan_leaders = BayanihanLeader::where('bg_id', $submitted_syllabus->bg_id)->get();
        $bayanihan_members = BayanihanMember::where('bg_id', $submitted_syllabus->bg_id)->get();
        foreach ($bayanihan_leaders as $leader) {
            $user = User::find($leader->bg_user_id);
            if ($user) {
                $user->notify(new BL_SyllabusDeanReturned($course_code, $bg_school_year, $syll_id));
            }
        }
        foreach ($bayanihan_members as $member) {
            $user = User::find($member->bm_user_id);
            if ($user) {
                $user->notify(new BT_SyllabusDeanReturned($course_code, $bg_school_year, $syll_id));
            }
        }

        return redirect()->route('dean.syllList')->with('success', 'Syllabus rejection successful.');
    }
    public function approveSyllabus($syll_id)
    {
        $syllabus = Syllabus::find($syll_id);

        if (!$syllabus) {
            return redirect()->route('dean.syllList')->with('error', 'Syllabus not found.');
        }
        $syllabus->dean_approved_at = Carbon::now();
        $syllabus->status = 'Approved by Dean';
        $syllabus->save();

        $submitted_syllabus = Syllabus::where('syll_id', $syll_id)
            ->join('bayanihan_groups', 'bayanihan_groups.bg_id', 'syllabi.bg_id')
            ->join('courses', 'courses.course_id', 'bayanihan_groups.course_id')
            ->select('bayanihan_groups.bg_school_year', 'courses.course_code', 'syllabi.bg_id')
            ->first();

        $course_code = $submitted_syllabus->course_code;
        $bg_school_year = $submitted_syllabus->bg_school_year;

        // Notification for the Chair 
        $chair = User::join('chairpeople', 'chairpeople.user_id', '=', 'users.id')
        ->join('departments', 'departments.department_id', '=', 'chairpeople.department_id')
        ->where('departments.department_id', '=', $syllabus->department_id)
        ->select('users.*', 'departments.*')
        ->first();
        $chair->notify(new Chair_SyllabusDeanApproved($course_code, $bg_school_year, $syll_id));

        // Notification for Bayanihan Members 
        $bayanihan_leaders = BayanihanLeader::where('bg_id', $submitted_syllabus->bg_id)->get();
        $bayanihan_members = BayanihanMember::where('bg_id', $submitted_syllabus->bg_id)->get();
        foreach ($bayanihan_leaders as $leader) {
            $user = User::find($leader->bg_user_id);
            if ($user) {
                $user->notify(new BL_SyllabusDeanApproved($course_code, $bg_school_year, $syll_id));
            }
        }
        foreach ($bayanihan_members as $member) {
            $user = User::find($member->bm_user_id);
            if ($user) {
                $user->notify(new BT_SyllabusDeanApproved($course_code, $bg_school_year, $syll_id));
            }
        }

        return redirect()->route('dean.viewSyllabus', $syll_id)->with('success', 'Syllabus approval successful.');
    }
}
