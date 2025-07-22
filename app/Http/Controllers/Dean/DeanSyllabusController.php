<?php

namespace App\Http\Controllers\Dean;

use App\Http\Controllers\Controller;
use App\Mail\BLeader;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Roles;
use App\Models\BayanihanGroup;
use App\Models\BayanihanGroupUsers;
use App\Models\Course;
use Illuminate\Support\Facades\Mail;
use App\Mail\BTeam;
use App\Models\College;
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
        $deanRoleId = Roles::where('role_name', 'Dean')->value('role_id'); 
        $dean = UserRole::where('user_id', Auth::id())
            ->where('entity_type', '=', 'College')
            ->where('role_id', '=', $deanRoleId)
            ->first();
        $college_id = $dean->entity_id;
        
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
            
            $ApprovedSyllabus = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
                ->join('bayanihan_group_users', 'bayanihan_group_users.bg_id', '=', 'bayanihan_groups.bg_id')
                ->leftJoin('courses', 'courses.course_id', '=',  'bayanihan_groups.course_id')
                ->where('syllabi.department_id', '=', $college_id)
                ->where('syllabi.status', '=', 'Chair Approved')
                ->whereNotNull('syllabi.dean_submitted_at')
                ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
                ->get();

            $RejectedSyllabus = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
                ->join('bayanihan_group_users', 'bayanihan_group_users.bg_id', '=', 'bayanihan_groups.bg_id')
                ->leftJoin('courses', 'courses.course_id', '=',  'bayanihan_groups.course_id')
                ->where('syllabi.department_id', '=', $college_id)
                ->where('syllabi.status', '=', 'Chair Rejected')
                ->whereNotNull('syllabi.chair_rejected_at')
                ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
                ->get();
                
        } else {
            $syllabus = [];
            $ApprovedSyllabus = [];
            $RejectedSyllabus = [];
        }

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

        // Get chairperson of the department
        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id'); 
        $chair = UserRole::join('users', 'users.id', '=', 'user_roles.user_id')
            ->where('entity_id', $syll->department_id)
            ->where('entity_type', 'Department')
            ->where('role_id', $chairRoleId)
            ->select('users.*')
            ->first();

        // Get dean of the college
        $deanRoleId = Roles::where('role_name', 'Dean')->value('role_id'); 
        $dean = UserRole::join('users', 'users.id', '=', 'user_roles.user_id')
            ->where('entity_id', $syll->college_id)
            ->where('entity_type', 'College')
            ->where('role_id', $deanRoleId)
            ->select('users.*')
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

        $bLeaders = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_group_users.user_id')
            ->select('bayanihan_group_users.*', 'users.*')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->where('bayanihan_group_users.bg_role', '=', 'leader')
            ->get();
        $bMembers = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_group_users.user_id')
            ->select('bayanihan_group_users.*', 'users.*')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->where('bayanihan_group_users.bg_role', '=', 'member')
            ->get();
            
        $poes = POE::join('departments', 'departments.department_id', '=', 'poes.department_id')
            ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('poes.*')
            ->get();
        
        for ($i = 1; $i <= 19; $i++) {
            ${"srf{$i}"} = null;
        }
        
        for ($i = 1; $i <= 19; $i++) {
            ${"srf{$i}"} = SrfChecklist::join('syllabus_review_forms', 'syllabus_review_forms.srf_id', '=', 'srf_checklists.srf_id')
                ->where('syll_id', $syll_id)
                ->where('srf_no', $i)
                ->first();
        }

        $reviewForm = SyllabusReviewForm::join('srf_checklists', 'srf_checklists.srf_id', '=', 'syllabus_review_forms.srf_id')
            ->where('syllabus_review_forms.syll_id', $syll_id)
            ->select('srf_checklists.*', 'syllabus_review_forms.*')
            ->first();

        $syllabusVersions = Syllabus::where('syllabi.bg_id', $syll->bg_id)
            ->select('syllabi.*')
            ->get();
            
        $feedback = SyllabusDeanFeedback::where('syll_id', $syll_id)->first();

        $user = Auth::user();
        $notifications = $user->notifications;

        return view('Dean.Syllabus.syllView', compact(
            'notifications',
            'syll',
            'chair',
            'dean',
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
            'syllabusVersions',
            'feedback',
            'reviewForm',
            'srf1',
            'srf2',
            'srf3',
            'srf4',
            'srf5',
            'srf6',
            'srf7',
            'srf8',
            'srf9',
            'srf10',
            'srf11',
            'srf12',
            'srf13',
            'srf14',
            'srf15',
            'srf16',
            'srf18',
            'srf17',
            'srf19',
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
        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');
        $chair = User::join('user_roles', 'user_roles.user_id', '=', 'users.id')
            ->join('departments', 'departments.department_id', '=', 'user_roles.entity_id')
            ->where('user_roles.entity_type', 'Department')
            ->where('user_roles.role_id', $chairRoleId)
            ->where('departments.department_id', '=', $syllabus->department_id)
            ->select('users.*', 'departments.*')
            ->first();

        $chair->notify(new Chair_SyllabusDeanReturned($course_code, $bg_school_year, $syll_id));

        // Notification for Bayanihan Members 
        $bayanihan_leaders = BayanihanGroupUsers::where('bg_id', $submitted_syllabus->bg_id)->where('bg_role', operator: 'leader')->get();
        $bayanihan_members = BayanihanGroupUsers::where('bg_id', $submitted_syllabus->bg_id)->where('bg_role', 'member')->get();
        foreach ($bayanihan_leaders as $leader) {
            $user = User::find($leader->user_id);
            if ($user) {
                $user->notify(new BL_SyllabusDeanReturned($course_code, $bg_school_year, $syll_id));
            }
        }
        foreach ($bayanihan_members as $member) {
            $user = User::find($member->user_id);
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
        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');
        $chair = User::join('user_roles', 'user_roles.user_id', '=', 'users.id')
            ->join('departments', 'departments.department_id', '=', 'user_roles.entity_id')
            ->where('user_roles.entity_type', 'Department')
            ->where('user_roles.role_id', $chairRoleId)
            ->where('departments.department_id', '=', $syllabus->department_id)
            ->select('users.*', 'departments.*')
            ->first();
        $chair->notify(new Chair_SyllabusDeanApproved($course_code, $bg_school_year, $syll_id));

        // Notification for Bayanihan Members 
        $bayanihan_leaders = BayanihanGroupUsers::where('bg_id', $submitted_syllabus->bg_id)->where('bg_role', operator: 'leader')->get();
        $bayanihan_members = BayanihanGroupUsers::where('bg_id', $submitted_syllabus->bg_id)->where('bg_role', 'member')->get();
        foreach ($bayanihan_leaders as $leader) {
            $user = User::find($leader->user_id);
            if ($user) {
                $user->notify(new BL_SyllabusDeanApproved($course_code, $bg_school_year, $syll_id));
            }
        }
        foreach ($bayanihan_members as $member) {
            $user = User::find($member->user_id);
            if ($user) {
                $user->notify(new BT_SyllabusDeanApproved($course_code, $bg_school_year, $syll_id));
            }
        }

        return redirect()->route('dean.viewSyllabus', $syll_id)->with('success', 'Syllabus approval successful.');
    }
}
