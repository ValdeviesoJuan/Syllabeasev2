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
        <div class="max-w-md bg-gradient-to-r from-[#FFF] to-[#dbeafe] bg-slate-100 w-[500px] p-6 rounded-lg shadow-lg">
            <img class="edit_user_img text-center mt-2 w-[300px] m-auto mb-2" src="/assets/Create User Role.png" alt="SyllabEase Logo">
            <form class="p-4 pt-8" action="{{ route('admin.storeRole') }}" method="POST">
                @csrf
                <input class="" type="text" name="user_id" value="{{ $user }}" hidden>
                <div>
                    <label class="-mb-8 font-semibold text-xl" for="role_id">Role</label>
                    <select name="role_id" id="role_id" class="select2 px-[80px]" required>
                        @foreach ($all_roles as $all_role)
                        <option value="{{ $all_role->role_id }}">{{ $all_role->role_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn text-white px-8 font-semibold py-2 rounded-lg m-2 mt-[40px] mb-4 bg-blue">Assign</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
@endsection