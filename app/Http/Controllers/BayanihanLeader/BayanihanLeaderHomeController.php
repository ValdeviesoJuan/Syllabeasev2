<?php

namespace App\Http\Controllers\BayanihanLeader;

use App\Http\Controllers\Controller;
use App\Models\BayanihanGroup;
use App\Models\BayanihanGroupUsers; 
use App\Models\Syllabus;
use App\Models\College;
use App\Models\SyllabusInstructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BayanihanLeaderHomeController extends Controller
{
    public function index()
    {
        $myDepartment = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
            ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
            ->join('departments', 'departments.department_id', '=', 'curricula.department_id')
            ->where('bayanihan_group_users.user_id', '=', Auth::id())
            ->where('bayanihan_group_users.bg_role', '=', 'leader')
            ->select('departments.department_id')
            ->first();

                // $syllabi = Syllabus::join('syllabus_instructors', 'syllabi.syll_id', '=', 'syllabus_instructors.syll_id')
        //     ->select('syllabus_instructors.*', 'syllabi.*')
        //     ->get();

        // $mySyllabus = BayanihanGroup::join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
        //     ->join('bayanihan_group_users', 'bayanihan_group_users.bg_id', '=', 'bayanihan_groups.bg_id')
        //     ->where('bayanihan_group_users.user_id', '=', Auth::user()->id)
        //     ->where('bayanihan_group_users.bg_role', '=', 'leader')
        //     ->where('syllabi.department_id', '=', $myDepartment->department_id)
        //     ->leftJoin('courses', 'courses.course_id', '=',  'bayanihan_groups.course_id')
        //     ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*')
        //     ->distinct()
        //     ->get();

        if ($myDepartment) {
            $syllabus = BayanihanGroup::join('syllabi', function ($join) {
                $join->on('syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
                    ->whereRaw('syllabi.version = (SELECT MAX(version) FROM syllabi WHERE bg_id = bayanihan_groups.bg_id)');
            })
                ->join('bayanihan_group_users', 'bayanihan_group_users.bg_id', '=', 'bayanihan_groups.bg_id')
                ->where('bayanihan_group_users.user_id', '=', Auth::user()->id)
                ->where('bayanihan_group_users.bg_role', '=', 'leader')
                ->where('syllabi.department_id', '=', $myDepartment->department_id)
                ->leftJoin('courses', 'courses.course_id', '=',  'bayanihan_groups.course_id')
                ->leftJoin('deadlines', function ($join) {
                    $join->on('deadlines.dl_semester', '=', 'courses.course_semester')
                        ->on('deadlines.dl_school_year', '=', 'bayanihan_groups.bg_school_year')
                        ->on('deadlines.college_id', '=', 'syllabi.college_id');
                })
                ->select('syllabi.*', 'bayanihan_groups.*', 'courses.*', 'deadlines.*')
                ->get();

            $syllabiCount = $syllabus->count();
            $completedCount = $syllabus->filter(function ($item) {
                return $item->status === 'Approved by Dean';
            })->count();
            $pendingCount = $syllabus->filter(function ($item) {
                return $item->status === 'Pending Chair Review';
            })->count();
        } else {
            $syllabus = [];
            $syllabiCount = 0;
            $completedCount = 0;
            $pendingCount = 0;
        }

        $user = Auth::user(); 
        $notifications = $user->notifications;
        $missingSignature = is_null($user->signature); // ✅ Add this

        return view('BayanihanLeader.blHome', compact(
            'notifications',
            'syllabus',
            'syllabiCount',
            'completedCount',
            'pendingCount',
            'missingSignature' // ✅ Pass to view
        ));
    }
}
