@extends('layouts.blNav')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyllabEase</title>
    @vite('resources/css/app.css')
    <style>
        body {
            background-image: url("{{ asset('assets/wave1.png') }}");
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
        <div class="flex justify-center">
            <div>
                <livewire:bl-create-syllabus />
                <!-- <button type="submit" class="btn btn-primary font-semibold text-white px-6 py-2 rounded-lg m-2 bg-blue">Create Syllabus from Existing Syllabus</button> -->
            </div>
        </div>
        <div class="relative mt-1 flex flex-col bg-gradient-to-r from-[#FFF] to-[#dbeafe]  rounded-xl shadow-lg p-3 mx-auto border border-white bg-white">
            <img class="edit_user_img text-center mt-6 mb-6 w-[280px] m-auto mb-2" src="/assets/Create Syllabus.png" alt="SyllabEase Logo">
            <div class="mx-10">
                <form action="{{ route('bayanihanleader.storeSyllabus') }}" method="POST">
                    @csrf
                    <label for="" class="text-3xl text-black -mb-[30px] font-semibold">Course Details</label>
                    <div class="grid  gap-2 mb-6 md:grid-cols-2">
                        <div class="mb-3">
                            <label for="bg_id" class="flex">Bayanihan Group</label>
                            <select name="bg_id" id="bg_id" class="select2 p-5 w-[390px]" required>
                                @foreach ($bGroups as $bGroup)
                                <option value="{{ $bGroup->bg_id }}">{{ $bGroup->course_code }}: {{ $bGroup->course_title }} {{ $bGroup->bg_school_year}}</option>
                                @endforeach
                            </select>
                            @error('bg_id')
                            <span class="" role="alert">
                                <strong class="">{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="syll_bldg_rm" class="flex">Bldg/Rm No.</label>
                            <input type="text" name="syll_bldg_rm" id="syll_bldg_rm" class="border border-[#a8a29e] rounded p-[5px] w-[390px]" required></input>
                            @error('syll_bldg_rm')
                            <span class="" role="alert">
                                <strong class="">{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid gap-2 mb-6 md:grid-cols-2">
                        <div class="mb-3">
                            <label for="syll_class_schedule" class="flex">Class Schedule</label>
                            <textarea name="syll_class_schedule" id="" cols="30" rows="5" class="border border-[#a8a29e] rounded w-[390px] p-2" required></textarea>

                        </div>


                        <div class="mb-3">
                            <label for="syll_course_description" class="flex">Course Description</label>
                            <textarea name="syll_course_description" id="syll_course_description" cols="30" rows="5" class="border p-2 border-[#a8a29e] rounded w-[390px]" required></textarea>
                            @error('syll_course_description')
                            <span class="" role="alert">
                                <strong class="">{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>


                    <label for="" class="text-3xl text-black -mb-[30px] font-semibold">Instructor Details</label>
                    <div class="flex">

                        <div class="mb-3">
                            <label for="" class="flex">Instructor Name</label>
                            <select name="syll_ins_user_id[]" id="user_id" class="select2 w-[390px] p-2" multiple required>
                                @foreach ($instructors as $instructor)
                                <option value="{{ $instructor->id }}">{{ $instructor->lastname }}, {{ $instructor->firstname }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <span class="" role="alert">
                                <strong class="">{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3 ml-4">
                            <label for="syll_ins_bldg_rm" class="flex">Bldg.Rm. No</label>
                            <input type="text" name="syll_ins_bldg_rm" id="syll_ins_bldg_rm" class="border rounded border-[#a8a29e] p-2 w-[390px]" required></input>
                            @error('syll_ins_bldg_rm')
                            <span class="" role="alert">
                                <strong class="">{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3 -mr-50">
                        <label for="syll_ins_consultation" class="flex">Consultation Schedule</label>
                        <textarea name="syll_ins_consultation" id="syll_ins_consultation" cols="30" rows="5" class="border border-[#a8a29e] w-[390px] p-2 rounded" required></textarea>
                        @error('syll_ins_consultation')
                        <span class="" role="alert">
                            <strong class="">{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary font-semibold text-white px-6 py-2 rounded-lg m-2 mt-30 mb-4 bg-blue">Create Syllabus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
@endsection