<div class=" text-left">
    <div class="flex flex-wrap items-center gap-3 mb-4">
        <div class="relative w-[18%]">
            <input
                wire:model.live="search"
                wire:keydown.enter="applyFilters"
                type="text"
                class="border focus:outline-none focus:border-blue border-black w-full rounded p-1 pr-10"
                placeholder="Search..."
            >
            <button
                type="button"
                wire:click="applyFilters"
                class="absolute inset-y-0 right-0 flex items-center px-2"
                tabindex="-1"
            >
                <svg width="24px" class="rounded-lg p-[2px]" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z" stroke="#2468d2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
        <select wire:model="filters.course_year_level" class="border cursor-pointer focus:outline-none focus:border-blue rounded p-1 w-[15%]" placeholder="Year level">
            <option value="" class="">Year level (All)</option>
            <option value="1st Year">1st Year</option>
            <option value="2nd Year">2nd Year</option>
            <option value="3rd Year">3rd Year</option>
            <option value="4th Year">4th Year</option>
            <option value="5th Year">5th Year</option>
        </select>
        <select wire:model="filters.course_semester" class="border focus:outline-none focus:border-blue cursor-pointer rounded p-1 w-[15%]" placeholder="Semester">
            <option value="">Semester (All)</option>
            <option value="1st Semester">1st Semester</option>
            <option value="2nd Semester">2nd Semester</option>
            <option value="Mid Year">Mid Year</option>
        </select>
        <select wire:model="filters.bg_school_year" class="border focus:outline-none focus:border-blue cursor-pointer rounded p-1 w-[17%]" placeholder="School Year">
            <option value="">School Year (All)</option>
            <option value="2023-2024">2023-2024</option>
            <option value="2024-2025">2024-2025</option>
            <option value="2025-2026">2025-2026</option>
            <option value="2026-2027">2026-2027</option>
            <option value="2027-2028">2027-2028</option>
            <option value="2028-2029">2028-2029</option>
            <option value="2029-2030">2029-2030</option>
        </select>
        <select wire:model="filters.tos_status" class="border focus:outline-none focus:border-blue cursor-pointer rounded p-1 w-[14%]" placeholder="Status">
            <option value="">Status (All)</option>
            <option value="Pending">Pending</option>
            <option value="Approved by Chair">Approved by Chair</option>
            <option value="Returned by Chair">Returned by Chair</option>
        </select>
        <button wire:click="applyFilters" class="bg-blue5 hover:bg-blue focus:outline-none focus:border-blue cursor-pointer rounded text-white p-[4px] px-4">Apply Filters</button>
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
            @foreach ($toss as $tos)
            <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-white' : 'bg-[#e9edf7]' }} bg-white border- dark:bg-gray-800 dark:border-gray-700 hover:bg-gray4 dark:hover:bg-gray-600">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $tos->course_code }}
                </td>
                <td class="px-6 py-4">
                    {{ $tos->course_title }}
                </td>
                <td class="px-6 py-4">
                    {{ $tos->bg_school_year }}
                </td>
                <td class="px-6 py-4">
                    {{$tos->course_semester}}
                </td>
                <td class="px-6 py-4">
                    {{$tos->chair_submitted_at}}
                </td>
                <td class="px-6 py-4">
                    Version {{$tos->tos_version}}
                </td>
                <td class="px-6 py-4">
                    <button class="
                    {{ $tos->tos_status === 'Pending' ? 'w-[100%] bg-amber-100 text-amber-500 border-2 border-amber-300 rounded-lg' : '' }}
                    {{ $tos->tos_status === 'Approved by Chair' ? 'w-[100%]  bg-emerald-200 text-emerald-600 border-2 border-emerald-400 rounded-lg' : '' }}
                    {{ $tos->tos_status === 'Returned by Chair' ? 'w-[100%] bg-rose-300 text-rose-600 border-2 border-rose-500 rounded-lg' : ' ' }}
                    {{ $tos->tos_status === 'Approved by Dean' ? 'w-[100%]  bg-emerald-200 text-emerald-600 border-2 border-emerald-400 rounded-lg' : '' }}
                    {{ $tos->tos_status === 'Returned by Dean' ? 'w-[100%] bg-rose-300 text-rose-600 border-2 border-rose-500 rounded-lg' : ' ' }}">
                        {{$tos->tos_status}}
                    </button>
                </td>
                <td class="px-6 py-4 flex">
                    <form class="" action="{{ route('chairperson.viewTos', $tos->tos_id) }}" method="GET">
                        @csrf
                        <div class="mt-6">
                            <button class="hover:text-yellow hover:undelined" type="submit">View</button>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $toss->links() }}
</div>