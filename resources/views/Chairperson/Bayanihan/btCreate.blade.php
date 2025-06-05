@extends('layouts.chairSidebar')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyllabEase</title>
    <link rel="stylesheet" href="/css/loading.css">
    <script src="{{ asset('js/loading.js') }}" defer></script>
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
    @vite('resources/css/app.css')
</head>
<body>
    <div class="p-4 pb-10 flex items-center justify-center  mt-14">
        <div class="max-w-md bg-gradient-to-r from-[#FFF] to-[#dbeafe] w-[560px] p-6 px-8 rounded-lg shadow-lg">
            <img class="edit_user_img text-center mt-4 w-[330px] m-auto mb-6" src="/assets/Create Bayanihan Team.png" alt="SyllabEase Logo">
            <form action="{{ route('chairperson.storeBTeam') }}" id="form" method="POST">
                @csrf
                <div class="m-6">
                    <div>
                        <label class="flex" for="course_id">Courses<label>
                    </div>
                    <select name="course_id" id="course_id" class="form-control w-full select2 px-12 border rounded border-[#a3a3a3]" required>
                        @foreach ($courses as $course)
                        <option value="{{ $course->course_id }}">{{ $course->course_code}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="m-6">
                    <label class="flex" for="bl_user_id">Bayanihan Leaders</label>
                    <select name="bl_user_id[]" id="bl_user_id" class="form-control select2 px-1 py-[6px] w-full border rounded border-[#a3a3a3]" multiple required>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->lastname }}, {{ $user->firstname }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="m-6">
                    <label class="flex" for="bm_user_id">Bayanihan Members</label>
                    <select name="bm_user_id[]" id="bm_user_id" class="form-control select2 px-1 py-[6px] w-full border rounded border-[#a3a3a3]" multiple required>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->lastname }}, {{ $user->firstname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="m-6">
                    <div>
                        <label for="bg_school_year">School Year</label>
                    </div>
                    <select name="bg_school_year" id="bg_school_year" class="select1 w-full px-1 py-[6px] border rounded border-[#a3a3a3]" required>
                        <option value="2023-2024">2023-2024</option>
                        <option value="2024-2025">2024-2025</option>
                        <option value="2025-2026">2025-2026</option>
                        <option value="2026-2027">2026-2027</option>
                        <option value="2027-2028">2027-2028</option>
                        <option value="2027-2028">2028-2029</option>
                        <option value="2027-2028">2029-2030</option>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="text-white font-semibold px-6 py-2 rounded-lg m-2 mt-4 mb-4 bg-blue">Create Bayanihan Team</button>
                </div>
            </form>
            <div id="loading-screen">
                <div id="loading-spinner" class="flex">
                    <div id="loading-box">
                        <img src="/assets/Sample/loading.gif" alt="loading...">
                    </div>
                </div>
            </div>
</body>

</html>
@endsection