<!-- @-extends('layouts.deanNav') -->
@extends('layouts.deanSidebar')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <div class="min-h-screen -mt-[10px] flex items-center justify-center">
        <div class="max-w-md bg-slate-100 bg-gradient-to-r from-[#FFF] to-[#dbeafe] w-[500px] p-6 rounded-lg shadow-lg">

            <img class="edit_user_img text-center mt-4 mb-6 w-[300px] m-auto mb-2" src="/assets/Create Department.png" alt="SyllabEase Logo">
            <form action="{{ route('dean.storeDepartment') }}" method="POST">
                @csrf

                <input type="hidden" id="college_id" name="college_id" value="{{ $college->college_id }}">

                <div class="mb-3">
                    <label for="department_code">Department Code</label>
                    <input name="department_code" id="department_code" class="px-1 py-[6px] w-[380px] border rounded border-gray" required></input>
                </div>

                <div class="mb-3">
                    <label for="department_name">Department Name</label>
                    <input name="department_name" id="department_name" class="px-1 py-[6px] w-[380px] border rounded border-gray" required></input>
                </div>

                <div class="mb-3">
                    <label for="program_code">Program Code</label>
                    <input name="program_code" id="program_code" class="px-1 py-[6px] w-[380px] border rounded border-gray" required></input>
                </div>

                <div class="mb-3">
                    <label for="program_name">Program Name</label>
                    <input name="program_name" id="program_name" class="px-1 py-[6px] w-[380px] border rounded border-gray" required></input>
                </div>

                <div class="mb-3">
                    <label for="department_status">Status</label>
                    <select name="department_status" id="department_status" class="px-1 py-[6px] w-[380px] border rounded border-gray" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                    </select>           
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary font-semibold px-6 py-2 rounded-lg m-2 text-white mt-8 mb-4 bg-blue">Create Department</button>
                </div>

            </form>
        </div>
    </div>
</body>
</html>
    
@endsection