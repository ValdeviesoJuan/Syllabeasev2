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

            <img class="edit_user_img text-center mt-4 mb-6 w-[300px] m-auto mb-2" src="/assets/Create Department.png" alt="SyllabEase Logo">
            <form action="{{ route('admin.storeDepartment') }}" method="POST">
                @csrf

                <div class="m-2 mb-4">
                    <div>
                        <label for="college_id">College</label>
                    </div>
                    <select name="college_id" id="college_id" class="form-control select1 px-1 py-[6px] w-[380px] border rounded h-[38px] border-[#a3a3a3]" required>
                        @foreach ($colleges as $college)
                        <option value="{{ $college->college_id }}">{{ $college->college_description}}</option>
                        @endforeach
                    </select>
                </div>

                    <div class="m-2">
                        <div>
                            <label for="department_code">Department Code</label>
                        </div>
                        <input name="department_code" id="department_code" class="px-1 py-[6px] w-[380px] border rounded h-[38px] border-[#a3a3a3]" required></input>
                    </div>

                    <div class="m-2">
                        <div>
                            <label for="department_name">Department Name</label>
                        </div>
                        <input name="department_name" id="department_name" class="px-1 py-[6px] w-[380px] border rounded h-[38px] border-[#a3a3a3]" required></input>
                    </div>


                    <div class="m-2 ">
                        <div>
                            <label for="program_code">Program Code</label>
                        </div>
                        <input name="program_code" id="program_code" class="px-1 py-[6px] w-[380px] border rounded h-[38px] border-[#a3a3a3]" required></input>
                    </div>

                    <div class="m-2 ">
                        <div>
                            <label for="program_name">Program Name</label>
                        </div>
                        <input name="program_name" id="program_name" class="px-1 py-[6px] w-[380px] border rounded h-[38px] border-[#a3a3a3]" required></input>
                    </div>


                <div class="m-2 ">
                    <div>
                        <label for="department_status">Status</label>
                    </div>
                    <select name="department_status" id="department_status" class="px-1 py-[6px] w-[380px] border rounded h-[38px] border-[#a3a3a3]" required>
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