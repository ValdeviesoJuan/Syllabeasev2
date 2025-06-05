<div class="relative overflow-x-auto sm:rounded-lg">
    <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
        <select wire:model="filters.course_code" class="border cursor-pointer focus:outline-none focus:border-blue rounded-lg p-1 w-[14%]" placeholder="Year level">
            <option value="" class="">Course Code (All)</option>
            @foreach($courses as $course)
            <option value="{{$course->course_code}}">{{$course->course_code}}-{{$course->course_title}}</option>
            @endforeach
        </select>
        <select wire:model="filters.bg_school_year" class="mx-1 border focus:outline-none focus:border-blue cursor-pointer rounded-lg p-1 w-[14%]" placeholder="School Year">
            <option value="">School Year (All)</option>
            <option value="2023-2024">2023-2024</option>
            <option value="2024-2025">2024-2025</option>
            <option value="2025-2026">2025-2026</option>
            <option value="2026-2027">2026-2027</option>
            <option value="2027-2028">2027-2028</option>
            <option value="2028-2029">2028-2029</option>
            <option value="2029-2030">2029-2030</option>
        </select>
        <select wire:model="filters.course_semester" class="mx-1 border focus:outline-none focus:border-blue cursor-pointer rounded-lg p-1 w-[10%]" placeholder="Semester">
            <option value="">Semester (All)</option>
            <option value="1st Semester">1st Semester</option>
            <option value="2nd Semester">2nd Semester</option>
            <option value="Mid Year">Mid Year</option>
        </select>
        <select wire:model="filters.leader_user_id" class="mx-1 border cursor-pointer focus:outline-none focus:border-blue rounded-lg p-1 w-[10%]" placeholder="Year level">
            <option value="" class="">Leader (All)</option>
            @foreach($users as $user)
            <option value="{{$user->id}}">{{$user->lastname}}, {{$user->firstname}}</option>
            @endforeach
        </select>
        <select wire:model="filters.member_user_id" class="mx-1 border cursor-pointer focus:outline-none focus:border-blue rounded-lg p-1 w-[10%]" placeholder="Year level">
            <option value="" class="">Member (All)</option>
            @foreach($users as $user)
            <option value="{{$user->id}}">{{$user->lastname}}, {{$user->firstname}}</option>
            @endforeach
        </select>
        <button wire:click="applyFilters" class="bg-blue5 focus:outline-none focus:border-blue cursor-pointer rounded-lg text-white p-[4px] px-4">Apply Filters</button>
        <label for="table-search" class="sr-only">Search</label>
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
                    Leader/s
                </th>
                <th scope="col" class="bg-blue5 px-6 py-3">
                    Member/s
                </th>
                <th scope="col" class="bg-blue5 rounded-tr-lg px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bgroups as $bgroup)
            <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-white' : 'bg-[#e9edf7]' }} bg-white border- dark:bg-gray-800 dark:border-gray-700 hover:bg-gray4 dark:hover:bg-gray-600">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $bgroup->course_code }}
                </td>
                <td class="px-6 py-4">
                    {{ $bgroup->course_title }}
                </td>
                <td class="px-6 py-4">
                    {{ $bgroup->bg_school_year }}
                </td>
                <td class="px-6 py-4">
                    {{$bgroup->course_semester}}
                </td>
                <td class="px-6 py-4">
                    @foreach ($bleaders[$bgroup->bg_id] ?? [] as $leader)
                    <p>{{ $leader->lastname }}, {{ $leader->firstname }}</p>
                    @endforeach
                </td>
                <td class="px-6 py-4">
                    @foreach ($bmembers[$bgroup->bg_id] ?? [] as $member)
                    <p>{{ $member->lastname }}, {{ $member->firstname }}</p>
                    @endforeach
                </td>
                <td class="px-6 py-4 flex">
                    <form action="{{ route('chairperson.editBTeam', $bgroup->bg_id) }}" method="GET">
                        @csrf
                        <button type="submit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1">
                            Edit
                        </button>
                    </form>
                    <form action="{{ route('chairperson.destroyBTeam',$bgroup->bg_id) }}" method="Post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $bgroups->links() }}
</div>