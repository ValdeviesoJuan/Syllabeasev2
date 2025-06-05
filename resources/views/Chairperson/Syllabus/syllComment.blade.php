@extends('layouts.chairSidebar')
@section('content')
@include('layouts.modal')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyllabEase</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/sample/se.png') }}">
    @vite('resources/css/app.css')
    <x-head.tinymce-config />
    <script src="https://cdn.tiny.cloud/1/ux8hih2n6kvrupg3ywetf1kdoav78vf12hcudnuhz6ftkl0x/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
        .crq li {
            list-style-type: disc;
            list-style-position: inside;
            padding-left: 40px;
        }

        .crq tr {
            border: 1px solid #000;
        }

        .crq td,
        .crq th {
            border: 1px solid #000;
            padding: 8px;
        }

        .crq table {
            margin: 0 auto;
        }

        .bg svg {
            transform: scaleY(-1);
            min-width: '1880'
        }

        body {
            background-image: url("{{ asset('assets/wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain;
        }

        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: rgba(128, 128, 128, 0.75);
            color: #fff;
            text-align: center;
            padding: 5px 0;
            border-radius: 6px;
            position: absolute;
            z-index: 1;
            top: 110%;
            left: 0%;
            margin-left: -60px;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
        }
    </style>
</head>

<body class="font-thin mt-14">
    <div class="flex justify-end mr-32">
        <div class="w-[130px] py-1 rounded-lg bg-[#2468d2] hover:scale-105 transition ease-in-out shadow-lg text-center">
            <a href="{{ route('chairperson.syllabus') }}" class="text-white flex items-center">
                <svg class="ml-4" xmlns="http://www.w3.org/2000/svg" width="35px" height="35px" viewBox="0 -0.5 25 25" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 12.0002C5.50024 8.66068 7.85944 5.78639 11.1348 5.1351C14.4102 4.48382 17.6895 6.23693 18.9673 9.32231C20.2451 12.4077 19.1655 15.966 16.3887 17.8212C13.6119 19.6764 9.91127 19.3117 7.55 16.9502C6.23728 15.6373 5.49987 13.8568 5.5 12.0002Z" stroke="#FFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 12.0002L11.333 14.3332L16 9.66724" stroke="#FFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="ml-2">Finish</span>
            </a>
        </div>
    </div>
    
    <table class="mt-2 mx-auto border-2 border-solid w-10/12 font-serif text-sm bg-white">
        <!-- 1st Header -->
        <tr>
            <th colspan="2" class="font-medium border-2 border-solid px-4">
                <span class="font-bold">{{$syll->college_description}}</span><br>
                {{$syll->department_name}}
            </th>

            <th class="font-medium border-2 border-solid text-left px-4 w-2/6">
                <span class="font-bold underline underline-offset-4">Syllabus<br></span>
                Course Title :<span class="font-bold">{{$syll->course_title}}<br></span>
                Course Code: {{$syll->course_code}}<br>
                Credits: {{$syll->course_credit_unit}} units ({{$syll->course_unit_lec}} hours lecture, {{$syll->course_unit_lab}} hrs Laboratory)<br>
            </th>
        </tr>
        <!-- 2nd Header -->
        <tr class="">
            <td class="border-2 border-solid font-medium  text-sm text-left px-4 text-justify align-top">
                <!-- VISION -->
                <div class="mt-2 mb-8">
                    <span class="font-bold">USTP Vision<br><br></span>
                    <p>The University is a nationally recognized Science and Technology University providing the vital link between education and the economy.</p>
                </div>
                <!-- MISSION -->
                <div class="mb-8">
                    <span class="font-bold">USTP Mission<br><br></span>
                    <ul class="list-disc">
                        <li class="ml-8">
                            Bring the world of work (industry) into the actual higher education and training of students;
                        </li>
                        <li class="ml-8">
                            Offer entrepreneurs the opportunity to maximize their business potentials through a gamut of services from product conceptualization to commercialization;
                        </li>
                        <li class="ml-8">
                            Contribute significantly to the National Development Goals of food security an energy sufficiency through technological solutions.
                        </li>
                    </ul>
                </div>
                <!-- POE -->
                <div class="mb-8">
                    <span class="font-bold">Program Educational Objectives<br><br></span>
                    @foreach($poes as $poe)
                    <div class="mb-2">
                        <p><span class="font-semibold">{{$poe->poe_code}}: </span>{{$poe->poe_description}}</p>
                    </div>
                    @endforeach
                </div>
                <div class="mb-8">
                    <span class="font-bold">Program Outcomes<br><br></span>
                    @foreach($programOutcomes as $po)
                    <div class="mb-5">
                        <p><span class="font-semibold leading-relaxed">{{$po->po_letter}}: </span>{{$po->po_description}}</p>
                    </div>
                    @endforeach
                </div>

                <table class="table-auto border-2 mb-5">
                    <thead class="border-2">
                        <tr>
                            <th class="border-2 text-center py-1">Code</th>
                            <th class="border-2 text-center">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="">
                            <td class="border-2 text-center py-2">I</td>
                            <td class="border-2 text-center">Introductory Course</td>
                        </tr>
                        <tr>
                            <td class="border-2 text-center py-2">E</td>
                            <td class="border-2 text-center">Enabling Course</td>
                        </tr>
                        <tr>
                            <td class="border-2 text-center py-2">D</td>
                            <td class="border-2 text-center">Demonstrative Course</td>
                        </tr>
                        <tr class="font-semibold">
                            <td class="border-2 text-center py-1">Code</td>
                            <td class="border-2 text-center">Definition</td>
                        </tr>
                        <tr>
                            <td class="border-2 text-center py-5">I</td>
                            <td class="border-2 text-center">An introductory course to an outcome</td>
                        </tr>
                        <tr>
                            <td class="border-2 text-center py-5">E</td>
                            <td class="border-2 text-center">A course strengthens an outcome</td>
                        </tr>
                        <tr>
                            <td class="border-2 text-center py-5">D</td>
                            <td class="border-2 text-center">A Course demonstrating an outcome</td>
                        </tr>
                    </tbody>
                </table>
            </td>

            <td colspan="2" class="w-[10/12] align-top">
                <table class="my-4 mx-2 ">
                    <tr class="">
                        <td class="border-2 border-solid font-medium text-left px-4 w-1/2">
                            Semester/Year: {{$syll->course_semester}} SY{{$syll->bg_school_year}}<br>
                            Class Schedule:{!! nl2br(e($syll->syll_class_schedule)) !!}<br>
                            Bldg./Rm. No. {{$syll->syll_bldg_rm}}
                        </td>
                        <td class="border-2 border-solid font-medium  text-start text-top px-4">
                            <div class="absolute right-[120px]">
                                <livewire:header-comment-modal :syll_id="$syll->syll_id" />
                            </div>
                            Pre-requisite(s): {{$syll->course_pre_req}} <br>
                            Co-requisite(s): {{$syll->course_co_req}}
                        </td>
                    </tr>

                    <tr>
                        <td class="items-start border-2 border-solid font-medium text-left px-4">
                            Instructor:
                            <!-- @foreach ($instructors[$syll->syll_id] ?? [] as $instructor)
                            <span class="font-bold">{{ $instructor->firstname }} {{ $instructor->lastname }}</span>
                            @endforeach <br> -->
                            @foreach ($instructors[$syll->syll_id] ?? [] as $key => $instructor)
                            @if ($loop->first)
                            <span class="font-bold">{{ $instructor->firstname }} {{ $instructor->lastname }}</span>
                            @elseif ($loop->last)
                            and <span class="font-bold">{{ $instructor->firstname }} {{ $instructor->lastname }}</span>
                            @else
                            , <span class="font-bold">{{ $instructor->firstname }} {{ $instructor->lastname }}</span>
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
                        <td class="border-2 border-solid font-medium text-left px-4">
                            Consultation Schedule: {!! nl2br(e($syll->syll_ins_consultation)) !!}<br>
                            Bldg rm no: {{$syll->syll_ins_bldg_rm}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan=2 class="items-start border-2 border-solid font-medium text-left px-4 ">
                            <span class="text-left font-bold">
                                I. Course Descripion:</span><br>
                            {{ $syll->syll_course_description }}
                        </td>
                    </tr>
                    <tr class="">
                        <!-- course_outcome table-->
                        <td colspan=2 class=" border-2 border-solid font-medium px-4 ">
                            <span class="text-left font-bold">
                                II. Course Outcome:</span><br>
                            <table class="m-10 mx-auto border-2 border-solid w-11/12">
                                <tr class="border-2 border-solid ">
                                    <th>
                                        Course Outcomes (CO)
                                    </th>
                                    @foreach($programOutcomes as $po)
                                    <th class="border-2 border-solid">
                                        {{$loop->iteration}}
                                    </th>
                                    @endforeach
                                </tr>

                                @foreach($courseOutcomes as $co)
                                <tr id="co_row" class="border-2 border-solid hover:bg-blue2">
                                    <td class="w-64 text-left font-medium px-2"><span class="font-bold">{{$co->syll_co_code}} : </span>{{$co->syll_co_description}}</td>
                                    @foreach($programOutcomes as $po)
                                    <td class="border-2 border-solid font-medium text-center py-1 ">
                                        @foreach ($copos as $copo)
                                        @if($copo->syll_po_id == $po->po_id)
                                        @if($copo->syll_co_id == $co->syll_co_id)
                                        {{$copo->syll_co_po_code}}
                                        @endif
                                        @endif
                                        @endforeach
                                    </td>
                                    @endforeach
                                    <td class="relative w-4">
                                        <livewire:chair-comment-modal :syll_co_id="$co->syll_co_id" />
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                    <!-- course outline tr -->
                    <tr>
                        <td colspan=2 class=" border-2 border-solid font-medium px-4">
                            <span class="text-left font-bold">
                                III. Course Outline:</span><br>
                            <table class="m-5 mx-auto border-2 border-solid w-">
                                <tr class="border-2 border-solid ">
                                    <th class="border-2 border-solid">
                                        Alloted Time
                                    </th>
                                    <th class="border-2 border-solid">
                                        Course Outcomes (C)
                                    </th>
                                    <th class="border-2 border-solid">
                                        Intended Learning Outcome (ILO)
                                    </th>
                                    <th class="border-2 border-solid">
                                        Topics
                                    </th>
                                    <th class="border-2 border-solid">
                                        Suggested Readings
                                    </th>
                                    <th class="border-2 border-solid">
                                        Teaching Learning Activities
                                    </th>
                                    <th class="border-2 border-solid">
                                        Assessment Tasks/Tools
                                    </th>
                                    <th class="border-2 border-solid">
                                        Grading Criteria
                                    </th>
                                    <th class="border-2 border-solid">
                                        Remarks
                                    </th>
                                </tr>

                                @foreach($courseOutlines as $cot)
                                <tr class="border-2 border-solid hover:bg-blue2">
                                    <td class="border-2 border-solid p-2">
                                        {!! nl2br(e($cot->syll_allotted_time)) !!}
                                    </td>
                                    <td class="border-2 border-solid p-2">
                                        @foreach ($cotCos->get($cot->syll_co_out_id, []) as $index => $coo)
                                        {{ $coo->syll_co_code }}@unless($loop->last),@endunless
                                        @endforeach
                                    </td>
                                    <td class="border-2 border-solid p-2">
                                        {!! nl2br(e($cot->syll_intended_learning)) !!}
                                    </td>
                                    <td class="border-2 border-solid p-2">
                                        {!! nl2br(e($cot->syll_topics)) !!}

                                    </td>
                                    <td class="border-2 border-solid p-2">
                                        {!! nl2br(e($cot->syll_suggested_readings)) !!}
                                    </td>
                                    <td class="border-2 border-solid p-2">
                                        {!! nl2br(e($cot->syll_learning_act)) !!}
                                    </td>
                                    <td class="border-2 border-solid p-2">
                                        {!! nl2br(e($cot->syll_asses_tools)) !!}
                                    </td>
                                    <td class="border-2 border-solid p-2">
                                        {!! nl2br(e($cot->syll_grading_criteria)) !!}
                                    </td>
                                    <td class="border-2 border-solid p-2">
                                        {!! nl2br(e($cot->syll_remarks)) !!}
                                    </td>
                                    <td class="relative">
                                        <livewire:chair-cot-m-comment :syll_co_out_id="$cot->syll_co_out_id" />
                                    </td>
                                </tr>
                                @endforeach

                                <tr class="border-2 border-solid p-2">
                                    <th colspan=10 class="border-2 border-solid font-medium px-4">
                                        MIDTERM EXAMINATION
                                    </th>
                                </tr>
                                @foreach($courseOutlinesFinals as $cotf)
                                <tr class="border-2 border-solid p-2 hover:bg-blue2">
                                    <td class="border-2 border-solid">
                                        <!-- {{$cotf->syll_allotted_time}} -->
                                        {!! nl2br(e($cotf->syll_allotted_time)) !!}
                                    </td>
                                    <td class="border-2 border-solid">
                                        <!-- @foreach ($cotCosF->get($cotf->syll_co_out_id, []) as $index => $coo)
                                        {{ $coo->syll_co_code }}@unless($loop->last),@endunless
                                        @endforeach -->
                                        @foreach ($cotCosF->get($cotf->syll_co_out_id, []) as $index => $coo)
                                        {{ $coo->syll_co_code }}@unless($loop->last),@endunless
                                        @endforeach
                                    </td>
                                    <td class="border-2 border-solid">
                                        {!! nl2br(e($cotf->syll_intended_learning)) !!}
                                    </td>
                                    <td class="border-2 border-solid">
                                        {!! nl2br(e($cotf->syll_topics)) !!}
                                    </td>
                                    <td class="border-2 border-solid">
                                        {!! nl2br(e($cotf->syll_suggested_readings)) !!}
                                    </td>
                                    <td class="border-2 border-solid">
                                        {!! nl2br(e($cotf->syll_learning_act)) !!}
                                    </td>
                                    <td class="border-2 border-solid">
                                        {!! nl2br(e($cotf->syll_asses_tools)) !!}
                                    </td>
                                    <td class="border-2 border-solid">
                                        {!! nl2br(e($cotf->syll_grading_criteria)) !!}
                                    </td>
                                    <td class="border-2 border-solid">
                                        {!! nl2br(e($cotf->syll_remarks)) !!}
                                    </td>
                                    <td class="relative">
                                        <livewire:chair-cot-f-comment :syll_co_out_id="$cotf->syll_co_out_id" />
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th colspan=10 class="border-2 border-solid font-medium px-4">
                                        FINAL EXAMINATION
                                    </th>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- course Requirements -->
                    <tr class="crq border-2">
                        <td colspan="2" class="border-2 border-solid font-medium">
                            <span class="text-left font-bold">
                                IV. Course Requirements:
                            </span><br>
                            <div class="crq">
                                {!! $syll->syll_course_requirements !!}
                            </div>
                        </td>
                    </tr>
        </tr>
    </table>

    <div class="grid grid-cols-3 m-3">
        <div class="">
            <div class="flex justify-center">
                Prepared By:
            </div>
            <!-- need loop here -->
            @foreach ($instructors[$syll->syll_id] ?? [] as $key => $instructor)
            <div>
                <div class="flex justify-center font-semibold underline mt-20">
                    {{ strtoupper($instructor->prefix) }} {{ strtoupper($instructor->firstname) }} {{ strtoupper($instructor->lastname) }} {{ strtoupper($instructor->suffix) }}
                </div>
                <div class="flex justify-center">
                    Instructor
                </div>
            </div>
            @endforeach

            <!-- <div>
                <div class="flex justify-center font-semibold underline mt-20">
                    JOHN-REY JAMAGO
                </div>
                <div class="flex justify-center">
                    Instructor
                </div>
            </div> -->
        </div>
        <div>
            <div class="flex justify-center">
                Checked and Recommended for Approval:
            </div>
            <div class="flex justify-center font-semibold underline mt-20">
                {{ strtoupper($syll->syll_chair) }}
            </div>
            <div class="flex justify-center">
                Chairperson, {{$syll->department_name}}
            </div>
        </div>
        <div>
            <div class="flex justify-center">
                Approved by:
            </div>
            <div class="flex justify-center font-semibold underline mt-20">
                {{ strtoupper($syll->syll_dean) }}
            </div>
            <div class="flex justify-center">
                Dean, {{$syll->college_code}}
            </div>
        </div>
    </div>
    </td>
    </table>


</body>

</html>
@endsection