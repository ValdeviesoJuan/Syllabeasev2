@extends('layouts.blNav')
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
background-image: url("{{ asset('assets/wave.png') }}");
background-repeat: no-repeat;
background-position: top;
background-attachment: fixed;
background-size: contain;
}
</style>
    <link rel="stylesheet" href="/css/review_form.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/sample/se.png') }}">
</head>
<body class="">
    <div class="flex justify-center">
        <div id="" class="mt-24 flex flex-col border  justify-center border-gray3 top-0  bg-white bg-opacity-100 rounded-lg font-sans pb-10">
            <div class=" justify-center items-center mx-10">
                <div class="flex mt-5 justify-center items-center">
                    <div class="text-3xl font-bold mb-5 mt-5">SYLLABUS REVIEW FORM</div>
                </div>
                <div class="grid grid-cols-2 grid-rows-2 mb-6 mt-">
                    <div class="">
                        <span style="font-family: 'Roboto', sans-serif; font-weight: bold">Course Code: </span>
                        <span>{{$reviewForm->srf_course_code}}</span>
                    </div>
                    <div class="">
                        <span style="font-family: 'Roboto', sans-serif; font-weight: bold">Sem and Year: </span>
                        <span>{{$reviewForm->srf_sem_year}}</span>
                    </div>
                    <div class="">
                        <span style="font-family: 'Roboto', sans-serif; font-weight: bold">Descriptive Title: </span>
                        <span>{{$reviewForm->srf_title}}</span>
                    </div>
                    <div class="">
                        <span style="font-family: 'Roboto', sans-serif; font-weight: bold">Faculty: </span>
                        <span>{{$reviewForm->srf_faculty}}</span>
                    </div>
                    <!-- <div>
                        {{$reviewForm->srf_course_code}}

                    </div> -->
<!-- 
                    <div>
                        Sem and Year: {{$reviewForm->srf_sem_year}}
                    </div>
                    <div>
                        Descriptive Title: {{$reviewForm->srf_title}}
                    </div>
                    <div>
                        Faculty: {{$reviewForm->srf_faculty}}
                    </div> -->
                </div>
                <div class="w-[900px] h-11/12 bg-white bg-white bg-opacity-100 ">
                    <div class="mb-4">
                        <p>
                            <span class="font-semibold">Directions:</span> Check the column <span class="font-semibold">YES</span> if an indicator is observed in the syllabus and check column NO if otherwise. Provide clear and constructive remarks that would help improve the content and alignment of the syllabus.
                        </p>
                    </div>
                    <table id="review_form_table">
                        <thead>
                            <tr class="">
                                <th class="w-[600px]">Indicators</th>
                                <th class="w-[100px]">Yes</th>
                                <th class="w-[100px]">No</th>
                                <th class="w-[200px]">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr colspan-4 class="part">
                                <td class="font-semibold">PART I. BASIC SYLLABUS INFORMATION</td>
                            </tr>
                            <!-- 1  -->
                            <tr class="">
                                <input type="hidden" name="srf_no[]" value=1>
                                <td>1. The syllabus follows the prescribed OBE syllabus format of the University and include the following:</td>
                                <td class="checkbox-cell">@if($srf1['srf_yes_no'] === 'yes') <div style="text-align: center;">/</div>  @endif </td>
                                <td class="">@if($srf1['srf_yes_no'] === 'no') <div style="text-align: center;">/</div>  @endif </td>
                                <td class="">{{$srf1->srf_remarks}}</td>
                            </tr>
                            <tr class="">
                                <td class="ones">• Name of the College/Campus is indicated below the University name/brand.</td>
                                <td class="checkbox-cell">@if($srf2['srf_yes_no'] === 'yes') <div style="text-align: center;">/</div>  @endif </td>
                                <td class="">@if($srf2['srf_yes_no'] === 'no') <div style="text-align: center;">/</div>  @endif </td>
                                <td class="">{{$srf2->srf_remarks}}</td>
                            </tr>
                            <!-- 2  -->
                            <!-- 3 -->
                            <tr class="">
                                <td class="ones">• Program, Course Title, Course Code and Unit Credits are specified in the syllabus.</td>
                                <td class="checkbox-cell">@if($srf3['srf_yes_no'] === 'yes') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">@if($srf3['srf_yes_no'] === 'no') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">{{$srf3->srf_remarks}}</td>
                            </tr>
                            <!-- 4  -->
                            <tr class="">
                                <td class="ones">• Pre-requisites and co-requisites are indicated.</td>
                                <td class="checkbox-cell">@if($srf4['srf_yes_no'] === 'yes') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">@if($srf4['srf_yes_no'] === 'no') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">{{$srf4->srf_remarks}}</td>
                            </tr>
                            <!-- 1.4  -->
                            <tr class="">
                                <td class="ones">• Semester, Academic Year, Schedule of Course, Building and Room Number are stipulated in the syllabus.</td>
                                <td class="checkbox-cell">@if($srf5['srf_yes_no'] === 'yes') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">@if($srf5['srf_yes_no'] === 'no') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">{{$srf5->srf_remarks}}</td>
                            </tr>
                            <!-- 1.5  -->
                            <tr class="">
                                <td class="ones">• Contact details of the instructor such as the instructor’s name, email address OR mobile number (optional) are specified in the syllabus.</td>
                                <td class="checkbox-cell">@if($srf6['srf_yes_no'] === 'yes') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">@if($srf6['srf_yes_no'] === 'no') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">{{$srf6->srf_remarks}}</td>
                            </tr>
                            <!-- 1.6  -->
                            <tr class="">
                                <td class="ones">• Instructor’s consultation schedules, oﬃce or consultation venue, oﬃce phone number is indicated in the syllabus.</td>
                                <td class="checkbox-cell">@if($srf7['srf_yes_no'] === 'yes') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">@if($srf7['srf_yes_no'] === 'no') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">{{$srf7->srf_remarks}}</td>
                            </tr>
                            <!-- 1.7  -->
                            <tr class="">
                                <td class="ones">• The University’s Vision and Mission are indicated in the syllabus.</td>
                                <td class="checkbox-cell">@if($srf8['srf_yes_no'] === 'yes') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">@if($srf8['srf_yes_no'] === 'no') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">{{$srf8->srf_remarks}}</td>
                            </tr>

                            <!-- 2  -->
                            <tr class="">
                                <td class="">2. The course description stipulates its relevance to the curriculum in general and provides an overview of the course content.</td>
                                <td class="checkbox-cell">@if($srf9['srf_yes_no'] === 'yes') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">@if($srf9['srf_yes_no'] === 'no') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">{{$srf9->srf_remarks}}</td>
                            </tr>

                            <tr class="part">
                                <td colspan="3" class="font-semibold">PART II. PROGRAM EDUCATIONAL OBJECTIVES (or General Outcomes for Gen Ed courses)</td>
                            </tr>
                            <!-- 3  -->
                            <tr class="">
                                <td class="">3. The Approved Program Educational Objectives (PEO) and Program Outcomes (PO) are listed with alphabets in the syllabus (which will be referred to in the mapping of the course outcomes).</td>
                                <td class="checkbox-cell">@if($srf10['srf_yes_no'] === 'yes') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">@if($srf10['srf_yes_no'] === 'no') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">{{$srf10->srf_remarks}}</td>
                            </tr>

                            <tr colspan-3 class="part">
                                <td class="font-semibold">PART III.</td>
                            </tr>
                            <!-- 4  -->
                            <tr class="">
                                <td class="">4. The course outcomes are measurable and aligned with the course description and program outcomes.</td>
                                <td class="checkbox-cell">@if($srf11['srf_yes_no'] === 'yes') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">@if($srf11['srf_yes_no'] === 'no') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">{{$srf11->srf_remarks}}</td>
                            </tr>
                            <!-- 5  -->
                            <tr class="">
                                <td class="">5. The course outcomes are mapped accordingly to the program outcomes/GELOs using the markers: i - introductory, e - enabling, and d - demonstrative.</td>
                                <td class="checkbox-cell">@if($srf12['srf_yes_no'] === 'yes') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">@if($srf12['srf_yes_no'] === 'no') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">{{$srf12->srf_remarks}}</td>
                            </tr>

                            <tr colspan-3 class="part">
                                <td class="font-semibold">PART IV.</td>
                            </tr>
                            <!-- 6  -->
                            <tr class="">
                                <td class="">6. The course outline indicates the number of hours.</td>
                                <td class="checkbox-cell">@if($srf13['srf_yes_no'] === 'yes') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">@if($srf13['srf_yes_no'] === 'no') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">{{$srf13->srf_remarks}}</td>
                            </tr>
                            <!-- 7  -->
                            <tr class="">
                                <td class="">7. Topics are assigned to intended learning outcomes (ILO).</td>
                                <td class="checkbox-cell">@if($srf14['srf_yes_no'] === 'yes') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">@if($srf14['srf_yes_no'] === 'no') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">{{$srf14->srf_remarks}}</td>
                            </tr>
                            <!-- 8  -->
                            <tr class="">
                                <td class="">8. Suggested readings are provided.</td>
                                <td class="checkbox-cell">@if($srf15['srf_yes_no'] === 'yes') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">@if($srf15['srf_yes_no'] === 'no') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">{{$srf15->srf_remarks}}</td>
                            </tr>
                            <!-- 9  -->
                            <tr class="">
                                <td class="">9. The Teaching-Learning Activities (TLAs) are indicated in the outline.</td>
                                <td class="checkbox-cell">@if($srf16['srf_yes_no'] === 'yes') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">@if($srf16['srf_yes_no'] === 'no') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">{{$srf16->srf_remarks}}</td>
                            </tr>

                            <!-- 10  -->
                            <tr class="">
                                <td class="">10. Assessment tools are indicated.</td>
                                <td class="checkbox-cell">@if($srf17['srf_yes_no'] === 'yes') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">@if($srf17['srf_yes_no'] === 'no') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">{{$srf17->srf_remarks}}</td>
                            </tr>
                            <!-- 11  -->
                            <tr class="">
                                <td class="">11. Rubrics are attached for all outputs/requirements.</td>
                                <td class="checkbox-cell">@if($srf18['srf_yes_no'] === 'yes') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">@if($srf18['srf_yes_no'] === 'no') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">{{$srf18->srf_remarks}}</td>
                            </tr>
                            <!-- 12  -->
                            <tr class="">
                                <td class="">12. The grading criteria are clearly stated in the syllabus.</td>
                                <td class="checkbox-cell">@if($srf19['srf_yes_no'] === 'yes') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">@if($srf19['srf_yes_no'] === 'no') <div style="text-align: center;">/</div>  @endif</td>
                                <td class="">{{$srf19->srf_remarks}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>