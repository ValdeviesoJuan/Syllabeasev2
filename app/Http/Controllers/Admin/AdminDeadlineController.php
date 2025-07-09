<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deadline;
use App\Models\User;
use App\Models\Roles;
use App\Models\UserRole;
use App\Models\College;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\DeadlineSetNotification;

class AdminDeadlineController extends Controller
{
    public function deadline()
    {
        $deadlines = Deadline::join('colleges', 'colleges.college_id', '=', 'deadlines.college_id')
            ->select('deadlines.*', 'colleges.*')
            ->get();

        return view('admin.deadline.dllist', compact('deadlines'));
    }
    public function createDeadline()
    {
        $colleges = College::where('colleges.college_status','=','Active')->get();

        return view('admin.deadline.dlcreate', ['colleges' => $colleges]);
    }
    public function storeDeadline(Request $request)
    {
         try {
            $user_id = Auth::id();

            $validated = $request->validate([
                'dl_syll'         => 'required|date',
                'dl_tos_midterm'  => 'required|date',
                'dl_tos_final'    => 'required|date',
                'dl_school_year'  => 'required|string',
                'dl_semester'     => 'required|string',
                'college_id'      => 'required|exists:colleges,college_id',
            ]);

            // ✅ Check for existing deadline
            $existingDeadline = Deadline::where([
                'dl_school_year' => $validated['dl_school_year'],
                'dl_semester'    => $validated['dl_semester'],
                'college_id'     => $validated['college_id'],
            ])->first();

            if ($existingDeadline) {
                return redirect()
                    ->route('admin.createDeadline')
                    ->withInput()
                    ->with('error', 'Deadline for that school year and semester already exists.');
            }

            // ✅ Save new deadline
            $validated['user_id'] = $user_id;
            $deadline = Deadline::create($validated);

            // ✅ Notify Bayanihan Leaders (role_id = 4)
            $bayanihanLeaders = User::whereHas('userRoles', function ($query) {
                $query->where('role_id', 4);
            })->get();

            foreach ($bayanihanLeaders as $bl) {
                $bl->notify(new DeadlineSetNotification($deadline));
            }

            return redirect()
                ->route('admin.deadline')
                ->with('success', 'Deadline set successfully.');

        } catch (\Exception $e) {
            // Optional: log the error
            // \Log::error('Failed to store deadline: ' . $e->getMessage());

            return redirect()
                ->route('admin.createDeadline')
                ->withInput()
                ->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }
    public function editDeadline(string $dl_id)
    {
        if ($dl_id) {
            $deadline = Deadline::where('deadlines.dl_id', $dl_id)->first();
        } else {
            $deadline = null;
        }
        
        $colleges = College::where('colleges.college_status','=','Active')->get();

        return view('admin.deadline.dledit', compact('deadline', 'colleges'));
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
            'college_id' => 'required',
        ]);

        $request->merge(['user_id' => $user_id]);

        $deadline = Deadline::findOrFail($id);
        $deadline->update($request->all());

        return redirect()->route('admin.deadline')->with('success', 'Deadline updated successfully.');
    }
    public function destroyDeadline($id)
    {
        $deadline = Deadline::findOrFail($id);

        DB::table('notifications')
            ->where('type', \App\Notifications\DeadlineSetNotification::class)
            ->whereJsonContains('data->deadline_id', $deadline->dl_id)
            ->delete();

        $deadline->delete();

        return redirect()->route('admin.deadline')->with('success', 'Deadline and related notifications deleted successfully.');
    }
}
