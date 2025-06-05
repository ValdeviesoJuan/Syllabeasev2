<div class=" mx-auto sm:p-2 text-gray-100 m-10 bg-gray-100 mt-4">
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
                                    <th class="bg-blue5 rounded-tl-lg px-6 py-3"> Code </th>
                                    <th class="bg-blue5 px-6 py-3">Name </th>
                                    <th class="bg-blue5 px-6 py-3"> Start Validity </th>
                                    <th class="bg-blue5 px-6 py-3"> End Validity </th>
                                    <th class="bg-blue5 px-6 py-3"> </th>
                                    <th class="bg-blue5 px-6 py-3"> </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-[#e5e7eb] bg-white">
                                    @foreach ($chairs as $chair)
                                    <tr class="hover:bg-gray4 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4 font-bold">{{ $chair->department_code }}</td>
                                        <td class="px-6 py-4">{{ $chair->lastname }}, {{ $chair->firstname }}</td>
                                        <td class="px-6 py-4">{{ $chair->start_validity }}</td>
                                        <td class="px-6 py-4">{{ $chair->end_validity }}</td>
                                        <td>
                                            <form action="{{ route('admin.editChair', $chair->chairman_id) }}" method="GET">
                                                @csrf
                                                <button type="submit" class="text-green font-medium mt-5 hover:scale-105">
                                                   Edit
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.destroyChair',$chair->chairman_id) }}" method="Post">
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
              
                <div class="mt-5 mb-6">
                        <div class="flex justify-center">
                            <span class="text-gray-600 text-sm">Page {{ $chairs->currentPage() }} of {{ $chairs->lastPage() }}</span>
                        </div>
                        {{ $chairs->links() }}
                        </div>
      
          
        </div>
    </div>
</div>