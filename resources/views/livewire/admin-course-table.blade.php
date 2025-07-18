<div class="mx-auto sm:p-2 text-gray-100 m-10 bg-gray-100 mt-2">
    <div class="flex flex-wrap justify-between gap-2 mb-4 items-center">

        <!-- Search Bar First -->
        <div class="relative w-[30%] min-w-[250px]">
            <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-5 h-5 text-blue-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <input type="text" wire:model.live="search" id="table-search"
                class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Search...">
        </div>

        <!-- Year Level Dropdown -->
        <select wire:model="filters.course_year_level"
            class="border cursor-pointer focus:outline-none focus:border-blue rounded-lg  w-[17%] text-sm"
            placeholder="Year level">
            <option value="">Year level (All)</option>
            <option value="1st Year">1st Year</option>
            <option value="2nd Year">2nd Year</option>
            <option value="3rd Year">3rd Year</option>
            <option value="4th Year">4th Year</option>
            <option value="5th Year">5th Year</option>
        </select>

        <!-- Semester Dropdown -->
        <select wire:model="filters.course_semester"
            class="border focus:outline-none focus:border-blue cursor-pointer rounded-lg  w-[17%] text-sm"
            placeholder="Semester">
            <option value="">Semester (All)</option>
            <option value="1st Semester">1st Semester</option>
            <option value="2nd Semester">2nd Semester</option>
            <option value="Mid Year">Mid Year</option>
        </select>

        <!-- Curriculum Dropdown -->
        <select wire:model="filters.curr_code"
            class="border focus:outline-none focus:border-blue cursor-pointer rounded-lg w-[17%] text-sm"
            placeholder="Curriculum">
            <option value="">Curriculum (All)</option>
            <option value=""></option>
        </select>

        <!-- Apply Button -->
        <button wire:click="applyFilters"
            class="bg-blue5 hover:bg-blue-600 focus:outline-none focus:border-blue cursor-pointer rounded-lg text-white p-[10px] px-4 text-sm">
            Apply Filters
        </button>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
                    <table class=' w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400'>
                        <thead class="rounded text-sm text-white uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr class="bg-blue text-sm text-white">
                                <th class="bg-blue5 rounded-tl-lg px-6 py-3"> Code </th>
                                <th class="bg-blue5 px-6 py-3"> Title  </th>
                                <th class="bg-blue5 px-6 py-3"> Curriculum  </th>
                                <th class="bg-blue5 px-8 py-3"> Year Level  </th>
                                <th class="bg-blue5 px-8 py-3"> Semester  </th>
                                <th class="bg-blue5 px-6 py-3"> Pre Req  </th>
                                <th class="bg-blue5 px-6 py-3"> Co Req  </th>
                                <th class="bg-blue5 px-6 py-3"> Lec Unit  </th>
                                <th class="bg-blue5 px-6 py-3"> Lab Unit  </th>
                                <th class="bg-blue5 px-6 py-3"> Credit Unit  </th>
                                <th class="bg-blue5 px-6 py-3"> Lec Hours  </th>
                                <th class="bg-blue5 px-6 py-3"> Lab Hours  </th>
                                <th class="bg-blue5 px-6 py-3"> </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e5e7eb] bg-white ">
                            @foreach ($courses as $course)
                                <tr  class="hover:bg-gray4 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 font-bold">
                                        <div class="flex items-center space-x-3">
                                            <div>
                                                <p>{{ $course->course_code }}</p>
                                            </div>
                                        </div>
                                    </td>
        
                                    <td class="px-6 py-4">
                                        <p class="">{{ $course->course_title }}</p>
                                    </td>

                                    <td class="px-6 py-4">
                                        <p class="">{{ $course->curr_code }}</p>
                                    </td>
        
                                    <td class="px-6 py-4">
                                        <p class="">{{ $course->course_year_level }}</p>
                                    </td>
        
                                    <td class="px-6 py-4">
                                        <p class="">{{ $course->course_semester }}</p>
                                    </td>
        
                                    <td class="px-6 py-4">
                                        <p class="">{{ $course->course_pre_req }}</p>
                                    </td>
        
                                    <td class="px-6 py-4">
                                        <p class="">{{ $course->course_co_req }}</p>
                                    </td>

                                    <td class="px-4 py-2">
                                        <p class="text-center">{{ $course->course_unit_lec }}</p>
                                    </td>
        
                                    <td class="px-4 py-2">
                                        <p class="text-center">{{ $course->course_unit_lab }}</p>
                                    </td>
        
                                    <td class="px-4 py-2">
                                        <p class="text-center">{{ $course->course_credit_unit }}</p>
                                    </td>
        
                                    <td class="px-4 py-2">
                                        <p class="text-center">{{ $course->course_hrs_lec }}</p>
                                    </td>
        
                                    <td class="px-4 py-2">
                                        <p class="text-center">{{ $course->course_hrs_lab}}</p>
                                    </td>

                                    <td class="px-4 py-2 flex">
                                        <form action="{{ route('admin.editCourse', $course->course_id) }}" method="GET">
                                            @csrf
                                            <button type="submit" class="text-green font-medium mt-5 pr-2 ">
                                                Edit
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.destroyCourse',$course->course_id) }}" method="Post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red font-medium mt-5 pl-2 ">
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
                    <span class="text-gray-600 text-sm">Page {{ $courses->currentPage() }} of {{ $courses->lastPage() }}</span>
                    </div>
        
                    <div class="mb-9">
                        {{ $courses->links() }} 
                    </div>
                </div>

</div>