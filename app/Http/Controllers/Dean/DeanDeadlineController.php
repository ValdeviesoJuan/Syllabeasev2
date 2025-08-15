<?php

namespace App\Http\Controllers\Dean;

use App\Http\Controllers\Controller;
use App\Models\Deadline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeadlineSetMail;
use App\Notifications\DeadlineSetNotification;
use App\Models\Roles;
use Illuminate\Support\Facades\DB;

class DeanDeadlineController extends Controller
{
    public function deadline()
    {
        $deanRoleId = Roles::where('role_name', 'Dean')->value('role_id'); 
        $dean = UserRole::where('user_id', Auth::id())
            ->where('entity_type', '=', 'College')
            ->where('role_id', '=', $deanRoleId)
            ->whereNotNull('entity_id')
            ->orderByDesc('updated_at')
            ->firstOrFail();

        if ($dean) {
            $college_id = $dean->entity_id;
            $deadlines = Deadline::where('college_id', $college_id)->get();
        } else {
            $deadlines = collect(); // Return empty collection instead of array (avoids errors in Blade)
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
        $user_id = Auth::user()->id; 

        $request->validate([
            'dl_syll' => 'required',
            'dl_tos_midterm' => 'nullable',
            'dl_tos_final' => 'nullable',
            'dl_school_year' => 'required',
            'dl_semester' => 'required',
        ]);

        $deanRoleId = Roles::where('role_name', 'Dean')->value('role_id'); 
        $dean = UserRole::where('user_id', $user_id)
            ->where('entity_type', '=', 'College')
            ->where('role_id', '=', $deanRoleId)
            ->whereNotNull('entity_id')
            ->orderByDesc('updated_at')
            ->firstOrFail();
        $college_id = $dean->entity_id;

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

        $deadline = Deadline::create($request->all());

        // Notify Bayanihan Leaders (role_id = 4)
        $bayanihanLeaders = User::whereHas('roles', function($q) {
            $q->where('user_roles.role_id', 4);
        })->get();

        foreach ($bayanihanLeaders as $bl) {
            $bl->notify(new DeadlineSetNotification($deadline));
        }

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
        $user_id = Auth::user()->id;
        
        $request->validate([
            'dl_syll' => 'required',
            'dl_tos_midterm' => 'nullable',
            'dl_tos_final' => 'nullable',
            'dl_school_year' => 'required',
            'dl_semester' => 'required',
        ]);

        $deanRoleId = Roles::where('role_name', 'Dean')->value('role_id'); 

        $dean = UserRole::where('user_id', $user_id)
            ->where('entity_type', '=', 'College')
            ->where('role_id', '=', $deanRoleId)
            ->whereNotNull('entity_id')
            ->orderByDesc('updated_at')
            ->firstOrFail();
        $college_id = $dean->entity_id;

        $request->merge(['user_id' => $user_id]);
        $request->merge(['college_id' => $college_id]);

        $deadline = Deadline::findOrFail($id);
        $deadline->update($request->all());

        return redirect()->route('dean.deadline')->with('success', 'Deadline updated successfully.');
    }
    public function destroyDeadline($id)
    {
        // Find the deadline first
        $deadline = Deadline::findOrFail($id);

        // Delete related notifications
        DB::table('notifications')
            ->where('type', \App\Notifications\DeadlineSetNotification::class)
            ->whereJsonContains('data->deadline_id', $deadline->dl_id)
            ->delete();

        // Delete the deadline itself
        $deadline->delete();

        return redirect()->route('dean.deadline')->with('success', 'Deadline and related notifications deleted successfully.');
    }
}