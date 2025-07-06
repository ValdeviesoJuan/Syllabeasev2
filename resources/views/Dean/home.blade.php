@extends('layouts.deanSidebar')
{{-- @extends('layouts.deanNav') --}}

@section('content')
@include('layouts.modal')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dean Home</title>
    @vite('resources/css/app.css')
    

    <style>
        .bg svg {
            transform: scaleY(-1);
            min-width: '1880'
        }

        body {
            /* background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain; */
            background-color: #EEEEEE;
        }

        /* body {
            background-color: #e8e9e9;
        } */

        /* table, */
        /* tbody {
            border: 1px solid;
            border-collapse: collapse;
            padding: 4px;
            border-color: black;
        } */

        /* th {
            background-color: #2468d2;
            color: white;
        } */
    </style>
    <script>
        //JS for Searchable Select
        $(document).ready(function() {
            $('.select2').select2(); // Initialize Select2 
        });
    </script>
</head>

<body>
    <div class="p-4 pb-4 shadow bg-white border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="flex justify-center align-items-center">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <h2 class="font-bold text-4xl text-[#201B50] mb-4">Departments</h2>
                    <a class="whitespace-nowrap absolute w-50 mr-1.5 hover:scale-105 w-max transition ease-in-out px-4 py-2 font-semibold flex max-w-full float-left bg-blue5 mb-2 text-white rounded-lg hover:bg-blue" href="{{ route('dean.createDepartment') }}">
                        <svg class="mr-2" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#FFF" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#FFF" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        Add new Department</a>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto w-full pt-6"> 
            <table class='w-full mt-12 shadow-lg text-sm mt-12 bg-white text-left rtl:text-right text-gray-500 dark:text-gray-400'>
                <thead class="rounded text-xs text-white bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="text-sm text-white">
                        <th class="bg-blue5 rounded-tl-lg px-6 py-3"> Code </th>
                        <th class="bg-blue5 px-6 py-3"> Name</th>
                        <th class="bg-blue5 px-6 py-3"> Status</th>
                        <th class="bg-blue5 px-6 py-3"></th>
                        <th class="bg-blue5 rounded-tr-lg px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="">
                    @foreach ($departments as $department)
                    <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-white' : 'bg-[#e9edf7]' }} bg-white border- dark:bg-gray-800 dark:border-gray-700 hover:bg-gray4 dark:hover:bg-gray-600">
                        <td class="px-6 text-md font-medium dark:text-gray-400">
                            <div class="flex items-center space-x-3">
                                <div>
                                    <p>{{ $department->department_code }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <p class="">{{ $department->department_name }}</p>
                        </td>

                        {{-- <td class="px-6 py-4">
                            <p>{{ $department->department_status }}</p>
                        </td> --}}

                        <td class="px-6 py-4 flex">
                            @if($department->department_status == 'Active')
                                <p class="bg-emerald-200 text-emerald-600 border-2 border-emerald-400 rounded-lg text-center flex justify-center px-12 py-[1px]">Active</p>
                            @else
                                <p class="bg-[#fca5a5] text-[#b91c1c] border-2 border-[#ef4444] rounded-lg text-center flex justify-center px-11 py-[1px]">Inactive</p>
                            @endif
                        </td>
                        
                        <td>
                            <form action="{{ route('dean.editDepartment', $department->department_id) }}" method="GET">
                                @csrf
                                <button type="submit" class="text-green font-medium mt-1 hover:scale-105">
                                    Edit
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('dean.destroyDepartment',$department->department_id) }}" method="Post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red font-medium mt-1 hover:scale-105">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
        <div class="pagination mt-6">
            <div class="flex justify-center">
                <span class="text-gray-600 text-sm">Page {{ $departments->currentPage() }} of {{ $departments->lastPage() }}</span>
            </div>
            {{ $departments->links() }}
        </div>
    </div>
    
</body>

</html>
@endsection