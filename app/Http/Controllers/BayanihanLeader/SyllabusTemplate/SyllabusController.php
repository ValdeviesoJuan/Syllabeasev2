<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BayanihanLeader\SyllabusTemplate\TemplatePageController;


class SyllabusController extends Controller
{
 public function show()
{
    $sections = [
        ['id' => 'section1', 'name' => 'HEADER'],
        ['id' => 'section2', 'name' => 'Vision, Mission'],
        ['id' => 'section3', 'name' => 'PEO and PO'],
        ['id' => 'section4', 'name' => 'Course Description'],
        ['id' => 'section5', 'name' => 'Course Outcome'],
        ['id' => 'section6', 'name' => 'Course Outline'],
        ['id' => 'section7', 'name' => 'Course Requirement'],
        ['id' => 'section8', 'name' => 'Faculty Signatures'],
    ];

    $syll = DB::table('syllabi')->where('id', $id)->first();

    return view('BayanihanLeader.SyllabusTemplate.Template', compact('sections', 'syll'));
}

}
