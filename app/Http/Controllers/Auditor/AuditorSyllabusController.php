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
use App\Models\User;

class AuditorSyllabusController extends Controller
{
    public function index()
    {
        $syllabi = Syllabus::with(['bayanihanGroup', 'course', 'instructors'])->get();

        $instructors = SyllabusInstructor::join('users', 'syllabus_instructors.syll_ins_user_id', '=', 'users.id')
            ->select('users.*', 'syllabus_instructors.*')
            ->get()
            ->groupBy('syll_id');

        $user = Auth::user();
        $notifications = $user->notifications;

        return view('Auditor.Syllabus.syllList', compact('syllabi', 'instructors', 'notifications'));
    }

    public function commentSyllabus($syll_id)
    {
        $syll = Syllabus::with(['bayanihanGroup', 'course'])->findOrFail($syll_id);

        $programOutcomes = ProgramOutcome::join('departments', 'departments.department_id', '=', 'program_outcomes.department_id')
            ->where('departments.department_id', '=', $syll->department_id)
            ->select('program_outcomes.*')
            ->get();

        $poes = POE::where('department_id', '=', $syll->department_id)->get();

        $courseOutcomes = SyllabusCourseOutcome::where('syll_id', '=', $syll_id)->get();

        $copos = SyllabusCoPO::where('syll_id', '=', $syll_id)->get();

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

        $bLeaders = BayanihanLeader::join('users', 'users.id', '=', 'bayanihan_leaders.bg_user_id')
            ->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_leaders.bg_id')
            ->where('bayanihan_leaders.bg_id', '=', $syll->bg_id)
            ->select('bayanihan_leaders.*', 'users.*')
            ->get();

        $bMembers = BayanihanMember::join('users', 'users.id', '=', 'bayanihan_members.bm_user_id')
            ->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_members.bg_id')
            ->where('bayanihan_members.bg_id', '=', $syll->bg_id)
            ->select('bayanihan_members.*', 'users.*')
            ->get();

        $reviewForm = SyllabusReviewForm::join('srf_checklists', 'srf_checklists.srf_id', '=', 'syllabus_review_forms.srf_id')
            ->where('syllabus_review_forms.syll_id', $syll_id)
            ->select('srf_checklists.*', 'syllabus_review_forms.*')
            ->first();

        $syllabusVersions = Syllabus::where('bg_id', $syll->bg_id)->get();

        $feedback = SyllabusDeanFeedback::where('syll_id', $syll_id)->first();

        return view('auditor.Syllabus.syllView', compact(
    'syll',
    'instructors',
    'syll_id',
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
