    <form action="{{ route('bayanihanleader.createCo', $syll_id) }}" method="GET">
        @csrf
        <button type="submit" class="btn btn-primary">Create Course Outcome</button>
    </form>
    <form action="{{ route('bayanihanleader.createCoPo', $syll_id) }}" method="GET">
        @csrf
        <button type="submit" class="btn btn-primary">Create Course Outcome</button>
    </form>

    <h1>Syllabus</h1>
    <br>
    <h1>{{ $syllabus->syll_class_schedule }}</h1>
    <h4>Bayanihan Members:</h4>
    @foreach ($instructors[$syllabus->syll_id] ?? [] as $instructor)
    <p>{{ $instructor->lastname }}, {{ $instructor->firstname }}</p>
    @endforeach


    <form action="{{ route('chairperson.editBTeam', $instructor->syll_id) }}" method="GET">
        @csrf
        <button type="submit" class="btn btn-primary">Edit</button>
    </form>

    <form action="{{ route('chairperson.destroyBTeam',$instructor->syll_id) }}" method="Post">
        @csrf
        @method('DELETE')
        <button class="delete_btn" type="submit" class="">Delete</button>
    </form> 

    <?php

namespace App\Http\Controllers\BayanihanLeader;
use App\Http\Controllers\Controller;
use App\Models\BayanihanGroup;
use App\Models\User;
use App\Models\Syllabus;
use App\Models\College;
use App\Models\ProgramOutcome;
use App\Models\SyllabusCoPo;
use App\Models\SyllabusCourseOutcome;
use App\Models\SyllabusInstructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class BayanihanLeaderSyllabusController extends Controller
{
    public function index()
    {
        $syllabi = Syllabus::join('syllabus_instructors', 'syllabi.syll_id', '=', 'syllabus_instructors.syll_id')
        ->select('syllabus_instructors.*', 'syllabi.*')
        ->get();

        $syll = College::join('departments', 'departments.college_id', '=', 'colleges.college_id')
        ->join('curricula', 'departments.department_id' , '=', 'curricula.department_id')
        ->join('courses', 'courses.curr_id', '=', 'curricula.curr_id')
        ->join('bayanihan_groups', 'bayanihan_groups.course_id', '=', 'courses.course_id')
        ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
        ->join('bayanihan_members', 'bayanihan_members.bg_id', '=', 'bayanihan_groups.bg_id')
        ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
        ->join('syllabus_instructors', 'syllabi.syll_id', '=', 'syllabus_instructors.syll_id')
        ->select('courses.*', 'bayanihan_groups.*', 'syllabi.*')
        ->get();

        $instructors = SyllabusInstructor::join('users', 'syllabus_instructors.syll_ins_user_id', '=', 'users.id')
        ->select('users.*', 'syllabus_instructors.*')
        ->get()
        ->groupBy('syll_id');
        return view('bayanihanleader.syllabus.syllList', compact('syllabi', 'instructors', 'syll'));
    }

    public function viewSyllabus($syll_id){
        $syllabus = College::join('departments', 'departments.college_id', '=', 'colleges.college_id')
        ->join('curricula', 'departments.department_id' , '=', 'curricula.department_id')
        ->join('courses', 'courses.curr_id', '=', 'curricula.curr_id')
        ->join('bayanihan_groups', 'bayanihan_groups.course_id', '=', 'courses.course_id')
        ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
        ->join('bayanihan_members', 'bayanihan_members.bg_id', '=', 'bayanihan_groups.bg_id')
        ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
        ->join('syllabus_instructors', 'syllabi.syll_id', '=', 'syllabus_instructors.syll_id')
        ->where('syllabi.syll_id', '=', $syll_id)
        ->select('courses.*', 'bayanihan_groups.*', 'syllabi.*', 'departments.*', 'curricula.*', 'syllabus_instructors.*', 'colleges.college_description')
        ->get();

        $programOutcomes = Syllabus::where('syllabi.syll_id', '=', $syll_id)
            ->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            ->join('bayanihan_leaders', 'bayanihan_leaders.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
            ->join('curricula', 'curricula.curr_id', '=', 'courses.curr_id')
            ->join('program_outcomes', 'program_outcomes.department_id', '=', 'curricula.department_id')
            // ->join('syll_co_pos', 'syll_co_pos.syll_po_id', '=', 'program_outcomes.po_id')
            // ->join('syllabus_course_outcomes', 'syllabus_course_outcomes.syll_co_id', '=', 'syll_co_pos.syll_co_id')
            // ->groupBy('syllabus_course_outcomes.syll_co_id')
            ->get();

        // join('program_outcomes', 'program_outcomes.po_id', '=', 'syll_co_pos.syll_po_id')
        // ->join('syllabus_course_outcomes', 'syllabus_course_outcomes.syll_co_id', '=', 'syll_co_pos.syll_co_id')
        // ->where('syllabus_course_outcomes.syll_id', '=', $syll_id)
        // ->select('syllabus_course_outcomes.*', 'program_outcomes.*')
        // ->get();

            // ->join('syll_co_pos', 'syll_co_pos.syll_po_id', '=', 'program_outcomes.po_id')
            // ->join('syllabus_course_outcomes', 'syllabus_course_outcomes.syll_co_id', '=', 'syll_co_pos.syll_co_id')
            // ->select('program_outcomes.*')

        $courseOutcomes = SyllabusCourseOutcome::all();
        $copos = SyllabusCoPO::all();
   
        $instructors = SyllabusInstructor::join('users', 'syllabus_instructors.syll_ins_user_id', '=', 'users.id')
        ->select('users.*', 'syllabus_instructors.*')
        ->get()
        ->groupBy('syll_id');

        return view('bayanihanleader.syllabus.syllView', compact('syllabus', 'instructors', 'syll_id', 'instructors', 'courseOutcomes', 'programOutcomes', 'copos'));
    }
    public function createSyllabus()
    {
        $bGroups = BayanihanGroup::join('courses', 'courses.course_id', '=', 'bayanihan_groups.course_id')
        ->join('bayanihan_leaders', 'bayanihan_groups.bg_id', '=', 'bayanihan_leaders.bg_id')
        ->where('bayanihan_leaders.bg_user_id', '=', Auth::user()->id)
        ->select('bayanihan_groups.*', 'courses.*')
        ->get();

        //add: Only show bg groups that they leads
        $instructors = User::all();

        return view('bayanihanleader.syllabus.syllCreate', compact('bGroups', 'instructors'));
    }
    public function storeSyllabus(Request $request)
    {
        $request->validate([
            'syll_class_schedule' => 'required',
            'syll_bldg_rm' => 'required',
            'syll_ins_consultation' => 'required',
            'syll_ins_bldg_rm' => 'required',
            'syll_course_description' => 'required',
            'bg_id' => "required"
        ]);
        $syllabus = new Syllabus();
        $syllabus->bg_id = $request->input('bg_id');
        $syllabus->syll_class_schedule = $request->input('syll_class_schedule');
        $syllabus->syll_bldg_rm = $request->input('syll_bldg_rm');
        $syllabus->syll_ins_consultation = $request->input('syll_ins_consultation');
        $syllabus->syll_ins_bldg_rm = $request->input('syll_ins_bldg_rm');
        $syllabus->syll_course_description = $request->input('syll_course_description');
        $syllabus->save();

        $instructors = $request->input('syll_ins_user_id');
        foreach ($instructors as $instructor_id) {
            $instructor = new SyllabusInstructor();
            $instructor->syll_id = $syllabus->syll_id;
            $instructor->syll_ins_user_id = $instructor_id;
            $instructor->save();
        }
        return redirect()->route('bayanihanleader.home')->with('success', 'Syllabus created successfully.');
    }
}


public function storeCot(Request $request, $syll_id)
    {
        $validatedData = $request->validate([
            'syll_allotted_time.*' => 'required',
            'syll_course_outcome.*' => 'required',
            'syll_intended_learning.*' => 'required',
            'syll_topics' => 'required',
            'syll_suggested_readings.*' => 'nullable',
            'syll_learning_act.*' => 'nullable',
            'syll_asses_tools.*' => 'nullable',
            'syll_grading_criteria.*' => 'nullable',
            'syll_remarks.*' => 'nullable',
        ]);

        foreach ($validatedData['syll_allotted_time'] as $key => $syll_allotted_time) {
            $cot = SyllabusCourseOutline::updateOrCreate(
                ['syll_id' => $syll_id, 'syll_allotted_time' => $syll_allotted_time],
                [
                    'syll_course_outcome' => $validatedData['syll_course_outcome'][$key],
                    'syll_intended_learning' => $validatedData['syll_intended_learning'][$key],
                    'syll_topics' => $validatedData['syll_topics'][$key],
                    'syll_suggested_readings' => $validatedData['syll_suggested_readings'][$key],
                    'syll_learning_act' => $validatedData['syll_learning_act'][$key],
                    'syll_asses_tools' => $validatedData['syll_asses_tools'][$key],
                    'syll_grading_criteria' => $validatedData['syll_grading_criteria'][$key],
                    'syll_remarks' => $validatedData['syll_remarks'][$key],
                ]
            );
            $courseOutcomes = $request->input

            $instructors = $request->input('syll_ins_user_id');
            foreach ($instructors as $instructor_id) {
            $instructor = new SyllabusInstructor();
            $instructor->syll_id = $syllabus->syll_id;
            $instructor->syll_ins_user_id = $instructor_id;
            $instructor->save();
        }
        }

