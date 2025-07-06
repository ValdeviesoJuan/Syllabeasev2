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
            <img class="edit_user_img text-center mt-4 mb-6 w-[300px] m-auto mb-2" src="/assets/Assign Chairperson.png" alt="SyllabEase Logo">
            <form action="{{ route('dean.storeChair') }}" method="POST">
                @csrf
                <div class="mb-6">
                <div>
                    <label for="user_id">Chairperson</label>
                </div>
                <select name="user_id" id="user_id" class="select2 px-1 py-[6px] w-[400px] border rounded border-gray" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->lastname }}, {{ $user->firstname }}</option>
                        @endforeach
                </select>
                </div>

                <div class="mb-6">
                    <div>
                        <label for="department_id">Department</label>
                    </div>
                    <select name="department_id" id="department_id" class="select2 js-example-basic-multiple js-states form-control px-1 py-[6px] w-[400px] border rounded border-black" required>
                        @foreach ($departments as $department)
                            <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
                        @endforeach
                    </select>        
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="mb-3">
                        <label for="start_validity">Start of Validity</label>
                        <input type="date" name="start_validity" id="start_validity" class="form-control px-1 py-[6px] w-[190px] border rounded h-[38px] border-[#a3a3a3]" required></input>
                    </div>
                    <div class="mb-3">
                        <label for="end_validity">End of Validity</label>
                        <input type="date" name="end_validity" id="end_validity" class="form-control px-1 py-[6px] w-[190px] border rounded h-[38px] border-[#a3a3a3]" ></input>
                    </div>
                    @error('end_validity')
                        <span class="" role="alert">
                            <strong class="">{{ $message }}</strong>
                        </span>
                        @enderror
                </div>
                <div class="text-center">
                    <button type="submit"
                        class="whitespace-nowrap rounded-xl hover:scale-105 transition ease-in-out px-6 py-2 text-black font-semibold flex items-center gap-2 m-auto mt-8 mb-4"
                        style="background: #d7ecf9;"
                        onmouseover="this.style.background='#c3dff3';"
                        onmouseout="this.style.background='#d7ecf9';">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="9" cy="7" r="4" stroke="black" stroke-width="1.5"/>
                            <path d="M20 8v6M23 11h-6" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Assign Chair
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
@endsection