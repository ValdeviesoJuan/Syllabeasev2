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
            background-image: url("{{ asset('assets/Wave1.png') }}");
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
        <div class="max-w-md bg-slate-100 bg-gradient-to-r from-[#FFF] to-[#dbeafe] w-[500px] p-6 rounded-lg shadow-lg">

            <form class="auto text-center" action="{{ route('admin.updateCollege', $college->college_id) }}" method="POST">
                @csrf
                @method('PUT')
                <img class="edit_user_img text-center mt-4 w-[240px] m-auto mb-2" src="/assets/Edit College.png" alt="SyllabEase Logo">
                {{-- <h1 class="text-center p-3 text-2xl font-semibold">Edit College</h1> --}}
                <div class="m-2 mt-4">
                    <div>
                        <label class="mr-[53%]" for="college_code">College Code </label>
                    </div>
                    <input type="text" name="college_code" id="college_code" class="px-1 py-[6px] w-[300px] border rounded border-gray" value="{{ $college->college_code }}">
                </div>

                <div class="m-2 mt-4">
                    <div>
                        <label class="mr-[42%]" for="college_description">College Description </label>
                    </div>
                    <input type="text" name="college_description" id="college_description" class="px-1 py-[6px] w-[300px] border rounded border-gray" value="{{ $college->college_description }}">
                </div>
                <div class="m-2 mt-4">
                    <div>
                        <label class="mr-[67%]" for="college_status">Status </label>
                    </div>
                    <select name="college_status" id="college_status" class="px-1 py-[6px] w-[300px] border rounded border-gray" required>
                        <option value="Active" @if ($college->college_status === 'Active') selected @endif>Active</option>
                        <option value="Inactive" @if ($college->college_status === 'Inactive') selected @endif>Inactive</option>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="text-white px-6 py-2 font-semibold rounded m-2 mt-[40px] mb-4 bg-blue">Update College</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
@endsection