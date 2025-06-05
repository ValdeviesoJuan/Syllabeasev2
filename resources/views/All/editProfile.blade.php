@extends('layouts.allNav')

@section('content')
@include('layouts.modal')
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
            background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain;
        }
    </style>
</head>

<body>
    <section class="pt-16 bg-blueGray-50">
        <div class="w-full lg:w-5/12 px-4 mx-auto">
        <div class="relative flex flex-col min-w-0 break-words bg-gradient-to-r from-[#FFF] to-[#dbeafe] w-full mb-6 shadow-xl rounded-lg mt-16">
            <div class="px-6">
            <div class="flex flex-wrap justify-center">
                <div class="w-full px-4 flex justify-center">
                <div class="relative">
                    <div class="cursor-pointer -mt-[50%] border-4 border-blue w-[200px] h-[200px] flex md:inline-flex text-white hover:text-beige items-center hover:bg-seThird bg-yellow rounded-full justify-center">
                        <div class="text-white text-[90px]">
                            {{ Str::upper(substr(Auth::user()->firstname, 0, 1)) . Str::upper(substr(Auth::user()->lastname, 0, 1)) }}
                        </div>
                    </div>                  
                </div>
                </div>
                {{-- <img class="edit_user_img text-center mt-6 w-[200px] m-auto mb-4" src="/assets/Edit Profile.png" alt="SyllabEase Logo"> --}}

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
    
                    <div class="grid gap-6 mt-6 mb-6 md:grid-cols-2">
                        <div class="">
                            <label class="labelinput flex font-semibold" for="firstname">First Name</label>
                            <input type="text" name="firstname" id="firstname" class="px-1 py-[6px] w-[250px] border rounded border-gray" value="{{ $user->firstname }}">
                        </div>
        
                        <div class="">
                            <label class="flex font-semibold" for="lastname ">Last Name</label>
                            <input type="text" name="lastname" id="lastname" class="px-1 py-[6px] w-[250px] border rounded border-gray" value="{{ $user->lastname }}">
                        </div>
                    </div>

                    <div class="grid gap-6 mt-6 mb-6 ml-0 md:grid-cols-2">
                        <div class="">
                            <label class="flex font-semibold" for="prefix">Prefix</label>
                            <input type="text" name="prefix" id="prefix" class="px-1 py-[6px] w-[250px] border rounded border-gray" value="{{ $user->prefix }}">
                        </div>
                    
                        <div class="">
                            <label class="flex font-semibold" for="suffix">Suffix</label>
                            <input type="text" name="suffix" id="suffix" class="px-1 py-[6px] w-[250px] border rounded border-gray" value="{{ $user->suffix }}">
                        </div>
                    </div>
                    <div class="grid gap-6 mt-4 mb-6 md:grid-cols-2">
                        <div class="">
                            <label class="flex font-semibold" for="phone">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="px-1 py-[6px] w-[250px] border rounded border-gray" value="{{ $user->phone }}">
                        </div>
        
                        <div class="">
                            <label class="flex font-semibold" for="email">Email Address</label>
                            <input type="email" name="email" id="email" class="px-1 py-[6px] w-[250px] border rounded border-gray" value="{{ $user->email }}">
                        </div>
                    </div>
    

                    <div class="text-center mt-8 content-center">
                        <button type="submit" class="text-white font-semibold px-12 py-2 rounded-lg m-2 mt-8 bg-blue">Update Profile</button>
                    </div>                
                </form>
            </div>
            </div>
            <div class="text-center content-center  mb-8 hover:text-black font-semibold text-[#6b7280] shadow-lg w-[197px] py-2 rounded-lg mx-auto">
                <a href="{{ route('password.edit') }}">Edit password</a>
            </div>
        </div>
    </section>
</body>

</html>
@endsection