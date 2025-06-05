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
        <div class="relative mt-[100px] flex flex-col bg-gradient-to-r from-[#FFF] to-[#dbeafe] p-12 px-8 md:space-y-0 rounded-xl shadow-lg p-3 mx-auto border border-white bg-white">
            <img class="edit_user_img text-center mt-6 w-[320px] m-auto mb-2" src="/assets/Edit Syllabus Header.png" alt="SyllabEase Logo">
    <form class="p-12" action="{{ route('bayanihanleader.updateSyllabus', $syll_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid  gap-6 mb-6 md:grid-cols-3">
            <div class="mb-3">
                <label class="flex" for="bg_id">Bayanihan Group</label>
                <select name="bg_id" id="bg_id" class="select2 border border-[#a8a29e] rounded p-[5px] w-[300px]" required>
                    @foreach ($bGroups as $bGroup)
                    <option value="{{ $bGroup->bg_id }}" {{$bGroup->bg_id == $syllabus->syll_bg_id ? 'selected' : ''}}>{{ $bGroup->course_code }}: {{ $bGroup->course_title }} {{ $bGroup->bg_school_year}}</option>
                    @endforeach
        
                </select>
                @error('bg_id')
                <span class="" role="alert">
                    <strong class="">{{ $message }}</strong>
                </span>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="flex" for="syll_bldg_rm">Bldg/Rm No.:</label>
                <input type="text" name="syll_bldg_rm" id="syll_bldg_rm" class="form-control border border-[#a8a29e] rounded p-[5px] w-[300px]" value="{{$syllabus->syll_bldg_rm}}" required></input>
                @error('syll_bldg_rm')
                <span class="" role="alert">
                    <strong class="">{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="flex" for="user_id">Instructor:</label>
                <select name="syll_ins_user_id[]" id="user_id" class="form-control select2 w-min-05 border border-[#a8a29e] rounded p-[5px] w-[300px]" multiple required>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}" 
                    {{ in_array($user->id, $syllabus->SyllabusInstructors->pluck('syll_ins_user_id')->toArray()) ? 'selected' : '' }}>
                    {{ $user->lastname }}, {{ $user->firstname }}
                </option>
                    @endforeach
                    dd($instructor->id == $syllabus->SyllabusInstructors->first()->user_id)
                </select>

                @error('user_id')
                <span class="" role="alert">
                    <strong class="">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="grid  gap-6 mb-6 md:grid-cols-2">
            <div class="mb-3">
                <label class="flex" for="syll_class_schedule">Class Schedule:</label>
                <textarea name="syll_class_schedule" id="syll_class_schedule" class="border border-[#a8a29e] rounded w-[450px] p-2" cols="30" rows="5" value="{{$syllabus->syll_class_schedule}}" required>
                {{$syllabus->syll_class_schedule}}
                </textarea>
            </div>

            <div class="mb-3">
                <label class="flex" for="syll_ins_consultation">Consultation Schedule:</label>
                <textarea name="syll_ins_consultation" id="syll_ins_consultation" class="border border-[#a8a29e] rounded w-[450px] p-2" cols="30" rows="5" value="{{$syllabus->syll_ins_consultation}}" required>{{$syllabus->syll_ins_consultation}}</textarea>
                @error('syll_ins_consultation')
                <span class="" role="alert">
                    <strong class="">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="grid  gap-6 mb-6 md:grid-cols-2">
            <div class="mb-3">
                <label class="flex" for="syll_ins_bldg_rm">Bldg.Rm. No:</label>
                <input type="text" name="syll_ins_bldg_rm" id="syll_ins_bldg_rm" class="form-control border border-[#a8a29e] rounded p-[5px] w-[300px]" value="syll_ins_bldg_rm"required></input>
                @error('syll_ins_bldg_rm')
                <span class="" role="alert">
                    <strong class="">{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="flex" for="syll_course_description">Course Description:</label>
                <textarea name="syll_course_description" id="syll_course_description" cols="30" class="border border-[#a8a29e] rounded w-[450px] p-2" rows="5" value="{{$syllabus->syll_course_description}}"required>{{$syllabus->syll_course_description}}</textarea>
                @error('syll_course_description')
                <span class="" role="alert">
                    <strong class="">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary font-semibold text-white px-6 py-2 rounded-lg m-2 mt-30 bg-blue">Update Syllabus Header</button>
        </div>    </form>

</body>

</html>
@endsection