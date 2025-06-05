<?php

namespace App\Livewire;

use App\Models\Chairperson;
use App\Models\College;
use App\Models\Course;
use App\Models\Curriculum;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ChairCourses extends Component
{
    use WithPagination;
    public $search = '';
    public $filters = [
        'course_year_level' => null,
        'course_semester' => null,
        'curr_code' => null,
    ];
    public function render()
    {
        $department_id = Chairperson::where('chairpeople.user_id', '=', Auth::user()->id)
            ->select('chairpeople.department_id')
            ->first()
            ->department_id;

        $colleges = College::all();
        $curricula = Curriculum::where('department_id', $department_id)->get();
        $courses = Course::join('curricula', 'courses.curr_id', '=', 'curricula.curr_id')
            ->join('departments', 'curricula.department_id', '=', 'departments.department_id')
            ->join('colleges', 'departments.college_id', '=', 'colleges.college_id')
            ->select('colleges.*', 'departments.*', 'colleges.*', 'courses.*', 'curricula.*')
            ->where('departments.department_id', '=', $department_id)
            ->where(function ($query) {
                $query->where('courses.course_code', 'like', '%' . $this->search . '%')
                    ->orWhere('courses.course_semester', 'like', '%' . $this->search . '%')
                    ->orWhere('courses.course_title', 'like', '%' . $this->search . '%')
                    ->orWhere('courses.course_year_level', 'like', '%' . $this->search . '%')
                    ->orWhere('curricula.curr_code', 'like', '%' . $this->search . '%');
            })
            ->when($this->filters['course_year_level'], function ($query) {
                $query->where('courses.course_year_level', 'like', '%' . $this->filters['course_year_level']);
            })
            ->when($this->filters['course_semester'], function ($query) {
                $query->where('courses.course_semester', 'like', '%' . $this->filters['course_semester']);
            })
            ->when($this->filters['curr_code'], function ($query) {
                $query->where('curricula.curr_code', 'like', '%' . $this->filters['curr_code']);
            })
            ->select('courses.*', 'curricula.*')
            ->paginate(10);

        return view('livewire.chair-courses', ['courses' => $courses, 'curricula' => $curricula]);
    }
    public function applyFilters()
    {
        $this->resetPage();
    }
}
