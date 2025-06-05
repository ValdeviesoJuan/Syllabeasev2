<?php

namespace App\Livewire;

use App\Models\SrfChecklist;
use App\Models\Syllabus;
use App\Models\SyllabusCoPo;
use App\Models\SyllabusCotCoF;
use App\Models\SyllabusCotCoM;
use App\Models\SyllabusCourseOutcome;
use App\Models\SyllabusCourseOutlineMidterm;
use App\Models\SyllabusCourseOutlinesFinal;
use App\Models\SyllabusInstructor;
use App\Models\SyllabusReviewForm;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChairReviewForm extends Component
{
    public $isOpen = false;
    public $syll_id;
    public $checkboxes = [];

    public $srf_id;
    public $srf_course_code;
    public $srf_title;
    public $srf_sem_year;
    public $srf_faculty;
    public $user_id;
    public $srf_date;
    public $srf_reviewed_by;
    public $srf_action;

    public $srf_no = [];
    public $srf_yes_no = [];
    public $srf_remarks = [];

    public function openComments()
    {
        $this->isOpen = true;
    }
    public function closeComments()
    {
        $this->isOpen = false;
    }
    public function returnSyllabus()
    {
        $syll = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            ->join('colleges', 'colleges.college_id', '=', 'syllabi.college_id')
            ->join('departments', 'departments.department_id', '=', 'syllabi.department_id') // Corrected
            ->join('curricula', 'curricula.curr_id', '=', 'syllabi.curr_id')
            ->join('courses', 'courses.course_id', '=', 'syllabi.course_id')
            ->where('syllabi.syll_id', '=', $this->syll_id)
            ->select('courses.*', 'bayanihan_groups.*', 'syllabi.*', 'departments.*', 'curricula.*', 'colleges.college_description', 'colleges.college_code')
            ->first();

            // Create Review Form 
            $srf = new SyllabusReviewForm();
            $srf->syll_id = $this->syll_id;
            $srf->srf_course_code = $syll->course_code;
            $srf->srf_title = $syll->course_title;
            $srf->srf_sem_year = $syll->course_year_level  . ' ' . $syll->course_semester;

            $srf->user_id = Auth::id();
            $srf->srf_date = now()->toDateString();
            $srf->srf_reviewed_by = Auth::user()->prefix . ' ' . Auth::user()->firstname . ' ' . Auth::user()->lastname . ' ' . Auth::user()->suffix;
            $srf->srf_action = 0;

            $instructors = SyllabusInstructor::join('users', 'syllabus_instructors.syll_ins_user_id', '=', 'users.id')
                ->select('users.*', 'syllabus_instructors.*')
                ->get()
                ->groupBy('syll_id');
            $srf->srf_faculty = '';

            if ($instructors->has($srf->syll_id)) {
                $facultyNames = $instructors[$srf->syll_id]->map(function ($instructor) {
                    return $instructor->firstname . ' ' . $instructor->lastname;
                })->toArray();
            
                $srf->srf_faculty = implode(', ', $facultyNames);
            }
            $srf->save();

            // Create checklist rows here 
            foreach ($this->srf_no as $index => $srf_no) {
                $srf_checklist = new SrfChecklist();
                $srf_checklist->srf_no = $this->srf_no[$index];
                $srf_checklist->srf_id = $srf->srf_id;
                $srf_checklist->srf_remarks = $this->srf_remarks[$index] ?? null;
                $srf_checklist->srf_yes_no = $this->srf_yes_no[$index] ?? false; 
                $srf_checklist->save();
            }
    }
    public function allCheckboxesChecked()
    {
        return count(array_filter($this->checkboxes)) === count($this->checkboxes);
    }
    public function render()
    {
        return view('livewire.chair-review-form');
    }
}
