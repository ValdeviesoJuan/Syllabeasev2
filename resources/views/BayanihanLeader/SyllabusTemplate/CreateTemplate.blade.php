@extends('layouts.blNav')

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
       <div class="p-6 bg-blue-100 min-h-screen">
        <h1 class="text-2xl font-bold text-center flex-1 -ml-8 pt-[1px]">Select Template</h1>
    <div class="flex justify-end mb-6 px-4">
    <form action="{{ route('syllabus.template') }}" method="GET">
            @csrf    
    <button class="bg-yellow hover:scale-105 transition ease-in-out text-white px-4 py-2 rounded-lg shadow">
        + Create Syllabus Template
    </button>
    </div>

    
   <!-- Single Static Template Card -->
    <div class="bg-white rounded-lg shadow-md p-4 relative max-w-xl mx-auto">
        <!-- Top Bar: Radio Button Left, Actions Right -->
        <div class="flex justify-between items-center mb-2">
                    <!-- Radio Button -->
                    <label class="inline-flex items-center space-x-2">
                        <input type="radio" name="template" value="template1" class="form-radio text-green">
                        <span class="text-gray-700 text-sm"></span>
                    </label>

                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                            <!-- Delete Button -->
                            <button class="text-red-600 hover:text-red-800 bg-white bg-opacity-80 rounded px-2" title="Delete">
                                <img src="{{ asset('assets/delete.svg') }}" alt="Delete" class="w-5 h-5">
                            </button>

                            <!-- View Button -->
                            <button class="text-yellow-500 hover:text-yellow-700 bg-white bg-opacity-80 rounded px-2" title="View">
                                <img src="{{ asset('assets/view.svg') }}" alt="View" class="w-5 h-5">
                            </button>

                            <!-- Edit Button -->
                            <button class="text-blue-500 hover:text-blue-700 bg-white bg-opacity-80 rounded px-2" title="Edit">
                                <img src="{{ asset('assets/edit.svg') }}" alt="Edit" class="w-5 h-5">
                            </button>
                    </div>
                </div>

                <!-- Image Preview -->
                <div class="relative">
                    <img src="{{ asset('assets/tempstatic.png') }}" alt="Template Preview" class="w-full object-cover rounded">
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