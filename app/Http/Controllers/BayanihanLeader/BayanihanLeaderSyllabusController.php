<?php

namespace App\Http\Controllers\BayanihanLeader;

use App\Http\Controllers\Controller;
use App\Models\BayanihanGroup;
use App\Models\BayanihanLeader;
use App\Models\BayanihanMember;
use App\Models\User;
use App\Models\Syllabus;
use App\Models\College;
use App\Models\POE;
use App\Models\ProgramOutcome;
use App\Models\SrfChecklist;
use App\Models\SyllabusComment;
use App\Models\SyllabusCoPo;
use App\Models\SyllabusCotCoF;
use App\Models\SyllabusCotCoM;
use App\Models\SyllabusCourseOutcome;
use App\Models\SyllabusCourseOutline;
use App\Models\SyllabusCourseOutlineMidterm;
use App\Models\SyllabusCourseOutlinesFinal;
use App\Models\SyllabusDeanFeedback;
use App\Models\SyllabusInstructor;
use App\Models\SyllabusReviewForm;
use App\Notifications\Chair_SyllabusSubmittedtoChair;
use App\Notifications\SyllabusSubmittedtoChair;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use function Laravel\Prompts\select;

class BayanihanLeaderSyllabusController extends Controller
{
    public function index()
    {
        $myDepartment = BayanihanLeader::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_leaders.bg_id')
            ->join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
            ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
            ->join('departments', 'departments.department_id', '=', 'curricula.department_id')
            ->where('bayanihan_leaders.bg_user_id', '=', Auth::user()->id)
            ->select('departments.department_id')
            ->first();

        $syllabi = Syllabus::join('syllabus_instructors', 'syllabi.syll_id', '=', 'syllabus_instructors.syll_id')
            ->select('syllabus_instructors.*', 'syllabi.*')
            ->get();

        // $syllabus = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
        //     ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
        //     ->where('bayanihan_leaders.bg_user_id', '=', Auth::user()->id)
        //     ->leftJoin('courses', 'courses.course_id', '=',  'bayanihan_groups.course_id')
        //     ->where('syllabi.department_id', '=', $myDepartment->department_id)
        //     ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
        //     ->get();
        if ($myDepartment) {
            // $syllabus = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            //     ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
            //     ->where('bayanihan_leaders.bg_user_id', '=', Auth::user()->id)
            //     ->leftJoin('courses', 'courses.course_id', '=',  'bayanihan_groups.course_id')
            //     ->where('syllabi.department_id', '=', $myDepartment->department_id)
            //     ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
            //     ->get();
            $syllabus = BayanihanGroup::join('syllabi', function ($join) {
                $join->on('syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
                    ->whereRaw('syllabi.version = (SELECT MAX(version) FROM syllabi WHERE bg_id = bayanihan_groups.bg_id)');
            })
                ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
                ->where('bayanihan_leaders.bg_user_id', '=', Auth::user()->id)
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

        // $syll = College::join('departments', 'departments.college_id', '=', 'colleges.college_id')
        //     ->join('curricula', 'departments.department_id', '=', 'curricula.department_id')
        //     ->join('courses', 'courses.curr_id', '=', 'curricula.curr_id')
        //     ->join('bayanihan_groups', 'bayanihan_groups.course_id', '=', 'courses.course_id')
        //     ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
        //     ->join('bayanihan_members', 'bayanihan_members.bg_id', '=', 'bayanihan_groups.bg_id')
        //     ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
        //     ->join('syllabus_instructors', 'syllabi.syll_id', '=', 'syllabus_instructors.syll_id')
        //     ->select('courses.*', 'bayanihan_groups.*', 'syllabi.*')
        //     ->get();

        $instructors = SyllabusInstructor::join('users', 'syllabus_instructors.syll_ins_user_id', '=', 'users.id')
            ->select('users.*', 'syllabus_instructors.*')
            ->get()
            ->groupBy('syll_id');
            $user = Auth::user(); 
            $notifications = $user->notifications;



        // View::share('syll', $syll);
        return view('BayanihanLeader.Syllabus.syllList', compact('notifications','syllabi', 'instructors', 'syllabus'));
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
        $poes = POE::join('departments', 'departments.department_id', '=', 'poes.department_id')
            ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('poes.*')
            ->get();

        $courseOutcomes = SyllabusCourseOutcome::where('syll_id', '=', $syll_id)
            ->get();

        // foreach ($courseOutcomes as $courseOutcome) {
        //     $copos = SyllabusCoPO::where('syll_co_id', '=', $courseOutcome->syll_co_id)
        //         ->get();
        // }
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
        // $syllabusComments = SyllabusComment::join('users', 'users.id', '=', 'syllabus_comments.user_id')
        // ->where('syllabus_comments.syll_id', '=', $syll_id)
        // ->select('users.*', 'syllabus_comments.*')
        // ->orderBy('syllabus_comments.syll_created_at', 'asc')
        // ->get();

        $reviewForm = SyllabusReviewForm::join('srf_checklists', 'srf_checklists.srf_id', '=', 'syllabus_review_forms.srf_id')
            ->where('syllabus_review_forms.syll_id', $syll_id)
            ->select('srf_checklists.*', 'syllabus_review_forms.*')
            ->first();

        $syllabusVersions = Syllabus::where('syllabi.bg_id', $syll->bg_id)
            ->select('syllabi.*')
            ->get();
        $feedback = SyllabusDeanFeedback::where('syll_id', $syll_id)->first();

        return view('BayanihanLeader.Syllabus.syllView', compact(
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
            'reviewForm',
            'syllabusVersions',
            'feedback'
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
        // $syllabusComments = SyllabusComment::join('users', 'users.id', '=', 'syllabus_comments.user_id')
        // ->where('syllabus_comments.syll_id', '=', $syll_id)
        // ->select('users.*', 'syllabus_comments.*')
        // ->orderBy('syllabus_comments.syll_created_at', 'asc')
        // ->get();
        $syllabusVersions = Syllabus::where('syllabi.bg_id', $syll->bg_id)
            ->select('syllabi.*')
            ->get();
        return view('BayanihanLeader.Syllabus.syllComment', compact(
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
            'syllabusVersions'
        ))->with('success', 'Switched to Comment Mode.');
    }
    public function createSyllabus()
    {
        $bGroups = BayanihanGroup::join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
            ->join('bayanihan_leaders', 'bayanihan_groups.bg_id', '=', 'bayanihan_leaders.bg_id')
            ->where('bayanihan_leaders.bg_user_id', '=', Auth::user()->id)
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

        $dean = User::join('deans', 'deans.user_id', '=', 'users.id')
            ->join('colleges', 'colleges.college_id', '=', 'deans.college_id')
            ->where('colleges.college_id', '=', $info->college_id)
            ->select('users.firstname', 'users.lastname', 'users.*')
            ->first();

        $chair = User::join('chairpeople', 'chairpeople.user_id', '=', 'users.id')
            ->join('departments', 'departments.department_id', '=', 'chairpeople.department_id')
            ->where('departments.department_id', '=', $info->department_id)
            ->select('users.*', 'departments.*')
            ->first();
        $syllabus = new Syllabus();
        $syllabus->bg_id = $request->input('bg_id');
        $syllabus->syll_class_schedule = $request->input('syll_class_schedule');
        $syllabus->syll_bldg_rm = $request->input('syll_bldg_rm');
        $syllabus->syll_ins_consultation = $request->input('syll_ins_consultation');
        $syllabus->syll_ins_bldg_rm = $request->input('syll_ins_bldg_rm');
        $syllabus->syll_course_description = $request->input('syll_course_description');

        $syllabus->college_id = $info->college_id;
        $syllabus->department_id = $info->department_id;
        $syllabus->curr_id = $info->curr_id;
        $syllabus->course_id = $info->course_id;

        $syllabus->syll_dean = $dean->prefix . ' ' . $dean->firstname . ' ' . $dean->lastname . ' ' . $dean->suffix;
        $syllabus->syll_chair = $chair->prefix . ' ' . $chair->firstname . ' ' . $chair->lastname . ' ' . $chair->suffix;

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
            ->join('bayanihan_leaders', 'bayanihan_groups.bg_id', '=', 'bayanihan_leaders.bg_id')
            ->where('bayanihan_leaders.bg_user_id', '=', Auth::user()->id)
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
        $syllabus->status = 'Pending';
        $syllabus->save();

        $chair = User::join('chairpeople', 'chairpeople.user_id', '=', 'users.id')
        ->join('departments', 'departments.department_id', '=', 'chairpeople.department_id')
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
        $syll_id->delete();
        return redirect()->route('bayanihanleader.home')->with('success', 'Syllabus deleted successfully.');
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
            $newSyllabus->status = null;
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
}
