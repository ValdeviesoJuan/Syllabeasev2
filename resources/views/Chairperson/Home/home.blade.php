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
            /* background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain; */
            background-color: #EEEEEE;
        }

        /* body {
            background-color: #e8e9e9;
        } */

        /* table, */
        /* tbody {
            border: 1px solid;
            border-collapse: collapse;
            padding: 4px;
            border-color: black;
        } */

        /* th {
            background-color: #2468d2;
            color: white;
        } */
    </style>
    <script>
        //JS for Searchable Select
        $(document).ready(function() {
            $('.select2').select2(); // Initialize Select2 
        });
    </script>
</head>

<body>
    <div class="p-4 pb-10 shadow bg-white border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="" id="whole">
            <!-- Syllabus here -->
            <div class="">
                <h1 class="font-bold text-4xl text-[#201B50] mb-8">Bayanihan Teams</h1>

                <div class="mb- ml- mt-2 pt-2 w-max hover:scale-105 transition ease-in-out bg-blue5 mb-2 py-2 text-white rounded-lg hover:bg-blue">
                    <form action="{{ route('chairperson.createBTeam') }}" method="GET">
                        @csrf
                        <button type="submit" class="flex  px-5   text-ml">
                            <svg class="" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            <div class="px-2">
                                Create Bayanihan Team
                            </div>

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