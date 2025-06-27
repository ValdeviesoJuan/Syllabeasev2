@extends('layouts.BTsyllabus')
@section('content')
@include('layouts.modal')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyllabEase</title>
    @vite('resources/css/app.css')
    <x-head.tinymce-config />
    <script src="https://cdn.tiny.cloud/1/ux8hih2n6kvrupg3ywetf1kdoav78vf12hcudnuhz6ftkl0x/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#myeditorinstance',
            plugins: 'code table lists',
            toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });
    </script>
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
            background-image: url("{{ asset('assets/Wave.png') }}");
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
        .view-feedback-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            width: 500px;
            height: 520px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 1001;
        }
    </style>
            @livewireStyles

</head>

<body class="font-thin ">
    @if($syll->chair_submitted_at != null && $syll->dean_submitted_at == null && $syll->chair_rejected_at == null)
    <div class="flex flex-col border-2 border-blue3 bg-white bg-opacity-75 w-[500px] rounded-lg h-[60px] mt-2 mx-auto">
        <div class="flex items-center justify-center">
            <div class="mx-1">
                <svg fill="#2468d2" width="40px" height="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <title>notice1</title>
                    <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zM15.5 10c-0.828 0-1.5 0.671-1.5 1.5v5.062c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-5.062c0-0.829-0.672-1.5-1.5-1.5zM15.5 20c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5 1.5-0.672 1.5-1.5-0.672-1.5-1.5-1.5z"></path>
                </svg>
            </div>
            <div class="mt-1">
                <span class="font-semibold">Notice:</span> This syllabus has already been submitted, and further edits are no longer permitted.
            </div>
        </div>
    </div>
    <!-- Returned by Chair  -->
    @elseif($syll->chair_rejected_at != null && $syll->status == 'Returned by Chair')
    <div class="flex flex-col border-2 border-blue3 bg-white bg-opacity-75 w-[500px] rounded-lg h-[110px] mt-2 mx-auto">
        <div class="flex items-center justify-center">
            <div class="mx-1">
                <svg fill="#2468d2" width="40px" height="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <title>notice1</title>
                    <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zM15.5 10c-0.828 0-1.5 0.671-1.5 1.5v5.062c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-5.062c0-0.829-0.672-1.5-1.5-1.5zM15.5 20c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5 1.5-0.672 1.5-1.5-0.672-1.5-1.5-1.5z"></path>
                </svg>
            </div>
            <div class="mt-1">
                <span class="font-semibold">Notice:</span> This syllabus has already been submitted, and further edits are no longer permitted.
            </div>
        </div>
        <div class="flex mt-3 mx-auto">
            <div class="">
                <a href="{{ route('bayanihanteacher.viewReviewForm', $syll_id) }}" class="m-2 p-2 items-center rounded shadow hover:text-white hover:bg-blue hover:bg-blue text-blue border border-blue">
                    View Syllabus Review Form
                </a>
            </div>
        </div>
    </div>
    <!-- Returned by Dean  -->
    @elseif($syll->dean_rejected_at != null && $syll->status == 'Returned by Dean')
    <div class="flex flex-col border-2 border-blue3 bg-white bg-opacity-75 w-[500px] rounded-lg h-[110px] mt-2 mx-auto">
        <div class="flex items-center justify-center">
            <div class="mx-1">
                <svg fill="#2468d2" width="40px" height="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <title>notice1</title>
                    <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zM15.5 10c-0.828 0-1.5 0.671-1.5 1.5v5.062c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-5.062c0-0.829-0.672-1.5-1.5-1.5zM15.5 20c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5 1.5-0.672 1.5-1.5-0.672-1.5-1.5-1.5z"></path>
                </svg>
            </div>
            <div class="mt-1">
                <span class="font-semibold">Notice:</span> This syllabus has been returned by the dean for further revision.
            </div>
        </div>
        <div class="flex mt- mx-auto">
            <div class="">
                <button id="viewFeedback" type="submit" class="p-2 items-center rounded shadow hover:text-white hover:bg-blue hover:bg-blue text-blue">View Feedback</button>
            </div>
        </div>
    </div>
    <div class="hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white  rounded-lg shadow-lg view-feedback-modal">
        <div class="mt-5 flex flex-col justify-center items-center">
            <div class="text-lg font-semibold">
                Feedback
            </div>
            <div class="mx-[30px] mt-5 h-[380px] border w-10/12 p-4 border-blue rounded">
                <div>
                    {{$feedback->syll_dean_feedback_text}}
                </div>
            </div>
            <div class="flex justify-end mt-2">
                <button id="closeModalButton2" class="bg-blue px-3 py-2 rounded-lg text-white hover:bg-blue3">Done</button>
            </div>
        </div>
    </div>
    @elseif($syll->chair_submitted_at != null && $syll->dean_submitted_at != null && $syll->status == 'Approved by Chair')
    <div class="flex flex-col border-2 border-green3 bg-white bg-opacity-75 w-[500px] rounded-lg h-[85px] mt-2 mx-auto">
        <div class="flex items-center justify-center">
            <div class="mx-1">
                <svg fill="#73d693" width="40px" height="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <title>notice1</title>
                    <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zM15.5 10c-0.828 0-1.5 0.671-1.5 1.5v5.062c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-5.062c0-0.829-0.672-1.5-1.5-1.5zM15.5 20c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5 1.5-0.672 1.5-1.5-0.672-1.5-1.5-1.5z"></path>
                </svg>
            </div>
            <div class="mt-1">
                <span class="font-semibold">Notice:</span>This syllabus has already been approved by the chair and is awaiting dean approval; further edits are no longer permitted.
            </div>
        </div>
    </div>
    @elseif($syll->dean_approved_at != null && $syll->status == 'Approved by Dean')
    <div class="flex flex-col border-2 border-green3 bg-white bg-opacity-75 w-[500px] rounded-lg h-[70px] mt-2 mx-auto">
        <div class="flex items-center justify-center">
            <div class="mx-1">
                <svg fill="#73d693" width="40px" height="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <title>notice1</title>
                    <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zM15.5 10c-0.828 0-1.5 0.671-1.5 1.5v5.062c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-5.062c0-0.829-0.672-1.5-1.5-1.5zM15.5 20c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5 1.5-0.672 1.5-1.5-0.672-1.5-1.5-1.5z"></path>
                </svg>
            </div>
            <div class="mt-1">
                <span class="font-semibold">Notice:</span>This syllabus has already been <span class="font-semibold text-green">approved</span> by the chair and the dean; further edits are no longer permitted.
            </div>
        </div>
    </div>
    @endif
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
                                        <livewire:BL-Comment-Modal :syll_co_id="$co->syll_co_id" />
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
                                        {!! nl2br(e($cot->syll_allotted_hour)) !!} hours
                                        <div>
                                            {!! nl2br(e($cot->syll_allotted_time)) !!} 
                                        </div>
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
                                        <livewire:BL-Cot-M-Comment :syll_co_out_id="$cot->syll_co_out_id" />
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
                                    <td class="border-2 border-solid p-2">
                                        {!! nl2br(e($cotf->syll_allotted_hour)) !!} hours
                                        <div>
                                            {!! nl2br(e($cotf->syll_allotted_time)) !!} 
                                        </div>
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
                                        <livewire:BL-Cot-F-Comment :syll_co_out_id="$cotf->syll_co_out_id" />
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
            @foreach ($instructors[$syll->syll_id] ?? [] as $key => $instructor)
            <div>
                @if($syll->chair_submitted_at != null)
                <div class="flex justify-center mt-20">
                    sgd
                </div>
                @else
                <div class="flex justify-center mt-20">

                </div>
                @endif
                <div class="flex justify-center font-semibold underline">
                    {{ strtoupper($instructor->prefix) }} {{ strtoupper($instructor->firstname) }} {{ strtoupper($instructor->lastname) }} {{ strtoupper($instructor->suffix) }}
                </div>
                <div class="flex justify-center">
                    Instructor
                </div>
            </div>
            @endforeach
        </div>
        <div>
            <div class="flex justify-center">
                Checked and Recommended for Approval:
            </div>
            @if($syll->dean_submitted_at != null)
            <div class="flex justify-center mt-20">
                sgd
            </div>
            @else
            <div class="flex justify-center mt-20">

            </div>
            @endif
            <div class="flex justify-center font-semibold underline">
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
            @if($syll->dean_approved_at != null)
            <div class="flex justify-center mt-20">
                sgd
            </div>
            @else
            <div class="flex justify-center mt-20">

            </div>
            @endif
            <div class="flex justify-center font-semibold underline">
                {{ strtoupper($syll->syll_dean) }}
            </div>
            <div class="flex justify-center">
                Dean, {{$syll->college_code}}
            </div>
        </div>
    </div>
    </td>
    </table>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var rejectButton = document.getElementById("viewFeedback");
            var feedbackModal = document.querySelector(".view-feedback-modal");
            var overlay = document.getElementById("overlay");

            rejectButton.addEventListener("click", function() {
                feedbackModal.style.display = "block";
                overlay.style.display = "block";
            });

            // Close modal functionality
            var closeModalButton2 = document.getElementById("closeModalButton2");

            closeModalButton2.addEventListener("click", function() {
                feedbackModal.style.display = "none";
                overlay.style.display = "none";
            });
            var closeModalButton2 = document.getElementById("closeModalButton2");

            closeModalButton.addEventListener("click", function() {
                feedbackModal.style.display = "none";
                overlay.style.display = "none";
            });
        });
    </script>
</body>

</html>
@endsection