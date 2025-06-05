@extends('layouts.chairSidebar')

@section('content')
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
    <div class="p-4 mt-14 flex items-center justify-center">
        <div class="max-w-md bg-gradient-to-r from-[#FFF] to-[#dbeafe] w-[500px] p-6 rounded-lg shadow-lg">

            
            <img class="edit_user_img text-center mt-4 w-[300px] m-auto mb-6" src="/assets/Create New Course.png" alt="SyllabEase Logo">
            <form class="" action="{{ route('chairperson.storeCourse') }}" method="POST">
                @csrf
                <div>
                    <div class="grid  gap-6 mb-6 md:grid-cols-2">
                        <div class="mt-3 mb-5">
                            <div class="">
                                <label for="course_code">Course Code</label>
                            </div>
                            <input placeholder="e.g. IT112" type="text" name="course_code" id="course_code" class="relative border w-[130px] border-[#a3a3a3] rounded px-3 py-1" required></input>
                        </div>
                        <div class="mt-3 mb-5 -ml-[50px]">
                            <label for="course_title">Course Title</label>
                            <input placeholder="e.g. Computer Programming 1" type="text" name="course_title" id="course_title" class="relative border w-[240px] border-[#a3a3a3] rounded px-3 py-1" required></input>
                        </div>
                    </div>

                    <div class="mb-5 -mt-[30px]">
                        <div>
                            <label for="curr_id">Curriculum</label>
                        </div>
                            <select name="curr_id" id="curr_id" class=" select2 w-[400px] border py-1 rounded pl-2 border-[#a3a3a3]" required>
                                @foreach ($curricula as $curriculum)
                                    <option value="{{ $curriculum->curr_id }}">{{ $curriculum->curr_code}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="grid  gap-6 mb-6 md:grid-cols-3">
                        <div class="">
                            <label for="course_unit_lec">Unit Lecture</label>
                            <input type="number" name="course_unit_lec" id="course_unit_lec" class="relative border rounded w-[110px] border-[#a3a3a3] px-3 py-1" required></input>
                        </div>
                        <div class="">
                            <label for="course_unit_lab">Unit Laboratory</label>
                            <input type="number" name="course_unit_lab" id="course_unit_lab" class="relative border rounded w-[110px] border-[#a3a3a3] px-3 py-1" required></input>
                        </div>
                        <div class="">
                            <label for="course_credit_unit">Credit Unit</label>
                            <input type="number" name="course_credit_unit" id="course_credit_unit" class="relative border w-[110px] border-[#a3a3a3] rounded px-3 py-1" required></input>
                        </div>
                    </div>
                    <div class="grid  gap-6 mb-6 md:grid-cols-3">
                        <div class="">
                            <label for="course_hrs_lec">Lec Hours</label>
                            <input type="number" name="course_hrs_lec" id="course_hrs_lec" class="relative border rounded w-[110px] border-[#a3a3a3] px-3 py-1" required></input>
                        </div>
                        <div class="">
                            <label for="course_hrs_lab">Lab Hours</label>
                            <input type="number" name="course_hrs_lab" id="course_hrs_lab" class="relative border rounded w-[110px] border-[#a3a3a3] px-3 py-1" required></input>
                        </div>
                    </div>

                    <div class="mb-5">
                        <div>
                            <label for="course_pre_req">Pre Requisite</label>
                        </div>
                        <input type="text" name="course_pre_req" id="course_pre_req" class="relative border w-[400px] border-[#a3a3a3] rounded px-3 py-1" required></input>
                    </div>
                    <div class="mb-5">
                        <div>
                            <label for="course_co_req">Co Requisite</label>
                        </div>
                        <input type="text" name="course_co_req" id="course_co_req" class="relative border w-[400px] border-[#a3a3a3] rounded px-3 py-1" required></input>
                    </div>

                    <div class="grid gap-6 mb-6 md:grid-cols-3 mt-5">
                        <div class="">
                            <div>
                            <label for="course_year_level">Year Level</label>
                            </div>
                            <select name="course_year_level" id="course_year_level" class="select1 w-[110px] border-[#a3a3a3]  px-3 py-1 border rounded" required>
                                <option value="1st Year">1st Year</option>
                                <option value="2nd Year">2nd Year</option>
                                <option value="3rd Year">3rd Year</option>
                                <option value="4th Year">4th Year</option>
                                <option value="5th Year">5th Year </option>
                            </select>
                        </div>
                        <div class="">
                            <div>
                                <label for="course_semester">Semester</label>
                            </div>
                            <select name="course_semester" id="course_semester" class="select1 w-[170px] border-[#a3a3a3]  px-3 py-1 border rounded" required>
                                <option value="1st Semester">1st Semester</option>
                                <option value="2nd Semester">2nd Semester</option>
                                <option value="Mid Year">Mid Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary text-white font-semibold px-6 py-2 rounded-lg m-2 mt-30 mb-4 bg-blue">Create Course</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

@endsection