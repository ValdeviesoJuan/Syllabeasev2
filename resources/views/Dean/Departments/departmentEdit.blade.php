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
    <div class="min-h-screen  flex items-center justify-center">
        <div class="max-w-md bg-gradient-to-r from-[#FFF] to-[#dbeafe] w-[500px] p-6 rounded-lg shadow-lg">
            <img class="edit_user_img text-center mt-4 mb-6 w-[280px] m-auto mb-2" src="/assets/Edit Department.png" alt="SyllabEase Logo">
            <form action="{{ route('dean.updateDepartment', $department->department_id) }}" method="POST">
                @csrf
                @method('PUT') 

                <div class="grid gap-6 mb-6 md:grid-cols-2 mr-[25%]">
                    <div>
                        <div>
                            <label for="department_code">Department Code</label>
                        </div>
                        <input name="department_code" id="department_code" class="px-1 py-[6px] w-[100px] border rounded border-gray" required value="{{ $department->department_code }}"></input>
                    </div>

                    <div>
                        <div>
                            <label for="department_name">Department Name</label>
                        </div>
                        <input name="department_name" id="department_name" class="px-1 py-[6px] w-[230px] border rounded border-gray" required value="{{ $department->department_name }}"></input>
                    </div>
                </div>

                <div class="grid  gap-6 mb-6 md:grid-cols-2 mr-[25%]">
                    <div>
                        <label for="program_code">Program Code</label>
                        <input name="program_code" id="program_code" class="px-1 py-[6px] w-[100px] border rounded border-gray" required value="{{ $department->program_code }}"></input>
                    </div>

                    <div>
                        <label for="program_name">Program Name</label>
                        <input name="program_name" id="program_name" class="px-1 py-[6px] w-[230px] border rounded border-gray" required value="{{ $department->program_name }}"></input>
                    </div>
                </div>

                <div class="mb-6">
                    <div>
                        <label for="department_status">Status</label>
                    </div>
                    <select name="department_status" id="department_status" class="px-1 py-[6px] w-[100px] border rounded border-gray" required>
                        <option value="Active" @if ($department->department_status === 'Active') selected @endif>Active</option>
                        <option value="Inactive" @if ($department->department_status === 'Inactive') selected @endif>Inactive</option>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary font-semibold text-white px-6 py-2 rounded-lg m-2 mt-2 mb-4 bg-blue">Update Department</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
@endsection