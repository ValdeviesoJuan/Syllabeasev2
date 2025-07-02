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
        </style>
</head>

<body>
    <div class="min-h-screen bg-swhite py-5 ml-16 mr-16 mx-auto">
        <div class="p-4 shadow-lg bg-white border-dashed rounded-lg dark:border-gray-700 mt-16">
            <div class="" id="whole">
                <div class="flex justify-center align-items-center">
                    <div class="min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <h2 class="text-3xl text-black -mb-[30px] font-semibold">Colleges</h2>
                                <a class="whitespace-nowrap mb-6 w-50 bg-seThird rounded-xl mr-1.5 hover:scale-105 w-max transition ease-in-out p-2 text-black font-semibold flex max-w-full float-right" href="{{ route('admin.createCollege') }}">
                                <svg class="mr-2" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                                Create College
                                </a>
                        </div>
                    </div>
                </div>

                <div class='overflow-x-auto w-full'>
                    <table class='w-full bg-gray-400 border-none shadow-lg table-auto overflow-scroll px-3 text-left whitespace-nowrap'>
                        <thead class="">
                            <tr class="bg-blue text-2xl text-white">
                                <th class="px-4 py-2 text-start text-lg font-bold text-white "> Code </th>
                                <th class="px-4 py-2 text-start text-lg font-bold text-white "> Description </th>
                                <th class="px-4 py-2 text-start text-lg font-bold text-white uppercase"></th>
                                <th class="px-4 py-2 text-start text-lg font-bold text-white uppercase"></th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#e5e7eb] bg-white">
                            @foreach ($colleges as $college)
                            <tr class="hover:bg-gray4 dark:hover:bg-gray-600">
                                <td class="px-4 py-2 font-bold">
                                    <div class="flex items-center space-x-3">
                                        <div>
                                            <p>{{ $college->college_code }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-2">
                                    <p class="">{{ $college->college_description }}</p>
                                </td>

                                <td class="px-4 py-2 text-center">
                                    <form action="{{ route('admin.editCollege', $college->college_id) }}" method="GET">
                                    @csrf
                                        <button type="submit" class="text-green font-medium mt-5 hover:scale-105">
                                            Edit
                                        </button>
                                    </form>
                                </td>

                                <td>
                                    <form action="{{ route('admin.destroyCollege',$college->college_id) }}" method="Post">
                                    @csrf
                                    @method('DELETE')
                                        <button type="submit" class="text-red font-medium mt-5 hover:scale-105">
                                           Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                <div class="mt-9">
                    <div class="flex justify-center">
                        <span class="text-gray-600 text-sm">Page {{ $colleges->currentPage() }} of {{ $colleges->lastPage() }}</span>
                    </div>
                        {{ $colleges->links() }} <!-- Pagination links -->
                </div>
            </div>
        </div>
    </div>    

    <div class="">
        <div class="p-4 shadow-lg bg-white border-dashed rounded-lg dark:border-gray-700 mt-24">
            <div class="flex justify-center align-items-center">
                <div class="min-w-full inline-block align-middle">
                    <div class="overflow-hidden">
                        <h2 class="text-3xl text-black font-semibold -mb-[35px]">Dean</h2>
                            <a class="whitespace-nowrap mb-6 w-50 bg-seThird rounded-xl mr-1.5 hover:scale-105 w-max transition ease-in-out p-2 text-black font-semibold flex max-w-full float-right" href="{{ route('admin.createDean') }}">
                                <svg class="mr-2" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                                Assign Dean
                            </a>
                    </div>
                </div>
            </div>
                
            <div class='overflow-x-auto'>
                <table class='w-full border-none shadow-lg table-auto overflow-scroll p-2 text-left whitespace-nowrap'>
                    <thead class="bg-[#e2e8f0] border-none shadow-lg">
                        <tr class="bg-blue text-xl text-white">
                            <th class="p-6 py-2 text-start text-sm font-bold text-white "> Code </th>
                            <th class="p-6 py-2 text-start text-sm font-bold text-white "> Name </th>
                            <th class="p-6 py-2 text-start text-sm font-bold text-white "> Start Validity </th>
                            <th class="p-6 py-2 text-start text-sm font-bold text-white "> End Validity </th>
                            <th class="p-6 py-2 text-start text-sm font-bold text-white uppercase"> </th>
                            <th class="p-6 py-2 text-start text-sm font-bold text-white uppercase"> </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#e5e7eb] bg-white">
                    @foreach ($deans as $dean)
                        <tr class="hover:bg-gray4 dark:hover:bg-gray-600">
                            <td class="px-2 text-sm py-2 font-bold">
                                <div class="flex items-center space-x-3">
                                    <div>
                                        <p>{{ $dean->college_code }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-2 py-2">
                                <p class="">{{ $dean->firstname }} {{ $dean->lastname }}</p>
                            </td>
                            <td class="px-2 py-2">
                                <p class="">{{ $dean->start_validity }}</p>
                            </td>
                            <td class="px-2 py-2">
                                <p class="">{{ $dean->end_validity }}</p>
                            </td>

                            <td class="px-2 py-2 text-center">
                                <form action="{{ route('admin.editDean', $dean->ur_id) }}" method="GET">
                                @csrf
                                    <button type="submit" class="text-green mt-5 font-medium hover:scale-105">
                                        Edit
                                    </button>
                                </form>
                            </td>

                            <td>
                                <form action="{{ route('admin.destroyDean',$dean->ur_id) }}" method="Post">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="text-red font-medium mt-5 hover:scale-105">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    <div class="flex justify-center">
                        <span class="text-gray-600 text-sm">Page {{ $deans->currentPage() }} of {{ $deans->lastPage() }}</span>
                    </div>
                    {{ $deans->links() }} <!-- Pagination links -->
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>

@endsection








<!-- <body>
    <h1 class="">Colleges</h1>
    <a href="{{ route('admin.createCollege') }}">Create New College</a>

    <table class="">
        <thead>
            <tr>
                <th>Code</th>
                <th>Descripion</th>
                <th class="actions_th">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($colleges as $college)
            <tr>
                <td>{{ $college->college_code }}</td>
                <td>{{ $college->college_description }}</td>
                <td>

                    <form action="{{ route('admin.editCollege', $college->college_id) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>

                    <form action="{{ route('admin.destroyCollege',$college->college_id) }}" method="Post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h1 class="">Dean</h1>
    <a href="{{ route('admin.createDean') }}">Assign Dean</a>

    <table class="">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Start Validity</th>
                <th>End Validity</th>

                <th class="actions_th">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($deans as $dean)
            <tr>
                <td>{{ $dean->college_code }}</td>
                <td>{{ $dean->firstname }} {{ $dean->lastname }}</td>
                <td>{{ $dean->start_validity }}</td>
                <td>{{ $dean->end_validity }}</td>
                <td>

                    <form action="{{ route('admin.editDean', $dean->ur_id) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>

                    <form action="{{ route('admin.destroyDean',$dean->ur_id) }}" method="Post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html> -->