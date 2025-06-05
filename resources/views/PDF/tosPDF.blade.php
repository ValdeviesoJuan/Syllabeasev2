<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
        .head {
            text-align: right;
        }
        table {
        border-collapse: collapse;
        /* Combine borders for seamless look */
    }
        th, tr, td{
            border: 1px solid;
            border-collapse: collapse;
        }
    </style>
<body>
<div class="">
        <div class="head" style="margin-bottom: 1%;">
            <span style="font-weight: bold ">Term Examination: </span>
            <span style="border-bottom: 2px solid #000; padding-bottom: 4px; width:300px" class="ml-2"> {{$tos->tos_term}}</span>
        </div>

        <div class="head" style="margin-bottom: 1%;">
            <span style="font-weight: bold ">Course Code: </span>
            <span style="border-bottom: 2px solid #000; padding-bottom: 4px; width:300px" class="ml-2"> {{$tos->course_code}}</span>
        </div>

        <div class="head" style="margin-bottom: 1%;">
            <span style="font-weight: bold ">Course Title: </span>
            <span style="border-bottom: 2px solid #000; padding-bottom: 4px; width:300px" class="ml-2"> {{$tos->course_title}}</span>
        </div>
        <div style="text-align:center; font-weight:bold; margin-bottom: 1%;">
            TABLE OF SPECIFICATION
        </div>

        <div style="text-align:center; margin-bottom: 1%;">
            <span style="font-weight: bold" class="text-center">S.Y.: </span>
            <span style="border-bottom: 2px solid #000; padding-bottom: 4px; width:150px" class="ml-2">{{$tos->bg_school_year}}</span>
            <span style="font-weight: bold" class="text-center">Semester: </span>
            <span style="border-bottom: 2px solid #000; padding-bottom: 4px; width:150px" class="ml-2">{{$tos->course_semester}}</span>
        </div>

        <div style="text-align:center; margin-bottom: 1%;"> 
            <span style="font-weight: bold "> Curricular Program/Year/Section: </span>
            <span style="border-bottom: 2px solid #000; padding-bottom: 4px; width:200px" class="ml-2">{{$tos->tos_cpys}}</span>
            <span style="font-weight: bold "> Date Submitted: </span>
            <span style="border-bottom: 2px solid #000; padding-bottom: 4px; width:200px" class="ml-2">{{$tos->tos_cpys}}</span>
        </div>

        <div style="display: flex; justify-content: center; ; margin-bottom: 1%;">
            <table style="border: 1px solid; width: 11%; margin-right: 5px">
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

            <table style="border:1px solid; width: 60%;">
                <tr style="border:1px solid;">
                    <th rowspan="3" style="border:1px solid; border-collapse: collapse;">
                        Topics
                    </th>
                    <th rowspan="3" style="border:1px solid;  border-collapse: collapse;">
                        No. of <br> Hours <br> Taught
                    </th>
                    <th rowspan="3" style="border:1px solid; border-collapse: collapse;">
                        %
                    </th>
                    <th rowspan="3" style="border:1px solid;   border-collapse: collapse;">
                        No. of <br>Test <br>Items
                    </th>
                    <th colspan="4" class="py-2" style="border:1px solid;   border-collapse: collapse;">
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
                <tr>
                    <td style="text-align:right; font-weight: bold;"class="text-right font-bold p-2">Total: </td>
                    <td class="text-center font-bold p-2">{{$total_tos_r_no_hours}}</td>
                    <td class="text-center font-bold p-2">{{$total_tos_r_percent}}</td>
                    <td class="text-center font-bold p-2">{{$tos->tos_no_items}}</td>
                    <td class="text-center font-bold p-2">{{$tos->col_1_exp}}</td>
                    <td class="text-center font-bold p-2">{{$tos->col_2_exp}}</td>
                    <td class="text-center font-bold p-2">{{$tos->col_3_exp}}</td>
                    <td class="text-center font-bold p-2">{{$tos->col_4_exp}}</td>
                </tr>
            </table>
        </div>
        <div style="justify-items:center;display:grid; grid: 150px / auto auto auto auto">
            <div class="flex justify-center items-center">
                <div class="flex justify-center">
                    Prepared by:
                </div>
            </div>
            <div>
                @foreach($bLeaders as $bLeader)
                <div class="mb-10 mt-10">
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
                <div class="flex justify-center font-semibold underline">
                    {{ strtoupper($chair->prefix) }} {{ strtoupper($chair->firstname) }} {{ strtoupper($chair->lastname) }} {{ strtoupper($chair->suffix) }}
                </div>
                <div class="flex justify-center">
                    Department Chair
                </div>
            </div>
        </div>
    </div>
</body>
</html>