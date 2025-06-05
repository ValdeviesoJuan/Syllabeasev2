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

        table,
        tr,
        td,
        th {
            border: 1px solid;
        }
    </style>
</head>

<body class="mt-[50px]">
    @if($tos->chair_returned_at != null)
    Notice: This TOS has been returned by the chair for further revision.
    @elseif($tos->chair_approved_at != null)
    <div class="flex flex-col items-center justify-center border-2 border-[#22c55e] bg-opacity-75 w-[500px] lg:w-[800px] rounded-lg bg-white py-6 mt-6 mx-auto">
        <div class="flex items-center mb-4">
            <svg fill="#22c55e" width="40px" height="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <title>notice1</title>
                <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zM15.5 10c-0.828 0-1.5 0.671-1.5 1.5v5.062c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-5.062c0-0.829-0.672-1.5-1.5-1.5zM15.5 20c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5 1.5-0.672 1.5-1.5-0.672-1.5-1.5-1.5z"></path>
            </svg>
            <div class="ml-3">
                <span class="font-semibold">Notice:</span> This TOS has already been <h1 class="inline text-[#22c55e] font-bold">approved</h1> by the chair; further edits are no longer permitted.
            </div>
        </div>
        <div class="text-center">
            <a href="{{ route('generateTOSPDF', $tos_id) }}" class="text-blue-600 hover:underline font-bold">
                Export as docx
            </a>
        </div>
    </div>
    @else
    <div class="flex flex-row justify-end h-full items-end mt-10 mb-2 mr-[9.5%]">
        <div class="mx-2 my-2  p-1 bg-green2 rounded justify-center items-center hover:scale-105 w-[200px] h-[47px] shadow-lg">
            <form action="{{ route('chairperson.approveTos', $tos_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to submit this tos version?');">
                @csrf
                @method('PUT')
                <button type="submit" class="ml-[23%] mt-[3px]">
                    <div class="flex items-center justify-center ">
                        <svg width="30px" height="30px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg">
                            <path d="M905.92 237.76a32 32 0 0 0-52.48 36.48A416 416 0 1 1 96 512a418.56 418.56 0 0 1 297.28-398.72 32 32 0 1 0-18.24-61.44A480 480 0 1 0 992 512a477.12 477.12 0 0 0-86.08-274.24z" fill="#31a858" />
                            <path d="M630.72 113.28A413.76 413.76 0 0 1 768 185.28a32 32 0 0 0 39.68-50.24 476.8 476.8 0 0 0-160-83.2 32 32 0 0 0-18.24 61.44zM489.28 86.72a36.8 36.8 0 0 0 10.56 6.72 30.08 30.08 0 0 0 24.32 0 37.12 37.12 0 0 0 10.56-6.72A32 32 0 0 0 544 64a33.6 33.6 0 0 0-9.28-22.72A32 32 0 0 0 505.6 32a20.8 20.8 0 0 0-5.76 1.92 23.68 23.68 0 0 0-5.76 2.88l-4.8 3.84a32 32 0 0 0-6.72 10.56A32 32 0 0 0 480 64a32 32 0 0 0 2.56 12.16 37.12 37.12 0 0 0 6.72 10.56zM230.08 467.84a36.48 36.48 0 0 0 0 51.84L413.12 704a36.48 36.48 0 0 0 51.84 0l328.96-330.56A36.48 36.48 0 0 0 742.08 320l-303.36 303.36-156.8-155.52a36.8 36.8 0 0 0-51.84 0z" fill="#31a858" />
                        </svg>
                        <div class=" m-1 mx-2 text-green  text-center">
                            Approve
                        </div>
                    </div>
                </button>
            </form>
        </div>
        <div class="mx-2 my-2 p-1 bg-pink rounded justify-center items-center hover:scale-105 shadow-lg">
            <form action="{{ route('chairperson.returnTos', $tos_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to return this tos version?');">
                @csrf
                @method('PUT')
                <button type="submit" class="mt-[2px]">
                    <div class="flex items-center justify-center">
                        <svg width="30px" height="30px" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.9998 8L6 14L12.9998 21" stroke="#fb6a5e" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M6 14H28.9938C35.8768 14 41.7221 19.6204 41.9904 26.5C42.2739 33.7696 36.2671 40 28.9938 40H11.9984" stroke="#fb6a5e" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="m-1 mx-2 text-red text-center">
                            Return for Revision
                        </div>
                    </div>
                </button>
            </form>
        </div>
    </div>
    @endif
    <div class="flex flex-col justify-center mb-20 w-screen">
        <div class=" mt-4 mx-auto shadow-lg pb-20 border border-white bg-white w-[80%]">
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

            <div class="flex sticky justify-center ml-12 pt-6 text-3xl font-bold">
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

                <table class="mt-2 w-3/12 font-serif border-2 text-sm bg-white">
                    <tr>
                        <td>
                            <div class="mb-8">
                                <div class="text-center">
                                    <span class="font-bold">COURSE OUTCOMES<br><br></span>
                                </div>
                                @foreach($course_outcomes as $co)
                                <div class="mb-2">
                                    <p><span class="font-semibold p-4">{{$co->syll_co_code}} : </span>{{$co->syll_co_description}}</p>
                                </div>
                                @endforeach
                            </div>
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
                    {{-- @if(count($tos_rows) > 0) --}}
                    @php
                    $total_tos_r_col_1 = 0;
                    $total_tos_r_col_2 = 0;
                    $total_tos_r_col_3 = 0;
                    $total_tos_r_col_4 = 0;

                    @endphp
                    @if(count($tos_rows) > 0)

                    @foreach($tos_rows as $tos_row)
                    <tr>
                        <td class="text-center p-2">{{ $tos_row->tos_r_topic }}</td>
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
                    <tr>
                        <td class="text-right font-bold">Total:</td>
                        <td></td>
                        <td></td>
                        <td class="text-center font-bold p-2">{{$tos->tos_no_items}}</td>
                        <td class="text-center font-bold p-2">{{$total_tos_r_col_1}}</td>
                        <td class="text-center font-bold p-2">{{$total_tos_r_col_2}}</td>
                        <td class="text-center font-bold p-2">{{$total_tos_r_col_3}}</td>
                        <td class="text-center font-bold p-2">{{$total_tos_r_col_4}}</td>
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