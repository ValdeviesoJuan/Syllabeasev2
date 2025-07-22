<!-- @-extends('layouts.adminNav') -->
@extends('layouts.adminSidebar')
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
            <img class="edit_user_img text-center mt-4 w-[190px] m-auto mb-2" src="/assets/Edit Dean.png" alt="SyllabEase Logo">

            <form class="" action="{{ route('admin.updateDean', $dean->ur_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="m-2 mt-4">
                    <div>
                        <label class="mr-[69%]" for="user_id">Dean</label>
                    </div>
                    <select name="user_id" id="user_id" class="select2 px-1 py-[6px] w-[380px] border rounded border-gray" required>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $dean->user_id == $user->id ? 'selected' : '' }}>{{ $user->lastname }}, {{ $user->firstname }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="m-2 mt-4">
                    <div>
                        <label class="mr-[65%]" for="college_id">College</label>
                    </div>
                    <select name="college_id" id="college_id" class="px-1 py-[6px] w-[380px] border rounded border-gray" required>
                        @foreach ($colleges as $college)
                        <option value="{{ $college->college_id }}" {{ $dean->entity_id == $college->college_id ? 'selected' : '' }}>{{ $college->college_code }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="m-2 mt-4">
                    <div>
                        <label class="mr-[51%]" for="start_validity">Start of Validity</label>
                    </div>
                    <input type="date" name="start_validity" id="start_validity" class="px-1 py-[6px] w-[380px] border rounded border-gray" value="{{ $dean->start_validity }}" required></input>
                </div>
                <div class="m-2 mt-4">
                    <div>
                        <label class="mr-[52%]" for="end_validity">End of Validity</label>
                    </div>
                    <input type="date" name="end_validity" id="end_validity" class="px-1 py-[6px] w-[380px] border rounded border-gray" value="{{ $dean->end_validity }}" ></input>
                    @error('end_validity')
                    <span class="" role="alert">
                        <strong class="">{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary font-semibold text-white px-6 py-2 rounded-lg m-2 mt-8 mb-4 bg-blue">Update Dean</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

@endsection