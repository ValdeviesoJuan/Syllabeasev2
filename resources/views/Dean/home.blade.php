@extends('layouts.deanSidebar')
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
            background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain; 
            background-color: #EEEEEE;
        }
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
                    <div class="flex justify-between items-center mb-2 mt-2">
                        <h2 class="font-bold text-4xl text-[#201B50]">Departments</h2>
                        <a href="{{ route('dean.createDepartment') }}"
                            class="whitespace-nowrap w-50 rounded-xl mr-1.5 hover:scale-105 w-max transition ease-in-out p-2 text-black font-semibold flex items-center gap-2 max-w-full"
                            style="background: #d7ecf9;"
                            onmouseover="this.style.background='#c3dff3';"
                            onmouseout="this.style.background='#d7ecf9';">

                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 8v8M8 12h8" stroke="black" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="12" cy="12" r="10" stroke="black" stroke-width="1.5"/>
                            </svg>
                            Add new Department
                        </a>
                    </div>
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