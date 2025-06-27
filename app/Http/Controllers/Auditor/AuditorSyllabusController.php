<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
use App\Models\BayanihanLeader;
use App\Models\BayanihanMember;
use App\Models\BayanihanGroup;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuditorSyllabusController extends Controller
{
    public function index()
    {
        return view('auditor.syllabus.syllList');
    }

    public function commentSyllabus($syll_id)
    {
        $syll = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            ->join('colleges', 'colleges.college_id', '=', 'syllabi.college_id')
            ->join('departments', 'departments.department_id', '=', 'syllabi.department_id')
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

        return view('auditor.syllabus.syllView', compact(
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
    
}
