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
            background-image: url("{{ asset('assets/Wave.png') }}");
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
                <img class="edit_user_img text-center mt-12 w-[320px] m-auto mb-12" src="/assets/Edit Course Outcome.png" alt="SyllabEase Logo">
                <div class="pb-10">
                    <div class="ml-20 items-center">
                        <form class="" action="{{ route('bayanihanleader.updateCo', $syll_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="">
                                <div id="input-container" class="">
                                @foreach ($courseOutcomes as $co)
                                    <input placeholder="CO1" type="text" name="syll_co_code[]" class="text-center w-16 border-2 border-solid border-sePrimary" value="{{$co->syll_co_code}}" required> : </input>
                                    <input placeholder="Upon completion of the course, students will be able to confidently troubleshoot technical problems e.g., by diagnosing hardware and software issues and implementing appropriate solutions." type="text" name="syll_co_description[]" class="w-5/6 px-2 border-2 border-solid border-seSecondary mb-5" value="{{$co->syll_co_description}}" required></input>
                                    <!-- <button type="button" class="btn btn-danger" onclick="confirmDelete({{$co->syll_co_id}}, {{$syll_id}})">Delete</button> -->
                                    <br>
                                    @endforeach
                                </div>
                                
                                <div class="text-center">
                                    <button type="submit" class="text-white px-5 py-2 rounded m-2 mt-8 mb-4 bg-blue w-48 text-lg">Update</button>
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


    <!-- <script>
        function confirmDelete(coId, syllId) {
            if (confirm("Are you sure you want to delete this course outcome?")) {
                var form = document.createElement("form");
                form.action = "{{ route('bayanihanleader.destroyCo', ['co_id' => ':coId', 'syll_id' => ':syllId']) }}".replace(':coId', coId).replace(':syllId', syllId);
                form.method = "POST";
                form.style.display = "none";
                form.innerHTML = `@csrf @method('DELETE')`;

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputContainer = document.getElementById('input-container');
            const addButton = document.getElementById('add-input');

            addButton.addEventListener('click', function() {
                const newRow = document.createElement('div');
                newRow.className = 'input-row my-5';

                const newInput1 = document.createElement('input');
                newInput1.type = 'text';
                newInput1.name = 'syll_co_code[]';
                newInput1.classList.add('w-9', 'border-2', 'border-solid', 'border-sePrimary', 'text-center');
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
    </script> -->

</html>
@endsection