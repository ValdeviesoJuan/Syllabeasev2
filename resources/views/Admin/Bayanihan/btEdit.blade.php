@extends('layouts.adminSidebar')
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
    <div class="p-4 pb-10 flex items-center justify-center  mt-14">
        <div class="max-w-md bg-gradient-to-r from-[#FFF] to-[#dbeafe] w-[560px] p-6 px-8 rounded-lg shadow-lg">
            <img class="edit_user_img text-center mt-4 w-[320px] m-auto mb-6" src="/assets/Edit Bayanihan Team.png" alt="SyllabEase Logo">
            @if(session('error'))
                <div class="bg-[#fca5a5] border border-[#f87171] text-[#EF4444] px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-100 border border-green text-green px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('admin.updateBTeam', $bGroup->bg_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="flex" for="course_id">Courses</label>
                    <select name="course_id" id="course_id" class="form-control select2 px-1 py-[6px] w-full border rounded border-gray" required>
                        @foreach ($courses as $course)
                        <option value="{{ $course->course_id }}" {{ $course->course_id == $bGroup->course_id ? 'selected' : '' }}>{{ $course->course_code }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="flex" for="bl_user_id">Bayanihan Leaders</label>
                    <select name="bl_user_id[]" id="bl_user_id" class="form-control select2 px-1 py-[6px] w-full border rounded border-gray" multiple required>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $bGroup->leaders->contains('user_id', $user->id) ? 'selected' : '' }}>{{ $user->lastname }}, {{ $user->firstname }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="flex" for="bm_user_id">Bayanihan Members</label>
                    <select name="bm_user_id[]" id="bm_user_id" class="form-control select2 px-1 py-[6px] w-full border rounded border-gray" multiple required>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $bGroup->members->contains('user_id', $user->id) ? 'selected' : '' }}>{{ $user->lastname }}, {{ $user->firstname }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <div>
                        <label for="bg_school_year">School Year</label>
                    </div>
                        <select name="bg_school_year" id="bg_school_year" value="{{ $bGroup->bg_school_year }}" class="select1 px-1 py-[6px] w-full border rounded border-[#9ca3af] " required>
                            <option value="2023-2024" {{ $bGroup->bg_school_year == '2023-2024' ? 'selected' : '' }}>2023-2024</option>
                            <option value="2024-2025" {{ $bGroup->bg_school_year == '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                            <option value="2025-2026" {{ $bGroup->bg_school_year == '2025-2026' ? 'selected' : '' }}>2025-2026</option>
                            <option value="2026-2027" {{ $bGroup->bg_school_year == '2026-2027' ? 'selected' : '' }}>2026-2027</option>
                            <option value="2027-2028" {{ $bGroup->bg_school_year == '2027-2028' ? 'selected' : '' }}>2027-2028 </option>
                            <option value="2027-2028" {{ $bGroup->bg_school_year == '2028-2029' ? 'selected' : '' }}>2028-2029 </option>
                            <option value="2027-2028" {{ $bGroup->bg_school_year == '2029-2030' ? 'selected' : '' }}>2029-2030 </option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="text-white font-semibold px-6 py-2 rounded-lg m-2 mt-4 mb-4 bg-blue">Update Bayanihan Team</button>
                </div>    
            </form>
        </div>
    </div>
</body>

</html>
@endsection