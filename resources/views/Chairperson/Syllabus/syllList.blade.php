@extends('layouts.chairSidebar')

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
    <livewire:styles />
</head>

<body>
<div class="p-4 pb-10 shadow bg-white border-dashed rounded-lg dark:border-gray-700 mt-14">
        <h1 class="font-bold text-4xl text-[#201B50] mb-8">List of Syllabus</h1>
        <div class="">
            <livewire:chair-syllabus-table />
        </div>
        <livewire:scripts />
</body>

</html>
@endsection