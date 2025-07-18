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

    <div>
        <table class='w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400'>
            <thead class="rounded text-sm text-white uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="bg-blue5 rounded-tl-lg px-6 py-3">Department Code</th>
                    <th class="bg-blue5 px-6 py-3">Department Name</th>
                    <th class="bg-blue5 px-6 py-3">Program Code</th>
                    <th class="bg-blue5 px-6 py-3">Program Name</th>
                    <th class="bg-blue5 px-8 py-3">Status</th>
                    <th class="bg-blue5 px-6 py-3 rounded-tr-lg text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-[#e5e7eb] bg-white">
                @foreach ($departments as $department)
                <tr class="hover:bg-gray4 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-bold">
                        <div class="flex items-center space-x-3">
                            <p> {{ $department->department_code }}</p>
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        <p> {{ $department->department_name }}</p>
                    </td>

                    <td class="px-6 py-4 font-bold">
                        <div class="flex items-center space-x-3">
                            <p> {{ $department->program_code }}</p>
                        </div>
                    </td>
                                        
                    <td class="px-6 py-4">
                        <p> {{ $department->program_name }}</p>
                    </td>

                    <td class="px-6 py-4">
                        <span class="dot" style="color: {{ $department->department_status === 'Active' ? 'rgb(8, 230, 8)' : 'rgb(255, 35, 35)' }}; font-size: 25px;">&bull;</span>
                        {{ $department->department_status }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        <div class="relative inline-block text-left">
                            <button id="dropdownButton-{{ $department->department_id }}" type="button"
                                class="flex items-center justify-center rounded-md p-2 bg-white text-sm text-gray-700 hover:bg-gray-50 focus:outline-none">
                                <svg class="h-5 w-5 text-blue" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div id="dropdownMenu-{{ $department->department_id }}" class="origin-top-right absolute right-0 mt-2 w-44 rounded-md shadow-lg bg-white ring-1 ring-blue ring-opacity-5 hidden z-10">
                                <div class="py-1 space-y-1">
                                    <a href="{{ route('admin.editDepartment', $department->department_id) }}"
                                       class="block w-full text-left px-4 py-2 text-sm text-green hover:bg-gray5">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.destroyDepartment', $department->department_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this department?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="block w-full text-left px-4 py-2 text-sm text-red hover:bg-gray5">
                                            Delete
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.viewPoe', $department->department_id) }}"
                                       class="block w-full text-left px-4 py-2 text-sm text-blue hover:bg-gray5 cursor-default">
                                        View POE
                                    </a>

                                    <a href="{{ route('admin.viewPo', $department->department_id) }}"
                                       class="block w-full text-left px-4 py-2 text-sm text-blue hover:bg-gray5 cursor-default">
                                        View PO
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>
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

<script>
    document.addEventListener('click', function (e) {
        const clickedButton = e.target.closest('[id^="dropdownButton-"]');

        // If a dropdown button was clicked
        if (clickedButton) {
            e.preventDefault();
            e.stopPropagation();

            const id = clickedButton.id.replace('dropdownButton-', '');
            const clickedMenu = document.getElementById(`dropdownMenu-${id}`);

            // Toggle clicked menu
            if (clickedMenu) {
                const isHidden = clickedMenu.classList.contains('hidden');

                // Close all dropdowns first
                document.querySelectorAll('[id^="dropdownMenu-"]').forEach(menu => {
                    menu.classList.add('hidden');
                });

                // Then re-show only if it was previously hidden
                if (isHidden) {
                    clickedMenu.classList.remove('hidden');
                }
            }

            return;
        }

        // If clicked anywhere else, close all dropdowns
        document.querySelectorAll('[id^="dropdownMenu-"]').forEach(menu => {
            menu.classList.add('hidden');
        });
    });
</script>
