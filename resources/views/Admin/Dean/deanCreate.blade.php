<!-- @-extends('layouts.adminNav') -->
@extends('layouts.adminSidebar')

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
        body {
            background-image: url("{{ asset('assets/wave1.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            min-width: 100vh;
            background-size: contain;
        }
        </style>
</head>

<body>
    <div class="p-4 mt-14 flex items-center justify-center">
        <div class="max-w-md bg-gradient-to-r from-[#FFF] to-[#dbeafe] w-[500px] p-6 rounded-lg shadow-lg">
            <img class="edit_user_img text-center mt-4 w-[230px] m-auto mb-2" src="/assets/Assign Dean.png" alt="SyllabEase Logo">
            <form action="{{ route('admin.storeDean') }}" method="POST">
                @csrf

                <div class="grid gap-6 mb-2 md:grid-cols-2">
                    <div class="m-2">
                        <div>
                            <label class="" for="user_id">Dean </label>
                        </div>
                        <select name="user_id" id="user_id" class="select2 px-1 py-[6px] w-[215px] border rounded border-gray" required>
                            @foreach ($users as $user)
                            <option class="" value="{{ $user->id }}">{{ $user->lastname }}, {{ $user->firstname }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="m-2 ml-12">
                        <div>
                            <label for="college_id">College </label>
                        </div>
                        <select name="college_id" id="college_id" class="select2 px-1 py-[6px] w-[130px] border rounded border-gray" required>
                            @foreach ($colleges as $college)
                            <option value="{{ $college->college_id }}">{{ $college->college_code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="m-2 ">
                        <div>
                            <label for="start_validity">Start of Validity </label>
                        </div>
                        <input type="date" name="start_validity" id="start_validity" class="form-control px-1 py-[6px] w-[170px] border rounded border-gray" required></input>
                    </div>
                    <div class="m-2 ">
                        <div>
                            <label for="end_validity">End of Validity </label>
                        </div>
                        <input type="date" name="end_validity" id="end_validity" class="form-control px-1 py-[6px] w-[170px] border rounded border-gray" ></input>
                        @error('end_validity')
                        <span class="" role="alert">
                            <strong class="">{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary font-semibold text-white px-6 py-2 rounded-lg m-2 mt-8 mb-4 bg-blue">Assign Dean</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
@endsection