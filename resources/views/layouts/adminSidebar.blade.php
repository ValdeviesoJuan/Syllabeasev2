<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Syllabease</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/Sample/se.png') }}">
</head>

<script>
    //JS for Searchable Select
    $(document).ready(function() {
        $('.select2').select2(); // Initialize Select2 
    });
</script>

<body>
    <nav class="fixed top-0 z-50 w-full bg-white border- shadow border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-2 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>
                    <a href="#" class="flex ml-[40px] ml-[35px] ms-2 md:me-24">
                        <img src="/assets/Sample/syllabease.png" class="h-8 me-3" alt="FlowBite Logo" />
                    </a>
                </div>

                <div class="flex items-center">   
                    <div class="flex items-center ms-3">
                        <div>
                            <button type="button" class="flex text-sm bg-white justify-center items-center rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-notif">
                                <span class="sr-only">Open user menu</span>
                                <div class="w-8 h-8 rounded-full text-white text-sm flex justify-center items-center">
                                    <svg width="25px" height="25px" viewBox="-1.5 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <defs>
                                        </defs>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g id="Dribbble-Light-Preview" transform="translate(-181.000000, -720.000000)" fill="#2468d2">
                                                <g id="icons" transform="translate(56.000000, 160.000000)">
                                                    <path d="M137.75,574 L129.25,574 L129.25,568 C129.25,565.334 131.375,564 133.498937,564 L133.501063,564 C135.625,564 137.75,565.334 137.75,568 L137.75,574 Z M134.5625,577 C134.5625,577.552 134.0865,578 133.5,578 C132.9135,578 132.4375,577.552 132.4375,577 L132.4375,576 L134.5625,576 L134.5625,577 Z M140.9375,574 C140.351,574 139.875,573.552 139.875,573 L139.875,568 C139.875,564.447 137.359,562.475 134.5625,562.079 L134.5625,561 C134.5625,560.448 134.0865,560 133.5,560 C132.9135,560 132.4375,560.448 132.4375,561 L132.4375,562.079 C129.641,562.475 127.125,564.447 127.125,568 L127.125,573 C127.125,573.552 126.649,574 126.0625,574 C125.476,574 125,574.448 125,575 C125,575.552 125.476,576 126.0625,576 L130.3125,576 L130.3125,577 C130.3125,578.657 131.739438,580 133.5,580 C135.260563,580 136.6875,578.657 136.6875,577 L136.6875,576 L140.9375,576 C141.524,576 142,575.552 142,575 C142,574.448 141.524,574 140.9375,574 L140.9375,574 Z" id="notification_bell-[#1397]">

                                                    </path>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </button>
                        </div>

                    </div>

                    <div class="flex items-center ms-3">
                        <div>
                            <button type="button" class="flex text-sm bg-yellow justify-center items-center rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <div class="w-8 h-8 rounded-full text-white text-sm flex justify-center items-center">
                                    {{ Str::upper(substr(Auth::user()->firstname, 0, 1)) . Str::upper(substr(Auth::user()->lastname, 0, 1)) }}
                                </div>
                            </button>
                        </div>
                        <div class="w-[350px] z-50 hidden my-4 text-base shadow-xl px-4 py-2 list-none bg-white rounded dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                            <div class="flex flex-row">
                                <!-- SyllabEase Logo -->
                                <div>
                                    <img class="w-[125px] text-lg font-bold md:py-0 py-4 m-2" src="/assets/Sample/syllabease.png" alt="SyllabEase">
                                </div>

                                <!-- Logout and SyllabEase Name -->
                                <div class="flex items-center ml-auto">
                                    <div class="text-sm text-yellow pr-4">
                                        <a class="mt-1 flex hover:underline hover:underline-offset-4" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="">
                                            Sign out
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- User Information -->
                            <div class="mt-4 flex flex-row mb-[20px]">
                                <!-- User Avatar with Initials -->
                                <div class="bg-yellow rounded-full w-[80px] h-[80px] flex items-center justify-center mr-3">
                                    <div class="text-white text-3xl tracking-widest">
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

            </div>
        </div>
    </nav>

    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-[65px] transition-transform -translate-x-full bg-blue border- border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
        <div class="flex justify-center mb-[40px]">
            <div class="border-2 border-solid border-white rounded-full text-white ml-2 w-min">
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
                    <div>
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 15L12 20L17 15M7 9L12 4L17 9" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </button>
            </div>
        </div>

        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-roles">
            <div class="px-4 py-3" role="none">
                <p class="text-sm text-gray-900 dark:text-white font-semibold" role="none">
                    ROLES
                </p>
            </div>
            <ul class="py-1" role="none">
                <li>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                        Role dani
                    </a>
                </li>
        </div>

        <div class="h-full px-3 pb-4 overflow-y-auto bg-blue dark:bg-gray-800 ">

            <ul class="space-y-2 font-">
                <li>
                    <a href="{{ route('admin.home') }}" class="{{request()->route()->getName() == 'admin.home' ? 'bg-blue4' : ''}} flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-blue4 dark:hover:bg-gray-700 group">
                        <svg class="w-6 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="#ffffff" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 45.973 45.972" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M44.752,20.914L25.935,2.094c-0.781-0.781-1.842-1.22-2.946-1.22c-1.105,0-2.166,0.439-2.947,1.22L1.221,20.914
			c-1.191,1.191-1.548,2.968-0.903,4.525c0.646,1.557,2.165,2.557,3.85,2.557h2.404v13.461c0,2.013,1.607,3.642,3.621,3.642h3.203
			V32.93c0-0.927,0.766-1.651,1.692-1.651h6.223c0.926,0,1.673,0.725,1.673,1.651v12.168h12.799c2.013,0,3.612-1.629,3.612-3.642
			V27.996h2.411c1.685,0,3.204-1,3.85-2.557C46.3,23.882,45.944,22.106,44.752,20.914z" />
                                </g>
                            </g>
                        </svg>
                        <span class="ms-3">Home</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.syllabus') }}" class="{{request()->route()->getName() == 'bayanihanleader.syllabus' ? 'bg-blue4' : ''}} flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-blue4 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-6 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="#ffffff" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 31.867 31.867" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M24.963,2.609C24.963,1.168,23.795,0,22.356,0H4.421C3.038,0,1.917,1.121,1.917,2.504v21.762
			c0,1.441,1.168,2.609,2.609,2.609h17.827c1.441,0,2.609-1.168,2.609-2.609L24.963,2.609L24.963,2.609z M22.364,22.294
			c0,1.095-0.889,1.983-1.983,1.983H6.498c-1.095,0-1.983-0.889-1.983-1.983V4.514c0-1.095,0.888-1.983,1.983-1.983h13.883
			c1.094,0,1.981,0.888,1.981,1.983L22.364,22.294L22.364,22.294z"></path>
                                    <path d="M25.989,4.993v2.599c0.791,0,1.435,0.643,1.435,1.435v18.875c0,0.792-0.644,1.435-1.435,1.435H10.876
			c-0.755,0-1.368-0.612-1.368-1.368H6.977v1.289c0,1.441,1.168,2.609,2.609,2.609h17.757c1.439,0,2.607-1.169,2.607-2.609V7.602
			c0-1.441-1.168-2.609-2.607-2.609H25.989z"></path>
                                    <path d="M7.799,8.411H19.31c0.707,0,1.279-0.558,1.279-1.265S20.017,5.88,19.31,5.88H7.799c-0.707,0-1.279,0.559-1.279,1.266
			C6.521,7.853,7.092,8.411,7.799,8.411z"></path>
                                    <path d="M7.799,12.651H19.31c0.707,0,1.279-0.561,1.279-1.265c0-0.707-0.572-1.265-1.279-1.265H7.799
			c-0.707,0-1.279,0.558-1.279,1.265C6.521,12.09,7.092,12.651,7.799,12.651z"></path>
                                    <path d="M7.799,16.891H19.31c0.707,0,1.279-0.56,1.279-1.265c0-0.706-0.572-1.265-1.279-1.265H7.799
			c-0.707,0-1.279,0.559-1.279,1.265C6.521,16.331,7.092,16.891,7.799,16.891z"></path>
                                    <path d="M7.799,20.994H19.31c0.707,0,1.279-0.559,1.279-1.266c0-0.705-0.572-1.267-1.279-1.267H7.799
			c-0.707,0-1.279,0.562-1.279,1.267C6.521,20.436,7.092,20.994,7.799,20.994z"></path>
                                </g>
                            </g>
                        </svg>
                        <span class="ms-3">Syllabus</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.tos') }}" class="{{request()->route()->getName() == 'auditor.tos' ? 'bg-blue4' : ''}} flex items-center p-2 text-white rounded-lg dark:text-white  hover:bg-blue4 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-6 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" width="179.53818mm" height="179.53818mm" viewBox="0 0 179.53818 179.53818" version="1.1" id="svg1" inkscape:export-filename="courses.svg" inkscape:export-xdpi="79.62088" inkscape:export-ydpi="79.62088" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg">
                            <sodipodi:namedview id="namedview1" pagecolor="#505050" bordercolor="#eeeeee" borderopacity="1" inkscape:showpageshadow="0" inkscape:pageopacity="0" inkscape:pagecheckerboard="0" inkscape:deskcolor="#505050" inkscape:document-units="mm" />
                            <defs id="defs1" />
                            <g inkscape:label="Layer 1" inkscape:groupmode="layer" id="layer1" transform="translate(-15.755283,-77.661276)">
                                <rect style="fill:#ffffff;fill-opacity:1;fill-rule:evenodd;stroke-width:0.231;stroke-linecap:round" id="rect1" width="179.53818" height="179.53816" x="15.755282" y="77.66127" ry="22.909351" />
                                <text xml:space="preserve" style="font-weight:bold;font-size:79.1731px;font-family:Octarine;-inkscape-font-specification:'Octarine, Bold';fill:#2468d2;fill-opacity:1;fill-rule:evenodd;stroke-width:0.547526;stroke-linecap:round" x="25.193558" y="190.14262" id="text2" transform="scale(0.9670732,1.0340479)">
                                    <tspan sodipodi:role="line" id="tspan2" style="fill:#2468d2;fill-opacity:1;stroke-width:0.547526" x="25.193558" y="190.14262">TOS</tspan>
                                </text>
                            </g>
                        </svg>

                        <span class="flex-1 ms-3 whitespace-nowrap">TOS</span>
                    </a>
                </li>
                            
                <li>
                    <a href="{{ route('admin.bayanihan') }}" class="{{request()->route()->getName() == 'admin.bayanihan' ? 'bg-blue4' : ''}} flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-blue4 dark:hover:bg-gray-700 group">
                        <svg class="w-6 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="#ffffff" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 45.973 45.972" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M44.752,20.914L25.935,2.094c-0.781-0.781-1.842-1.22-2.946-1.22c-1.105,0-2.166,0.439-2.947,1.22L1.221,20.914
			c-1.191,1.191-1.548,2.968-0.903,4.525c0.646,1.557,2.165,2.557,3.85,2.557h2.404v13.461c0,2.013,1.607,3.642,3.621,3.642h3.203
			V32.93c0-0.927,0.766-1.651,1.692-1.651h6.223c0.926,0,1.673,0.725,1.673,1.651v12.168h12.799c2.013,0,3.612-1.629,3.612-3.642
			V27.996h2.411c1.685,0,3.204-1,3.85-2.557C46.3,23.882,45.944,22.106,44.752,20.914z" />
                                </g>
                            </g>
                        </svg>
                        <span class="ms-3">Bayanihan Team</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.college') }}" class="{{ request()->route()->getName() == 'admin.college' ? 'bg-blue4' : '' }} flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-blue4 dark:hover:bg-gray-700 group">
                        <svg class="w-6 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L1 7l11 5 9-4.09V17h2V7L12 2z"></path>
                            <path d="M4 10v10h2v-4h2v4h2V10H4zm10 0v10h2v-4h2v4h2V10h-6z"></path>
                        </svg>
                        <span class="ms-3">College</span>
                    </a>
                </li>



                <li>
                    <a href="{{ route('admin.department') }}" class="{{request()->route()->getName() == 'admin.department' ? 'bg-blue4' : ''}} flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-blue4 dark:hover:bg-gray-700 group">
                        <svg class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 24 24" version="1.1">
                            <title>department_svg</title>
                            <g id="页面-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Development" transform="translate(-768.000000, -48.000000)" fill-rule="nonzero">
                                    <g id="department_svg" transform="translate(768.000000, 48.000000)">
                                        <path d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z" id="MingCute" fill-rule="nonzero">
                        
                        </path>
                                        <path d="M12,3 C10.3431,3 9,4.34315 9,6 C9,7.30622 9.83481,8.41746 11,8.82929 L11,11 L8,11 C6.34315,11 5,12.3431 5,14 L5,15.1707 C3.83481,15.5825 3,16.6938 3,18 C3,19.6569 4.34315,21 6,21 C7.65685,21 9,19.6569 9,18 C9,16.6938 8.16519,15.5825 7,15.1707 L7,14 C7,13.4477 7.44772,13 8,13 L16,13 C16.5523,13 17,13.4477 17,14 L17,15.1707 C15.8348,15.5825 15,16.6938 15,18 C15,19.6569 16.3431,21 18,21 C19.6569,21 21,19.6569 21,18 C21,16.6938 20.1652,15.5825 19,15.1707 L19,14 C19,12.3431 17.6569,11 16,11 L13,11 L13,8.82929 C14.1652,8.41746 15,7.30622 15,6 C15,4.34315 13.6569,3 12,3 Z" id="路径" fill="#FFF">
                        
                        </path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <span class="ms-3">Department</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.curr') }}" class="{{request()->route()->getName() == 'admin.curr' ? 'bg-blue4' : ''}} flex items-center p-2 text-white  text-white rounded-lg dark:text-white  hover:bg-blue4 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-6 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" width="179.53818mm" height="179.53818mm" viewBox="0 0 179.53818 179.53818" version="1.1" id="svg1" inkscape:export-filename="curr.svg" inkscape:export-xdpi="79.62088" inkscape:export-ydpi="79.62088" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg">
                            <defs id="defs1" />
                            <g inkscape:label="Layer 1" inkscape:groupmode="layer" id="layer1" transform="translate(-15.755283,-77.661276)">
                                <rect style="fill:#ffffff;fill-opacity:1;fill-rule:evenodd;stroke-width:0.15923;stroke-linecap:round" id="rect1-8" width="121.78162" height="125.76481" x="15.755283" y="77.66127" ry="16.047787" />
                                <rect style="fill:#ffffff;fill-opacity:1;fill-rule:evenodd;stroke-width:0.15923;stroke-linecap:round" id="rect1-8-8" width="121.78162" height="125.76481" x="73.511841" y="131.43463" ry="16.047787" inkscape:transform-center-x="56.561599" inkscape:transform-center-y="-68.909554" />
                                <text xml:space="preserve" style="font-weight:bold;font-size:67.9802px;font-family:Octarine;-inkscape-font-specification:'Octarine, Bold';fill:#2468d2;fill-opacity:1;fill-rule:evenodd;stroke-width:0.470121;stroke-linecap:round" x="25.558954" y="182.51872" id="text2" transform="scale(0.97174614,1.0290753)">
                                    <tspan sodipodi:role="line" id="tspan2" style="fill:#2468d2;fill-opacity:1;stroke-width:0.470121" x="25.558954" y="182.51872">Curr</tspan>
                                </text>
                                <rect style="fill:#ffffff;fill-opacity:1;fill-rule:evenodd;stroke-width:0.0569156;stroke-linecap:round" id="rect1-8-8-2" width="49.685493" height="39.384407" x="109.55991" y="111.74243" ry="5.0255122" inkscape:transform-center-x="23.07648" inkscape:transform-center-y="-21.579661" />
                            </g>
                        </svg>

                        <span class="flex-1 ms-3 whitespace-nowrap">Curriculum</span>
                        <!-- <span class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">Pro</span> -->
                    </a>
                </li>
                            
                <li>
                    <a href="{{ route('admin.course') }}" class="{{request()->route()->getName() == 'admin.course' ? 'bg-blue4' : ''}} flex items-center p-2 text-white rounded-lg dark:text-white  hover:bg-blue4 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-6 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" width="179.53818mm" height="179.53818mm" viewBox="0 0 179.53818 179.53818" version="1.1" id="svg1" sodipodi:docname="program.svg" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg">
                            <sodipodi:namedview id="namedview1" pagecolor="#505050" bordercolor="#eeeeee" borderopacity="1" inkscape:showpageshadow="0" inkscape:pageopacity="0" inkscape:pagecheckerboard="0" inkscape:deskcolor="#505050" inkscape:document-units="mm" />
                            <defs id="defs1" />
                            <g id="layer1" transform="translate(-15.755283,-77.661276)">
                                <rect style="fill:#ffffff;fill-opacity:1;fill-rule:evenodd;stroke-width:0.231;stroke-linecap:round" id="rect1" width="179.53818" height="179.53816" x="15.755282" y="77.66127" ry="22.909351" />
                                <text xml:space="preserve" style="font-weight:bold;font-size:141.022px;font-family:Octarine;-inkscape-font-specification:'Octarine, Bold';fill:#2468d2;fill-opacity:1;fill-rule:evenodd;stroke-width:0.975245;stroke-linecap:round" x="44.760868" y="222.98555" id="text2" transform="scale(1.0315405,0.96942389)">
                                    <tspan id="tspan2" style="fill:#2468d2;fill-opacity:1;stroke-width:0.975245" x="44.760868" y="222.98555">C</tspan>
                                </text>
                            </g>
                        </svg>

                        <span class="flex-1 ms-3 whitespace-nowrap">Courses</span>
                        <!-- <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">3</span> -->
                    </a>
                </li>

                <ul class="pt-4 mt-4 space-y-2 font- border-t border-white dark:border-gray-700"></ul>
              
                <li>
                    <a href="{{ route('admin.memo') }}" class="{{request()->route()->getName() == 'admin.memo' ? 'bg-blue4' : ''}} flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-blue4 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="#ffffff" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 4C4 2.895 4.895 2 6 2H14L20 8V20C20 21.105 19.105 22 18 22H6C4.895 22 4 21.105 4 20V4Z" stroke="white" stroke-width="2" fill="none"/>
                            <path d="M14 2V8H20" stroke="white" stroke-width="2" fill="none"/>
                        </svg>
                        <span class="ms-3">Memo</span>
                    </a>
                </li>
            <!-- <div class="absolute bottom-0 flex w-[225px] px-3 mb-5 justify-between items-center p-2 text-white rounded-lg dark:text-white bg-blue4 dark:hover:bg-gray-700 group">
                <div class="w-8 h-8 bg-yellow border rounded-full text-white text-sm flex justify-center items-center">
                    {{ Str::upper(substr(Auth::user()->firstname, 0, 1)) . Str::upper(substr(Auth::user()->lastname, 0, 1)) }}
                </div>
                <div class="ml-2">
                    <div class="font-semibold text-sm">
                        {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}

                    </div>
                    <div class="opacity-50 text-xs">
                        {{ Auth::user()->email }}

                    </div>
                </div>
                <div class="ml-auto">
                    <button type="button" data-collapse-toggle="dropdown-profile">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="6" r="2" transform="rotate(90 12 6)" fill="#ffffff" />
                            <circle cx="12" cy="12" r="2" transform="rotate(90 12 12)" fill="#ffffff" />
                            <path d="M12 20C10.8954 20 10 19.1046 10 18C10 16.8954 10.8954 16 12 16C13.1046 16 14 16.8954 14 18C14 19.1046 13.1046 20 12 20Z" fill="#ffffff" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="absolute z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-profile">
                <div class="px-4 py-3" role="none">
                    <p class="text-sm text-gray-900 dark:text-white font-semibold" role="none">
                        Profile
                    </p>
                </div>
                <ul class="py-1" role="none">
                    <li>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                            Sign Out
                        </a>
                    </li>
            </div> -->
            <div class="right-2 bottom-[60px] absolute hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-profile">
                <div class="px-4 py-2" role="none">
                    <a class="text-sm text-gray-900 dark:text-white hover:text-yellow" href="{{ route('profile.edit') }}">My Profile</a>
                </div>
                <ul class="py-1" role="none">
                    <li>
                        <a class="block px-4 py-1 text-sm text-gray-700 hover:text-yellow dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="">
                        Sign out
                    </a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>

    <div class="p-4 sm:ml-64">
        @yield('content')
    </div>

</body>

</html>