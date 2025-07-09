@extends('layouts.adminSidebar')
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
            <form class="" action="{{ route('admin.storeDeadline') }}" method="POST">
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
                        <label class="" for="school_year">School Year<span class="text-red">*</span></label>
                    </div>
                    <select name="dl_school_year" id="school_year" class="select1 w-full px-1 py-[6px] border rounded border-[#a3a3a3]" required>
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
                        <label class="" for="semester">Semester<span class="text-red">*</span></label>
                    </div>
                    <select name="dl_semester" id="semester" class="select1 w-full px-1 py-[6px] border rounded border-[#a3a3a3]" required>
                        <option value="1st Semester">1st Semester</option>
                        <option value="2nd Semester">2nd Semester</option>
                        <option value="Mid Year">Mid Year</option>
                    </select>
                </div>
                <div class="m-4 ">
                    <div>
                        <label class="" for="college">College Assigned<span class="text-red">*</span></label>
                    </div>
                    <select name="college_id" id="college" class="select1 w-full px-1 py-[6px] border rounded border-[#a3a3a3]" required>
                        @foreach ($colleges as $college)
                            <option value="{{$college->college_id}}">{{ $college->college_code }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit"
                        class="whitespace-nowrap rounded-xl hover:scale-105 transition ease-in-out px-6 py-2 text-black font-semibold flex items-center gap-2 m-auto mt-4 mb-4"
                        style="background: #d7ecf9;"
                        onmouseover="this.style.background='#c3dff3';"
                        onmouseout="this.style.background='#d7ecf9';">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="4" width="18" height="16" rx="2" stroke="black" stroke-width="1.5" fill="none"/>
                            <path d="M16 2v4M8 2v4" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M8 13l3 3l5-5" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Set Deadline
                    </button>
                </div>
            </form>
        </div>

    </div>
</body>

</html>

@endsection