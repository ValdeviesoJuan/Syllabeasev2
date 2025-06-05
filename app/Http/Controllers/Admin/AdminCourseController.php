<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\College;
use App\Models\Dean;
use App\Models\Course;
use App\Models\User;
use App\Models\Curriculum;

use Illuminate\Http\Request;

class AdminCourseController extends Controller
{
    public function index()
    {
        $colleges = College::all();
        $courses = Course::join('curricula', 'courses.curr_id', '=', 'curricula.curr_id')
            ->join('departments', 'curricula.department_id', '=', 'departments.department_id')
            ->join('colleges', 'departments.college_id', '=', 'colleges.college_id')
            ->select('colleges.*', 'departments.*', 'colleges.*', 'courses.*', 'curricula.*')
            ->paginate(10);
        return view('Admin.Course.courseList', compact('courses', 'colleges'));
    }
    public function createCourse()
    {
        $curricula = Curriculum::all();
        return view('Admin.Course.courseCreate', compact('curricula'));
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
        return redirect()->route('admin.course')->with('success', 'Course created successfully.');
    }
    public function editCourse(string $course_id)
    {
        $course = Course::where('course_id', $course_id)->first();
        $curricula = Curriculum::all();
        return view('Admin.Course.courseEdit', [
            'course' => Course::where('course_id', $course_id)->first()
        ], compact('curricula'));
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
        return redirect()->route('admin.course')
            ->with('success', 'Course Information Updated');
    }
    public function destroyCourse(Course $course_id)
    {
        $course_id->delete();
        return redirect()->route('admin.course')
            ->with('success', 'Course deleted successfully.');
    }
}
