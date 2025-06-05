@extends('layouts.chairSidebar')

@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syllabease</title>
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
    <div class="mt-14 p-4 pb-10 m-auto mt-10 w-11/12 bg-gradient-to-r from-[#FFF] to-[#dbeafe] shadow-lg rounded-lg">
       <div> 
            <img class="edit_user_img text-center p-6 mt-4 w-[400px] m-auto mb-6" src="/assets/Edit Program Outcomes.png" alt="SyllabEase Logo">
                <div class="mb-10 pb-10">
                    <div class="ml-20 items-center">
                        <form action="{{ route('chairperson.updatePo', $department_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="">
                                <div id="input-container" class="">
                                @foreach ($programOutcomes as $po)
                                    <input placeholder="a." type="text" name="po_letter[]" id="po_letter" class="text-center w-9 border-2 border-solid border-sePrimary" value="{{ $po->po_letter }}" required> : </input>
                                    <input placeholder="e.g Apply knowledge of computing, science and mathematics in solving computing..." type="text" name="po_description[]" id="po_description" class="w-5/6 border-2 border-solid border-seSecondary mb-5" value="{{ $po->po_description }}" required></input>
                                    <br>
                                @endforeach
                                </div>
                                
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary text-white font-semibold px-6 py-2 rounded-lg m-2 mt-30 mb-4 bg-blue">Update Program Outcomes</button>
                                </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
</body>

</html>
@endsection