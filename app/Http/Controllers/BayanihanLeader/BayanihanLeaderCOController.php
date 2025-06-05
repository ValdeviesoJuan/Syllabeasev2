<?php

namespace App\Http\Controllers\BayanihanLeader;

use App\Http\Controllers\Controller;
use App\Models\ProgramOutcome;
use App\Models\Syllabus;
use App\Models\SyllabusCoPo;
use Illuminate\Http\Request;
use App\Models\SyllabusCourseOutcome;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Helper\ProgressIndicator;

class BayanihanLeaderCoController extends Controller
{
    public function createCo($syll_id)
    {
        $user = Auth::user(); 
        $notifications = $user->notifications;
        return view('BayanihanLeader.Syllabus.CourseOutcome.coCreate', compact('notifications', 'syll_id'));
    }
    public function storeCo(Request $request, $syll_id)
    {
        // $programOutcomes = Syllabus::where('syllabi.syll_id', '=', $syll_id)
        //     ->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
        //     ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
        //     ->join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
        //     ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
        //     ->join('program_outcomes', 'program_outcomes.department_id', '=', 'curricula.department_id')
        //     ->select('program_outcomes.*')
        //     ->get();
        $programOutcomes = ProgramOutcome::join('departments', 'departments.department_id', '=', 'program_outcomes.department_id')
        ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
        ->where('syllabi.syll_id', '=', $syll_id)
        ->select('program_outcomes.*')
        ->get();
        
        $courseOutcomes = SyllabusCourseOutcome::where('syll_id', '=', $syll_id)->get();

        $validatedData = $request->validate([
            'syll_co_code.*' => 'required',
            'syll_co_description.*' => 'required',
        ]);
        foreach ($validatedData['syll_co_code'] as $key => $syll_co_code) {
            $syllabus = new SyllabusCourseOutcome();
            $syllabus->syll_id = $syll_id;
            $syllabus->syll_co_code = $syll_co_code;
            $syllabus->syll_co_description = $validatedData['syll_co_description'][$key];
            $syllabus->save();
            foreach ($programOutcomes as $po) {
                $colpo = new SyllabusCoPo();
                $colpo->syll_co_id = $syllabus->syll_co_id;
                $colpo->syll_po_id = $po->po_id;
                $colpo->syll_co_po_code = null;
                $colpo->syll_id = $syll_id;
                $colpo->save();
            }
        }
        return redirect()->route('bayanihanleader.viewSyllabus', $syll_id)->with('success', 'CourseOutcome created successfully.');
    }
    public function createCoPo($syll_id)
    {
        // $programOutcomes = Syllabus::where('syllabi.syll_id', '=', $syll_id)
        //     ->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
        //     ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
        //     ->join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
        //     ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
        //     ->join('program_outcomes', 'program_outcomes.department_id', '=', 'curricula.department_id')
        //     ->select('program_outcomes.*')
        //     ->get();
        // multiple progr out inputs
        // $programOutcomes = ProgramOutcome::join('departments', 'departments.department_id', '=', 'program_outcomes.department_id')
        // ->join('curricula', 'curricula.department_id', '=', 'departments.department_id')
        // ->join('courses', 'courses.curr_id', '=', 'curricula.curr_id')
        // ->join('bayanihan_groups', 'bayanihan_groups.course_id', '=', 'courses.course_id')
        // ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
        // ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
        // ->where('bayanihan_leaders.bg_user_id', '=', Auth::user()->id)
        // ->where('syllabi.syll_id', '=', $syll_id)
        // ->groupBy('program_outcomes.po_id')
        // ->select('program_outcomes.*')
        // ->distinct()
        // ->get();
        $programOutcomes = ProgramOutcome::join('departments', 'departments.department_id', '=', 'program_outcomes.department_id')
        ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
        ->get();

        $courseOutcomes = SyllabusCourseOutcome::where('syll_id', '=', $syll_id)->get();
        $user = Auth::user(); 
        $notifications = $user->notifications;
        return view('BayanihanLeader.Syllabus.CourseOutcome.copoCreate', compact('notifications', 'syll_id', 'programOutcomes', 'courseOutcomes'));
    }
    public function storeCoPo(Request $request, $syll_id)
    {
        $validatedData = $request->validate([
            'syll_co_id.*' => 'required',
            'syll_po_id.*' => 'required',
            'syll_co_po_code.*' => ''
        ]);
        foreach ($validatedData['syll_co_id'] as $key => $syll_co_id) {
            $colpo = new SyllabusCoPo();
            $colpo->syll_co_id = $syll_co_id;
            $colpo->syll_po_id = $validatedData['syll_po_id'][$key];
            $colpo->syll_co_po_code = $validatedData['syll_co_po_code'][$key];
            $colpo->syll_id = $syll_id;
            $colpo->save();
        }
        return redirect()->route('bayanihanleader.viewSyllabus', $syll_id)->with('success', 'CourseOutcome created successfully.');
    }
    public function editCoPo($syll_id)
    {
        // $programOutcomes = Syllabus::where('syllabi.syll_id', '=', $syll_id)
        //     ->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
        //     ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
        //     ->join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
        //     ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
        //     ->join('program_outcomes', 'program_outcomes.department_id', '=', 'curricula.department_id')
        //     ->select('program_outcomes.*')
        //     ->get();

        $programOutcomes = ProgramOutcome::join('departments', 'departments.department_id', '=', 'program_outcomes.department_id')
        ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
        ->where('syllabi.syll_id', '=', $syll_id)
        ->select('program_outcomes.*')
        ->get();
        $user = Auth::user(); 
        $notifications = $user->notifications;
        $courseOutcomes = SyllabusCourseOutcome::where('syll_id', '=', $syll_id)->get();
        $copos = SyllabusCoPo::where('syll_id', '=', $syll_id)->get();
        return view('BayanihanLeader.Syllabus.CourseOutcome.copoEdit', compact('notifications', 'syll_id', 'copos', 'courseOutcomes', 'programOutcomes'));
    }
    public function updateCoPo(Request $request, $syll_id)
    {
        $validatedData = $request->validate([
            'syll_co_po_id.*' => 'required',
            'syll_co_id.*' => 'required',
            'syll_po_id.*' => 'required',
            'syll_co_po_code.*' => '',
        ]);
        foreach ($validatedData['syll_co_po_id'] as $key => $syll_co_po_id) {
            $colpo = SyllabusCoPo::find($syll_co_po_id);

            if ($colpo) {
                $colpo->syll_co_po_code = $validatedData['syll_co_po_code'][$key] ?? null;
                $colpo->save();
            }
        }
        return redirect()->route('bayanihanleader.viewSyllabus', $syll_id)->with('success', 'Course Outcome updated successfully.');
    }
    public function editCo($syll_id)
    {
        $user = Auth::user(); 
        $notifications = $user->notifications;
        $courseOutcomes = SyllabusCourseOutcome::where('syll_id', '=', $syll_id)->get();
        return view('BayanihanLeader.Syllabus.CourseOutcome.coEdit', compact('notifications', 'syll_id', 'courseOutcomes'));
    }
    public function updateCo(Request $request, $syll_id)
    {
        $validatedData = $request->validate([
            'syll_co_code.*' => 'required',
            'syll_co_description.*' => 'required',
        ]);

        // Loop through the validated data and update or create records
        foreach ($validatedData['syll_co_code'] as $key => $syll_co_code) {
            $syllabus = SyllabusCourseOutcome::updateOrCreate(
                ['syll_id' => $syll_id, 'syll_co_code' => $syll_co_code],
                ['syll_co_description' => $validatedData['syll_co_description'][$key]]
            );
        }
        return redirect()->route('bayanihanleader.viewSyllabus', $syll_id)->with('success', 'Course Outcomes updated successfully.');
    }
    public function destroyCo($co_id, $syll_id)
    {
        try {
            $co = SyllabusCourseOutcome::findOrFail($co_id);
            $co->delete();
            return redirect()->route('bayanihanleader.editCo', $syll_id)->with('success', 'Course Outcome deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('bayanihanleader.editCo', $syll_id)->with('error', 'Failed to delete Course Outcome.');
        }
    }
}
