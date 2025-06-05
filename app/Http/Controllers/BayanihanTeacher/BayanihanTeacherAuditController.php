<?php

namespace App\Http\Controllers\BayanihanTeacher;

use App\Http\Controllers\Controller;
use App\Models\BayanihanLeader;
use App\Models\BayanihanMember;
use App\Models\Syllabus;
use App\Models\SyllabusCoPo;
use App\Models\SyllabusCotCoF;
use App\Models\SyllabusCotCoM;
use App\Models\SyllabusCourseOutcome;
use App\Models\SyllabusCourseOutlineMidterm;
use App\Models\SyllabusCourseOutlineFinal;
use App\Models\SyllabusCourseOutlinesFinal;
use App\Models\SyllabusInstructor;
use App\Models\Tos;
use App\Models\TosRows;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class BayanihanLeaderAuditController extends Controller
{
    public function viewAudit($syll_id)
    {
        $syll = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            ->join('colleges', 'colleges.college_id', '=', 'syllabi.college_id')
            ->join('departments', 'departments.department_id', '=', 'syllabi.department_id') // Corrected
            ->join('curricula', 'curricula.curr_id', '=', 'syllabi.curr_id')
            ->join('courses', 'courses.course_id', '=', 'syllabi.course_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('courses.*', 'bayanihan_groups.*', 'syllabi.*', 'departments.*', 'curricula.*', 'colleges.college_description', 'colleges.college_code')
            ->first();


        $syllabusVersions = Syllabus::where('syllabi.bg_id', $syll->bg_id)
            ->select('syllabi.*')
            ->get();
        $bLeaders = BayanihanLeader::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_leaders.bg_id')
            ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_leaders.bg_user_id')
            ->select('bayanihan_leaders.*', 'users.*')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->get();

        $bMembers = BayanihanMember::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_members.bg_id')
            ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_members.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_members.bm_user_id')
            ->select('bayanihan_members.*', 'users.*')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->get();

        $courseOutcomes = SyllabusCourseOutcome::where('syll_id', $syll_id)->get();
        $coIds = $courseOutcomes->pluck('syll_co_id')->toArray();

        $syllabusCoPo = SyllabusCoPo::where('syll_id', $syll_id)->get();
        $coPoIds = $syllabusCoPo->pluck('syll_co_po_id')->toArray();

        $syllabusCourseOutlineM = SyllabusCourseOutlineMidterm::where('syll_id', $syll_id)->get();
        $coMIds = $syllabusCourseOutlineM->pluck('syll_co_out_id')->toArray();

        $syllabusCourseOutlineF = SyllabusCourseOutlinesFinal::where('syll_id', $syll_id)->get();
        $coFIds = $syllabusCourseOutlineM->pluck('syll_co_out_id')->toArray();

        $syllabusCotCoM = SyllabusCotCoM::whereIn('syll_co_out_id', $coMIds)->get();
        $cotCoMIds = $syllabusCotCoM->pluck('syllabus_cot_co')->toArray();

        $syllabusCotCoF = SyllabusCotCoF::whereIn('syll_co_out_id', $coFIds)->get();
        $cotCoFIds = $syllabusCotCoM->pluck('syllabus_cot_co')->toArray();

        $syllabusAudits = Audit::where('auditable_type', Syllabus::class)
            ->where('auditable_id', $syll_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $syllabusCourseOutcomesAudit = Audit::where('auditable_type', SyllabusCourseOutcome::class)
            ->whereIn('auditable_id', $coIds)
            ->orderBy('created_at', 'desc')
            ->get();

        $syllabusCoPoAudit = Audit::where('auditable_type', SyllabusCoPo::class)
            ->whereIn('auditable_id', $coPoIds)
            ->orderBy('created_at', 'desc')
            ->get();

        $syllabusCourseOutlineMAudit = Audit::where('auditable_type', SyllabusCourseOutlineMidterm::class)
            ->whereIn('auditable_id', $coMIds)
            ->orderBy('created_at', 'desc')
            ->get();
        $syllabusCourseOutlineFAudit = Audit::where('auditable_type', SyllabusCourseOutlinesFinal::class)
            ->whereIn('auditable_id', $coFIds)
            ->orderBy('created_at', 'desc')
            ->get();
        $syllabusCotCoMAudit = Audit::where('auditable_type', SyllabusCotCoM::class)
            ->whereIn('auditable_id', $cotCoMIds)
            ->orderBy('created_at', 'desc')
            ->get();
        $syllabusCotCoFAudit = Audit::where('auditable_type', SyllabusCotCoF::class)
            ->whereIn('auditable_id', $cotCoFIds)
            ->orderBy('created_at', 'desc')
            ->get();

        $audits = $syllabusAudits->merge($syllabusCourseOutcomesAudit)->merge($syllabusCoPoAudit)
            ->merge($syllabusCourseOutlineMAudit)->merge($syllabusCourseOutlineFAudit)->merge($syllabusCotCoMAudit)
            ->merge($syllabusCotCoFAudit);

        $audits = $audits->sortByDesc('created_at');

        return view('bayanihanteacher.audit.blAudit', compact('syll_id', 'syllabusVersions', 'syll', 'bLeaders', 'bMembers', 'audits'));
    }
    public function viewTosAudit($tos_id)
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

        $bMembers = BayanihanMember::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_members.bg_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_members.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_members.bm_user_id')
            ->select('bayanihan_members.*', 'users.*')
            ->where('tos.tos_id', '=', $tos_id)
            ->get();
        $tosVersions = Tos::where('tos.bg_id', $tos->bg_id)
            ->select('tos.*')
            ->get();

        $toss = Tos::where('tos_id', $tos_id)->get();
        $tosIds = $toss->pluck('tos_id')->toArray();

        $tosRow = TosRows::where('tos_id', $tos_id)->get();
        $tosRowsIds = $tosRow->pluck('tos_id')->toArray();

        $tosAudit = Audit::where('auditable_type', Tos::class)
            ->whereIn('auditable_id', $tosIds)
            ->orderBy('created_at', 'desc')
            ->get();
            $tosRowsAudit = Audit::where('auditable_type', TosRows::class)
            ->whereIn('auditable_id', $tosRowsIds)
            ->orderBy('created_at', 'desc')
            ->get();

        $audits = $tosAudit->merge($tosRowsAudit);
        $audits = $audits->sortByDesc('created_at');
        return view('bayanihanteacher.audit.blTosAudit', compact('tos_rows', 'tos', 'tos_id', 'bMembers', 'bLeaders', 'tosVersions', 'course_outcomes', 'audits'));
    }
}
