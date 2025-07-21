<div class="relative overflow-x-auto sm:rounded-lg">
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
        <select wire:model="filters.course_code" class="border cursor-pointer focus:outline-none focus:border-blue rounded p-1 w-[16%]" placeholder="Course Code">
            <option value="" class="">Course Code (All)</option>
            @foreach($courses as $course)
            <option value="{{$course->course_code}}">{{$course->course_code}}-{{$course->course_title}}</option>
            @endforeach
        </select>
        <select wire:model="filters.bg_school_year" class="border focus:outline-none focus:border-blue cursor-pointer rounded p-1 w-[9%]" placeholder="School Year">
            <option value="">SY (All)</option>
            <option value="2023-2024">2023-2024</option>
            <option value="2024-2025">2024-2025</option>
            <option value="2025-2026">2025-2026</option>
            <option value="2026-2027">2026-2027</option>
            <option value="2027-2028">2027-2028</option>
            <option value="2028-2029">2028-2029</option>
            <option value="2029-2030">2029-2030</option>
        </select>
        <select wire:model="filters.course_semester" class="border focus:outline-none focus:border-blue cursor-pointer rounded p-1 w-[14%]" placeholder="Semester">
            <option value="">Semester(All)</option>
            <option value="1st Semester">1st Semester</option>
            <option value="2nd Semester">2nd Semester</option>
            <option value="Mid Year">Mid Year</option>
        </select>
        <select wire:model="filters.leader_user_id" class="border cursor-pointer focus:outline-none focus:border-blue rounded p-1 w-[11%]" placeholder="Leader">
            <option value="" class="">Leader(All)</option>
            @foreach($users as $user)
            <option value="{{$user->id}}">{{$user->lastname}}, {{$user->firstname}}</option>
            @endforeach
        </select>
        <select wire:model="filters.member_user_id" class="border cursor-pointer focus:outline-none focus:border-blue rounded p-1 w-[13%]" placeholder="Member">
            <option value="" class="">Member(All)</option>
            @foreach($users as $user)
            <option value="{{$user->id}}">{{$user->lastname}}, {{$user->firstname}}</option>
            @endforeach
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
                    @forelse ($bleaders[$bgroup->bg_id] ?? [] as $leader)
                    <p>{{ $leader->lastname }}, {{ $leader->firstname }}</p>
                    @empty
                    @endforelse
                </td>
                <td class="px-6 py-4">
                    @forelse ($bmembers[$bgroup->bg_id] ?? [] as $member)
                    <p>{{ $member->lastname }}, {{ $member->firstname }}</p>
                    @empty
                    @endforelse
                </td>
                <td class="px-6 py-4 flex">
                    <form action="{{ route('chairperson.editBTeam', $bgroup->bg_id) }}" method="GET">
                        @csrf
                        <button type="submit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1 text-green">
                            Edit
                        </button>
                    </form>
                    <form action="{{ route('chairperson.destroyBTeam',$bgroup->bg_id) }}" method="Post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1 text-red">
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