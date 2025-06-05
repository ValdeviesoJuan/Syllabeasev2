<!-- @-extends('layouts.adminNav') -->
@extends('layouts.adminSidebar')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <link rel="stylesheet" href="/css/edit_user.css"> -->
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
            /* background-color: #EEEEEE; */
        }
    </style>
</head>

<body>

    <div class="p-4 mt-14 flex items-center justify-center">
        <div class="max-w-md bg-gradient-to-r from-[#FFF] to-[#dbeafe] bg-slate-100 w-[500px] p-6 rounded-lg shadow-lg">
            <img class="edit_user_img text-center mt-2 m-auto mb-2" src="/assets/Edit User.png" alt="SyllabEase Logo">
            {{-- <h1 class="text-center text-3xl font-semibold">Edit User</h1> --}}
            <form class="p-4" action="{{ route('admin.update', $user->id) }}" method="POST">
                @csrf

                <input type="hidden" name="_method" value="PUT">

                <div class="form-group mb-4">
                    <label class="labelinput flex" for="firstname">First Name</label>
                    <input type="text" name="firstname" class="px-1 py-[6px] w-full border border-[#a8a29e] rounded border-gray" id="firstname" value="{{ $user->firstname }}">
                </div>

                <div class="form-group mb-4">
                    <label class="flex" for="lastname">Last Name</label>
                    <input type="text" name="lastname" id="lastname" class="px-1 py-[6px] w-full border border-[#a8a29e] rounded border-gray" value="{{ $user->lastname }}">
                </div>

                <div class="form-group mb-4">
                    <label class="flex" for="phone">Phone Number</label>
                    <input type="text" name="phone" id="phone" class="px-1 py-[6px] w-full border border-[#a8a29e] rounded border-gray" value="{{ $user->phone }}">
                </div>

                <div class="form-group mb-4">
                    <label class="flex" for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="px-1 py-[6px] w-full border border-[#a8a29e] rounded border-gray" value="{{ $user->email }}">
                </div>

                <!-- <div class="form-group">
                    <label for="email">Role ID</label>
                    <input type="role_id" name="role_id" id="role_id" value="{{ $user->role_id }}">
                </div> -->

                <div class="text-center">
                    <button type="submit" class="btn text-white px-8 font-semibold py-2 rounded-lg m-2 mt-[40px] mb-4 bg-blue">Update User</button>
                </div>
                <div class="back_btn text-center hover:text-blue hover:underline">
                    <a href="/admin" id="user edit">Back</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
@endsection