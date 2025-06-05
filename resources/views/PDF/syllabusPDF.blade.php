<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    table {
        border-collapse: collapse;
        /* Combine borders for seamless look */
    }

    tr, tr, td {
        border: 1px solid black;
        /* Top border for each row */
        /* Bottom border for each row */
    }

    .header {
        text-align: center;
        vertical-align: middle;
    }

    .side {
        width: 20%;
    }
</style>

<body>
    <div>
        <table>
            <!-- 1st Header -->
            <tr class="header">
                <th colspan="2" class="header">
                    <span class="">{{$syll->college_description}}</span><br>
                    {{$syll->department_name}}
                </th>

                <th class="">
                    <span class="">Syllabus<br></span>
                    Course Title :<span class="">{{$syll->course_title}}<br></span>
                    Course Code: {{$syll->course_code}}<br>
                    Credits: {{$syll->course_credit_unit}} units ({{$syll->course_unit_lec}} hours lecture, {{$syll->course_unit_lab}} hrs Laboratory)<br>
                </th>
            </tr>
            <!-- 2nd ROW  -->
            <tr>
                <td class="">
                    <!-- VISION -->
                    <div class="">
                        <span class="">USTP Vision<br><br></span>
                        <p>The University is a nationally recognized Science and Technology University providing the vital link between education and the economy.</p>
                    </div>
                    <!-- MISSION -->
                    <div class="">
                        <span class="">USTP Mission<br><br></span>
                        <ul class="">
                            <li class="">
                                Bring the world of work (industry) into the actual higher education and training of students;
                            </li>
                            <li class="">
                                Offer entrepreneurs the opportunity to maximize their business potentials through a gamut of services from product conceptualization to commercialization;
                            </li>
                            <li class="">
                                Contribute significantly to the National Development Goals of food security an energy sufficiency through technological solutions.
                            </li>
                        </ul>
                    </div>
                    <!-- POE -->
                    <div class="">
                        <span class="">Program Educational Objectives<br><br></span>
                        @foreach($poes as $poe)
                        <div class="">
                            <p><span class="">{{$poe->poe_code}}: </span>{{$poe->poe_description}}</p>
                        </div>
                        @endforeach
                    </div>
                    <div class="">
                        <span class="">Program Outcomes<br><br></span>
                        @foreach($programOutcomes as $po)
                        <div class="">
                            <p><span class="">{{$po->po_letter}}: </span>{{$po->po_description}}</p>
                        </div>
                        @endforeach
                    </div>

                    <table class="">
                        <tr>
                            <th class="">Code</th>
                            <th class="">Description</th>
                        </tr>
                        <tbody>
                            <tr class="">
                                <td class="">I</td>
                                <td class=" ">Introductory Course</td>
                            </tr>
                            <tr>
                                <td class="">E</td>
                                <td class="">Enabling Course</td>
                            </tr>
                            <tr>
                                <td class="">D</td>
                                <td class=" ">Demonstrative Course</td>
                            </tr>
                            <tr class="">
                                <td class="">Code</td>
                                <td class="">Definition</td>
                            </tr>
                            <tr>
                                <td class="">I</td>
                                <td class="">An introductory course to an outcome</td>
                            </tr>
                            <tr>
                                <td class="">E</td>
                                <td class="">A course strengthens an outcome</td>
                            </tr>
                            <tr>
                                <td class="">D</td>
                                <td class="">A Course demonstrating an outcome</td>
                            </tr>
                        </tbody>
                    </table>
                </td>


                <!-- syllabus proper  -->
                <td colspan="2" class="">
                    <table>
                        <!-- About Course  -->
                        <tr class="">
                            <td class="">
                                Semester/Year: {{$syll->course_semester}} SY{{$syll->bg_school_year}}<br>
                                Class Schedule:{!! nl2br(e($syll->syll_class_schedule)) !!}<br>
                                Bldg./Rm. No. {{$syll->syll_bldg_rm}}
                            </td>
                            <td class="">
                                Pre-requisite(s): {{$syll->course_pre_req}} <br>
                                Co-requisite(s): {{$syll->course_co_req}}
                            </td>
                        </tr>

                        <!-- About Instructor  -->
                        <tr>
                            <td class="">
                                Instructor:
                                @foreach ($instructors[$syll->syll_id] ?? [] as $key => $instructor)
                                @if ($loop->first)
                                <span class="">{{ $instructor->firstname }} {{ $instructor->lastname }}</span>
                                @elseif ($loop->last)
                                and <span class="">{{ $instructor->firstname }} {{ $instructor->lastname }}</span>
                                @else
                                , <span class="">{{ $instructor->firstname }} {{ $instructor->lastname }}</span>
                                @endif
                                @endforeach
                                <br>
                                Email:
                                @foreach ($instructors[$syll->syll_id] ?? [] as $instructor)
                                {{ $instructor->email }}
                                @endforeach <br>
                                Phone:
                                @foreach ($instructors[$syll->syll_id] ?? [] as $instructor)
                                {{ $instructor->phone }}
                                @endforeach <br>
                            </td>
                            <td class="">
                                Consultation Schedule: {!! nl2br(e($syll->syll_ins_consultation)) !!}<br>
                                Bldg rm no: {{$syll->syll_ins_bldg_rm}}
                            </td>
                        </tr>

                        <tr>
                            <td colspan=2 class="">
                                <span class="">
                                    I. Course Descripion:</span><br>
                                {{ $syll->syll_course_description }}
                            </td>
                        </tr>

                        <tr class="">
                            <!-- course_outcome table-->
                            <td colspan=2 class="">
                                <span class="">
                                    II. Course Outcome:</span><br>
                                <table class="">
                                    <tr class="">
                                        <th>
                                            Course Outcomes (CO)
                                        </th>
                                        @foreach($programOutcomes as $po)
                                        <th class="">
                                            {{$loop->iteration}}
                                        </th>
                                        @endforeach
                                    </tr>

                                    @foreach($courseOutcomes as $co)
                                    <tr class="">
                                        <td class=""><span class="">{{$co->syll_co_code}} : </span>{{$co->syll_co_description}}</td>
                                        @foreach($programOutcomes as $po)
                                        <td class="">
                                            @foreach ($copos as $copo)
                                            @if($copo->syll_po_id == $po->po_id)
                                            @if($copo->syll_co_id == $co->syll_co_id)
                                            {{$copo->syll_co_po_code}}
                                            @endif
                                            @endif
                                            @endforeach
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>

                        <!-- course outline tr -->
                        <tr>
                            <td colspan=2 class="">
                                <span class="">
                                    III. Course Outline:</span><br>
                                <table class="">
                                    <tr class="">
                                        <th class="">
                                            Alloted Time
                                        </th>
                                        <th class="">
                                            Course Outcomes (C)
                                        </th>
                                        <th class="">
                                            Intended Learning Outcome (ILO)
                                        </th>
                                        <th class="">
                                            Topics
                                        </th>
                                        <th class="">
                                            Suggested Readings
                                        </th>
                                        <th class="">
                                            Teaching Learning Activities
                                        </th>
                                        <th class="">
                                            Assessment Tasks/Tools
                                        </th>
                                        <th class="">
                                            Grading Criteria
                                        </th>
                                        <th class="">
                                            Remarks
                                        </th>
                                    </tr>

                                    @foreach($courseOutlines as $cot)
                                    <tr class="">
                                        <td class="">
                                            {!! nl2br(e($cot->syll_allotted_time)) !!}
                                        </td>
                                        <td class="">
                                            @foreach ($cotCos->get($cot->syll_co_out_id, []) as $index => $coo)
                                            {{ $coo->syll_co_code }}@unless($loop->last),@endunless
                                            @endforeach
                                        </td>
                                        <td class="">
                                            {!! nl2br(e($cot->syll_intended_learning)) !!}
                                        </td>
                                        <td class="">
                                            {!! nl2br(e($cot->syll_topics)) !!}

                                        </td>
                                        <td class="">
                                            {!! nl2br(e($cot->syll_suggested_readings)) !!}
                                        </td>
                                        <td class="">
                                            {!! nl2br(e($cot->syll_learning_act)) !!}
                                        </td>
                                        <td class="">
                                            {!! nl2br(e($cot->syll_asses_tools)) !!}
                                        </td>
                                        <td class="">
                                            {!! nl2br(e($cot->syll_grading_criteria)) !!}
                                        </td>
                                        <td class="">
                                            {!! nl2br(e($cot->syll_remarks)) !!}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="">
                                        <th colspan=10 class="">
                                            MIDTERM EXAMINATION
                                        </th>
                                    </tr>
                                    @foreach($courseOutlinesFinals as $cotf)
                                    <tr class="">
                                        <td class="">
                                            {!! nl2br(e($cotf->syll_allotted_time)) !!}
                                        </td>
                                        <td class="">
                                            @foreach ($cotCosF->get($cotf->syll_co_out_id, []) as $index => $coo)
                                            {{ $coo->syll_co_code }}@unless($loop->last),@endunless
                                            @endforeach
                                        </td>
                                        <td class="">
                                            {!! nl2br(e($cotf->syll_intended_learning)) !!}
                                        </td>
                                        <td class="">
                                            {!! nl2br(e($cotf->syll_topics)) !!}
                                        </td>
                                        <td class="">
                                            {!! nl2br(e($cotf->syll_suggested_readings)) !!}
                                        </td>
                                        <td class="">
                                            {!! nl2br(e($cotf->syll_learning_act)) !!}
                                        </td>
                                        <td class="">
                                            {!! nl2br(e($cotf->syll_asses_tools)) !!}
                                        </td>
                                        <td class="">
                                            {!! nl2br(e($cotf->syll_grading_criteria)) !!}
                                        </td>
                                        <td class="">
                                            {!! nl2br(e($cotf->syll_remarks)) !!}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th colspan=10 class="">
                                            FINAL EXAMINATION
                                        </th>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- course Requirements -->
                        <tr class="">
                            <td colspan="2" class="">
                                <span class="">
                                    IV. Course Requirements:
                                </span><br>
                                <div class="">
                                    {!! $syll->syll_course_requirements !!}
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div>
                        <div class="">
                            <div class="">
                                Prepared By:
                            </div>
                            @foreach ($instructors[$syll->syll_id] ?? [] as $key => $instructor)
                            <div>
                                @if($syll->chair_submitted_at != null)
                                <div class="">
                                    sgd
                                </div>
                                @else
                                <div class="">

                                </div>
                                @endif
                                <div class="">
                                    {{ strtoupper($instructor->prefix) }} {{ strtoupper($instructor->firstname) }} {{ strtoupper($instructor->lastname) }} {{ strtoupper($instructor->suffix) }}
                                </div>
                                <div class="">
                                    Instructor
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div>
                            <div class="">
                                Checked and Recommended for Approval:
                            </div>
                            @if($syll->dean_submitted_at != null)
                            <div class="">
                                sgd
                            </div>
                            @else
                            <div class="">

                            </div>
                            @endif
                            <div class="">
                                {{ strtoupper($syll->syll_chair) }}
                            </div>
                            <div class="">
                                Chairperson, {{$syll->department_name}}
                            </div>
                        </div>
                        <div>
                            <div class="">
                                Approved by:
                            </div>
                            @if($syll->dean_approved_at != null)
                            <div class="">
                                sgd
                            </div>
                            @else
                            <div class="">

                            </div>
                            @endif
                            <div class="">
                                {{ strtoupper($syll->syll_dean) }}
                            </div>
                            <div class="">
                                Dean, {{$syll->college_code}}
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>