@extends('layouts.AUTos')
@section('content')
@include('layouts.modal')  
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
        <!-- Approved by Chair  -->
        @if($tos->chair_approved_at != null && $tos->tos_status == 'Approved by Chair')
        <div class="flex items-center m-auto justify-center border-2 border-[#22c55e] bg-opacity-75 w-[500px] w-[800px] rounded-lg bg-white py-3 mt-6">
            <div class="mx-1">
                <svg fill="#22c55e" width="40px" height="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <title>notice1</title>
                    <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zM15.5 10c-0.828 0-1.5 0.671-1.5 1.5v5.062c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-5.062c0-0.829-0.672-1.5-1.5-1.5zM15.5 20c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5 1.5-0.672 1.5-1.5-0.672-1.5-1.5-1.5z"></path>
                </svg>
            </div>
            <div class="mt-1">
                <span class="font-semibold">Notice:</span> This TOS has already been <h1 class="inline text-[#22c55e] font-bold">approved</h1> by the Chair; further edits are no longer permitted.
            </div>
        </div>

        <!-- Returned by Chair  -->
        @elseif($tos->chair_returned_at != null && $tos->tos_status == 'Returned by Chair')
        <div class="mt-8 space-y-6 mb-5">
            {{-- Notice Card --}}
            <div class="flex items-start max-w-3xl mx-auto p-5 border-l-4 rounded shadow"
                style="border-color: #dc2626; background-color: #fef2f2;">
                <div class="flex-shrink-0 mt-1">
                    <svg fill="#dc2626" width="36" height="36" viewBox="0 0 32 32">
                        <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zM15.5 10c-0.828 0-1.5 0.671-1.5 1.5v5.062c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-5.062c0-0.829-0.672-1.5-1.5-1.5zM15.5 20c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5 1.5-0.672 1.5-1.5-0.672-1.5-1.5-1.5z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 style="color: #b91c1c; font-weight: 600;">Notice</h2>
                    <p style="color: #991b1b; margin-top: 4px; font-size: 14px;">
                        This TOS has been <span style="font-weight: bold;">returned</span> by the Chair for further revision.
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
        
    <div class="mx-auto shadow-lg pb-20 border border-white bg-white w-[80%]">
        <!-- <div class="flex justify-end ml-12 mt-2 mr-12 pt-14 text-xl font-semibold"> 
            Term Examination: <span class="text-left"style="border-bottom: 2px solid #000; padding-bottom: 4px; width:300px">{{$tos->tos_term}}</span>
        </div> -->

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
                        <div class="-ml-1">
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
                                <td class="border border-gray-400 px-2 py-1">{{ $tos->tos_version }}</td>
                                <td class="border border-gray-400 px-2 py-1">{{ \Carbon\Carbon::parse($tos->effectivity_date)->format('m.d.y') }}</td>
                                <td class="border border-gray-400 px-2 py-1">#</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
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
                <table class="border-2 border-solid w-3/12 font-serif text-sm bg-white">
                    <tr>
                        <th class="text-center font-bold"> COURSE OUTCOMES</th>
                    </tr>
                    <tr>
                        <td class="pt-2 align-top">
                            @foreach($course_outcomes as $co)
                            <p class="p-2"><span class="font-semibold">{{$co->syll_co_code}} : </span>{{$co->syll_co_description}}</p>
                            @endforeach
                        </td>
                    </tr>
                </table>

                <table class="ml-4 border-2 border-solid w-8/12 font-serif text-sm bg-white">
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
                    <div class="mb-10 mt-5">
                        <div class="flex justify-center">
                            @if($tos->chair_submitted_at && $bLeader->signature)
                                <img src="{{ asset('assets/signatures/' . $bLeader->signature) }}" alt="Instructor Signature" class="h-16 object-contain">
                            @endif
                        </div>

                        <div class="flex justify-center font-semibold underline text-center">
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
                        @if($tos->chair_approved_at != null && !empty($chair['signature']))
                            <img src="{{ asset('assets/signatures/' . $chair['signature']) }}" alt="Chairperson Signature" class="h-16 object-contain">
                        @endif
                    </div>

                    <div class="flex justify-center font-semibold underline text-center">
                        {{ strtoupper($chair['full_name'] ?? 'N/A') }}
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