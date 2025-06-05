@extends('layouts.blNav')
@section('content')
@include('layouts.modal')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syllabease</title>
    @vite('resources/css/app.css')
    <style>

body {
background-image: url("{{ asset('assets/Wave.png') }}");
background-repeat: no-repeat;
background-position: top;
background-attachment: fixed;
background-size: contain;
}
</style>
</head>

<body>
    <div class="flex flex-col justify-center mt-10 mx-auto">
        <div class="relative mt-20 flex flex-col bg-gradient-to-r from-[#FFF] to-[#dbeafe]  rounded-xl shadow-lg p-3 mx-auto border border-white bg-white">
            <div>
                <img class="edit_user_img text-center mt-4 mb-6 w-[250px] m-auto mb-2" src="/assets/Create TOS.png" alt="SyllabEase Logo">
            </div>
            <div class="pl-4 mt-4 ml-4">
                <span style="font-family: 'Roboto', sans-serif; font-weight: bold">Course Code: </span>
                <span>{{$syllabus->course_code}}</span>
            </div>

            <div class="pl-4 ml-4">
                <span style="font-family: 'Roboto', sans-serif; font-weight: bold">S.Y. & Semester:</span>
                <span>{{$syllabus->bg_school_year . ' - ' . $syllabus->course_semester}}</span>
            </div>

            <div class="m-8">
                <form action="{{ route('bayanihanleader.storeTos', $syll_id) }}" method="POST">
                @csrf
                    <div class="">
                        <div class="mb-3">
                            <label for="tos_term" class="flex">Term</label>
                            <select name="tos_term" id="tos_term" class="border border-[#a8a29e] rounded w-[200px] p-2">
                                <option value="Midterm">Midterm</option>
                                <option value="Final">Final</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid gap-6 mb-6 md:grid-cols-2 mr-6"> 
                        <div class="mb-3">
                            <label for="tos_no_items" class="flex">Total No. of Test Items</label>
                                <input type="number" name="tos_no_items" id="tos_no_items" class="border w-max border-[#a8a29e] rounded w-[400px] p-2" required>
                        </div>
                        <div class="mb-3">
                            <label for="tos_no_items" class="flex" >Curricular Program/Year/Section:</label>
                                <input type="text" name="tos_cpys" id="tos_cpys" class="border w-max border-[#a8a29e] rounded w-[400px] p-2" required>
                        </div>
                    </div>

                    <p class="font-semibold text-xl text-center mb-4">Cognitive Level</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="">
                            <p class="">Knowledge</p>
                            <input type="number" name="col_1_per" id="col_1_per" class="percentage-input border w-max border-[#a8a29e] rounded w-[400px] p-2"  required>
                        </div>
                        <div class="">
                            <p>Comprehension</p>
                            <input type="number" name="col_2_per" id="col_2_per" class="percentage-input border w-max border-[#a8a29e] rounded w-[400px] p-2" required>
                        </div>
                        <div class="">
                            <p>Application/ Analysis</p>
                            <input type="number" name="col_3_per" id="col_3_per" class="percentage-input border w-max border-[#a8a29e] rounded w-[400px] p-2" required>
                        </div>
                        <div class="">
                            <p>Synthesis/ Evaluation</p>
                            <input type="number" name="col_4_per" id="col_4_per" class="percentage-input border w-max border-[#a8a29e] rounded w-[400px] p-2" required>
                        </div>
                    </div>
                    <div id="feedback" class="text-red-500 font-bold mt-8"></div>
                    <div id="currentTotal" class="font-bold mt-2"></div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary font-semibold text-white px-6 py-2 rounded-lg m-2 mt-30 mb-4 bg-blue">Create TOS</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script>
                const percentageInputs = document.querySelectorAll('.percentage-input');
                const feedbackDiv = document.getElementById('feedback');
                const currentTotalDiv = document.getElementById('currentTotal');

                percentageInputs.forEach(input => {
                    input.addEventListener('input', updateTotal);
                });

                function updateTotal() {
                    let total = 0;

                    percentageInputs.forEach(input => {
                        total += parseInt(input.value) || 0;
                    });

                    if (total !== 100) {
                        feedbackDiv.textContent = 'Total should be 100%';
                        feedbackDiv.classList.add('text-red-500');
                        currentTotalDiv.textContent = `Current Total: ${total}%`;
                    } else {
                        feedbackDiv.textContent = ''; 
                        feedbackDiv.classList.remove('text-red-500');
                        currentTotalDiv.textContent = ``;
                    }
                }
            </script>
</html>