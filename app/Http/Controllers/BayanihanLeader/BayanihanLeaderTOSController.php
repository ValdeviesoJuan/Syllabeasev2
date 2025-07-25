<?php

namespace App\Http\Controllers\BayanihanLeader;

use App\Http\Controllers\Controller;
use App\Models\BayanihanGroupUsers;
use App\Models\Course;
use App\Models\Syllabus;
use App\Models\SyllabusCotCoM;
use App\Models\SyllabusCourseOutcome;
use App\Models\SyllabusCourseOutlineMidterm;
use App\Models\SyllabusCourseOutlinesFinal;
use App\Models\Tos;
use App\Models\TosRows;
use App\Models\User;
use App\Models\Roles;
use App\Notifications\Chair_TOSSubmitted;
use App\Notifications\TOSSubmitted;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\TosCreatedNotification;

class BayanihanLeaderTOSController extends Controller
{
    public function index()
    {
        $myGroup = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->where('bayanihan_group_users.user_id', '=', Auth::user()->id)
            ->where('bayanihan_group_users.bg_role', '=', 'leader')
            ->select('bayanihan_groups.bg_id')
            ->first();

        if ($myGroup) {
            $toss = Tos::join('bayanihan_groups', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
                ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
                ->join('courses', 'courses.course_id', '=', 'tos.course_id')
                ->select('tos.*', 'courses.*', 'bayanihan_groups.*')
                ->whereRaw('tos.tos_version = (SELECT MAX(tos_version) FROM tos WHERE bg_id = bayanihan_groups.bg_id)')
                ->whereIn('tos.tos_term', ['Midterm', 'Final'])
                ->whereIn('tos.tos_version', function ($query) {
                    $query->select(DB::raw('MAX(tos_version)'))
                        ->from('tos')
                        ->groupBy('syll_id', 'tos_term');
                })
                ->where('tos.bg_id', '=', $myGroup->bg_id)
                ->get();
        } else {
            $toss = [];
        }

        $user = Auth::user();
        $notifications = $user->notifications;

        return view('bayanihanleader.tos.tosList', compact('notifications', 'toss'));
    }
    public function createTos($syll_id)
    {
        $syllabus = Syllabus::join('courses', 'courses.course_id', '=', 'syllabi.course_id')
            ->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            ->select('syllabi.*', 'courses.*', 'bayanihan_groups.*')
            ->where('syllabi.syll_id', $syll_id)
            ->first();

        $midtermTopics = SyllabusCourseOutlineMidterm::where('syll_id', $syll_id)
            ->pluck('syll_topics')
            ->filter()
            ->unique()
            ->values();

        $finalTopics = SyllabusCourseOutlinesFinal::where('syll_id', $syll_id)
            ->pluck('syll_topics')
            ->filter()
            ->unique()
            ->values();

        $user = Auth::user();
        $notifications = $user->notifications;

        return view('bayanihanleader.tos.tosCreate', compact(
            'notifications',
            'syllabus',
            'syll_id',
            'midtermTopics',
            'finalTopics'
        ));
    }
    public function viewTos($tos_id)
    {
        $tos = Tos::where('tos_id', $tos_id)->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'tos.bg_id')
            ->join('courses', 'courses.course_id', '=', 'tos.course_id')
            ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
            ->select('tos.*', 'bayanihan_groups.*', 'courses.*')->first();
        $course_outcomes = SyllabusCourseOutcome::where('syll_id', '=', $tos->syll_id)->select('syllabus_course_outcomes.*')->get();
        $tos_rows = TosRows::where('tos_rows.tos_id', '=', $tos_id)
            ->leftJoin('tos', 'tos.tos_id', '=', 'tos_rows.tos_id')
            ->select('tos.*', 'tos_rows.*')
            ->get();

        $bLeaders = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_group_users.user_id')
            ->select('bayanihan_group_users.*', 'users.*')
            ->where('tos.tos_id', '=', $tos_id)
            ->where('bayanihan_group_users.bg_role', '=', 'leader')
            ->get();
        $bMembers = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_group_users.user_id')
            ->select('bayanihan_group_users.*', 'users.*')
            ->where('tos.tos_id', '=', $tos_id)
            ->where('bayanihan_group_users.bg_role', '=', 'member')
            ->get();
            
        $tosVersions = Tos::where('tos.bg_id', $tos->bg_id)
            ->select('tos.*')
            ->get();

        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');
        $chair = Syllabus::join('tos', 'tos.syll_id', '=', 'syllabi.syll_id')
            ->join('user_roles', 'syllabi.department_id', '=', 'user_roles.entity_id')
            ->join('users', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.entity_type', 'Department')
            ->where('user_roles.role_id', $chairRoleId)
            ->first();

        return view('bayanihanleader.tos.tosView', compact('tos_rows', 'tos', 'tos_id', 'bMembers', 'bLeaders', 'tosVersions', 'course_outcomes', 'chair'));
    }
    public function destroyTos(Tos $tos_id)
    {
        $tos_id->delete();
        return redirect()->route('bayanihanleader.tos')->with('success', 'Tos deleted successfully.');
    }
    public function submitTos($tos_id)
    {
        $tos = Tos::find($tos_id);

        if (!$tos) {
            return redirect()->route('bayanihanleader.tos')->with('error', 'Tos not found.');
        }
        $tos->chair_submitted_at = Carbon::now();
        $tos->tos_status = 'Pending';
        $tos->save();

        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');
        $chair = User::join('user_roles', 'user_roles.user_id', '=', 'users.id')
            ->join('departments', 'departments.department_id', '=', 'user_roles.entity_id')
            ->where('user_roles.entity_type', 'Department')
            ->where('user_roles.role_id', $chairRoleId)
            ->where('departments.department_id', '=', $tos->department_id)
            ->select('users.*', 'departments.*')
            ->first();

        $submitted_tos = Tos::where('tos_id', $tos_id)
            ->join('bayanihan_groups', 'bayanihan_groups.bg_id', 'tos.bg_id')
            ->join('courses', 'courses.course_id', 'bayanihan_groups.course_id')
            ->select('bayanihan_groups.bg_school_year', 'courses.course_code')
            ->first();
        $course_code = $submitted_tos->course_code;
        $bg_school_year = $submitted_tos->bg_school_year;
        $chair->notify(new Chair_TOSSubmitted($course_code, $bg_school_year, $tos_id));


        return redirect()->route('bayanihanleader.tos')->with('success', 'Tos submission successful.');
    }
    public function editTos($syll_id, $tos_id)
    {
        $syllabus = Syllabus::join('courses', 'courses.course_id', '=', 'syllabi.course_id')
            ->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            ->select('syllabi.*', 'courses.*', 'bayanihan_groups.*')
            ->where('syllabi.syll_id', $syll_id) // ← fix missing WHERE condition
            ->first();

        $tos = Tos::where('tos_id', $tos_id)
            ->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'tos.bg_id')
            ->join('courses', 'courses.course_id', '=', 'tos.course_id')
            ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
            ->select('tos.*', 'bayanihan_groups.*', 'courses.*')
            ->first();

        $tos_rows = TosRows::where('tos_rows.tos_id', '=', $tos_id)
            ->leftJoin('tos', 'tos.tos_id', '=', 'tos_rows.tos_id')
            ->select('tos.*', 'tos_rows.*')
            ->get();

        // Get Midterm topics from syllabus_course_outlines_midterms
        $midtermTopics = DB::table('syllabus_course_outlines_midterms')
            ->where('syll_id', $syll_id)
            ->pluck('syll_topics')
            ->filter()
            ->flatMap(function ($topic) {
                return array_map('trim', explode(',', $topic));
            })
            ->unique()
            ->values()
            ->toArray();

        // Get Final topics from syllabus_course_outlines_finals
        $finalTopics = DB::table('syllabus_course_outlines_finals')
            ->where('syll_id', $syll_id)
            ->pluck('syll_topics')
            ->filter()
            ->flatMap(function ($topic) {
                return array_map('trim', explode(',', $topic));
            })
            ->unique()
            ->values()
            ->toArray();

        // Also get selected topics from tos_rows
        $selectedTopics = $tos_rows->pluck('tos_r_topic')->toArray();

        $bLeaders = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_group_users.user_id')
            ->select('bayanihan_group_users.*', 'users.*')
            ->where('tos.tos_id', '=', $tos_id)
            ->where('bayanihan_group_users.bg_role', '=', 'leader')
            ->get();

        $bMembers = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_group_users.user_id')
            ->select('bayanihan_group_users.*', 'users.*')
            ->where('tos.tos_id', '=', $tos_id)
            ->where('bayanihan_group_users.bg_role', '=', 'member')
            ->get();

        $user = Auth::user();
        $notifications = $user->notifications;

        return view('bayanihanleader.tos.tosEdit', compact(
            'notifications',
            'tos_rows',
            'tos',
            'tos_id',
            'bMembers',
            'bLeaders',
            'syllabus',
            'syll_id',
            'midtermTopics',
            'finalTopics',
            'selectedTopics'
        ));
    }

    public function commentTos($tos_id)
    {
        $tos = Tos::where('tos_id', $tos_id)->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'tos.bg_id')
            ->join('courses', 'courses.course_id', '=', 'tos.course_id')
            ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
            ->select('tos.*', 'bayanihan_groups.*', 'courses.*')->first();

        $course_outcomes = SyllabusCourseOutcome::where('syll_id', '=', $tos->syll_id)->select('syllabus_course_outcomes.*')->get();

        $tos_rows = TosRows::where('tos_rows.tos_id', '=', $tos_id)
            ->leftJoin('tos', 'tos.tos_id', '=', 'tos_rows.tos_id')
            ->select('tos.*', 'tos_rows.*')
            ->get();

        $bLeaders = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_group_users.user_id')
            ->select('bayanihan_group_users.*', 'users.*')
            ->where('tos.tos_id', '=', $tos_id)
            ->where('bayanihan_group_users.bg_role', '=', 'leader')
            ->get();
        $bMembers = BayanihanGroupUsers::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_group_users.bg_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_group_users.user_id')
            ->select('bayanihan_group_users.*', 'users.*')
            ->where('tos.tos_id', '=', $tos_id)
            ->where('bayanihan_group_users.bg_role', '=', 'member')
            ->get();

        $tosVersions = Tos::where('tos.bg_id', $tos->bg_id)
            ->select('tos.*')
            ->get();
            
        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');
        $chair = Syllabus::join('tos', 'tos.syll_id', '=', 'syllabi.syll_id')
            ->join('user_roles', 'syllabi.department_id', '=', 'user_roles.entity_id')
            ->join('users', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.entity_type', 'Department')
            ->where('user_roles.role_id', $chairRoleId)
            ->first();

        return view('bayanihanleader.tos.tosComment', compact('chair', 'tos_rows', 'tos', 'tos_id', 'bMembers', 'bLeaders', 'tosVersions', 'course_outcomes'));
    }
    public function storeTos(Request $request, $syll_id)
    {
        $syllabus = Syllabus::where('syll_id', $syll_id)->first();

        $request->validate([
            'tos_term' => 'required',
            'tos_no_items' => 'required|integer',
            'col_1_per' => 'required|numeric',
            'col_2_per' => 'required|numeric',
            'col_3_per' => 'required|numeric',
            'col_4_per' => 'required|numeric',
            'tos_cpys' => 'required',
        ]);

        $existingMTos = Tos::where('syll_id',  $syll_id)->where('tos_term', 'Midterm')->first();
        $existingFTos = Tos::where('syll_id',  $syll_id)->where('tos_term', 'Final')->first();

        if ($existingMTos && $request->tos_term === 'Midterm') {
            return redirect()->route('bayanihanleader.tos')->with('error', 'Midterm TOS already exists for this Syllabus.');
        } elseif ($existingFTos && $request->tos_term === 'Final') {
            return redirect()->route('bayanihanleader.tos')->with('error', 'Final TOS already exists for this Syllabus.');
        } elseif ($existingMTos && $existingFTos) {
            return redirect()->route('bayanihanleader.tos')->with('error', 'Midterm and Final TOS already exist for this Syllabus.');
        }

        $tos = new Tos();
        $tos->syll_id = $syll_id;
        $tos->user_id = Auth::user()->id;
        $tos->effectivity_date = $syllabus->effectivity_date;
        $tos->tos_term = $request->tos_term;
        $tos->tos_no_items = $request->tos_no_items;
        $tos->col_1_per = $request->col_1_per;
        $tos->col_2_per = $request->col_2_per;
        $tos->col_3_per = $request->col_3_per;
        $tos->col_4_per = $request->col_4_per;
        $tos->tos_cpys = $request->tos_cpys;

        $tos->course_id = $syllabus->course_id;
        $tos->department_id = $syllabus->department_id;
        $tos->bg_id = $syllabus->bg_id;
        $tos->save();
        $tableName = $request->tos_term === 'Final' ? 'syllabus_course_outlines_finals' : 'syllabus_course_outlines_midterms';

        $selectedTopics = $request->input('selected_topics', []);

        $outlineModel = $request->tos_term === 'Final' ? SyllabusCourseOutlinesFinal::class : SyllabusCourseOutlineMidterm::class;

        $selectedEntries = $outlineModel::where('syll_id', $syll_id)
            ->whereIn('syll_topics', $selectedTopics)
            ->get();
        
        if ($tos) {
            // Calculate the values based on the percentages
            $col1Exp = $tos->tos_no_items * ($tos->col_1_per / 100);
            $col2Exp = $tos->tos_no_items * ($tos->col_2_per / 100);
            $col3Exp = $tos->tos_no_items * ($tos->col_3_per / 100);
            $col4Exp = $tos->tos_no_items * ($tos->col_4_per / 100);

            // Calculate the sum of the floored values
            $sumOfFlooredValues = floor($col1Exp) + floor($col2Exp) + floor($col3Exp) + floor($col4Exp);

            // Calculate the remaining items
            $remainingItems = $tos->tos_no_items - $sumOfFlooredValues;

            // Distribute the remaining items to the columns with decimal values
            $decimals = [$col1Exp - floor($col1Exp), $col2Exp - floor($col2Exp), $col3Exp - floor($col3Exp), $col4Exp - floor($col4Exp)];
            arsort($decimals);
            foreach ($decimals as $index => $decimal) {
                if ($remainingItems > 0) {
                    ${"col" . ($index + 1) . "Exp"} = floor(${"col" . ($index + 1) . "Exp"}) + 1;
                    $remainingItems--;
                } else {
                    ${"col" . ($index + 1) . "Exp"} = floor(${"col" . ($index + 1) . "Exp"});
                }
            }

            // Update the Tos record with the adjusted values
            $tosColExpUpdate = Tos::find($tos->tos_id);
            $tosColExpUpdate->col_1_exp = $col1Exp;
            $tosColExpUpdate->col_2_exp = $col2Exp;
            $tosColExpUpdate->col_3_exp = $col3Exp;
            $tosColExpUpdate->col_4_exp = $col4Exp;
            $tosColExpUpdate->save();
        } else {
        }

        $totalNoHours = 0;

        if ($syllabus) {
            // Calculate the total syll_allotted_time
            $totalNoHours = $selectedEntries->sum('syll_allotted_hour');

            foreach ($selectedEntries as $co) {
                $tos_row = new TosRows();
                $tos_row->tos_id = $tos->tos_id;
                $tos_row->tos_r_topic = $co->syll_topics;
                $tos_row->tos_r_no_hours = $co->syll_allotted_hour ?? 0;
                $tos_row->save();
            }

            $tosRows = TosRows::where('tos_id', $tos->tos_id)->get();
            $totalRoundedPercent = 0;
            $decimalRows = [];

            // Iterate through the rows
            foreach ($tosRows as $row) {
                $percent = ($row->tos_r_no_hours / $totalNoHours) * 100;

                // Check if decimal
                if ($percent != floor($percent)) {
                    $decimalRows[] = $row;
                }

                // round ang percent
                $roundedPercent = round($percent);

                // Update the total rounded percentage
                $totalRoundedPercent += $roundedPercent;

                // Update the row with the rounded percentage
                $row->tos_r_percent = $roundedPercent;
                $row->save();
            }

            // Adjust the last row with decimals to make the total exactly 100
            if (!empty($decimalRows)) {
                $lastDecimalRow = end($decimalRows);
                $adjustment = 100 - $totalRoundedPercent;
                $lastDecimalRow->tos_r_percent += $adjustment;
                $lastDecimalRow->save();
            }



            // ADJUST THE NO OF ITEMS PARA EQUAL SA TOTAL ITEMS HEHE 
            $totalRoundedItems = 0;
            $counter = 0;
            $totalRows = count($tosRows);

            $decimalRowsItem = [];

            // Iterate through the rows
            foreach ($tosRows as $row) {
                $counter++;
                $rowPercent = $row->tos_r_percent;

                // Computation to get the number of items rounded off
                $roundedItem = ($tos->tos_no_items * ($rowPercent / 100));

                // Check if the number has decimals
                if ($roundedItem != floor($roundedItem)) {
                    $decimalRowsItem[] = $row;
                }

                // Update the row with the rounded number of items and save
                $row->tos_r_no_items = floor($roundedItem);
                $row->save();

                $totalRoundedItems += floor($roundedItem);
            }

            // Distribute the remainder
            $remainder = $tos->tos_no_items - $totalRoundedItems;
            foreach ($decimalRowsItem as $row) {
                if ($remainder > 0) {
                    $row->tos_r_no_items += 1;
                    $row->save();
                    $remainder--;
                } else {
                    break;
                }
            }

            $expectedCol1 = round($tos->tos_no_items * ($tos->col_1_per / 100));
            $totalCol1 = 0;

            $expectedCol2 = round($tos->tos_no_items * ($tos->col_2_per / 100));
            $totalCol2 = 0;

            $expectedCol3 = round($tos->tos_no_items * ($tos->col_3_per / 100));
            $totalCol3 = 0;

            // $expectedCol4 = round($tos->tos_no_items * ($tos->col_4_per / 100));
            $expectedCol4 = $tos->tos_no_items - ($expectedCol1 + $expectedCol2 + $expectedCol3);

            $totalCol4 = 0;

            $expectedCol4 = max(0, $expectedCol4);

            foreach ($tosRows as $index => $row) {
                // Calculate the rounded value for $row->tos_r_col_1
                $Data1 = $row->tos_r_no_items * ($tos->col_1_per / 100);
                $Data2 = $row->tos_r_no_items * ($tos->col_2_per / 100);
                $Data3 = $row->tos_r_no_items * ($tos->col_3_per / 100);
                $Data4 = $row->tos_r_no_items * ($tos->col_4_per / 100);

                $row->tos_r_col_1 = $Data1;
                $row->tos_r_col_2 = $Data2;
                $row->tos_r_col_3 = $Data3;
                $row->tos_r_col_4 = $Data4;

                $row->save();

                $totalCol1 += $Data1;
                $totalCol2 += $Data2;
                $totalCol3 += $Data3;
                $totalCol4 += $Data4;
            }
        }

        // Send email to Chairperson(s)
        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');
        $chairpersons = User::join('user_roles', 'user_roles.user_id', '=', 'users.id')
            ->where('user_roles.entity_type', 'Department')
            ->where('user_roles.role_id', $chairRoleId)
            ->where('user_roles.entity_id', $tos->department_id)
            ->select('users.*')
            ->get();

        foreach ($chairpersons as $chair) {
            if (filter_var($chair->email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($chair->email)->send(new TosCreatedNotification($tos));
            }
        }

        return redirect()->route('bayanihanleader.viewTos', $tos->tos_id);
    }

    public function updateTos(Request $request, $syll_id, $tos_id)
    {
        $syllabus = Syllabus::where('syll_id', $syll_id)->first();

        $request->validate([
            'tos_term' => 'required',
            'tos_no_items' => 'required|integer',
            'col_1_per' => 'required|numeric',
            'col_2_per' => 'required|numeric',
            'col_3_per' => 'required|numeric',
            'col_4_per' => 'required|numeric',
            'tos_cpys' => 'required',
            'selected_topics' => 'required|array|min:1', // ✅ Validate selected topics
        ]);

        $tos = Tos::findOrFail($tos_id);
        $tos->user_id = Auth::user()->id;
        $tos->tos_term = $request->tos_term;
        $tos->tos_no_items = $request->tos_no_items;
        $tos->col_1_per = $request->col_1_per;
        $tos->col_2_per = $request->col_2_per;
        $tos->col_3_per = $request->col_3_per;
        $tos->col_4_per = $request->col_4_per;
        $tos->tos_cpys = $request->tos_cpys;
        $tos->course_id = $syllabus->course_id;
        $tos->bg_id = $syllabus->bg_id;
        $tos->save();

        // ✅ Determine correct table and fetch selected entries
        $tableName = $request->tos_term === 'Final' ? 'syllabus_course_outlines_finals' : 'syllabus_course_outlines_midterms';
        $selectedTopics = $request->input('selected_topics');

        $selectedEntries = DB::table($tableName)
            ->where('syll_id', $syll_id)
            ->whereIn('syll_topics', $selectedTopics)
            ->get();

        // ✅ Clear previous TOS rows
        TosRows::where('tos_id', $tos_id)->delete();

        // ✅ Handle expected column distribution
        $col1Exp = $tos->tos_no_items * ($tos->col_1_per / 100);
        $col2Exp = $tos->tos_no_items * ($tos->col_2_per / 100);
        $col3Exp = $tos->tos_no_items * ($tos->col_3_per / 100);
        $col4Exp = $tos->tos_no_items * ($tos->col_4_per / 100);

        $sumOfFloored = floor($col1Exp) + floor($col2Exp) + floor($col3Exp) + floor($col4Exp);
        $remaining = $tos->tos_no_items - $sumOfFloored;
        $decimals = [
            'col_1' => $col1Exp - floor($col1Exp),
            'col_2' => $col2Exp - floor($col2Exp),
            'col_3' => $col3Exp - floor($col3Exp),
            'col_4' => $col4Exp - floor($col4Exp),
        ];
        arsort($decimals);

        $col1Exp = floor($col1Exp);
        $col2Exp = floor($col2Exp);
        $col3Exp = floor($col3Exp);
        $col4Exp = floor($col4Exp);

        $columnMap = [
            'col_1' => &$col1Exp,
            'col_2' => &$col2Exp,
            'col_3' => &$col3Exp,
            'col_4' => &$col4Exp,
        ];

        foreach (array_keys($decimals) as $col) {
            if ($remaining > 0) {
                $columnMap[$col]++;
                $remaining--;
            }
        }

        // ✅ Update Tos with adjusted expected values
        $tos->col_1_exp = $col1Exp;
        $tos->col_2_exp = $col2Exp;
        $tos->col_3_exp = $col3Exp;
        $tos->col_4_exp = $col4Exp;
        $tos->save();

        // ✅ Total hours for percent calculation
        $totalNoHours = $selectedEntries->sum('syll_allotted_hour');

        foreach ($selectedEntries as $co) {
            $tos_row = new TosRows();
            $tos_row->tos_id = $tos->tos_id;
            $tos_row->tos_r_topic = $co->syll_topics;
            $tos_row->tos_r_no_hours = $co->syll_allotted_hour ?? 0;
            $tos_row->save();
        }

        $tosRows = TosRows::where('tos_id', $tos->tos_id)->get();

        // ✅ Percent rounding and balancing
        $totalRoundedPercent = 0;
        $decimalRows = [];
        foreach ($tosRows as $row) {
            $percent = ($row->tos_r_no_hours / $totalNoHours) * 100;
            $roundedPercent = round($percent);
            if ($percent != floor($percent)) $decimalRows[] = $row;
            $row->tos_r_percent = $roundedPercent;
            $row->save();
            $totalRoundedPercent += $roundedPercent;
        }

        if (!empty($decimalRows)) {
            $adjustment = 100 - $totalRoundedPercent;
            $lastDecimalRow = end($decimalRows);
            $lastDecimalRow->tos_r_percent += $adjustment;
            $lastDecimalRow->save();
        }

        // ✅ Item distribution
        $totalRoundedItems = 0;
        $decimalRowsItem = [];
        foreach ($tosRows as $row) {
            $roundedItem = ($tos->tos_no_items * ($row->tos_r_percent / 100));
            if ($roundedItem != floor($roundedItem)) $decimalRowsItem[] = $row;
            $row->tos_r_no_items = floor($roundedItem);
            $row->save();
            $totalRoundedItems += floor($roundedItem);
        }

        $remainder = $tos->tos_no_items - $totalRoundedItems;
        foreach ($decimalRowsItem as $row) {
            if ($remainder-- > 0) {
                $row->tos_r_no_items += 1;
                $row->save();
            }
        }

        // ✅ Update column distributions
        foreach ($tosRows as $row) {
            $row->tos_r_col_1 = $row->tos_r_no_items * ($tos->col_1_per / 100);
            $row->tos_r_col_2 = $row->tos_r_no_items * ($tos->col_2_per / 100);
            $row->tos_r_col_3 = $row->tos_r_no_items * ($tos->col_3_per / 100);
            $row->tos_r_col_4 = $row->tos_r_no_items * ($tos->col_4_per / 100);
            $row->save();
        }

        return redirect()->route('bayanihanleader.viewTos', $tos_id)->with('success', 'Updated Tos Successfully');
    }

    public function replicateTos($tos_id)
    {
        $oldTos = Tos::where('tos_id', $tos_id)->first();
        $oldTosRows = TosRows::where('tos_id', $tos_id)->get();

        if ($oldTos) {
            $newTos = $oldTos->replicate();
            $newTos->chair_submitted_at = null;
            $newTos->chair_returned_at = null;
            $newTos->chair_approved_at = null;
            $newTos->tos_status = null;
            $newTos->tos_version = $oldTos->tos_version + 1;
            $newTos->save();

            foreach ($oldTosRows as $oldTosRow) {
                $newTosRow = $oldTosRow->replicate();
                $newTosRow->tos_id = $newTos->tos_id;
                $newTosRow->save();
            }
            return redirect()->route('bayanihanleader.viewTos', $newTos->tos_id)
                ->with('success', 'Tos replicated successfully');
        }
    }
    public function editTosRow($tos_id) 
    {
        $tos_id = TOS::where('tos_id', '=', $tos_id)
            ->select('tos_id')
            ->first();
            
        $user = Auth::user();
        $notifications = $user->notifications;

        return view('bayanihanleader.tos.tosEditRow', compact('tos_id', 'notifications'));
    }
    public function updateTosRow(Request $request, $tos_id)
    {
        $validatedData = $request->validate([
            'tos_r_id.*' => 'required',
            'tos_r_col_1.*' => 'required',
            'tos_r_col_2.*' => 'required',
            'tos_r_col_3.*' => 'required',
            'tos_r_col_4.*' => 'required',
        ]);

        foreach ($validatedData['tos_r_id'] as $key => $tos_r_id) {
            $tosRow = TosRows::find($tos_r_id);

            if ($tosRow) {
                $tosRow->tos_r_col_1 = $validatedData['tos_r_col_1'][$key];
                $tosRow->tos_r_col_2 = $validatedData['tos_r_col_2'][$key];
                $tosRow->tos_r_col_3 = $validatedData['tos_r_col_3'][$key];
                $tosRow->tos_r_col_4 = $validatedData['tos_r_col_4'][$key];
                $tosRow->save();
            }
        }

        // You can return a response as needed
        return redirect()->route('bayanihanleader.viewTos', $tos_id)->with('success', 'Tos adjusted successfully');
    }
}
