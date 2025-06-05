@extends('layouts.deanSidebar')

@section('content')
@include('layouts.modal')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syllabease</title>
    @vite('resources/css/app.css')

<style>
    body {
        /* background-image: url("{{ asset('assets/Wave.png') }}");
        background-repeat: no-repeat;
        background-position: top;
        background-attachment: fixed;
        background-size: contain; */
        background-color: #EEEEEE;
    }
</style>
</head>
<body>
    <div>
        <div class="mt-16 p-4 pb-4 shadow bg-white border-dashed rounded-lg dark:border-gray-700">
            <livewire:dean-reports/>
        </div>
    </div>
</body>
</html>
@endsection