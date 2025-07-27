<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRole;
use App\Models\Roles;
use App\Models\Syllabus;
use App\Models\SyllabusInstructor;
use App\Models\ProgramOutcome;
use App\Models\POE;
use App\Models\SyllabusCoPO;
use App\Models\SyllabusCourseOutcome;
use App\Models\SyllabusCourseOutlineMidterm;
use App\Models\SyllabusCourseOutlinesFinal;
use App\Models\SyllabusCotCoM;
use App\Models\SyllabusCotCoF;
use App\Models\SyllabusReviewForm;
use App\Models\SrfChecklist;
use App\Models\SyllabusDeanFeedback;
use App\Models\BayanihanGroup;
use App\Models\BayanihanGroupUsers;
use Illuminate\Support\Facades\DB;

class AuditorSyllabusController extends Controller
{
    public function index()
    {
        return view('auditor.syllabus.syllList');
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
            ->orderBy('syllabi.version', 'DESC')
            ->get();
        
        $isLatest = Syllabus::where('bg_id', $syll->bg_id)
            ->orderByRaw('CAST(version AS UNSIGNED) DESC')
            ->value('syll_id') == $syll->syll_id;
            
        $feedback = SyllabusDeanFeedback::where('syll_id', $syll_id)->first();

        return view('auditor.syllabus.syllView', compact(
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
            'reviewForm',
            'syllabusVersions',
            'feedback',
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

        return view('auditor.syllabus.reviewForm', compact(
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
        ))->with('success', 'Syllabus submission successful.');
    }
}
