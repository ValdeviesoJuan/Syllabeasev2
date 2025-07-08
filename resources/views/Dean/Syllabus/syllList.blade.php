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
            background-color: #EEEEEE;
        }
    </style>
    <livewire:styles />
</head>

<body>
    <div class="p-4 pb-4 shadow bg-white border-dashed rounded-lg dark:border-gray-700 mt-14">
        {{-- <div class="max-w-md  w-[560px] p-6 px-8 rounded-lg shadow-lg"> --}}
                <h1 class="font-bold text-4xl text-[#201B50] mb-8 text-left">List of Syllabus</h1>
        <div class="">
            <livewire:dean-syllabus-table />         
        </div>
        <livewire:scripts />
</body>

</html>
@endsection