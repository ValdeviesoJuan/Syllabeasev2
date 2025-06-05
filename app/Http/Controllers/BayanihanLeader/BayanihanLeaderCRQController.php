<?php

namespace App\Http\Controllers\BayanihanLeader;

use App\Http\Controllers\Controller;
use App\Models\Syllabus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BayanihanLeaderCRQController extends Controller
{
    public function createCrq($syll_id)
    {
        $user = Auth::user(); 
        $notifications = $user->notifications;
        $syllabus = Syllabus::find($syll_id);
        return view('BayanihanLeader.Syllabus.CourseRequirement.crqCreate', compact('notifications', 'syll_id', 'syllabus'));
    }
    public function updateCrq(Request $request, $syll_id)
    {
        $request->validate([
            'syll_course_requirements' => 'required',
        ]);
    
        $syllabus = Syllabus::findOrFail($syll_id);
    
        $syllabus->syll_course_requirements = $request->input('syll_course_requirements');
        $syllabus->save();
    
        return redirect()->route('bayanihanleader.viewSyllabus', $syll_id)->with('success', 'CourseOutcome updated successfully.');
    }
}