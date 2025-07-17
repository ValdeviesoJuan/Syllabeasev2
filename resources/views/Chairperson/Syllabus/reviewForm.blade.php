@extends('layouts.chairSidebarPlain')
@section('content')
@include('layouts.modal')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyllabEase</title>
    @vite('resources/css/app.css')
    <style>
        body {
            background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain;
        }
    </style>
    <link rel="stylesheet" href="/css/review_form.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/Sample/se.png') }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body class="mt-14 flex"> 
    <div class="m-auto justify-center flex mb-4 ml-36">
        <button id="checkAllYesButton" class="ml text-lg justify-end p-1 rounded text-white shadow mb-1 px-4 bg-[#4ade80] hover:scale-105 transition ease-in-out">Check All Yes</button>
    </div>
    <div class="flex flex overflow-auto mx-1">
        <div id="" class="mr-5 syllabus h-screen rounded-tl-xl bg-white w-[50%] overflow-auto ">
            <div className="flex flex-col w-full bg-red-200 h-[1000px]">
                <!-- OUTER CONTAINER -->
    <div class="mx-auto mt-6 w-11/12 border-[3px] border-black bg-white font-serif text-sm p-4">
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
                        FM-USTP-ACAD-12
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
                    <td class="border border-gray-400 px-2 py-1">01</td>
                    <td class="border border-gray-400 px-2 py-1">03.01.23</td>
                    <td class="border border-gray-400 px-2 py-1">1 of 2</td>
                </tr>
            </tbody>
        </table>
    </div>


        </div>
    </div>
                <table class="mt-2 mx-auto border-2 border-solid w-10/12 font-serif text-sm bg-white">
                    <!-- 1st Header -->
                    <tr>
                        <th colspan="1" class="font-medium border-2 border-solid px-4">
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
                                            </tr>
                                            @endforeach

                                            <tr class="border-2 border-solid p-2">
                                                <th colspan=10 class="border-2 border-solid font-medium px-4">
                                                    MIDTERM EXAMINATION
                                                </th>
                                            </tr>
                                            @foreach($courseOutlinesFinals as $cotf)
                                            <tr class="border-2 border-solid p-2">
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
            </div>
        </div>

        <div id="review_form" class="rounded-xl overflow-auto w-[50%] flex flex-col border  justify-center border-gray3  bg-white bg-opacity-100  rounded shadow-lg font-sans">
            <div class="h-screen justify-center items-center mx-1">
                <div class="flex justify-center items-center mt-5">
                    <div class="text-3xl font-bold mb-5 mt-5">SYLLABUS REVIEW FORM</div>
                </div>
                <div class="bg-white bg-white bg-opacity-100">
                    <div>
                        <p class="mb-5">
                            <span class="font-semibold ">Directions:</span> Check the column <span class="font-semibold">YES</span> if an indicator is observed in the syllabus and check column NO if otherwise. Provide clear and constructive remarks that would help improve the content and alignment of the syllabus.
                        </p>
                    </div>
                    <form action="{{ route('chairperson.returnSyllabus', $syll_id) }}" method="POST">
                        <table id="review_form_table">
                            @csrf
                            <thead class="bg-red-500">
                                <tr class="">
                                    <th class="w-[600px] p-4">INDICATORS</th>
                                    <th>YES</th>
                                    <th>NO</th>
                                    <th class="w-[200px]">REMARKS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr colspan-3 class="part">
                                    <td class="font-bold">PART I. BASIC SYLLABUS INFORMATION</td>
                                </tr>
                                <tr class="review-row">
                                    <input type="hidden" name="srf_no[]" value='1'>
                                    <td>1. The syllabus follows the prescribed OBE syllabus format of the University and include the following:</td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="yes h-6 w-6" type="checkbox" value="1"></td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="no h-6 w-6" type="checkbox" value="0"></td>
                                    <td class=""><textarea name="srf_remarks[]" class="remarks" id="" cols="30" rows="3" placeholder="Please input remarks here..."></textarea></td>
                                </tr>
                                <!-- 1.1  -->
                                <tr class="review-row">
                                    <input type="hidden" name="srf_no[]" value='2'>
                                    <td class="ones">• Name of the College/Campus is indicated below the University name/brand.</td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="yes h-6 w-6" type="checkbox" value="1"></td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="no h-6 w-6" type="checkbox" value="0"></td>
                                    <td class=""><textarea name="srf_remarks[]" class="remarks" id="" cols="30" rows="3" placeholder="Please input remarks here..."></textarea></td>
                                </tr>
                                <!-- 1.2  -->
                                <tr class="review-row">
                                    <input type="hidden" name="srf_no[]" value='3'>
                                    <td class="ones">• Program, Course Title, Course Code and Unit Credits are specified in the syllabus.</td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="yes h-6 w-6" type="checkbox" value="1"></td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="no h-6 w-6" type="checkbox" value="0"></td>
                                    <td class=""><textarea name="srf_remarks[]" class="remarks" id="" cols="30" rows="3" placeholder="Please input remarks here..."></textarea></td>
                                </tr>
                                <!-- 1.3  -->
                                <tr class="review-row">
                                    <input type="hidden" name="srf_no[]" value='4'>
                                    <td class="ones">• Pre-requisites and co-requisites are indicated.</td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="yes h-6 w-6" type="checkbox" value="1"></td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="no h-6 w-6" type="checkbox" value="0"></td>
                                    <td class=""><textarea name="srf_remarks[]" class="remarks" id="" cols="30" rows="3" placeholder="Please input remarks here..."></textarea></td>
                                </tr>
                                <!-- 1.4  -->
                                <tr class="review-row">
                                    <input type="hidden" name="srf_no[]" value="5">
                                    <td class="ones">• Semester, Academic Year, Schedule of Course, Building and Room Number are stipulated in the syllabus.</td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="yes h-6 w-6" type="checkbox" value="1"></td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="no h-6 w-6" type="checkbox" value="0"></td>
                                    <td class=""><textarea name="srf_remarks[]" class="remarks" id="" cols="30" rows="3" placeholder="Please input remarks here..."></textarea></td>
                                </tr>
                                <!-- 1.5  -->
                                <tr class="review-row">
                                    <input type="hidden" name="srf_no[]" value="6">
                                    <td class="ones">• Contact details of the instructor such as the instructor’s name, email address OR mobile number (optional) are specified in the syllabus.</td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="yes h-6 w-6" type="checkbox" value="1"></td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="no h-6 w-6" type="checkbox" value="0"></td>
                                    <td class=""><textarea name="srf_remarks[]" class="remarks" id="" cols="30" rows="3" placeholder="Please input remarks here..."></textarea></td>
                                </tr>
                                <!-- 1.6  -->
                                <tr class="review-row">
                                    <input type="hidden" name="srf_no[]" value="7">
                                    <td class="ones">• Instructor’s consultation schedules, oﬃce or consultation venue, oﬃce phone number is indicated in the syllabus.</td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="yes h-6 w-6" type="checkbox" value="1"></td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="no h-6 w-6" type="checkbox" value="0"></td>
                                    <td class=""><textarea name="srf_remarks[]" class="remarks" id="" cols="30" rows="3" placeholder="Please input remarks here..."></textarea></td>
                                </tr>
                                <!-- 1.7  -->
                                <tr class="review-row">
                                    <input type="hidden" name="srf_no[]" value="8">
                                    <td class="ones">• The University’s Vision and Mission are indicated in the syllabus.</td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="yes h-6 w-6" type="checkbox" value="1"></td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="no h-6 w-6" type="checkbox" value="0"></td>
                                    <td class=""><textarea name="srf_remarks[]" class="remarks" id="" cols="30" rows="3" placeholder="Please input remarks here..."></textarea></td>
                                </tr>

                                <!-- 2  -->
                                <tr class="review-row">
                                    <input type="hidden" name="srf_no[]" value="9">
                                    <td class="">2. The course description stipulates its relevance to the curriculum in general and provides an overview of the course content.</td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="yes h-6 w-6" type="checkbox" value="1"></td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="no h-6 w-6" type="checkbox" value="0"></td>
                                    <td class=""><textarea name="srf_remarks[]" class="remarks" id="" cols="30" rows="3" placeholder="Please input remarks here..."></textarea></td>
                                </tr>

                                <tr class="part">
                                    <td colspan="4" class="font-bold">PART II. PROGRAM EDUCATIONAL OBJECTIVES (or General Outcomes for Gen Ed courses)</td>
                                </tr>
                                <!-- 3  -->
                                <tr class="review-row">
                                    <input type="hidden" name="srf_no[]" value="10">
                                    <td class="">3. The Approved Program Educational Objectives (PEO) and Program Outcomes (PO) are listed with alphabets in the syllabus (which will be referred to in the mapping of the course outcomes).</td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="yes h-6 w-6" type="checkbox" value="1"></td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="no h-6 w-6" type="checkbox" value="0"></td>
                                    <td class=""><textarea name="srf_remarks[]" class="remarks" id="" cols="30" rows="3" placeholder="Please input remarks here..."></textarea></td>
                                </tr>


                                <tr colspan-3 class="part">
                                    <td class="font-bold">PART III. COURSE OUTCOMES</td>
                                </tr>
                                <!-- 4  -->
                                <tr class="review-row">
                                    <input type="hidden" name="srf_no[]" value="11">
                                    <td class="">4. The course outcomes are measurable and aligned with the course description and program outcomes.</td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="yes h-6 w-6" type="checkbox" value="1"></td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="no h-6 w-6" type="checkbox" value="0"></td>
                                    <td class=""><textarea name="srf_remarks[]" class="remarks" id="" cols="30" rows="3" placeholder="Please input remarks here..."></textarea></td>
                                </tr>
                                <!-- 5  -->
                                <tr class="review-row">
                                    <input type="hidden" name="srf_no[]" value="12">
                                    <td class="">5. The course outcomes are mapped accordingly to the program outcomes/GELOs using the markers: i - introductory, e - enabling, and d - demonstrative.</td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="yes h-6 w-6" type="checkbox" value="1"></td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="no h-6 w-6" type="checkbox" value="0"></td>
                                    <td class=""><textarea name="srf_remarks[]" class="remarks" id="" cols="30" rows="3" placeholder="Please input remarks here..."></textarea></td>
                                </tr>

                                <tr colspan-3 class="part">
                                    <td class="font-bold">PART IV. COURSE OUTLINE</td>
                                </tr>
                                <!-- 6  -->
                                <tr class="review-row">
                                    <input type="hidden" name="srf_no[]" value="13">
                                    <td class="">6. The course outline indicates the number of hours.</td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="yes h-6 w-6" type="checkbox" value="1"></td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="no h-6 w-6" type="checkbox" value="0"></td>
                                    <td class=""><textarea name="srf_remarks[]" class="remarks" id="" cols="30" rows="3" placeholder="Please input remarks here..."></textarea></td>
                                </tr>
                                <!-- 7  -->
                                <tr class="review-row">
                                    <input type="hidden" name="srf_no[]" value="14">
                                    <td class="">7. Topics are assigned to intended learning outcomes (ILO).</td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="yes h-6 w-6" type="checkbox" value="1"></td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="no h-6 w-6" type="checkbox" value="0"></td>
                                    <td class=""><textarea name="srf_remarks[]" class="remarks" id="" cols="30" rows="3" placeholder="Please input remarks here..."></textarea></td>
                                </tr>
                                <!-- 8  -->
                                <tr class="review-row">
                                    <input type="hidden" name="srf_no[]" value="15">
                                    <td class="">8. Suggested readings are provided.</td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="yes h-6 w-6" type="checkbox" value="1"></td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="no h-6 w-6" type="checkbox" value="0"></td>
                                    <td class=""><textarea name="srf_remarks[]" class="remarks" id="" cols="30" rows="3" placeholder="Please input remarks here..."></textarea></td>
                                </tr>
                                <!-- 9  -->
                                <tr class="review-row">
                                    <input type="hidden" name="srf_no[]" value="16">
                                    <td class="">9. The Teaching-Learning Activities (TLAs) are indicated in the outline.</td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="yes h-6 w-6" type="checkbox" value="1"></td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="no h-6 w-6" type="checkbox" value="0"></td>
                                    <td class=""><textarea name="srf_remarks[]" class="remarks" id="" cols="30" rows="3" placeholder="Please input remarks here..."></textarea></td>
                                </tr>
                                <!-- 10  -->
                                <tr class="review-row">
                                    <input type="hidden" name="srf_no[]" value="17">
                                    <td class="">10. Assessment tools are indicated.</td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="yes h-6 w-6" type="checkbox" value="1"></td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="no h-6 w-6" type="checkbox" value="0"></td>
                                    <td class=""><textarea name="srf_remarks[]" class="remarks" id="" cols="30" rows="3" placeholder="Please input remarks here..."></textarea></td>
                                </tr>
                                <!-- 11  -->
                                <tr class="review-row">
                                    <input type="hidden" name="srf_no[]" value="18">
                                    <td class="">11. Rubrics are attached for all outputs/requirements.</td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="yes h-6 w-6" type="checkbox" value="1"></td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="no h-6 w-6" type="checkbox" value="0"></td>
                                    <td class=""><textarea name="srf_remarks[]" class="remarks" id="" cols="30" rows="3" placeholder="Please input remarks here..."></textarea></td>
                                </tr>
                                <!-- 12  -->
                                <tr class="review-row">
                                    <input type="hidden" name="srf_no[]" value="19">
                                    <td class="">12. The grading criteria are clearly stated in the syllabus.</td>
                                    <td class="checkbox-cell"><input name="srf_yes_no[]" class="yes h-6 w-6" type="checkbox" value="1"></td>
                                    <td class="checkbox-cell"> <input name="srf_yes_no[]" class="no h-6 w-6" type="checkbox" value="0"></td>
                                    <td class=""><textarea name="srf_remarks[]" class="remarks" id="" cols="30" rows="3" placeholder="Please input remarks here..."></textarea></td>
                                </tr>
                            </tbody>
                    </table>
                </div>
                <!-- <form wire:submit.prevent="returnSyllabus" method="POST"> -->
                <div class="mt-10 flex space-x-4 justify-center items-center">
                    <input type="hidden" wire:model="syll_id">
                    <div id="revisionBtn" class="py-2 px-2 mb-8 bg-pink text-red w-[150px] h-14 rounded flex justify-center items-center ">
                        <button class="revisionBtn" type="submit">
                            <div class="flex space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23px" height="23px" viewBox="0 0 64 64" stroke-width="5" stroke="#fb6a5e" fill="none">
                                    <path d="M54.89,26.73A23.52,23.52,0,0,1,15.6,49" stroke-linecap="round" />
                                    <path d="M9,37.17a23.75,23.75,0,0,1-.53-5A23.51,23.51,0,0,1,48.3,15.2" stroke-linecap="round" />
                                    <polyline points="37.73 16.24 48.62 15.44 47.77 5.24" stroke-linecap="round" />
                                    <polyline points="25.91 47.76 15.03 48.56 15.88 58.76" stroke-linecap="round" />
                                </svg>
                                <div>For Revision</div>
                            </div>
                        </button>
                    </div>
                    </form>
                    <!-- </form> -->
                    <form action="{{ route('chairperson.approveSyllabus', $syll_id) }}" method="POST" class="m-0">
                        @csrf
                        @method('PUT')
                        <input type="hidden" wire:model="syll_id">
                        <div style="display:none" id="submitBtn" class="py-2 mb-8 px-2 bg-green2 text-green w-[150px] h-14 rounded flex justify-center items-center">
                            <button class="submitBtn" type="submit">
                                <div class="flex space-x-3">
                                    <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 12.6111L8.92308 17.5L20 6.5" stroke="#31a858" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div>
                                        Approve
                                    </div>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
    $(document).ready(function () {
        function checkCheckbox() {
            let allYesChecked = $('.yes').length > 0 && $('.yes:checked').length === $('.yes').length;
            let anyNoChecked = $('.no:checked').length > 0;

            if (allYesChecked && !anyNoChecked) {
                $('#submitBtn').show();
                $('#revisionBtn').hide();
            } else {
                $('#submitBtn').hide();
                $('#revisionBtn').show();
            }
        }

        $('input[name="srf_yes_no[]"]').on('change', function () {
            var row = $(this).closest('tr');

            if ($(this).hasClass('yes') && $(this).prop('checked')) {
                row.find('input.no').prop('checked', false);
            } else if ($(this).hasClass('no') && $(this).prop('checked')) {
                row.find('input.yes').prop('checked', false);
            }

            checkCheckbox(); 
        });

        $('#checkAllYesButton').on('click', function () {
            $('.no').prop('checked', false);
            $('.yes').prop('checked', true);
            checkCheckbox();
        });

        checkCheckbox();

        var form = $('form');
        var rows = $('.review-row');

        form.on('submit', function (e) {
            var isValid = true;

            rows.each(function () {
                var no = $(this).find('.no');
                var remarks = $(this).find('.remarks');

                if (no.prop('checked') && $.trim(remarks.val()) === '') {
                    isValid = false;
                    remarks.addClass('border-solid border-2 border-red placeholder-red').attr('placeholder', 'Please input remarks here');
                } else {
                    remarks.removeClass('border-solid border-2 border-red placeholder-red').removeAttr('placeholder');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Please provide remarks for all items marked as "No".');
            }
        });
    });
</script>
</body>

</html>
@endsection