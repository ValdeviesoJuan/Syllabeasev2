@extends('layouts.allNav')
@section('content')
@include('layouts.accessModal')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/home_user.css">
    <title>User Home Page</title>
    @vite('resources/css/app.css')
    <style>
        .bg svg {
            transform: scaleY(-1);
            min-width: '1880'
        }

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
    <div class="flex items-center justify-center">
        <div class="bg-white h-content m-auto justify-center mt-[6%] w-[400px] rounded-lg shadow-xl pb-5">
            <div class="flex justify-center mt-5 w-full shadow">
                <img class="w-[280px] text-lg font-bold md:py-0 py-4" src="/assets/Sample/syllabease.png" alt="SyllabEase">
            </div>
            <div class="flex justify-center font-semibold text-lg text-gray2">
                Login as
            </div>
            @php
            $href = '';
            $roleCount = count($myRoles);

            if ($roleCount == 1) {
            $myRole = $myRoles[0];

            if ($myRole->role_id == 1) {
            $href = route('admin.home');
            } elseif ($myRole->role_id == 2) {
            $href = route('dean.home');
            } elseif ($myRole->role_id == 3) {
            $href = route('chairperson.home');
            } elseif ($myRole->role_id == 4) {
            $href = route('bayanihanleader.home');
            } elseif ($myRole->role_id == 5) {
            $href = route('bayanihanteacher.home');
            } else {
            $href = '#';
            }

            echo "<script>
                window.location.href = '{$href}';
            </script>";
            }
            @endphp

            @foreach($myRoles as $myRole)
            @php
            if ($myRole->role_id == 1) {
            $href = route('admin.home');
            } elseif ($myRole->role_id == 2) {
            $href = route('dean.home');
            } elseif ($myRole->role_id == 3) {
            $href = route('chairperson.home');
            } elseif ($myRole->role_id == 4) {
            $href = route('bayanihanleader.home');
            } elseif ($myRole->role_id == 5) {
            $href = route('bayanihanteacher.home');
            } else {
            $href = '#';
            }
            @endphp

            <a class="" href="{{ $href }}">
                <div class="hover:bg-blue hover:text-white text-gray2 mt-2 bg-blue2 h-[50px] mx-5 rounded-md flex justify-center items-center mb-3">
                    <div class="font-semibold text-lg">
                        {{ $myRole->role_name }}
                    </div>
                </div>
            </a>
            @endforeach

        </div>
    </div>
</body>

</html>
@endsection