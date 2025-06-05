<!-- @-extends('layouts.deanNav') -->
@extends('layouts.deanSidebar')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md bg-gradient-to-r from-[#FFF] to-[#dbeafe] w-[500px] p-6 rounded-lg shadow-lg">
            <img class="edit_user_img text-center mt-4 mb-6 w-[280px] m-auto mb-2" src="/assets/Edit Chairperson.png" alt="SyllabEase Logo">
            <form action="{{ route('dean.updateChair', $chair->chairman_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <div>
                        <label for="user_id">Chairperson</label>
                    </div>
                    <select name="user_id" id="user_id" class="select2 js-example-basic-multiple js-states form-control px-1 py-[6px] w-[400px] border rounded border-black" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $chair->chairman_id ? 'selected' : '' }}>
                                {{ $user->lastname }}, {{ $user->firstname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <div>
                        <label for="department_id">Department</label>
                    </div>
                    <select name="department_id" id="department_id" class="select2 js-example-basic-multiple js-states form-control px-1 py-[6px] w-[400px] border rounded border-black" required>
                        @foreach ($departments as $department)
                            <option value="{{ $department->department_id }}" {{ $department->department_id == $chair->department_id ? 'selected' : '' }}>
                                {{ $department->department_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid gap-6 mb-3 md:grid-cols-2">
                    <div class="mb-3">
                        <div>
                            <label for="start_validity">Start of Validity</label>
                        </div>
                        <input type="date" name="start_validity" id="start_validity" class="px-1 py-[6px] w-[190px] border rounded h-[38px] border-[#a3a3a3]" required value="{{ $chair->start_validity }}">
                    </div>

                    <div class="mb-3">
                        <label for="end_validity">End of Validity</label>
                        <input type="date" name="end_validity" id="end_validity" class="px-1 py-[6px] w-[190px] border rounded h-[38px] border-[#a3a3a3]" required value="{{ $chair->end_validity }}">
                        @error('end_validity')
                        <span class="" role="alert">
                            <strong class="">{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary font-semibold text-white px-6 py-2 rounded-lg m-2 mb-4 bg-blue">Update Chairman</button>
                </div>
            </form>
</body>
</html>
    
@endsection
