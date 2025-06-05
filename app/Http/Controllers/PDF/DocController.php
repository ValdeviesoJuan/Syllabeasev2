<?php

namespace App\Http\Controllers\PDF;
use App\Http\Controllers\Controller;
use App\Models\SrfChecklist;
use App\Models\SyllabusReviewForm;

class DocController extends Controller
{
    public function downloadReviewForm($syll_id)
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

        $data = [
            'date' => date('m/d/Y'),
            'reviewForm' => $reviewForm,
            'srfResults' => $srfResults,
            'srf1' => $srf1,
            'srf2' => $srf2,
            'srf3' => $srf3,
            'srf4' => $srf4,
            'srf5' => $srf5,
            'srf6' => $srf6,
            'srf7' => $srf7,
            'srf8' => $srf8,
            'srf9' => $srf9,
            'srf10' => $srf10,
            'srf11' => $srf11,
            'srf12' => $srf12,
            'srf13' => $srf13,
            'srf14' => $srf14,
            'srf15' => $srf15,
            'srf16' => $srf16,
            'srf17' => $srf17,
            'srf18' => $srf18,
            'srf19' => $srf19,
        ];

        setlocale(LC_TIME, 'es');
        $date = date('Y-m-d');
        $document = new \PhpOffice\PhpWord\TemplateProcessor('doc/ReviewFormTemplate.docx');

        $document->setValue('srf_course_code', $data['reviewForm']->srf_course_code);
        $document->setValue('srf_title', $data['reviewForm']->srf_title);
        $document->setValue('srf_sem_year', $data['reviewForm']->srf_sem_year);
        $document->setValue('srf_faculty', $data['reviewForm']->srf_faculty);
        $document->setValue('srf_date', $data['reviewForm']->srf_date);
        $document->setValue('srf_reviewed_by', $data['reviewForm']->srf_reviewed_by);


        $document->setValue('srf_yes_no_1', $data['srf1']->srf_yes_no);
        $document->setValue('srf_remarks_1', $data['srf1']->srf_remarks);

        $document->setValue('srf_yes_no_2', $data['srf2']->srf_yes_no);

        
        $name = 'Review Form' . '.docx';
        $document->saveAs(storage_path() . "/word/{$name}");
        return response()->download(storage_path() . "/word/{$name}");

    }
}