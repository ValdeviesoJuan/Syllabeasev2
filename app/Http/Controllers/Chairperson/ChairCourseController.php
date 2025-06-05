<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\Chairperson;
use App\Models\College;
use App\Models\Course;
use App\Models\Curriculum;
use App\Models\ProgramOutcome;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChairCourseController extends Controller
{
    public function index()
    {
        $department_id = Chairperson::where('chairpeople.user_id', '=', Auth::user()->id)
            ->select('chairpeople.department_id')
            ->first()
            ->department_id;

        $colleges = College::all();
        $courses = Course::join('curricula', 'courses.curr_id', '=', 'curricula.curr_id')
            ->join('departments', 'curricula.department_id', '=', 'departments.department_id')
            ->join('colleges', 'departments.college_id', '=', 'colleges.college_id')
            ->select('colleges.*', 'departments.*', 'colleges.*', 'courses.*', 'curricula.*')
            ->where('departments.department_id', '=', $department_id)
            ->paginate(10);
            $user = Auth::user(); 
            $notifications = $user->notifications;
        return view('Chairperson.Courses.courseList', compact('notifications', 'courses', 'colleges'));
    }
    public function viewCourse($course_id)
    {
        $course = Course::where('course_id', $course_id)->first();
        $department_id = Chairperson::where('chairpeople.user_id', '=', Auth::user()->id)
            ->select('chairpeople.department_id')
            ->first()
            ->department_id;

        $curricula = Curriculum::join('departments', 'departments.department_id', '=', 'curricula.department_id')
            ->where('departments.department_id', '=', $department_id)
            ->get();
            $user = Auth::user(); 
        $notifications = $user->notifications;
        return view('Chairperson.Courses.courseView', [
            'course' => Course::where('course_id', $course_id)->first()
        ], compact('notifications','curricula'));
    }
    public function createCourse()
    {
        $department_id = Chairperson::where('chairpeople.user_id', '=', Auth::user()->id)
            ->select('chairpeople.department_id')
            ->first()
            ->department_id;

        $curricula = Curriculum::join('departments', 'departments.department_id', '=', 'curricula.department_id')
            ->where('departments.department_id', '=', $department_id)
            ->get();
            $user = Auth::user(); 
        $notifications = $user->notifications;
        return view('Chairperson.Courses.courseCreate', compact('notifications','curricula'));
    }
    public function storeCourse(Request $request)
    {
        $request->validate([
            'curr_id' => 'required',
            'course_title' => 'required|string',
            'course_code' => 'required|string',
            'course_unit_lec' => 'required|numeric',
            'course_unit_lab' => 'required|numeric',
            'course_credit_unit' => 'required|numeric',
            'course_hrs_lec' => 'required|numeric',
            'course_hrs_lab' => 'required|numeric',
            'course_pre_req' => 'required|string',
            'course_co_req' => 'required|string',
            'course_year_level' => 'required|string',
            'course_semester' => 'required|string',
        ]);
        Course::create($request->all());
        return redirect()->route('chairperson.course')->with('success', 'Course created successfully.');
    }
    public function editCourse(string $course_id)
    {
        $course = Course::where('course_id', $course_id)->first();
        $department_id = Chairperson::where('chairpeople.user_id', '=', Auth::user()->id)
            ->select('chairpeople.department_id')
            ->first()
            ->department_id;

        $curricula = Curriculum::join('departments', 'departments.department_id', '=', 'curricula.department_id')
            ->where('departments.department_id', '=', $department_id)
            ->get();
            $user = Auth::user(); 
            $notifications = $user->notifications;
        return view('Chairperson.Courses.courseEdit', [
            'course' => Course::where('course_id', $course_id)->first()
        ], compact('notifications','curricula'));
    }
    public function updateCourse(Request $request, string $course_id)
    {
        $course = Course::findorFail($course_id);
        $request->validate([
            'course_title' => 'required|string',
            'course_code' => 'required|string',
            'course_unit_lec' => 'required|numeric',
            'course_unit_lab' => 'required|numeric',
            'course_credit_unit' => 'required|numeric',
            'course_hrs_lec' => 'required|numeric',
            'course_hrs_lab' => 'required|numeric',
            'course_pre_req' => 'required|string',
            'course_co_req' => 'required|string',
            'curr_id' => 'required|string',
            'course_year_level' => 'required|string',
            'course_semester' => 'required|string',
        ]);
        $course->update([
            'course_title' =>  $request->input('course_title'),
            'curr_id' =>  $request->input('curr_id'),
            'course_code' =>  $request->input('course_code'),
            'course_unit_lec' =>  $request->input('course_unit_lec'),
            'course_unit_lab' =>  $request->input('course_unit_lab'),
            'course_credit_unit' =>  $request->input('course_credit_unit'),
            'course_hrs_lec' =>  $request->input('course_hrs_lec'),
            'course_hrs_lab' =>  $request->input('course_hrs_lab'),
            'course_pre_req' =>  $request->input('course_pre_req'),
            'course_pre_req' =>  $request->input('course_pre_req'),
            'course_co_req' =>  $request->input('course_co_req'),
            'course_year_level' =>  $request->input('course_year_level'),
            'course_semester' =>  $request->input('course_semester'),
        ]);
        return redirect()->route('chairperson.course')
            ->with('success', 'Course Information Updated');
    }
    public function destroyCourse(Course $course_id)
    {
        $course_id->delete();
        return redirect()->route('chairperson.course')
            ->with('success', 'Course deleted successfully.');
    }
}
