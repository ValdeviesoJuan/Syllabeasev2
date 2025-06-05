<?php

namespace App\Http\Controllers\BayanihanLeader;

use App\Http\Controllers\Controller;
use App\Models\SyllabusCotCoF;
use App\Models\SyllabusCotCoM;
use App\Models\SyllabusCourseOutcome;
use App\Models\SyllabusCourseOutlineMidterm;
use App\Models\SyllabusCourseOutlinesFinal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BayanihanLeaderCOTController extends Controller
{
    public function createCot($syll_id)
    {
        $courseOutcomes = SyllabusCourseOutcome::where('syll_id', '=', $syll_id)->get();
        $user = Auth::user();
        $notifications = $user->notifications;
        return view('BayanihanLeader.Syllabus.CourseOutline.cotCreate', compact('notifications', 'syll_id', 'courseOutcomes'));
    }
    public function createCotF($syll_id)
    {
        $user = Auth::user();
        $notifications = $user->notifications;
        $courseOutcomes = SyllabusCourseOutcome::where('syll_id', '=', $syll_id)->get();
        return view('BayanihanLeader.Syllabus.CourseOutline.cotFCreate', compact('notifications', 'syll_id', 'courseOutcomes'));
    }
    public function storeCot(Request $request, $syll_id)
    {
        $request->validate([
            'syll_allotted_hour' => 'required',
            'syll_allotted_time' => 'nullable',
            'syll_intended_learning' => 'nullable',
            'syll_topics' => 'required',
            'syll_course_outcome' => 'nullable|array',
            'syll_suggested_readings' => 'nullable',
            'syll_learning_act' => 'nullable',
            'syll_asses_tools' => 'nullable',
            'syll_grading_criteria' => 'nullable',
            'syll_remarks' => 'nullable',
        ]);

        try {
            $lastRowNo = SyllabusCourseOutlineMidterm::where('syll_id', $syll_id)->max('syll_row_no');
            $cot = new SyllabusCourseOutlineMidterm();
            $cot->fill($request->only([
                'syll_allotted_hour',
                'syll_allotted_time',
                'syll_intended_learning',
                'syll_topics',
                'syll_suggested_readings',
                'syll_learning_act',
                'syll_asses_tools',
                'syll_grading_criteria',
                'syll_remarks',
            ]));
            $cot->syll_row_no = $lastRowNo + 1;
            $cot->syll_id = $syll_id;
            $cot->save();

            $courseOutcomes = $request->input('syll_course_outcome');
            foreach ($courseOutcomes as $syll_co_id) {
                $co = new SyllabusCotCoM();
                $co->syll_co_out_id = $cot->syll_co_out_id;
                $co->syll_co_id = $syll_co_id;
                $co->save();
            }

            return redirect()->route('bayanihanleader.viewSyllabus', $syll_id)->with('success', 'Course Outcome created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('bayanihanleader.viewSyllabus', $syll_id);
        }
    }
    public function storeCotF(Request $request, $syll_id)
    {
        $request->validate([
            'syll_allotted_hour' => 'required',
            'syll_allotted_time' => 'nullable',
            'syll_intended_learning' => 'nullable',
            'syll_topics' => 'required',
            'syll_course_outcome' => 'nullable|array',
            'syll_suggested_readings' => 'nullable',
            'syll_learning_act' => 'nullable',
            'syll_asses_tools' => 'nullable',
            'syll_grading_criteria' => 'nullable',
            'syll_remarks' => 'nullable',
        ]);

        try {
            $lastRowNo = SyllabusCourseOutlinesFinal::where('syll_id', $syll_id)->max('syll_row_no');
            $cot = new SyllabusCourseOutlinesFinal();
            $cot->fill($request->only([
                'syll_allotted_hour',
                'syll_allotted_time',
                'syll_intended_learning',
                'syll_topics',
                'syll_suggested_readings',
                'syll_learning_act',
                'syll_asses_tools',
                'syll_grading_criteria',
                'syll_remarks',
            ]));
            $cot->syll_row_no = $lastRowNo + 1;
            $cot->syll_id = $syll_id;
            $cot->save();

            $courseOutcomes = $request->input('syll_course_outcome');
            foreach ($courseOutcomes as $syll_co_id) {
                $co = new SyllabusCotCoF();
                $co->syll_co_out_id = $cot->syll_co_out_id;
                $co->syll_co_id = $syll_co_id;
                $co->save();
            }

            return redirect()->route('bayanihanleader.viewSyllabus', $syll_id)->with('success', 'Course Outcome created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('bayanihanleader.viewSyllabus', $syll_id)->with('error', 'Failed to create Course Outcome.');
        }
    }
    public function editCot($syll_co_out, $syll_id)
    {
        $cot = SyllabusCourseOutlineMidterm::find($syll_co_out);

        $courseOutcomes = SyllabusCourseOutcome::where('syll_id', '=', $syll_id)->get();

        $cot_cos = SyllabusCotCoM::where('syll_co_out_id', '=', $syll_co_out)->get();
        $user = Auth::user();
        $notifications = $user->notifications;
        return view('BayanihanLeader.Syllabus.CourseOutline.cotEdit', compact('notifications', 'cot', 'courseOutcomes', 'syll_id', 'cot_cos'));
    }

    public function editCotF($syll_co_out, $syll_id)
    {
        $cot = SyllabusCourseOutlinesFinal::find($syll_co_out);

        $courseOutcomes = SyllabusCourseOutcome::where('syll_id', '=', $syll_id)->get();

        $cot_cos = SyllabusCotCoF::where('syll_co_out_id', '=', $syll_co_out)->get();
        $user = Auth::user();
        $notifications = $user->notifications;
        return view('BayanihanLeader.Syllabus.CourseOutline.cotFEdit', compact('notifications', 'cot', 'courseOutcomes', 'syll_id', 'cot_cos'));
    }
    // public function updateCot(Request $request, $syll_co_out_id, $syll_id)
    // {
    //     $request->validate([
    //         'syll_allotted_time' => 'required',
    //         'syll_course_outcome' => 'required',
    //         'syll_intended_learning' => 'required',
    //         'syll_topics' => 'required',
    //         'syll_suggested_readings' => 'nullable',
    //         'syll_learning_act' => 'nullable',
    //         'syll_asses_tools' => 'nullable',
    //         'syll_grading_criteria' => 'nullable',
    //         'syll_remarks' => 'nullable',
    //     ]);
    //     $cot = SyllabusCourseOutline::find($syll_co_out_id);

    //     if (!$cot) {
    //         return redirect()->route('bayanihanleader.home')->with('error', 'Syllabus not found.');
    //     }


    //     $cot->syll_allotted_time = $request->input('syll_allotted_time');
    //     // $cot->syll_course_outcome = $request->input('syll_course_outcome');
    //     $cot->syll_intended_learning = $request->input('syll_intended_learning');
    //     $cot->syll_topics = $request->input('syll_topics');
    //     $cot->syll_suggested_readings = $request->input('syll_suggested_readings');
    //     $cot->syll_learning_act = $request->input('syll_learning_act');
    //     $cot->syll_asses_tools = $request->input('syll_asses_tools');
    //     $cot->syll_grading_criteria = $request->input('syll_grading_criteria');
    //     $cot->syll_remarks = $request->input('syll_remarks');
    //     $cot->syll_id = $syll_id;
    //     $cot->save();

    //     $cot->SyllabusCotCos()->delete();

    //     $courseOutcomes = $request->input('syll_course_outcome');
    //     foreach($courseOutcomes as $syll_co_id){
    //         $co = new SyllabusCotCo();
    //         $co->syll_co_out_id = $cot->syll_co_out_id;
    //         $co->syll_co_id = $syll_co_id;
    //         $co->save();
    //     }
    //     return redirect()->route('bayanihanleader.viewSyllabus', $syll_id)->with('success', 'CourseOutcome updated successfully.');
    // }
    public function updateCot(Request $request, $cot_id, $syll_id)
    {
        $request->validate([
            'syll_allotted_hour'  => 'required',
            'syll_allotted_time' => 'nullable',
            'syll_course_outcome' => 'nullable',
            'syll_intended_learning' => 'nullable',
            'syll_topics' => 'required',
            'syll_suggested_readings' => 'nullable',
            'syll_learning_act' => 'nullable',
            'syll_asses_tools' => 'nullable',
            'syll_grading_criteria' => 'nullable',
            'syll_remarks' => 'nullable',
        ]);

        $cot = SyllabusCourseOutlineMidterm::findOrFail($cot_id);

        $cot->update($request->only([
            'syll_allotted_hour', 
            'syll_allotted_time',
            'syll_intended_learning',
            'syll_topics',
            'syll_suggested_readings',
            'syll_learning_act',
            'syll_asses_tools',
            'syll_grading_criteria',
            'syll_remarks',
        ]));

        $cot->syll_id = $syll_id;
        $cot->save();

        $courseOutcomes = $request->input('syll_course_outcome');

        SyllabusCotCoM::where('syll_co_out_id', $cot->syll_co_out_id)->delete();

        if ($courseOutcomes !== null) {
            foreach ($courseOutcomes as $syll_co_id) {
                $co = new SyllabusCotCoM();
                $co->syll_co_out_id = $cot->syll_co_out_id;
                $co->syll_co_id = $syll_co_id;
                $co->save();
            }
        }

        return redirect()->route('bayanihanleader.viewSyllabus', $syll_id)->with('success', 'CourseOutcome updated successfully.');
    }

    public function updateCotF(Request $request, $cot_id, $syll_id)
    {
        $request->validate([
            'syll_allotted_hour'  => 'required',
            'syll_allotted_time' => 'nullable',
            'syll_course_outcome' => 'nullable',
            'syll_intended_learning' => 'nullable',
            'syll_topics' => 'required',
            'syll_suggested_readings' => 'nullable',
            'syll_learning_act' => 'nullable',
            'syll_asses_tools' => 'nullable',
            'syll_grading_criteria' => 'nullable',
            'syll_remarks' => 'nullable',
        ]);

        $cot = SyllabusCourseOutlinesFinal::findOrFail($cot_id);

        $cot->update($request->only([
            'syll_allotted_hour',
            'syll_allotted_time',
            'syll_intended_learning',
            'syll_topics',
            'syll_suggested_readings',
            'syll_learning_act',
            'syll_asses_tools',
            'syll_grading_criteria',
            'syll_remarks',
        ]));

        $cot->syll_id = $syll_id;
        $cot->save();

        $courseOutcomes = $request->input('syll_course_outcome');

        SyllabusCotCoF::where('syll_co_out_id', $cot->syll_co_out_id)->delete();

        if ($courseOutcomes !== null) {
            foreach ($courseOutcomes as $syll_co_id) {
                $co = new SyllabusCotCoF();
                $co->syll_co_out_id = $cot->syll_co_out_id;
                $co->syll_co_id = $syll_co_id;
                $co->save();
            }
        }

        return redirect()->route('bayanihanleader.viewSyllabus', $syll_id)->with('success', 'CourseOutcome updated successfully.');
    }

    public function destroyCot($co_id, $syll_id)
    {
        try {
            SyllabusCotCoM::where('syll_co_out_id', $co_id)->delete();
            $co = SyllabusCourseOutlineMidterm::findOrFail($co_id);
            $co->delete();
            return redirect()->route('bayanihanleader.viewSyllabus', $syll_id)->with('success', 'Course Outline deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('bayanihanleader.viewSyllabus', $syll_id)->with('error', 'Failed to delete Course Outline.');
        }
    }
    public function destroyCotF($co_id, $syll_id)
    {
        try {
            SyllabusCotCoF::where('syll_co_out_id', $co_id)->delete();
            $co = SyllabusCourseOutlinesFinal::findOrFail($co_id);
            $co->delete();
            return redirect()->route('bayanihanleader.viewSyllabus', $syll_id)->with('success', 'Course Outline deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('bayanihanleader.viewSyllabus', $syll_id)->with('error', 'Failed to delete Course Outline.');
        }
    }
    public function editCotRowM($syll_id)
    {
        $courseOutlinesM = SyllabusCourseOutlineMidterm::where('syll_id', $syll_id)
            ->with('courseOutcomes')
            ->orderBy('syll_row_no', 'ASC')
            ->get();
        $user = Auth::user();
        $notifications = $user->notifications;
        return view('BayanihanLeader.Syllabus.CourseOutline.cotRowMEdit', compact('notifications', 'syll_id', 'courseOutlinesM'));
    }
    public function updateCotRowM(Request $request, $syll_id)
    {
        $courseOutlinesM = SyllabusCourseOutlineMidterm::where('syll_id', $syll_id)
            ->with('courseOutcomes')
            ->orderBy('syll_row_no', 'ASC')
            ->get();
        foreach ($courseOutlinesM as $cot) {
            foreach ($request->order as $order) {
                if ($order['id'] == $cot->syll_co_out_id) {
                    $cot->update(['syll_row_no' => $order['position']]);
                }
            }
        }
        return response('Update Successfully', 200);
    }

    public function editCotRowF($syll_id)
    {
        $courseOutlinesM = SyllabusCourseOutlinesFinal::where('syll_id', $syll_id)
            ->with('courseOutcomes')
            ->orderBy('syll_row_no', 'ASC')
            ->get();
            $user = Auth::user(); 
            $notifications = $user->notifications;
        return view('BayanihanLeader.Syllabus.CourseOutline.cotRowFEdit', compact('notifications', 'syll_id', 'courseOutlinesM'));
    }
    public function updateCotRowF(Request $request, $syll_id)
    {
        $courseOutlinesF = SyllabusCourseOutlinesFinal::where('syll_id', $syll_id)
            ->with('courseOutcomes')
            ->orderBy('syll_row_no', 'ASC')
            ->get();
        foreach ($courseOutlinesF as $cot) {
            foreach ($request->order as $order) {
                if ($order['id'] == $cot->syll_co_out_id) {
                    $cot->update(['syll_row_no' => $order['position']]);
                }
            }
        }
        return response('Update Successfully', 200);
    }
}
