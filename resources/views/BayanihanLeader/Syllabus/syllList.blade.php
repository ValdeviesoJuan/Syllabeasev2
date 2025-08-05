@extends('layouts.blSidebar')
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
        <style>
            body {
                background-color: #EEEEEE;
            }
        </style>
    </head>

<body>
    <div class="m-auto p-8 bg-white mt-[5%] shadow-lg rounded-lg  w-full">
        <span class="flex flex-block justify-between items-center">
            <h1 class="font-bold text-4xl text-[#201B50] mb-8">List of Syllabus</h1>
            <div class="">
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
            </div>
        </span>
        <livewire:b-l-syllabus-table />
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
                    remainingTimeElement.innerText = 'Remaining: ' + days + 'd ' + hours + 'h ' + minutes + 'm ' +
                        seconds + 's';
                }

                updateRemainingTime();
                setInterval(updateRemainingTime, 1000);
            }
        });
    </script>
</body>

</html>
@endsection