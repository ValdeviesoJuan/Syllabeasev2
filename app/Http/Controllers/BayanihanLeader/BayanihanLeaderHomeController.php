<?php

namespace App\Http\Controllers\BayanihanLeader;

use App\Http\Controllers\Controller;
use App\Models\BayanihanGroup;
use App\Models\BayanihanLeader;
use App\Models\Syllabus;
use App\Models\College;
use App\Models\SyllabusInstructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class BayanihanLeaderHomeController extends Controller
{
    public function index()
    {

        $myDepartment = BayanihanLeader::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_leaders.bg_id')
            ->join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
            ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
            ->join('departments', 'departments.department_id', '=', 'curricula.department_id')
            ->where('bayanihan_leaders.bg_user_id', '=', Auth::user()->id)
            ->select('departments.department_id')
            ->first();

        $syllabi = Syllabus::join('syllabus_instructors', 'syllabi.syll_id', '=', 'syllabus_instructors.syll_id')
            ->select('syllabus_instructors.*', 'syllabi.*')
            ->get();

        // $syllabus = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
        //     ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
        //     ->where('bayanihan_leaders.bg_user_id', '=', Auth::user()->id)
        //     ->leftJoin('courses', 'courses.course_id', '=',  'bayanihan_groups.course_id')
        //     ->where('syllabi.department_id', '=', $myDepartment->department_id)
        //     ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
        //     ->get();
        $mySyllabus = BayanihanGroup::join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
            ->where('bayanihan_leaders.bg_user_id', '=', Auth::user()->id)
            ->where('syllabi.department_id', '=', $myDepartment->department_id)
            ->leftJoin('courses', 'courses.course_id', '=',  'bayanihan_groups.course_id')
            ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
            ->distinct()
            ->get();
        if ($myDepartment) {
            // $syllabus = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            //     ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
            //     ->where('bayanihan_leaders.bg_user_id', '=', Auth::user()->id)
            //     ->leftJoin('courses', 'courses.course_id', '=',  'bayanihan_groups.course_id')
            //     ->where('syllabi.department_id', '=', $myDepartment->department_id)
            //     ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
            //     ->get();
            $syllabus = BayanihanGroup::join('syllabi', function ($join) {
                $join->on('syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
                    ->whereRaw('syllabi.version = (SELECT MAX(version) FROM syllabi WHERE bg_id = bayanihan_groups.bg_id)');
            })
                ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
                ->where('bayanihan_leaders.bg_user_id', '=', Auth::user()->id)
                ->where('syllabi.department_id', '=', $myDepartment->department_id)
                ->leftJoin('courses', 'courses.course_id', '=',  'bayanihan_groups.course_id')
                ->leftJoin('deadlines', function ($join) {
                    $join->on('deadlines.dl_semester', '=', 'courses.course_semester')
                        ->on('deadlines.dl_school_year', '=', 'bayanihan_groups.bg_school_year')
                        ->on('deadlines.college_id', '=', 'syllabi.college_id');
                })
                ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*', 'deadlines.*')
                ->get();
        } else {
            $syllabus = [];
        }
        $syllabiCount = $syllabus->count();
        $completedCount = $syllabus->filter(function ($item) {
            return $item->status === 'Approved by Dean';
        })->count();
        $pendingCount = $syllabus->filter(function ($item) {
            return $item->status === 'Pending';
        })->count();
        
        // $syll = College::join('departments', 'departments.college_id', '=', 'colleges.college_id')
        //     ->join('curricula', 'departments.department_id', '=', 'curricula.department_id')
        //     ->join('courses', 'courses.curr_id', '=', 'curricula.curr_id')
        //     ->join('bayanihan_groups', 'bayanihan_groups.course_id', '=', 'courses.course_id')
        //     ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
        //     ->join('bayanihan_members', 'bayanihan_members.bg_id', '=', 'bayanihan_groups.bg_id')
        //     ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
        //     ->join('syllabus_instructors', 'syllabi.syll_id', '=', 'syllabus_instructors.syll_id')
        //     ->select('courses.*', 'bayanihan_groups.*', 'syllabi.*')
        //     ->get();

        $instructors = SyllabusInstructor::join('users', 'syllabus_instructors.syll_ins_user_id', '=', 'users.id')
            ->select('users.*', 'syllabus_instructors.*')
            ->get()
            ->groupBy('syll_id');
            
        $user = Auth::user(); 
        $notifications = $user->notifications;
        return view('BayanihanLeader.blHome', compact('notifications','syllabi', 'instructors', 'syllabus', 'syllabiCount', 'completedCount', 'pendingCount'));
    }
}
