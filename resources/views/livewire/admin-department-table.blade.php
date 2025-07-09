<div class="mx-auto sm:p-2 text-gray-100 m-10 bg-gray-100 mt-4">
    <div class="flex justify-between mb-4">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <input type="text" wire:model.live="search" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search...">
        </div>
    </div>

    <div class="">
        <table class=' w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400'>
            <thead class="rounded text-sm text-white uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="bg-blue5 rounded-tl-lg px-6 py-3"> Department Code </th>
                    <th class="bg-blue5 px-6 py-3"> Department Name </th>
                    <th class="bg-blue5 px-6 py-3"> Program Code </th>
                    <th class="bg-blue5 px-6 py-3"> Program Name </th>
                    <th class="bg-blue5 px-8 py-3"> Status </th>
                    <th class="bg-blue5 px-6 py-3"> </th>
                    <th class="bg-blue5 px-6 py-3"> </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-[#e5e7eb] bg-white">
                @foreach ($departments as $department)
                <tr class="hover:bg-gray4 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-bold">
                        <div class="flex items-center space-x-3">
                            <div>
                                <p> {{ $department->department_code }}</p>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        <p class=""> {{ $department->department_name }}</p>
                    </td>

                    <td class="px-6 py-4 font-bold">
                        <div class="flex items-center space-x-3">
                            <div>
                                <p> {{ $department->program_code }}</p>
                            </div>
                        </div>
                    </td>
                                        
                    <td class="px-6">
                        <p class=""> {{ $department->program_name }}</p>
                    </td>

                    <td class="px-6 py-4">
                        @if($department->department_status === 'Active')
                            <span class="dot" style="color: {{ $department->department_status === 'Active' ? 'rgb(8, 230, 8)' : 'rgb(255, 35, 35)' }}; font-size: 25px;">&bull;</span>                                        
                        @else
                            <span class="dot" style="color: rgb(255, 35, 35); font-size: 25px;">&bull;</span>
                        @endif
                            {{ $department->department_status }}
                    </td>
                    <div class="m-auto mt-2">
                        <td class="text-center">
                            <form action="{{ route('admin.editDepartment', $department->department_id) }}" method="GET">
                                @csrf
                                <button type="submit" class="text-green font-medium hover:scale-105 mt-5">
                                    Edit 
                                </button>
                            </form>
                        </td>

                        <td>
                            <form action="{{ route('admin.destroyDepartment',$department->department_id) }}" method="Post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red font-medium hover:scale-105 mt-5"> 
                                    Delete
                                </button>
                            </form>
                        </td>
                    </div>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-5 mb-6">
            <div class="flex justify-center">
                <span class="text-gray-600 text-sm">Page {{ $departments->currentPage() }} of {{ $departments->lastPage() }}</span>
            </div>
            {{ $departments->links() }} 
        </div>
    </div>
</div>