@extends('layouts.chairSidebarSyllabus')
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdn.tiny.cloud/1/ux8hih2n6kvrupg3ywetf1kdoav78vf12hcudnuhz6ftkl0x/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
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
        .force-full-red-border {
            border: 3px solid red !important;
        }
    </style>
</head>

<body class="font-thin mt-14">
    <!-- Pending Chair Review -->
    @if($syll->chair_submitted_at != null && $syll->dean_submitted_at == null && $syll->chair_rejected_at == null)
    <div class="flex justify-end mr-28">
        <form action="{{ route('chairperson.reviewForm', $syll_id) }}" method="get">
            @csrf
            <button wire:click="openComments" class=" rounded bg-green2 text-green px-3 py-3">
                <div class="flex">
                    <div class="mr-2">
                        <svg width="20px" height="20px" viewBox="0 -0.5 28 28" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-154.000000, -621.000000)" fill="#31a858">
                                    <path d="M168,624.695 L179.2,641.99 L156.8,641.99 L168,624.695 L168,624.695 Z M156.014,643.995 L180.018,643.995 C182.375,643.995 182.296,642.608 181.628,641.574 L169.44,622.555 C168.882,621.771 167.22,621.703 166.56,622.555 L154.372,641.574 C153.768,642.703 153.687,643.995 156.014,643.995 L156.014,643.995 Z M181,645.998 L155,645.998 C154.448,645.998 154,646.446 154,646.999 C154,647.552 154.448,648 155,648 L181,648 C181.552,648 182,647.552 182,646.999 C182,646.446 181.552,645.998 181,645.998 L181,645.998 Z" id="open" sketch:type="MSShapeGroup">
                                    </path>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="font-sans text">Open Syllabus Review Form</span>
                </div>
            </button>
        </form>
    </div>
    <!-- Approved by Chair -->
    @elseif($syll->dean_submitted_at != null && $syll->chair_submitted != null && $syll->chair_rejected_at == null && $syll->status == 'Approved by Chair')
    <div class="flex flex-col border-2 border-[#28a745] bg-[#d4edda] bg-opacity-80 w-[500px] rounded-lg h-[85px] mt-2 mx-auto">
        <div class="flex items-center justify-center">
            <div class="mx-2">
                <svg fill="#28a745" width="40px" height="40px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5z"/>
                    <path d="M13.5 15.5l2 2 4-4-1.5-1.5-2.5 2.5-0.5-0.5z"/>
                </svg>
            </div>
            <div class="mt-1 text-[#155724]">
                <span class="font-semibold">Notice:</span> This syllabus has been <strong>approved by the Chair</strong> and is awaiting Dean approval; further edits are not permitted.
            </div>
        </div>
    </div>
    <!-- Returned by Chair -->
    @elseif($syll->chair_submitted_at != null && $syll->chair_rejected_at != null && $syll->status == 'Returned by Chair')
    <div class="flex flex-col border-2 border-[#007bff] bg-[#cce5ff] bg-opacity-80 w-[500px] rounded-lg h-[110px] mt-2 mx-auto">
        <div class="flex items-center justify-center">
            <div class="mx-2">
                <svg fill="#007bff" width="40px" height="40px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 0C7.163 0 0 7.163 0 16s7.163 16 16 16 16-7.163 16-16S24.837 0 16 0zM18 22h-4v-4h4v4zm0-6h-4V8h4v8z"/>
                </svg>
            </div>
            <div class="mt-1 text-[#004085]">
                <span class="font-semibold">Notice:</span> This syllabus has been <strong>returned by the Chair</strong> for further revisions.
            </div>
        </div>
        <div class="flex mt-2 mx-auto">
            <form action="{{ route('chairperson.viewReviewForm', $syll_id) }}" method="get">
                @csrf
                <button type="submit" class="px-4 py-2 text-[#007bff] border border-[#007bff] font-bold rounded hover:bg-[#007bff] hover:text-white transition">
                    View Review Form
                </button>
            </form>
        </div>
    </div>
    <!-- Returned by Dean -->
    @elseif($syll->dean_submitted_at != null && $syll->dean_rejected_at != null && $syll->status == 'Returned by Dean')
    <div class="flex flex-col border-2 border-[#007bff] bg-[#cce5ff] bg-opacity-80 w-[500px] rounded-lg h-[110px] mt-2 mx-auto">
        <div class="flex items-center justify-center">
            <div class="mx-2">
                <svg fill="#007bff" width="40px" height="40px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 0C7.163 0 0 7.163 0 16c0 8.837 7.163 16 16 16s16-7.163 16-16C32 7.163 24.837 0 16 0zM18 22h-4v-4h4v4zm0-6h-4V8h4v8z"/>
                </svg>
            </div>
            <div class="mt-1 text-[#004085]">
                <span class="font-semibold">Notice:</span> This syllabus has been <strong>returned by the Dean</strong> for further revision.
            </div>
        </div>
        <div class="flex mt-2 mx-auto">
            <button id="viewFeedback" type="submit" class="px-4 py-2 text-[#007bff] border border-[#007bff] font-bold rounded hover:bg-[#007bff] hover:text-white transition">
                View Feedback
            </button>
        </div>
    </div>
    <div class="hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white  rounded-lg shadow-lg view-feedback-modal">
        <div class="mt-5 flex flex-col justify-center items-center">
            <div class="text-lg font-semibold">
                Dean's Feedback
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
    <!-- Approved by Dean -->
    @elseif($syll->dean_approved_at != null && $syll->status == 'Approved by Dean')
        <div class="flex flex-col bg-white bg-opacity-75 w-[500px] rounded-lg h-[70px] mt-2 mx-auto"
            style="border: 2px solid #6ee7b7;">
            <div class="flex items-center justify-center">
                <div class="mx-1">
                    <svg fill="#73d693" width="40px" height="40px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                        <title>notice1</title>
                        <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zM15.5 10c-0.828 0-1.5 0.671-1.5 1.5v5.062c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-5.062c0-0.829-0.672-1.5-1.5-1.5zM15.5 20c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5 1.5-0.672 1.5-1.5-0.672-1.5-1.5-1.5z"></path>
                    </svg>
                </div>
                <div class="mt-1">
                    <span class="font-semibold">Notice:</span> This syllabus has already been
                    <span class="font-semibold" style="color:#059669;">approved</span> by the Dean;
                    further edits are no longer permitted.
                </div>
            </div>
        </div>
    @endif
    <!-- OUTER CONTAINER SYLLABUS TABLE-->
    <div class="mx-auto mt-6 w-11/12 border-[3px] border-black bg-white font-serif text-sm p-4 relative">
        @php
            $shouldShowIcon = (isset($srf1) && $srf1['srf_yes_no'] === 'no'); 
            $remarkText = $srf1['srf_remarks'] ?? null;
        @endphp

        @if($shouldShowIcon)
            <div 
                class="absolute -top-2 -right-2 z-100"
                style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
            >
                <div class="relative group">
                    <!-- Icon -->
                    <button 
                        class="text-[#d3494e] hover:text-[#b91c1c] rounded-full remark-btn"
                        title="View remark"
                    >
                        <i class="fa-solid fa-message text-xl"></i>
                    </button>

                    <!-- Bubble -->
                    <div class="remark-bubble absolute top-full right-0 mt-2 w-72 max-w-xs bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50 hidden">
                        <!-- Arrow -->
                        <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                    border-l-transparent border-r-transparent border-b-white"></div>

                        <!-- Feedback label -->
                        <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                        <!-- Feedback content -->
                        <p class="text-center text-gray leading-snug text-[14px] mb-4">
                            {{ $remarkText ?? 'No remarks provided.' }}
                        </p>

                        <!-- Button container -->
                        <div class="flex justify-end">
                            <button class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition close-remark">
                                OKAY
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- HEADER SECTION -->
        <br>
        <div class="flex justify-center items-start mb-4">
        <!-- OUTER FLEX CONTAINER -->
            <div class="flex justify-between items-start w-full max-w-5xl">
            
                <!-- LEFT: Logo + Campus Info -->
                <div class="flex items-start space-x-4 w-[70%]">
                    <!-- Logo with left shift -->
                    <div >
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

        <!-- SYLLABUS TABLE-->
        <table class="mt-2 mx-auto border-2 border-solid w-10/12 font-serif text-sm bg-white {{ isset($srf1) && $srf1['srf_yes_no'] === 'no' ? 'force-full-red-border': '' }}">
            <!-- 1st Header -->
            <tr>
                <th colspan="2" class="font-medium border-1 border-solid px-4 relative {{ isset($srf2) && $srf2['srf_yes_no'] === 'no' ? 'force-full-red-border': '' }}">
                    <span class="font-bold">{{$syll->college_description}}</span><br>
                    {{$syll->department_name}}

                    @php
                        $shouldShowIcon = (isset($srf2) && $srf2['srf_yes_no'] === 'no'); 
                        $remarkText = $srf2['srf_remarks'] ?? null;
                    @endphp

                    @if($shouldShowIcon)
                        <div 
                            class="absolute -top-2 -right-2 z-100"
                            style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                        >
                            <div class="relative group">
                                <!-- Icon -->
                                <button 
                                    class="text-[#d3494e] hover:text-[#b91c1c] rounded-full remark-btn"
                                    title="View remark"
                                >
                                    <i class="fa-solid fa-message text-xl"></i>
                                </button>

                                <!-- Bubble -->
                                <div class="remark-bubble absolute top-full right-0 mt-2 w-72 max-w-xs bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50 hidden">
                                    <!-- Arrow -->
                                    <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                                border-l-transparent border-r-transparent border-b-white"></div>

                                    <!-- Feedback label -->
                                    <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                                    <!-- Feedback content -->
                                    <p class="text-center text-gray leading-snug text-[14px] mb-4">
                                        {{ $remarkText ?? 'No remarks provided.' }}
                                    </p>

                                    <!-- Button container -->
                                    <div class="flex justify-end">
                                        <button class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition close-remark">
                                            OKAY
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </th>

                <th class="font-medium border-2 border-solid text-left px-4 w-2/6 relative {{ isset($srf3) && $srf3['srf_yes_no'] === 'no' ? 'force-full-red-border': '' }}">
                    <span class="font-bold underline underline-offset-4">Syllabus<br></span>
                    Course Title :<span class="font-bold">{{$syll->course_title}}<br></span>
                    Course Code: {{$syll->course_code}}<br>
                    Credits: {{$syll->course_credit_unit}} units ({{$syll->course_unit_lec}} hours lecture, {{$syll->course_unit_lab}} hrs Laboratory)<br>
                    @php
                        $shouldShowIcon = (isset($srf3) && $srf3['srf_yes_no'] === 'no'); 
                        $remarkText = $srf3['srf_remarks'] ?? null;
                    @endphp

                    @if($shouldShowIcon)
                        <div 
                            class="absolute -top-2 -right-2 z-100"
                            style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                        >
                            <div class="relative group">
                                <!-- Icon -->
                                <button 
                                    class="text-[#d3494e] hover:text-[#b91c1c] rounded-full remark-btn"
                                    title="View remark"
                                >
                                    <i class="fa-solid fa-message text-xl"></i>
                                </button>

                                <!-- Bubble -->
                                <div class="remark-bubble absolute top-full right-0 mt-2 w-72 max-w-xs bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50 hidden">
                                    <!-- Arrow -->
                                    <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                                border-l-transparent border-r-transparent border-b-white"></div>

                                    <!-- Feedback label -->
                                    <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                                    <!-- Feedback content -->
                                    <p class="text-center text-gray leading-snug text-[14px] mb-4">
                                        {{ $remarkText ?? 'No remarks provided.' }}
                                    </p>

                                    <!-- Button container -->
                                    <div class="flex justify-end">
                                        <button class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition close-remark">
                                            OKAY
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </th>
            </tr>
            <!-- 2nd Header -->
            <tr class="">
                <td class="border-2 border-solid font-medium  text-sm text-left px-4 text-justify align-top relative {{ isset($srf8) && $srf8['srf_yes_no'] === 'no' || isset($srf10) && $srf10['srf_yes_no'] === 'no' ? 'force-full-red-border': '' }}">
                    <!-- VISION -->
                    <div class="mt-2 mb-8">
                        <span class="font-bold">USTP Vision<br><br></span>
                        <p>The University is a nationally recognized Science and Technology University providing the vital link between education and the economy.</p>
                        @php
                            $shouldShowIcon = (isset($srf8) && $srf8['srf_yes_no'] === 'no'); 
                            $remarkText = $srf8['srf_remarks'] ?? null;
                        @endphp

                        @if($shouldShowIcon)
                            <div 
                                class="absolute -top-2 -right-2 z-100"
                                style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                            >
                                <div class="relative group">
                                    <!-- Icon -->
                                    <button 
                                        class="text-[#d3494e] hover:text-[#b91c1c] rounded-full remark-btn"
                                        title="View remark"
                                    >
                                        <i class="fa-solid fa-message text-xl"></i>
                                    </button>

                                    <!-- Bubble -->
                                    <div class="remark-bubble absolute top-full right-0 mt-2 w-72 max-w-xs bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50 hidden">
                                        <!-- Arrow -->
                                        <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                                    border-l-transparent border-r-transparent border-b-white"></div>

                                        <!-- Feedback label -->
                                        <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                                        <!-- Feedback content -->
                                        <p class="text-center text-gray leading-snug text-[14px] mb-4">
                                            {{ $remarkText ?? 'No remarks provided.' }}
                                        </p>

                                        <!-- Button container -->
                                        <div class="flex justify-end">
                                            <button class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition close-remark">
                                                OKAY
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <!-- MISSION -->
                    <div class="mb-8 relative">
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
                    <div class="mb-8 relative">
                        <span class="font-bold">Program Educational Objectives<br><br></span>
                        @foreach($poes as $poe)
                        <div class="mb-2">
                            <p><span class="font-semibold">{{$poe->poe_code}}: </span>{{$poe->poe_description}}</p>
                        </div>
                        @endforeach
                        @php
                            $shouldShowIcon = (isset($srf8) && $srf8['srf_yes_no'] === 'no'); 
                            $remarkText = $srf8['srf_remarks'] ?? null;
                        @endphp

                        @if($shouldShowIcon)
                            <div 
                                class="absolute -top-2 -right-2 z-100"
                                style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                            >
                                <div class="relative group">
                                    <!-- Icon -->
                                    <button 
                                        class="text-[#d3494e] hover:text-[#b91c1c] rounded-full remark-btn"
                                        title="View remark"
                                    >
                                        <i class="fa-solid fa-message text-xl"></i>
                                    </button>

                                    <!-- Bubble -->
                                    <div class="remark-bubble absolute top-full right-0 mt-2 w-72 max-w-xs bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50 hidden">
                                        <!-- Arrow -->
                                        <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                                    border-l-transparent border-r-transparent border-b-white"></div>

                                        <!-- Feedback label -->
                                        <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                                        <!-- Feedback content -->
                                        <p class="text-center text-gray leading-snug text-[14px] mb-4">
                                            {{ $remarkText ?? 'No remarks provided.' }}
                                        </p>

                                        <!-- Button container -->
                                        <div class="flex justify-end">
                                            <button class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition close-remark">
                                                OKAY
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
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
                            <td class="border-2 border-solid font-medium text-left px-4 w-1/2 relative {{ isset($srf5) && $srf5['srf_yes_no'] === 'no' ? 'force-full-red-border': '' }}">
                                Semester/Year: {{$syll->course_semester}} SY{{$syll->bg_school_year}}<br>
                                Class Schedule:{!! nl2br(e($syll->syll_class_schedule)) !!}<br>
                                Bldg./Rm. No. {{$syll->syll_bldg_rm}}

                                @php
                                    $shouldShowIcon = (isset($srf5) && $srf5['srf_yes_no'] === 'no'); 
                                    $remarkText = $srf5['srf_remarks'] ?? null;
                                @endphp

                                @if($shouldShowIcon)
                                    <div 
                                        class="absolute -top-2 -right-2 z-100"
                                        style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                    >
                                        <div class="relative group">
                                            <!-- Icon -->
                                            <button 
                                                class="text-[#d3494e] hover:text-[#b91c1c] rounded-full remark-btn"
                                                title="View remark"
                                            >
                                                <i class="fa-solid fa-message text-xl"></i>
                                            </button>

                                            <!-- Bubble -->
                                            <div class="remark-bubble absolute top-full right-0 mt-2 w-72 max-w-xs bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50 hidden">
                                                <!-- Arrow -->
                                                <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                                            border-l-transparent border-r-transparent border-b-white"></div>

                                                <!-- Feedback label -->
                                                <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                                                <!-- Feedback content -->
                                                <p class="text-center text-gray leading-snug text-[14px] mb-4">
                                                    {{ $remarkText ?? 'No remarks provided.' }}
                                                </p>

                                                <!-- Button container -->
                                                <div class="flex justify-end">
                                                    <button class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition close-remark">
                                                        OKAY
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="border-2 border-solid font-medium  text-start text-top px-4 relative {{ isset($srf4) && $srf4['srf_yes_no'] === 'no' ? 'force-full-red-border': '' }}">
                                Pre-requisite(s): {{$syll->course_pre_req}} <br>
                                Co-requisite(s): {{$syll->course_co_req}}

                                @php
                                    $shouldShowIcon = (isset($srf4) && $srf4['srf_yes_no'] === 'no'); 
                                    $remarkText = $srf4['srf_remarks'] ?? null;
                                @endphp

                                @if($shouldShowIcon)
                                    <div 
                                        class="absolute -top-2 -right-2 z-100"
                                        style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                    >
                                        <div class="relative group">
                                            <!-- Icon -->
                                            <button 
                                                class="text-[#d3494e] hover:text-[#b91c1c] rounded-full remark-btn"
                                                title="View remark"
                                            >
                                                <i class="fa-solid fa-message text-xl"></i>
                                            </button>

                                            <!-- Bubble -->
                                            <div class="remark-bubble absolute top-full right-0 mt-2 w-72 max-w-xs bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50 hidden">
                                                <!-- Arrow -->
                                                <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                                            border-l-transparent border-r-transparent border-b-white"></div>

                                                <!-- Feedback label -->
                                                <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                                                <!-- Feedback content -->
                                                <p class="text-center text-gray leading-snug text-[14px] mb-4">
                                                    {{ $remarkText ?? 'No remarks provided.' }}
                                                </p>

                                                <!-- Button container -->
                                                <div class="flex justify-end">
                                                    <button class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition close-remark">
                                                        OKAY
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td class="items-start border-2 border-solid font-medium text-left px-4 relative {{ isset($srf6) && $srf6['srf_yes_no'] === 'no' ? 'force-full-red-border': '' }}">
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

                                @php
                                    $shouldShowIcon = (isset($srf6) && $srf6['srf_yes_no'] === 'no'); 
                                    $remarkText = $srf6['srf_remarks'] ?? null;
                                @endphp

                                @if($shouldShowIcon)
                                    <div 
                                        class="absolute -top-2 -right-2 z-100"
                                        style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                    >
                                        <div class="relative group">
                                            <!-- Icon -->
                                            <button 
                                                class="text-[#d3494e] hover:text-[#b91c1c] rounded-full remark-btn"
                                                title="View remark"
                                            >
                                                <i class="fa-solid fa-message text-xl"></i>
                                            </button>

                                            <!-- Bubble -->
                                            <div class="remark-bubble absolute top-full right-0 mt-2 w-72 max-w-xs bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50 hidden">
                                                <!-- Arrow -->
                                                <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                                            border-l-transparent border-r-transparent border-b-white"></div>

                                                <!-- Feedback label -->
                                                <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                                                <!-- Feedback content -->
                                                <p class="text-center text-gray leading-snug text-[14px] mb-4">
                                                    {{ $remarkText ?? 'No remarks provided.' }}
                                                </p>

                                                <!-- Button container -->
                                                <div class="flex justify-end">
                                                    <button class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition close-remark">
                                                        OKAY
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="border-2 border-solid font-medium text-left px-4 relative {{ isset($srf7) && $srf7['srf_yes_no'] === 'no' ? 'force-full-red-border': '' }}">
                                Consultation Schedule: {!! nl2br(e($syll->syll_ins_consultation)) !!}<br>
                                Bldg rm no: {{$syll->syll_ins_bldg_rm}}
                                

                                @php
                                    $shouldShowIcon = (isset($srf7) && $srf7['srf_yes_no'] === 'no'); 
                                    $remarkText = $srf7['srf_remarks'] ?? null;
                                @endphp

                                @if($shouldShowIcon)
                                    <div 
                                        class="absolute -top-2 -right-2 z-100"
                                        style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                    >
                                        <div class="relative group">
                                            <!-- Icon -->
                                            <button 
                                                class="text-[#d3494e] hover:text-[#b91c1c] rounded-full remark-btn"
                                                title="View remark"
                                            >
                                                <i class="fa-solid fa-message text-xl"></i>
                                            </button>

                                            <!-- Bubble -->
                                            <div class="remark-bubble absolute top-full right-0 mt-2 w-72 max-w-xs bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50 hidden">
                                                <!-- Arrow -->
                                                <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                                            border-l-transparent border-r-transparent border-b-white"></div>

                                                <!-- Feedback label -->
                                                <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                                                <!-- Feedback content -->
                                                <p class="text-center text-gray leading-snug text-[14px] mb-4">
                                                    {{ $remarkText ?? 'No remarks provided.' }}
                                                </p>

                                                <!-- Button container -->
                                                <div class="flex justify-end">
                                                    <button class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition close-remark">
                                                        OKAY
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td colspan=2 class="items-start border-2 border-solid font-medium text-left px-4 relative {{ isset($srf9) && $srf9['srf_yes_no'] === 'no' ? 'force-full-red-border': '' }}">
                                <span class="text-left font-bold">
                                    I. Course Descripion:</span><br>
                                {{ $syll->syll_course_description }}

                                @php
                                    $shouldShowIcon = (isset($srf9) && $srf9['srf_yes_no'] === 'no'); 
                                    $remarkText = $srf9['srf_remarks'] ?? null;
                                @endphp

                                @if($shouldShowIcon)
                                    <div 
                                        class="absolute -top-2 -right-2 z-100"
                                        style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                    >
                                        <div class="relative group">
                                            <!-- Icon -->
                                            <button 
                                                class="text-[#d3494e] hover:text-[#b91c1c] rounded-full remark-btn"
                                                title="View remark"
                                            >
                                                <i class="fa-solid fa-message text-xl"></i>
                                            </button>

                                            <!-- Bubble -->
                                            <div class="remark-bubble absolute top-full right-0 mt-2 w-72 max-w-xs bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50 hidden">
                                                <!-- Arrow -->
                                                <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                                            border-l-transparent border-r-transparent border-b-white"></div>

                                                <!-- Feedback label -->
                                                <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                                                <!-- Feedback content -->
                                                <p class="text-center text-gray leading-snug text-[14px] mb-4">
                                                    {{ $remarkText ?? 'No remarks provided.' }}
                                                </p>

                                                <!-- Button container -->
                                                <div class="flex justify-end">
                                                    <button class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition close-remark">
                                                        OKAY
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        
                        <tr class="">
                            <!-- course_outcome table-->
                            <td colspan=2 class=" border-2 border-solid font-medium px-4 relative {{ isset($srf11) && $srf11['srf_yes_no'] === 'no' ? 'force-full-red-border': '' }}">
                                <span class="text-left font-bold">
                                    II. Course Outcome:</span><br>
                                <table class="m-10 mx-auto border-2 border-solid w-11/12 relative {{ isset($srf12) && $srf12['srf_yes_no'] === 'no' ? 'force-full-red-border': '' }}">
                                    
                                    <tr class="border-2 border-solid relative">
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

                                @php
                                    $remarkText1 = $srf11['srf_remarks'] ?? null;
                                    $remarkText2 = $srf12['srf_remarks'] ?? null;

                                    $shouldShowIcon = 
                                        (isset($srf11) && $srf11['srf_yes_no'] === 'no' && $remarkText1) || 
                                        (isset($srf12) && $srf12['srf_yes_no'] === 'no' && $remarkText2); 
                                @endphp

                                @if($shouldShowIcon)
                                    <div 
                                        class="absolute -top-2 -right-2 z-100"
                                        style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                    >
                                        <div class="relative group">
                                            <!-- Icon -->
                                            <button 
                                                class="text-[#d3494e] hover:text-[#b91c1c] rounded-full remark-btn"
                                                title="View remarks"
                                            >
                                                <i class="fa-solid fa-message text-xl"></i>
                                            </button>

                                            <!-- Bubble -->
                                            <div class="remark-bubble absolute top-full right-0 mt-2 w-80 bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50 hidden">
                                                <!-- Arrow -->
                                                <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                                            border-l-transparent border-r-transparent border-b-white"></div>

                                                <!-- Header -->
                                                <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                                                <!-- Feedback content -->
                                                <div class="space-y-3 text-[14px] text-gray">
                                                    @if($remarkText1)
                                                        <div class="bg-gray-100 p-2 rounded">
                                                            <span class="font-semibold">Section 4:</span><br>
                                                            {{ $remarkText1 }}
                                                        </div>
                                                    @endif

                                                    @if($remarkText2)
                                                        <div class="bg-gray-100 p-2 rounded">
                                                            <span class="font-semibold">Section 5:</span><br>
                                                            {{ $remarkText2 }}
                                                        </div>
                                                    @endif

                                                    @if(!$remarkText1 && !$remarkText2)
                                                        <p class="text-center">No remarks provided.</p>
                                                    @endif
                                                </div>

                                                <!-- Button -->
                                                <div class="flex justify-end mt-4">
                                                    <button class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition close-remark">
                                                        OKAY
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        <!-- course outline tr -->
                        <tr>
                            <td colspan=2 class=" border-2 border-solid font-medium px-4">
                                <span class="text-left font-bold">
                                    III. Course Outline:</span><br>
                                <table class="m-5 mx-auto border-2 border-solid w-">
                                    <tr class="border-2 border-solid">
                                        <th class="border-2 border-solid relative {{ isset($srf13) && $srf13['srf_yes_no'] === 'no' ? 'force-full-red-border': '' }}">
                                            Allotted Time
                                            @php
                                                $shouldShowIcon = (isset($srf13) && $srf13['srf_yes_no'] === 'no'); 
                                                $remarkText = $srf13['srf_remarks'] ?? null;
                                            @endphp

                                            @if($shouldShowIcon)
                                                <div 
                                                    class="absolute -top-2 -right-2 z-100"
                                                    style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                                >
                                                    <div class="relative group">
                                                        <!-- Icon -->
                                                        <button 
                                                            class="text-[#d3494e] hover:text-[#b91c1c] rounded-full remark-btn"
                                                            title="View remark"
                                                        >
                                                            <i class="fa-solid fa-message text-xl"></i>
                                                        </button>

                                                        <!-- Bubble -->
                                                        <div class="remark-bubble absolute top-full right-0 mt-2 w-72 max-w-xs bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50 hidden">
                                                            <!-- Arrow -->
                                                            <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                                                        border-l-transparent border-r-transparent border-b-white"></div>

                                                            <!-- Feedback label -->
                                                            <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                                                            <!-- Feedback content -->
                                                            <p class="text-center text-gray leading-snug text-[14px] mb-4">
                                                                {{ $remarkText ?? 'No remarks provided.' }}
                                                            </p>

                                                            <!-- Button container -->
                                                            <div class="flex justify-end">
                                                                <button class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition close-remark">
                                                                    OKAY
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </th>
                                        <th class="border-2 border-solid relative">
                                            Course Outcomes (C)
                                        </th>
                                        <th class="border-2 border-solid relative {{ isset($srf14) && $srf14['srf_yes_no'] === 'no' ? 'force-full-red-border': '' }}">
                                            Intended Learning Outcome (ILO)
                                            @php
                                                $shouldShowIcon = (isset($srf14) && $srf14['srf_yes_no'] === 'no'); 
                                                $remarkText = $srf14['srf_remarks'] ?? null;
                                            @endphp

                                            @if($shouldShowIcon)
                                                <div 
                                                    class="absolute -top-2 -right-2 z-100"
                                                    style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                                >
                                                    <div class="relative group">
                                                        <!-- Icon -->
                                                        <button 
                                                            class="text-[#d3494e] hover:text-[#b91c1c] rounded-full remark-btn"
                                                            title="View remark"
                                                        >
                                                            <i class="fa-solid fa-message text-xl"></i>
                                                        </button>

                                                        <!-- Bubble -->
                                                        <div class="remark-bubble absolute top-full right-0 mt-2 w-72 max-w-xs bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50 hidden">
                                                            <!-- Arrow -->
                                                            <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                                                        border-l-transparent border-r-transparent border-b-white"></div>

                                                            <!-- Feedback label -->
                                                            <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                                                            <!-- Feedback content -->
                                                            <p class="text-center text-gray leading-snug text-[14px] mb-4">
                                                                {{ $remarkText ?? 'No remarks provided.' }}
                                                            </p>

                                                            <!-- Button container -->
                                                            <div class="flex justify-end">
                                                                <button class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition close-remark">
                                                                    OKAY
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </th>
                                        <th class="border-2 border-solid relative {{ isset($srf14) && $srf14['srf_yes_no'] === 'no' ? 'force-full-red-border': '' }}">
                                            Topics
                                            @php
                                                $shouldShowIcon = (isset($srf14) && $srf14['srf_yes_no'] === 'no'); 
                                                $remarkText = $srf14['srf_remarks'] ?? null;
                                            @endphp

                                            @if($shouldShowIcon)
                                                <div 
                                                    class="absolute -top-2 -right-2 z-100"
                                                    style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                                >
                                                    <div class="relative group">
                                                        <!-- Icon -->
                                                        <button 
                                                            class="text-[#d3494e] hover:text-[#b91c1c] rounded-full remark-btn"
                                                            title="View remark"
                                                        >
                                                            <i class="fa-solid fa-message text-xl"></i>
                                                        </button>

                                                        <!-- Bubble -->
                                                        <div class="remark-bubble absolute top-full right-0 mt-2 w-72 max-w-xs bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50 hidden">
                                                            <!-- Arrow -->
                                                            <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                                                        border-l-transparent border-r-transparent border-b-white"></div>

                                                            <!-- Feedback label -->
                                                            <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                                                            <!-- Feedback content -->
                                                            <p class="text-center text-gray leading-snug text-[14px] mb-4">
                                                                {{ $remarkText ?? 'No remarks provided.' }}
                                                            </p>

                                                            <!-- Button container -->
                                                            <div class="flex justify-end">
                                                                <button class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition close-remark">
                                                                    OKAY
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </th>
                                        <th class="border-2 border-solid relative {{ isset($srf15) && $srf15['srf_yes_no'] === 'no' ? 'force-full-red-border': '' }}">
                                            Suggested Readings
                                            @php
                                                $shouldShowIcon = (isset($srf15) && $srf15['srf_yes_no'] === 'no'); 
                                                $remarkText = $srf15['srf_remarks'] ?? null;
                                            @endphp

                                            @if($shouldShowIcon)
                                                <div 
                                                    class="absolute -top-2 -right-2 z-100"
                                                    style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                                >
                                                    <div class="relative group">
                                                        <!-- Icon -->
                                                        <button 
                                                            class="text-[#d3494e] hover:text-[#b91c1c] rounded-full remark-btn"
                                                            title="View remark"
                                                        >
                                                            <i class="fa-solid fa-message text-xl"></i>
                                                        </button>

                                                        <!-- Bubble -->
                                                        <div class="remark-bubble absolute top-full right-0 mt-2 w-72 max-w-xs bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50 hidden">
                                                            <!-- Arrow -->
                                                            <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                                                        border-l-transparent border-r-transparent border-b-white"></div>

                                                            <!-- Feedback label -->
                                                            <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                                                            <!-- Feedback content -->
                                                            <p class="text-center text-gray leading-snug text-[14px] mb-4">
                                                                {{ $remarkText ?? 'No remarks provided.' }}
                                                            </p>

                                                            <!-- Button container -->
                                                            <div class="flex justify-end">
                                                                <button class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition close-remark">
                                                                    OKAY
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </th>
                                        <th class="border-2 border-solid relative {{ isset($srf16) && $srf16['srf_yes_no'] === 'no' ? 'force-full-red-border': '' }}">
                                            Teaching Learning Activities
                                            @php
                                                $shouldShowIcon = (isset($srf16) && $srf16['srf_yes_no'] === 'no'); 
                                                $remarkText = $srf16['srf_remarks'] ?? null;
                                            @endphp

                                            @if($shouldShowIcon)
                                                <div 
                                                    class="absolute -top-2 -right-2 z-100"
                                                    style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                                >
                                                    <div class="relative group">
                                                        <!-- Icon -->
                                                        <button 
                                                            class="text-[#d3494e] hover:text-[#b91c1c] rounded-full remark-btn"
                                                            title="View remark"
                                                        >
                                                            <i class="fa-solid fa-message text-xl"></i>
                                                        </button>

                                                        <!-- Bubble -->
                                                        <div class="remark-bubble absolute top-full right-0 mt-2 w-72 max-w-xs bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50 hidden">
                                                            <!-- Arrow -->
                                                            <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                                                        border-l-transparent border-r-transparent border-b-white"></div>

                                                            <!-- Feedback label -->
                                                            <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                                                            <!-- Feedback content -->
                                                            <p class="text-center text-gray leading-snug text-[14px] mb-4">
                                                                {{ $remarkText ?? 'No remarks provided.' }}
                                                            </p>

                                                            <!-- Button container -->
                                                            <div class="flex justify-end">
                                                                <button class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition close-remark">
                                                                    OKAY
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </th>
                                        <th class="border-2 border-solid relative {{ isset($srf17) && $srf17['srf_yes_no'] === 'no' ? 'force-full-red-border': '' }}">
                                            Assessment Tasks/Tools
                                            @php
                                                $shouldShowIcon = (isset($srf17) && $srf17['srf_yes_no'] === 'no'); 
                                                $remarkText = $srf17['srf_remarks'] ?? null;
                                            @endphp

                                            @if($shouldShowIcon)
                                                <div 
                                                    class="absolute -top-2 -right-2 z-100"
                                                    style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                                >
                                                    <div class="relative group">
                                                        <!-- Icon -->
                                                        <button 
                                                            class="text-[#d3494e] hover:text-[#b91c1c] rounded-full remark-btn"
                                                            title="View remark"
                                                        >
                                                            <i class="fa-solid fa-message text-xl"></i>
                                                        </button>

                                                        <!-- Bubble -->
                                                        <div class="remark-bubble absolute top-full right-0 mt-2 w-72 max-w-xs bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50 hidden">
                                                            <!-- Arrow -->
                                                            <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                                                        border-l-transparent border-r-transparent border-b-white"></div>

                                                            <!-- Feedback label -->
                                                            <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                                                            <!-- Feedback content -->
                                                            <p class="text-center text-gray leading-snug text-[14px] mb-4">
                                                                {{ $remarkText ?? 'No remarks provided.' }}
                                                            </p>

                                                            <!-- Button container -->
                                                            <div class="flex justify-end">
                                                                <button class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition close-remark">
                                                                    OKAY
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </th>
                                        <th class="border-2 border-solid relative {{ isset($srf19) && $srf19['srf_yes_no'] === 'no' ? 'force-full-red-border': '' }}">
                                            Grading Criteria
                                            @php
                                                $shouldShowIcon = (isset($srf19) && $srf19['srf_yes_no'] === 'no'); 
                                                $remarkText = $srf19['srf_remarks'] ?? null;
                                            @endphp

                                            @if($shouldShowIcon)
                                                <div 
                                                    class="absolute -top-2 -right-2 z-100"
                                                    style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                                >
                                                    <div class="relative group">
                                                        <!-- Icon -->
                                                        <button 
                                                            class="text-[#d3494e] hover:text-[#b91c1c] rounded-full remark-btn"
                                                            title="View remark"
                                                        >
                                                            <i class="fa-solid fa-message text-xl"></i>
                                                        </button>

                                                        <!-- Bubble -->
                                                        <div class="remark-bubble absolute top-full right-0 mt-2 w-72 max-w-xs bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50 hidden">
                                                            <!-- Arrow -->
                                                            <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                                                        border-l-transparent border-r-transparent border-b-white"></div>

                                                            <!-- Feedback label -->
                                                            <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                                                            <!-- Feedback content -->
                                                            <p class="text-center text-gray leading-snug text-[14px] mb-4">
                                                                {{ $remarkText ?? 'No remarks provided.' }}
                                                            </p>

                                                            <!-- Button container -->
                                                            <div class="flex justify-end">
                                                                <button class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition close-remark">
                                                                    OKAY
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </th>
                                        <th class="border-2 border-solid relative">
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
                            <td colspan="2" class="border-2 border-solid font-medium relative {{ isset($srf18) && $srf18['srf_yes_no'] === 'no' ? 'force-full-red-border': '' }}">
                                <span class="text-left font-bold">
                                    IV. Course Requirements:
                                </span><br>
                                <div class="crq">
                                    {!! $syll->syll_course_requirements !!}
                                </div>
                                @php
                                    $shouldShowIcon = (isset($srf18) && $srf18['srf_yes_no'] === 'no'); 
                                    $remarkText = $srf18['srf_remarks'] ?? null;
                                @endphp

                                @if($shouldShowIcon)
                                    <div 
                                        class="absolute -top-2 -right-2 z-100"
                                        style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                    >
                                        <div class="relative group">
                                            <!-- Icon -->
                                            <button 
                                                class="text-[#d3494e] hover:text-[#b91c1c] rounded-full remark-btn"
                                                title="View remark"
                                            >
                                                <i class="fa-solid fa-message text-xl"></i>
                                            </button>

                                            <!-- Bubble -->
                                            <div class="remark-bubble absolute top-full right-0 mt-2 w-72 max-w-xs bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50 hidden">
                                                <!-- Arrow -->
                                                <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                                            border-l-transparent border-r-transparent border-b-white"></div>

                                                <!-- Feedback label -->
                                                <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                                                <!-- Feedback content -->
                                                <p class="text-center text-gray leading-snug text-[14px] mb-4">
                                                    {{ $remarkText ?? 'No remarks provided.' }}
                                                </p>

                                                <!-- Button container -->
                                                <div class="flex justify-end">
                                                    <button class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition close-remark">
                                                        OKAY
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    </table>
                    <div class="grid grid-cols-3 m-3">
                        <div class="">
                            <div class="flex justify-center">
                                Prepared By:
                            </div>
                            @foreach ($instructors[$syll->syll_id] ?? [] as $key => $instructor)
                            <div>
                                @if($syll->chair_submitted_at != null && $instructor->signature)
                                <div class="flex justify-center mt-20">
                                    <img src="{{ asset('assets/signatures/' . $instructor->signature) }}" alt="Instructor Signature" class="h-16 object-contain">
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
                            @if($syll->dean_submitted_at != null && $chair->signature)
                            <div class="flex justify-center mt-5">
                                <img src="{{ asset('assets/signatures/' . $chair->signature) }}" alt="Chair Signature" class="h-16 object-contain">
                            </div>
                            @else
                            <div class="flex justify-center mt-20">

                            </div>
                            @endif
                            <div class="flex justify-center font-semibold underline">
                                {{ strtoupper($syll->syll_chair) }}
                            </div>
                            <div class="flex justify-center">
                                Department Chair
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-center">
                                Approved by:
                            </div>
                            @if($syll->dean_approved_at != null && $dean->signature)
                            <div class="flex justify-center mt-5">
                                <img src="{{ asset('assets/signatures/' . $dean->signature) }}" alt="Dean Signature" class="h-16 object-contain">
                            </div>
                            @else
                            <div class="flex justify-center mt-20">

                            </div>
                            @endif
                            <div class="flex justify-center font-semibold underline">
                                {{ strtoupper($syll->syll_dean) }}
                            </div>
                            <div class="flex justify-center">
                                Dean
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
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
    </script>
    
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
    document.addEventListener("DOMContentLoaded", function () {
        // Handle remark bubble toggle
        document.querySelectorAll(".remark-btn").forEach(btn => {
            btn.addEventListener("click", function () {
                const bubble = this.nextElementSibling;
                bubble?.classList.toggle("hidden");
            });
        });

        document.querySelectorAll(".close-remark").forEach(btn => {
            btn.addEventListener("click", function () {
                this.closest(".remark-bubble")?.classList.add("hidden");
            });
        });
    });
    </script>
    <div id="overlay"></div>
</body>

</html>
@endsection