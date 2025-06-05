<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SyllabEase</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
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

        function toggleNotifDropdown() {
            var dropdown = document.getElementById('NotifDropdown');
            dropdown.classList.toggle('hidden');
        }
    </script>
    <script>
        // JS for Searchable Select
        $(document).ready(function() {
            $('.select2').select2(); // Initialize Select2 
        });
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
    <x-head.tinymce-config />
</head>

<body class="box-border">
    <div class="">
        <div class="relative">
            <div class="fixed top-0 z-50">

                <nav class="w-screen flex px-6 md:shadow-lg items-center relative bg-blue">
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
                                <a href="{{ route('home') }}">B Teacher</a>
                            </div>
                            <!-- <div class="fixed top-20 start-1 w-48 p-4 bg-yellow border rounded-lg shadow-lg">
                            <div class="relative text-black">
                                <div class="absolute w-6 h-6 -top-8 left-1/2 transform -translate-x-1/2 bg-white rotate-45"></div>
                                Your pop-up content goes here
                            </div>
                        </div> -->
                        </button>
                    </div>
                    <!-- <div class="fixed left-[324px] top-6 opacity-90">
                    <div class="fixed w-4 h-4 transform -translate-x-1/2 bg-white rotate-45 top-8"></div>
                    <div class="absolute bg-white rounded-lg shadow-lg p-4 h-36 w-48 shadow-xl ">
                        <p class="font-semibold text-yellow">Important Note:</p>
                        <p class="mt-2">
                            Click here to switch role.
                        </p>
                        <button class="absolute bottom-0 right-0 mb-3 mr-3 text-blue">Got it.</button>
                    </div>
                </div>
                 -->


                    <ul class="md:px-2 ml-auto md:flex md:space-x-2 absolute md:relative top-full left-0 py-1 right-0">
                        <li>
                            <a href="{{ route('bayanihanteacher.home') }}" class="rounded  borderflex text-white hover:text-black md:inline-flex p-4 items-center hover:bg-seThird {{request()->route()->getName() == 'bayanihanteacher.home' ? 'bg-seThird border-b-4 border-seThird text-white' : ''}}" class="border-b-4 border-seThird rounded  text-white hover:text-black md:inline-flex p-4 items-center hover:bg-seThird">
                                <span>Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('bayanihanteacher.syllabus') }}" class="rounded  borderflex text-white hover:text-black md:inline-flex p-4 items-center hover:bg-seThird {{request()->route()->getName() == 'bayanihanteacher.syllabus' ? 'bg-seThird border-b-4 border-seThird text-white' : ''}}" class="border-b-4 border-seThird flex text-white hover:text-black md:inline-flex p-4 items-center hover:bg-seThird">
                                <span>Syllabus</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('bayanihanteacher.tos') }}" class="rounded  borderflex text-white hover:text-black md:inline-flex p-4 items-center hover:bg-seThird {{request()->route()->getName() == 'bayanihanteacher.tos' ? 'bg-seThird border-b-4 border-seThird text-white' : ''}}" class="border-b-4 border-seThird flex text-white hover:text-black md:inline-flex p-4 items-center hover:bg-seThird">
                                <span>TOS</span>
                            </a>
                        </li>
                        <!-- Notification -->
                        <div class="md:px-2 ml-auto md:flex md:space-x-3 absolute md:relative mt-2 top-full left-0 right-0">
                            <div class="relative parent">
                                <!-- User Avatar and Initials -->
                                <a class="cursor-pointer  w-8 h-8 flex justify-center md:inline-flex hover:text-beige items-center hover:bg-seThird rounded-full justify-center" onclick="toggleNotifDropdown()">
                                    <div class="">
                                        <svg width="25px" height="25px" viewBox="-1.5 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <defs>
                                            </defs>
                                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g id="Dribbble-Light-Preview" transform="translate(-181.000000, -720.000000)" fill="#ffffff">
                                                    <g id="icons" transform="translate(56.000000, 160.000000)">
                                                        <path d="M137.75,574 L129.25,574 L129.25,568 C129.25,565.334 131.375,564 133.498937,564 L133.501063,564 C135.625,564 137.75,565.334 137.75,568 L137.75,574 Z M134.5625,577 C134.5625,577.552 134.0865,578 133.5,578 C132.9135,578 132.4375,577.552 132.4375,577 L132.4375,576 L134.5625,576 L134.5625,577 Z M140.9375,574 C140.351,574 139.875,573.552 139.875,573 L139.875,568 C139.875,564.447 137.359,562.475 134.5625,562.079 L134.5625,561 C134.5625,560.448 134.0865,560 133.5,560 C132.9135,560 132.4375,560.448 132.4375,561 L132.4375,562.079 C129.641,562.475 127.125,564.447 127.125,568 L127.125,573 C127.125,573.552 126.649,574 126.0625,574 C125.476,574 125,574.448 125,575 C125,575.552 125.476,576 126.0625,576 L130.3125,576 L130.3125,577 C130.3125,578.657 131.739438,580 133.5,580 C135.260563,580 136.6875,578.657 136.6875,577 L136.6875,576 L140.9375,576 C141.524,576 142,575.552 142,575 C142,574.448 141.524,574 140.9375,574 L140.9375,574 Z" id="notification_bell-[#1397]">

                                                        </path>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                </a>

                                <!-- Notification Dropdown -->
                                <div id="NotifDropdown" class="hidden max-h-[500px] overflow-y-auto px-3 pb-2 transition duration-300 md:absolute top-full right-0 md:w-[400px] bg-[#f3f4f6] md:shadow-lg md:rounded">
                                    <div class="mt-1 flex flex-row">
                                        <div>
                                            <div class="font-semibold text-lg my-2">
                                                NOTIFICATION
                                            </div>
                                        </div>
                                    </div>
                                    <div> 
                                        @foreach ($notifications as $notification)
                                        <div class="flex items-center bg-white mb-3 cursor-pointer px-2 py-2 hover:bg-gray4 shadow rounded my-1">
                                            <div class="pr-1">
                                                <div class="bg-yellow rounded-full text-xl font-medium w-12 h-12 px-2 flex items-center justify-center text-white mr-3">
                                                    <div>{{ $notification->data['for'] }}</div>
                                                </div>
                                            </div>
                                            <div>
                                                <div>
                                                    <span class="hover:text-blue"><a href="{{ $notification->data['action_url'] }}">
                                                        <span class="font-semibold">{{ $notification->data['course_code'] }}-{{ $notification->data['bg_school_year'] }}</span>: {{ $notification->data['message'] }}</a></span>
                                                </div>
                                                <div class="text-gray text-sm pt-1">{{ $notification->created_at->format('F j, Y, g:i a') }}</div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <li>
                        <a href="{{ route('admin.department') }}" class="flex text-white hover:text-black md:inline-flex p-4 items-center hover:bg-seThird">
                            <span>Department</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.curr') }}" class="flex text-white hover:text-black md:inline-flex p-4 items-center hover:bg-seThird">
                            <span>Curriculum</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course') }}" class="flex text-white hover:text-black md:inline-flex p-4 items-center hover:bg-seThird">
                            <span>Course</span>
                        </a>
                    </li> -->
                        <!-- 
                    #f3a71a
                    #1148b1 
                -->
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

        <main>
            <div class="mt-16">
                @yield('content')
            </div>

        </main>
    </div>





</body>

</html>
<!-- <a class="logout_btn navlinks" href="{{ route('chairperson.home') }}">
                    Home
                </a>
                <a class="logout_btn" href="{{ route('chairperson.programOutcome') }}">
                    Program
                </a> -->