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
        /* background-image: url("{{ asset('assets/Wave1.png') }}");
        background-repeat: no-repeat;
        background-position: top;
        background-attachment: fixed;
        min-width: 100vh;
        background-size: contain; */
        background-color: #EEEEEE;
    }
    </style>
</head>

<body>
    <div class="top-0 mt-12">
        <div class="flex flex-col float-left mb-20">
            <div class="py-12 px-12 -mt-12 flex flex-col p-12 md:space-y-0 rounded-xl mx-auto bg-transparent">
                <div class="mb-5 ml-10 mt-4 pt-2 w-max h-[40px] hover:scale-105 transition ease-in-out bg-blue  text-white rounded-xl hover:bg-blue">
                <form action="{{ route('dean.createDeadline') }}" method="GET">
                    @csrf
                    <button type="submit" class="flex px-5 text-ml">
                        <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23 12C23 12.3545 22.9832 12.7051 22.9504 13.051C22.3838 12.4841 21.7204 12.014 20.9871 11.6675C20.8122 6.85477 16.8555 3.00683 12 3.00683C7.03321 3.00683 3.00683 7.03321 3.00683 12C3.00683 16.8555 6.85477 20.8122 11.6675 20.9871C12.014 21.7204 12.4841 22.3838 13.051 22.9504C12.7051 22.9832 12.3545 23 12 23C5.92487 23 1 18.0751 1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12Z" fill="#ffffff" />
                            <path d="M13 11.8812L13.8426 12.3677C13.2847 12.7802 12.7902 13.2737 12.3766 13.8307L11.5174 13.3346C11.3437 13.2343 11.2115 13.0898 11.1267 12.9235C11 12.7274 11 12.4667 11 12.4667V6C11 5.44771 11.4477 5 12 5C12.5523 5 13 5.44772 13 6V11.8812Z" fill="#ffffff" />
                            <path d="M18 15C17.4477 15 17 15.4477 17 16V17H16C15.4477 17 15 17.4477 15 18C15 18.5523 15.4477 19 16 19H17V20C17 20.5523 17.4477 21 18 21C18.5523 21 19 20.5523 19 20V19H20C20.5523 19 21 18.5523 21 18C21 17.4477 20.5523 17 20 17H19V16C19 15.4477 18.5523 15 18 15Z" fill="#ffffff" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M18 24C21.3137 24 24 21.3137 24 18C24 14.6863 21.3137 12 18 12C14.6863 12 12 14.6863 12 18C12 21.3137 14.6863 24 18 24ZM18 22.0181C15.7809 22.0181 13.9819 20.2191 13.9819 18C13.9819 15.7809 15.7809 13.9819 18 13.9819C20.2191 13.9819 22.0181 15.7809 22.0181 18C22.0181 20.2191 20.2191 22.0181 18 22.0181Z" fill="#ffffff" />
                        </svg>
                        <div class="px-2 ml-1">
                            Set Deadline
                        </div>
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
                            <form action="{{ route('dean.editDeadline', $dl->dl_id) }}" method="GET">
                                @csrf
                            <button type="submit" class="btn btn-danger px-14 text-white bg-blue font-semibold hover:bg-[#2563eb] shadow-lg p-1 rounded-lg mt-6">Edit</button>
                            </form>
                            <form action="{{ route('dean.destroyDeadline', $dl->dl_id) }}" method="POST">
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