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
        body {
            background-image: url("{{ asset('assets/Wave.png') }}"); */
            background-color: #EEEEEE;
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain; 
        }
    </style>
</head>

<body>
    <div class="p-8 pb-4 shadow bg-white border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="flex justify-center align-items-center">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <div class="flex justify-between items-center mb-2 mt-2">
                        <h2 class="font-bold text-3xl text-[#201B50]">Departments</h2>
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
                    <div class="overflow-x-auto w-full pt-6"> 
                        <table class="w-full shadow-lg text-sm mt-12 bg-white text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="rounded text-xs text-white bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr class="bg-blue rounded text-sm text-white">
                                    <th class="bg-blue5 rounded-tl-lg px-6 py-3">Code</th>
                                    <th class="bg-blue5 px-6 py-3">Name</th>
                                    <th class="bg-blue5 px-6 py-3">Status</th>
                                    <th class="bg-blue5 px-6 py-3"></th>
                                    <th class="bg-blue5 rounded-tr-lg px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="">
                                @foreach ($departments as $department)
                                <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-white' : 'bg-[#e9edf7]' }} bg-white border- dark:bg-gray-800 dark:border-gray-700 hover:bg-gray4 dark:hover:bg-gray-600">
                                    <td class="px-6 text-md font-bold dark:text-gray-400">{{ $department->department_code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sl text-gray-800 dark:text-gray-200">{{ $department->department_name }}</td>
                                    {{-- <td class="px-6 py-4 whitespace-nowrap text-sl text-gray-800 dark:text-gray-200">{{ $department->department_status }}</td> --}}

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
                                            <button type="submit" class="text-green font-medium hover:scale-105 mt-3">
                                               Edit
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('dean.destroyDepartment',$department->department_id) }}" method="Post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red font-medium hover:scale-105 mt-3">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination">
                            <div class="flex justify-center">
                                <span class="mt-6 text-gray-600 text-sm">Page {{ $departments->currentPage() }} of {{ $departments->lastPage() }}</span>
                            </div>
                            {{ $departments->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <h2>Chair</h2>
        <a href="{{ route('dean.createChair') }}">Assign a new Chairperson</a>
        <div class="table-container"> 
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($chairs as $chair)
                    <tr>
                        <td>{{ $chair->lastname }}, {{ $chair->firstname }}</td>
                        <td>{{ $chair->department_code }}</td>
                        <td>{{ $chair->start_validity }}</td>
                        <td>{{ $chair->end_validity }}</td>
                        <td>
                            <form action="{{ route('dean.editChair', $chair->chairman_id) }}" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('dean.destroyChair',$chair->chairman_id) }}" method="Post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination">
                <div class="flex justify-center">
                    <span class="text-gray-600 text-sm">Page {{ $chairs->currentPage() }} of {{ $chairs->lastPage() }}</span>
                </div>
                {{ $chairs->links() }}
            </div>
        </div> -->
    </body>

</html>
@endsection