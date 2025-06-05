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
        <div class="max-w-md bg-gradient-to-r from-[#FFF] to-[#dbeafe] w-[500px] p-6 rounded-lg shadow-lg">

            <img class="edit_user_img text-center mt-4 w-[300px] m-auto mb-6" src="/assets/Create New Curriculum.png" alt="SyllabEase Logo">
            <form class="text-center" action="{{ route('admin.storeCurr') }}" method="POST">
                @csrf
                <div class="m-4">
                    <div>
                        <label class="mr-[64%]" for="department_id">Department</label>
                    </div>
                    <div class="text-left ml-[6.5%]">
                        <select name="department_id" id="department_id" class="select2 js-example-basic-multiple js-states form-control px-1 py-[6px] w-[320px] border rounded border-gray" required>
                            @foreach ($departments as $department)
                            <option class="" value="{{ $department->department_id }}">{{ $department->department_code}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="m-4">
                    <div>
                        <label class="mr-[54%]" for="curr_code">Curriculum Code</label>
                    </div>
                    <input type="text" name="curr_code" id="curr_code" class="px-1 py-[6px] w-[320px] border rounded h-[35px] border-[#a3a3a3]" required></input>
                </div>

                <div class="m-4">
                    <div>
                        <label class="mr-[68%]" for="effectivity">Effectivity</label>
                    </div>
                    <input type="text" name="effectivity" id="effectivity" class="px-1 py-[6px] w-[320px] border rounded h-[35px] border-[#a3a3a3]" required></input>
                </div>
                <div class="text-center">
                    <button type="submit" class="text-white font-semibold px-6 py-2 rounded-lg m-2 mt-4 mb-4 bg-blue">Create Curriculum</button>
                </div>
            </form>
        </div>

    </div>
</body>

</html>

@endsection