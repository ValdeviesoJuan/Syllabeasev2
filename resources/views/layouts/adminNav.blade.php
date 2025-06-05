<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SyllabEase</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        // JS for Searchable Select
        $(document).ready(function() {
            $('.select2').select2(); // Initialize Select2 
        });
    </script>
    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById('dropdown');
            dropdown.classList.toggle('hidden');
        }

        function dropdownTeam() {
            var dropdown = document.getElementById('dropdownTeam');
            dropdown.classList.toggle('hidden');
        }

        function dropdownComment() {
            var dropdown = document.getElementById('dropdownComment');
            dropdown.classList.toggle('hidden');
        }
    </script>
    
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/Sample/se.png') }}">
    <style>
        @media only screen and (min-width: 768px) {
            .parent:hover .child {
                opacity: 1;
                height: auto;
                overflow: none;
                transform: translateY(0);
            }

            .child {
                opacity: 0;
                height: 0;
                overflow: hidden;
                transform: translateY(-10%);
            }
        }
    </style>
    <livewire:styles />
</head>
<body class="box-border">
    <div class="">
        <div class="relative">
            <div class="fixed top-0 z-50" id="nav">
                <nav class="w-screen flex px-6 md:shadow-lg items-center relative bg-blue py-1">
                    <img class="w-48 text-lg font-bold md:py-0 py-4" src="/assets/Sample/syllabease4.png" alt="SyllabEase">
                    <div class="border-2 border-solid border-white rounded-full text-white ml-2">
                        <button class="flex p-0.5 relative">
                        <div class="bg-white rounded-full">
                            <svg fill="#1148b1" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                                <path d="M44,63.3c0-3.4,1.1-7.2,2.9-10.2c2.1-3.7,4.5-5.2,6.4-8c3.1-4.6,3.7-11.2,1.7-16.2c-2-5.1-6.7-8.1-12.2-8
                                s-10,3.5-11.7,8.6c-2,5.6-1.1,12.4,3.4,16.6c1.9,1.7,3.6,4.5,2.6,7.1c-0.9,2.5-3.9,3.6-6,4.6c-4.9,2.1-10.7,5.1-11.7,10.9
                                c-1,4.7,2.2,9.6,7.4,9.6h21.2c1,0,1.6-1.2,1-2C45.8,72.7,44,68.1,44,63.3z M64,48.3c-8.2,0-15,6.7-15,15s6.7,15,15,15s15-6.7,15-15
                                S72.3,48.3,64,48.3z M66.6,64.7c-0.4,0-0.9-0.1-1.2-0.2l-5.7,5.7c-0.4,0.4-0.9,0.5-1.2,0.5c-0.5,0-0.9-0.1-1.2-0.5
                                c-0.6-0.6-0.6-1.7,0-2.5l5.7-5.7c-0.1-0.4-0.2-0.7-0.2-1.2c-0.2-2.6,1.9-5,4.5-5c0.4,0,0.9,0.1,1.2,0.2c0.2,0,0.2,0.2,0.1,0.4
                                L66,58.9c-0.2,0.1-0.2,0.5,0,0.6l1.7,1.7c0.2,0.2,0.5,0.2,0.7,0l2.5-2.5c0.1-0.1,0.4-0.1,0.4,0.1c0.1,0.4,0.2,0.9,0.2,1.2
                                C71.6,62.8,69.4,64.9,66.6,64.7z" />
                            </svg>
                        </div>
                        <div class="mt mx-1 text-[13px]">
                            <a href="{{ route('home') }}">Admin</a>
                        </div>

                        </button>
                    </div>

                    <ul class="md:px-2 ml-auto md:flex md:space-x-3 absolute md:relative top-full left-0 right-0">
                        <li>
                            <a href="{{ route('admin.home') }}" class="rounded  borderflex text-white hover:text-black md:inline-flex p-4 items-center hover:bg-seThird {{request()->route()->getName() == 'admin.home' ? 'bg-seThird border-b-4 border-seThird text-white' : ''}}" class="flex text-white hover:text-black md:inline-flex p-4 items-center hover:bg-seThird">
                                <span>Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.college') }}" class="rounded  borderflex text-white hover:text-black md:inline-flex p-4 items-center hover:bg-seThird {{request()->route()->getName() == 'admin.college' ? 'bg-seThird border-b-4 border-seThird text-white' : ''}}" class="flex text-white hover:text-black md:inline-flex p-4 items-center hover:bg-seThird">
                                <span>College</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.department') }}" class="rounded  borderflex text-white hover:text-black md:inline-flex p-4 items-center hover:bg-seThird {{request()->route()->getName() == 'admin.department' ? 'bg-seThird border-b-4 border-seThird text-white' : ''}}" class="flex text-white hover:text-black md:inline-flex p-4 items-center hover:bg-seThird">
                                <span>Department</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.curr') }}" class="rounded  borderflex text-white hover:text-black md:inline-flex p-4 items-center hover:bg-seThird {{request()->route()->getName() == 'admin.curr' ? 'bg-seThird border-b-4 border-seThird text-white' : ''}}" class="flex text-white hover:text-black md:inline-flex p-4 items-center hover:bg-seThird">
                                <span>Curriculum</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.course') }}" class="rounded  borderflex text-white hover:text-black md:inline-flex p-4 items-center hover:bg-seThird {{request()->route()->getName() == 'admin.course' ? 'bg-seThird border-b-4 border-seThird text-white' : ''}}" class="flex text-white hover:text-black md:inline-flex p-4 items-center hover:bg-seThird">
                                <span>Course</span>
                            </a>
                        </li>

                        {{-- <li class="relative parent">
                            <a class="flex justify-between md:inline-flex text-white hover:text-black p-4 items-center hover:bg-seThird space-x-2">
                                <span>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current pt-1" viewBox="0 0 24 24">
                                    <path d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z" />
                                </svg>
                            </a>
                            <ul class="child transition duration-300 md:absolute top-full right-0 md:w-48 bg-white  md:shadow-lg md:rounded-b ">
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();" class="flex text-black hover:text-black px-4 py-3 hover:bg-seThird">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li> --}}
                        <div class="md:px-2 ml-auto md:flex md:space-x-3 absolute md:relative mt-3 top-full left-0 right-0">
                            <div class="relative parent">
                                <!-- User Avatar and Initials -->
                                <a class="cursor-pointer border-2 w-8 h-8 flex justify-center md:inline-flex text-white hover:text-beige items-center hover:bg-seThird bg-yellow rounded-full bg-white justify-center" onclick="toggleDropdown()">
                                    <div class="text-white text-sm">
                                        {{ Str::upper(substr(Auth::user()->firstname, 0, 1)) . Str::upper(substr(Auth::user()->lastname, 0, 1)) }}
                                    </div>
                                </a>
        
                                <!-- User Profile Dropdown -->
                                <div id="dropdown" class="px-3 pb-7 transition duration-300 md:absolute top-full right-0 md:w-[350px] bg-white bg-opacity-90 md:shadow-lg md:rounded hidden">
                                    <div class="flex flex-row">
                                        <!-- SyllabEase Logo -->
                                        <div>
                                            <img class="w-[125px] text-lg font-bold md:py-0 py-4 m-2" src="/assets/Sample/syllabease.png" alt="SyllabEase">
                                        </div>
        
                                        <!-- Logout and SyllabEase Name -->
                                        <div class="flex items-center ml-auto">
                                            <div class="text-sm text-yellow pr-4">
                                                <a class="mt-2 flex hover:underline hover:underline-offset-4" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="">
                                                    Sign out
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </div>
                                        </div>
                                    </div>
        
                                    <!-- User Information -->
                                    <div class="mt-4 flex flex-row">
                                        <!-- User Avatar with Initials -->
                                        <div class="bg-yellow rounded-full w-[80px] h-[80px] flex items-center justify-center mr-3">
                                            <div class="text-white text-3xl">
                                                {{ Str::upper(substr(Auth::user()->firstname, 0, 1)) . Str::upper(substr(Auth::user()->lastname, 0, 1)) }}
                                            </div>
                                        </div>
        
                                        <!-- User Name, Email, and Profile Link -->
                                        <div>
                                            <div class="font-semibold text-lg">
                                                {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                                            </div>
                                            <div>
                                                {{ Auth::user()->email }}
                                            </div>
                                            <div class="text-blue underline underline-offset-4">
                                                <a href="{{ route('profile.edit') }}">My Profile</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ul>
                </nav>
            </div>
        </div>
        <main class="mt-[90px]">
            @yield('content')
        </main>
    </div>
    <livewire:scripts />
</body>
</html>
