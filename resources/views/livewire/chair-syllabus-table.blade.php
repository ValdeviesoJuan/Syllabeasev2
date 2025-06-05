<div class=" text-left">
    <div class="flex justify-between mb-4">
        <select wire:model="filters.course_year_level" class="border cursor-pointer focus:outline-none focus:border-blue rounded-lg p-1 w-[15%] ml-" placeholder="Year level">
            <option value="" class="">Year level (All)</option>
            <option value="1st Year">1st Year</option>
            <option value="2nd Year">2nd Year</option>
            <option value="3rd Year">3rd Year</option>
            <option value="4th Year">4th Year</option>
            <option value="5th Year">5th Year</option>
        </select>
        <select wire:model="filters.course_semester" class="border focus:outline-none focus:border-blue cursor-pointer rounded-lg p-1 w-[15%] ml-" placeholder="Semester">
            <option value="">Semester (All)</option>
            <option value="1st Semester">1st Semester</option>
            <option value="2nd Semester">2nd Semester</option>
            <option value="Mid Year">Mid Year</option>
        </select>
        <select wire:model="filters.bg_school_year" class="border focus:outline-none focus:border-blue cursor-pointer rounded-lg p-1 w-[15%] ml-" placeholder="School Year">
            <option value="">School Year (All)</option>
            <option value="2023-2024">2023-2024</option>
            <option value="2024-2025">2024-2025</option>
            <option value="2025-2026">2025-2026</option>
            <option value="2026-2027">2026-2027</option>
            <option value="2027-2028">2027-2028</option>
            <option value="2028-2029">2028-2029</option>
            <option value="2029-2030">2029-2030</option>
        </select>

        <select wire:model="filters.status" class="border focus:outline-none focus:border-blue cursor-pointer rounded-lg p-1 w-[14%] ml-" placeholder="Semester">
            <option value="">Status (All)</option>
            <option value="Pending">Pending</option>
            <option value="Approved by Chair">Approved by Chair</option>
            <option value="Returned by Chair">Returned by Chair</option>
            <option value="Approved by Dean">Approved by Dean</option>
            <option value="Returned by Dean">Returned by Dean</option>
        </select>
        <button wire:click="applyFilters" class="bg-blue5 focus:outline-none focus:border-blue cursor-pointer rounded-lg text-white p-[4px] px-4">Apply Filters</button>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <input type="text" wire:model.live="search" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search...">
        </div>
    </div>
    <table class=" w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="rounded text-xs text-white uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="bg-blue5 rounded-tl-lg px-6 py-3">
                    Course Code
                </th>
                <th scope="col" class="bg-blue5 px-6 py-3">
                    Course Title
                </th>
                <th scope="col" class="bg-blue5 px-6 py-3">
                    School Year
                </th>
                <th scope="col" class="bg-blue5 px-6 py-3">
                    Semester
                </th>
                <th scope="col" class="bg-blue5 px-6 py-3">
                    Submitted At
                </th>
                <th scope="col" class="bg-blue5 px-6 py-3">
                    Version
                </th>
                <th scope="col" class="bg-blue5 px-6 py-3">
                    Status
                </th>
                <th scope="col" class="bg-blue5 rounded-tr-lg px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($syllabi as $syllabus)
            <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-white' : 'bg-[#e9edf7]' }} bg-white border- dark:bg-gray-800 dark:border-gray-700 hover:bg-gray4 dark:hover:bg-gray-600">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $syllabus->course_code }}
                </td>
                <td class="px-6 py-4">
                    {{ $syllabus->course_title }}
                </td>
                <td class="px-6 py-4">
                    {{ $syllabus->bg_school_year }}
                </td>
                <td class="px-6 py-4">
                    {{$syllabus->course_semester}}
                </td>
                <td class="px-6 py-4">
                    {{$syllabus->chair_submitted_at}}
                </td>
                <td class="px-6 py-4">
                    Version {{$syllabus->version}}
                </td>
                <td class="px-6 py-4">
                    <button class="
                    {{ $syllabus->status === 'Pending' ? 'w-[80%] bg-amber-100 text-amber-500 border-2 border-amber-300 rounded-lg' : '' }}
                    {{ $syllabus->status === 'Approved by Chair' ? 'w-[80%]  bg-emerald-200 text-emerald-600 border-2 border-emerald-400 rounded-lg' : '' }}
                    {{ $syllabus->status === 'Returned by Chair' ? 'w-[80%] bg-rose-300 text-rose-600 border-2 border-rose-500 rounded-lg' : ' ' }}
                    {{ $syllabus->status === 'Approved by Dean' ? 'w-[80%]  bg-emerald-200 text-emerald-600 border-2 border-emerald-400 rounded-lg' : '' }}
                    {{ $syllabus->status === 'Returned by Dean' ? 'w-[80%] bg-rose-300 text-rose-600 border-2 border-rose-500 rounded-lg' : ' ' }}">
                        {{$syllabus->status}}
                    </button>
                </td>
                <td class="px-6 py-4 flex">
                    <form class="" action="{{ route('chairperson.viewSyllabus', $syllabus->syll_id) }}" method="GET">
                        @csrf
                        <div class="p-4">
                            <button class="hover:text-yellow hover:underline" type="submit">View</button>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $syllabi->links() }}

</div>