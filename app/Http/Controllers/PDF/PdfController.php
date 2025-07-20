<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Models\UserRole;
use App\Models\Roles;
use App\Models\BayanihanGroupUsers;
use App\Models\POE;
use App\Models\ProgramOutcome;
use App\Models\Syllabus;
use App\Models\SyllabusCoPo;
use App\Models\SyllabusCotCoF;
use App\Models\SyllabusCotCoM;
use App\Models\SyllabusCourseOutcome;
use App\Models\SyllabusCourseOutlineMidterm;
use App\Models\SyllabusCourseOutlinesFinal;
use App\Models\SyllabusDeanFeedback;
use App\Models\SyllabusInstructor;
use App\Models\SyllabusReviewForm;
use App\Models\Tos;
use App\Models\TosRows;
use Carbon\Carbon;
use DateTime;
use GuzzleHttp\Psr7\Response;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\Style\Table as TableStyle;
use PhpOffice\PhpWord\Style\Cell as CellStyle;
use PhpOffice\PhpWord\Style\Row as RowStyle;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\Shared\Html as HtmlConverter;
use CloudConvert\CloudConvert;
use CloudConvert\Models\Job;
use CloudConvert\Models\Task;
use CloudConvert\Exceptions\ApiException;
use CloudConvert\Exceptions\HttpClientException;

class PDFController extends Controller
{
    public function pdf2($tos_id)
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

        $bLeaders = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_group_users.user_id')
            ->select('bayanihan_group_users.*', 'users.*')
            ->where('tos.tos_id', '=', $tos_id)
            ->where('bayanihan_group_users.bg_role', '=', 'leader')
            ->get();
        $bMembers = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_group_users.user_id')
            ->select('bayanihan_group_users.*', 'users.*')
            ->where('tos.tos_id', '=', $tos_id)
            ->where('bayanihan_group_users.bg_role', '=', 'member')
            ->get();


        $tosVersions = Tos::where('tos.bg_id', $tos->bg_id)
            ->select('tos.*')
            ->get();

        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');
        $chair = Syllabus::join('tos', 'tos.syll_id', '=', 'syllabi.syll_id')
            ->join('user_roles', 'syllabi.department_id', '=', 'user_roles.entity_id')
            ->join('users', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.entity_type', 'Department')
            ->where('user_roles.role_id', $chairRoleId)
            ->first();
            
        return view('PDF.tosPDF', compact('tos_rows', 'tos', 'tos_id', 'bMembers', 'bLeaders', 'tosVersions', 'course_outcomes', 'chair'));
    }
    public function pdf($syll_id)
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

        $reviewForm = SyllabusReviewForm::join('srf_checklists', 'srf_checklists.srf_id', '=', 'syllabus_review_forms.srf_id')
            ->where('syllabus_review_forms.syll_id', $syll_id)
            ->select('srf_checklists.*', 'syllabus_review_forms.*')
            ->first();

        $syllabusVersions = Syllabus::where('syllabi.bg_id', $syll->bg_id)
            ->select('syllabi.*')
            ->get();
        $feedback = SyllabusDeanFeedback::where('syll_id', $syll_id)->first();

        return view('pdf.syllabusPDF', compact(
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
    // public function generateTOSPDF($tos_id)
    // {
    //     $tos = Tos::where('tos_id', $tos_id)->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'tos.bg_id')
    //         ->join('courses', 'courses.course_id', '=', 'tos.course_id')
    //         ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
    //         ->select('tos.*', 'bayanihan_groups.*', 'courses.*')->first();
    //     $course_outcomes = SyllabusCourseOutcome::where('syll_id', '=', $tos->syll_id)->select('syllabus_course_outcomes.*')->get();
    //     $tos_rows = TosRows::where('tos_rows.tos_id', '=', $tos_id)
    //         ->leftJoin('tos', 'tos.tos_id', '=', 'tos_rows.tos_id')
    //         ->select('tos.*', 'tos_rows.*')
    //         ->get();
    //     $bLeaders = BayanihanLeader::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_leaders.bg_id')
    //         ->join('tos', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
    //         ->join('users', 'users.id', '=', 'bayanihan_leaders.bg_user_id')
    //         ->select('bayanihan_leaders.*', 'users.*')
    //         ->where('tos.tos_id', '=', $tos_id)
    //         ->get();

    //     $bMembers = BayanihanMember::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_members.bg_id')
    //         ->join('tos', 'tos.bg_id', '=', 'bayanihan_members.bg_id')
    //         ->join('users', 'users.id', '=', 'bayanihan_members.bm_user_id')
    //         ->select('bayanihan_members.*', 'users.*')
    //         ->where('tos.tos_id', '=', $tos_id)
    //         ->get();
    //     $tosVersions = Tos::where('tos.bg_id', $tos->bg_id)
    //         ->select('tos.*')
    //         ->get();

    //     $chair = Syllabus::join('tos', 'tos.syll_id', '=', 'syllabi.syll_id')
    //         ->join('user_roles', 'syllabi.department_id', '=', 'user_roles.entity_id')
    //         ->join('users', 'users.id', '=', 'user_roles.user_id')
    //         ->first();

    //     $data = [
    //         'title' => 'Welcome to Tutsmake.com',
    //         'date' => date('m/d/Y'),
    //         'tos' => $tos,
    //         'course_outcomes' => $course_outcomes,
    //         'tos_rows' => $tos_rows,
    //         'bLeaders' => $bLeaders,
    //         'bMembers' => $bMembers,
    //         'tosVersions' => $tosVersions,
    //         'chair' => $chair,
    //     ];
    //     $pdf = PDF::loadView('PDF.tosPDF', $data);
    //     return $pdf->download('tos.pdf');
    // }

    // public function generateSyllabusPDF($syll_id)
    // {

    //     $syll = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
    //         ->join('colleges', 'colleges.college_id', '=', 'syllabi.college_id')
    //         ->join('departments', 'departments.department_id', '=', 'syllabi.department_id') // Corrected
    //         ->join('curricula', 'curricula.curr_id', '=', 'syllabi.curr_id')
    //         ->join('courses', 'courses.course_id', '=', 'syllabi.course_id')
    //         ->where('syllabi.syll_id', '=', $syll_id)
    //         ->select('courses.*', 'bayanihan_groups.*', 'syllabi.*', 'departments.*', 'curricula.*', 'colleges.college_description', 'colleges.college_code')
    //         ->first();

    //     $programOutcomes = ProgramOutcome::join('departments', 'departments.department_id', '=', 'program_outcomes.department_id')
    //         ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
    //         ->where('syllabi.syll_id', '=', $syll_id)
    //         ->select('program_outcomes.*')
    //         ->get();
    //     $poes = POE::join('departments', 'departments.department_id', '=', 'poes.department_id')
    //         ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
    //         ->where('syllabi.syll_id', '=', $syll_id)
    //         ->select('poes.*')
    //         ->get();

    //     $courseOutcomes = SyllabusCourseOutcome::where('syll_id', '=', $syll_id)
    //         ->get();
    //     $copos = [];
    //     foreach ($courseOutcomes as $courseOutcome) {
    //         $copos = SyllabusCoPo::where('syll_co_id', '=', $courseOutcome->syll_co_id)
    //             ->get();
    //     }
    //     $instructors = SyllabusInstructor::join('users', 'syllabus_instructors.syll_ins_user_id', '=', 'users.id')
    //         ->select('users.*', 'syllabus_instructors.*')
    //         ->get()
    //         ->groupBy('syll_id');

    //     $courseOutlines = SyllabusCourseOutlineMidterm::where('syll_id', '=', $syll_id)
    //         ->with('courseOutcomes')
    //         ->orderBy('syll_row_no', 'asc')
    //         ->get();

    //     $courseOutlinesFinals = SyllabusCourseOutlinesFinal::where('syll_id', '=', $syll_id)
    //         ->with('courseOutcomes')
    //         ->orderBy('syll_row_no', 'asc')
    //         ->get();

    //     $cotCos = SyllabusCotCoM::join('syllabus_course_outcomes', 'syllabus_cot_cos_midterms.syll_co_id', '=', 'syllabus_course_outcomes.syll_co_id')
    //         ->select('syllabus_course_outcomes.*', 'syllabus_cot_cos_midterms.*')
    //         ->get()
    //         ->groupBy('syll_co_out_id');

    //     $cotCosF = SyllabusCotCoF::join('syllabus_course_outcomes', 'syllabus_cot_cos_finals.syll_co_id', '=', 'syllabus_course_outcomes.syll_co_id')
    //         ->select('syllabus_course_outcomes.*', 'syllabus_cot_cos_finals.*')
    //         ->get()
    //         ->groupBy('syll_co_out_id');

    //     $bLeaders = BayanihanLeader::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_leaders.bg_id')
    //         ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
    //         ->join('users', 'users.id', '=', 'bayanihan_leaders.bg_user_id')
    //         ->select('bayanihan_leaders.*', 'users.*')
    //         ->where('syllabi.syll_id', '=', $syll_id)
    //         ->get();

    //     $bMembers = BayanihanMember::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_members.bg_id')
    //         ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_members.bg_id')
    //         ->join('users', 'users.id', '=', 'bayanihan_members.bm_user_id')
    //         ->select('bayanihan_members.*', 'users.*')
    //         ->where('syllabi.syll_id', '=', $syll_id)
    //         ->get();

    //     $reviewForm = SyllabusReviewForm::join('srf_checklists', 'srf_checklists.srf_id', '=', 'syllabus_review_forms.srf_id')
    //         ->where('syllabus_review_forms.syll_id', $syll_id)
    //         ->select('srf_checklists.*', 'syllabus_review_forms.*')
    //         ->first();

    //     $syllabusVersions = Syllabus::where('syllabi.bg_id', $syll->bg_id)
    //         ->select('syllabi.*')
    //         ->get();
    //     $filename = 'syllabus.pdf';

    //     $data = [
    //         'title' => 'Welcome to Tutsmake.com',
    //         'date' => date('m/d/Y'),
    //         'syll' => $syll,
    //         'programOutcomes' => $programOutcomes,
    //         'poes' => $poes,
    //         'courseOutlinesFinals' => $courseOutlinesFinals,
    //         'copos' => $copos,
    //         'instructors' => $instructors,
    //         'courseOutlines' => $courseOutlines,
    //         'cotCos' => $cotCos,
    //         'cotCosF' => $cotCosF,
    //         'bLeaders' => $bLeaders,
    //         'bMembers' => $bMembers,
    //         'reviewForm' => $reviewForm,
    //         'syllabusVersions' => $syllabusVersions,
    //         'courseOutcomes' => $courseOutcomes,
    //     ];
    //     $pdf = PDF::loadView('PDF.syllabusPDF', $data);
    //     return $pdf->download('my_pdf.pdf');
    // }
    public function generateTOSPDF($tos_id)
    {
        $tos = Tos::where('tos_id', $tos_id)->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'tos.bg_id')
            ->join('courses', 'courses.course_id', '=', 'tos.course_id')
            ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
            ->select('tos.*', 'bayanihan_groups.*', 'courses.*')->first();

        $course_outcomes = SyllabusCourseOutcome::where('syll_id', '=', $tos->syll_id)
            ->select('syllabus_course_outcomes.*')
            ->get();
        
        $tos_rows = TosRows::leftJoin('tos', 'tos.tos_id', '=', 'tos_rows.tos_id')
            ->where('tos_rows.tos_id', '=', $tos_id)
            ->select('tos.*', 'tos_rows.*')
            ->get();

        $bLeaders = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_group_users.user_id')
            ->select('bayanihan_group_users.*', 'users.*')
            ->where('tos.tos_id', '=', $tos_id)
            ->where('bayanihan_group_users.bg_role', '=', 'leader')
            ->get();
        $bMembers = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_group_users.user_id')
            ->select('bayanihan_group_users.*', 'users.*')
            ->where('tos.tos_id', '=', $tos_id)
            ->where('bayanihan_group_users.bg_role', '=', 'member')
            ->get();

        $tosVersions = Tos::where('tos.bg_id', $tos->bg_id)
            ->select('tos.*')
            ->get();

        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');
        $chair = Syllabus::join('tos', 'tos.syll_id', '=', 'syllabi.syll_id')
            ->join('user_roles', 'syllabi.department_id', '=', 'user_roles.entity_id')
            ->join('users', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.entity_type', 'Department')
            ->where('user_roles.role_id', $chairRoleId)
            ->first();

        $data = [
            'title' => 'W',
            'date' => date('m/d/Y'),
            'tos' => $tos,
            'course_outcomes' => $course_outcomes,
            'tos_rows' => $tos_rows,
            'bLeaders' => $bLeaders,
            'bMembers' => $bMembers,
            'tosVersions' => $tosVersions,
            'chair' => $chair,
        ];
        setlocale(LC_TIME, 'es');
        $document = new TemplateProcessor('doc/Tos-Template.docx');

        $document->setValue('tos_term', $data['tos']->tos_term);
        $document->setValue('course_code', $data['tos']->course_code);
        $document->setValue('course_title', $data['tos']->course_title);

        $document->setValue('bg_school_year', $data['tos']->bg_school_year);
        $document->setValue('course_semester', $data['tos']->course_semester);

        $document->setValue('tos_cpys', $data['tos']->tos_cpys);
        $document->setValue('chair_submitted_at', $data['tos']->chair_submitted_at);

        $coCount = count($course_outcomes);
        $document->cloneRow('syll_co_code', $coCount);
        foreach ($course_outcomes as $index => $co) {
            $syll_co_code = $co['syll_co_code'];
            $syll_co_description = $co['syll_co_description'];

            $document->setValue('syll_co_code#' . ($index + 1), $syll_co_code);
            $document->setValue('syll_co_description#' . ($index + 1), $syll_co_description);
        }
        $document->setValue('col_1_per', $data['tos']->col_1_per);
        $document->setValue('col_2_per', $data['tos']->col_2_per);
        $document->setValue('col_3_per', $data['tos']->col_3_per);
        $document->setValue('col_4_per', $data['tos']->col_4_per);
        $tosRowCount = count($tos_rows);
        $document->cloneRow('tos_r_topic', $tosRowCount);
        foreach ($tos_rows as $index => $co) {
            $tos_r_topic = $co['tos_r_topic'];
            $tos_r_topic = str_replace("\n", '</w:t><w:br/><w:t>', $tos_r_topic);
            $tos_r_topic = str_replace("&", "and", $tos_r_topic);
            $tos_r_no_hours = $co['tos_r_no_hours'];
            $tos_r_percent = $co['tos_r_percent'];
            $tos_r_no_items = $co['tos_r_no_items'];
            $tos_r_col_1 = (int)$co['tos_r_col_1'];
            $tos_r_col_2 = (int)$co['tos_r_col_2'];
            $tos_r_col_3 = (int)$co['tos_r_col_3'];
            $tos_r_col_4 = (int)$co['tos_r_col_4'];

            $document->setValue('tos_r_topic#' . ($index + 1), $tos_r_topic);
            $document->setValue('tos_r_no_hours#' . ($index + 1), $tos_r_no_hours);
            $document->setValue('tos_r_percent#' . ($index + 1), $tos_r_percent);
            $document->setValue('tos_r_no_items#' . ($index + 1), $tos_r_no_items);
            $document->setValue('tos_r_col_1#' . ($index + 1), $tos_r_col_1);
            $document->setValue('tos_r_col_2#' . ($index + 1), $tos_r_col_2);
            $document->setValue('tos_r_col_3#' . ($index + 1), $tos_r_col_3);
            $document->setValue('tos_r_col_4#' . ($index + 1), $tos_r_col_4);
        }

        $document->setValue('tos_no_items', $data['tos']->tos_no_items);
        $document->setValue('col_1_exp', $data['tos']->col_1_exp);
        $document->setValue('col_2_exp', $data['tos']->col_2_exp);
        $document->setValue('col_3_exp', $data['tos']->col_3_exp);
        $document->setValue('col_4_exp', $data['tos']->col_4_exp);

        $total_tos_r_no_hours = 0;
        $total_tos_r_percent = 0;
        foreach ($tos_rows as $tos_row) {
            $total_tos_r_no_hours += $tos_row->tos_r_no_hours;
            $total_tos_r_percent += $tos_row->tos_r_percent;
        }
        $document->setValue('t_total_tos_r_no_hours', $total_tos_r_no_hours);
        $document->setValue('t_total_tos_r_percent', $total_tos_r_percent);
        $document->setValue('prepared_by', "NOO");

        $btCount = count($bLeaders);

        $document->cloneRow('firstname', $btCount);
        foreach ($bLeaders as $index => $bLeader) {


            $prefix = $bLeader['prefix'];
            $firstname = $bLeader['firstname'];
            $lastname = $bLeader['lastname'];
            $suffix = $bLeader['suffix'];

            $document->setValue('prefix#' . ($index + 1), $prefix);
            $document->setValue('firstname#' . ($index + 1), $firstname);
            $document->setValue('lastname#' . ($index + 1), $lastname);
            $document->setValue('suffix#' . ($index + 1), $suffix);
        }


        $document->setValue('chairFirstname', $data['chair']->firstname);
        $document->setValue('chairLastname', $data['chair']->lastname);
        $document->setValue('chairPrefix', $data['chair']->prefix);
        $document->setValue('chairSuffix', $data['chair']->suffix);

        if ($data['tos']->tos_term == 'Midterm') {
            $document->setValue('tos_midterm', "/");
            $document->setValue('tos_final', "");
        } else if ($data['tos']->tos_term == 'Final') {
            $document->setValue('tos_midterm', "");
            $document->setValue('tos_final', "/");
        }

        $timestamp = ($data['tos']->chair_submitted_at);
        $submitted_date = Carbon::parse($timestamp)->format('F j, Y');

        $document->setValue('submitted_date', $submitted_date);

        $name = 'TOS' . '-' . "$tos->course_title"  . "-" . "$tos->status" . "-" . "$submitted_date" . '.docx';

        $document->saveAs(storage_path() . "/word/{$name}");
        return response()->download(storage_path() . "/word/{$name}");
    }

    public function generateSyllabusPDF($syll_id)
    {
        $syll = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            ->join('colleges', 'colleges.college_id', '=', 'syllabi.college_id')
            ->join('departments', 'departments.department_id', '=', 'syllabi.department_id') 
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

        $poes = POE::join('departments', 'departments.department_id', '=', 'poes.department_id')
            ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('poes.*')
            ->get();

        $courseOutcomes = SyllabusCourseOutcome::where('syll_id', '=', $syll_id)
            ->select('syllabus_course_outcomes.*')
            ->get();

        $copos = [];
        foreach ($courseOutcomes as $courseOutcome) {
            $copos = SyllabusCoPo::where('syll_co_id', '=', $courseOutcome->syll_co_id)
                ->get();
        }
        // $instructors = SyllabusInstructor::join('users', 'syllabus_instructors.syll_ins_user_id', '=', 'users.id')
        //     ->select('users.*', 'syllabus_instructors.*')
        //     ->get()
        //     ->groupBy('syll_id');
        $instructors = SyllabusInstructor::join('users', 'syllabus_instructors.syll_ins_user_id', '=', 'users.id')
            ->where('syllabus_instructors.syll_id', '=', $syll_id)
            ->select('users.*', 'syllabus_instructors.*')
            ->get();

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
            ->where('bayanihan_group_users.bg_role', '=', 'leader')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->get();
        $bMembers = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_group_users.user_id')
            ->select('bayanihan_group_users.*', 'users.*')
            ->where('bayanihan_group_users.bg_role', '=', 'member')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->get();

        $reviewForm = SyllabusReviewForm::join('srf_checklists', 'srf_checklists.srf_id', '=', 'syllabus_review_forms.srf_id')
            ->where('syllabus_review_forms.syll_id', $syll_id)
            ->select('srf_checklists.*', 'syllabus_review_forms.*')
            ->first();

        $syllabusVersions = Syllabus::where('syllabi.bg_id', $syll->bg_id)
            ->select('syllabi.*')
            ->get();
        $filename = 'syllabus.pdf';

        $data = [
            'title' => 'Welcome to Tutsmake.com',
            'date' => date('m/d/Y'),
            'syll' => $syll,
            'programOutcomes' => $programOutcomes,
            'poes' => $poes,
            'courseOutcomes' => $courseOutcomes,
            'copos' => $copos,
            'courseOutlines' => $courseOutlines,
            'courseOutlinesFinals' => $courseOutlinesFinals,
            'cotCos' => $cotCos,
            'cotCosF' => $cotCosF,
            'instructors' => $instructors,
            'bLeaders' => $bLeaders,
            'bMembers' => $bMembers,
            'chair' => $chair,
            'dean' => $dean,
            'reviewForm' => $reviewForm,
            'syllabusVersions' => $syllabusVersions,
        ];
        setlocale(LC_TIME, 'es');
        $date = date('Y-m-d');
        $document = new TemplateProcessor('doc/Syllabus-Template.docx');

        $formattedDate = date('m.d.y', strtotime($data['syll']->effectivity_date));
        $document->setValue('effective_date', $formattedDate);
        
        $document->setValue('college_description', $data['syll']->college_description);
        $document->setValue('department_name', $data['syll']->department_name);

        $document->setValue('course_title', $data['syll']->course_title);
        $document->setValue('course_code', $data['syll']->course_code);

        $document->setValue('course_credit_unit', $data['syll']->course_credit_unit);
        $document->setValue('course_unit_lec', $data['syll']->course_unit_lec);
        $document->setValue('course_unit_lab', $data['syll']->course_unit_lab);

        $document->setValue('course_semester', $data['syll']->course_semester);
        $document->setValue('bg_school_year', $data['syll']->bg_school_year);
        $document->setValue('syll_class_schedule', str_replace("\n", '</w:t><w:br/><w:t>', $data['syll']->syll_class_schedule));
        $document->setValue('syll_bldg_rm', $data['syll']->syll_bldg_rm);
        $document->setValue('course_pre_req', $data['syll']->course_pre_req);
        $document->setValue('course_co_req', $data['syll']->course_co_req);

        $instructorNames = [];
        $instructorEmails = [];
        $instructorPhones = [];

        foreach ($data['instructors'] as $instructor) {
            $instructorNames[] = $instructor->firstname . ' ' . $instructor->lastname;
            $instructorEmails[] = $instructor->email;
            $instructorPhones[] = $instructor->phone;
        }
        $document->setValue('instructor_names', implode(', ', $instructorNames));
        $document->setValue('instructor_emails', implode(', ', $instructorEmails));
        $document->setValue('instructor_phones', implode(', ', $instructorPhones));

        $document->setValue('syll_ins_consultation', $syll->syll_ins_consultation);
        $document->setValue('syll_ins_bldg_rm', $syll->syll_ins_bldg_rm);
        $document->setValue('syll_course_description', $syll->syll_course_description);

        //For Course Outline Midterms Section
        $rowCount = count($courseOutlines);
        $document->cloneRow('syll_allotted_time', $rowCount);
        foreach ($courseOutlines as $index => $row) {
            $syll_allotted_time = str_replace("\n", '</w:t><w:br/><w:t>', $row['syll_allotted_time']);
            $syll_intended_learning = str_replace("\n", '</w:t><w:br/><w:t>', $row['syll_intended_learning']);
            $syll_topics = str_replace("\n", '</w:t><w:br/><w:t>', $row['syll_topics']);
            $syll_suggested_readings = str_replace("\n", '</w:t><w:br/><w:t>', $row['syll_suggested_readings']);
            $syll_learning_act = str_replace("\n", '</w:t><w:br/><w:t>', $row['syll_learning_act']);
            $syll_asses_tools = str_replace("\n", '</w:t><w:br/><w:t>', $row['syll_asses_tools']);
            $syll_grading_criteria = str_replace("\n", '</w:t><w:br/><w:t>', $row['syll_grading_criteria']);
            $syll_remarks = str_replace("\n", '</w:t><w:br/><w:t>', $row['syll_remarks']);

            $syll_allotted_time = str_replace("&", 'and', $row['syll_allotted_time']);
            $syll_intended_learning = str_replace("&", 'and', $row['syll_intended_learning']);
            // $syll_topics = str_replace("&", 'hello', $row['syll_topics']);
            $syll_topics = str_replace('&', 'and', $syll_topics);

            $syll_suggested_readings = str_replace("&", 'and', $row['syll_suggested_readings']);
            $syll_learning_act = str_replace("&", 'and', $row['syll_learning_act']);
            $syll_asses_tools = str_replace("&", 'and', $row['syll_asses_tools']);
            $syll_grading_criteria = str_replace("&", 'and', $row['syll_grading_criteria']);
            $syll_remarks = str_replace("&", 'and', $row['syll_remarks']);
            $syll_topics = str_replace("&", 'and', $row['syll_topics']);

            $syll_topics = str_replace("'", '&apos;', $syll_topics);


            $document->setValue('syll_allotted_time#' . ($index + 1), $row['syll_allotted_hour'] . 'hours' .$syll_allotted_time);
            $document->setValue('syll_intended_learning#' . ($index + 1), $syll_intended_learning);
            $document->setValue('syll_topics#' . ($index + 1), $syll_topics);
            $document->setValue('syll_suggested_readings#' . ($index + 1), $syll_suggested_readings);
            $document->setValue('syll_learning_act#' . ($index + 1), $syll_learning_act);
            $document->setValue('syll_asses_tools#' . ($index + 1), $syll_asses_tools);
            $document->setValue('syll_grading_criteria#' . ($index + 1), $syll_grading_criteria);
            $document->setValue('syll_remarks#' . ($index + 1), $syll_remarks);

            $coOutId = $row['syll_co_out_id'];
            $courseOutcomes = $cotCos->get($coOutId, []);

            $cooString = '';
            $cooCount = count($courseOutcomes);
            foreach ($courseOutcomes as $cooIndex => $coo) {
                $cooString .= $coo['syll_co_code'];
                if ($cooIndex < $cooCount - 1) {
                    $cooString .= ', ';
                }
            }
            $document->setValue('syll_co_code#' . ($index + 1), nl2br(e($cooString)));
        }
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(false);

        //For Course Outline Finals Section
        $rowCount_f = count($courseOutlinesFinals);
        $document->cloneRow('syll_allotted_time_f', $rowCount_f);
        foreach ($courseOutlinesFinals as $index => $row) {
            $syll_allotted_time_f = str_replace("\n", '</w:t><w:br/><w:t>', $row['syll_allotted_time']);
            $syll_intended_learning_f = str_replace("\n", '</w:t><w:br/><w:t>', $row['syll_intended_learning']);
            $syll_topics_f = str_replace("\n", '</w:t><w:br/><w:t>', $row['syll_topics']);
            $syll_suggested_readings_f = str_replace("\n", '</w:t><w:br/><w:t>', $row['syll_suggested_readings']);
            $syll_learning_act_f = str_replace("\n", '</w:t><w:br/><w:t>', $row['syll_learning_act']);
            $syll_asses_tools_f = str_replace("\n", '</w:t><w:br/><w:t>', $row['syll_asses_tools']);
            $syll_grading_criteria_f = str_replace("\n", '</w:t><w:br/><w:t>', $row['syll_grading_criteria']);
            $syll_remarks_f = str_replace("\n", '</w:t><w:br/><w:t>', $row['syll_remarks']);

            $syll_allotted_time_f = str_replace("&", 'and', $row['syll_allotted_time']);
            $syll_intended_learning_f = str_replace("&", 'and', $row['syll_intended_learning']);
            $syll_topics_f = str_replace('&', 'and', $syll_topics);
            $syll_suggested_readings_f = str_replace("&", 'and', $row['syll_suggested_readings']);
            $syll_learning_act_f = str_replace("&", 'and', $row['syll_learning_act']);
            $syll_asses_tools_f = str_replace("&", 'and', $row['syll_asses_tools']);
            $syll_grading_criteria_f = str_replace("&", 'and', $row['syll_grading_criteria']);
            $syll_remarks_f = str_replace("&", 'and', $row['syll_remarks']);

            $syll_topics_f = str_replace("'", '&apos;', $syll_topics_f);

            $document->setValue('syll_allotted_time_f#' . ($index + 1), $row['syll_allotted_hour'] . ' hours ' . $syll_allotted_time_f);
            $document->setValue('syll_intended_learning_f#' . ($index + 1), $syll_intended_learning_f);
            $document->setValue('syll_topics_f#' . ($index + 1), $syll_topics_f);
            $document->setValue('syll_suggested_readings_f#' . ($index + 1), $syll_suggested_readings_f);
            $document->setValue('syll_learning_act_f#' . ($index + 1), $syll_learning_act_f);
            $document->setValue('syll_asses_tools_f#' . ($index + 1), $syll_asses_tools_f);
            $document->setValue('syll_grading_criteria_f#' . ($index + 1), $syll_grading_criteria_f);
            $document->setValue('syll_remarks_f#' . ($index + 1), $syll_remarks_f);

            $coOutId = $row['syll_co_out_id'];
            $courseOutcomes = $cotCos->get($coOutId, []);

            $cooString = '';
            $cooCount = count($courseOutcomes);
            foreach ($courseOutcomes as $cooIndex => $coo) {
                $cooString .= $coo['syll_co_code'];
                if ($cooIndex < $cooCount - 1) {
                    $cooString .= ', ';
                }
            }
            $document->setValue('syll_co_code_f#' . ($index + 1), nl2br(e($cooString)));
        }

        //For Program Educational Objectives in Syllabus
        $poeCount = count($poes);
        $document->cloneRow('poe_code', $poeCount);
        foreach ($poes as $index => $poe) {
            $poe_code = $poe['poe_code'];
            $poe_description = htmlspecialchars_decode($poe['poe_description']);

            $document->setValue('poe_code#' . ($index + 1), $poe_code);
            $document->setValue('poe_description#' . ($index + 1), $poe_description);
        }

        //For Program Outcomes in Syllabus
        $poCount = count($programOutcomes);
        $document->cloneRow('po_letter', $poCount);
        foreach ($programOutcomes as $index => $po) {
            $po_letter = $po['po_letter'];
            $po_description = htmlspecialchars_decode($po['po_description']);

            $document->setValue('po_letter#' . ($index + 1), $po_letter);
            $document->setValue('po_description#' . ($index + 1), $po_description);
        }

        //For all Instructors in Syllabus
        $insCount = count($instructors);
        $document->cloneRow('ins_firstname', $insCount);
        foreach ($instructors as $index => $instructor) {
            $ins_firstname = $instructor['firstname'];
            $ins_lastname = $instructor['lastname'];
            $signatureFilename = $instructor['signature'];

            $signaturePath = public_path('assets/signatures/' . $signatureFilename);

            // Check if file exists and set image
            if (!empty($signatureFilename) && file_exists($signaturePath)) {
                $document->setImageValue('ins_signature#' . ($index + 1), [
                    'path' => $signaturePath,
                    'width' => 120,     // adjust as needed
                    'height' => 50,     // adjust as needed
                    'ratio' => true,
                ]);
            } else {
                $document->setValue('ins_signature#' . ($index + 1), ''); // fallback
            }

            $document->setValue('ins_firstname#' . ($index + 1), $ins_firstname);
            $document->setValue('ins_lastname#' . ($index + 1), $ins_lastname);
        }

        $chairSignaturePath = public_path('assets/signatures/' . $data['chair']->signature);
        $deanSignaturePath = public_path('assets/signatures/' . $data['dean']->signature);

        $document->setValue('syll_chair', $data['syll']->syll_chair);
        if (!empty($data['chair']->signature) && file_exists($chairSignaturePath)) {
            $document->setImageValue('syll_chair_signature', [
                'path' => $chairSignaturePath,
                'width' => 120,
                'height' => 50,
                'ratio' => true,
            ]);
        }

        $document->setValue('syll_dean', $data['syll']->syll_dean);
        if (!empty($data['dean']->signature) && file_exists($deanSignaturePath)) {
            $document->setImageValue('syll_dean_signature', [
                'path' => $deanSignaturePath,
                'width' => 120,
                'height' => 50,
                'ratio' => true,
            ]);
        }

        //For Syllabus Course Requirement Section
        $syll_course_requirements = htmlspecialchars_decode(($data['syll']->syll_course_requirements));
        $syll_course_requirements = str_replace('andbull;', '&bull;', $syll_course_requirements);
        $syll_course_requirements = str_replace('&nbsp;', '', $syll_course_requirements);
        $syll_course_requirements = str_replace('%;', '', $syll_course_requirements);
        $syll_course_requirements = str_replace('&', 'and', $syll_course_requirements);
        $syll_course_requirements = str_replace('/n', '</w:t><w:br/><w:t>', $syll_course_requirements);
        $syll_course_requirements = str_replace('andbull;', '&bull;', $syll_course_requirements);
        $syll_course_requirements = str_replace("andrsquo;", '&apos;', $syll_course_requirements);
        $syll_course_requirements = str_replace("andndash;", '', $syll_course_requirements);

        // $syll_course_requirements = str_replace(':', '', $syll_course_requirements); 

        $dom = new \DOMDocument();
        @$dom->loadHTML($syll_course_requirements);

        $body = $dom->getElementsByTagName('body')->item(0);
        $children = $body->childNodes;

        $placeholderIndex = 0;

        $currentContent = '';
        $lastElementType = null;

        foreach ($children as $child) {
            if ($child->nodeName == 'table') {
                if (!empty($currentContent) && $lastElementType !== 'table') {
                    $document->setValue("syll_course_requirements_{$placeholderIndex}", nl2br($currentContent));
                    $placeholderIndex++;
                    $currentContent = '';
                }

                $phpWordTable = new Table(array('borderSize' => 6, 'borderColor' => '000000', 'width' => 100 * 50, 'unit' => TblWidth::PERCENT));

                foreach ($child->getElementsByTagName('tr') as $domRow) {
                    $phpWordTable->addRow();

                    foreach ($domRow->getElementsByTagName('td') as $domCell) {
                        $colspan = $domCell->getAttribute('colspan');
                        $colspan = $colspan ? intval($colspan) : 1;

                        $cellStyle = array(
                            'gridSpan' => $colspan,
                            'alignment' => Jc::CENTER,
                            'valign' => 'center'
                        );

                        $phpWordTable->addCell(2000 * $colspan, $cellStyle)->addText($domCell->textContent, array(), array('alignment' => Jc::CENTER));
                    }
                }

                $document->setComplexBlock("syll_course_requirements_{$placeholderIndex}", $phpWordTable);
                $placeholderIndex++;
                $lastElementType = 'table';
            } elseif ($child->nodeName == 'p' || $child->nodeType == XML_TEXT_NODE) {
                $text = trim($child->textContent);

                if (!empty($text)) {
                    if ($lastElementType !== 'text') {
                        $currentContent = '';
                    }

                    $currentContent .= $text . "\n";
                    $lastElementType = 'text';
                }
            } elseif ($child->nodeName == 'ul' || $child->nodeName == 'ol') {
                if ($lastElementType !== 'text') {
                    $currentContent = '';
                }

                foreach ($child->getElementsByTagName('li') as $li) {
                    $currentContent .= '- ' . $li->textContent . "\n";
                }
                $lastElementType = 'text';
            }
        }

        if (!empty($currentContent)) {
            $document->setValue("syll_course_requirements_{$placeholderIndex}", nl2br($currentContent));
        }
        for ($i = $placeholderIndex; $i < 51; $i++) {
            $document->setValue("syll_course_requirements_{$i}", '');
        }

        //For Syllabus Course Outcome Section
        $programOutcomes = ProgramOutcome::join('departments', 'departments.department_id', '=', 'program_outcomes.department_id')
            ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('program_outcomes.*')
            ->get();
        
        $courseOutcomes = SyllabusCourseOutcome::where('syll_id', '=', $syll_id)
            ->get();

        $copos = SyllabusCoPO::where('syll_id', '=', $syll_id)
            ->get();

        // Define default font style
        $fontStyle = ['name' => 'Times New Roman', 'size' => 9];
        $boldFontStyle = ['name' => 'Times New Roman', 'size' => 9, 'bold' => true];
        $paragraphStyle = ['alignment' => Jc::CENTER, 'spaceBefore' => 0, 'spaceAfter' => 0];

        $phpWordTable = new Table(array(
            'borderSize' => 6, 
            'borderColor' => '000000', 
            'width' => 100 * 50, 
            'unit' => TblWidth::PERCENT,
            'cellMarginTop' => 0,
            'cellMarginBottom' => 0,
            'cellMarginLeft' => 50,    // Optional for inner spacing
            'cellMarginRight' => 50    // Optional for inner spacing
        ));

        // === First Header Row ===
        $phpWordTable->addRow();

        // Course Outcomes (CO) column with rowspan 2
        $phpWordTable->addCell(2500, ['valign' => 'center', 'vMerge' => 'restart'])->addText(
            'Course Outcomes (CO)', $boldFontStyle, $paragraphStyle
        );

        // Program Outcomes (PO) column spanning all POs
        $phpWordTable->addCell(count($programOutcomes) * 300, ['valign' => 'center', 'gridSpan' => count($programOutcomes)])
            ->addText('Program Outcomes (PO)', $boldFontStyle, $paragraphStyle);

        // === Second Header Row ===
        $phpWordTable->addRow();

        // This cell continues the rowspan from "Course Outcomes (CO)"
        $phpWordTable->addCell(null, ['vMerge' => 'continue']); // Empty cell continuing the row span

        foreach ($programOutcomes as $index => $po) {
            $phpWordTable->addCell(300, ['valign' => 'center'])->addText(
                ($index + 1), $boldFontStyle, $paragraphStyle
            );
        }

        foreach ($courseOutcomes as $co) {
            $phpWordTable->addRow();

            $coText = "{$co->syll_co_code}: {$co->syll_co_description}";
            $phpWordTable->addCell(2500)->addText($coText, $fontStyle, ['alignment' => 'left']);

            foreach ($programOutcomes as $po) {
                $coPoCode = '';

                foreach ($copos as $copo) {
                    if ($copo->syll_po_id == $po->po_id && $copo->syll_co_id == $co->syll_co_id) {
                        $coPoCode = $copo->syll_co_po_code;
                        break;
                    }
                }

                $phpWordTable->addCell(300, ['valign' => 'center'])->addText(
                    $coPoCode, $fontStyle, $paragraphStyle
                );
            }
        }

        $document->setComplexBlock('co_po', $phpWordTable);


        $name = 'Syllabus' . '-' . "$syll->course_title"  . "-" . "$syll->status" . "-" . "$date" . '.docx';
        $document->saveAs(storage_path() . "/word/{$name}");

        return response()->download(storage_path() . "/word/{$name}");
        // $name = 'Syllabus' . '-' . "$syll->course_title"  . "-" . "$syll->status" . "-" . "$date" . '.docx';
        // $path = storage_path("word/{$name}");

        // $document->saveAs($path);

        // return response()->download($path)->deleteFileAfterSend(true);

        // $name = 'Syllabus' . '-' . "$syll->course_title" . "-" . "$syll->status" . "-" . "$date" . '.docx';
        // $wordPath = storage_path("word/{$name}");
        // $document->saveAs($wordPath);

        // // Initialize CloudConvert with your API key
        // $cloudconvert = new CloudConvert(['api_key' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYzMxM2UyZGQ4NWFmYzZiNWFlOWQ5OTc5YTEzN2I0NmYyN2FkMzNlY2I4NTYxZjY0ZThkNmIyZjQzMGNmNTAxYjhkYmE5Mzg4NTc3Y2RiM2QiLCJpYXQiOjE3MjUwNjk4NDUuNDIyMjIzLCJuYmYiOjE3MjUwNjk4NDUuNDIyMjI0LCJleHAiOjQ4ODA3NDM0NDUuNDE4MTQ1LCJzdWIiOiI2OTQ0ODkzNCIsInNjb3BlcyI6WyJ0YXNrLndyaXRlIl19.NrZsCheaq2DD59c-XOuEY4LqBboEMxjdkQMx45-F7PpZG72ifqjTIhSfLVi2g-_e9p2DbIAEb9RRVG528v-2aoCCkjXBayHlucnjwbRZWap33smUXpt0uJwxrIWU63io--kHXO0pZ6RSLRUzEy8EIW9BYyEBF3I0phoOTYVu2I5vQQJD636stsLN8H_9wJqdgWEj4Wxib3Psytt06Wrf71Kym4PZAp58hlYzU51yojRDoTeya26zP5kaE0wWc5wXFNHAUlg_wpGrUfzSU3H7VEESrofnWua9H6ClY3l6wYw3mR80IPNey41iiwM-de5teRqm7gsa3zVyEQbu98jKMO2tUgfTqWvLP0pQIUWBZhLfA1oXElNhUrqmT853kZ-Uqbr1NH82qQ4xPX8-5zqzSysR40uk1PVSHG7xRhHPNAFIeihovTG2xYBBlbFbKmKWgI2yBhBD4zx7eUzMlN0t2MbiS3G8iDnZxm27CPLRVyzf3lpMQmkmyFT0ilJqMnuo0UEKyErApvM-MlRMnVs8l8lz5Iz0P6d3cdSCq7ynfx4KnLYQUunmhRjCbbIHKnBULMW_LXFF-Lqj_xPt3HYqSfOKAx_M_YQljqWJvMo_pCqzjC6veW_iFIw9KtkNC4Vi406xchicYhzdN6J7giGbGCWEL2HmFAqgyiZ-B7A50gQ']);

        // // Retry logic
        // $maxRetries = 5;  // Max retries to avoid infinite loop
        // $retryCount = 0;
        // $waitTime = 5; // seconds to wait between retries

        // while ($retryCount < $maxRetries) {
        //     try {
        //         // Create a new job
        //         $job = new Job();

        //         // Define tasks for the job with unique names
        //         $importTask = (new Task('import/upload', 'import-my-file'));
        //         $convertTask = (new Task('convert', 'convert-my-file'))
        //             ->set('input', 'import-my-file')
        //             ->set('output_format', 'pdf')
        //             ->set('input_format', 'docx');
        //         $exportTask = (new Task('export/url', 'export-my-file'))
        //             ->set('input', 'convert-my-file');

        //         $job->addTask($importTask);
        //         $job->addTask($convertTask);
        //         $job->addTask($exportTask);

        //         // Create the job
        //         $createdJob = $cloudconvert->jobs()->create($job);

        //         // Check if the job creation was successful
        //         if (!$createdJob) {
        //             throw new Exception("Job creation failed.");
        //         }

        //         // Continue with upload and conversion process...

        //         $importTask = $createdJob->getTasks()->whereName('import-my-file')[0];
        //         $cloudconvert->tasks()->upload($importTask, fopen($wordPath, 'r'));

        //         $cloudconvert->jobs()->wait($createdJob->getId());

        //         $exportTask = $createdJob->getTasks()->whereName('export-my-file')[0];
        //         $pdfUrl = $exportTask->getResult()->getFiles()[0]->getUrl();

        //         // Save the PDF to local storage
        //         $pdfContent = file_get_contents($pdfUrl);
        //         $pdfName = 'Syllabus-' . "$syll->course_title" . "-" . "$syll->status" . "-" . "$date" . '.pdf';
        //         $pdfPath = storage_path("pdf/{$pdfName}");
        //         file_put_contents($pdfPath, $pdfContent);

        //         // Delete the Word file
        //         unlink($wordPath);

        //         return response()->download($pdfPath)->deleteFileAfterSend(true);

        //     } catch (\CloudConvert\Exceptions\ApiTemporaryUnavailableException $e) {
        //         // If we hit rate limit or too many jobs error, wait and retry
        //         $retryCount++;
        //         if ($retryCount >= $maxRetries) {
        //             return response()->json(['error' => 'Too many jobs. Please try again later.'], 429);
        //         }
        //         sleep($waitTime);
        //     } catch (\Exception $e) {
        //         return response()->json(['error' => $e->getMessage()], 500);
        //     }
        // }
        // return redirect()->route('bayanihanleader.viewSyllabus', $syll_id)->with('success', 'The Syllabi has been exported as docx.');
        return redirect()->back()->with('success', 'The Syllabi has been exported as docx.');
    }
}
