<?php

namespace App\Http\Controllers\BayanihanTeacher;

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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use function Laravel\Prompts\select;

class BayanihanTeacherSyllabusController extends Controller
{
    public function syllabus()
    {
        $myDepartment = BayanihanMember::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_members.bg_id')
            ->join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
            ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
            ->join('departments', 'departments.department_id', '=', 'curricula.department_id')
            ->where('bayanihan_members.bm_user_id', '=', Auth::user()->id)
            ->select('departments.department_id')
            ->first();

        $syllabi = Syllabus::join('syllabus_instructors', 'syllabi.syll_id', '=', 'syllabus_instructors.syll_id')
            ->select('syllabus_instructors.*', 'syllabi.*')
            ->get();

        // $syllabus = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
        //     ->join('bayanihan_members', 'bayanihan_members.bg_id', '=', 'bayanihan_groups.bg_id')
        //     ->where('bayanihan_members.bm_user_id', '=', Auth::user()->id)
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
            $syllabiCount = $syllabus->count();
            $completedCount = $syllabus->filter(function ($item) {
                return $item->status === 'Approved by Dean';
            })->count();
            $pendingCount = $syllabus->filter(function ($item) {
                return $item->status === 'Pending';
            })->count();
        } else {
            $syllabus = [];
            $syllabiCount = 0;
            $completedCount = 0;
            $pendingCount = 0;
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
        // View::share('syll', $syll);
        $user = Auth::user();
        $notifications = $user->notifications;
        return view('BayanihanTeacher.Syllabus.syllList', compact('notifications', 'syllabi', 'instructors', 'syllabus', 'syllabiCount', 'completedCount', 'pendingCount'));
    }
    public function index()
    {
        $myDepartment = BayanihanMember::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_members.bg_id')
            ->join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
            ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
            ->join('departments', 'departments.department_id', '=', 'curricula.department_id')
            ->where('bayanihan_members.bm_user_id', '=', Auth::user()->id)
            ->select('departments.department_id')
            ->first();

        $syllabi = Syllabus::join('syllabus_instructors', 'syllabi.syll_id', '=', 'syllabus_instructors.syll_id')
            ->select('syllabus_instructors.*', 'syllabi.*')
            ->get();

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
            $syllabiCount = $syllabus->count();
            $completedCount = $syllabus->filter(function ($item) {
                return $item->status === 'Approved by Dean';
            })->count();
            $pendingCount = $syllabus->filter(function ($item) {
                return $item->status === 'Pending';
            })->count();
        } else {
            $syllabus = [];
            $syllabiCount = 0;
            $completedCount = 0;
            $pendingCount = 0;
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
        // View::share('syll', $syll);
        $user = Auth::user();
        $notifications = $user->notifications;
        return view('BayanihanTeacher.home', compact('notifications', 'syllabi', 'instructors', 'syllabus', 'syllabiCount', 'completedCount', 'pendingCount'));
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
        $reviewForm = SyllabusReviewForm::join('srf_checklists', 'srf_checklists.srf_id', '=', 'syllabus_review_forms.srf_id')
            ->where('syllabus_review_forms.syll_id', $syll_id)
            ->select('srf_checklists.*', 'syllabus_review_forms.*')
            ->first();

        $syllabusVersions = Syllabus::where('syllabi.bg_id', $syll->bg_id)
            ->select('syllabi.*')
            ->get();
        $feedback = SyllabusDeanFeedback::where('syll_id', $syll_id)->first();
        return view('BayanihanTeacher.Syllabus.syllView', compact(
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
        return view('bayanihanleader.syllabus.reviewForm', compact(
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
}
