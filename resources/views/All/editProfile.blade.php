@extends('layouts.allNav')

@section('content')
@include('layouts.modal')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

                        {{-- Profile Circle with Edit Icon --}}
                        <div class="w-full px-4 flex justify-center mt-6">
                            <div class="relative w-[200px] h-[200px]">
                                @if(Auth::user()->profile_image)
                                    <img src="{{ asset('storage/profile_images/' . Auth::user()->profile_image) }}" 
                                        alt="Profile" 
                                        class="w-full h-full object-cover rounded-full border-4 border-blue">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-yellow text-white text-[90px] rounded-full border-4 border-blue">
                                        {{ Str::upper(substr(Auth::user()->firstname, 0, 1)) . Str::upper(substr(Auth::user()->lastname, 0, 1)) }}
                                    </div>
                                @endif

                                {{-- Hidden file input --}}
                                <input type="file" name="profile_image" id="profile_image" class="hidden" onchange="this.form.submit()">

                                {{-- Edit icon overlay --}}
                                <label for="profile_image" class="absolute bottom-2 right-2 bg-blue text-white rounded-full p-2 shadow cursor-pointer hover:bg-darkBlue transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16.862 3.487a2.25 2.25 0 013.182 3.182L9 17.713 5.25 18.75l1.037-3.75 10.575-11.513z" />
                                    </svg>

                                </label>
                            </div>
                        </div>

                        {{-- Form --}}
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Name Fields --}}
                            <div class="grid gap-6 mt-6 mb-6 md:grid-cols-2">
                                <div>
                                    <label class="flex font-semibold" for="firstname">First Name</label>
                                    <input type="text" name="firstname" id="firstname" class="px-1 py-[6px] w-[250px] border rounded border-gray" value="{{ $user->firstname }}">
                                </div>

                                <div>
                                    <label class="flex font-semibold" for="lastname">Last Name</label>
                                    <input type="text" name="lastname" id="lastname" class="px-1 py-[6px] w-[250px] border rounded border-gray" value="{{ $user->lastname }}">
                                </div>
                            </div>

                            {{-- Prefix / Suffix --}}
                            <div class="grid gap-6 mt-6 mb-6 ml-0 md:grid-cols-2">
                                <div>
                                    <label class="flex font-semibold" for="prefix">Prefix</label>
                                    <input type="text" name="prefix" id="prefix" class="px-1 py-[6px] w-[250px] border rounded border-gray" value="{{ $user->prefix }}">
                                </div>

                                <div>
                                    <label class="flex font-semibold" for="suffix">Suffix</label>
                                    <input type="text" name="suffix" id="suffix" class="px-1 py-[6px] w-[250px] border rounded border-gray" value="{{ $user->suffix }}">
                                </div>
                            </div>

                            {{-- Contact Info --}}
                            <div class="grid gap-6 mt-4 mb-6 md:grid-cols-2">
                                <div>
                                    <label class="flex font-semibold" for="phone">Phone Number</label>
                                    <input type="text" name="phone" id="phone" class="px-1 py-[6px] w-[250px] border rounded border-gray" value="{{ $user->phone }}">
                                </div>

                                <div>
                                    <label class="flex font-semibold" for="email">Email Address</label>
                                    <input type="email" name="email" id="email" class="px-1 py-[6px] w-[250px] border rounded border-gray" value="{{ $user->email }}">
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="text-center mt-8 content-center">
                                <button type="submit" class="text-white font-semibold px-12 py-2 rounded-lg m-2 mt-8 bg-blue">Update Profile</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Edit Password Link --}}
                <div class="text-center content-center mb-8 hover:text-black font-semibold text-[#6b7280] shadow-lg w-[197px] py-2 rounded-lg mx-auto">
                    <a href="{{ route('password.edit') }}">Edit password</a>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
@endsection
