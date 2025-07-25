<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\College;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeanAssigned;

class AdminCollegeController extends Controller
{
    public function index(){
        $colleges = College::paginate(10, ['*'], 'colleges_page');

        $deanRoleId = Roles::where('role_name', 'Dean')->value('role_id'); 

        $deans = College::join('user_roles', function ($join) use ($deanRoleId) {
                $join->on('user_roles.entity_id', '=', 'colleges.college_id')
                     ->where('user_roles.entity_type', 'College')
                     ->where('user_roles.role_id',  $deanRoleId);
            })
            ->join('users', 'users.id', '=', 'user_roles.user_id')
            ->select('users.*', 'user_roles.*', 'colleges.*')
            ->paginate(10, ['*'], 'deans_page');

        return view('Admin.College.collegeList', compact('colleges', 'deans'));
    }
    public function createCollege()
    {
        return view('Admin.College.collegeCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeCollege(Request $request)
    {
        $request->validate([
            'college_code' => 'required|string',
            'college_description' => 'required|string',
        ]);

        College::create($request->all());

        return redirect()->route('admin.college')->with('success', 'College created successfully.');
    }

    public function editCollege(string $college_id)
    {
        $college = College::where('college_id', $college_id)->firstOrFail();

        return view('Admin.College.collegeEdit', compact('college'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCollege(Request $request, string $college_id)
    {
        $college = College::findorFail($college_id);

        $request->validate([
            'college_code' => 'required|string',
            'college_description' => 'required|string',
            'college_status' => 'required|string',
        ]);

        $college->update([
            'college_code' =>  $request->input('college_code'),
            'college_description' =>  $request->input('college_description'),
            'college_status' =>  $request->input('college_status'),

        ]);
        return redirect()->route('admin.college')->with('success', 'College Information Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyCollege(College $college_id)
    {
        
        $college_id->delete();
        return redirect()->route('admin.college')
        ->with('success', 'College deleted successfully.');
    }
    //Dean Controller
    public function createDean()
    {
        $users = User::all();
        $colleges = College::all();
        return view('Admin.Dean.deanCreate', compact('users', 'colleges'));
    }
    public function storeDean(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string|exists:users,id',
            'college_id' => 'required|string|exists:colleges,college_id',
            'start_validity' => 'required|date',
            'end_validity' => 'nullable|date|after:start_validity',
        ]);

        $deanRoleId = Roles::where('role_name', 'Dean')->value('role_id');

        // ⚠️ 1. Check if the user already holds a dean role in any college
        $userHasDeanRole = UserRole::where('role_id', $deanRoleId)
            ->where('entity_type', 'College')
            ->where('user_id', $request->user_id)
            ->where(function ($q) use ($request) {
                $q->whereNull('end_validity')
                ->orWhere('end_validity', '>', $request->start_validity);
            })
            ->whereNotNull('entity_id')
            ->exists();

        if ($userHasDeanRole) {
            return back()->with('error', 'This user is already assigned as dean in another college.');
        }

        DB::transaction(function () use ($request, $deanRoleId) {
            // End any currently active dean assignment on this college
            UserRole::where('role_id', $deanRoleId)
                    ->where('entity_type', 'College')
                    ->where('entity_id', $request->college_id)
                    ->where(function ($q) use ($request) {
                        $q->whereNull('end_validity')
                        ->orWhere('end_validity', '>', $request->start_validity);
                    })
                    ->update(['end_validity' => $request->start_validity]);

            // Check if there's a record with null entity_id (unassigned dean)
            $existingUnassignedRole = UserRole::where('user_id', $request->user_id)
                ->where('role_id', $deanRoleId)
                ->where('entity_type', 'College')
                ->whereNull('entity_id')
                ->first();

            if ($existingUnassignedRole) {
                // Update the existing unassigned record
                $existingUnassignedRole->update([
                    'entity_id'      => $request->college_id,
                    'start_validity' => $request->start_validity,
                    'end_validity'   => $request->end_validity,
                ]);
            } else {
                // Otherwise, create a new assignment
                UserRole::create([
                    'user_id'        => $request->user_id,
                    'role_id'        => $deanRoleId,
                    'entity_type'    => 'College',
                    'entity_id'      => $request->college_id,
                    'start_validity' => $request->start_validity,
                    'end_validity'   => $request->end_validity,
                ]);
            }
        });

        // Send email to the assigned Dean
        $user = User::findOrFail($request->user_id);
        $college = College::findOrFail($request->college_id);
        Mail::to($user->email)->send(new DeanAssigned($user, $college, $request->start_validity, $request->end_validity));

        return redirect()->route('admin.college')->with('success', 'Dean assigned successfully and email sent.');
    }
    public function editDean(string $ur_id)
    {
        $users = User::all();
        $colleges = College::all();

        $deanRoleId = Roles::where('role_name', 'dean')->value('role_id');

        $dean = UserRole::where('ur_id', $ur_id)
            ->where('role_id', $deanRoleId)
            ->where('entity_type', 'College')
            ->firstOrFail();

        return view('Admin.Dean.deanEdit', compact('dean', 'users', 'colleges', 'ur_id'));
    }
    public function updateDean(Request $request, string $ur_id)
    {
        $deanRoleId = Roles::where('role_name', 'Dean')->value('role_id');

        $request->validate([
            'user_id' => 'required|string',
            'college_id' => 'required|string',
            'start_validity' => 'required|date',
            'end_validity' => 'nullable|date|after:start_validity',
        ]);

        // ⚠️ 1. Check if the user already holds a dean role in any college
        $userHasDeanRole = UserRole::where('role_id', $deanRoleId)
            ->where('entity_type', 'College')
            ->where('user_id', $request->user_id)
            ->where('ur_id', '!=', $ur_id) 
            ->where(function ($q) use ($request) {
                $q->whereNull('end_validity')
                ->orWhere('end_validity', '>', $request->start_validity);
            })
            ->whereNotNull('entity_id')
            ->exists();

        if ($userHasDeanRole) {
            return back()->with('error', 'This user is already assigned as dean in another college.');
        }
        
        DB::transaction(function () use ($request, $deanRoleId, $ur_id) {
            $dean = UserRole::where('ur_id', $ur_id)
                ->where('role_id', $deanRoleId)
                ->where('entity_type', 'College')
                ->firstOrFail();

            /* ─── Close any overlapping dean assignment for this college_id ─── */
            UserRole::where('role_id',     $deanRoleId)
                ->where('entity_type', 'College')
                ->where('entity_id',   $request->college_id)
                ->where('ur_id', '!=', $ur_id) // don’t overwrite the record we’re updating
                ->where(function ($q) use ($request) {
                    $q->whereNull('end_validity')
                    ->orWhere('end_validity', '>', $request->start_validity);
                })  
                ->update(['end_validity' => $request->start_validity]);

            $dean->update([
                'user_id'        => $request->user_id,
                'entity_id'      => $request->college_id,
                'start_validity' => $request->start_validity,
                'end_validity'   => $request->end_validity,
            ]);
        });

        return redirect()->route('admin.college')->with('success', 'College Information Updated');
    }

    public function destroyDean(string $ur_id)
    {
        $dean = UserRole::where('ur_id', $ur_id)
            ->where('role_id', Roles::where('role_name', 'Dean')->value('role_id'))
            ->where('entity_type', 'College')
            ->firstOrFail();

        $dean->delete();

        return redirect()->route('admin.college')
        ->with('success', 'Dean deleted successfully.');
    }
}