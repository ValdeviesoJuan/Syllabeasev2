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