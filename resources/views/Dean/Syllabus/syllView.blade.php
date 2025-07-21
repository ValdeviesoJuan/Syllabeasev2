@extends('layouts.deanNav')
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
    <link rel="stylesheet" href="/css/review_form.css">
    <x-head.tinymce-config />
    <script src="https://cdn.tiny.cloud/1/4rknda951knm3s86u3ejsp9j6tfpr5gmgljlkw0ayx2qykdj/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#myeditorinstance',
            plugins: 'code table lists',
            toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });

        function confirmSubmission() {
            var confirmation = confirm("Are you sure you want to submit?");
            if (confirmation) {
                document.getElementById("submiForm").submit();
            }
        }
    </script>
    <style>
        .crq li {
            list-style-type: disc;
            list-style-position: inside;
            padding-left: 40px;
        }

        .mission li {
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

        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .feedback-modal {
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
</head>

<body class="font-thin ">
    @if($syll->dean_submitted_at != null && $syll->dean_rejected_at == null && $syll->status == 'Approved by Chair')
    <div class="flex justify-center">
        <div class="bg-pink py-2 px-3 text-white rounded shadow-lg hover:scale-105 transition ease-in-out mx-2">
            <div class="flex items-center space-x-2 ">
                <svg height="20px" width="20px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32.002 32.002" xml:space="preserve">
                    <g>
                        <g id="undo">
                            <g>
                                <path style="fill:#ff5d9b;" d="M28.157,3.719c-4.957-4.957-13.605-4.961-18.559,0L4.001,9.32V4h-4v12.007h12v-3.92H6.978
				l5.453-5.537c3.445-3.449,9.453-3.449,12.898,0.004c1.723,1.723,2.672,4.012,2.672,6.534c0,2.357-0.949,4.646-2.672,6.373
				l-3.016,3.014l2.828,2.828l3.016-3.008c2.477-2.486,3.844-5.783,3.844-9.207C32.001,9.496,30.634,6.199,28.157,3.719z" />
                                <polygon style="fill:#ff5d9b;" points="18.45,32.002 15.622,29.166 18.45,26.338 21.278,29.166 			" />
                            </g>
                        </g>
                    </g>
                </svg>
                <button id="rejectButton" type="submit" class="btn btn-primary text-pink2">Return for Revision</button>
            </div>
        </div>
        <div class="bg-green2 py-2 px-3 text-white rounded shadow-lg hover:scale-105 transition ease-in-out mx-2">
            <form action="{{ route('dean.approveSyllabus', $syll_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="flex items-center space-x-2 ">
                    <svg fill="#31a858" width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <style>
                                .cls-1 {
                                    fill-rule: evenodd;
                                }
                            </style>
                        </defs>
                        <path id="accept" class="cls-1" d="M1008,120a12,12,0,1,1,12-12A12,12,0,0,1,1008,120Zm0-22a10,10,0,1,0,10,10A10,10,0,0,0,1008,98Zm-0.08,14.333a0.819,0.819,0,0,1-.22.391,0.892,0.892,0,0,1-.72.259,0.913,0.913,0,0,1-.94-0.655l-2.82-2.818a0.9,0.9,0,0,1,1.27-1.271l2.18,2.184,4.46-7.907a1,1,0,0,1,1.38-.385,1.051,1.051,0,0,1,.36,1.417Z" transform="translate(-996 -96)" />
                    </svg>
                    <button type="submit" class="btn btn-primary text-green">Approve</button>
                </div>
            </form>
        </div>
    </div>
    @elseif($syll->dean_rejected_at != null)
    <div class="flex justify-center ">
        <div class="flex flex-col justify-center items-center text-blue bg-white bg-opacity-75 h-[60px] w-[400px] rounded border border-blue3">
            The syllabus has been returned for further revisions.
            <div>
                <button id="viewFeedback" type="submit" class="btn btn-primary text-pink2">View Feedback</button>
            </div>
        </div>
    </div>

    <div class="hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white  rounded-lg shadow-lg view-feedback-modal">
        <div class="mt-5 flex flex-col justify-center items-center">
            <div class="text-lg font-semibold">
                Your Feedback
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
    @elseif($syll->dean_approved_at != null && $syll->status == 'Approved by Dean')
    <div class="flex justify-center ">
        <div class="flex flex-col p-2 justify-center items-center text-green bg-white bg-opacity-75 h-[100px] w-[400px] rounded border border-green">
            The syllabus has been approved for the upcoming semester.
            <div>
                <div>
                    <a href="{{ route('generateSyllabusPDF', $syll_id) }}" class="hover:underline hover:text-blue">Export as docx</a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Feedback modal -->
    <div class="hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white w-[500px] h-[520px] rounded-lg shadow-lg feedback-modal">

        <div class="mt-5">
            <div class="flex flex-row justify-between mx-[50px] mt-5">
                <div class="text-lg font-semibold">
                    Give feedback
                </div>
                <button id="closeModalButton" class="hover:bg-gray3 p-1 rounded-full">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.7457 3.32851C20.3552 2.93798 19.722 2.93798 19.3315 3.32851L12.0371 10.6229L4.74275 3.32851C4.35223 2.93798 3.71906 2.93798 3.32854 3.32851C2.93801 3.71903 2.93801 4.3522 3.32854 4.74272L10.6229 12.0371L3.32856 19.3314C2.93803 19.722 2.93803 20.3551 3.32856 20.7457C3.71908 21.1362 4.35225 21.1362 4.74277 20.7457L12.0371 13.4513L19.3315 20.7457C19.722 21.1362 20.3552 21.1362 20.7457 20.7457C21.1362 20.3551 21.1362 19.722 20.7457 19.3315L13.4513 12.0371L20.7457 4.74272C21.1362 4.3522 21.1362 3.71903 20.7457 3.32851Z" fill="#454545" />
                    </svg>
                </button>
            </div>
            <div class="mx-[50px] text-gray2">
                Could you please provide more information on why the syllabus submission was returned for revision?
            </div>
            <form action="{{ route('dean.returnSyllabus', $syll_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mx-[50px] mt-5 ">
                    <textarea class="resize-none border border-blue  focus:border-blue w-[400px] rounded-lg p-2" name="syll_dean_feedback_text" id="syll_dean_feedback_text" rows="13"></textarea>
                </div>
                <div class="flex justify-end mr-[50px]">
                    <button type="submit" class="bg-blue px-3 py-2 rounded-lg text-white hover:bg-blue3">Submit</button>
                </div>
            </form>
        </div>

    </div>

    </div>

    <!-- OUTER CONTAINER -->
    <div class="mx-auto mt-6 w-11/12 border-[1px] border-black bg-white font-serif text-sm p-4">
    <!-- HEADER SECTION -->
    <br>
    <div class="flex justify-center items-start mb-4">
    <!-- OUTER FLEX CONTAINER -->
    <div class="flex justify-between items-start w-full max-w-5xl">
        
        <!-- LEFT: Logo + Campus Info -->
        <div class="flex items-start space-x-4 w-[70%]">
            <!-- Logo with left shift -->
            <div class="-ml-6">
                <img src="{{ asset('assets/ustplogo.png') }}" alt="USTP Logo" class="w-20 h-auto">
            </div>

            <!-- Text block -->
            <div>
                <h1 class="text-md font-bold uppercase leading-tight ml-11 p-2">
                    University of Science and Technology of Southern Philippines
                </h1>
                <p class="text-sm mt-1 ml-11">
                    Alubijid | Balubal | Cagayan de Oro | Claveria | Jasaan | Oroquieta | Panaon | Villanueva
                </p>
            </div>
        </div>

        <!-- RIGHT: Document Info Table -->
        <table class="text-xs text-center border border-gray-400 ml-20">
            <!-- Top Header Row -->
            <thead>
                <tr class="bg-[#5A6E99] text-white">
                    <th colspan="3" class="border border-gray-400 px-3 py-1 text-xs font-semibold">
                        Document Code No.
                    </th>
                </tr>
            </thead>
            <!-- Document Code -->
            <tbody>
                <tr>
                    <td colspan="3" class="border border-gray-400 py-1 text-sm font-bold text-gray-700">
                        FM-USTP-ACAD-01
                    </td>
                </tr>
                <!-- Sub Headers -->
                <tr class="bg-[#5A6E99] text-white">
                    <td class="border border-gray-400 px-2 py-1 font-medium">Rev. No.</td>
                    <td class="border border-gray-400 px-2 py-1 font-medium">Effective Date</td>
                    <td class="border border-gray-400 px-2 py-1 font-medium">Page No.</td>
                </tr>
                <!-- Data Row -->
                <tr>
                    <td class="border border-gray-400 px-2 py-1">{{ $syll->version }}</td>
                    <td class="border border-gray-400 px-2 py-1">{{ \Carbon\Carbon::parse($syll->effectivity_date)->format('m.d.y') }}</td>
                    <td class="border border-gray-400 px-2 py-1">#</td>
                </tr>
            </tbody>
        </table>

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
                        <td colspan=2 class=" border-2 border-solid font-medium px-4">
                            <span class="text-left font-bold">
                                II. Course Outcome:</span><br>
                            <table class="m-10 mx-auto border-2 border-solid w-11/12">
                                <tr class="border-2 border-solid">
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
                                <tr class="border-2 border-solid">
                                    <td class="w-64 text-left font-medium px-2"><span class="font-bold">{{$co->syll_co_code}} : </span>{{$co->syll_co_description}}</td>
                                    @foreach($programOutcomes as $po)
                                    <td class="border-2 border-solid font-medium text-center py-1">
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
                        <td colspan=2 class=" border-2 border-solid font-medium px-4">
                            <span class="text-left font-bold">
                                III. Course Outline:</span><br>
                            <table class="m-5 mx-auto border-2 border-solid w-">
                                <tr class="border-2 border-solid">
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
                                <tr class="border-2 border-solid">
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
                                </tr>
                                @endforeach

                                <tr class="border-2 border-solid p-2">
                                    <th colspan=10 class="border-2 border-solid font-medium px-4">
                                        MIDTERM EXAMINATION
                                    </th>
                                </tr>
                                @foreach($courseOutlinesFinals as $cotf)
                                <tr class="border-2 border-solid p-2">
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
            var rejectButton = document.getElementById("rejectButton");
            var feedbackModal = document.querySelector(".feedback-modal");
            var overlay = document.getElementById("overlay");

            rejectButton.addEventListener("click", function() {
                feedbackModal.style.display = "block";
                overlay.style.display = "block";
            });

            // Close modal functionality
            var closeModalButton = document.getElementById("closeModalButton");

            closeModalButton.addEventListener("click", function() {
                feedbackModal.style.display = "none";
                overlay.style.display = "none";
            });
        });
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
    <div id="overlay"></div>
</body>

</html>
@endsection