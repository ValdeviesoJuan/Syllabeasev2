<div>
    <div class="flex justify-between mb-4 flex-wrap gap-2">
        <!-- 🔍 Search Input (Now First) -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-5 h-5 text-blue-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <input type="text" wire:model.live="search" id="table-search"
                class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Search...">
        </div>

        <select wire:model="filters.course_year_level"
            class="border cursor-pointer focus:outline-none focus:border-blue rounded-lg p-1 w-[17%]"
            placeholder="Year level">
            <option value="" class="">Year level (All)</option>
            <option value="1st Year">1st Year</option>
            <option value="2nd Year">2nd Year</option>
            <option value="3rd Year">3rd Year</option>
            <option value="4th Year">4th Year</option>
            <option value="5th Year">5th Year</option>
        </select>

        <select wire:model="filters.course_semester"
            class="border focus:outline-none focus:border-blue cursor-pointer rounded-lg p-1 w-[17%]"
            placeholder="Semester">
            <option value="">Semester (All)</option>
            <option value="1st Semester">1st Semester</option>
            <option value="2nd Semester">2nd Semester</option>
            <option value="Mid Year">Mid Year</option>
        </select>

        <select wire:model="filters.curr_code"
            class="border focus:outline-none focus:border-blue cursor-pointer rounded-lg p-1 w-[17%]"
            placeholder="Semester">
            <option value="">Curriculum (All)</option>
            @foreach($curricula as $curr)
                <option value="{{$curr->curr_code}}">{{$curr->curr_code}}</option>
            @endforeach
        </select>

        <button wire:click="applyFilters"
            class="bg-blue5 focus:outline-none focus:border-blue cursor-pointer rounded-lg text-white p-[4px] px-4">
            Apply Filters
        </button>
    </div>

    <div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="rounded text-xs text-white uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="bg-blue5 rounded-tl-lg px-6 py-3">Course Code</th>
                    <th scope="col" class="bg-blue5 px-6 py-3">Course Title</th>
                    <th scope="col" class="bg-blue5 px-6 py-3">Curr</th>
                    <th scope="col" class="bg-blue5 px-6 py-3">Year level</th>
                    <th scope="col" class="bg-blue5 px-6 py-3">Semester</th>
                    <th scope="col" class="bg-blue5 rounded-tr-lg px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                    <tr
                        class="{{ $loop->iteration % 2 == 0 ? 'bg-white' : 'bg-[#e9edf7]' }} bg-white border- dark:bg-gray-800 dark:border-gray-700 hover:bg-gray4 dark:hover:bg-gray-600">
                        <td scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $course->course_code }}
                        </td>
                        <td class="px-6 py-4">{{ $course->course_title }}</td>
                        <td class="px-6 py-4">{{ $course->curr_code }}</td>
                        <td class="px-6 py-4">{{ $course->course_year_level }}</td>
                        <td class="px-6 py-4">{{ $course->course_semester }}</td>
                        <td class="px-6 py-4 flex">
                            <form action="{{ route('chairperson.viewCourse', $course->course_id) }}" method="GET">
                                @csrf
                                <button type="submit" class="hover:text-yellow hover:underlined px-1 ">View</button>
                            </form>
                            <form action="{{ route('chairperson.editCourse', $course->course_id) }}" method="GET">
                                @csrf
                                <button type="submit" class="hover:text-yellow hover:underlined px-1 text-green">Edit</button>
                            </form>
                            <form action="{{ route('chairperson.destroyCourse', $course->course_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="hover:text-yellow hover:underlined px-1 text-red">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $courses->links() }}
    </div>
</div>
