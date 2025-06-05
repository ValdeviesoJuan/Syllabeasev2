<!-- @-extends('layouts.blNav') -->
@extends('layouts.blSidebar')
@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyllabEase</title>
    @vite('resources/css/app.css')

    <style>
        .bg svg {
            transform: scaleY(-1);
            min-width: '1880'
        }

        body {
            background-image: url("{{ asset('assets/wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain;
        }
    </style>
</head>

<body class="">
    <div class="m-auto bg-slate-100 mt-[120px] p-2 shadow-lg bg-gradient-to-r from-[#FFF] to-[#dbeafe] rounded-lg w-11/12">
        {{-- <div class="max-w-md  w-[560px] p-6 px-8 rounded-lg shadow-lg"> --}}
            <img class="edit_user_img text-center mt-12 w-[370px] m-auto mb-12" src="/assets/Create Course Outcome.png" alt="SyllabEase Logo">
                <div class="mb-10 pb-10">
                    <div class="ml-20 items-center">
                        <form action="{{ route('bayanihanleader.storeCo', $syll_id) }}" method="POST">
                            @csrf
                            <div class="">
                                <div id="input-container" class="ml-12">
                                    <input placeholder="CO1" type="text" name="syll_co_code[]" id="syll_co_code" class="text-center w-16  border-2 border-solid border-sePrimary" required> : </input>
                                    <input placeholder="Upon completion of the course, students will be able to confidently troubleshoot technical problems e.g., by diagnosing hardware and software issues and implementing appropriate solutions." type="text" name="syll_co_description[]" id="syll_co_description" class="w-10/12 border-2 border-solid border-seSecondary" required></input>
                                </div>
                                
                                <button type="button" id="add-input" class="p-2 ml-12 text-white inline-block w-[145px] px-4 py-2 rounded m-2 mt-8 mb-4 bg-blue">
                                    <svg class="-mb-2" width="22px" height="22px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="white" stroke-width="2" stroke-linecap="round"></path>
                                        <path d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8" stroke="white" stroke-width="2" stroke-linecap="round"></path>
                                    </svg>
                                    <h1 class="-mt-[22px] ml-2">Add Row</h1>
                                </button>
                                <div class="text-center">
                                    <button type="submit" class="text-white px-5 py-2 rounded m-2 mt-8 mb-4 bg-blue w-48 text-lg">Create</button>
                                </div>
                            </div>
                            <div class="text-center">
                                <a href="{{ route('bayanihanleader.viewSyllabus', $syll_id) }}" class="text-black hover:underline hover:text-blue hover:underline-offset-4 px-5 py-2 rounded m-2 mt-8 mb-4 w-48 text-lg">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
</body>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputContainer = document.getElementById('input-container');
        const addButton = document.getElementById('add-input');

        addButton.addEventListener('click', function () {
            const newRow = document.createElement('div');
            newRow.className = 'input-row my-5';

            const newInput1 = document.createElement('input');
            newInput1.type = 'text';
            newInput1.name = 'syll_co_code[]';
            newInput1.classList.add('w-16', 'border-2', 'border-solid', 'border-sePrimary', 'text-center');
            newInput1.required = true;

            const separator = document.createTextNode(' : ');

            const newInput2 = document.createElement('input');
            newInput2.type = 'text';
            newInput2.name = 'syll_co_description[]';
            newInput2.classList.add('w-5/6', 'border-2', 'border-solid', 'border-seSecondary');
            newInput2.required = true;
            
            inputContainer.appendChild(newRow);
            inputContainer.appendChild(newInput1);
            inputContainer.appendChild(separator);
            inputContainer.appendChild(newInput2);
        });
    });
</script>
</html>
@endsection