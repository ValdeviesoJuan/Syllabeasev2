<?php

namespace App\Http\Controllers\Chairperson;

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
use App\Models\Department;
use App\Models\POE;
use App\Models\ProgramOutcome;
use App\Models\SrfChecklist;
use App\Models\Syllabus;
use App\Models\SyllabusChairFeedback;
use App\Models\SyllabusCoPo;
use App\Models\SyllabusCotCoF;
use App\Models\SyllabusCotCoM;
use App\Models\SyllabusCourseOutcome;
use App\Models\SyllabusCourseOutlineMidterm;
use App\Models\SyllabusCourseOutlinesFinal;
use App\Models\SyllabusDeanFeedback;
use App\Models\SyllabusInstructor;
use App\Models\SyllabusReviewForm;
use App\Notifications\BL_SyllabusChairApproved;
use App\Notifications\SyllabusChairApproved;
use App\Notifications\BL_SyllabusChairReturned;
use App\Notifications\BT_SyllabusChairApproved;
use App\Notifications\BT_SyllabusChairReturned;
use App\Notifications\Dean_SyllabusChairApproved;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChairSyllabusController extends Controller
{
    public function index()
    {
        $chairperson = Chairperson::where('user_id', Auth::user()->id)->firstOrFail();
        $department_id = $chairperson->department_id;

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
        if ($department_id) {
            $syllabus = BayanihanGroup::join('syllabi', function ($join) {
                $join->on('syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
                    ->where('syllabi.version', '=', DB::raw('(SELECT MAX(version) FROM syllabi WHERE bg_id = bayanihan_groups.bg_id)'));
            })
                ->where('syllabi.department_id', '=', $department_id)
                ->whereNotNull('syllabi.chair_submitted_at')
                ->leftJoin('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
                ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
                ->get();
        } else {
            $syllabus = [];
        }

        $instructors = SyllabusInstructor::join('users', 'syllabus_instructors.syll_ins_user_id', '=', 'users.id')
            ->select('users.*', 'syllabus_instructors.*')
            ->get()
            ->groupBy('syll_id');
        $user = Auth::user();
        $notifications = $user->notifications;
        return view('Chairperson.Syllabus.syllList', compact('notifications', 'syllabus', 'instructors'));
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

        // $copos = SyllabusCoPo::where('syll_id', '=', $syll_id)
        //     ->get();

        $copos = SyllabusCoPO::where('syll_id', '=', $syll_id)
            ->get();

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

        $syllabusVersions = Syllabus::where('syllabi.bg_id', $syll->bg_id)
        ->select('syllabi.*')
        ->get();

        return view('Chairperson.Syllabus.syllView', compact(
            'syllabusVersions',
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
    public function approveSyllabus($syll_id)
    {
        $syllabus = Syllabus::find($syll_id);

        if (!$syllabus) {
            return redirect()->route('bayanihanleader.home')->with('error', 'Syllabus not found.');
        }
        $syllabus->dean_submitted_at = Carbon::now();
        $syllabus->status = 'Approved by Chair';
        $syllabus->save();

        $dean = User::join('deans', 'deans.user_id', '=', 'users.id')
            ->join('colleges', 'colleges.college_id', '=', 'deans.college_id')
            ->where('colleges.college_id', '=', $syllabus->college_id)
            ->select('users.*', 'colleges.*')
            ->first();

        $submitted_syllabus = Syllabus::where('syll_id', $syll_id)
            ->join('bayanihan_groups', 'bayanihan_groups.bg_id', 'syllabi.bg_id')
            ->join('courses', 'courses.course_id', 'bayanihan_groups.course_id')
            ->select('bayanihan_groups.bg_school_year', 'courses.course_code', 'syllabi.bg_id')
            ->first();

        $course_code = $submitted_syllabus->course_code;
        $bg_school_year = $submitted_syllabus->bg_school_year;

        // Notification for Dean 
        $dean->notify(new Dean_SyllabusChairApproved($course_code, $bg_school_year, $syll_id));

        // Notification for Bayanihan Members 
        $bayanihan_leaders = BayanihanLeader::where('bg_id', $submitted_syllabus->bg_id)->get();
        $bayanihan_members = BayanihanMember::where('bg_id', $submitted_syllabus->bg_id)->get();
        foreach ($bayanihan_leaders as $leader) {
            $user = User::find($leader->bg_user_id);
            if ($user) {
                $user->notify(new BL_SyllabusChairApproved($course_code, $bg_school_year, $syll_id));
            }
        }
        foreach ($bayanihan_members as $member) {
            $user = User::find($member->bm_user_id);
            if ($user) {
                $user->notify(new BT_SyllabusChairApproved($course_code, $bg_school_year, $syll_id));
            }
        }

        return redirect()->route('chairperson.syllabus')->with('success', 'Syllabus approval successful.');
    }

    public function rejectSyllabus(Request $request, $syll_id)
    {
        $request->validate([
            'syll_chair_feedback_text' => 'required',
        ]);

        SyllabusChairFeedback::create([
            'syll_id' => $syll_id,
            'user_id' => Auth::user()->id,
            'syll_chair_feedback_text' => $request->input('syll_chair_feedback_text'),
        ]);

        $syllabus = Syllabus::find($syll_id);

        if (!$syllabus) {
            return redirect()->route('bayanihanleader.home')->with('error', 'Syllabus not found.');
        }
        $syllabus->chair_rejected_at = Carbon::now();
        $syllabus->status = 'Returned by Chair';
        $syllabus->save();


        $returned_syllabus = Syllabus::where('syll_id', $syll_id)
            ->join('bayanihan_groups', 'bayanihan_groups.bg_id', 'syllabi.bg_id')
            ->join('courses', 'courses.course_id', 'bayanihan_groups.course_id')
            ->select('bayanihan_groups.bg_school_year', 'courses.course_code')
            ->first();

        // Notification 
        $bayanihan_leaders = BayanihanLeader::where('bg_id', $returned_syllabus->bg_id)->get('bayanihan_leaders.*');
        $bayanihan_members = BayanihanMember::where('bg_id', $returned_syllabus->bg_id)->get('bayanihan_members.*');

        $course_code = $returned_syllabus->course_code;
        $bg_school_year = $returned_syllabus->bg_school_year;

        foreach ($bayanihan_leaders as $leader) {
            $user = User::where('id', $leader->user_id)->first();
            $user->notify(new BL_SyllabusChairReturned($course_code, $bg_school_year, $syll_id));
        }
        foreach ($bayanihan_members as $member) {
            $user = User::where('id', $member->user_id)->first();
            $user->notify(new BT_SyllabusChairReturned($course_code, $bg_school_year, $syll_id));
        }

        return redirect()->route('chairperson.syllabus')->with('success', 'Syllabus rejection successful.');
    }
    public function reviewForm($syll_id)
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

        // $copos = SyllabusCoPo::where('syll_id', '=', $syll_id)
        //     ->get();

        $copos = SyllabusCoPO::where('syll_id', '=', $syll_id)
            ->get();

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
        return view('Chairperson.Syllabus.reviewForm', compact(
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


        $syll = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            ->join('colleges', 'colleges.college_id', '=', 'syllabi.college_id')
            ->join('departments', 'departments.department_id', '=', 'syllabi.department_id') // Corrected
            ->join('curricula', 'curricula.curr_id', '=', 'syllabi.curr_id')
            ->join('courses', 'courses.course_id', '=', 'syllabi.course_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('courses.*', 'bayanihan_groups.*', 'syllabi.*', 'departments.*', 'curricula.*', 'colleges.college_description', 'colleges.college_code')
            ->first();
        if (!$syll) {
            return redirect()->route('bayanihanleader.home')->with('error', 'Syllabus not found.');
        }
        $syll->chair_rejected_at = Carbon::now();
        $syll->status = 'Returned by Chair';
        $syll->save();

        // Create Review Form 
        $srf = new SyllabusReviewForm();
        $srf->syll_id = $syll->syll_id;
        $srf->srf_course_code = $syll->course_code;
        $srf->srf_title = $syll->course_title;
        $srf->srf_sem_year = $syll->course_year_level  . ' ' . $syll->course_semester;

        $srf->user_id = Auth::id();
        $srf->srf_date = now()->toDateString();
        $srf->srf_reviewed_by = Auth::user()->prefix . ' ' . Auth::user()->firstname . ' ' . Auth::user()->lastname . ' ' . Auth::user()->suffix;
        $srf->srf_action = 0;

        $instructors = SyllabusInstructor::join('users', 'syllabus_instructors.syll_ins_user_id', '=', 'users.id')
            ->select('users.*', 'syllabus_instructors.*')
            ->get()
            ->groupBy('syll_id');
        $srf->srf_faculty = '';

        if ($instructors->has($srf->syll_id)) {
            $facultyNames = $instructors[$srf->syll_id]->map(function ($instructor) {
                return $instructor->firstname . ' ' . $instructor->lastname;
            })->toArray();

            $srf->srf_faculty = implode(', ', $facultyNames);
        }
        $srf->save();

        // Create checklist rows here 
        $srf_remarks = $request->input('srf_remarks');
        $srf_yes_no = $request->input('srf_yes_no');
        $checks = $request->input('srf_no');
        foreach ($checks as $key => $srf_nos) {
            $srf_checklist = new SrfChecklist();
            $srf_checklist->srf_id = $srf->srf_id;

            $srf_checklist->srf_no = $srf_nos;
            $srf_checklist->srf_remarks = isset($srf_remarks[$key]) ? $srf_remarks[$key] : null;
            $srf_checklist->srf_yes_no = isset($srf_yes_no[$key]) && $srf_yes_no[$key] ? 'yes' : 'no';
            $srf_checklist->save();
        }
        
        $returned_syllabus = Syllabus::where('syll_id', $syll_id)
            ->join('bayanihan_groups', 'bayanihan_groups.bg_id', 'syllabi.bg_id')
            ->join('courses', 'courses.course_id', 'bayanihan_groups.course_id')
            ->select('bayanihan_groups.bg_school_year', 'courses.course_code', 'syllabi.bg_id')
            ->first();

        // Notification 
        $bayanihan_leaders = BayanihanLeader::where('bg_id', $returned_syllabus->bg_id)->get();
        $bayanihan_members = BayanihanMember::where('bg_id', $returned_syllabus->bg_id)->get();

        $course_code = $returned_syllabus->course_code;
        $bg_school_year = $returned_syllabus->bg_school_year;

        foreach ($bayanihan_leaders as $leader) {
            $user = User::find($leader->bg_user_id);
            if ($user) {
                $user->notify(new BL_SyllabusChairReturned($course_code, $bg_school_year, $syll_id));
            }
        }

        foreach ($bayanihan_members as $member) {
            $user = User::find($member->bm_user_id);
            if ($user) {
                $user->notify(new BT_SyllabusChairReturned($course_code, $bg_school_year, $syll_id));
            }
        }
        // $validatedData = $request->validate([
        //     'srf_remarks.*' => 'nullable',
        //     'srf_yes_no.*' => 'nullable',
        // ]);

        // $srfRemarks = $validatedData['srf_remarks'] ?? [];
        // $srfYesNos = $validatedData['srf_yes_no'] ?? [];

        // foreach ($srfRemarks as $key => $srfRemark) {
        //     $check = new SrfChecklist();

        //     // Use the counter as the srf_no value
        //     $check->srf_no = $key + 1; // Assuming you want to use the counter as the srf_no value

        //     // Add checks to avoid "Undefined array key" error
        //     $check->srf_id = $srf->srf_id;
        //     $check->srf_remarks = $srfRemark;

        //     // Ensure that the key exists in $srfYesNos before accessing it
        //     if (array_key_exists($key, $srfYesNos)) {
        //         $check->srf_yes_no = $srfYesNos[$key];
        //     } else {
        //         // Handle the case where the key does not exist in $srfYesNos
        //         // You can set a default value or handle it based on your requirements
        //         $check->srf_yes_no = '0'; // For example, setting it to null
        //     }            
        //     $check->save();

        return redirect()->route('chairperson.commentSyllabus', $syll_id)->with('success', 'Review Form Submitted. Proceed to comment.');
    }
    public function commentSyllabus($syll_id)
    {
        // $syll = College::join('departments', 'departments.college_id', '=', 'colleges.college_id')
        //     ->join('curricula', 'departments.department_id', '=', 'curricula.department_id')
        //     ->join('courses', 'courses.curr_id', '=', 'curricula.curr_id')
        //     ->join('bayanihan_groups', 'bayanihan_groups.course_id', '=', 'courses.course_id')
        //     ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
        //     ->join('bayanihan_members', 'bayanihan_members.bg_id', '=', 'bayanihan_groups.bg_id')
        //     ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
        //     // ->join('syllabus_instructors', 'syllabi.syll_id', '=', 'syllabus_instructors.syll_id')
        //     ->where('syllabi.syll_id', '=', $syll_id)
        //     ->select('courses.*', 'bayanihan_groups.*', 'syllabi.*', 'departments.*', 'curricula.*', 'colleges.college_description')
        //     ->first();

        $syll = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            ->join('colleges', 'colleges.college_id', '=', 'syllabi.college_id')
            ->join('departments', 'departments.department_id', '=', 'syllabi.department_id') // Corrected
            ->join('curricula', 'curricula.curr_id', '=', 'syllabi.curr_id')
            ->join('courses', 'courses.course_id', '=', 'syllabi.course_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('courses.*', 'bayanihan_groups.*', 'syllabi.*', 'departments.*', 'curricula.*', 'colleges.college_description', 'colleges.college_code')
            ->first();

        // $dean = User::join('deans', 'deans.user_id', '=', 'users.id')
        //     ->join('colleges', 'colleges.college_id', '=', 'deans.college_id')
        //     ->where('colleges.college_id', '=', $syll->college_id)
        //     ->select('users.*', 'colleges.*')
        //     ->first();

        // $chair = User::join('chairpeople', 'chairpeople.user_id', '=', 'users.id')
        //     ->join('departments', 'departments.department_id', '=', 'chairpeople.department_id')
        //     ->where('departments.department_id', '=', $syll->department_id)
        //     ->select('users.*', 'departments.*')
        //     ->first();

        // $programOutcomes = Syllabus::where('syllabi.syll_id', '=', $syll_id)
        //     ->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
        //     ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
        //     ->join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
        //     ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
        //     ->join('program_outcomes', 'program_outcomes.department_id', '=', 'curricula.department_id')
        //     ->get();
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
        $user = Auth::user();
        $notifications = $user->notifications;
        return view('Chairperson.Syllabus.syllComment', compact(
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
        ));
    }

    public function viewReviewForm($syll_id)
    {
        $reviewForm = SyllabusReviewForm::join('srf_checklists', 'srf_checklists.srf_id', '=', 'syllabus_review_forms.srf_id')
            ->where('syllabus_review_forms.syll_id', $syll_id)
            ->select('srf_checklists.*', 'syllabus_review_forms.*')
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
        return view('chairperson.syllabus.viewReviewForm', compact(
            'syll_id',
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
            ->with('success', 'Syllabus Review Form Successfully opened');
    }
}
