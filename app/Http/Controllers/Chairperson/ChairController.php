<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Mail\BLeader;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BayanihanGroup;
use App\Models\BayanihanLeader;
use App\Models\BayanihanMember;
use App\Models\Chairperson;
use App\Models\Course;
use Illuminate\Support\Facades\Mail;
use App\Mail\BTeam;
use App\Models\Department;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;


class ChairController extends Controller
{
    public function index()
    {
        $chairperson = Chairperson::where('user_id', Auth::user()->id)->firstOrFail();
        $department_id = $chairperson->department_id;

        $users = User::all();
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
        $chairperson = Chairperson::where('user_id', Auth::user()->id)->firstOrFail();
        $department_id = $chairperson->department_id;

        $users = User::all();
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
        // Retrieve the department ID for the logged-in user
        $chairperson = Chairperson::where('user_id', Auth::user()->id)->firstOrFail();
        $department_id = $chairperson->department_id;

        // Retrieve users and courses based on the department ID
        $users = User::all();
        $user = Auth::user(); 
        $notifications = $user->notifications;
        $courses = Course::join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
            ->where('curricula.department_id', $department_id)
            ->get();

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
        $bGroup = new BayanihanGroup();
        $bGroup->bg_school_year = $request->input('bg_school_year');
        $bGroup->course_id = $request->input('course_id');
        $bGroup->save();

        $chairperson = User::findOrFail(Auth::user()->id);

        $department = Department::join('chairpeople', 'chairpeople.department_id', '=', 'departments.department_id')
        ->where('chairpeople.user_id', '=', Auth::user()->id)
        ->select('departments.*')
        ->first();

        $leaders = $request->input('bl_user_id');
        foreach ($leaders as $leader) {
            $bLeader = new BayanihanLeader();
            $bLeader->bg_id = $bGroup->bg_id;
            $bLeader->bg_user_id = $leader;
            $bLeader->save();
            $user = User::find($bLeader->bg_user_id);            
            // if ($user) {
            //     Mail::to($user->email)->send(new BLeader($user, $chairperson, $department, $bGroup));
            // }
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
            // if ($user) {
            //     Mail::to($user->email)->send(new bTeam($user, $chairperson, $department, $bGroup));
            // }

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
