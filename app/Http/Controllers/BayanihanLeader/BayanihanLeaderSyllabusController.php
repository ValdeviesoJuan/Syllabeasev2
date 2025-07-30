<?php

namespace App\Http\Controllers\BayanihanLeader;

use App\Http\Controllers\Controller;
use App\Models\BayanihanGroup; 
use App\Models\User;
use App\Models\Roles;
use App\Models\Syllabus;
use App\Models\College;
use App\Models\POE;
use App\Models\ProgramOutcome;
use App\Models\SrfChecklist; 
use App\Models\SyllabusCoPo;
use App\Models\SyllabusCotCoF;
use App\Models\SyllabusCotCoM;
use App\Models\SyllabusCourseOutcome; 
use App\Models\SyllabusCourseOutlineMidterm;
use App\Models\SyllabusCourseOutlinesFinal;
use App\Models\SyllabusDeanFeedback;
use App\Models\SyllabusInstructor;
use App\Models\SyllabusReviewForm;
use App\Notifications\Chair_SyllabusSubmittedtoChair; 
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use App\Models\UserRole;
use App\Mail\SyllabusSubmittedNotification;
use App\Models\BayanihanGroupUsers;

use function Laravel\Prompts\select;

class BayanihanLeaderSyllabusController extends Controller
{
    public function index()
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
            $syllabus = BayanihanGroup::join('syllabi', function ($join) {
                $join->on('syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
                    ->whereRaw('syllabi.version = (SELECT MAX(version) FROM syllabi WHERE bg_id = bayanihan_groups.bg_id)');
            })
                ->join('bayanihan_group_users', 'bayanihan_group_users.bg_id', '=', 'bayanihan_groups.bg_id')
                ->where('bayanihan_group_users.user_id', '=', Auth::user()->id)
                ->where('bayanihan_group_users.bg_role', '=', 'leader')
                ->where('syllabi.department_id', '=', $myDepartment->department_id)
                ->leftJoin('courses', 'courses.course_id', '=',  'bayanihan_groups.course_id')
                ->leftJoin('deadlines', function ($join) {
                    $join->on('deadlines.dl_semester', '=', 'courses.course_semester')
                        ->on('deadlines.dl_school_year', '=', 'bayanihan_groups.bg_school_year')
                        ->on('deadlines.college_id', '=', 'syllabi.college_id');
                })
                ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*', 'deadlines.*')
                ->get();
        } else {
            $syllabus = [];
        }
            
        $user = Auth::user(); 
        $notifications = $user->notifications;

        return view('BayanihanLeader.Syllabus.syllList', compact('notifications', 'syllabus'));
    }

    public function viewSyllabus($syll_id)
    {
        $syll = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            ->join('colleges', 'colleges.college_id', '=', 'syllabi.college_id')
            ->join('departments', 'departments.department_id', '=', 'syllabi.department_id')
            ->join('curricula', 'curricula.curr_id', '=', 'syllabi.curr_id')
            ->join('courses', 'courses.course_id', '=', 'syllabi.course_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('courses.*', 'bayanihan_groups.*', 'syllabi.*', 'departments.*', 'curricula.*', 'colleges.*')
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
        
        $previousSyllabus = Syllabus::where('syllabi.bg_id', $syll->bg_id)
            ->whereRaw('CAST(version AS UNSIGNED) < ?', [intval($syll->version)])
            ->orderByRaw('CAST(version AS UNSIGNED) DESC')
            ->first();

        $previousStatus = null;
        $previousReviewForm = null;
        $previousChecklistItems = [];
        $previousChecklistSRF = collect();
        $previousDeanFeedback = [];

        if ($previousSyllabus) {
            $previousStatus = $previousSyllabus->status;

            if ($previousStatus === "Returned by Chair") {
                $previousReviewForm = SyllabusReviewForm::where('syll_id', $previousSyllabus->syll_id)->first();

                if ($previousReviewForm) {
                    $previousChecklistItems = SrfChecklist::where('srf_id', $previousReviewForm->srf_id)
                        ->orderBy('srf_no')
                        ->get();

                    $previousChecklistSRF = $previousChecklistItems->keyBy('srf_no');
                }
                
            } else if ($previousStatus === "Returned by Dean") {
                $previousDeanFeedback = SyllabusDeanFeedback::where('syll_id', $previousSyllabus->syll_id)->first();
            }
        }

        $programOutcomes = ProgramOutcome::join('departments', 'departments.department_id', '=', 'program_outcomes.department_id')
            ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('program_outcomes.*')
            ->get();
        $poes = POE::join('departments', 'departments.department_id', '=', 'poes.department_id')
            ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('poes.*')
            ->get();

        $courseOutcomes = SyllabusCourseOutcome::where('syll_id', '=', $syll_id)
            ->get();

        $copos = SyllabusCoPO::where('syll_id', '=', $syll_id)
            ->get();

        $instructors = SyllabusInstructor::join('users', 'syllabus_instructors.syll_ins_user_id', '=', 'users.id')
            ->select('users.*', 'syllabus_instructors.*')
            ->get()
            ->groupBy('syll_id');

        $courseOutlines = SyllabusCourseOutlineMidterm::where('syll_id', '=', $syll_id)
            ->with('courseOutcomes')
            ->orderBy('syll_row_no', 'asc')
            ->get();

        $courseOutlinesFinals = SyllabusCourseOutlinesFinal::where('syll_id', '=', $syll_id)
            ->with('courseOutcomes')
            ->orderBy('syll_row_no', 'asc')
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

        // $syllabusComments = SyllabusComment::join('users', 'users.id', '=', 'syllabus_comments.user_id')
        // ->where('syllabus_comments.syll_id', '=', $syll_id)
        // ->select('users.*', 'syllabus_comments.*')
        // ->orderBy('syllabus_comments.syll_created_at', 'asc')
        // ->get();

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
        
        $isLatest = Syllabus::where('bg_id', $syll->bg_id)
            ->orderByRaw('CAST(version AS UNSIGNED) DESC')
            ->value('syll_id') == $syll->syll_id;

        $feedback = SyllabusDeanFeedback::where('syll_id', $syll_id)->first();

        return view('BayanihanLeader.Syllabus.syllView', compact(
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
            'previousSyllabus',
            'previousStatus',
            'previousReviewForm',
            'previousChecklistItems',
            'previousChecklistSRF',
            'previousDeanFeedback',
            'isLatest'
        ))->with('success', 'Switched to Edit Mode');
    }
    public function commentSyllabus($syll_id)
    {
        $syll = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            ->join('colleges', 'colleges.college_id', '=', 'syllabi.college_id')
            ->join('departments', 'departments.department_id', '=', 'syllabi.department_id') // Corrected
            ->join('curricula', 'curricula.curr_id', '=', 'syllabi.curr_id')
            ->join('courses', 'courses.course_id', '=', 'syllabi.course_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('courses.*', 'bayanihan_groups.*', 'syllabi.*', 'departments.*', 'curricula.*', 'colleges.college_description', 'colleges.college_code')
            ->first();

        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id'); 
        $chair = UserRole::join('users', 'users.id', '=', 'user_roles.user_id')
            ->where('entity_id', $syll->department_id)
            ->where('entity_type', 'Department')
            ->where('role_id', $chairRoleId)
            ->select('users.*')
            ->first();

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

        $poes = POE::join('departments', 'departments.department_id', '=', 'poes.department_id')
            ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('poes.*')
            ->get();

        $courseOutcomes = SyllabusCourseOutcome::where('syll_id', '=', $syll_id)
            ->get();

        $copos = SyllabusCoPO::where('syll_id', '=', $syll_id)
            ->get();

        $instructors = SyllabusInstructor::join('users', 'syllabus_instructors.syll_ins_user_id', '=', 'users.id')
            ->select('users.*', 'syllabus_instructors.*')
            ->get()
            ->groupBy('syll_id');

        $courseOutlines = SyllabusCourseOutlineMidterm::where('syll_id', '=', $syll_id)
            ->with('courseOutcomes')
            ->orderBy('syll_row_no', 'asc')
            ->get();

        $courseOutlinesFinals = SyllabusCourseOutlinesFinal::where('syll_id', '=', $syll_id)
            ->with('courseOutcomes')
            ->orderBy('syll_row_no', 'asc')
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

        // $syllabusComments = SyllabusComment::join('users', 'users.id', '=', 'syllabus_comments.user_id')
        // ->where('syllabus_comments.syll_id', '=', $syll_id)
        // ->select('users.*', 'syllabus_comments.*')
        // ->orderBy('syllabus_comments.syll_created_at', 'asc')
        // ->get();
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
        return view('BayanihanLeader.Syllabus.syllComment', compact(
            'syll',
            'instructors',
            'chair',
            'dean',
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
        ))->with('success', 'Switched to Comment Mode.');
    }
    public function createSyllabus()
    {
        $bGroups = BayanihanGroup::join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
            ->join('bayanihan_group_users', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->where('bayanihan_group_users.user_id', '=', Auth::user()->id)
            ->where('bayanihan_group_users.bg_role', '=', 'leader')
            ->select('bayanihan_groups.*', 'courses.*')
            ->get();

        //add: Only show bg groups that they leads
        $instructors = User::all();

        $user = Auth::user(); 
        $notifications = $user->notifications;

        return view('BayanihanLeader.Syllabus.syllCreate', compact('notifications', 'bGroups', 'instructors'));
    }

    public function storeSyllabus(Request $request)
    {
        $request->validate([
            'effectivity_date' => 'required',
            'syll_class_schedule' => 'required',
            'syll_bldg_rm' => 'required',
            'syll_ins_consultation' => 'required',
            'syll_ins_bldg_rm' => 'required',
            'syll_course_description' => 'required',
            'bg_id' => "required"
        ]);

        $existingSyllabus = Syllabus::where('bg_id', $request->input('bg_id'))->first();
        if ($existingSyllabus) {
            return redirect()->route('bayanihanleader.syllabus')->with('error', 'Syllabus already exists for this bayanihan group.');
        }

        $info = College::join('departments', 'departments.college_id', '=', 'colleges.college_id')
            ->join('curricula', 'curricula.department_id', '=', 'departments.department_id')
            ->join('courses', 'courses.curr_id', '=', 'curricula.curr_id')
            ->join('bayanihan_groups', 'bayanihan_groups.course_id', '=', 'courses.course_id')
            ->where('bayanihan_groups.bg_id', '=', $request->input('bg_id'))
            ->select('colleges.college_id', 'departments.department_id', 'courses.course_id', 'curricula.curr_id')
            ->first();

        $deanRoleId = Roles::where('role_name', 'Dean')->value('role_id'); 
        $dean = User::join('user_roles', 'user_roles.user_id', '=', 'users.id')
            ->join('colleges', 'colleges.college_id', '=', 'user_roles.entity_id')
            ->where('user_roles.entity_type', 'College')
            ->where('user_roles.role_id', $deanRoleId)
            ->where('colleges.college_id', '=', $info->college_id)
            ->select('users.firstname', 'users.lastname', 'users.*')
            ->first();

        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id'); 
        $chair = User::join('user_roles', 'user_roles.user_id', '=', 'users.id')
            ->join('departments', 'departments.department_id', '=', 'user_roles.entity_id')
            ->where('user_roles.entity_type', 'Department')
            ->where('user_roles.role_id', $chairRoleId)
            ->where('departments.department_id', '=', $info->department_id)
            ->select('users.firstname', 'users.lastname', 'users.*')
            ->first();

        $syllabus = new Syllabus();
        $syllabus->bg_id = $request->input('bg_id');
        $syllabus->effectivity_date = $request->input('effectivity_date');
        $syllabus->syll_class_schedule = $request->input('syll_class_schedule');
        $syllabus->syll_bldg_rm = $request->input('syll_bldg_rm');
        $syllabus->syll_ins_consultation = $request->input('syll_ins_consultation');
        $syllabus->syll_ins_bldg_rm = $request->input('syll_ins_bldg_rm');
        $syllabus->syll_course_description = $request->input('syll_course_description');

        $syllabus->college_id = $info->college_id;
        $syllabus->department_id = $info->department_id;
        $syllabus->curr_id = $info->curr_id;
        $syllabus->course_id = $info->course_id;

        $syllabus->syll_dean = ($dean->prefix ? $dean->prefix . ' ' : '') . $dean->firstname . ' ' . $dean->lastname . ' ' . $dean->suffix;
        $syllabus->syll_chair = ($chair->prefix ? $chair->prefix . ' ' : '') . $chair->firstname . ' ' . $chair->lastname . ' ' . $chair->suffix;
        
        $syllabus->status = "Draft";
        $syllabus->version = 1;
        $syllabus->save();

        $instructors = $request->input('syll_ins_user_id');
        foreach ($instructors as $instructor_id) {
            $instructor = new SyllabusInstructor();
            $instructor->syll_id = $syllabus->syll_id;
            $instructor->syll_ins_user_id = $instructor_id;
            $instructor->save();
        }

        return redirect()->route('bayanihanleader.home')->with('success', 'Syllabus created successfully.');
    }
    public function editSyllabus($syll_id)
    {
        // $syllabus = Syllabus::where('syllabi.syll_id', '=', $syll_id)
        // ->select('syllabi.*')
        // ->first();
        $syllabus = Syllabus::find($syll_id);

        $bGroups = BayanihanGroup::join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
            ->join('bayanihan_group_users', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->where('bayanihan_group_users.user_id', '=', Auth::user()->id)
            ->where('bayanihan_group_users.bg_role', '=', 'leader')
            ->select('bayanihan_groups.*', 'courses.*')
            ->get();

        //add: Only show bg groups that they leads
        $instructors = SyllabusInstructor::all();
        $users = User::all();

        $user = Auth::user(); 
        $notifications = $user->notifications;
        
        return view('BayanihanLeader.Syllabus.syllEdit', compact('notifications', 'bGroups', 'instructors', 'syllabus', 'users', 'syll_id'));
    }
    public function updateSyllabus(Request $request, $syll_id)
    {
        $request->validate([
            'effectivity_date' => 'required',
            'syll_class_schedule' => 'required',
            'syll_bldg_rm' => 'required',
            'syll_ins_consultation' => 'required',
            'syll_ins_bldg_rm' => 'required',
            'syll_course_description' => 'required',
            'bg_id' => 'required',
        ]);

        $syllabus = Syllabus::find($syll_id);

        if (!$syllabus) {
            return redirect()->route('bayanihanleader.home')->with('error', 'Syllabus not found.');
        }

        $syllabus->bg_id = $request->input('bg_id');
        $syllabus->effectivity_date = $request->input('effectivity_date');
        $syllabus->syll_class_schedule = $request->input('syll_class_schedule');
        $syllabus->syll_bldg_rm = $request->input('syll_bldg_rm');
        $syllabus->syll_ins_consultation = $request->input('syll_ins_consultation');
        $syllabus->syll_ins_bldg_rm = $request->input('syll_ins_bldg_rm');
        $syllabus->syll_course_description = $request->input('syll_course_description');
        $syllabus->save();

        $syllabus->SyllabusInstructors()->delete();

        $instructors = $request->input('syll_ins_user_id');
        foreach ($instructors as $instructor_id) {
            $instructor = new SyllabusInstructor();
            $instructor->syll_id = $syllabus->syll_id;
            $instructor->syll_ins_user_id = $instructor_id;
            $instructor->save();
        }

        return redirect()->route('bayanihanleader.viewSyllabus', $syll_id)->with('success', 'Syllabus updated successfully.');
    }

    public function submitSyllabus($syll_id)
    {
        $syllabus = Syllabus::find($syll_id);

        if (!$syllabus) {
            return redirect()->route('bayanihanleader.home')->with('error', 'Syllabus not found.');
        }

        $syllabus->chair_submitted_at = Carbon::now();

        if ($syllabus->status == "Draft") {
            $syllabus->status = 'Pending Chair Review';

        } else if ($syllabus->status == "Requires Revision (Chair)") {
            $syllabus->status = 'Revised for Chair';

        } else if ($syllabus->status == "Requires Revision (Dean)") {
            $syllabus->status = 'Revised for Dean';
        }

        $syllabus->save();

        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');
        $chair = User::join('user_roles', 'user_roles.user_id', '=', 'users.id')
            ->join('departments', 'departments.department_id', '=', 'user_roles.entity_id')
            ->where('user_roles.entity_type', 'Department')
            ->where('user_roles.role_id', $chairRoleId)
            ->where('departments.department_id', '=', $syllabus->department_id)
            ->select('users.*', 'departments.*')
            ->first();
        
        $submitted_syllabus = Syllabus::where('syll_id', $syll_id)
            ->join('bayanihan_groups', 'bayanihan_groups.bg_id', 'syllabi.bg_id')
            ->join('courses', 'courses.course_id', 'bayanihan_groups.course_id')
            ->select('bayanihan_groups.bg_school_year', 'courses.course_code')
            ->first();
        $course_code = $submitted_syllabus->course_code;
        $bg_school_year= $submitted_syllabus->bg_school_year;
        
        $chair->notify(new Chair_SyllabusSubmittedtoChair($course_code, $bg_school_year, $syll_id));

        // Send email to the chair
        if (filter_var($chair->email, FILTER_VALIDATE_EMAIL)) {
            Mail::to($chair->email)->send(
                new SyllabusSubmittedNotification($course_code, $bg_school_year, $syll_id)
            );
        }

        return redirect()->route('bayanihanleader.syllabus')->with('success', 'Syllabus submission successful.');
    }

    // public function destroySyllabus($syll_id)
    // {
    //     try {
    //         $co = Syllabus::findOrFail($syll_id);
    //         $co->delete();
    //         return redirect()->route('bayanihanleader.home')->with('success', 'Syllabus deleted successfully.');
    //     } catch (\Exception $e) {
    //         return redirect()->route('bayanihanleader.home')->with('error', 'Syllabus to delete Course Outcome.');
    //     }
    // }
    public function destroySyllabus(Syllabus $syll_id)
    {
        $syll = Syllabus::where('syll_id', $syll_id)->firstorfail();

        $hasApprovedSyllabusDocument = Syllabus::where('bg_id', $syll->bg_id)
            ->where('status', 'Approved by Dean')
            ->whereNotNull('dean_approved_at')
            ->exists();

        if ($hasApprovedSyllabusDocument) {
            return redirect()->route('bayanihanleader.home')
                ->with('error', 'Cannot delete this syllabus because it already has been approved.');
        }
        
        $syll_id->delete();

        return redirect()->route('bayanihanleader.home')->with('success', 'Syllabus deleted successfully.');
    }
    public function viewReviewForm($syll_id)
    {
        $reviewForm = SyllabusReviewForm::join('srf_checklists', 'srf_checklists.srf_id', '=', 'syllabus_review_forms.srf_id')
            ->join('syllabi', 'syllabi.syll_id', '=', 'syllabus_review_forms.syll_id')
            ->where('syllabus_review_forms.syll_id', $syll_id)
            ->select('srf_checklists.*', 'syllabus_review_forms.*', 'syllabi.version')
            ->first();

        $srfResults = [];

        for ($i = 1; $i <= 19; $i++) {
            $srfResults["srf{$i}"] = SrfChecklist::join('syllabus_review_forms', 'syllabus_review_forms.srf_id', '=', 'srf_checklists.srf_id')
                ->where('syll_id', $syll_id)
                ->where('srf_no', $i)
                ->first();
        }
        $srf1 = $srfResults['srf1'];
        $srf2 = $srfResults['srf2'];
        $srf3 = $srfResults['srf3'];
        $srf4 = $srfResults['srf4'];
        $srf5 = $srfResults['srf5'];
        $srf6 = $srfResults['srf6'];
        $srf7 = $srfResults['srf7'];
        $srf8 = $srfResults['srf8'];
        $srf9 = $srfResults['srf9'];
        $srf10 = $srfResults['srf10'];
        $srf11 = $srfResults['srf11'];
        $srf12 = $srfResults['srf12'];
        $srf13 = $srfResults['srf13'];
        $srf14 = $srfResults['srf14'];
        $srf15 = $srfResults['srf15'];
        $srf16 = $srfResults['srf16'];
        $srf17 = $srfResults['srf17'];
        $srf18 = $srfResults['srf18'];
        $srf19 = $srfResults['srf19'];
        $user = Auth::user(); 
        $notifications = $user->notifications;
        return view('bayanihanleader.syllabus.reviewForm', compact(
            'notifications',
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
            'srf19'
        ))
            ->with('success', 'Syllabus submission successful.');
    }
    public function replicateSyllabus($syll_id)
    {
        $oldSyllabus = Syllabus::where('syll_id', $syll_id)->first();
        $oldSyllabusInstructor = SyllabusInstructor::where('syll_id', $syll_id)->get();
        $oldSyllabusCourseOutcome = SyllabusCourseOutcome::where('syll_id', $syll_id)->get();
        $oldSyllabusCourseOutlineM = SyllabusCourseOutlineMidterm::where('syll_id', $syll_id)->get();
        $oldSyllabusCourseOutlineF = SyllabusCourseOutlinesFinal::where('syll_id', $syll_id)->get();
        
        if ($oldSyllabus) {
            $newSyllabus = $oldSyllabus->replicate();

            if ($oldSyllabus->status == "Returned by Chair") {
                $newSyllabus->status = "Requires Revision (Chair)";

            } else if ($oldSyllabus->status == "Returned by Dean") {
                $newSyllabus->status = "Requires Revision (Dean)";

            } else {
                $newSyllabus->status = null;
            }

            $newSyllabus->chair_submitted_at = null;
            $newSyllabus->dean_submitted_at = null;
            $newSyllabus->chair_rejected_at = null;
            $newSyllabus->dean_rejected_at = null;
            $newSyllabus->version = $oldSyllabus->version + 1;
            $newSyllabus->save();

            foreach ($oldSyllabusInstructor as $syllabusInstructor) {
                $newSyllabusInstructor = $syllabusInstructor->replicate();
                $newSyllabusInstructor->syll_id = $newSyllabus->syll_id;
                $newSyllabusInstructor->save();
            }
            foreach ($oldSyllabusCourseOutcome as $syllabusCourseOutcome) {
                $newSyllabusCourseOutcome = $syllabusCourseOutcome->replicate();
                $newSyllabusCourseOutcome->syll_id = $newSyllabus->syll_id;
                $newSyllabusCourseOutcome->save();

                $oldSyllabusCoPo = SyllabusCoPo::where('syll_co_id', $syllabusCourseOutcome->syll_co_id)->get();

                foreach ($oldSyllabusCoPo as $syllabusCoPo) {
                    $newSyllabusCoPo = $syllabusCoPo->replicate();
                    $newSyllabusCoPo->syll_co_id = $newSyllabusCourseOutcome->syll_co_id;
                    $newSyllabusCoPo->syll_id = $newSyllabus->syll_id;
                    $newSyllabusCoPo->save();
                }
            }

            foreach ($oldSyllabusCourseOutlineM as $syllabusCourseOutlineM) {
                $newSyllabusCourseOutlineM = $syllabusCourseOutlineM->replicate();
                $newSyllabusCourseOutlineM->syll_id = $newSyllabus->syll_id;
                $newSyllabusCourseOutlineM->save();

                $oldSyllabusCotCoM = SyllabusCotCoM::where('syll_co_out_id', $syllabusCourseOutlineM->syll_co_out_id)->get();

                foreach ($oldSyllabusCotCoM as $syllabusCotCoM) {
                    $newSyllabusCotCoM = $syllabusCotCoM->replicate();
                    $newSyllabusCotCoM->syllabus_cot_co = null;
                    $newSyllabusCotCoM->syll_co_out_id = $newSyllabusCourseOutlineM->syll_co_out_id;
                    $newSyllabusCotCoM->save();
                }
            }

            foreach ($oldSyllabusCourseOutlineF as $syllabusCourseOutlineF) {
                $newSyllabusCourseOutlineF = $syllabusCourseOutlineF->replicate();
                $newSyllabusCourseOutlineF->syll_id = $newSyllabus->syll_id;
                $newSyllabusCourseOutlineF->save();

                $oldSyllabusCotCoF = SyllabusCotCoF::where('syll_co_out_id', $syllabusCourseOutlineF->syll_co_out_id)->get();

                foreach ($oldSyllabusCotCoF as $syllabusCotCoF) {
                    $newSyllabusCotCoF = $syllabusCotCoF->replicate();
                    $newSyllabusCotCoF->syllabus_cot_co = null;
                    $newSyllabusCotCoF->syll_co_out_id = $newSyllabusCourseOutlineF->syll_co_out_id;
                    $newSyllabusCotCoF->save();
                }
            }
            return redirect()->route('bayanihanleader.viewSyllabus', $newSyllabus->syll_id)->with('success', 'Syllabus replication successful.');
        }
    }

    public function duplicateSyllabus($syll_id, $target_bg_id)
    {   
        $oldSyllabus = Syllabus::where('syll_id', $syll_id)->first();
        $oldSyllabusInstructor = SyllabusInstructor::where('syll_id', $syll_id)->get();
        $oldSyllabusCourseOutcome = SyllabusCourseOutcome::where('syll_id', $syll_id)->get();
        $oldSyllabusCourseOutlineM = SyllabusCourseOutlineMidterm::where('syll_id', $syll_id)->get();
        $oldSyllabusCourseOutlineF = SyllabusCourseOutlinesFinal::where('syll_id', $syll_id)->get();
        
        if ($oldSyllabus) {
            $newSyllabus = $oldSyllabus->replicate();
            $newSyllabus->status = "Draft";
            $newSyllabus->chair_submitted_at = null;
            $newSyllabus->dean_submitted_at = null;
            $newSyllabus->chair_rejected_at = null;
            $newSyllabus->dean_rejected_at = null;  
            $newSyllabus->dean_approved_at = null;
            $newSyllabus->version = 1;
            $newSyllabus->bg_id = $target_bg_id;
            $newSyllabus->save();

            foreach ($oldSyllabusInstructor as $syllabusInstructor) {
                $newSyllabusInstructor = $syllabusInstructor->replicate();
                $newSyllabusInstructor->syll_id = $newSyllabus->syll_id;
                $newSyllabusInstructor->save();
            }
            foreach ($oldSyllabusCourseOutcome as $syllabusCourseOutcome) {
                $newSyllabusCourseOutcome = $syllabusCourseOutcome->replicate();
                $newSyllabusCourseOutcome->syll_id = $newSyllabus->syll_id;
                $newSyllabusCourseOutcome->save();

                $oldSyllabusCoPo = SyllabusCoPo::where('syll_co_id', $syllabusCourseOutcome->syll_co_id)->get();

                foreach ($oldSyllabusCoPo as $syllabusCoPo) {
                    $newSyllabusCoPo = $syllabusCoPo->replicate();
                    $newSyllabusCoPo->syll_co_id = $newSyllabusCourseOutcome->syll_co_id;
                    $newSyllabusCoPo->syll_id = $newSyllabus->syll_id;
                    $newSyllabusCoPo->save();
                }
            }

            foreach ($oldSyllabusCourseOutlineM as $syllabusCourseOutlineM) {
                $newSyllabusCourseOutlineM = $syllabusCourseOutlineM->replicate();
                $newSyllabusCourseOutlineM->syll_id = $newSyllabus->syll_id;
                $newSyllabusCourseOutlineM->save();

                $oldSyllabusCotCoM = SyllabusCotCoM::where('syll_co_out_id', $syllabusCourseOutlineM->syll_co_out_id)->get();

                foreach ($oldSyllabusCotCoM as $syllabusCotCoM) {
                    $newSyllabusCotCoM = $syllabusCotCoM->replicate();
                    $newSyllabusCotCoM->syllabus_cot_co = null;
                    $newSyllabusCotCoM->syll_co_out_id = $newSyllabusCourseOutlineM->syll_co_out_id;
                    $newSyllabusCotCoM->save();
                }
            }

            foreach ($oldSyllabusCourseOutlineF as $syllabusCourseOutlineF) {
                $newSyllabusCourseOutlineF = $syllabusCourseOutlineF->replicate();
                $newSyllabusCourseOutlineF->syll_id = $newSyllabus->syll_id;
                $newSyllabusCourseOutlineF->save();

                $oldSyllabusCotCoF = SyllabusCotCoF::where('syll_co_out_id', $syllabusCourseOutlineF->syll_co_out_id)->get();

                foreach ($oldSyllabusCotCoF as $syllabusCotCoF) {
                    $newSyllabusCotCoF = $syllabusCotCoF->replicate();
                    $newSyllabusCotCoF->syllabus_cot_co = null;
                    $newSyllabusCotCoF->syll_co_out_id = $newSyllabusCourseOutlineF->syll_co_out_id;
                    $newSyllabusCotCoF->save();
                }
            }
            return redirect()->route('bayanihanleader.syllabus')->with('success', 'Syllabus duplication successful.');
        }

        return redirect()->back()->with('error', 'Original syllabus not found.');
    }
}
