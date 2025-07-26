@extends('layouts.adminSidebar')
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
            /* background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain; */
            background-color: #EEEEEE;
        }
        /* body {
            background-color: #e8e9e9;
        } */
        
/*         
        table
        {
            border: 1px solid;
            border-collapse: collapse;
            padding: 4px;
            border-color: black;
        }
        th{
            background-color: #2468d2;
            color: white;
        } */
    </style>
</head>

<body>
<div class="p-4 pb-10 shadow bg-white border-dashed rounded-lg dark:border-gray-700 mt-14">
    <div class="" id="whole">
        <div class="flex justify-between items-center mb-6">
            <h1 class="font-bold text-4xl text-[#201B50]">Bayanihan Teams</h1>
            <form action="{{ route('admin.createBTeam') }}" method="GET">
                @csrf
                <button type="submit"
                    class="whitespace-nowrap rounded-xl hover:scale-105 transition ease-in-out px-6 py-2 text-black font-semibold flex items-center gap-2"
                    style="background: #d7ecf9;"
                    onmouseover="this.style.background='#c3dff3';"
                    onmouseout="this.style.background='#d7ecf9';">
                    <!-- Modern team/group SVG icon -->
                    <svg class="w-5 h-5" fill="none" stroke="black" stroke-width="1.5" viewBox="0 0 24 24">
                        <circle cx="7" cy="10" r="3"/>
                        <circle cx="17" cy="10" r="3"/>
                        <circle cx="12" cy="16" r="3"/>
                        <path d="M2 20c0-2.5 3-4.5 5-4.5s5 2 5 4.5"/>
                        <path d="M12 20c0-2.5 3-4.5 5-4.5s5 2 5 4.5"/>
                    </svg>
                    Create Bayanihan Team
                </button>
            </form>
        </div>
        <livewire:admin-b-teams />
    </div>
</div>
</body>

</html>
@endsection