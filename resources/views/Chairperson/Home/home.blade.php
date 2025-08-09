@extends('layouts.chairSidebar')

@section('content')
@include('layouts.modal')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <title>SyllabEase</title>
    @vite(['resources/css/app.css','resources/js/app.js'])

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
            background-color: #EEEEEE;
        }
    </style>
    <script>
        //JS for Searchable Select
        $(document).ready(function() {
            $('.select2').select2(); // Initialize Select2 
        });
    </script>
</head>

<body>
    @if($missingSignature)
        <div id="alert-box" class="absolute z-50 top-10 left-1/2 transform -translate-x-1/2 w-[700px] p-4 rounded-lg shadow-lg border border-red bg-white text-gray-800">
            <!-- Close button (top-right) -->
            <button onclick="document.getElementById('alert-box').style.display='none'" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 8.586l4.95-4.95a1 1 0 111.414 1.414L11.414 10l4.95 4.95a1 1 0 11-1.414 1.414L10 11.414l-4.95 4.95a1 1 0 11-1.414-1.414L8.586 10l-4.95-4.95A1 1 0 115.05 3.636L10 8.586z" clip-rule="evenodd" />
                </svg>
            </button>

            <!-- Alert content -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pr-6">
                <div class="text-sm font-semibold">
                    <strong class="text-red">Missing Signature:</strong> You haven't uploaded your signature yet.
                </div>
                <a href="{{ route('profile.edit') }}" 
                class="ml-4 w-[150px] bg-[#ff8192] hover:bg-[#eb93a8] text-black font-semibold py-1 px-4 rounded-lg transition-all flex items-center justify-center gap-2">
                    <!-- User icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 11c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4
                        v1h16v-1c0-2.66-5.33-4-8-4z" />
                    </svg>
                    Go to Profile
                </a>
            </div>
        </div>
    @endif
    <div class="p-4 pb-10 shadow bg-white border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="" id="whole">
            <!-- Syllabus here -->
            <div class="">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="font-bold text-4xl text-[#201B50]">Bayanihan Teams</h1>
                    <form action="{{ route('chairperson.createBTeam') }}" method="GET">
                        @csrf
                        <button type="submit"
                            class="whitespace-nowrap rounded-xl hover:scale-105 transition ease-in-out px-6 py-2 text-black font-semibold flex items-center gap-2"
                            style="background: #d7ecf9;"
                            onmouseover="this.style.background='#c3dff3';"
                            onmouseout="this.style.background='#d7ecf9';">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 8v8M8 12h8" stroke="black" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="12" cy="12" r="10" stroke="black" stroke-width="1.5"/>
                            </svg>
                            Create Bayanihan Team
                        </button>
                    </form>
                </div>
                <div>
                    <livewire:chair-b-teams />
                </div>
            </div>
        </div>
    </div>

</body>

</html>
@endsection