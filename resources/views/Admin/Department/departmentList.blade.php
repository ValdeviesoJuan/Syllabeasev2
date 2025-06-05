<!-- @-extends('layouts.adminNav') -->
@extends('layouts.adminSidebar')
@include('layouts.modal')
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
            /* background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain; */
            background-color: #EEEEEE;
        }
        table,
        /* tbody{
            border: 1px solid black;
        }
        .dot{
            font-size: 12px;
        } */
        </style>
</head>

<body>
    <div>
        <div class="p-4 shadow-lg bg-white border-dashed rounded-lg dark:border-gray-700 mt-16">
            <div class="" id="whole">
                <div class="overflow-hidden ml-2">
                    <h2 class="text-4xl mb-4 flex text-left text-black font-semibold leadi ">Departments</h2>
                </div>
                <a class="ml-2 whitespace-nowrap w-50 bg-seThird rounded-xl mr-1.5 hover:scale-105 w-max transition ease-in-out p-2 text-black font-semibold flex max-w-full" href="{{ route('admin.createDepartment') }}">
                        <svg class="mr-2" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    Add new Department
                </a>
                <livewire:admin-department-table />
                <div class='overflow-x-auto w-full'>
            </div>
            
        </div>
    </div>


    <div>
        <div class="p-4 shadow-lg bg-white border-dashed rounded-lg dark:border-gray-700 mt-14">
            <div class="" id="whole">
                <div class="flex overflow-hidden">
                    <h2 class="text-4xl mb-4 flex text-left text-black font-semibold leadi ml-2 ">Chairperson</h2>
                </div>
                <a class="ml-2 whitespace-nowrap mb-6 w-50 bg-seThird rounded-xl mr-1.5 hover:scale-105 w-max transition ease-in-out p-2 text-black font-semibold flex max-w-full" href="{{ route('admin.createChair') }}">
                        <svg class="mr-2" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    Assign Chairperson
                </a>
                <livewire:admin-chairperson-table />
            </div>
        </div>
    </div>

</body>
</html>
@endsection
