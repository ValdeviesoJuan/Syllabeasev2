{{-- #final course outline --}}
@extends('layouts.blNav')
@section('content')


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $(document).ready(function() {
                $('.select2').select2();
            });
        });
    </script>
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
    <div class="m-auto bg-slate-100 mt-[120px] p-2 shadow-lg bg-gradient-to-r from-[#000] to-[#dbeafe] rounded-lg w-11/12">
        {{-- <div class="max-w-md  w-[560px] p-6 px-8 rounded-lg shadow-lg"> --}}
        <img class="edit_user_img text-center mt-12 w-[370px] m-auto mb-12" src="/assets/Final Course Outline.png" alt="SyllabEase Logo">
        <form action="{{ route('bayanihanleader.storeCotF', $syll_id) }}" method="POST">
            @csrf
            <div id="input-container" class="">
            </div>
            <table class="border-collapse border-2 border-solid m-5 font-serif">
                <thead>
                    <tr class="border-2 border-solid">
                        <th class="p-2">Alloted Hour<span class="text-red">*</span></th>
                        <th class="p-2">Allotted Time</th>
                        <th class="p-2">Course Outcomes (CO)</th>
                        <th class="p-2">Intended Learning Outcome (ILO)</th>
                        <th class="p-2">Topics<span class="text-red">*</span></th>
                        <th class="p-2">Suggested Readings</th>
                        <th class="p-2">Teaching-Learning Activities</th>
                        <th class="p-2">Assessment Task/Tools</th>
                        <th class="p-2">Grading Criteria</th>
                        <th class="p-2">Remarks</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <tr class="border-2 border-solid text-sm" id="">
                        <td class="p-2">
                            <input type="number"
    class="w-full h-60 font-sans {{ $isDisabled ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : '' }}"
    name="syll_allotted_hour"
    id=""
    placeholder="{{ $isDisabled ? 'Disabled' : 'e.g. 10' }}"
    value="{{ $isDisabled ? 'Disabled' : '' }}"
    required {{ $isDisabled }}>
                        </td>
                        <td class="p-2">
                            <textarea id="syll_allotted_time" placeholder=" e.g. Week 1" name="syll_allotted_time" rows="4" cols="50" class="font-sans border-2 border-solid w-full h-60 "></textarea>
                        </td>
                        <td class="">
                            <select name="syll_course_outcome[]" id="syll_course_outcome[]" class="select2 border-2 border-solid w-full h-60 " multiple>
                                @foreach ($courseOutcomes as $co)
                                <option value="{{ $co->syll_co_id }}">{{ $co->syll_co_code }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="">
                            <textarea id="syll_intended_learning" name="syll_intended_learning" rows="4" cols="50" class="border-2 border-solid w-full h-60 {{ $isDisabled ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : '' }}" {{ $isDisabled }}>{{ $isDisabled ? 'Disabled' : '' }}</textarea>
                        </td>
                        <td class="">
                            <textarea id="syll_topics" name="syll_topics" rows="4" cols="50" class="border-2 border-solid w-full h-60 " required></textarea>
                        </td>
                        <td class="">
                            <textarea id="syll_suggested_readings" name="syll_suggested_readings" rows="4" cols="50" class="border-2 border-solid w-full h-60 "></textarea>
                        </td>
                        <td class="">
                            <textarea id="syll_learning_act" name="syll_learning_act" rows="4" cols="50" class="border-2 border-solid w-full h-60 "></textarea>
                        </td>
                        <td class="">
                            <textarea id="syll_asses_tools" name="syll_asses_tools" rows="4" cols="50" class="border-2 border-solid w-full h-60 "></textarea>
                        </td>
                        <td class="">
                            <textarea id="syll_grading_criteria" name="syll_grading_criteria" rows="4" cols="50" class="border-2 border-solid w-full h-60 "></textarea>
                        </td>
                        <td class="">
                            <textarea id="syll_remarks" name="syll_remarks" rows="4" cols="50" class="border-2 border-solid w-full h-60 "></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center">
                <button type="submit" class="bg-blue p-2 px-6 font-semibold text-white rounded-lg m-5" {{ $isDisabled }}>Create Course Outline</button>
            </div>
            <div class="text-center mb-8">
                <a href="{{ route('bayanihanleader.viewSyllabus', $syll_id) }}" class="-mt-[80px] hover:underline hover:text-blue hover:underline-offset-4 p-2 px-6 font-semibold text-black rounded-lg m-5">Back</a>
            </div>
        </form>
        <div id="customAlert"
             class="hidden fixed top-6 right-6 z-50 bg-white border-t-4 border-[#ef4444] rounded-b text-red-900 px-8 py-8 shadow-md min-w-[320px] flex items-start"
             role="alert">
          <div class="py-1 mr-4">
            <svg class="fill-current h-6 w-6 text-[#ef4444]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
              <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
            </svg>
          </div>
          <div class="flex-1">
            <p class="font-bold">Allotted Time Exceeded</p>
            <p class="text-sm">The allotted time exceeds 40. You cannot add more.</p>
          </div>
          <button onclick="document.getElementById('customAlert').classList.add('hidden')" class="ml-4 text-red-700 hover:text-red-900 text-xl font-bold leading-none">
            &times;
          </button>
        </div>
        <script>
document.addEventListener('DOMContentLoaded', function() {
    let totalHours = {{ $totalHours }};
    const maxHours = 39;

    const hourInput = document.querySelector('input[name="syll_allotted_hour"]');
    const submitBtn = document.querySelector('button[type="submit"]');
    const formFields = document.querySelectorAll('input, textarea, select');

    function setDisabledState() {
        formFields.forEach(f => {
            f.disabled = true;
            f.classList.add('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
            if (f.tagName === 'INPUT' || f.tagName === 'TEXTAREA') {
                f.value = 'Disabled';
                f.placeholder = 'Disabled';
            }
        });
        submitBtn.disabled = true;
    }

    if (totalHours > maxHours) {
        setDisabledState();
    }

    submitBtn.addEventListener('click', function(e) {
        let current = parseFloat(hourInput.value) || 0;
        if (totalHours > maxHours || (totalHours + current) > maxHours) {
            e.preventDefault();
            setDisabledState();
            document.getElementById('customAlert').classList.remove('hidden');
        }
    });
});
</script>
</body>

</html>
@endsection