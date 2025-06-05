@extends('layouts.BLtos')
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

        table,
        tr,
        td,
        th {
            border: 1px solid;
        }
    </style>
</head>

<body>
    <div class="flex flex-col justify-center mb-[5px]">
        <!-- If submitted na si TOS  -->
        @if($tos->chair_submitted_at != null && $tos->tos_status == 'Pending')
        <div class="">
            <div class="flex items-center m-auto justify-center border-2 border-[#22c55e] bg-opacity-75 w-[500px] w-[800px] rounded-lg bg-white py-3 mt-6">
                <div class="mx-1">
                    <svg fill="#22c55e" width="40px" height="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <title>notice1</title>
                        <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zM15.5 10c-0.828 0-1.5 0.671-1.5 1.5v5.062c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-5.062c0-0.829-0.672-1.5-1.5-1.5zM15.5 20c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5 1.5-0.672 1.5-1.5-0.672-1.5-1.5-1.5z"></path>
                    </svg>
                </div>
                <div class="mt-1">
                    <span class="font-semibold">Notice:</span> Notice: This TOS has already been <h1 class="inline text-[#22c55e] font-bold">submitted</h1> and further edits are no longer permitted.
                </div>

            </div>
            <div class="flex items-center my-2 justify-center">
                <div class="bg-blue py-1 px-3 mx-1 text-white hover:scale-105">
                    <a href="{{ route('bayanihanleader.commentTos', $tos_id) }}">
                        View Comments
                    </a>
                </div>

                <div class="bg-blue py-1 mx-1 px-2 text-white hover:scale-105">
                    <a href="{{route('bayanihanleader.replicateTos', $tos_id)}}">
                        Replicate TOS
                    </a>
                </div>
            </div>

            <!-- If approved na si TOS  -->
            @elseif($tos->chair_approved_at != null && $tos->tos_status == 'Approved by Chair')
            <div class="flex items-center m-auto justify-center border-2 border-[#22c55e] bg-opacity-75 w-[500px] w-[800px] rounded-lg bg-white py-3 mt-6">
                <div class="mx-1">
                    <svg fill="#22c55e" width="40px" height="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <title>notice1</title>
                        <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zM15.5 10c-0.828 0-1.5 0.671-1.5 1.5v5.062c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-5.062c0-0.829-0.672-1.5-1.5-1.5zM15.5 20c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5 1.5-0.672 1.5-1.5-0.672-1.5-1.5-1.5z"></path>
                    </svg>
                </div>
                <div class="mt-1">
                    <span class="font-semibold">Notice:</span> This TOS has already been <h1 class="inline text-[#22c55e] font-bold">approved</h1> by the chair; further edits are no longer permitted.
                </div>
            </div>

        </div>

        <!-- If Gi return si TOS  -->
        @elseif($tos->chair_returned_at != null && $tos->tos_status == 'Returned by Chair')
        <div>
            <div class="flex items-center m-auto justify-center border-2 border-[#22c55e] bg-opacity-75 w-[500px] w-[800px] rounded-lg bg-white py-3 mt-6">
                <div class="mx-1">
                    <svg class="ml-5 mt-2.5" fill="#22c55e" width="40px" height="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <title>notice1</title>
                        <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zM15.5 10c-0.828 0-1.5 0.671-1.5 1.5v5.062c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-5.062c0-0.829-0.672-1.5-1.5-1.5zM15.5 20c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5 1.5-0.672 1.5-1.5-0.672-1.5-1.5-1.5z"></path>
                    </svg>
                </div>
                <div class="mt-1">
                    <span class="font-semibold">Notice:</span>This TOS has been<h1 class="inline text-red font-bold"> returned</h1> by the chair for further revision.
                </div>
            </div>
            <div class="grid mb-3 md:grid-cols-2 mt-6">
                <div class="bg-blue text-white shadow-lg w-[190px] m-auto float-right ml-[78%] h-12 text-center m-autp rounded-lg hover:scale-105 transition ease-in-out">
                    <a href="{{ route('bayanihanleader.commentTos', $tos_id) }}">
                        <svg class="ml-5 mt-2.5" xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24" fill="#FFF">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M20.991 4.8C20.991 3.81 20.19 3 19.2 3H4.8C3.81 3 3 3.81 3 4.8V15.6C3 16.59 3.81 17.4 4.8 17.4H17.4L21 21L20.991 4.8ZM19.2 4.8V16.653L18.147 15.6H4.8V4.8H19.2ZM17.4 12H6.6V13.8H17.4V12ZM6.6 9.3H17.4V11.1H6.6V9.3ZM17.4 6.6H6.6V8.4H17.4V6.6Z" fill="#FFF" />
                        </svg>
                        <div class="-mt-[16%] ml-7">
                            View Comments
                    </a>
                </div>
            </div>
            <div class="bg-blue text-white shadow-lg w-[190px] h-12 text-center m-autp rounded-lg hover:scale-105 transition ease-in-out">
                <svg class="ml-6 mt-2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#FFF" height="28px" width="28px" version="1.1" id="Capa_1" viewBox="0 0 330 330" xml:space="preserve">
                    <g>
                        <path d="M35,270h45v45c0,8.284,6.716,15,15,15h200c8.284,0,15-6.716,15-15V75c0-8.284-6.716-15-15-15h-45V15   c0-8.284-6.716-15-15-15H35c-8.284,0-15,6.716-15,15v240C20,263.284,26.716,270,35,270z M280,300H110V90h170V300z M50,30h170v30H95   c-8.284,0-15,6.716-15,15v165H50V30z" />
                        <path d="M155,120c-8.284,0-15,6.716-15,15s6.716,15,15,15h80c8.284,0,15-6.716,15-15s-6.716-15-15-15H155z" />
                        <path d="M235,180h-80c-8.284,0-15,6.716-15,15s6.716,15,15,15h80c8.284,0,15-6.716,15-15S243.284,180,235,180z" />
                        <path d="M235,240h-80c-8.284,0-15,6.716-15,15c0,8.284,6.716,15,15,15h80c8.284,0,15-6.716,15-15C250,246.716,243.284,240,235,240z   " />
                    </g>
                </svg>
                <a href="{{route('bayanihanleader.replicateTos', $tos_id)}}">
                    <div class="-mt-[13%] ml-6">
                        Replicate TOS
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- If wala pa si all hehe  -->
    @else
    <div class="flex justify-end mx-auto w-[80%]">
        <div class="bg-blue px-2 py-1 hover:scale-105 m-1 text-white">
            <a href="{{ route('bayanihanleader.editTos', ['syll_id' => $tos->syll_id, 'tos_id' => $tos_id]) }}">
                <button class="btn btn-primary">Edit</button>
            </a>
        </div>

        <div class="bg-blue px-2 py-1 hover:scale-105 m-1 text-white">
            <a href="{{ route('bayanihanleader.editTosRow', $tos_id) }}">
                <button class="btn btn-primary">Edit Cognitive Level</button>
            </a>
        </div>
        <form action="{{ route('bayanihanleader.submitTos', $tos_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to submit this tos version?');">
            @csrf
            @method('PUT')
            <div class="bg-green2 px-2 py-1 hover:bg-green3 hover:text-white my-1 ml-1 text-green">
                <button type="submit">
                    Submit
                </button>
            </div>
        </form>
    </div>
    <!-- <div class="flex m-auto space-x-96 -mb-[2%] mt-4 items-center">
        <div class="bg-blue py-3 px-5 text-white rounded-lg shadow-lg hover:scale-105 transition ease-in-out">
            <a href="{{ route('bayanihanleader.editTosRow', $tos_id) }}">
                <div class="flex items-center space-x-2">
                    <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <button class="btn btn-primary">Edit Cognitive Level</button>
                </div>
            </a>
        </div>
    
        <div class="flex space-x-6">
            <div class="bg-blue py-3 px-5 text-white rounded-lg shadow-lg hover:scale-105 transition ease-in-out">
                <a href="{{ route('bayanihanleader.editTos', ['syll_id' => $tos->syll_id, 'tos_id' => $tos_id]) }}">
                    <div class="flex items-center space-x-2">
                        <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <button class="btn btn-primary">Edit</button>
                    </div>
                </a>
            </div>
    
            <form action="{{ route('bayanihanleader.submitTos', $tos_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to submit this tos version?');">
                @csrf
                @method('PUT')
                <div class="flex space-x-12">
                    <button type="submit" class="bg-green2 shadow-lg text-white py-3 px-5 rounded-lg w-[160px] hover:scale-105 transition ease-in-out">
                        <div class="flex items-center space-x-2">

                            <svg width="30px" height="30px" viewBox="0 0 1024 1024" class="icon ml-3" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M905.92 237.76a32 32 0 0 0-52.48 36.48A416 416 0 1 1 96 512a418.56 418.56 0 0 1 297.28-398.72 32 32 0 1 0-18.24-61.44A480 480 0 1 0 992 512a477.12 477.12 0 0 0-86.08-274.24z" fill="#31a858" />
                                <path d="M630.72 113.28A413.76 413.76 0 0 1 768 185.28a32 32 0 0 0 39.68-50.24 476.8 476.8 0 0 0-160-83.2 32 32 0 0 0-18.24 61.44zM489.28 86.72a36.8 36.8 0 0 0 10.56 6.72 30.08 30.08 0 0 0 24.32 0 37.12 37.12 0 0 0 10.56-6.72A32 32 0 0 0 544 64a33.6 33.6 0 0 0-9.28-22.72A32 32 0 0 0 505.6 32a20.8 20.8 0 0 0-5.76 1.92 23.68 23.68 0 0 0-5.76 2.88l-4.8 3.84a32 32 0 0 0-6.72 10.56A32 32 0 0 0 480 64a32 32 0 0 0 2.56 12.16 37.12 37.12 0 0 0 6.72 10.56zM230.08 467.84a36.48 36.48 0 0 0 0 51.84L413.12 704a36.48 36.48 0 0 0 51.84 0l328.96-330.56A36.48 36.48 0 0 0 742.08 320l-303.36 303.36-156.8-155.52a36.8 36.8 0 0 0-51.84 0z" fill="#31a858" />
                            </svg>
                        <div class="text-[#31a858]">Submit</div>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div> -->

    </div>
    @endif
    <div>
    </div>

    <div class="mx-auto shadow-lg pb-20 border border-white bg-white w-[80%]">
        <!-- <div class="flex justify-end ml-12 mt-2 mr-12 pt-14 text-xl font-semibold"> 
            Term Examination: <span class="text-left"style="border-bottom: 2px solid #000; padding-bottom: 4px; width:300px">{{$tos->tos_term}}</span>
        </div> -->


        <div class="flex justify-end ml-12 mt-2 mr-12 pt-14 pl-6 text-xl font-semibold">
            <span style="font-family: 'Roboto', sans-serif; font-weight: bold ">Term Examination: </span>
            <span style="border-bottom: 2px solid #000; padding-bottom: 4px; width:300px" class="ml-2"> {{$tos->tos_term}}</span>
        </div>

        <div class="flex justify-end ml-12 mr-12 pt-1 text-xl font-semibold">
            <span style="font-family: 'Roboto', sans-serif; font-weight: bold ">Course Code: </span>
            <span style="border-bottom: 2px solid #000; padding-bottom: 4px; width:300px" class="ml-2"> {{$tos->course_code}}</span>
        </div>

        <div class="flex justify-end ml-12 mr-12 pt-1 text-xl font-semibold">
            <span style="font-family: 'Roboto', sans-serif; font-weight: bold ">Course Title: </span>
            <span style="border-bottom: 2px solid #000; padding-bottom: 4px; width:300px" class="ml-2"> {{$tos->course_title}}</span>
        </div>

        <!-- 
        <div class="flex justify-end ml-12 mt-2 mr-12 pt-4 text-xl font-semibold"> 
            Course Code: <span class="text-center"style="border-bottom: 2px solid #000; padding-bottom: 4px; width:300px">{{$tos->course_code}}</span>
        </div>

        <div class="flex justify-end ml-12 mt-2 mr-12 pt-2 text-xl font-semibold"> 
            Course Title: <span class="text-center"style="border-bottom: 2px solid #000; padding-bottom: 4px; width:300px">{{$tos->course_title}}</span>
        </div> -->

        <div class="flex justify-center ml-12 pt-6 text-3xl font-bold">
            TABLE OF SPECIFICATION
        </div>

        <div class="flex justify-center ml-12 mt-4 pt-2 text-xl font-semibold">
            <span style="font-family: 'Roboto', sans-serif; font-weight: bold" class="text-center">S.Y.: </span>
            <span style="border-bottom: 2px solid #000; padding-bottom: 4px; width:150px" class="ml-2">{{$tos->bg_school_year}}</span>
            <span style="font-family: 'Roboto', sans-serif; font-weight: bold" class="text-center">Semester: </span>
            <span style="border-bottom: 2px solid #000; padding-bottom: 4px; width:150px" class="ml-2">{{$tos->course_semester}}</span>
        </div>

        <div class="flex justify-left ml-14 pt-4 text-xl font-semibold">
            <span style="font-family: 'Roboto', sans-serif; font-weight: bold "> Curricular Program/Year/Section: </span>
            <span style="border-bottom: 2px solid #000; padding-bottom: 4px; width:200px" class="ml-2">{{$tos->tos_cpys}}</span>
        </div>

        <div class="mt-10 flex justify-center">

            <table class="mt-2 border-2 border-solid w-3/12 font-serif text-sm bg-white">
                <tr>
                    <th class="text-center font-bold"> COURSE OUTCOMES
                    </th>
                </tr>
                <tr>
                    <td class="pt-2 align-top">
                        @foreach($course_outcomes as $co)
                        <p class="p-2"><span class="font-semibold">{{$co->syll_co_code}} : </span>{{$co->syll_co_description}}</p>
                        @endforeach
                    </td>
                </tr>
            </table>

            <table class="mt-2 ml-4 border-2 border-solid w-8/12 font-serif text-sm bg-white">
                <tr>
                    <th rowspan="3">
                        Topics
                    </th>
                    <th rowspan="3">
                        No. of <br> Hours <br> Taught
                    </th>
                    <th rowspan="3">
                        %
                    </th>
                    <th rowspan="3">
                        No. of <br>Test <br>Items
                    </th>
                    <th colspan="4" class="py-2">
                        Cognitive Level
                    </th>
                </tr>
                <tr>
                    <th>
                        Knowledge
                    </th>
                    <th>
                        Comprehension
                    </th>
                    <th>
                        Application/ <br>Analysis
                    </th>
                    <th>
                        Synthesis/ <br> Evaluation
                    </th>
                </tr>
                <tr>
                    <th class="py-2 px-1">{{$tos->col_1_per}}%</th>
                    <th>{{$tos->col_2_per}}%</th>
                    <th>{{$tos->col_3_per}}%</th>
                    <th>{{$tos->col_4_per}}%</th>
                </tr>
                {{-- uncomment disss arasoo? --}}
                {{-- @if(count($tos_rows) > 0) --}}
                @php
                $total_tos_r_no_hours = 0;
                $total_tos_r_percent = 0;
                $total_tos_r_col_1 = 0;
                $total_tos_r_col_2 = 0;
                $total_tos_r_col_3 = 0;
                $total_tos_r_col_4 = 0;

                @endphp


                {{-- tangtanga lang ni if dili mo work sa inyo kay dili ga work ang taas :)) --}}
                @if(count($tos_rows) > 0)

                @foreach($tos_rows as $tos_row)
                <tr>
                    <td class="p-2">{!! nl2br(e($tos_row->tos_r_topic)) !!}</td>
                    <td class="text-center">{{ $tos_row->tos_r_no_hours }}</td>
                    <td class="text-center">{{ $tos_row->tos_r_percent }}</td>
                    <td class="text-center">{{ $tos_row->tos_r_no_items }}</td>
                    <td class="text-center">{{ intval($tos_row->tos_r_col_1) }}</td>
                    <td class="text-center">{{ intval($tos_row->tos_r_col_2) }}</td>
                    <td class="text-center">{{ intval($tos_row->tos_r_col_3) }}</td>
                    <td class="text-center">{{ intval($tos_row->tos_r_col_4) }}</td>
                    <!-- <td>{{ $tos_row->tos_r_col_1 +  $tos_row->tos_r_col_2 + $tos_row->tos_r_col_3 + $tos_row->tos_r_col_4}}</td> -->
                </tr>
                @php
                $total_tos_r_no_hours += $tos_row->tos_r_no_hours;
                $total_tos_r_percent += $tos_row->tos_r_percent;
                $total_tos_r_col_1 += $tos_row->tos_r_col_1;
                $total_tos_r_col_2 += $tos_row->tos_r_col_2;
                $total_tos_r_col_3 += $tos_row->tos_r_col_3;
                $total_tos_r_col_4 += $tos_row->tos_r_col_4;

                @endphp
                @endforeach
                @else
                <tr>
                    <td colspan="8">No data available</td>
                </tr>
                @endif
                <!-- <tr>
                    <td class="text-right font-bold p-2">Total: </td>
                    <td class="text-center font-bold p-2">{{$total_tos_r_no_hours}}</td>
                    <td class="text-center font-bold p-2">{{$total_tos_r_percent}}</td>
                    <td class="text-center font-bold p-2">{{$tos->tos_no_items}}</td>
                    <td class="text-center font-bold p-2">{{$total_tos_r_col_1}}</td>
                    <td class="text-center font-bold p-2">{{$total_tos_r_col_2}}</td>
                    <td class="text-center font-bold p-2">{{$total_tos_r_col_3}}</td>
                    <td class="text-center font-bold p-2">{{$total_tos_r_col_4}}</td>
                </tr> -->
                <tr>
                    <td class="text-right font-bold p-2">Total: </td>
                    <td class="text-center font-bold p-2">{{$total_tos_r_no_hours}}</td>
                    <td class="text-center font-bold p-2">{{$total_tos_r_percent}}</td>
                    <td class="text-center font-bold p-2">{{$tos->tos_no_items}}</td>
                    <td class="text-center font-bold p-2">{{$tos->col_1_exp}}</td>
                    <td class="text-center font-bold p-2">{{$tos->col_2_exp}}</td>
                    <td class="text-center font-bold p-2">{{$tos->col_3_exp}}</td>
                    <td class="text-center font-bold p-2">{{$tos->col_4_exp}}</td>


                </tr>
                <!-- <tr>
                            expected 
                            <td>Total:</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{$expectedCol1 = round($tos->tos_no_items * ($tos->col_1_per / 100))}}</td>
                            <td>{{$expectedCol2 = round($tos->tos_no_items * ($tos->col_2_per / 100))}}</td>
                            <td>{{$expectedCol3 = round($tos->tos_no_items * ($tos->col_3_per / 100))}}</td>
                            <td>{{$expectedCol4 = $tos->tos_no_items - ($expectedCol1 + $expectedCol2 + $expectedCol3)}}</td>
                        </tr> -->
            </table>

        </div>

        <div class="grid grid-cols-4 m-3 font-serif	">
            <div class="flex justify-center items-center">
                <div class="flex justify-center">
                    Prepared by:
                </div>
            </div>
            <div>
                @foreach($bLeaders as $bLeader)
                <div class="mb-10 mt-10">
                    <div class="flex justify-center">
                        @if($tos->chair_submitted_at != null)
                        sgd
                        @endif
                    </div>

                    <div class="flex justify-center font-semibold underline">
                        {{ strtoupper($bLeader->prefix) }} {{ strtoupper($bLeader->firstname) }} {{ strtoupper($bLeader->lastname) }} {{ strtoupper($bLeader->suffix) }}

                    </div>

                    <div class="flex justify-center">
                        Faculty
                    </div>
                </div>
                @endforeach
            </div>


            <div class="flex justify-center items-center">
                <div class="flex justify-center">
                    Approved by:
                </div>
            </div>

            <div class="">
                <div class="flex justify-center items-center mt-10">
                    @if($tos->chair_approved_at != null)
                    sgd
                    @endif
                </div>

                <div class="flex justify-center font-semibold underline">
                    {{ strtoupper($chair->prefix) }} {{ strtoupper($chair->firstname) }} {{ strtoupper($chair->lastname) }} {{ strtoupper($chair->suffix) }}
                </div>

                <div class="flex justify-center">
                    Department Chair
                </div>
            </div>
        </div>





    </div>
    </div>
</body>

</html>
@endsection