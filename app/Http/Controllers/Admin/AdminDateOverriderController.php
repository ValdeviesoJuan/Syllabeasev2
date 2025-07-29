<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BayanihanGroup;
use Illuminate\Http\Request;
use App\Models\Syllabus;
use App\Models\Tos;

class AdminDateOverriderController extends Controller
{
    public function viewSyllabusDates($bg_id) 
    {
        $syllabusDetails = BayanihanGroup::where('bayanihan_groups.bg_id', $bg_id)
            ->join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
            ->select('courses.*', 'bayanihan_groups.*')
            ->first();

        $syllabusVersions = Syllabus::where('syllabi.bg_id', $bg_id)
            ->join('colleges', 'colleges.college_id', '=', 'syllabi.college_id')
            ->join('departments', 'departments.department_id', '=', 'syllabi.department_id')
            ->join('curricula', 'curricula.curr_id', '=', 'syllabi.curr_id')
            ->join('courses', 'courses.course_id', '=', 'syllabi.course_id')
            ->select('syllabi.*', 'courses.*')
            ->orderByRaw('CAST(version AS UNSIGNED) DESC')
            ->get();

        return view('admin.syllabus.viewSyllabusDate', compact('syllabusDetails', 'syllabusVersions'));
    }

    public function overrideSyllabusDate(Request $request, $syll_id) 
    {
        $syllabus = Syllabus::findOrFail($syll_id);
        
        // Update only the fields that are not null in the DB and are editable in the form
        $editableFields = [
            'chair_submitted_at',
            'chair_rejected_at',
            'dean_submitted_at',
            'dean_rejected_at',
            'dean_approved_at',
        ];

        foreach ($editableFields as $field) {
            // Don't update disabled fields (nulls) – so only update if it's present in the request
            if ($request->has($field)) {
                $syllabus->$field = $request->$field;
            }
        }
        
        $syllabus->save();
        
        return redirect()->back()->with('success', 'Syllabus dates overridden successfully.');
    }
    public function viewTOSDates($bg_id, $tos_term) 
    {
        $tosDetails = BayanihanGroup::where('bayanihan_groups.bg_id', $bg_id)
            ->join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
            ->where('tos.tos_term', $tos_term)
            ->select('courses.*', 'bayanihan_groups.*', 'tos.*')
            ->first();

        $tosVersions = Tos::where('tos.bg_id', $bg_id)
            ->join('departments', 'departments.department_id', '=', 'tos.department_id')
            ->join('courses', 'courses.course_id', '=', 'tos.course_id')
            ->join('curricula', 'curricula.department_id', '=', 'departments.department_id')
            ->join('colleges', 'colleges.college_id', '=', 'departments.college_id')
            ->select('tos.*', 'courses.*')
            ->where('tos.tos_term', $tos_term)
            ->orderByRaw('CAST(tos_version AS UNSIGNED) DESC')
            ->get();

        return view('admin.tos.viewTOSDate', compact('tosDetails', 'tosVersions'));
    }

    public function overrideTOSDate(Request $request, $tos_id) 
    {
        $tos = Tos::findOrFail($tos_id);
        
        // Update only the fields that are not null in the DB and are editable in the form
        $editableFields = [
            'chair_submitted_at',
            'chair_rejected_at',
            'chair_approved_at',
        ];

        foreach ($editableFields as $field) {
            // Don't update disabled fields (nulls) – so only update if it's present in the request
            if ($request->has($field)) {
                $tos->$field = $request->$field;
            }
        }
        
        $tos->save();
        
        return redirect()->back()->with('success', 'TOS dates overridden successfully.');
    }
}
