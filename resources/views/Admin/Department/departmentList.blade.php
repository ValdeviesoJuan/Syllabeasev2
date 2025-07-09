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
            background-image: url("{{ asset('assets/Wave.png') }}");
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
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-4xl flex text-left text-black font-semibold leadi mb-0">Departments</h2>
                    <a href="{{ route('admin.createDepartment') }}"
                       class="whitespace-nowrap w-50 rounded-xl hover:scale-105 w-max transition ease-in-out p-2 text-black font-semibold flex items-center gap-2 max-w-full"
                       style="background: #d7ecf9;"
                       onmouseover="this.style.background='#c3dff3';"
                       onmouseout="this.style.background='#d7ecf9';">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 8v8M8 12h8" stroke="black" stroke-width="1.5"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="10" stroke="black" stroke-width="1.5"/>
                        </svg>
                        Add New Department
                    </a>
                </div>
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
                <a href="{{ route('admin.createChair') }}"
                    class="whitespace-nowrap mb-6 w-50 rounded-xl mr-1.5 hover:scale-105 w-max transition ease-in-out p-2 text-black font-semibold flex items-center gap-2 max-w-full"
                    style="background: #d7ecf9;"
                    onmouseover="this.style.background='#c3dff3';"
                    onmouseout="this.style.background='#d7ecf9';">

                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 8v8M8 12h8" stroke="black" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="10" stroke="black" stroke-width="1.5"/>
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
