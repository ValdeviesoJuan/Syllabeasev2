<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Mail\BLeader;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;
use App\Models\UserRole;
use App\Models\BayanihanGroup;
use App\Models\BayanihanLeader;
use App\Models\BayanihanMember;
use App\Models\Course;
use Illuminate\Support\Facades\Mail;
use App\Mail\BTeam;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use App\Mail\BLeaderCreatedMail;
use App\Mail\BMemberCreatedMail;

class ChairController extends Controller
{
    public function index()
    {
        $users = User::all();

        $chair = UserRole::where('user_id', Auth::id())
            ->where('entity_type', '=', 'Department')
            ->where('role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
            ->firstOrFail();

        $department_id = $chair->entity_id;

        $bgroups = BayanihanGroup::with('BayanihanLeaders', 'BayanihanMembers')
        ->join('courses', 'bayanihan_groups.course_id', '=', 'courses.course_id')
        ->select('courses.*', 'bayanihan_groups.*')
        ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
        ->where('curricula.department_id', '=', $department_id)
        ->get();

        $bmembers = BayanihanMember::join('users', 'bayanihan_members.bm_user_id', '=', 'users.id')
        ->select('users.*', 'bayanihan_members.*')
        ->get()
        ->groupBy('bg_id');

        $bleaders = BayanihanLeader::join('users', 'bayanihan_leaders.bg_user_id', '=', 'users.id')
        ->select('users.*', 'bayanihan_leaders.*')
        ->get()
        ->groupBy('bg_id');

        $user = Auth::user(); 
        
        $notifications = $user->notifications;


        return view('Chairperson.Home.home', compact('users', 'bgroups', 'bmembers', 'bleaders', 'notifications'));
    }
    public function bayanihan()
    {
        $users = User::all();
        
        $chair = UserRole::where('user_id', Auth::id())
            ->where('entity_type', '=', 'Department')
            ->where('role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
            ->firstOrFail();

        $department_id = $chair->entity_id;

        $bgroups = BayanihanGroup::with('BayanihanLeaders', 'BayanihanMembers')
        ->join('courses', 'bayanihan_groups.course_id', '=', 'courses.course_id')
        ->select('courses.*', 'bayanihan_groups.*')
        ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
        ->where('curricula.department_id', '=', $department_id)
        ->get();

        $bmembers = BayanihanMember::join('users', 'bayanihan_members.bm_user_id', '=', 'users.id')
        ->select('users.*', 'bayanihan_members.*')
        ->get()
        ->groupBy('bg_id');
        
        $bleaders = BayanihanLeader::join('users', 'bayanihan_leaders.bg_user_id', '=', 'users.id')
        ->select('users.*', 'bayanihan_leaders.*')
        ->get()
        ->groupBy('bg_id');

        $user = Auth::user(); 
        $notifications = $user->notifications;

        return view('Chairperson.Bayanihan.btList', compact('notifications','users', 'bgroups', 'bmembers', 'bleaders'));
    }
    public function createBTeam()
    {
        try {
            // Retrieve the department ID for the logged-in chairperson user
            $chair = UserRole::where('user_id', Auth::id())
                ->where('entity_type', '=', 'Department')
                ->where('role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
                ->firstOrFail();

            $department_id = $chair->entity_id;

            // Retrieve users and courses based on the department ID
            $courses = Course::join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
                ->where('curricula.department_id', $department_id)
                ->get();
            
            $users = User::all();
            $user = Auth::user(); 
            $notifications = $user->notifications;

            // Return the view with the necessary data
            return view('Chairperson.Bayanihan.btCreate', compact('notifications','users', 'courses'));
        } catch (\Exception $e) {
            // Handle exceptions (e.g., user not found, department not found)
            return redirect()->back()->with('error', 'Error occurred: ' . $e->getMessage());
        }
    }
    public function storeBTeam(Request $request)
    {
        $request->validate([
            'bg_school_year' => 'required',
            'course_id' => 'required',
        ]);

        $chairperson = UserRole::where('user_id', Auth::id())
            ->where('entity_type', '=', 'Department')
            ->where('role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
            ->firstOrFail();

        $department_id = $chairperson->entity_id;

        // Check if the course belongs to the department through curricula
        $course = Course::join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
            ->where('courses.course_id', $request->input('course_id'))
            ->where('curricula.department_id', $department_id)
            ->first();

        if (!$course) {
            return redirect()->back()->with('error', 'This course does not belong to your department.');
        }

        // Check if a BayanihanGroup already exists for the course and bg.school_year
        $exists = BayanihanGroup::join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
            ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
            ->where('bayanihan_groups.course_id', $request->input('course_id'))
            ->where('bayanihan_groups.bg_school_year', $request->input('bg_school_year'))
            ->where('curricula.department_id', $department_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'A Bayanihan Team already exists for this course and school year.');
        }

        $bGroup = new BayanihanGroup();
        $bGroup->bg_school_year = $request->input('bg_school_year');
        $bGroup->course_id = $request->input('course_id');
        $bGroup->save();

        $department = Department::join('user_roles', 'user_roles.entity_id', '=', 'departments.department_id')
            ->where('user_roles.entity_type', '=', 'Department')
            ->where('user_roles.role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
            ->where('user_roles.user_id', '=', Auth::id())
            ->select('departments.*')
            ->first();

        $leaders = $request->input('bl_user_id');
        foreach ($leaders as $leader) {
            $bLeader = new BayanihanLeader();
            $bLeader->bg_id = $bGroup->bg_id;
            $bLeader->bg_user_id = $leader;
            $bLeader->save();
            
            $user = User::find($bLeader->bg_user_id);      
            if ($user) {
                Mail::to($user->email)->send(new BLeaderCreatedMail($user, $chairperson, $department, $bGroup));
            }
            UserRole::firstOrCreate([
                'role_id' => 4,
                'user_id' => $leader,
            ]);
        }
        
        $members = $request->input('bm_user_id');
        foreach ($members as $member) {
            $bMember = new BayanihanMember();
            $bMember->bg_id = $bGroup->bg_id;
            $bMember->bm_user_id = $member;
            $bMember->save();

            $user = User::find($bMember->bm_user_id);            
            if ($user) {
                Mail::to($user->email)->send(new BMemberCreatedMail($user, $chairperson, $department, $bGroup));
            }

            UserRole::firstOrCreate([
                'role_id' => 5,
                'user_id' => $member,
            ]);
        }

        return redirect()->route('chairperson.bayanihan')->with('success', 'Bayanihan Team created successfully.');
    }
    public function editBTeam($bg_id)
    {
        $bGroup = BayanihanGroup::find($bg_id);
        $users = User::all();
        $courses = Course::all();
        $user = Auth::user(); 
        $notifications = $user->notifications;
        return view('Chairperson.Bayanihan.btEdit', compact('notifications','bGroup', 'users', 'courses'));
    }
    public function updateBTeam(Request $request, string $bg_id)
    {
        $bGroup = BayanihanGroup::findorfail($bg_id);

        $request->validate([
            'bg_school_year' => 'required',
            'course_id' => 'required',
        ]);

        $chair = UserRole::where('user_id', Auth::id())
            ->where('entity_type', '=', 'Department')
            ->where('role_id', '=', Roles::where('role_name', 'Chairperson')->value('role_id'))
            ->firstOrFail();

        $department_id = $chair->entity_id;

        $course = Course::join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
            ->where('courses.course_id', $request->input('course_id'))
            ->where('curricula.department_id', $department_id)
            ->first();

        if (!$course) {
            return redirect()->back()->with('error', 'This course does not belong to your department.');
        }

        $exists = BayanihanGroup::join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
            ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
            ->where('bayanihan_groups.course_id', $request->input('course_id'))
            ->where('bayanihan_groups.bg_school_year', $request->input('bg_school_year'))
            ->where('curricula.department_id', $department_id)
            ->where('bayanihan_groups.bg_id', '!=', $bg_id)
            ->exists();
        
        if ($exists) {
            return redirect()->back()->with('error', 'Another Bayanihan Team already exists for this course and school year.');
        }
        
        $bGroup->bg_school_year = $request->input('bg_school_year');
        $bGroup->course_id = $request->input('course_id');
        $bGroup->save();

        $leaders = $request->input('bl_user_id');

        BayanihanLeader::where('bg_id', $bg_id)->delete();
        foreach ($leaders as $leader) {
            $bLeader = new BayanihanLeader();
            $bLeader->bg_id = $bGroup->bg_id;
            $bLeader->bg_user_id = $leader;
            $bLeader->save();

            UserRole::firstOrCreate([
                'role_id' => 4,
                'user_id' => $leader,
            ]);
        }

        $members = $request->input('bm_user_id');
        BayanihanMember::where('bg_id', $bg_id)->delete();
        foreach ($members as $member) {
            $bMember = new BayanihanMember();
            $bMember->bg_id = $bGroup->bg_id;
            $bMember->bm_user_id = $member;
            $bMember->save();

            UserRole::firstOrCreate([
                'role_id' => 5,
                'user_id' => $member,
            ]);
        }

        return redirect()->route('chairperson.bayanihan')->with('success', 'Bayanihan Team updated successfully.');
    }
    public function destroyBTeam($bg_id)
    {
        $bGroup = BayanihanGroup::findorfail($bg_id);
        BayanihanLeader::where('bg_id', $bg_id)->delete();
        BayanihanMember::where('bg_id', $bg_id)->delete();
        $bGroup->delete();

        return redirect()->route('chairperson.bayanihan')->with('success', 'Bayanihan Team deleted successfully.');
    }
    public function mail(){
        return view('mails.BtMail');
    }
}
