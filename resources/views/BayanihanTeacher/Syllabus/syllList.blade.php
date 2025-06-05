<!-- @-extends('layouts.btNav') -->
@extends('layouts.btSidebar')

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
    </style>
</head>

<body>
    <div class="mt-[7%]">
        <div class="mt-[100px] pb-12 m-auto p-8 bg-slate-100 mt-[30px] p-2 shadow-lg bg-gradient-to-r from-[#FFF] to-[#dbeafe] rounded-lg w-11/12">
            <div class="font-bold text-4xl text-[#201B50] mb-8">
                List of Syllabi
            </div>
            <livewire:b-t-syllabus-table />
            <!-- Syllabus Cards                                 -->
            <!-- <div class="ml-10 mr-5">
                <div class="grid grid-cols-4 gap-4 mt-2">
                    @forelse ($syllabus as $key => $syll)
                    <div class="w-60 h-72 h-auto min-h-fit bg- rounded-xl shadow-lg hover:scale-105 transition ease-in-out">
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
                        <div class="text-xl font-semibold mx-3 text-neutral-900 my-1">
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
                        <div class="text-neutral-900 mx-3 text-sm" id="remaining-time">
                            Remaining : Calculating...
                        </div>
                        <div class="mr-3 justify-end flex ">
                            <form action="{{ route('bayanihanteacher.commentSyllabus', $syll->syll_id) }}" method="GET">
                                @csrf
                                <button type="submit" class="shadow-lg rounded-full bg-blue text-white py-1 px-3 my-4">View</button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <p>No Syllabus Found</p>
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