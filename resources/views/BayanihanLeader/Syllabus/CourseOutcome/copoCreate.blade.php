@extends('layouts.blNav')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <!-- legend -->
    <div>
        <div class="flex space-x-14 position-absolute top-40 right-40 mt-10">
                <div class=" mx-auto px-6 py-2.5 bg-blue text-white font-medium text-xs leading-tight rounded-md shadow-md  focus:shadow-lg 
            transition duration-150 ease-in-out flex items-center whitespace-nowrap" type="button" aria-expanded="false">
                    <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="1" stroke="#ffffff" stroke-width="2" />
                        <path d="M18.2265 11.3805C18.3552 11.634 18.4195 11.7607 18.4195 12C18.4195 12.2393 18.3552 12.366 18.2265 12.6195C17.6001 13.8533 15.812 16.5 12 16.5C8.18799 16.5 6.39992 13.8533 5.77348 12.6195C5.64481 12.366 5.58048 12.2393 5.58048 12C5.58048 11.7607 5.64481 11.634 5.77348 11.3805C6.39992 10.1467 8.18799 7.5 12 7.5C15.812 7.5 17.6001 10.1467 18.2265 11.3805Z" stroke="#ffffff" stroke-width="2" />
                        <path d="M17 4H17.2C18.9913 4 19.887 4 20.4435 4.5565C21 5.11299 21 6.00866 21 7.8V8M17 20H17.2C18.9913 20 19.887 20 20.4435 19.4435C21 18.887 21 17.9913 21 16.2V16M7 4H6.8C5.00866 4 4.11299 4 3.5565 4.5565C3 5.11299 3 6.00866 3 7.8V8M7 20H6.8C5.00866 20 4.11299 20 3.5565 19.4435C3 18.887 3 17.9913 3 16.2V16" stroke="#ffffff" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    
                    <button id="showPo" class="pl-3 hover:text-white">Program Outcomes</button>
                </div>
        </div>

        <table class="m-10 mx-auto border-2 border-solid text-sm text-center">
            <tr class="border-2 border-solid">
                <th class="border-2 border-solid w-24">
                    Code
                </th>
                <th colspan=2>
                    Description
                </th class="border-2 border-solid">
            </tr>
            <tr class="border-2 border-solid">
                <td class="border-2 border-solid">
                    I
                </td>
                <td class="border-2 border-solid">
                    Introductory Course
                </td>
                <td class="border-2 border-solid">
                    An Introductory course to an outcome
                </td>
            </tr>
            <tr class="border-2 border-solid">
                <td class="border-2 border-solid">
                    E
                </td>
                <td class="border-2 border-solid">
                    Enabling Scourse
                </td>
                <td class="border-2 border-solid">
                    A course that strengtens the outcome
                </td>
            </tr>
            <tr class="border-2 border-solid">
                <td class="border-2 border-solid">
                    D
                </td>
                <td class="border-2 border-solid">
                    Demonstrating Course
                </td>
                <td>
                    A course demonstrating an outcome
                </td>
            </tr>
        </table>
    </div>
    <!-- form div -->
    <div>
    <form action="{{ route('bayanihanleader.storeCoPo', $syll_id) }}" method="POST">
    @csrf
    <table class="m-10 mx-auto border-2 border-solid">
        <tr class="border-2 border-solid">
            <th>
                Course Outcomes (CO)
            </th>
            @foreach($programOutcomes as $po)
                <th class="border-2 border-solid">
                    {{$po->po_id}} ({{$po->po_code}})
                </th>
            @endforeach
        </tr>

        @foreach($courseOutcomes as $co)
            <tr class="border-2 border-solid">
                <td class="text-xs w-64">{{$co->syll_co_code}} : {{$co->syll_co_description}}</td>
                @foreach($programOutcomes as $po)
                    <td class="border-2 border-solid">
                        <input type="hidden" name="syll_co_id[]" value="{{$co->syll_co_id}}" />
                        <input type="hidden" name="syll_po_id[]" value="{{$po->po_id}}" />
                        <input type="text" class="border-0 m-2 text-center w-10 h-full" name="syll_co_po_code[]" />
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>
    <button type="submit" class="text-white bg-blue focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mx-auto">Submit</button>
</form>
    </div>


    <div id="ProgramOutcomes" class="modal" hidden>
        <div class="w-1/2 absolute top-24 left-1/4 max-h-96 rounded-md shadow-2xl rounded-b-lg">
            <div class="flex bg-blue text-white px-5 pt-2 h-10 rounded-t-md">
                <p class="mr-12">Program Outcomes</p>
                <div class="cursor-pointer float-right">
                    <svg class="close ml-96" id="closebtn" fill="#ffffff" height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                        <g>
                            <g>
                                <path d="M256,0C114.84,0,0,114.842,0,256s114.84,256,256,256s256-114.842,256-256S397.16,0,256,0z M256,462.452
			c-113.837,0-206.452-92.614-206.452-206.452S142.163,49.548,256,49.548S462.452,142.163,462.452,256S369.837,462.452,256,462.452z
			" />
                            </g>
                        </g>
                        <g>
                            <g>
                                <polygon points="355.269,191.767 320.233,156.731 256,220.964 191.767,156.731 156.731,191.767 220.964,256 156.731,320.233 
			191.767,355.269 256,291.036 320.233,355.269 355.269,320.233 291.036,256 		" />
                            </g>
                        </g>
                    </svg>
                </div>
            </div>

            <div class="bg-white text-black p-5 overflow-y-auto max-h-96 shadow-2xl rounded-b-lg">
                @foreach($programOutcomes as $po)
                <p class="pb-4">{{$po->po_letter}} : {{$po->po_description}}</p>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        var openFormBtn = document.getElementById("showPo");
        openFormBtn.addEventListener("click", function() {
            document.getElementById("ProgramOutcomes").style.display = "block";
        });


        var closeFormBtn = document.getElementById("closebtn");
        closeFormBtn.addEventListener("click", function() {
            document.getElementById("ProgramOutcomes").style.display = "none";
        });
    </script>

</body>

</html>
@endsection