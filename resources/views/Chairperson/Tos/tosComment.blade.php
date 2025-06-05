@extends('layouts.chairSidebar')
@section('content')
@include('layouts.modal')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyllabEase</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/sample/se.png') }}">
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

<body>

    <div class="flex flex-col justify-center mb-20 w-screen mt-14">
    <div class=" flex justify-end">
        <div class="mt-10 bg-green3  rounded w-[100px] flex justify-center items-center text-white">
        <a href="{{route('chairperson.tos')}}">Finish</a>
        </div>
    </div>
        <div class="mt-24 mx-auto shadow-lg pb-10 border border-white bg-white w-[80%]">
     
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
                <table class="mt-2 w-3/12 font-serif text-sm bg-white">
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
                        <th>
                            <div class="text-right align-top -mr-2 -mt-1">
                                <livewire:chair-tos-a-comment :tos_id="$tos->tos_id" :col_no='1' />
                            </div>
                            <div class="text-center mb-2 -mt-1">{{$tos->col_1_per}}%</div>
                        </th>
                        <th>
                            <div class="text-right align-top -mr-2 -mt-1">
                                <livewire:chair-tos-a-comment :tos_id="$tos->tos_id" :col_no='2' />
                            </div>
                            <div class="text-center mb-2 -mt-1">{{$tos->col_2_per}}%</div>
                        </th>
                        <th>
                            <div class="text-right align-top -mr-2 -mt-1">
                                <livewire:chair-tos-a-comment :tos_id="$tos->tos_id" :col_no='3' />
                            </div>
                            <div class="text-center mb-2 -mt-1">{{$tos->col_3_per}}%</div>
                        </th>

                        <th>
                            <div class="text-right align-top -mr-2 -mt-1">
                                <livewire:chair-tos-a-comment :tos_id="$tos->tos_id" :col_no='4' />
                            </div>
                            <div class="text-center mb-2 -mt-1">{{$tos->col_4_per}}%</div>
                        </th>
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
                        <td class="">
                            <div class="text-right align-top -mr-2 -mt-1"><livewire:chair-tos-ro-comment :tos_r_id="$tos_row->tos_r_id" :col_no='1' /></div>
                            <div class="text-center mb-2 -mt-1">{{ $tos_row->tos_r_topic }} </div>
                        </td>
                        <td class="">
                            <div class="text-right align-top -mr-2 -mt-1"><livewire:chair-tos-ro-comment :tos_r_id="$tos_row->tos_r_id" :col_no='2' /></div>
                            <div class="text-center mb-2 -mt-1">{{ $tos_row->tos_r_no_hours }} </div>
                        </td>
                        <td class="">
                            <div class="text-right align-top -mr-2 -mt-1"><livewire:chair-tos-ro-comment :tos_r_id="$tos_row->tos_r_id" :col_no='3' /></div>
                            <div class="text-center mb-2 -mt-1 mx-3">{{ $tos_row->tos_r_percent }} </div>
                        </td>
                        <td class="">
                            <div class="text-right align-top -mr-2 -mt-1"><livewire:chair-tos-ro-comment :tos_r_id="$tos_row->tos_r_id" :col_no='4' /></div>
                            <div class="text-center mb-2 -mt-1">{{ $tos_row->tos_r_no_items }} </div>
                        </td>
                        <td class="">
                            <div class="text-right align-top -mr-2 -mt-1"><livewire:chair-tos-ro-comment :tos_r_id="$tos_row->tos_r_id" :col_no='5' /></div>
                            <div class="text-center mb-2 -mt-1">{{ intval($tos_row->tos_r_col_1) }} </div>
                        </td>
                        <td class="">
                            <div class="text-right align-top -mr-2 -mt-1"><livewire:chair-tos-ro-comment :tos_r_id="$tos_row->tos_r_id" :col_no='6' /></div>
                            <div class="text-center mb-2 -mt-1">{{ intval($tos_row->tos_r_col_2) }} </div>
                        </td>
                        <td class="">
                            <div class="text-right align-top -mr-2 -mt-1"><livewire:chair-tos-ro-comment :tos_r_id="$tos_row->tos_r_id" :col_no='7' /></div>
                            <div class="text-center mb-2 -mt-1">{{ intval($tos_row->tos_r_col_3) }} </div>
                        </td>
                        <td class="">
                            <div class="text-right align-top -mr-2 -mt-1"><livewire:chair-tos-ro-comment :tos_r_id="$tos_row->tos_r_id" :col_no='8' /></div>
                            <div class="text-center mb-2 -mt-1">{{ intval($tos_row->tos_r_col_4) }} </div>
                        </td>
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
                        <td>
                            <div class="text-right align-top -mr-2 -mt-1">
                                <livewire:chair-tos-a-comment :tos_id="$tos->tos_id" :col_no='5' />
                            </div>
                        </td>
                        <td></td>
                        <td class="text-center font-bold p-2">
                            <div class="text-right align-top -mr-2 -mt-1">
                                <livewire:chair-tos-a-comment :tos_id="$tos->tos_id" :col_no='6' />
                            </div>
                            {{$tos->tos_no_items}}
                        </td>
                        <td class="text-center font-bold p-2">
                            <div class="text-right align-top -mr-2 -mt-1">
                                <livewire:chair-tos-a-comment :tos_id="$tos->tos_id" :col_no='7' />
                            </div>
                            {{$total_tos_r_col_1}}
                        </td>
                        <td class="text-center font-bold p-2">
                            <div class="text-right align-top -mr-2 -mt-1">
                                <livewire:chair-tos-a-comment :tos_id="$tos->tos_id" :col_no='8' />
                            </div>
                            {{$total_tos_r_col_2}}
                        </td>
                        <td class="text-center font-bold p-2">
                            <div class="text-right align-top -mr-2 -mt-1">
                                <livewire:chair-tos-a-comment :tos_id="$tos->tos_id" :col_no='9' />
                            </div>
                            {{$total_tos_r_col_3}}
                        </td>
                        <td class="text-center font-bold p-2">
                            <div class="text-right align-top -mr-2 -mt-1">
                                <livewire:chair-tos-a-comment :tos_id="$tos->tos_id" :col_no='10' />
                            </div>
                            {{$total_tos_r_col_4}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>