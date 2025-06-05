<!-- @-extends('layouts.adminNav') -->
@extends('layouts.adminSidebar')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <link rel="stylesheet" href="/css/edit_role.css"> -->
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
    <div class="p-4">
        <div class="flex flex-col justify-center mb-20">
            <div class="w-[1030px] py-12 px-12 -mt-12 flex flex-col p-12 md:space-y-0 rounded-xl p-3 mx-auto bg-transparent">
                <div class="h-[110px] inline-block p-4 rounded-lg">
                    <h2 class="heads w-[500px] -ml-[10px] mt-6 text-center p-2 px-4 text-3xl font-semibold">
                        <svg class="-mb-8" width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#1e3a8a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <div c lass="-ml-[10%]">
                            {{$user->firstname}} {{$user->lastname}}
                        </div>
                    </h2>

                    <a class="assign_role -mt-12 flex mr-2 font-semibold float-right bg-blue text-white rounded-lg px-4 py-2 hover:scale-105 w-max transition ease-in-out" href="{{ route('admin.createRole', $user->id) }}">
                        <svg class="" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        Assign New Role</a>
                </div>

                <div class="grid gap-6 md:grid-cols-3">
                @foreach ($user_roles as $user_role)
                    <div class="role_form m-4 p-4 w-[280px] bg-gradient-to-r from-[#FFF] to-[#dbeafe] h-[270px] rounded-xl transform hover:scale-105 transition duration-500 shadow-lg">
                        <form class="" action="{{ route('admin.updateRoles', $user_role->ur_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="rolename text-center mb-6 text-2xl mt-3 font-semibold mb-2">{{ $user_role->role_name }}</div>
                            <div class="mb-3">
                                <label class="role_text font-semibold" for="role_id">Role</label>
                                <select name="role_id" id="role_id" class="options border border-[#a8a29e] w-[200px] p-1 rounded" required>
                                    @foreach ($all_roles as $all_role)
                                    <option class="options" value="{{ $all_role->role_id }}" {{ $user_role->role_id == $all_role->role_id ? 'selected' : '' }}>
                                        {{ $all_role->role_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="text-center mt-12">
                                <div class="">
                                    <div class="">
                                        <button type="submit" class="btn btn-primary font-semibold shadow-lg px-7 bg-blue hover:bg-[#2563eb] text-white rounded-lg p-1">
                                            Update Role
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="text-center mb-12s">
                            <form action="{{ route('admin.destroyRoles', $user_role->ur_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger px-12 text-[#6b7280] bg-white font-semibold hover:text-black shadow-lg p-1 rounded-lg mt-4">
                                    Delete
                                </button>
                            </form>
                        </div>

                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</body>

</html>
@endsection