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
            <div class="">
            <div class="flex justify-between items-center mb-6">
    <h1 class="font-bold text-4xl text-[#201B50]">Bayanihan Teams</h1>
    <form action="{{ route('chairperson.createBTeam') }}" method="GET">
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

                <div class="">
                    <livewire:chair-b-teams />
                </div>
                <!-- BT Cards                                 -->
<!-- 
                <div class="ml-10 mr-5">
                    @foreach ($bgroups as $bgroup)
                    <div class="flex grid-cols-4 gap-4">
                        <div class="w-60 h-72 h-auto min-h-fit bg-white rounded-xl shadow-xl hover:scale-105 transition ease-in-out">
                            <div class="w-fit">
                                @php
                                $imageNumber = ($loop->iteration - 1) % 10 + 1;
                                @endphp
                                <img class="rounded-t-xl h-40" src="/assets/bg/{{ $imageNumber }}.png" alt="">
                            </div>
                            <div class="text-xl font-semibold mx-3 text-neutral-900 my-1">
                                {{ $bgroup->course_code }} - {{ $bgroup->bg_school_year }}
                            </div>
                            <div class="text-neutral-900 font-normal mx-3">
                                <h4 class="font-medium">Leader:</h4>
                                @foreach ($bleaders[$bgroup->bg_id] ?? [] as $leader)
                                <p>{{ $leader->lastname }}, {{ $leader->firstname }}</p>
                                @endforeach
                            </div>
                            <div class="text-neutral-900 font-normal mx-3">
                                <h4 class="font-medium">Members:</h4>
                                @foreach ($bmembers[$bgroup->bg_id] ?? [] as $member)
                                <p>{{ $member->lastname }}, {{ $member->firstname }}</p>
                                @endforeach
                            </div>
                            <div class="mr-3 justify-end flex ">
                                <form action="{{ route('chairperson.editBTeam', $bgroup->bg_id) }}" method="GET">
                                    @csrf
                                    <button type="submit" class="bg-blue p-1 rounded-lg mr-2 mb-2 hover:bg-green">
                                        <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </form>

                                <form action="{{ route('chairperson.destroyBTeam',$bgroup->bg_id) }}" method="Post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-blue p-1 rounded-lg mr-2 shadow-lg hover:bg-pink">
                                        <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 11V17" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M14 11V17" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M4 7H20" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div> -->


            </div>
        </div>


    </div>
</body>

</html>
@endsection