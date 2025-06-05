@extends('layouts.blNav')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course Outline</title>
    @vite('resources/css/app.css')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $(document).ready(function() {
                $('.select2').select2();
            });
        });
    </script>
        <x-head.tinymce-config />

</head>
    <style>

        body {
        background-image: url("{{ asset('assets/Wave.png') }}");
        background-repeat: no-repeat;
        background-position: top;
        background-attachment: fixed;
        background-size: contain;
        }
    </style>
<body>
    <div class="m-auto bg-slate-100 mt-[120px] p-2 shadow-lg bg-gradient-to-r from-[#FFF] to-[#dbeafe] rounded-lg w-11/12">
        <img class="edit_user_img text-center mt-12 w-[370px] m-auto mb-12" src="/assets/Edit Course Outline.png" alt="SyllabEase Logo">
        <form action="{{ route('bayanihanleader.updateCot', ['syll_co_out_id' => $cot->syll_co_out_id, 'syll_id' => $syll_id]) }}" method="POST">
        @csrf
        @method('PUT')

            <table class="border-collapse border-2 border-solid m-5 font-serif">
                <thead>
                    <tr class="border-2 border-solid">
                        <th class="p-2">Allotted Hour</th>
                        <th class="p-2">Allotted Time</th>
                        <th class="p-2">Course Outcomes (CO)</th>
                        <th class="p-2">Intended Learning Outcome (ILO)</th>
                        <th class="p-2">Topics</th>
                        <th class="p-2">Suggested Readings</th>
                        <th class="p-2">Teaching-Learning Activities</th>
                        <th class="p-2">Assessment Task/Tools</th>
                        <th class="p-2">Grading Criteria</th>
                        <th class="p-2">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-2 border-solid text-sm">
                        <td class="p-2">
                            <!-- <textarea id="" name="syll_allotted_time" rows="4" cols="50" class="border-2 border-solid w-full" required>{{ $cot->syll_allotted_time }}</textarea>
                        <td class="p-2"> -->
                            <input type="number"class="w-full h-60 font-sans mb-1 text-center" name="syll_allotted_hour" id="" placeholder="e.g. 10" value="{{ $cot->syll_allotted_hour ?? '' }}"  required>
                            <!-- <textarea id="syll_allotted_hour" placeholder=" e.g. 1 hour" name="syll_allotted_hour" rows="4" cols="50" class="font-sans border-2 border-solid w-full" required></textarea> -->
                        </td>
                        <td class="p-2">
                            <!-- <input type="number"class="w-[65%] font-sans mb-1" name="syll_allotted_time" id="" placeholder="e.g. 10"> week -->
                            <textarea id="syll_allotted_time" placeholder=" e.g. Week 1" name="syll_allotted_time" rows="4" cols="50" class="font-sans border-2 border-solid w-full h-60 ">{{ $cot->syll_allotted_time }}</textarea>
                        </td>
                        <td class="p-2">
                            <select name="syll_course_outcome[]" id="syll_course_outcome" class="form-control select2 w-full h-60 " multiple>
                                @foreach ($courseOutcomes as $co)
                                <option value="{{ $co->syll_co_id }}" {{ in_array($co->syll_co_id, $cot_cos->pluck('syll_co_id')->toArray()) ? 'selected' : '' }}>
                                    {{ $co->syll_co_code }}
                                </option>
                                @endforeach
                            </select>

                        <td>
                            <textarea id="syll_intended_learning" name="syll_intended_learning" rows="4" cols="50" class="border-2 border-solid w-full h-60 ">{{ $cot->syll_intended_learning }}</textarea>
                        </td>
                        <td>
                            <textarea id="syll_topics" name="syll_topics" rows="4" cols="50" class="border-2 border-solid w-full h-60 " required>{{ $cot->syll_topics }}</textarea>
                        </td>
                        <td>
                            <textarea id="syll_suggested_readings" name="syll_suggested_readings" rows="4" cols="50" class="border-2 border-solid w-full h-60 ">{{ $cot->syll_suggested_readings }}</textarea>
                        </td>
                        <td>
                            <textarea id="syll_learning_act" name="syll_learning_act" rows="4" cols="50" class="border-2 border-solid w-full h-60 ">{{ $cot->syll_learning_act }}</textarea>
                        </td>
                        <td>
                            <textarea id="syll_asses_tools" name="syll_asses_tools" rows="4" cols="50" class="border-2 border-solid w-full h-60 ">{{ $cot->syll_asses_tools }}</textarea>
                        </td>
                        <td>
                            <textarea id="syll_grading_criteria" name="syll_grading_criteria" rows="4" cols="50" class="border-2 border-solid w-full h-60 ">{{ $cot->syll_grading_criteria }}</textarea>
                        </td>
                        <td>
                            <textarea id="syll_remarks" name="syll_remarks" rows="4" cols="50" class="border-2 border-solid w-full h-60 ">{{ $cot->syll_remarks }}</textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center">
                <button type="submit" class="bg-blue p-2 px-6 font-semibold text-white rounded-lg m-5">Update Course Outline</button>
            </div>
            <div class="text-center mb-8">
                <a href="{{ route('bayanihanleader.viewSyllabus', $syll_id) }}" class="btn btn-secondary -mt-[80px] hover:underline hover:text-blue hover:underline-offset-4 p-2 px-6 font-semibold text-black rounded-lg m-5">Back</a>
            </div>
        </form>
</body>

</html>
@endsection