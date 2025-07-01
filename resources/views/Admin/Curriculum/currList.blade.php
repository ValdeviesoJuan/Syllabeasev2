<!-- 
 @-extends('layouts.adminNav') -->
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
    </style>
</head>

<body>
    <div>
        <div class="p-4 shadow-lg bg-white border-dashed rounded-lg dark:border-gray-700 mt-16">
            <div id="whole">
                <div class="overflow-hidden">
                    <div class="flex overflow-hidden">
                        <h2 class="text-4xl mt-2 mb-2 flex text-left text-black font-semibold leadi ">Curricula</h2>
                    </div>
                        <a href="{{ route('admin.createCurr') }}"
   class="whitespace-nowrap mb-6 w-50 rounded-xl mr-1.5 hover:scale-105 w-max transition ease-in-out p-2 text-black font-semibold flex items-center gap-2 max-w-full"
   style="background: #d7ecf9;"
   onmouseover="this.style.background='#c3dff3';"
   onmouseout="this.style.background='#d7ecf9';">

    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
         xmlns="http://www.w3.org/2000/svg">
        <path d="M15 12H9M12 9V15" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
        <path d="M7 3.34C8.47 2.49 10.18 2 12 2C17.52 2 22 6.48 22 12C22 17.52 17.52 22 12 22C6.48 22 2 17.52 2 12C2 10.18 2.49 8.47 3.34 7" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
    </svg>

    Create New Curriculum
</a>

                        
                        <div class=''>
                            <table class='w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400'>
                                <thead class="rounded text-sm text-white uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th class="bg-blue5 rounded-tl-lg px-6 py-3"> Code </th>
                                        <th class="bg-blue5 px-6 py-3"> Effectivity </th>
                                        <th class="bg-blue5 px-6 py-3"> Department </th>
                                        <th class="bg-blue5 px-6 py-3"> </th>
                                        <th class="bg-blue5 px-6 py-3"> </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-[#e5e7eb] bg-white">
                                    @foreach ($curricula as $curriculum)
                                    <tr class="hover:bg-gray4 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4 font-bold">
                                            <div class="flex items-center space-x-3">
                                                <div>
                                                    <p> {{ $curriculum->curr_code }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class=""> {{ $curriculum->effectivity }}</p>
                                        </td>

                                        <td class="px-6 py-2 font-bold text-left"> <span class="">{{ $curriculum->department_code }}</span> </td>
                                        <td class="px-6 py-2 text-center">
                                           <form action="{{ route('admin.editCurr', $curriculum->curr_id) }}" method="GET">
                                                @csrf
                                                <button type="submit" class="text-green font-medium mt-5 hover:scale-105">
                                                    Edit
                                               </button>
                                            </form>
                                        </td>

                                        <td>
                                            <form action="{{ route('admin.destroyCurr',$curriculum->curr_id) }}" method="Post">
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
                                    <span class="text-gray-600 text-sm">Page {{ $curricula->currentPage() }} of {{ $curricula->lastPage() }}</span>
                                </div>
                                {{ $curricula->links() }}
                            </div>
                        </div>
                </div>
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