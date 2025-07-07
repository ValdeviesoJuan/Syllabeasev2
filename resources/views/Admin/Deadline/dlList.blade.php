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
        background-image: url("{{ asset('assets/Wave1.png') }}");
        background-repeat: no-repeat;
        background-position: top;
        background-attachment: fixed;
        min-width: 100vh;
        background-size: contain; 
        background-color: #EEEEEE;
    }
    </style>
</head>

<body>
    <div class="top-0 mt-12">
        <div class="flex flex-col float-left mb-20">
            <div class="py-12 px-12 -mt-12 flex flex-col p-12 md:space-y-0 rounded-xl mx-auto bg-transparent">
                <div class="mb-5 mt-4 pt-2 text-center">
                    <form action="{{ route('admin.createDeadline') }}" method="GET" class="inline-block">
                        @csrf
                        <button 
                            type="submit"
                            class="whitespace-nowrap rounded-xl hover:scale-105 transition ease-in-out px-6 py-2 text-black font-semibold flex items-center gap-2 m-auto bg-[#d7ecf9]"
                            style="background: #d7ecf9;"
                            onmouseover="this.style.background='#c3dff3';"
                            onmouseout="this.style.background='#d7ecf9';"
                        >
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect x="3" y="4" width="18" height="16" rx="2" stroke="black" stroke-width="1.5" fill="none"/>
                                <path d="M16 2v4M8 2v4" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M8 14l3 3l5-5" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Set Deadline
                        </button>
                    </form>
                </div>

                <div class="grid gap-[8%] md:grid-cols-4">
                    @foreach($deadlines as $dl)
                    <div class="role_form m-4 p-4 w-[350px] bg-gradient-to-r from-[#FFF] to-[#dbeafe] h-[300px] rounded-xl transform hover:scale-105 transition duration-500 shadow-lg">
                        <div class="text-center font-bold text-2xl mb-4 text-sePrimary">Deadline</div>
                        <div class="text-blue"><label class="text-left text-black" for="">School Year: </label>
                            {{$dl->dl_school_year}}</div>
                        <div class="text-blue"><label class="text-left text-black" for="">Semester: </label>
                            {{$dl->dl_semester}}</div>
                        <div class="text-blue"><label class="text-left text-black" for="">Syllabus Deadline: </label>
                            {{$dl->dl_syll}}</div>
                        <div class="text-blue"><label class="text-left text-black" for="">TOS Midterm Deadline: </label>
                            {{$dl->dl_tos_midterm}}</div>
                        <div class="text-blue"><label class="text-left text-black" for="">TOS Final Deadline: </label>
                            {{$dl->dl_tos_final}}</div>
                        <div class="text-center">
                            <form action="" method="GET">
                                @csrf
                            <button type="submit" class="btn btn-danger px-14 text-white bg-blue font-semibold hover:bg-[#2563eb] shadow-lg p-1 rounded-lg mt-6">Edit</button>
                            </form>
                            <form action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger px-12 mt-4 text-[#6b7280] bg-white font-semibold hover:text-black shadow-lg p-1 rounded-lg">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
                    
                </div>
            </div>
        </div>
    </div>
   
</body>

</html>
 @endsection