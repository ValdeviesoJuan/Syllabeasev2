<?php

namespace App\Http\Controllers\Dean;

use App\Http\Controllers\Controller;
use App\Models\Chairperson as ModelsChairperson;
use App\Models\Deadline;
use App\Models\Dean;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeanDeadlineController extends Controller
{
    public function deadline(){
        $dean = Dean::where('user_id', Auth::user()->id)->firstOrFail();
        $college_id = $dean->college_id;
        if ($college_id) {
            $deadlines = Deadline::where('deadlines.college_id', $college_id)->get();
        } else {
            $deadlines = [];
        }
        $user = Auth::user(); 
        $notifications = $user->notifications;
        return view('Dean.Deadline.dlList', compact('notifications', 'deadlines'));
    }
    public function createDeadline()
    {
        $user = Auth::user(); 
        $notifications = $user->notifications;
        return view('Dean.Deadline.dlCreate', compact('notifications'));
    }
    public function storeDeadline(Request $request)
    {
        $request->validate([
            'dl_syll' => 'required',
            'dl_tos_midterm' => 'nullable',
            'dl_tos_final' => 'nullable',
            'dl_school_year' => 'required',
            'dl_semester' => 'required',
        ]);

        $dean = Dean::where('user_id', Auth::user()->id)->firstOrFail();
        $college_id = $dean->college_id;
        $user_id = Auth::user()->id; 
    
        $request->merge(['user_id' => $user_id]);
        $request->merge(['college_id' => $college_id]);
        $existingDeadline = Deadline::where([
            'dl_school_year' => $request->input('dl_school_year'),
            'college_id' => $college_id,
            'dl_semester' => $request->input('dl_semester'),
        ])->first();
        if ($existingDeadline) {
            return redirect()->route('dean.createDeadline')->with('error', 'Deadline for that school year and semester already exist.');
        }
        Deadline::create($request->all());
    
        return redirect()->route('dean.deadline')->with('success', 'Deadline set successfully.');
    }
    public function editDeadline(string $dl_id)
    {
        if ($dl_id) {
            $deadline = Deadline::where('deadlines.dl_id', $dl_id)->first();
        } else {
            $deadline = null;
        }
        $user = Auth::user(); 
        $notifications = $user->notifications;
        return view('Dean.Deadline.dlEdit', compact('notifications','deadline'));
    }
    public function updateDeadline(Request $request, $id)
{
    $request->validate([
        'dl_syll' => 'required',
        'dl_tos_midterm' => 'nullable',
        'dl_tos_final' => 'nullable',
        'dl_school_year' => 'required',
        'dl_semester' => 'required',
    ]);

    $dean = Dean::where('user_id', Auth::user()->id)->firstOrFail();
        $college_id = $dean->college_id;
    $user_id = Auth::user()->id;

    $request->merge(['user_id' => $user_id]);
    $request->merge(['college_id' => $college_id]);

    $deadline = Deadline::findOrFail($id);
    $deadline->update($request->all());

    return redirect()->route('dean.deadline')->with('success', 'Deadline updated successfully.');
}
public function destroyDeadline($id)
{
    $deadline = Deadline::findOrFail($id);
    $deadline->delete();

    return redirect()->route('dean.deadline')->with('success', 'Deadline deleted successfully.');
}
}