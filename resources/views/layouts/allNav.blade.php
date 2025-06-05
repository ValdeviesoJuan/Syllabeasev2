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
    </script>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/Sample/se.png') }}">
    <style>
        @media only screen and (min-width: 768px) {
            .parent:hover .child {
                opacity: 1;
                height: auto;
                overflow: none;
                transform: translateY(0);
                transition: opacity 0.3s ease-in-out, height 0.3s ease-in-out, transform 0.3s ease-in-out;

            }

            .child {
                opacity: 0;
                height: 0;
                overflow: hidden;
                transform: translateY(-10%);
                transition: opacity 0.3s ease-in-out, height 0.3s ease-in-out, transform 0.3s ease-in-out;
            }
        }
    </style>
    <x-head.tinymce-config />
</head>

<body class="box-border">
    <div class="">
        <div class="relative">
            <div class="fixed top-0 z-50">

                <nav class="w-screen flex px-6 md:shadow-lg items-center relative bg-blue py-1">
                    <img class="w-48 text-lg font-bold md:py-0 py-4" src="/assets/Sample/syllabease4.png" alt="SyllabEase">

                    <div class="md:px-2 ml-auto md:flex md:space-x-3 absolute md:relative top-full left-0 right-0">
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
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="">
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

            </nav>
        </div>
    </div>
    <main>
        <div class="mt-[80px]">
            @yield('content')
        </div>

    </main>
    </div>
</body>

</html>