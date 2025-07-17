@extends('layouts.blNav')
@section('content')
@include('layouts.modal')
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>TinyMCE in Laravel</title>
     @vite('resources/css/app.css')
     <x-head.tinymce-config />
</head>
     <style>
          body {
          background-image: url("{{ asset('assets/wave.png') }}");
          background-repeat: no-repeat;
          background-position: top;
          background-attachment: fixed;
          background-size: contain;
          }
     </style>
<body>
     <div class="m-auto bg-slate-100 mt-[80px] p-2 shadow-lg bg-gradient-to-r from-[#FFF] to-[#dbeafe] rounded-lg w-11/12">
          <img class="edit_user_img text-center mt-8 w-[370px] m-auto mb-8" src="/assets/Course Requirement.png" alt="SyllabEase Logo">
          <form action="{{ route('bayanihanleader.updateCrq', $syll_id) }}" method="POST">
          @csrf
          @method('PUT')
               <div class="m-2 mx-8">
                    <textarea class=" min-h-[450px]" name="syll_course_requirements" id="myeditorinstance">{{$syllabus->syll_course_requirements}}</textarea>
               </div>
               <div class="text-center">
                    <button type="submit" class="bg-blue mr-[57px] p-2 px-6 font-semibold text-white rounded-lg m-5">Update Syllabus</button>
               </div>
          </form>
     </div>
</body>
</html>
@endsection