@extends('layouts.chairSidebar')

@section('content')
@include('layouts.modal')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyllabEase</title>
    @vite('resources/css/app.css')
</head>
<style>
    body {
        /* background-image: url("{{ asset('assets/Wave1.png') }}");
        background-repeat: no-repeat;
        background-position: top;
        background-attachment: fixed;
        min-width: 100vh;
        background-size: contain; */
        background-color: #EEEEEE;
    }
</style>

<body>
    <div class="p-4 pb-10 shadow bg-white border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="flex justify-between items-center mb-6">
            <h1 class="font-bold text-4xl text-[#201B50] mb-4">Curricula</h1>
            <a href="{{ route('chairperson.createCurr') }}"
               class="whitespace-nowrap rounded-xl hover:scale-105 transition ease-in-out px-6 py-2 text-black font-semibold flex items-center gap-2 bg-[#d7ecf9] hover:bg-[#c3dff3] max-w-full"
               style="background: #d7ecf9;"
               onmouseover="this.style.background='#c3dff3';"
               onmouseout="this.style.background='#d7ecf9';">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 8v8M8 12h8" stroke="black" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="12" r="10" stroke="black" stroke-width="1.5"/>
                </svg>
                Create New Curriculum
            </a>
        </div>
        <div div class='overflow-x-auto w-full'>
            <table class=" w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="rounded text-xs text-white uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="bg-blue5 rounded-tl-lg px-6 py-3">
                            Curr Code
                        </th>
                        <th scope="col" class="bg-blue5 px-6 py-3">
                            Effectivity
                        </th>
                        <th scope="col" class="bg-blue5 px-6 py-3">
                            Department
                        </th>
                        <th scope="col" class="rounded-tr-lg bg-blue5 px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($curricula as $curriculum)
                    <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-white' : 'bg-[#e9edf7]' }} bg-white border- dark:bg-gray-800 dark:border-gray-700 hover:bg-gray4 dark:hover:bg-gray-600">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $curriculum->curr_code }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $curriculum->effectivity }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $curriculum->department_code }}
                        </td>

                        <td class="px-6 py-4 flex">
                            <form action="{{ route('chairperson.editCurr', $curriculum->curr_id) }}" method="GET">
                                @csrf
                                <button type="submit" class="hover:text-yellow hover:underlined px-1">
                                    Edit
                                </button>
                            </form>
                            <form action="{{ route('chairperson.destroyCurr',$curriculum->curr_id) }}" method="Post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="hover:text-yellow hover:underlined px-1">
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
                    <span class="text-gray-600 text-sm">Page {{ $curricula->currentPage() }} of {{ $curricula->lastPage() }}</span>
                </div>

                {{ $curricula->links() }}
            </div>
        </div>
    </div>
</body>

</html>
@endsection






<!-- <body>
    <h1 class="">Curricula</h1>
    <a href="{{ route('admin.createCurr') }}">Create New Curriculum</a>

    <table class="">
        <thead>
            <tr>
                <th>Code</th>
                <th>Effectivity</th>
                <th>Department</th>
                <th class="actions_th">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($curricula as $curriculum)
            <tr>
                <td>{{ $curriculum->curr_code }}</td>
                <td>{{ $curriculum->effectivity }}</td>
                <td>{{ $curriculum->department_code }}</td>
                <td>


                    <form action="{{ route('admin.editCurr', $curriculum->curr_id) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>

                    <form action="{{ route('admin.destroyCurr',$curriculum->curr_id) }}" method="Post">
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

 -->