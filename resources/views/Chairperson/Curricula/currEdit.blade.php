@extends('layouts.chairSidebar')
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
    <div class="min-h-screen -mt-[120px] flex items-center justify-center">
        <div class="max-w-md bg-gradient-to-r from-[#FFF] to-[#dbeafe] w-[500px] p-6 rounded-lg shadow-lg">
            <img class="edit_user_img text-center mt-4 w-[240px] m-auto mb-6" src="/assets/Edit Curriculum.png" alt="SyllabEase Logo">
            <form action="{{ route('chairperson.updateCurr', $curriculum->curr_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="text-center">
                    <div class="m-2 mb-6">
                        <div>
                            <label class="mr-[66%]" for="department_id">Department</label>
                        </div>

                            <select name="department_id" id="department_id" class="form-control px-1 py-[6px] w-[340px] border rounded border-gray" required disabled>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->department_id }}" {{ $curriculum->department_id == $department->department_id ? 'selected' : '' }}>
                                        {{ $department->department_code }}
                                    </option>
                                @endforeach
                            </select>

                    </div>
                    
                    <div class="m-2 mb-6">
                        <div>
                            <label class="mr-[57%]" for="curr_code">Curriculum Code</label>
                        </div>
                        <input type="text" name="curr_code" id="curr_code" class="form-control px-1 py-[6px] w-[340px] border rounded border-gray" required value="{{ $curriculum->curr_code }}">
                    </div>

                    <div class="m-2 mb-6">
                        <div>
                            <label class="mr-[70%]" for="effectivity">Effectivity</label>
                        </div>
                        <input type="text" name="effectivity" id="effectivity" class="form-control px-1 py-[6px] w-[340px] border rounded border-gray" required value="{{ $curriculum->effectivity }}">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="text-white font-semibold px-6 py-2 rounded-lg m-2 mt-4 mb-4 bg-blue">Update Curriculum</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

@endsection