<!-- @-extends('layouts.deanNav') -->
@extends('layouts.deanSidebar')
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

    <style>
        body {
            background-image: url("{{ asset('assets/Wave1.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            min-width: 100vh;
            background-size: contain;
        }
    </style>
</head>

<body>
    <div class="flex flex-col justify-center mb-20">
        <div class="relative mt-[100px] flex flex-col bg-gradient-to-r from-[#FFF] to-[#dbeafe] p-12 px-8 md:space-y-0 rounded-xl shadow-lg p-3 mx-auto border border-white bg-white">
            <img class="edit_user_img text-center mt-6 w-[400px] m-auto mb-2" src="/assets/Set Syllabus and TOS Deadline.png" alt="SyllabEase Logo">
            <form class="" action="{{ route('dean.storeDeadline') }}" method="POST">
                @csrf
                <div class="m-4 ">
                    <div>
                        <label class="" for="dl_syll">Syllabus Deadline <span class="text-red">*</span></label>
                    </div>
                    <input type="datetime-local" name="dl_syll" id="dl_syll" class="px-1 py-[6px] w-full border rounded border-gray" required></input>
                </div>
                <div class="m-4 ">
                    <div>
                        <label class="" for="dl_tos">TOS Midterm Deadline</label>
                    </div>
                    <input type="datetime-local" name="dl_tos_midterm" id="dl_tos" class="px-1 py-[6px] w-full border rounded border-gray" required></input>
                </div>
                <div class="m-4 ">
                    <div>
                        <label class="" for="dl_tos">TOS Final Deadline</label>
                    </div>
                    <input type="datetime-local" name="dl_tos_final" id="dl_tos" class="px-1 py-[6px] w-full border rounded border-gray" required></input>
                </div>
                <div class="m-4 ">
                    <div>
                        <label class="" for="dl_school_year">School Year<span class="text-red">*</span></label>
                    </div>
                    <select name="dl_school_year" id="dl_school_year" class="select1 w-full px-1 py-[6px] border rounded border-[#a3a3a3]" required>
                        <option value="2023-2024">2023-2024</option>
                        <option value="2024-2025">2024-2025</option>
                        <option value="2025-2026">2025-2026</option>
                        <option value="2026-2027">2026-2027</option>
                        <option value="2027-2028">2027-2028</option>
                        <option value="2027-2028">2028-2029</option>
                        <option value="2027-2028">2029-2030</option>
                    </select>
                </div>
                <div class="m-4 ">
                    <div>
                        <label class="" for="dl_semester">Semester<span class="text-red">*</span></label>
                    </div>
                    <select name="dl_semester" id="bg_school_year" class="select1 w-full px-1 py-[6px] border rounded border-[#a3a3a3]" required>
                        <option value="1st Semester">1st Semester</option>
                        <option value="2nd Semester">2nd Semester</option>
                        <option value="Mid Year">Mid Year</option>

                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="text-white font-semibold px-6 py-2 rounded-lg m-2 mt-4 mb-4 bg-blue">Set Deadline</button>
                </div>
            </form>
        </div>

    </div>
</body>

</html>

@endsection