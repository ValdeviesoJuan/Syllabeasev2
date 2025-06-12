@extends('layouts.blSidebar')
<!-- @-extends('layouts.blNav') -->

@section('content')



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

        /* body {
            background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain;
        } */
        body{
            background-color: #eaeaea;
        }
    </style>
</head>

<body class="">
    <div class="p-4 pb-4 mt-14">
        <div class="flex w-" id="whole">
            <!-- <div class="fixed inset-0 z-0 bg w-full">
                <svg class="" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev/svgjs" width="1540" height="560" preserveAspectRatio="none" viewBox="0 0 1440 560">
                    <g mask="url(&quot;#SvgjsMask1000&quot;)" fill="none">
                        <path d="M 0,90 C 144,99.2 432,147 720,136 C 1008,125 1296,55.2 1440,35L1440 560L0 560z" fill="rgba(220, 235, 255, 1)"></path>
                        <path d="M 0,259 C 96,280.8 288,371.6 480,368 C 672,364.4 768,256.8 960,241 C 1152,225.2 1344,279.4 1440,289L1440 560L0 560z" fill="rgba(146, 191, 246, 1)"></path>
                        <path d="M 0,433 C 57.6,444.6 172.8,495.6 288,491 C 403.2,486.4 460.8,414.4 576,410 C 691.2,405.6 748.8,463 864,469 C 979.2,475 1036.8,426 1152,440 C 1267.2,454 1382.4,519.2 1440,539L1440 560L0 560z" fill="rgba(70, 143, 234, 1)"></path>
                    </g>
                    <defs>
                        <mask id="SvgjsMask1000">
                            <rect width="1550" height="560" fill="#ffffff"></rect>
                        </mask>
                    </defs>
                </svg>
            </div> -->
            <div class="flex z-10">
                <div id="icon" class="mr-5 flex items-center bg-white h-fit rounded justify-center p-1 shadow-xl hover:scale-110 transition ease-in-out">
                    <div class="m-5 bg-blue2 w-fit h-content rounded-full">
                        <div class="p-4">
                            <svg fill="#2262c6" width="40px" height="40px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">

                                <g id="Memo_Pad" data-name="Memo Pad">
                                    <g>
                                        <path d="M17.44,2.065H6.56a2.507,2.507,0,0,0-2.5,2.5v14.87a2.507,2.507,0,0,0,2.5,2.5H17.44a2.5,2.5,0,0,0,2.5-2.5V4.565A2.5,2.5,0,0,0,17.44,2.065Zm1.5,17.37a1.5,1.5,0,0,1-1.5,1.5H6.56a1.5,1.5,0,0,1-1.5-1.5V6.505H18.94Z" />
                                        <g>
                                            <path d="M7.549,9.506h0a.5.5,0,0,1,0-1h8.909a.5.5,0,0,1,0,1Z" />
                                            <path d="M7.549,12.506h0a.5.5,0,0,1,0-1h6.5a.5.5,0,0,1,0,1Z" />
                                            <path d="M7.566,18.374h0a.5.5,0,1,1,0-1h3.251a.5.5,0,0,1,0,1Z" />
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col mr-6 pt-5">
                        <div class="text-3xl font-semibold text-blue">
                            {{$syllabiCount}}
                        </div>
                        <div class=" ml-0 text-blue3">
                            No of Syllabus
                        </div>
                        <a href="{{ route('bayanihanleader.syllabus') }}">
                            <div class="text-blue justify-end flex mt-2 mb-1">
                                <div class="w-fit bg-blue2 rounded-full p-1">
                                    <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 12H18M18 12L13 7M18 12L13 17" stroke="#2262c6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div id="icon" class="mr-5 flex items-center bg-white h-fit rounded justify-center p-1 shadow-xl hover:scale-110 transition ease-in-out">
                    <div class="m-5 bg-green2 w-fit h-content rounded-full">
                        <div class="p-4">
                            <svg width="40px" height="40px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#31a858" d="M512 64a448 448 0 1 1 0 896 448 448 0 0 1 0-896zm-55.808 536.384-99.52-99.584a38.4 38.4 0 1 0-54.336 54.336l126.72 126.72a38.272 38.272 0 0 0 54.336 0l262.4-262.464a38.4 38.4 0 1 0-54.272-54.336L456.192 600.384z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col mr-6 pt-5">
                        <div class="text-3xl font-semibold text-green">
                            {{$completedCount}}/{{$syllabiCount}}
                        </div>
                        <div class=" ml-0 text-green3">
                            Completed Syllabus
                        </div>
                        <a href="{{ route('bayanihanleader.syllabus') }}">
                            <div class="text-green justify-end flex mt-2 mb-1">
                                <div class="w-fit bg-green2 rounded-full p-1">
                                    <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 12H18M18 12L13 7M18 12L13 17" stroke="#31a858" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div id="icon" class="mr-10 flex items-center bg-white h-fit rounded justify-center p-1 shadow-xl hover:scale-110 transition ease-in-out">
                    <div class="m-5 bg-beige2 w-fit h-content rounded-full">
                        <div class="p-4">
                            <svg fill="#f0a222" width="40px" height="40px" viewBox="0 0 32 32" id="icon" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <style>
                                        .cls-1 {
                                            fill: none;
                                        }
                                    </style>
                                </defs>
                                <circle cx="9" cy="16" r="2" />
                                <circle cx="23" cy="16" r="2" />
                                <circle cx="16" cy="16" r="2" />
                                <path d="M16,30A14,14,0,1,1,30,16,14.0158,14.0158,0,0,1,16,30ZM16,4A12,12,0,1,0,28,16,12.0137,12.0137,0,0,0,16,4Z" transform="translate(0 0)" />
                                <rect id="_Transparent_Rectangle_" data-name="&lt;Transparent Rectangle&gt;" class="cls-1" width="32" height="32" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col mr-6 pt-5">
                        <div class="text-3xl font-semibold text-beige">
                            {{$pendingCount}}
                        </div>
                        <div class=" ml-0 text-beige">
                            Pending Syllabus
                        </div>
                        <a href="{{ route('bayanihanleader.syllabus') }}">
                            <div class="text-green justify-end flex mt-2 mb-1">
                                <div class="w-fit bg-beige2 rounded-full p-1">
                                    <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 12H18M18 12L13 7M18 12L13 17" stroke="#f0a222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- <div id="icon" class="m-5 flex items-center bg-white h-fit rounded justify-center p-1 shadow-2xl hover:scale-110 transition ease-in-out">
                    <div class="m-5 bg-pink w-fit h-content rounded-full">
                        <div class="p-4">
                            <svg fill="#ff5d9b" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 100 100" xml:space="preserve">
                                <g>
                                    <g>
                                        <path d="M57,44h-6h-6c-3.3,0-6,2.7-6,6v9c0,1.1,0.5,2.1,1.2,2.8c0.7,0.7,1.7,1.2,2.8,1.2v9c0,3.3,2.7,6,6,6h2h2
                                        c3.3,0,6-2.7,6-6v-9c1.1,0,2.1-0.4,2.8-1.2c0.7-0.7,1.2-1.7,1.2-2.8v-9C63,46.7,60.3,44,57,44z" />
                                    </g>
                                    <g>
                                        <circle cx="51" cy="33" r="7" />
                                    </g>
                                    <g>
                                        <path d="M36.6,66.7c-0.2-0.2-0.5-0.4-0.7-0.6c-1.9-2-3-4.5-3-7.1v-9c0-3.2,1.3-6.2,3.4-8.3c0.6-0.6,0.1-1.7-0.7-1.7
                                        c-1.7,0-3.6,0-3.6,0h-6c-3.3,0-6,2.7-6,6v9c0,1.1,0.5,2.1,1.2,2.8c0.7,0.7,1.7,1.2,2.8,1.2v9c0,3.3,2.7,6,6,6h2h2
                                        c0.9,0,1.7-0.2,2.4-0.5c0.4-0.2,0.6-0.5,0.6-0.9c0-1.2,0-4,0-5.1C37,67.2,36.9,66.9,36.6,66.7z" />
                                    </g>
                                    <g>
                                        <circle cx="32" cy="29" r="7" />
                                    </g>
                                    <g>
                                        <path d="M76,40h-6c0,0-1.9,0-3.6,0c-0.9,0-1.3,1-0.7,1.7c2.1,2.2,3.4,5.1,3.4,8.3v9c0,2.6-1,5.1-3,7.1
                                        c-0.2,0.2-0.4,0.4-0.7,0.6c-0.2,0.2-0.4,0.5-0.4,0.8c0,1.1,0,3.8,0,5.1c0,0.4,0.2,0.8,0.6,0.9c0.7,0.3,1.5,0.5,2.4,0.5h2h2
                                        c3.3,0,6-2.7,6-6v-9c1.1,0,2.1-0.4,2.8-1.2c0.7-0.7,1.2-1.7,1.2-2.8v-9C82,42.7,79.3,40,76,40z" />
                                    </g>
                                    <g>
                                        <circle cx="70" cy="29" r="7" />
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col mr-6 pt-5">
                        <div class="text-3xl font-semibold text-pink2">
                            N
                        </div>
                        <div class=" ml-0 text-pink2">
                            Bayanihan Teams
                        </div>
                        <div class="text-green justify-end flex mt-2 mb-1">
                            <div class="w-fit bg-pink rounded-full p-1">
                                <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 12H18M18 12L13 7M18 12L13 17" stroke="#ff5d9b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div> -->

            </div>
        </div>

        <!-- Syllabus here -->
        <div class="">
            <div class="mt-2 text-blue text-2xl font-semibold">
                Syllabi
            </div>
            <div class="flex gap-4"> <!-- FLEX CONTAINER -->

    <!-- Create Syllabus button (left) -->
    <div class="mb-5 mt-2 pt-2 w-[200px] hover:scale-105 transition ease-in-out bg-blue py-2 text-white rounded hover:bg-blue">
        <form action="{{ route('bayanihanleader.createSyllabus') }}" method="GET">
            @csrf
            <button type="submit" class="flex m-auto text-ml">
                <svg class="" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path>
                    <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path>
                </svg>
                <div class="px-2">
                    <div class="flex m-auto">
                        Create Syllabus
                    </div>
                </div>
            </button>
        </form>
    </div>

    <!-- Create Template button (right) -->
    <div class="mb-5 mt-2 pt-2 w-[200px] hover:scale-105 transition ease-in-out bg-blue py-2 text-white rounded hover:bg-blue">
        <form action="{{ route('bayanihanleader.createTemplate') }}" method="GET">
            @csrf
            <button type="submit" class="flex m-auto text-ml">
                <svg class="" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path>
                    <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path>
                </svg>
                <div class="px-2">
                    <div class="flex m-auto">
                        Select Template
                    </div>
                </div>
            </button>
        </form>
    </div>

</div>

                

            <livewire:b-l-syllabus-table />

            <!-- Syllabus Cards                                
            <div class="m-8 mb-10">
                <div class="grid grid-cols-5 gap-5 mt-2">
                    @forelse ($syllabus as $key => $syll)
                    <div class="border border-gray3 sshadow-xl w-58 h-72 h-auto min-h-fit bg-white rounded-xl shadow-xl hover:scale-105 transition ease-in-out">
                        <div class="ml-[155px] flex justify-end">
                            <div class="bg-beige2 text-gray rounded-full w-max px-3 absolute mt-2 mr-2 bg-opacity-75">
                                {{$syll->status}}
                            </div>
                        </div>
                        <div class="w-fit">
                            @php
                            $imageIndex = $key % 10 + 1; // Cycle through images 1-10
                            @endphp
                            <img class="rounded-t-xl h-40" src="/assets/bg/{{ $imageIndex }}.png" alt="{{ $syll->course_title }}">
                        </div>
                        <div class="text-xl font-semibold mx-3 text-neutral-900 mt-1">
                            {{ $syll->course_title }}
                        </div>
                        <div class="text-neutral-900 font-semibold text-lg mx-3 mb-2">
                            {{ $syll->course_code }}
                        </div>
                        <div class="text-neutral-900 font-medium mx-3">
                            {{ $syll->bg_school_year }}
                        </div>
                        <div class="text-neutral-900 font-medium mx-3">
                            {{ $syll->course_semester }}
                        </div>
                        <div class="text-neutral-900 mx-3 text-sm">
                            Due by : {{ $syll-> dl_syll}}
                        </div>
                        <div class="text-neutral-900 mx-3 text-sm" id="remaining-time">
                            Remaining : Calculating...
                        </div>
                        <div class="flex flex-row justify-center">
                        <div class="mr-3 justify-end flex">
                            <form action="{{ route('bayanihanleader.destroySyllabus', $syll->syll_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this syllabus entry?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="shadow-lg rounded-full bg-blue text-white py-1 px-3 my-4">Delete</button>
                            </form>
                        </div>
                        <div class="flex">
                            <form action="{{ route('bayanihanleader.viewSyllabus', $syll->syll_id) }}" method="GET">
                                @csrf
                                <button type="submit" class="shadow-lg rounded-full bg-blue text-white py-1 px-3 my-4">View</button>
                            </form>
                        </div>
                    </div>
                    </div>
                    @empty
                    <p class="ml-2">No Syllabus Found</p>
                    @endforelse
                </div>
            </div> -->
        </div>
    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var syll = <?php echo json_encode($syll ?? null); ?>;
            var dueDate = syll && syll.dl_syll ? new Date(syll.dl_syll) : null;

            if (dueDate) {
                function updateRemainingTime() {
                    var now = new Date();
                    var timeDifference = dueDate - now;
                    var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

                    var remainingTimeElement = document.getElementById('remaining-time');
                    remainingTimeElement.innerText = 'Remaining: ' + days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's';
                }

                updateRemainingTime();
                setInterval(updateRemainingTime, 1000);
            }
        });
    </script>
</body>

</html>
@endsection