@extends('layouts.BLsyllabus')
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdn.tiny.cloud/1/ux8hih2n6kvrupg3ywetf1kdoav78vf12hcudnuhz6ftkl0x/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        function handleConfirmation() {
            var confirmation = confirm("Are you sure you want to submit?");
            if (confirmation) {
                document.getElementById("submitForm").submit();
            } else {
                alert("Submission canceled.");
            }
        }
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
            left: 25%;
            margin-left: -60px;
        }
        .tooltip:hover .tooltiptext {
            visibility: visible;
        }
        #ADCO .tooltiptext{
            top: 100%;
        }
        #CO .tooltiptext{
            bottom: 100%;
        }
        #Midterm .tooltiptext{
            top: 90%;
        }
        #EditMid .tooltiptext{
            top: 110%;
        }
        #Final .tooltiptext{
            bottom: 110%;
        }
        #EditFinal .tooltiptext{
            bottom: 110%;
        }
        .revision-highlight {
            background-color: #ffe4e6; /* Light red-pink */
            border: 2px solid #fb6a5e; /* Red border */
        }
        .force-full-red-border {
            border: 3px solid red !important;
        }
        /* Animation for entry */
        @keyframes slideInRight {
            0% {
                opacity: 0;
                transform: translateX(100%);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }
        /* Alert wrapper base */
        .stacked-alert {
            display: none;
            animation: slideInRight 0.5s ease-out;
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
            border-radius: 0.5rem;
        }

        /* Alert Types */
        .alert-warning {
            border-top-color: #f59e0b; /* amber-500 */
            background-color: #fff7ed;
            color: #92400e;
        }

        .alert-success {
            border-top-color: #16a34a; /* green-600 */
            background-color: #ecfdf5;
            color: #065f46;
        }

        .alert-error {
            border-top-color: #dc2626; /* red-600 */
            background-color: #fef2f2;
            color: #991b1b;
        }

        /* Close button */
        .close-alert {
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0 0.5rem;
            transition: color 0.3s ease;
        }
    </style>
</head>

<body class="font-thin ">
    <!-- Pending Chair Review && Returned for Revisions (Chair & Dean) -->
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
                <span class="font-semibold">Notice:</span> This syllabus has already been submitted to the Department Chair, further edits are no longer permitted.
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
                <span class="font-semibold">Notice:</span> This syllabus has been returned by the Department Chair for revisions. 
            </div>
        </div>
        <div class="flex mt-3 mx-auto">
            <div class="">
                <a href="{{ route('bayanihanleader.viewReviewForm', $syll_id) }}" class="m-2 p-2 items-center rounded shadow hover:text-white hover:bg-blue hover:bg-blue text-blue border border-blue">
                    View Syllabus Review Form
                </a>
            </div>
            @if($isLatest)
                <div class="">
                    <a href="{{ route('bayanihanleader.replicateSyllabus', $syll_id) }}" method="post" class="m-2 p-2 items-center rounded shadow hover:text-white hover:bg-blue hover:bg-blue text-blue border border-blue">
                        Replicate Syllabus
                    </a>
                </div>
            @endif
        </div>
    </div>
    <!-- Returned by Dean  -->
    @elseif($syll->dean_submitted_at != null && $syll->dean_rejected_at != null && $syll->status == 'Returned by Dean')
    <div class="flex flex-col border-2 border-blue3 bg-white bg-opacity-75 w-[500px] rounded-lg h-[110px] mt-2 mx-auto">
        <div class="flex items-center justify-center">
            <div class="mx-1">
                <svg fill="#2468d2" width="40px" height="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <title>notice1</title>
                    <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zM15.5 10c-0.828 0-1.5 0.671-1.5 1.5v5.062c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-5.062c0-0.829-0.672-1.5-1.5-1.5zM15.5 20c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5 1.5-0.672 1.5-1.5-0.672-1.5-1.5-1.5z"></path>
                </svg>
            </div>
            <div class="mt-1">
                <span class="font-semibold">Notice:</span> This syllabus has been returned by the Dean for revisions.
            </div>
        </div>
        
        <div class="flex mt-3 mx-auto">
            <div class="">
                <button id="viewFeedback" type="submit" class="p-2 items-center rounded shadow hover:text-white hover:bg-blue hover:bg-blue text-blue border border-blue">View Feedback</button>
                @if($isLatest)
                    <a href="{{ route('bayanihanleader.replicateSyllabus', $syll_id) }}" method="post" class="m-2 p-2 items-center rounded shadow hover:text-white hover:bg-blue hover:bg-blue text-blue border border-blue">
                        Replicate Syllabus
                    </a>
                @endif
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
                    {{$feedback->syll_dean_feedback_text }}
                </div>
            </div>
            <div class="flex justify-end mt-2">
                <button id="closeModalButton2" class="bg-blue px-3 py-2 rounded-lg text-white hover:bg-blue3">Done</button>
            </div>
        </div>
    </div>
    <!-- Approved by Chair -->
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
                <span class="font-semibold">Notice:</span>This syllabus has already been approved by the Chair and is awaiting Dean approval; further edits are no longer permitted.
            </div>
        </div>
    </div>
    <!-- Approved by Dean -->
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
                <span class="font-semibold">Notice:</span> This syllabus has already been <span class="font-semibold text-green">approved</span> by the chair and the dean; further edits are no longer permitted.
            </div>
        </div>
    </div>
    @else
    <div class="ml-32 my-5 ">
        <div class="flex flex-row space-x-4">
            <div class="bg-blue py-2 px-3 text-white rounded shadow-lg hover:scale-105 transition ease-in-out">
                <form action="{{ route('bayanihanleader.editSyllabus', $syll_id) }}" method="GET">
                    @csrf
                    <div class="tooltip">
                        <div class="flex items-center space-x-2 ">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <button type="submit" class="btn btn-primary">Edit Syllabus Header</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- course outcome -->
            <div class="relative parent inline-block w-fit hover:bg-blue2 bg-white py-2 px-3 text-white rounded shadow-lg">
                <a class="text-blue space-x-2 ">
                    <div class="flex items-center space-x-2">
                        <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 9.5H21M3 14.5H21M8 4.5V19.5M6.2 19.5H17.8C18.9201 19.5 19.4802 19.5 19.908 19.282C20.2843 19.0903 20.5903 18.7843 20.782 18.408C21 17.9802 21 17.4201 21 16.3V7.7C21 6.5799 21 6.01984 20.782 5.59202C20.5903 5.21569 20.2843 4.90973 19.908 4.71799C19.4802 4.5 18.9201 4.5 17.8 4.5H6.2C5.0799 4.5 4.51984 4.5 4.09202 4.71799C3.71569 4.90973 3.40973 5.21569 3.21799 5.59202C3 6.01984 3 6.57989 3 7.7V16.3C3 17.4201 3 17.9802 3.21799 18.408C3.40973 18.7843 3.71569 19.0903 4.09202 19.282C4.51984 19.5 5.07989 19.5 6.2 19.5Z" stroke="#1148b1" stroke-width="2" />
                        </svg>
                        <span>Course Outcome</span>
                        <svg width="25px" height="25px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path d="M12 15l-4.243-4.243 1.415-1.414L12 12.172l2.828-2.829 1.415 1.414z" stroke="#1148b1" />
                            </g>
                        </svg>
                    </div>
                </a>
                <div class="rounded-b-lg ">
                    <ul class="z-50 absolute w-full min-w-max parent:w-full bg-white md:absolute top-full right-0 rounded-b-lg shadow-2xl pl-4 pt-1 child transition duration-300">
                        <li class="text-blue pb-4 pt-4 hover:text-sePrimary">
                            <div class="">
                                <form action="{{ route('bayanihanleader.createCo', $syll_id) }}" method="GET">
                                    @csrf
                                    <div id="ADCO" class="tooltip">
                                    <div class="flex items-center space-x-2">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" />
                                            <path d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                        <button type="submit" class="btn btn-primary">Add Course Outcome</button>
                                        <span class="tooltiptext font-sans text-xs">Define what students will achieve, e.g., "Apply analytical skills to solve complex problems".</span>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </li>
                        <li class="text-blue pb-4 hover:text-sePrimary">
                            <div class="">
                                <form action="{{ route('bayanihanleader.editCo', $syll_id) }}" method="GET">
                                    @csrf
                                    <div class="flex items-center space-x-2">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <button type="submit" class="btn btn-primary">Edit Course Outcome</button>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <li class="text-blue pb-4 hover:text-sePrimary">
                            <div class="flex items-center space-x-2">
                                <form action="{{ route('bayanihanleader.editCoPo', $syll_id) }}" method="GET">
                                    @csrf
                                    <div id="CO" class="tooltip">
                                    <div class="flex items-center space-x-2">
                                        <svg fill="#1148b1" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 52 52" enable-background="new 0 0 52 52" xml:space="preserve">
                                            <path d="M23.2,10.2C18.1,5.1,10,3.5,2.9,5.7C2.6,5.7,2.2,6.2,2.2,7s0,3,0,3.9c0,0.8,0.7,1,1.1,0.9
                                                c5.4-2.2,12-1.2,16.3,3.3l1.1,1.1c0.6,0.6,0.1,1.7-0.7,1.7h-7.8c-0.8,0-1.5,0.6-1.5,1.5v3c0,0.8,0.6,1.5,1.5,1.5l19.2,0.2
                                                c0.8,0,1.5-0.6,1.5-1.5L33,3.5C33,2.7,32.4,2,31.5,2h-3c-0.8,0-1.6,0.6-1.6,1.4l-0.1,7.9c0,0.8-1.1,1.3-1.7,0.7
                                                C25.2,12.1,23.2,10.2,23.2,10.2z" />
                                            <path d="M3.5,27.8h3c0.8,0,1.5,0.7,1.5,1.5v13.2C8,43.3,8.7,44,9.5,44h33c0.8,0,1.5-0.7,1.5-1.5V16.9
                                                c0-0.8-0.7-1.5-1.5-1.5h-4c-0.8,0-1.5-0.7-1.5-1.5v-3c0-0.8,0.7-1.5,1.5-1.5H46c2.2,0,4,1.8,4,4V46c0,2.2-1.8,4-4,4H6
                                                c-2.2,0-4-1.8-4-4V29.3C2,28.5,2.7,27.8,3.5,27.8z" />
                                        </svg>
                                        <button type="submit" class="btn btn-primary">Assign CO Code</button>
                                        <span class="tooltiptext font-sans text-xs">Determine what course outcomes Code is to be assigned e.g E for Enabling Course</span>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Course outline -->
            <div class="relative parent inline-block w-fit hover:bg-blue2 bg-white py-2 px-3 text-white rounded shadow-lg">
                <a class="text-blue space-x-2 ">
                    <div class="flex items-center space-x-2">
                        <svg fill="#1148b1" width="25px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1801.441 0v1920H219.03v-439.216h-56.514c-31.196 0-56.515-25.299-56.515-56.47 0-31.172 25.319-56.47 56.515-56.47h56.514V1029.02h-56.514c-31.196 0-56.515-25.3-56.515-56.471 0-31.172 25.319-56.47 56.515-56.47h56.514V577.254h-56.514c-31.196 0-56.515-25.299-56.515-56.47 0-31.172 25.319-56.471 56.515-56.471h56.514V0h1582.412Zm-113.03 112.941H332.06v351.373h56.515c31.196 0 56.514 25.299 56.514 56.47 0 31.172-25.318 56.47-56.514 56.47H332.06v338.824h56.515c31.196 0 56.514 25.3 56.514 56.471 0 31.172-25.318 56.47-56.514 56.47H332.06v338.824h56.515c31.196 0 56.514 25.299 56.514 56.47 0 31.172-25.318 56.471-56.514 56.471H332.06v326.275h1356.353V112.94ZM640.289 425.201H1388.9v112.94H640.288v-112.94Zm0 214.83h639.439v112.94h-639.44v-112.94Zm0 534.845H1388.9v112.94H640.288v-112.94Zm0 214.83h639.439v112.94h-639.44v-112.94Z" fill-rule="evenodd" />
                        </svg>
                        <span>Course Outline</span>
                        <svg width="25px" height="25px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path d="M12 15l-4.243-4.243 1.415-1.414L12 12.172l2.828-2.829 1.415 1.414z" stroke="#1148b1" />
                            </g>
                        </svg>
                    </div>
                </a>
                <div class="rounded-b-lg ">
                    <ul class="z-50 absolute w-full min-w-max parent:w-full bg-white md:absolute top-full left-0 rounded-b-lg shadow-2xl pl-4 pt-1 child transition duration-300">
                        <li class="text-blue pb-4 pt-4 hover:text-sePrimary">
                            <div class="">
                                <form action="{{ route('bayanihanleader.createCot', $syll_id) }}" method="GET">
                                    @csrf
                                    <div id="Midterm" class="tooltip">
                                    <div class="flex items-center space-x-2">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" />
                                            <path d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                        <button type="submit" class="btn btn-primary">Add Midterm Course Outline</button>
                                        <span class="tooltiptext font-sans text-xs">Outline the key topics and assessments covered for Midterm, e.g., "4hrs, Week 1-3: Introduction to Programming, Quiz"</span>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </li>
                        <li class="text-yellow pb-4 pt-4 hover:text-sePrimary">
                            <div class="">
                                <form action="{{ route('bayanihanleader.editCotRowM', $syll_id) }}" method="GET">
                                    @csrf
                                    <div id="EditMid" class="tooltip">
                                    <div class="flex items-center space-x-2">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <button type="submit" class="btn btn-primary">Edit Midterm Course Outline Order</button>
                                        <span class="tooltiptext font-sans text-xs">Edit the existing midterm course outline</span>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </li>
                        <li class="text-blue pb-4 pt-4 hover:text-sePrimary">
                            <div class="">
                                <form action="{{ route('bayanihanleader.createCotF', $syll_id) }}" method="GET">
                                    @csrf
                                    <div id="Final" class="tooltip">
                                    <div class="flex items-center space-x-2">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" />
                                            <path d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                        <button type="submit" class="btn btn-primary">Add Final Course Outline</button>
                                        <span class="tooltiptext font-sans text-xs">Outline the key topics and assessments covered for the Final term, e.g., "4hrs, Week 1-3: Introduction to Programming, Quiz/Exam/"</span>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </li>
                        <li class="text-yellow pb-4 pt-4 hover:text-sePrimary">
                            <div class="">
                                <form action="{{ route('bayanihanleader.editCotRowF', $syll_id) }}" method="GET">
                                    @csrf
                                    <div id="EditFinal" class="tooltip">
                                    <div class="flex items-center space-x-2">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <button type="submit" class="btn btn-primary">Edit Final Course Outline Order</button>
                                        <span class="tooltiptext font-sans text-xs">Edit the existing final course outline</span>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Course Requirements -->
            <div class="relative parent inline-block w-fit hover:bg-blue2 bg-white py-2 px-3 text-white rounded shadow-lg">
                <a class="text-blue space-x-2 ">
                    <div class="flex items-center space-x-2">
                        <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 9.5H21M3 14.5H21M8 4.5V19.5M6.2 19.5H17.8C18.9201 19.5 19.4802 19.5 19.908 19.282C20.2843 19.0903 20.5903 18.7843 20.782 18.408C21 17.9802 21 17.4201 21 16.3V7.7C21 6.5799 21 6.01984 20.782 5.59202C20.5903 5.21569 20.2843 4.90973 19.908 4.71799C19.4802 4.5 18.9201 4.5 17.8 4.5H6.2C5.0799 4.5 4.51984 4.5 4.09202 4.71799C3.71569 4.90973 3.40973 5.21569 3.21799 5.59202C3 6.01984 3 6.57989 3 7.7V16.3C3 17.4201 3 17.9802 3.21799 18.408C3.40973 18.7843 3.71569 19.0903 4.09202 19.282C4.51984 19.5 5.07989 19.5 6.2 19.5Z" stroke="#1148b1" stroke-width="2" />
                        </svg>
                        <span>Course Requirements</span>
                        <svg width="25px" height="25px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path d="M12 15l-4.243-4.243 1.415-1.414L12 12.172l2.828-2.829 1.415 1.414z" stroke="#1148b1" />
                            </g>
                        </svg>
                    </div>
                </a>
                <div class="rounded-b-lg ">
                    <ul class="z-50 absolute w-full min-w-max parent:w-full bg-white md:absolute top-full right-0 rounded-b-lg shadow-2xl pl-4 pt-1 child transition duration-300">

                        <li class="text-blue pb-4 pt-4 hover:text-sePrimary">
                            <form action="{{ route('bayanihanleader.createCrq', $syll_id) }}" method="GET">
                                @csrf
                                <div class="flex items-center space-x-2">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <button type="submit" class="btn btn-primary">Edit Course Requirements</button>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Submit  -->
            <div class="relative parent hover:bg-green3 hover:scale-105 text-green bg-green2 py-2 px-3 rounded shadow-lg">
                <a class=" space-x-2 ">
                    <form id="submitForm" action="{{ route('bayanihanleader.submitSyllabus', $syll_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center space-x-2">
                            <svg width="20px" height="20px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M905.92 237.76a32 32 0 0 0-52.48 36.48A416 416 0 1 1 96 512a418.56 418.56 0 0 1 297.28-398.72 32 32 0 1 0-18.24-61.44A480 480 0 1 0 992 512a477.12 477.12 0 0 0-86.08-274.24z" fill="#31a858" />
                                <path d="M630.72 113.28A413.76 413.76 0 0 1 768 185.28a32 32 0 0 0 39.68-50.24 476.8 476.8 0 0 0-160-83.2 32 32 0 0 0-18.24 61.44zM489.28 86.72a36.8 36.8 0 0 0 10.56 6.72 30.08 30.08 0 0 0 24.32 0 37.12 37.12 0 0 0 10.56-6.72A32 32 0 0 0 544 64a33.6 33.6 0 0 0-9.28-22.72A32 32 0 0 0 505.6 32a20.8 20.8 0 0 0-5.76 1.92 23.68 23.68 0 0 0-5.76 2.88l-4.8 3.84a32 32 0 0 0-6.72 10.56A32 32 0 0 0 480 64a32 32 0 0 0 2.56 12.16 37.12 37.12 0 0 0 6.72 10.56zM230.08 467.84a36.48 36.48 0 0 0 0 51.84L413.12 704a36.48 36.48 0 0 0 51.84 0l328.96-330.56A36.48 36.48 0 0 0 742.08 320l-303.36 303.36-156.8-155.52a36.8 36.8 0 0 0-51.84 0z" fill="#31a858" />
                            </svg>
                            <button type="button" class="btn btn-primary" onclick="handleConfirmation()">Submit</button>
                        </div>
                    </form>
                </a>
            </div>
            @if($previousStatus === 'Returned by Chair')
                <!-- Highlight Revisions Toggle -->
                <div class="flex items-center ml-6 text-gray bg-[#f3a71a] hover:bg-[#f3a71a]  px-3 rounded shadow-lg space-x-2 cursor-pointer"> 
                    <input type="checkbox" id="toggleRevisions" class="btn btn-primary"
                            @change="showPrev = $event.target.checked">
                    <label for="toggleRevisions" >Highlight Revisions</label>
                </div>
            @elseif($previousStatus === 'Returned by Dean')
                <!-- Feedback by Dean Button -->
                <button id="viewDeanFeedback" type="button" class="flex items-center ml-6 text-white bg-blue hover:bg-blue-600 px-3 py-2 rounded shadow-lg space-x-2 cursor-pointer border border-blue">
                    View Dean Feedback
                </button>

                <!-- Modal Overlay -->
                <div class="view-dean-feedback-modal hidden fixed inset-0 bg-opacity-30 flex justify-center items-center z-50">
                    <div class="bg-white rounded-lg shadow-lg p-6 w-10/12 max-w-xl">
                        <div class="text-lg font-semibold text-center mb-4">
                            Feedback
                        </div>
                        <div class="border border-blue p-4 mb-4">
                            <div>
                                {{$previousDeanFeedback->syll_dean_feedback_text}}
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <button id="closeModalButton3" class="bg-blue px-3 py-2 rounded-lg text-white hover:bg-blue3">Done</button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif
    
    <!-- OUTER CONTAINER SYLLABUS TABLE -->
    <div class="mx-auto mt-6 w-11/12 border-[3px] border-black bg-white font-serif text-sm p-4 relative">
        @php
            $shouldShowIcon = (isset($srf1) && $srf1['srf_yes_no'] === 'no');
            $showPrev = isset($previousChecklistSRF[1]) && $previousChecklistSRF[1]->srf_yes_no === 'no';
            $remarkText = $srf1['srf_remarks'] ?? ($previousChecklistSRF[1]->srf_remarks ?? null);
        @endphp

        @if($shouldShowIcon || $showPrev)
            <div 
                class="absolute -top-2 -right-2 z-100"
                style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                data-prev-check="{{ $showPrev ? 'no' : 'yes' }}"
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

        <!-- SYLLABUS TABLE -->
        <table x-data="{ showPrev: false }" class="mt-2 mx-auto border-2 border-solid w-10/12 font-serif text-sm bg-white " 
            x-init="
                const toggle = document.getElementById('toggleRevisions');
                toggle.addEventListener('change', () => showPrev = toggle.checked);"
            :class="{
                'force-full-red-border': 
                    {{ isset($srf1) && $srf1['srf_yes_no'] === 'no' ? 'true' : 'false' }} || 
                    (showPrev && {{ isset($previousChecklistSRF[1]) && $previousChecklistSRF[1]->srf_yes_no === 'no' ? 'true' : 'false' }})
            }"
        >

            <!-- 1st Header -->
            <tr>
                <th colspan="2" 
                    :class="{
                        'force-full-red-border': 
                            {{ isset($srf2) && $srf2['srf_yes_no'] === 'no' ? 'true' : 'false' }} || 
                            (showPrev && {{ isset($previousChecklistSRF[2]) && $previousChecklistSRF[2]->srf_yes_no === 'no' ? 'true' : 'false' }})
                    }"
                    class="font-medium border-2 border-solid px-4 relative">
                    <span class="font-bold">{{$syll->college_description}}</span><br>
                    {{$syll->department_name}}
                    @php
                        $shouldShowIcon = (isset($srf2) && $srf2['srf_yes_no'] === 'no');
                        $showPrev = isset($previousChecklistSRF[2]) && $previousChecklistSRF[2]->srf_yes_no === 'no';
                        $remarkText = $srf2['srf_remarks'] ?? ($previousChecklistSRF[2]->srf_remarks ?? null);
                    @endphp

                    @if($shouldShowIcon || $showPrev)
                        <div 
                            class="absolute -top-2 -right-2 z-100"
                            style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                            data-prev-check="{{ $showPrev ? 'no' : 'yes' }}"
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

                <th :class="{
                        'force-full-red-border': 
                            {{ isset($srf3) && $srf3['srf_yes_no'] === 'no' ? 'true' : 'false' }} || 
                            (showPrev && {{ isset($previousChecklistSRF[3]) && $previousChecklistSRF[3]->srf_yes_no === 'no' ? 'true' : 'false' }})
                    }"
                    class="font-medium border-2 border-solid text-left px-4 w-2/6 relative"
                >
                    <span class="font-bold underline underline-offset-4">Syllabus<br></span>
                    Course Title :<span class="font-bold">{{$syll->course_title}}<br></span>
                    Course Code: {{$syll->course_code}}<br>
                    Credits: {{$syll->course_credit_unit}} units ({{$syll->course_unit_lec}} hours lecture, {{$syll->course_unit_lab}} hrs Laboratory)<br>
                    @php
                        $shouldShowIcon = (isset($srf3) && $srf3['srf_yes_no'] === 'no');
                        $showPrev = isset($previousChecklistSRF[3]) && $previousChecklistSRF[3]->srf_yes_no === 'no';
                        $remarkText = $srf3['srf_remarks'] ?? ($previousChecklistSRF[3]->srf_remarks ?? null);
                    @endphp

                    @if($shouldShowIcon || $showPrev)
                        <div 
                            class="absolute -top-2 -right-2 z-100"
                            style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                            data-prev-check="{{ $showPrev ? 'no' : 'yes' }}"
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
                <td :class="{
                        'force-full-red-border': 
                            {{ isset($srf8) && $srf8['srf_yes_no'] === 'no' || isset($srf10) && $srf10['srf_yes_no'] === 'no' ? 'true' : 'false' }} || 
                            (showPrev && {{ isset($previousChecklistSRF[8]) && $previousChecklistSRF[8]->srf_yes_no === 'no' || isset($previousChecklistSRF[10]) && $previousChecklistSRF[10]->srf_yes_no === 'no'? 'true' : 'false' }})
                    }"
                    class="border-2 border-solid font-medium text-sm text-left px-2 text-justify align-top"
                >

                    <!-- VISION -->
                    <div class="mt-2 mb-8 relative">
                        <span class="font-bold">USTP Vision<br><br></span>
                        <p>The University is a nationally recognized Science and Technology University providing the vital link between education and the economy.</p>
                        
                        @php
                            $shouldShowIcon = (isset($srf8) && $srf8['srf_yes_no'] === 'no');
                            $showPrev = isset($previousChecklistSRF[8]) && $previousChecklistSRF[8]->srf_yes_no === 'no';
                            $remarkText = $srf8['srf_remarks'] ?? ($previousChecklistSRF[8]->srf_remarks ?? null);
                        @endphp

                        @if($shouldShowIcon || $showPrev)
                            <div 
                                class="absolute -top-2 -right-2 z-100"
                                style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                data-prev-check="{{ $showPrev ? 'no' : 'yes' }}"
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
                    <div class="mb-8 relative">
                        <span class="font-bold">Program Educational Objectives<br><br></span>
                        @foreach($poes as $poe)
                        <div class="mb-2">
                            <p><span class="font-semibold">{{$poe->poe_code}}: </span>{{$poe->poe_description}}</p>
                        </div>
                        @endforeach
                        
                        @php
                            $shouldShowIcon = (isset($srf10) && $srf10['srf_yes_no'] === 'no');
                            $showPrev = isset($previousChecklistSRF[10]) && $previousChecklistSRF[10]->srf_yes_no === 'no';
                            $remarkText = $srf10['srf_remarks'] ?? ($previousChecklistSRF[10]->srf_remarks ?? null);
                        @endphp

                        @if($shouldShowIcon || $showPrev)
                            <div 
                                class="absolute -top-2 -right-2 z-100"
                                style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                data-prev-check="{{ $showPrev ? 'no' : 'yes' }}"
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
                            <td :class="{
                                    'force-full-red-border': 
                                        {{ isset($srf5) && $srf5['srf_yes_no'] === 'no' ? 'true' : 'false' }} || 
                                        (showPrev && {{ isset($previousChecklistSRF[5]) && $previousChecklistSRF[5]->srf_yes_no === 'no' ? 'true' : 'false' }})
                                }"
                                class="border-2 border-solid font-medium text-left px-4 w-1/2 relative"
                            >
                                Semester/Year: {{$syll->course_semester}} SY{{$syll->bg_school_year}}<br>
                                Class Schedule:{!! nl2br(e($syll->syll_class_schedule)) !!}<br>
                                Bldg./Rm. No. {{$syll->syll_bldg_rm}}
                                
                                @php
                                    $shouldShowIcon = (isset($srf5) && $srf5['srf_yes_no'] === 'no');
                                    $showPrev = isset($previousChecklistSRF[5]) && $previousChecklistSRF[5]->srf_yes_no === 'no';
                                    $remarkText = $srf5['srf_remarks'] ?? ($previousChecklistSRF[5]->srf_remarks ?? null);
                                @endphp

                                @if($shouldShowIcon || $showPrev)
                                    <div 
                                        class="absolute -top-2 -right-2 z-100"
                                        style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                        data-prev-check="{{ $showPrev ? 'no' : 'yes' }}"
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
                            <td :class="{
                                    'force-full-red-border': 
                                        {{ isset($srf4) && $srf4['srf_yes_no'] === 'no' ? 'true' : 'false' }} || 
                                        (showPrev && {{ isset($previousChecklistSRF[4]) && $previousChecklistSRF[4]->srf_yes_no === 'no' ? 'true' : 'false' }})
                                }"
                                class="border-2 border-solid font-medium  text-start text-top px-4 relative"
                            >
                                Pre-requisite(s): {{$syll->course_pre_req}} <br>
                                Co-requisite(s): {{$syll->course_co_req}}
                                
                                @php
                                    $shouldShowIcon = (isset($srf4) && $srf4['srf_yes_no'] === 'no');
                                    $showPrev = isset($previousChecklistSRF[4]) && $previousChecklistSRF[4]->srf_yes_no === 'no';
                                    $remarkText = $srf4['srf_remarks'] ?? ($previousChecklistSRF[4]->srf_remarks ?? null);
                                @endphp

                                @if($shouldShowIcon || $showPrev)
                                    <div 
                                        class="absolute -top-2 -right-2 z-100"
                                        style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                        data-prev-check="{{ $showPrev ? 'no' : 'yes' }}"
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
                            <td :class="{
                                    'force-full-red-border': 
                                        {{ isset($srf6) && $srf6['srf_yes_no'] === 'no' ? 'true' : 'false' }} || 
                                        (showPrev && {{ isset($previousChecklistSRF[6]) && $previousChecklistSRF[6]->srf_yes_no === 'no' ? 'true' : 'false' }})
                                }"
                                class="items-start border-2 border-solid font-medium text-left px-4 relative"
                            >
                                Instructor:
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
                                    $showPrev = isset($previousChecklistSRF[6]) && $previousChecklistSRF[6]->srf_yes_no === 'no';
                                    $remarkText = $srf6['srf_remarks'] ?? ($previousChecklistSRF[6]->srf_remarks ?? null);
                                @endphp

                                @if($shouldShowIcon || $showPrev)
                                    <div 
                                        class="absolute -top-2 -right-2 z-100"
                                        style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                        data-prev-check="{{ $showPrev ? 'no' : 'yes' }}"
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
                            <td :class="{
                                    'force-full-red-border': 
                                        {{ isset($srf7) && $srf7['srf_yes_no'] === 'no' ? 'true' : 'false' }} || 
                                        (showPrev && {{ isset($previousChecklistSRF[7]) && $previousChecklistSRF[7]->srf_yes_no === 'no' ? 'true' : 'false' }})
                                }"
                                class="border-2 border-solid font-medium text-left px-4 relative">
                                Consultation Schedule: {!! nl2br(e($syll->syll_ins_consultation)) !!}<br>
                                Bldg rm no: {{$syll->syll_ins_bldg_rm}}
                                
                                @php
                                    $shouldShowIcon = (isset($srf7) && $srf7['srf_yes_no'] === 'no');
                                    $showPrev = isset($previousChecklistSRF[7]) && $previousChecklistSRF[7]->srf_yes_no === 'no';
                                    $remarkText = $srf7['srf_remarks'] ?? ($previousChecklistSRF[7]->srf_remarks ?? null);
                                @endphp

                                @if($shouldShowIcon || $showPrev)
                                    <div 
                                        class="absolute -top-2 -right-2 z-100"
                                        style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                        data-prev-check="{{ $showPrev ? 'no' : 'yes' }}"
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
                            <td colspan=2 :class="{
                                    'force-full-red-border': 
                                        {{ isset($srf9) && $srf9['srf_yes_no'] === 'no' ? 'true' : 'false' }} || 
                                        (showPrev && {{ isset($previousChecklistSRF[9]) && $previousChecklistSRF[9]->srf_yes_no === 'no' ? 'true' : 'false' }})
                                }"
                                class="items-start border-2 border-solid font-medium text-left px-4 relative"
                            >
                                <span class="text-left font-bold">
                                    I. Course Description:
                                </span><br>
                                {{ $syll->syll_course_description }}
                                
                                @php
                                    $shouldShowIcon = (isset($srf9) && $srf9['srf_yes_no'] === 'no');
                                    $showPrev = isset($previousChecklistSRF[9]) && $previousChecklistSRF[9]->srf_yes_no === 'no';
                                    $remarkText = $srf9['srf_remarks'] ?? ($previousChecklistSRF[9]->srf_remarks ?? null);
                                @endphp

                                @if($shouldShowIcon || $showPrev)
                                    <div 
                                        class="absolute -top-2 -right-2 z-100"
                                        style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                        data-prev-check="{{ $showPrev ? 'no' : 'yes' }}"
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
                            <td colspan=2 :class="{
                                    'force-full-red-border': 
                                        {{ isset($srf11) && $srf11['srf_yes_no'] === 'no' ? 'true' : 'false' }} || 
                                        (showPrev && {{ isset($previousChecklistSRF[11]) && $previousChecklistSRF[11]->srf_yes_no === 'no' ? 'true' : 'false' }})
                                }"
                                class=" border-2 border-solid font-medium px-4 relative"
                            >
                                @php
                                    $shouldShowIcon = (isset($srf11) && $srf11['srf_yes_no'] === 'no' || isset($srf12) && $srf12['srf_yes_no'] === 'no');
                                    $showPrev = (isset($previousChecklistSRF[11]) && $previousChecklistSRF[11]->srf_yes_no === 'no' || isset($previousChecklistSRF[12]) && $previousChecklistSRF[12]->srf_yes_no === 'no');
                                    $remarkText1 = $srf11['srf_remarks'] ?? ($previousChecklistSRF[11]->srf_remarks ?? null);
                                    $remarkText2 = $srf12['srf_remarks'] ?? ($previousChecklistSRF[12]->srf_remarks ?? null);
                                @endphp

                                @if($shouldShowIcon || $showPrev)
                                    <div 
                                        class="absolute -top-2 -right-2 z-100"
                                        style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                        data-prev-check="{{ $showPrev ? 'no' : 'yes' }}"
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

                                                <!-- Feedback content
                                                <p class="text-center text-gray leading-snug text-[14px] mb-4">
                                                    {{ $remarkText ?? 'No remarks provided.' }}
                                                </p> -->

                                                <!-- Feedback content -->
                                                <div class="space-y-3 text-[14px] text-gray">
                                                    @if($remarkText1)
                                                        <div class="bg-gray1 p-2 rounded">
                                                            <span class="font-semibold">Section 4:</span><br>
                                                            {{ $remarkText1 }}
                                                        </div>
                                                    @endif

                                                    @if($remarkText2)
                                                        <div class="bg-gray1 p-2 rounded">
                                                            <span class="font-semibold">Section 5:</span><br>
                                                            {{ $remarkText2 }}
                                                        </div>
                                                    @endif

                                                    @if(!$remarkText1 && !$remarkText2)
                                                        <p class="text-center">No remarks provided.</p>
                                                    @endif
                                                </div>

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
                                <span class="text-left font-bold">
                                    II. Course Outcome:</span><br>
                                <table class="m-10 mx-auto border-2 border-solid w-11/12 relative "
                                    :class="{
                                        'force-full-red-border': 
                                            {{ isset($srf12) && $srf12['srf_yes_no'] === 'no' ? 'true' : 'false' }} || 
                                            (showPrev && {{ isset($previousChecklistSRF[12]) && $previousChecklistSRF[12]->srf_yes_no === 'no' ? 'true' : 'false' }})
                                    }"
                                >
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
                                <span class="text-left font-bold">III. Course Outline:</span> 
                                @php
                                    $midtermTotalHours = 0;
                                    $finalTotalHours = 0;
                                    foreach($courseOutlines as $cot) {
                                        $midtermTotalHours += floatval($cot->syll_allotted_hour);
                                    }
                                    foreach($courseOutlinesFinals as $cotf) {
                                        $finalTotalHours += floatval($cotf->syll_allotted_hour);
                                    }
                                @endphp

                                @if(($syll->status == "Draft" || $syll->status == "Requires Revision (Chair)" || $syll->status == "Requires Revision (Dean)") && $midtermTotalHours > 35 && $midtermTotalHours < 40)
                                    <div data-id="midtermHoursAlert" class="stacked-alert alert-warning fixed top-6 right-6 z-50 px-6 py-6 shadow-md min-w-[320px] flex items-start" role="alert">
                                        <div class="py-1">
                                            <svg class="h-6 w-6 text-amber-500 mr-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-lg">⚠ Warning: High Midterm Course Outline Hour Allocation</p>
                                            <p class="text-base">Total allotted hours ({{ $midtermTotalHours }}) are nearing the 40-hour limit.</p>
                                        </div>
                                        <button class="close-alert text-amber-600 hover:text-amber-700 ml-4">&times;</button>
                                    </div>

                                @elseif(($syll->status == "Draft" || $syll->status == "Requires Revision (Chair)" || $syll->status == "Requires Revision (Dean)") && $midtermTotalHours == 40)
                                    <div data-id="midtermHoursAlert" class="stacked-alert alert-success fixed top-6 right-6 z-50 px-6 py-6 shadow-md min-w-[320px] flex items-start" role="alert">
                                        <div class="py-1">
                                            <svg class="h-6 w-6 text-green-600 mr-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-lg">✔ Midterm Course Outline Hour Allocation Reached</p>
                                            <p class="text-base">Exactly 40 hours allocated for Midterms.</p>
                                        </div>
                                        <button class="close-alert text-green-600 hover:text-green-700 ml-4">&times;</button>
                                    </div>

                                @elseif(($syll->status == "Draft" || $syll->status == "Requires Revision (Chair)" || $syll->status == "Requires Revision (Dean)") && $midtermTotalHours > 40)
                                    <div data-id="midtermHoursAlert" class="stacked-alert alert-error fixed top-6 right-6 z-50 px-6 py-6 shadow-md min-w-[320px] flex items-start" role="alert">
                                        <div class="py-1">
                                            <svg class="h-6 w-6 text-red-500 mr-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-lg">❌ Midterm Course Outline Hour Allocation Exceeded</p>
                                            <p class="text-base">Total hours ({{ $midtermTotalHours }}) exceeded the 40-hour cap. Please adjust.</p>
                                        </div>
                                        <button class="close-alert text-red-600 hover:text-red-700 ml-4">&times;</button>
                                    </div>
                                @endif          
                                @if(($syll->status == "Draft" || $syll->status == "Requires Revision (Chair)" || $syll->status == "Requires Revision (Dean)") && $finalTotalHours > 35 && $finalTotalHours < 40)
                                    <div data-id="finalHoursAlert" class="stacked-alert alert-warning fixed top-6 right-6 z-50 px-6 py-6 shadow-md min-w-[320px] flex items-start" role="alert">
                                        <div class="py-1">
                                            <svg class="h-6 w-6 text-amber-500 mr-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-lg">⚠ Warning: High Final Course Outline Hour Allocation</p>
                                            <p class="text-base">Total allotted hours ({{ $finalTotalHours }}) for Finals are nearing the 40-hour limit.</p>
                                        </div>
                                        <button class="close-alert text-amber-600 hover:text-amber-700 ml-4">&times;</button>
                                    </div>

                                @elseif(($syll->status == "Draft" || $syll->status == "Requires Revision (Chair)" || $syll->status == "Requires Revision (Dean)") && $finalTotalHours == 40)
                                    <div data-id="finalHoursAlert" class="stacked-alert alert-success fixed top-6 right-6 z-50 px-6 py-6 shadow-md min-w-[320px] flex items-start" role="alert">
                                        <div class="py-1">
                                            <svg class="h-6 w-6 text-green-600 mr-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-lg">✔ Finals Course Outline Hour Allocation Reached</p>
                                            <p class="text-base">You’ve allocated exactly 40 hours for Final Course Outlines. </p>
                                        </div>
                                        <button class="close-alert text-green-600 hover:text-green-700 ml-4">&times;</button>
                                    </div>

                                @elseif(($syll->status == "Draft" || $syll->status == "Requires Revision (Chair)" || $syll->status == "Requires Revision (Dean)") && $finalTotalHours > 40)
                                    <div data-id="finalHoursAlert" class="stacked-alert alert-error fixed top-6 right-6 z-50 px-6 py-6 shadow-md min-w-[320px] flex items-start" role="alert">
                                        <div class="py-1">
                                            <svg class="h-6 w-6 text-red-500 mr-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-lg">❌ Finals Course Outline Hours Exceeded</p>
                                            <p class="text-base">You’ve exceeded the 40-hour cap for Final Course Outlines ({{ $finalTotalHours }} hours).</p>
                                        </div>
                                        <button class="close-alert text-red-600 hover:text-red-700 ml-4">&times;</button>
                                    </div>
                                @endif
                                <table class="m-5 mx-auto border-2 border-solid w-">
                                    <tr class="border-2 border-solid">
                                        <th :class="{
                                                'force-full-red-border': 
                                                    {{ isset($srf13) && $srf13['srf_yes_no'] === 'no' ? 'true' : 'false' }} || 
                                                    (showPrev && {{ isset($previousChecklistSRF[13]) && $previousChecklistSRF[13]->srf_yes_no === 'no' ? 'true' : 'false' }})
                                            }"
                                            class="border-2 border-solid relative">
                                            Allotted Time

                                            @php
                                                $shouldShowIcon = (isset($srf13) && $srf13['srf_yes_no'] === 'no');
                                                $showPrev = isset($previousChecklistSRF[13]) && $previousChecklistSRF[13]->srf_yes_no === 'no';
                                                $remarkText = $srf13['srf_remarks'] ?? ($previousChecklistSRF[13]->srf_remarks ?? null);
                                            @endphp

                                            @if($shouldShowIcon || $showPrev)
                                                <div 
                                                    class="absolute -top-2 -right-2 z-100"
                                                    style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                                    data-prev-check="{{ $showPrev ? 'no' : 'yes' }}"
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
                                        <th class="border-2 border-solid">
                                            Course Outcomes (C)
                                        </th>
                                        <th :class="{
                                                'force-full-red-border': 
                                                    {{ isset($srf14) && $srf14['srf_yes_no'] === 'no' ? 'true' : 'false' }} || 
                                                    (showPrev && {{ isset($previousChecklistSRF[14]) && $previousChecklistSRF[14]->srf_yes_no === 'no' ? 'true' : 'false' }})
                                            }"
                                            class="border-2 border-solid relative">
                                            Intended Learning Outcome (ILO)
                                        
                                            @php
                                                $shouldShowIcon = (isset($srf14) && $srf14['srf_yes_no'] === 'no');
                                                $showPrev = isset($previousChecklistSRF[14]) && $previousChecklistSRF[14]->srf_yes_no === 'no';
                                                $remarkText = $srf14['srf_remarks'] ?? ($previousChecklistSRF[14]->srf_remarks ?? null);
                                            @endphp

                                            @if($shouldShowIcon || $showPrev)
                                                <div 
                                                    class="absolute -top-2 -right-2 z-100"
                                                    style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                                    data-prev-check="{{ $showPrev ? 'no' : 'yes' }}"
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
                                        <th :class="{
                                                'force-full-red-border': 
                                                    {{ isset($srf14) && $srf14['srf_yes_no'] === 'no' ? 'true' : 'false' }} || 
                                                    (showPrev && {{ isset($previousChecklistSRF[14]) && $previousChecklistSRF[14]->srf_yes_no === 'no' ? 'true' : 'false' }})
                                            }"
                                            class="border-2 border-solid relative">
                                            Topics

                                            @php
                                                $shouldShowIcon = (isset($srf14) && $srf14['srf_yes_no'] === 'no');
                                                $showPrev = isset($previousChecklistSRF[14]) && $previousChecklistSRF[14]->srf_yes_no === 'no';
                                                $remarkText = $srf14['srf_remarks'] ?? ($previousChecklistSRF[14]->srf_remarks ?? null);
                                            @endphp

                                            @if($shouldShowIcon || $showPrev)
                                                <div 
                                                    class="absolute -top-2 -right-2 z-100"
                                                    style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                                    data-prev-check="{{ $showPrev ? 'no' : 'yes' }}"
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
                                        <th :class="{
                                                'force-full-red-border': 
                                                    {{ isset($srf15) && $srf15['srf_yes_no'] === 'no' ? 'true' : 'false' }} || 
                                                    (showPrev && {{ isset($previousChecklistSRF[15]) && $previousChecklistSRF[15]->srf_yes_no === 'no' ? 'true' : 'false' }})
                                            }"
                                            class="border-2 border-solid relative">
                                            Suggested Readings

                                            @php
                                                $shouldShowIcon = (isset($srf15) && $srf15['srf_yes_no'] === 'no');
                                                $showPrev = isset($previousChecklistSRF[15]) && $previousChecklistSRF[15]->srf_yes_no === 'no';
                                                $remarkText = $srf15['srf_remarks'] ?? ($previousChecklistSRF[15]->srf_remarks ?? null);
                                            @endphp

                                            @if($shouldShowIcon || $showPrev)
                                                <div 
                                                    class="absolute -top-2 -right-2 z-100"
                                                    style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                                    data-prev-check="{{ $showPrev ? 'no' : 'yes' }}"
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
                                        <th :class="{
                                                'force-full-red-border': 
                                                    {{ isset($srf16) && $srf16['srf_yes_no'] === 'no' ? 'true' : 'false' }} || 
                                                    (showPrev && {{ isset($previousChecklistSRF[16]) && $previousChecklistSRF[16]->srf_yes_no === 'no' ? 'true' : 'false' }})
                                            }"
                                            class="border-2 border-solid relative">
                                            Teaching Learning Activities

                                            @php
                                                $shouldShowIcon = (isset($srf16) && $srf16['srf_yes_no'] === 'no');
                                                $showPrev = isset($previousChecklistSRF[16]) && $previousChecklistSRF[16]->srf_yes_no === 'no';
                                                $remarkText = $srf16['srf_remarks'] ?? ($previousChecklistSRF[16]->srf_remarks ?? null);
                                            @endphp

                                            @if($shouldShowIcon || $showPrev)
                                                <div 
                                                    class="absolute -top-2 -right-2 z-100"
                                                    style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                                    data-prev-check="{{ $showPrev ? 'no' : 'yes' }}"
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
                                        <th :class="{
                                                'force-full-red-border': 
                                                    {{ isset($srf17) && $srf17['srf_yes_no'] === 'no' ? 'true' : 'false' }} || 
                                                    (showPrev && {{ isset($previousChecklistSRF[17]) && $previousChecklistSRF[17]->srf_yes_no === 'no' ? 'true' : 'false' }})
                                            }"
                                            class="border-2 border-solid relative">
                                            Assessment Tasks/Tools

                                            @php
                                                $shouldShowIcon = (isset($srf17) && $srf17['srf_yes_no'] === 'no');
                                                $showPrev = isset($previousChecklistSRF[17]) && $previousChecklistSRF[17]->srf_yes_no === 'no';
                                                $remarkText = $srf17['srf_remarks'] ?? ($previousChecklistSRF[17]->srf_remarks ?? null);
                                            @endphp

                                            @if($shouldShowIcon || $showPrev)
                                                <div 
                                                    class="absolute -top-2 -right-2 z-100"
                                                    style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                                    data-prev-check="{{ $showPrev ? 'no' : 'yes' }}"
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
                                        <th :class="{
                                                'force-full-red-border': 
                                                    {{ isset($srf19) && $srf19['srf_yes_no'] === 'no' ? 'true' : 'false' }} || 
                                                    (showPrev && {{ isset($previousChecklistSRF[19]) && $previousChecklistSRF[19]->srf_yes_no === 'no' ? 'true' : 'false' }})
                                            }"
                                            class="border-2 border-solid relative">
                                            Grading Criteria

                                            @php
                                                $shouldShowIcon = (isset($srf19) && $srf19['srf_yes_no'] === 'no');
                                                $showPrev = isset($previousChecklistSRF[19]) && $previousChecklistSRF[19]->srf_yes_no === 'no';
                                                $remarkText = $srf19['srf_remarks'] ?? ($previousChecklistSRF[19]->srf_remarks ?? null);
                                            @endphp

                                            @if($shouldShowIcon || $showPrev)
                                                <div 
                                                    class="absolute -top-2 -right-2 z-100"
                                                    style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                                    data-prev-check="{{ $showPrev ? 'no' : 'yes' }}"
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
                                        @if($syll->chair_submitted_at == null)
                                        <td class="p-2 flex">
                                            <form action="{{ route('bayanihanleader.editCot', ['syll_co_out_id' => $cot->syll_co_out_id, 'syll_id' => $syll_id]) }}" method="GET">
                                                @csrf
                                                <button type="submit" class="p-1"><svg width="20px" height="20px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none">
                                                        <path fill="#000000" fill-rule="evenodd" d="M15.198 3.52a1.612 1.612 0 012.223 2.336L6.346 16.421l-2.854.375 1.17-3.272L15.197 3.521zm3.725-1.322a3.612 3.612 0 00-5.102-.128L3.11 12.238a1 1 0 00-.253.388l-1.8 5.037a1 1 0 001.072 1.328l4.8-.63a1 1 0 00.56-.267L18.8 7.304a3.612 3.612 0 00.122-5.106zM12 17a1 1 0 100 2h6a1 1 0 100-2h-6z" />
                                                    </svg></button>
                                            </form>
                                            <form action="{{ route('bayanihanleader.destroyCot', ['syll_co_out_id' => $cot->syll_co_out_id, 'syll_id' => $syll_id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class=""><svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10 11V17" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M14 11V17" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M4 7H20" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg></button>
                                            </form>
                                        </td>
                                        @endif
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
                                            <!-- {{$cotf->syll_allotted_time}} -->
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
                                        @if($syll->chair_submitted_at == null)
                                        <td class="border-solid p-1 flex">
                                            <form action="{{ route('bayanihanleader.editCotF', ['syll_co_out_id' => $cotf->syll_co_out_id, 'syll_id' => $syll_id]) }}" method="GET">
                                                @csrf
                                                <button type="submit" class="p-1"> <svg width="20px" height="20px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none">
                                                        <path fill="#000000" fill-rule="evenodd" d="M15.198 3.52a1.612 1.612 0 012.223 2.336L6.346 16.421l-2.854.375 1.17-3.272L15.197 3.521zm3.725-1.322a3.612 3.612 0 00-5.102-.128L3.11 12.238a1 1 0 00-.253.388l-1.8 5.037a1 1 0 001.072 1.328l4.8-.63a1 1 0 00.56-.267L18.8 7.304a3.612 3.612 0 00.122-5.106zM12 17a1 1 0 100 2h6a1 1 0 100-2h-6z" />
                                                    </svg></button>
                                            </form>
                                            <form action="{{ route('bayanihanleader.destroyCotF', ['syll_co_out_id' => $cotf->syll_co_out_id, 'syll_id' => $syll_id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class=""><svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10 11V17" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M14 11V17" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M4 7H20" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg></button>
                                            </form>
                                        </td>
                                        @endif
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
                            <td colspan="2" :class="{
                                    'force-full-red-border': 
                                        {{ isset($srf18) && $srf18['srf_yes_no'] === 'no' ? 'true' : 'false' }} || 
                                        (showPrev && {{ isset($previousChecklistSRF[18]) && $previousChecklistSRF[18]->srf_yes_no === 'no' ? 'true' : 'false' }})
                                }"
                                class="border-2 border-solid font-medium relative">
                                <span class="text-left font-bold">
                                    IV. Course Requirements:
                                </span><br>
                                <div class="crq">
                                    {!! $syll->syll_course_requirements !!}
                                </div>
                                
                                @php
                                    $shouldShowIcon = (isset($srf18) && $srf18['srf_yes_no'] === 'no');
                                    $showPrev = isset($previousChecklistSRF[18]) && $previousChecklistSRF[18]->srf_yes_no === 'no';
                                    $remarkText = $srf18['srf_remarks'] ?? ($previousChecklistSRF[18]->srf_remarks ?? null);
                                @endphp

                                @if($shouldShowIcon || $showPrev)
                                    <div 
                                        class="absolute -top-2 -right-2 z-100"
                                        style="{{ !$shouldShowIcon ? 'display: none;' : '' }}"
                                        data-prev-check="{{ $showPrev ? 'no' : 'yes' }}"
                                    >
                                        <div class="relative group">
                                            <!-- Icon -->
                                            <button 
                                                class="remark-btn text-[#d3494e] hover:text-[#b91c1c] rounded-full"
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
                            <div class="flex justify-center text-center">
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
                            <div class="flex justify-center text-center">
                                Dean
                            </div>
                        </div>
                    </div> 
                </td>
            </tr>
        </table>
    </div>
</body>
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
    });
    document.addEventListener("DOMContentLoaded", function() {
        var feedbackButton = document.getElementById("viewDeanFeedback");
        var feedbackModal = document.querySelector(".view-dean-feedback-modal");
        var closeModalButton3 = document.getElementById("closeModalButton3");

        function toggleModal() {
            feedbackModal.classList.toggle("hidden");
        }

        function closeModal() {
            feedbackModal.classList.add("hidden");
        }

        feedbackButton.addEventListener("click", toggleModal);
        closeModalButton3.addEventListener("click", closeModal);

        // Close when clicking outside the modal content
        window.addEventListener("click", function(event) {
            if (event.target === feedbackModal) {
                closeModal();
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
        const toggle = document.getElementById("toggleRevisions");

        toggle?.addEventListener("change", function () {
            const show = toggle.checked;

            document.querySelectorAll("[data-prev-check]").forEach(icon => {
                const srfNo = icon.getAttribute("data-prev-check");
                const shouldShow = srfNo === "no" && show;

                icon.style.display = shouldShow ? "block" : "none";
            });
        });

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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const alerts = Array.from(document.querySelectorAll('.stacked-alert'));
        let currentIndex = 0;

        function showAlert(index) {
            if (index >= alerts.length) return;

            const alert = alerts[index];
            alert.style.display = 'flex';

            // Auto close after 7 seconds
            const timeout = setTimeout(() => {
                alert.style.display = 'none';
                showAlert(index + 1);
            }, 7000);

            // Manual close button
            const closeBtn = alert.querySelector('.close-alert');
            closeBtn.addEventListener('click', () => {
                clearTimeout(timeout);
                alert.style.display = 'none';
                showAlert(index + 1);
            });
        }

        // Hide all alerts initially
        alerts.forEach(alert => alert.style.display = 'none');

        // Start showing the first one
        if (alerts.length > 0) {
            showAlert(0);
        }
    });
</script>

</html>
@endsection