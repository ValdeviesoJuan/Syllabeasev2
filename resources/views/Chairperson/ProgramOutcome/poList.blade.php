@extends('layouts.chairSidebar')

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
        body {
            background-image: url("{{ asset('assets/Wave1.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            min-width: 100vh;
            background-size: contain;
        }
    </style>
</head>

<body class="">
    <div class="p-4 pb-10 shadow bg-white border-dashed rounded-lg dark:border-gray-700 mt-14 opacity-80">
        <div>
            <h1 class="font-semibold text-xl flex justify-center pt-5">Program Outcomes</h1>
            <div>
                <p class="ml-5 tracking-wide text-lg">
                    <br>Upon completion of the <span class="font-bold">{{ $department_name }}</span> program, graduates are able to:
                </p>
                <div class="mb-10 pb-10">
                    @foreach ($programOutcomes as $programOutcome)
                    <div class="ml-20 flex items-center tracking-wide leading-relaxed">
                        <p>{{ $programOutcome->po_letter }} : {{ $programOutcome->po_description }}</p>
                        <form action="{{ route('chairperson.destroyPo', $programOutcome->po_id) }}" method="Post">
                            @csrf
                            @method('DELETE')
                            <div class="w-10 color-sePrimary deleteButtonContainer">
                                <button class="w-6 inline-flex items-center ml-2 deleteButton" style="display: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 30 30">
                                        <path d="M 14.984375 2.4863281 A 1.0001 1.0001 0 0 0 14 3.5 L 14 4 L 8.5 4 A 1.0001 1.0001 0 0 0 7.4863281 5 L 6 5 A 1.0001 1.0001 0 1 0 6 7 L 24 7 A 1.0001 1.0001 0 1 0 24 5 L 22.513672 5 A 1.0001 1.0001 0 0 0 21.5 4 L 16 4 L 16 3.5 A 1.0001 1.0001 0 0 0 14.984375 2.4863281 z M 6 9 L 7.7929688 24.234375 C 7.9109687 25.241375 8.7633438 26 9.7773438 26 L 20.222656 26 C 21.236656 26 22.088031 25.241375 22.207031 24.234375 L 24 9 L 6 9 z"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- <div class="bg-blue px-2 py-1 text-white w-min flex-row rounded-lg">
                <div class="">
                    <a class="" href="{{ route('chairperson.createPo') }}">
                        <div class="">
                            <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                        </div>
                        <div class="">
                            Add
                        </div>
                    </a>
                </div>
            </div> -->

        <!-- <a href="{{ route('chairperson.editPo', $department_id) }}">Edit </a> -->

    </div>
    <div>
        <div class="ml-10 mt-2 pt-2 w-max hover:scale-105 transition ease-in-out bg-blue py-2 text-white rounded-lg hover:bg-blue">
            <form action="{{ route('chairperson.createPo') }}" method="GET">
                @csrf
                <button type="submit" class="flex  px-5   text-ml">
                    <svg class="" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    <div class="px-2">
                        Add Program Outcome
                    </div>

                </button>
            </form>
        </div>
        <div class="ml-10 mt-2 pt-2 w-max hover:scale-105 transition ease-in-out bg-blue py-2 text-white rounded-lg hover:bg-blue">
            <form action="{{ route('chairperson.editPo', $department_id) }}" method="GET">
                @csrf
                <button type="submit" class="flex  px-5   text-ml">
                    <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="px-2">
                        Edit Program Outcome
                    </div>

                </button>
            </form>
        </div>

        <div class="flex ml-10 mt-2 pt-2 w-max hover:scale-105 transition ease-in-out bg-blue py-2 text-white rounded-lg hover:bg-blue">
            <div class="pl-2">
                <input class="rounded-full" type="checkbox" id="enableDeleteButton">
            </div>
            <div class="px-2">
                Show Delete Button
            </div>

        </div>


    </div>
    <script>
        document.getElementById('enableDeleteButton').addEventListener('change', function() {
            var deleteButtonContainers = document.getElementsByClassName('deleteButtonContainer');
            var deleteButtons = document.getElementsByClassName('deleteButton');

            for (var i = 0; i < deleteButtons.length; i++) {
                if (this.checked) {
                    deleteButtons[i].style.display = 'inline-flex';
                } else {
                    deleteButtons[i].style.display = 'none';
                }
            }
        });
    </script>
</body>

</html>
@endsection