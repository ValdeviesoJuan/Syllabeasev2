@extends('layouts.auditorSidebar')
@section('content')
@include('layouts.modal')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
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
        }
    </style>
</head>

<body class="mt-[20px]">
    <div class="m-auto pb-12 p-8 bg-slate-100 mt-[7%] p-2 shadow-lg bg-gradient-to-r from-[#FFF] to-[#dbeafe] rounded-lg w-11/12">
        <div class="flex justify-center align-items-center">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden mb-6">
                    <div class="font-bold text-4xl text-[#201B50] mb-4">Table of Specifications</div>
                </div>
            </div>
        </div>
        <livewire:auditor-tos />
    </div>
</body>

</html>
@endsection