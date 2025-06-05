<!-- @-extends('layouts.deanNav') -->
@extends('layouts.deanSidebar')

@section('content')
@include('layouts.modal')
@vite('resources/css/app.css')

<style>
        .bg svg {
            transform: scaleY(-1);
            min-width: '1880'
        }

        body {
            background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain;
        }
    </style>

<div class="flex flex-col justify-center mb-20">
    <div class="relative mt-[100px] flex flex-col bg-gradient-to-r from-[#FFF] to-[#dbeafe] p-12 px-8 md:space-y-0 rounded-xl shadow-lg p-3 mx-auto border border-white bg-white">
        <img class="edit_user_img text-center mt-6 w-[400px] m-auto mb-2" src="/assets/Edit Syllabus and TOS Deadline.png" alt="SyllabEase Logo">
        <form action="{{ route('dean.updateDeadline', $deadline->dl_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="m-4">
                <div>
                    <label for="dl_syll">Syllabus Deadline</label>
                </div>
                <input type="datetime-local" name="dl_syll" id="dl_syll" class="px-1 py-[6px] w-full border rounded border-gray" value="{{ old('dl_syll', $deadline->dl_syll) }}" required>
            </div>
            <div class="m-4">
                <div>
                    <label for="dl_tos_midterm">TOS Midterm Deadline</label>
                </div>
                <input type="datetime-local" name="dl_tos_midterm" id="dl_tos" class="px-1 py-[6px] w-full border rounded border-gray" value="{{ old('dl_tos_midterm', $deadline->dl_tos_midterm) }}" required>
            </div>
            <div class="m-4">
                <div>
                    <label for="dl_tos_final">TOS Final Deadline</label>
                </div>
                <input type="datetime-local" name="dl_tos_final" id="dl_tos_final" class="px-1 py-[6px] w-full border rounded border-gray" value="{{ old('dl_tos_final', $deadline->dl_tos_final) }}" required>
            </div>
            <div class="m-4">
                <div>
                    <label for="dl_school_year">School Year</label>
                </div>
                <select name="dl_school_year" id="dl_school_year" class="select1 w-full px-1 py-[6px] border rounded border-[#a3a3a3]" required>
                        <option value="2023-2024" {{ old('dl_school_year', $deadline->dl_school_year) == '2023-2024' ? 'selected' : '' }}>2023-2024</option>
                        <option value="2024-2025" {{ old('dl_school_year', $deadline->dl_school_year) == '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                        <option value="2025-2026" {{ old('dl_school_year', $deadline->dl_school_year) == '2025-2026' ? 'selected' : '' }}>2025-2026</option>
                        <option value="2026-2027" {{ old('dl_school_year', $deadline->dl_school_year) == '2026-2027' ? 'selected' : '' }}>2026-2027</option>
                        <option value="2027-2028" {{ old('dl_school_year', $deadline->dl_school_year) == '2027-2028' ? 'selected' : '' }}>2027-2028</option>
                        <option value="2028-2029" {{ old('dl_school_year', $deadline->dl_school_year) == '2028-2029' ? 'selected' : '' }}>2028-2029</option>
                        <option value="2029-2030" {{ old('dl_school_year', $deadline->dl_school_year) == '2029-2030' ? 'selected' : '' }}>2029-2030</option>
                    </select>
            </div>
            <div class="m-4">
                <div>
                    <label for="dl_semester">Semester</label>
                </div>
                <select name="dl_semester" id="dl_semester" class="select1 w-full px-1 py-[6px] border rounded border-[#a3a3a3]" required>
                    <option value="1st Semester" {{ old('dl_semester', $deadline->dl_semester) == '1st Semester' ? 'selected' : '' }}>1st Semester</option>
                    <option value="2nd Semester" {{ old('dl_semester', $deadline->dl_semester) == '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
                    <option value="Mid Year" {{ old('dl_semester', $deadline->dl_semester) == 'Mid Year' ? 'selected' : '' }}>Mid Year</option>
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="text-white font-semibold px-6 py-2 rounded-lg m-2 mt-4 mb-4 bg-blue">Update Deadline</button>
            </div>
        </form>
    </div>
</div>

@endsection