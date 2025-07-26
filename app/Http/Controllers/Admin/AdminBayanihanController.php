<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;
use App\Models\UserRole;
use App\Models\BayanihanGroup; 
use App\Models\BayanihanGroupUsers;
use App\Models\Syllabus; 
use App\Models\Course;
use App\Models\Department;
use Illuminate\Support\Facades\Mail;
use App\Mail\BLeader;
use App\Mail\BTeam;
use App\Mail\BLeaderCreatedMail;
use App\Mail\BMemberCreatedMail;

class AdminBayanihanController extends Controller
{
    public function index()
    {
        $users = User::all();

        $bgroups = BayanihanGroup::with('members', 'leaders')
            ->join('courses', 'bayanihan_groups.course_id', '=', 'courses.course_id')
            ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
            ->select('courses.*', 'bayanihan_groups.*', 'curricula.*')
            ->get();

        $bmembers = BayanihanGroupUsers::join('users', 'bayanihan_group_users.user_id', '=', 'users.id')
            ->select('users.*', 'bayanihan_group_users.*')
            ->where('bayanihan_group_users.bg_role', '=', 'member')
            ->get()
            ->groupBy('bg_id');
        $bleaders = BayanihanGroupUsers::join('users', 'bayanihan_group_users.user_id', '=', 'users.id')
            ->select('users.*', 'bayanihan_group_users.*')
            ->where('bayanihan_group_users.bg_role', '=', 'leader')
            ->get()
            ->groupBy('bg_id');

        return view('admin.bayanihan.btList', compact('users', 'bgroups', 'bmembers', 'bleaders'));
    }
    public function createBTeam()
    {
        try {
            // Retrieve users and courses based on the department ID
            $courses = Course::join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
                ->get();
            
            $users = User::all();

            return view('admin.Bayanihan.btCreate', compact('users', 'courses'));
            
        } catch (\Exception $e) {
            // Handle exceptions (e.g., user not found, department not found)
            return redirect()->back()->with('error', 'Error occurred: ' . $e->getMessage());
        }
    }
    public function storeBTeam(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'bg_school_year' => 'required|string',
            'course_id' => 'required|exists:courses,course_id',
            'bg_semester' => 'nullable|string',
        ]); 

        // Check for duplicate Bayanihan Group
        $exists = BayanihanGroup::where('course_id', $request->input('course_id'))
            ->where('bg_school_year', $request->input('bg_school_year'))
            // ->where('bg_semester', $request->input('bg_semester')) // Optional
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'A Bayanihan Team already exists for this course and school year.');
        }

        try {
            DB::transaction(function () use ($request, $admin) {
                // Create the group
                $bGroup = BayanihanGroup::create([
                    'course_id' => $request->input('course_id'),
                    'bg_school_year' => $request->input('bg_school_year'),
                    // 'bg_semester' => $request->input('bg_semester'),
                ]);

                // Get department info
                $department = Department::join('curricula', 'curricula.department_id', '=', 'departments.department_id')
                    ->join('courses', 'courses.curr_id', '=', 'curricula.curr_id')
                    ->where('courses.course_id', $request->input('course_id'))
                    ->select('departments.*')
                    ->first();

                // Save leaders
                $leaders = $request->input('bl_user_id', []);
                foreach ($leaders as $leader) {
                    BayanihanGroupUsers::create([
                        'bg_id' => $bGroup->bg_id,
                        'user_id' => $leader,
                        'bg_role' => 'leader',
                    ]);

                    $user = User::find($leader);
                    if ($user) {
                        Mail::to($user->email)->send(new BLeaderCreatedMail($user, $admin, $department, $bGroup));
                    }

                    UserRole::firstOrCreate([
                        'role_id' => 4,
                        'user_id' => $leader,
                    ]);
                }

                // Save members
                $members = $request->input('bm_user_id', []);
                foreach ($members as $member) {
                    BayanihanGroupUsers::create([
                        'bg_id' => $bGroup->bg_id,
                        'user_id' => $member,
                        'bg_role' => 'member', 
                    ]);

                    $user = User::find($member);
                    if ($user) {
                        Mail::to($user->email)->send(new BMemberCreatedMail($user, $admin, $department, $bGroup));
                    }

                    UserRole::firstOrCreate([
                        'role_id' => 5,
                        'user_id' => $member,
                    ]);
                }
            });

            return redirect()->route('admin.bayanihan')->with('success', 'Bayanihan Team created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create Bayanihan Team: ' . $e->getMessage());
        }
    }
    public function editBTeam($bg_id)
    {
        $bGroup = BayanihanGroup::find($bg_id);
        $users = User::all();
        $courses = Course::all();

        return view('admin.Bayanihan.btEdit', compact('bGroup', 'users', 'courses'));
    }
    public function updateBTeam(Request $request, string $bg_id)
    {
        $request->validate([
            'bg_school_year' => 'required|string',
            'course_id' => 'required|exists:courses,course_id',
            'bg_semester' => 'nullable|string',
        ]);

        //Check for Duplicate Bayanihan Teams, except the one currently editing
        $exists = BayanihanGroup::where('bayanihan_groups.course_id', $request->input('course_id'))
            ->where('bayanihan_groups.bg_school_year', $request->input('bg_school_year'))
            // ->where('bayanihan_groups.bg_semester', $request->input('bg_semester'))
            ->where('bayanihan_groups.bg_id', '!=', $bg_id)
            ->exists();
        
        if ($exists) {
            return redirect()->back()->with('error', 'Another Bayanihan Team already exists for this course and school year.');
        }
        
        try {
            DB::transaction(function () use ($request, $bg_id) {
                $bGroup = BayanihanGroup::findOrFail($bg_id);
                $bGroup->bg_school_year = $request->input('bg_school_year');
                $bGroup->course_id = $request->input('course_id');
                $bGroup->save();

                // Remove old assignments
                BayanihanGroupUsers::where('bg_id', $bg_id)->delete();

                // Add new leaders
                $leaders = $request->input('bl_user_id', []);
                foreach ($leaders as $leader) {
                    BayanihanGroupUsers::create([
                        'bg_id' => $bGroup->bg_id,
                        'user_id' => $leader,
                        'bg_role' => 'leader',
                    ]);

                    UserRole::firstOrCreate([
                        'role_id' => 4,
                        'user_id' => $leader,
                    ]);
                }

                // Add new members
                $members = $request->input('bm_user_id', []);
                foreach ($members as $member) {
                    BayanihanGroupUsers::create([
                        'bg_id' => $bGroup->bg_id,
                        'user_id' => $member,
                        'bg_role' => 'member',
                    ]);

                    UserRole::firstOrCreate([
                        'role_id' => 5,
                        'user_id' => $member,
                    ]);
                }
            });

            return redirect()->route('admin.bayanihan')->with('success', 'Bayanihan Team updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update team: ' . $e->getMessage());
        }
    }
    public function destroyBTeam($bg_id)
    {
        $hasApprovedSyllabusDocument = Syllabus::where('bg_id', $bg_id)
            ->where('status', 'Approved by Dean')
            ->whereNotNull('dean_approved_at')
            ->exists();

        if ($hasApprovedSyllabusDocument) {
            return redirect()->route('admin.bayanihan')
                ->with('error', 'Cannot delete this Bayanihan Team because it already has an approved syllabus.');
        }

        $bGroup = BayanihanGroup::findorfail($bg_id);
        $bGroup->delete();

        BayanihanGroupUsers::where('bg_id', $bg_id)->delete();

        return redirect()->route('admin.bayanihan')->with('success', 'Bayanihan Team deleted successfully.');
    }
}
