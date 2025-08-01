@extends('layouts.blSidebar')
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

        body {
            background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain;
        } 
        body{
            background-color: #eaeaea;
        }
    </style>
</head>

<body class="">
    @if($missingSignature)
        <div class="absolute z-50 top-10 left-1/2 transform -translate-x-1/2 w-[500px] p-4 rounded-lg shadow-lg border border-[#facc15] bg-[#fefce8] text-[#16a34a] flex justify-between items-center">
            <div class="text-sm font-semibold">
                <strong>Missing Signature:</strong> You haven't uploaded your signature yet.
            </div>
            <a href="{{ route('profile.edit') }}" 
            class="ml-4 bg-[#facc15] hover:bg-[#eab308] text-white font-semibold py-1 px-4 rounded-lg transition-all">
                Go to Profile
            </a>
        </div>
    @endif
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
            </div>
        </div>
<div class="mt-[100px] pb-12 m-auto p-8 bg-slate-100  shadow-lg  rounded-lg w-full">
        <!-- Syllabus here -->
        <div class="">
            <div class="mt-2 text-blue text-2xl font-semibold">
                Syllabi
            </div>
                <div class="flex gap-6 py-4"> <!-- FLEX CONTAINER -->
                    <!-- Create Syllabus button (left) -->
                    <a href="{{ route('bayanihanleader.createSyllabus') }}"
                        class="whitespace-nowrap w-50 rounded mr-1.5 hover:scale-105 w-max transition ease-in-out p-2 text-black font-semibold flex items-center gap-2 max-w-full"
                        style="background: #d7ecf9;"
                        onmouseover="this.style.background='#c3dff3';"
                        onmouseout="this.style.background='#d7ecf9';">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 8v8M8 12h8" stroke="black" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="10" stroke="black" stroke-width="1.5"/>
                        </svg>
                        Create Syllabus
                    </a>

                    <!-- Create Template button (right) -->
                    <a href="{{ route('bayanihanleader.createTemplate') }}"
                        class="whitespace-nowrap w-50 rounded mr-1.5 hover:scale-105 w-max transition ease-in-out p-2 text-black font-semibold flex items-center gap-2 max-w-full"
                        style="background: #d7ecf9;"
                        onmouseover="this.style.background='#c3dff3';"
                        onmouseout="this.style.background='#d7ecf9';">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 8v8M8 12h8" stroke="black" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="10" stroke="black" stroke-width="1.5"/>
                        </svg>
                        Select Template
                    </a>
                </div>

            <livewire:b-l-syllabus-table />

        </div>
    </div>
</body>

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
</html>
@endsection